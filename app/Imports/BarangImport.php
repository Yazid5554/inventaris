<?php

namespace App\Imports;

use App\Models\Barang;
use App\Models\Lokasi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangImport implements ToCollection
{
    public array $errors = [];
    public int $successCount = 0;
    public int $skippedCount = 0;

    public function collection(Collection $rows)
    {
        // Step 1: Cari header row — scan tiap baris, cari yang mengandung "Nama Barang"
        $headerRowIndex = null;
        $columnMap = [];

        foreach ($rows as $index => $row) {
            $rowValues = $row->map(fn($v) => strtolower(trim((string) $v)))->toArray();

            // Cek apakah baris ini mengandung header yang kita kenal
            if (in_array('nama barang', $rowValues) || in_array('kode barang', $rowValues)) {
                $headerRowIndex = $index;

                // Map posisi kolom berdasarkan nama header
                foreach ($rowValues as $colIndex => $headerName) {
                    $columnMap[$headerName] = $colIndex;
                }
                break;
            }
        }

        // Kalau header tidak ditemukan, coba asumsi row 0 = title, row 1 = header
        if ($headerRowIndex === null) {
            // Fallback: asumsi kolom sesuai urutan spreadsheet client
            // No(0), Gedung(1), Lantai(2), Tahun(3), Ruangan(4), Kode Barang(5), Nama Barang(6), Nomor Inventaris(7), Barcode(8), Keterangan(9)
            $headerRowIndex = 1;
            $columnMap = [
                'gedung'      => 1,
                'lantai'      => 2,
                'tahun'       => 3,
                'ruangan'     => 4,
                'kode barang' => 5,
                'nama barang' => 6,
                'keterangan'  => 9,
            ];
        }

        // Resolve kolom index
        $colGedung      = $columnMap['gedung'] ?? null;
        $colLantai      = $columnMap['lantai'] ?? null;
        $colTahun       = $columnMap['tahun'] ?? $columnMap['tanggal pengadaan'] ?? $columnMap['tahun pengadaan'] ?? null;
        $colRuangan     = $columnMap['ruangan'] ?? null;
        $colKodeBarang  = $columnMap['kode barang'] ?? null;
        $colNamaBarang  = $columnMap['nama barang'] ?? null;
        $colJenisBarang = $columnMap['jenis barang'] ?? $columnMap['jenis'] ?? null;
        $colKeterangan  = $columnMap['keterangan'] ?? null;

        if ($colNamaBarang === null || $colKodeBarang === null) {
            $this->errors[] = 'Header "Nama Barang" atau "Kode Barang" tidak ditemukan di file Excel.';
            return;
        }

        // Kumpulkan kode_barang yang di-import untuk regenerate nomor inventaris nanti
        $kodesToRegenerate = [];

        // Step 2: Proses data setelah header row
        foreach ($rows as $index => $row) {
            // Skip semua baris sampai setelah header
            if ($index <= $headerRowIndex) continue;

            // Nomor baris di Excel (1-indexed, +1 karena Excel mulai dari 1)
            $excelRow = $index + 1;

            // Ambil data dari kolom
            $gedung      = trim((string) ($row[$colGedung] ?? ''));
            $lantai      = trim((string) ($row[$colLantai] ?? ''));
            $tahun       = trim((string) ($row[$colTahun] ?? ''));
            $ruangan     = trim((string) ($row[$colRuangan] ?? ''));
            $kodeBarang  = trim((string) ($row[$colKodeBarang] ?? ''));
            $namaBarang  = trim((string) ($row[$colNamaBarang] ?? ''));
            $jenisBarang = $colJenisBarang !== null ? trim((string) ($row[$colJenisBarang] ?? '')) : '';
            $keterangan  = $colKeterangan !== null ? trim((string) ($row[$colKeterangan] ?? '')) : '';

            // Bersihkan string '-'
            if ($gedung === '-') $gedung = '';
            if ($lantai === '-') $lantai = '';
            if ($ruangan === '-') $ruangan = '';
            if ($jenisBarang === '-' || empty($jenisBarang)) $jenisBarang = 'Umum';
            if ($keterangan === '-') $keterangan = '';

            // Extract 4-digit tahun pengadaan
            $tahunVal = (int) date('Y');
            if (!empty($tahun) && $tahun !== '-') {
                preg_match('/\b(19|20)\d{2}\b/', $tahun, $matches);
                if (!empty($matches[0])) {
                    $tahunVal = (int) $matches[0];
                }
            }

            // Skip baris kosong
            if (empty($namaBarang) && empty($kodeBarang)) {
                $this->skippedCount++;
                continue;
            }

            // Validasi field wajib
            $rowErrors = [];
            if (empty($namaBarang)) {
                $rowErrors[] = 'Nama Barang wajib diisi';
            }
            if (empty($kodeBarang)) {
                $rowErrors[] = 'Kode Barang wajib diisi';
            }

            if (!empty($rowErrors)) {
                $this->errors[] = "Baris {$excelRow}: " . implode(', ', $rowErrors);
                continue;
            }

            // Cari atau buat Lokasi berdasarkan gedung + lantai + nama ruangan
            $gedungVal  = strtolower($gedung ?: 'a');
            $lantaiVal  = $lantai ?: '01';
            $ruanganVal = $ruangan ?: 'Umum';

            $lokasi = Lokasi::firstOrCreate(
                [
                    'gedung' => $gedungVal,
                    'lantai' => $lantaiVal,
                    'nama'   => $ruanganVal,
                ],
                [
                    'jenis'      => 'ruangan',
                    'keterangan' => null,
                ]
            );
            $idLokasi = $lokasi->id;

            // Buat Barang
            $barang = Barang::create([
                'nama'             => $namaBarang,
                'kode_barang'      => strtoupper($kodeBarang),
                'jenis_barang'     => $jenisBarang,
                'tahun_pengadaan'  => $tahunVal,
                'id_lokasi'        => $idLokasi,
                'keterangan'       => !empty($keterangan) ? $keterangan : null,
            ]);

            // Generate QR Code
            try {
                $qrSvg  = QrCode::format('svg')->size(200)->errorCorrection('H')
                    ->generate(route('barang.show', $barang));
                $qrPath = 'qrcodes/' . $barang->id . '.svg';
                Storage::disk('public')->put($qrPath, $qrSvg);
                $barang->update(['qr_code' => $qrPath]);
            } catch (\Exception $e) {
                // QR gagal tapi barang tetap masuk
            }

            // Track kode untuk regenerate nomor inventaris
            $kodesToRegenerate[$barang->kode_barang] = true;
            $this->successCount++;
        }

        // Regenerate Nomor Inventaris per kode barang
        foreach (array_keys($kodesToRegenerate) as $kode) {
            $this->regenerateNomorInventarisByKode($kode);
        }
    }

    /**
     * Regenerate nomor inventaris — sama persis dengan logic di BarangController
     */
    private function regenerateNomorInventarisByKode(string $kode): void
    {
        $barangs = Barang::where('kode_barang', $kode)
            ->orderBy('id')
            ->get();

        $total = $barangs->count();

        foreach ($barangs as $index => $b) {
            $lokasi  = Lokasi::find($b->id_lokasi);
            $gedung  = strtoupper($lokasi?->gedung ?? 'X');
            $lantai  = $lokasi?->lantai ?? '00';
            $ruanganName = strtoupper($lokasi?->nama ?? 'X');
            $tahun   = $b->tahun_pengadaan ?? date('Y');
            $kodeB   = strtoupper($b->kode_barang ?? 'XX');

            $urutanStr = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            $totalStr  = str_pad($total, 3, '0', STR_PAD_LEFT);

            $b->update([
                'nomor_inventaris' => "{$gedung}-{$lantai}-{$tahun}-{$ruanganName}-{$kodeB}-{$urutanStr}/{$totalStr}"
            ]);
        }
    }
}
