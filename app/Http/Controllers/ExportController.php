<?php

namespace App\Http\Controllers;

use App\Exports\BarangExport;
use App\Imports\BarangImport;
use App\Models\Barang;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ExportController extends Controller
{
    public function exportExcel()
    {
        $filename = 'data-barang-' . date('d-m-Y') . '.xlsx';
        return Excel::download(new BarangExport, $filename);
    }

    public function exportPdf()
    {
        $barangs = Barang::with('lokasi')->latest()->get();

        $pdf = Pdf::loadView('exports.barang-pdf', compact('barangs'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('data-barang-' . date('d-m-Y') . '.pdf');
    }

    /**
     * Import data barang dari file Excel
     */
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240',
        ], [
            'file.required' => 'File Excel wajib dipilih.',
            'file.mimes'    => 'Format file harus .xlsx atau .xls.',
            'file.max'      => 'Ukuran file maksimal 10MB.',
        ]);

        $import = new BarangImport();

        try {
            Excel::import($import, $request->file('file'));
        } catch (\Exception $e) {
            return redirect()->route('barang.index')
                ->with('import_error', 'Gagal membaca file Excel. Pastikan format file sesuai template.')
                ->with('import_errors', [$e->getMessage()]);
        }

        // Kumpulkan feedback
        if ($import->successCount > 0 && empty($import->errors)) {
            return redirect()->route('barang.index')
                ->with('success', "Berhasil import {$import->successCount} barang.");
        }

        if ($import->successCount > 0 && !empty($import->errors)) {
            return redirect()->route('barang.index')
                ->with('success', "Berhasil import {$import->successCount} barang.")
                ->with('import_errors', $import->errors);
        }

        if ($import->successCount === 0 && !empty($import->errors)) {
            return redirect()->route('barang.index')
                ->with('import_error', 'Tidak ada data yang berhasil di-import.')
                ->with('import_errors', $import->errors);
        }

        return redirect()->route('barang.index')
            ->with('import_error', 'File Excel kosong atau tidak ada data yang valid.');
    }

    /**
     * Download template Excel untuk import
     * Format sesuai spreadsheet client
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Barang');

        // Row 1: Judul
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'Daftar Inventaris');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => 'FF000000']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFFFFF00']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(35);

        // Row 2: Header
        $headers = ['No', 'Gedung', 'Lantai', 'Tahun', 'Ruangan', 'Kode Barang', 'Nama Barang', 'Nomor Inventaris', 'Barcode', 'Keterangan'];
        foreach ($headers as $col => $header) {
            $cell = chr(65 + $col) . '2';
            $sheet->setCellValue($cell, $header);
        }

        $sheet->getStyle('A2:J2')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FF000000']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFD9E1F2']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(25);

        // Row 3: Contoh data
        $example = [1, 'A', '01', 2025, 'DAPUR', 'KL', 'Kulkas', '(auto)', '(auto)', 'Kulkas baru'];
        foreach ($example as $col => $val) {
            $sheet->setCellValue(chr(65 + $col) . '3', $val);
        }
        $sheet->getStyle('A3:J3')->applyFromArray([
            'font'    => ['italic' => true, 'color' => ['argb' => 'FF888888']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        // Auto-size kolom
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set kolom H dan I info
        $sheet->getComment('H2')->getText()->createTextRun('Kolom ini di-skip saat import. Nomor Inventaris akan di-generate otomatis oleh sistem.');
        $sheet->getComment('I2')->getText()->createTextRun('Kolom ini di-skip saat import. QR/Barcode akan di-generate otomatis oleh sistem.');

        // Generate file
        $writer = new Xlsx($spreadsheet);
        $filename = 'template-import-barang.xlsx';
        $tempPath = storage_path('app/' . $filename);
        $writer->save($tempPath);

        return response()->download($tempPath, $filename)->deleteFileAfterSend(true);
    }
}
