@extends('layouts.app')

@section('title', 'Print QR Code - ' . $barang->nama)

@section('content')
<style>
    @media print {
        #sidebar, #header, nav, footer, .no-print {
            display: none !important;
        }
        body, #main-content, main {
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
            overflow: visible !important;
            width: 100% !important;
        }
        .qr-card {
            box-shadow: none !important;
            border: 2px solid #000 !important;
            margin: 0 auto !important;
            width: 300px !important;
        }
    }
    .svg-qr svg {
        width: 100% !important;
        height: 100% !important;
        display: block !important;
    }
</style>

<div class="max-w-xl mx-auto w-full pb-12">

    {{-- Header Action Bar --}}
    <div class="flex items-center justify-between mb-6 no-print animate-card" style="animation-delay: 0ms;">
        <a href="{{ route('barang.show', $barang) }}" class="p-2.5 rounded-xl bg-white border border-gray-200 text-gray-600 hover:text-[#2548cc] hover:border-[#2548cc] hover:bg-blue-50 transition-all shadow-sm flex items-center gap-2 text-xs font-bold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke Detail
        </a>
        <button onclick="window.print()" class="bg-[#2548cc] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:bg-blue-800 transition flex items-center gap-2 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
            Print QR
        </button>
    </div>

    {{-- Single QR Card --}}
    <div class="qr-card bg-white rounded-2xl border border-gray-200 p-6 text-center shadow-lg w-80 mx-auto">
        <div class="border-b border-gray-100 pb-3 mb-4 flex items-center justify-between">
            <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-[#2548cc]"></span>
                <span class="text-xs font-black text-[#1a2f6e] tracking-widest uppercase">INVENTARIS</span>
            </div>
            <span class="text-xs font-semibold text-gray-400">{{ $barang->kode_barang ?? '-' }}</span>
        </div>

        <div class="my-4 flex justify-center">
            <div class="p-3 bg-white rounded-2xl border border-gray-100 shadow-inner inline-block w-48 h-48 svg-qr">
                {!! QrCode::size(170)->errorCorrection('M')->generate(route('barang.show', $barang)) !!}
            </div>
        </div>

        <h2 class="font-extrabold text-base text-gray-900 mb-3">{{ $barang->nama }}</h2>

        <div class="bg-gray-50 rounded-xl p-3 text-xs space-y-1.5 text-gray-600 border border-gray-100 text-left">
            <div class="flex justify-between">
                <span class="text-gray-400">Ruangan:</span>
                <strong class="text-gray-800">{{ $barang->lokasi?->nama ?? '-' }}</strong>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">Gedung / Lt:</span>
                <strong class="text-gray-800">{{ strtoupper($barang->lokasi?->gedung ?? '-') }} (Lt. {{ $barang->lokasi?->lantai ?? '-' }})</strong>
            </div>
            @if($barang->tanggal_pengadaan)
            <div class="flex justify-between">
                <span class="text-gray-400">Pengadaan:</span>
                <strong class="text-gray-800">{{ \Carbon\Carbon::parse($barang->tanggal_pengadaan)->format('d/m/Y') }}</strong>
            </div>
            @endif
        </div>

        <div class="mt-4 font-mono text-xs font-bold text-[#2548cc] bg-blue-50 border border-blue-100 py-2 px-3 rounded-xl">
            {{ $barang->nomor_inventaris ?? '-' }}
        </div>
    </div>

</div>
@endsection