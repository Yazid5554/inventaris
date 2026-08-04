@extends('layouts.app')

@section('title', 'Print QR Code Semua Barang')

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
            max-width: 100% !important;
        }
        .print-grid {
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 12px !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .qr-card {
            box-shadow: none !important;
            border: 1.5px solid #000 !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            background: white !important;
        }
    }
    .svg-qr {
        width: 170px !important;
        height: 170px !important;
    }
    .svg-qr svg {
        width: 100% !important;
        height: 100% !important;
        display: block !important;
    }
</style>

<div class="max-w-6xl mx-auto w-full pb-12">

    {{-- Header Action Bar --}}
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 no-print animate-card" style="animation-delay: 0ms;">
        <div class="flex items-center gap-4">
            <a href="{{ route('barang.index') }}" class="p-2.5 rounded-xl bg-white border border-gray-200 text-gray-600 hover:text-[#2548cc] hover:border-[#2548cc] hover:bg-blue-50 transition-all shadow-sm flex items-center gap-2 text-xs font-bold">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Kembali
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-[#1a2f6e] flex items-center gap-2">
                    <svg class="w-7 h-7 text-[#2548cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    Print QR Code Semua Barang
                </h1>
                <p class="text-xs text-gray-500 mt-0.5">Total <strong class="text-gray-900">{{ $barangs->count() }}</strong> label QR barang siap dicetak.</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="bg-[#2548cc] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:bg-blue-800 transition flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Sekarang (Print / PDF)
            </button>
        </div>
    </div>

    {{-- Grid Label QR Barang --}}
    <div class="print-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
        @foreach($barangs as $b)
        <div class="qr-card bg-white rounded-2xl border border-gray-200 p-5 text-center shadow-sm hover:shadow-md transition-all relative overflow-hidden flex flex-col justify-between">
            
            {{-- Header Label --}}
            <div class="border-b border-gray-100 pb-2.5 mb-3 flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-[#2548cc]"></span>
                    <span class="text-[10px] font-black text-[#1a2f6e] tracking-widest uppercase">INVENTARIS</span>
                </div>
                <span class="text-[10px] font-semibold text-gray-400">{{ $b->kode_barang ?? '-' }}</span>
            </div>

            {{-- Pure Single SVG Vector QR Code --}}
            <div class="my-2 flex justify-center">
                <div class="p-2 bg-white rounded-xl border border-gray-100 shadow-inner inline-flex items-center justify-center svg-qr">
                    {!! QrCode::size(170)->errorCorrection('L')->generate(route('barang.show', $b)) !!}
                </div>
            </div>

            {{-- Nama Barang & Detail --}}
            <div class="mt-2">
                <h3 class="font-extrabold text-sm text-gray-900 line-clamp-1 mb-2">{{ $b->nama }}</h3>

                <div class="bg-gray-50 rounded-xl p-2.5 text-[11px] space-y-1 text-gray-600 border border-gray-100">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Ruangan:</span>
                        <strong class="text-gray-800">{{ $b->lokasi?->nama ?? '-' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Gedung / Lt:</span>
                        <strong class="text-gray-800">{{ strtoupper($b->lokasi?->gedung ?? '-') }} (Lt. {{ $b->lokasi?->lantai ?? '-' }})</strong>
                    </div>
                </div>

                {{-- No Inventaris Pill --}}
                <div class="mt-3 font-mono text-[10px] font-bold text-[#2548cc] bg-blue-50 border border-blue-100 py-1.5 px-2 rounded-lg truncate">
                    {{ $b->nomor_inventaris ?? '-' }}
                </div>
            </div>

        </div>
        @endforeach
    </div>

</div>
@endsection