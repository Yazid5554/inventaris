<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangController extends Controller
{
    // ============================================================
    // HELPER — Auto-generate Nomor Inventaris
    // Format: {gedung}-{lantai}-{tahun}-{ruangan}-{kode}-{urutan}/{total}
    // Contoh: A-01-2025-DAPUR-KL-001/001
    // ============================================================
    private function generateNomorInventaris(Barang $barang): string
    {
        $lokasi  = Lokasi::find($barang->id_lokasi);
        $gedung  = strtoupper($lokasi?->gedung  ?? 'X');
        $lantai  = $lokasi?->lantai  ?? '00';
        $ruangan = strtoupper($lokasi?->nama    ?? 'X');
        $tahun   = $barang->tahun_pengadaan ?? date('Y');
        $kode    = strtoupper($barang->kode_barang ?? 'XX');

        // Hitung semua barang dengan kode yang sama
        $total = Barang::where('kode_barang', $barang->kode_barang)->count();

        // Urutan barang ini di antara barang dengan kode sama
        $urutan = Barang::where('kode_barang', $barang->kode_barang)
            ->where('id', '<=', $barang->id)
            ->count();

        $totalStr  = str_pad($total,  3, '0', STR_PAD_LEFT);
        $urutanStr = str_pad($urutan, 3, '0', STR_PAD_LEFT);

        return "{$gedung}-{$lantai}-{$tahun}-{$ruangan}-{$kode}-{$urutanStr}/{$totalStr}";
    }

    // ============================================================
    // Update semua nomor inventaris barang dengan kode yang sama
    // Dipanggil setiap kali ada barang baru ditambah/dihapus
    // ============================================================
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
            $ruangan = strtoupper($lokasi?->nama   ?? 'X');
            $tahun   = $b->tahun_pengadaan ?? date('Y');
            $kodeB   = strtoupper($b->kode_barang ?? 'XX');

            $urutanStr = str_pad($index + 1, 3, '0', STR_PAD_LEFT);
            $totalStr  = str_pad($total,     3, '0', STR_PAD_LEFT);

            $b->update([
                'nomor_inventaris' => "{$gedung}-{$lantai}-{$tahun}-{$ruangan}-{$kodeB}-{$urutanStr}/{$totalStr}"
            ]);
        }
    }

    // ============================================================
    // INDEX
    // ============================================================
    public function index(Request $request)
    {
        $query = Barang::with(['lokasi', 'riwayatKondisi' => fn($q) => $q->latest()]);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_barang', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor_inventaris', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('id_lokasi')) {
            $query->where('id_lokasi', $request->id_lokasi);
        }

        if ($request->filled('kondisi')) {
            $kondisiReq = $request->kondisi;

            if ($kondisiReq === 'baik') {
                $query->where(function ($q) {
                    $q->whereDoesntHave('riwayatKondisi')
                      ->orWhereExists(function ($sub) {
                          $sub->selectRaw('1')
                              ->from('riwayat_kondisi')
                              ->whereRaw('riwayat_kondisi.id_barang = barang.id')
                              ->where('riwayat_kondisi.kondisi', 'baik')
                              ->whereRaw('riwayat_kondisi.id = (select max(id) from riwayat_kondisi where id_barang = barang.id)');
                      });
                });
            } elseif ($kondisiReq === 'rusak') {
                // Umbrella filter untuk semua barang rusak & afkir
                $query->whereExists(function ($sub) {
                    $sub->selectRaw('1')
                        ->from('riwayat_kondisi')
                        ->whereRaw('riwayat_kondisi.id_barang = barang.id')
                        ->whereIn('riwayat_kondisi.kondisi', ['rusak_ringan', 'rusak_berat', 'tidak_layak_pakai'])
                        ->whereRaw('riwayat_kondisi.id = (select max(id) from riwayat_kondisi where id_barang = barang.id)');
                });
            } elseif (in_array($kondisiReq, ['rusak_ringan', 'rusak_berat'])) {
                // Spesifik Rusak Ringan atau Rusak Berat
                $query->whereExists(function ($sub) use ($kondisiReq) {
                    $sub->selectRaw('1')
                        ->from('riwayat_kondisi')
                        ->whereRaw('riwayat_kondisi.id_barang = barang.id')
                        ->where('riwayat_kondisi.kondisi', $kondisiReq)
                        ->whereRaw('riwayat_kondisi.id = (select max(id) from riwayat_kondisi where id_barang = barang.id)');
                });
            } elseif (in_array($kondisiReq, ['dalam_perbaikan', 'perbaikan_aktif'])) {
                $query->whereExists(function ($sub) {
                    $sub->selectRaw('1')
                        ->from('riwayat_kondisi')
                        ->whereRaw('riwayat_kondisi.id_barang = barang.id')
                        ->where('riwayat_kondisi.kondisi', 'dalam_perbaikan')
                        ->whereRaw('riwayat_kondisi.id = (select max(id) from riwayat_kondisi where id_barang = barang.id)');
                });
            } elseif ($kondisiReq === 'tidak_layak_pakai') {
                $query->whereExists(function ($sub) {
                    $sub->selectRaw('1')
                        ->from('riwayat_kondisi')
                        ->whereRaw('riwayat_kondisi.id_barang = barang.id')
                        ->where('riwayat_kondisi.kondisi', 'tidak_layak_pakai')
                        ->whereRaw('riwayat_kondisi.id = (select max(id) from riwayat_kondisi where id_barang = barang.id)');
                });
            }
        }

        $barang  = $query->latest()->paginate(5)->withQueryString();
        $lokasis = Lokasi::orderBy('nama')->get();

        return view('barang.index', compact('barang', 'lokasis'));
    }

    // ============================================================
    // CREATE
    // ============================================================
    public function create()
    {
        $lokasis = Lokasi::orderBy('nama')->get();
        return view('barang.create', compact('lokasis'));
    }

    // ============================================================
    // STORE
    // ============================================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'kode_barang'       => 'required|string|max:50',
            'jenis_barang'      => 'nullable|string|max:100',
            'tanggal_pengadaan' => 'nullable|date',
            'id_lokasi'         => 'nullable|exists:lokasi,id',
            'keterangan'        => 'nullable|string',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        if (!empty($validated['tanggal_pengadaan'])) {
            $validated['tahun_pengadaan'] = \Carbon\Carbon::parse($validated['tanggal_pengadaan'])->year;
        }

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('barang', 'public');
        }

        // Simpan barang dulu tanpa nomor inventaris
        $barang = Barang::create($validated);

        // Generate QR code
        $qrSvg  = QrCode::format('svg')->size(200)->errorCorrection('H')
            ->generate(route('barang.show', $barang));
        $qrPath = 'qrcodes/' . $barang->id . '.svg';
        Storage::disk('public')->put($qrPath, $qrSvg);
        $barang->update(['qr_code' => $qrPath]);

        // Regenerate semua nomor inventaris dengan kode yang sama
        $this->regenerateNomorInventarisByKode($barang->kode_barang);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    // ============================================================
    // SHOW
    // ============================================================
    public function show(Barang $barang)
    {
        $barang->load([
            'lokasi',
            'komponen',
            'riwayatKondisi' => fn($q) => $q->with('pengguna')->latest()->take(20),
            'kerusakan'      => fn($q) => $q->with('pengguna')->latest(),
            'perbaikan'      => fn($q) => $q->with('pengguna')->latest(),
        ]);
        return view('barang.show', compact('barang'));
    }

    // ============================================================
    // EDIT
    // ============================================================
    public function edit(Barang $barang)
    {
        $lokasis = Lokasi::orderBy('nama')->get();
        return view('barang.edit', compact('barang', 'lokasis'));
    }

    // ============================================================
    // UPDATE
    // ============================================================
    public function update(Request $request, Barang $barang)
    {
        $kode_lama = $barang->kode_barang;

        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'kode_barang'       => 'required|string|max:50',
            'jenis_barang'      => 'nullable|string|max:100',
            'tanggal_pengadaan' => 'nullable|date',
            'id_lokasi'         => 'nullable|exists:lokasi,id',
            'keterangan'        => 'nullable|string',
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($barang->foto) Storage::disk('public')->delete($barang->foto);
            $validated['foto'] = $request->file('foto')->store('barang', 'public');
        }

        if (!empty($validated['tanggal_pengadaan'])) {
            $validated['tahun_pengadaan'] = \Carbon\Carbon::parse($validated['tanggal_pengadaan'])->year;
        }

        $barang->update($validated);

        // Regenerate nomor inventaris
        // Kalau kode berubah, update 2 grup: kode lama & kode baru
        $this->regenerateNomorInventarisByKode($barang->kode_barang);
        if ($kode_lama !== $barang->kode_barang) {
            $this->regenerateNomorInventarisByKode($kode_lama);
        }

        return redirect()->route('barang.show', $barang)
            ->with('success', 'Barang berhasil diupdate.');
    }

    // ============================================================
    // DESTROY
    // ============================================================
    public function destroy(Barang $barang)
    {
        $kode = $barang->kode_barang;

        if ($barang->foto)    Storage::disk('public')->delete($barang->foto);
        if ($barang->qr_code) Storage::disk('public')->delete($barang->qr_code);

        $barang->delete();

        // Regenerate nomor inventaris barang lain dengan kode yang sama
        $this->regenerateNomorInventarisByKode($kode);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }

    // ============================================================
    // GENERATE QR
    // ============================================================
    public function generateQr(Barang $barang)
    {
        $qr = QrCode::format('svg')->size(300)->errorCorrection('H')
            ->generate(route('barang.show', $barang));

        return response($qr, 200)->header('Content-Type', 'image/svg+xml');
    }

    public function printQr(Barang $barang)
    {
        $barang->load('lokasi');
        return view('barang.print-qr', compact('barang'));
    }

    public function printQrSemua()
    {
        $barangs = Barang::with('lokasi')->latest()->get();
        return view('barang.print-qr-semua', compact('barangs'));
    }

    // ============================================================
    // UPLOAD FOTO (khusus dari detail barang jika belum ada foto)
    // ============================================================
    public function uploadFoto(Request $request, Barang $barang)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'foto.required' => 'File foto wajib dipilih.',
            'foto.image'    => 'File harus berupa gambar.',
            'foto.mimes'    => 'Format foto harus JPG, PNG, atau WEBP.',
            'foto.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $path = $request->file('foto')->store('barang', 'public');
        $barang->update(['foto' => $path]);

        return redirect()->route('barang.show', $barang)
            ->with('success', 'Foto barang berhasil diunggah.');
    }

    // ============================================================
    // BULK DELETE
    // ============================================================
    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:barang,id']);

        $kodes   = [];
        $deleted = 0;

        foreach ($request->ids as $id) {
            $barang = Barang::find($id);
            if (!$barang) continue;

            $kodes[] = $barang->kode_barang;

            if ($barang->foto)    Storage::disk('public')->delete($barang->foto);
            if ($barang->qr_code) Storage::disk('public')->delete($barang->qr_code);

            $barang->delete();
            $deleted++;
        }

        // Regenerate nomor inventaris untuk semua kode yang terdampak
        foreach (array_unique(array_filter($kodes)) as $kode) {
            $this->regenerateNomorInventarisByKode($kode);
        }

        return redirect()->route('barang.index')
            ->with('success', "{$deleted} barang berhasil dihapus.");
    }

    // ============================================================
    // CHECK NEXT NUMBER (LIVE PREVIEW)
    // ============================================================
    public function checkNextNumber(Request $request)
    {
        $kode = strtoupper(trim($request->query('kode', '')));
        if (empty($kode)) {
            return response()->json([
                'count' => 0,
                'next'  => 1,
                'formatted' => '001/001'
            ]);
        }

        $count = Barang::where('kode_barang', $kode)->count();
        $next  = $count + 1;

        $urutanStr = str_pad($next, 3, '0', STR_PAD_LEFT);
        $totalStr  = str_pad($next, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'count'     => $count,
            'next'      => $next,
            'formatted' => "{$urutanStr}/{$totalStr}"
        ]);
    }
}
