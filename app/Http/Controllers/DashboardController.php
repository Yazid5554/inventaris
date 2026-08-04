<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Lokasi;
use App\Models\Perbaikan;
use App\Models\RiwayatKondisi;

class DashboardController extends Controller
{
    public function index()
    {
        $latestKondisiIds = RiwayatKondisi::selectRaw('MAX(id) as id')->groupBy('id_barang');

        $stats = [
            'total_barang'    => Barang::count(),
            'total_lokasi'    => Lokasi::count(),
            'barang_rusak'    => RiwayatKondisi::whereIn('kondisi', ['rusak_ringan', 'rusak_berat', 'tidak_layak_pakai'])
                ->whereIn('id', $latestKondisiIds)
                ->count(),
            'perbaikan_aktif' => RiwayatKondisi::where('kondisi', 'dalam_perbaikan')
                ->whereIn('id', $latestKondisiIds)
                ->count(),
        ];

        $barang_terbaru = Barang::with('lokasi')->latest()->paginate(5);

        return view('dashboard', compact('stats', 'barang_terbaru'));
    }
}