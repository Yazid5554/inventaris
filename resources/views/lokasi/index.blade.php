@extends('layouts.app')
@section('title', 'Ruangan')

@section('content')
<style>
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-card { animation: fadeSlideUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) both; }
</style>

{{-- Header --}}
<div class="flex items-center justify-between mb-6 animate-card" style="animation-delay: 0ms;">
    <div class="flex items-center gap-3">
        <div class="text-[#1a2f6e]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-[#1a2f6e]">Daftar Ruangan</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola semua ruangan dan lokasi inventaris.</p>
        </div>
    </div>
    <a href="{{ route('lokasi.create') }}"
       class="bg-[#2548cc] text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-blue-800 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Ruangan
    </a>
</div>

{{-- Stat Cards --}}
<div class="grid grid-cols-4 gap-4 mb-6">

    {{-- Total Ruangan --}}
    <div class="group bg-white rounded-xl border border-gray-100 shadow-sm p-4 relative overflow-hidden flex flex-col justify-between h-[110px] hover:-translate-y-1 hover:shadow-xl hover:border-blue-100 transition-all duration-300 animate-card" style="animation-delay: 100ms;">
        <div class="flex items-start gap-3">
            <div class="flex items-center justify-center text-[#2548cc] flex-shrink-0 z-10">
                <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div class="z-10">
                <div class="flex items-center gap-2">
                    <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">Total Ruangan</span>
                    <span class="text-[10px] bg-blue-100 text-blue-600 px-1.5 py-0.5 rounded font-bold">Aktif</span>
                </div>
                <span class="text-3xl font-extrabold text-gray-900 mt-1 block">{{ $stats['total_ruangan'] }}</span>
            </div>
        </div>
        <svg class="w-28 h-28 text-gray-100 absolute -bottom-5 -right-5 z-0 group-hover:scale-125 group-hover:text-blue-50 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
    </div>

    {{-- Total Gedung --}}
    <div class="group bg-white rounded-xl border border-gray-100 shadow-sm p-4 relative overflow-hidden flex flex-col justify-between h-[110px] hover:-translate-y-1 hover:shadow-xl hover:border-purple-100 transition-all duration-300 animate-card" style="animation-delay: 200ms;">
        <div class="flex items-start gap-3">
            <div class="flex items-center justify-center text-purple-500 flex-shrink-0 z-10">
                <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                </svg>
            </div>
            <div class="z-10">
                <div class="flex items-center gap-2">
                    <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">Total Gedung</span>
                    <span class="text-[10px] bg-purple-100 text-purple-600 px-1.5 py-0.5 rounded font-bold">Unik</span>
                </div>
                <span class="text-3xl font-extrabold text-gray-900 mt-1 block">{{ $stats['total_gedung'] }}</span>
            </div>
        </div>
        <svg class="w-28 h-28 text-gray-100 absolute -bottom-5 -right-5 z-0 group-hover:scale-125 group-hover:text-purple-50 transition-all duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
        </svg>
    </div>

    {{-- Total Lantai --}}
    <div class="group bg-white rounded-xl border border-gray-100 shadow-sm p-4 relative overflow-hidden flex flex-col justify-between h-[110px] hover:-translate-y-1 hover:shadow-xl hover:border-emerald-100 transition-all duration-300 animate-card" style="animation-delay: 300ms;">
        <div class="flex items-start gap-3">
            <div class="flex items-center justify-center text-emerald-500 flex-shrink-0 z-10">
                <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 512 512">
                    <path d="M234.3 9.4C247.3 3.1 264.7 3.1 277.7 9.4l224 106.7c11.9 5.7 11.9 22.9 0 28.5L277.7 251.3c-13 6.2-30.4 6.2-43.3 0L10.3 144.6c-11.9-5.7-11.9-22.9 0-28.5l224-106.7zM10.3 256.6l224 106.7c13 6.2 30.4 6.2 43.3 0l224-106.7c11.9-5.7 11.9-22.9 0-28.5l-224 106.7c-13 6.2-30.4 6.2-43.3 0L10.3 228.1c-11.9 5.7-11.9 22.9 0 28.5zM10.3 368.6l224 106.7c13 6.2 30.4 6.2 43.3 0l224-106.7c11.9-5.7 11.9-22.9 0-28.5l-224 106.7c-13 6.2-30.4 6.2-43.3 0L10.3 340.1c-11.9 5.7-11.9 22.9 0 28.5z"/>
                </svg>
            </div>
            <div class="z-10">
                <div class="flex items-center gap-2">
                    <span class="text-[11px] text-gray-500 font-bold uppercase tracking-wider">Total Lantai</span>
                    <span class="text-[10px] bg-emerald-100 text-emerald-600 px-1.5 py-0.5 rounded font-bold">Unik</span>
                </div>
                <span class="text-3xl font-extrabold text-gray-900 mt-1 block">{{ $stats['total_lantai'] }}</span>
            </div>
        </div>
        <svg class="w-24 h-24 text-gray-100 absolute -bottom-4 -right-4 z-0 group-hover:scale-125 group-hover:text-emerald-50 transition-all duration-500" fill="currentColor" viewBox="0 0 512 512">
            <path d="M234.3 9.4C247.3 3.1 264.7 3.1 277.7 9.4l224 106.7c11.9 5.7 11.9 22.9 0 28.5L277.7 251.3c-13 6.2-30.4 6.2-43.3 0L10.3 144.6c-11.9-5.7-11.9-22.9 0-28.5l224-106.7zM10.3 256.6l224 106.7c13 6.2 30.4 6.2 43.3 0l224-106.7c11.9-5.7 11.9-22.9 0-28.5l-224 106.7c-13 6.2-30.4 6.2-43.3 0L10.3 228.1c-11.9 5.7-11.9 22.9 0 28.5zM10.3 368.6l224 106.7c13 6.2 30.4 6.2 43.3 0l224-106.7c11.9-5.7 11.9-22.9 0-28.5l-224 106.7c-13 6.2-30.4 6.2-43.3 0L10.3 340.1c-11.9 5.7-11.9 22.9 0 28.5z"/>
        </svg>
    </div>

    {{-- Search Bar (menggantikan card Total Barang) --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 flex flex-col justify-center h-[110px] animate-card" style="animation-delay: 400ms;">
        <p class="text-[11px] text-gray-500 font-bold uppercase tracking-wider mb-2.5">Cari Ruangan</p>
        <form method="GET" class="flex flex-col gap-2">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Nama, gedung, lantai..."
                    class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-[#2548cc] text-white py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-800 transition flex items-center justify-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari
                </button>
                @if(request('search'))
                <a href="{{ route('lokasi.index') }}" class="px-3 py-1.5 rounded-lg text-xs text-gray-500 border border-gray-200 hover:bg-gray-50 transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

</div>


{{-- Card Grid --}}
@forelse($lokasis as $i => $lokasi)
@php
    $colors = [
        ['border' => 'border-blue-100', 'icon_bg' => 'bg-blue-100', 'icon_text' => 'text-[#2548cc]', 'badge' => 'bg-blue-100 text-blue-700', 'hover_border' => 'hover:border-blue-300'],
        ['border' => 'border-purple-100', 'icon_bg' => 'bg-purple-100', 'icon_text' => 'text-purple-600', 'badge' => 'bg-purple-100 text-purple-700', 'hover_border' => 'hover:border-purple-300'],
        ['border' => 'border-emerald-100', 'icon_bg' => 'bg-emerald-100', 'icon_text' => 'text-emerald-600', 'badge' => 'bg-emerald-100 text-emerald-700', 'hover_border' => 'hover:border-emerald-300'],
        ['border' => 'border-orange-100', 'icon_bg' => 'bg-orange-100', 'icon_text' => 'text-orange-600', 'badge' => 'bg-orange-100 text-orange-700', 'hover_border' => 'hover:border-orange-300'],
    ];
    $c = $colors[$i % 4];
@endphp
@if($i === 0)
<div class="grid grid-cols-3 gap-5 mb-6">
@endif

    <div class="group bg-white rounded-2xl border {{ $c['border'] }} shadow-sm p-5 relative overflow-hidden hover:-translate-y-1 hover:shadow-lg {{ $c['hover_border'] }} transition-all duration-300 flex flex-col gap-3 animate-card" style="animation-delay: {{ 300 + ($i * 250) }}ms;">

        {{-- Top Row: Icon + Gedung Badge --}}
        <div class="flex items-start justify-between">
            <div class="{{ $c['icon_text'] }} w-10 h-10 flex items-center justify-start flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            @if($lokasi->gedung)
            <span class="{{ $c['badge'] }} text-[11px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                Gd. {{ strtoupper($lokasi->gedung) }}
            </span>
            @endif
        </div>

        {{-- Nama Ruangan --}}
        <div class="flex-1">
            <h3 class="font-bold text-gray-900 text-base leading-snug group-hover:text-[#1a2f6e] transition-colors">{{ $lokasi->nama }}</h3>
            <div class="flex items-center flex-wrap gap-2 mt-1.5">
                @if($lokasi->lantai)
                <span class="inline-flex items-center gap-1 text-[11px] text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full font-medium">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 512 512"><path d="M234.3 9.4C247.3 3.1 264.7 3.1 277.7 9.4l224 106.7c11.9 5.7 11.9 22.9 0 28.5L277.7 251.3c-13 6.2-30.4 6.2-43.3 0L10.3 144.6c-11.9-5.7-11.9-22.9 0-28.5l224-106.7zM10.3 256.6l224 106.7c13 6.2 30.4 6.2 43.3 0l224-106.7c11.9-5.7 11.9-22.9 0-28.5l-224 106.7c-13 6.2-30.4 6.2-43.3 0L10.3 228.1c-11.9 5.7-11.9 22.9 0 28.5zM10.3 368.6l224 106.7c13 6.2 30.4 6.2 43.3 0l224-106.7c11.9-5.7 11.9-22.9 0-28.5l-224 106.7c-13 6.2-30.4 6.2-43.3 0L10.3 340.1c-11.9 5.7-11.9 22.9 0 28.5z"/></svg>
                    Lt. {{ $lokasi->lantai }}
                </span>
                @endif
                @if($lokasi->jenis)
                <span class="inline-flex items-center gap-1 text-[11px] text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full font-medium">
                    {{ ucfirst($lokasi->jenis) }}
                </span>
                @endif
            </div>
            @if($lokasi->keterangan)
            <p class="text-xs text-gray-400 mt-1.5 line-clamp-2">{{ $lokasi->keterangan }}</p>
            @endif
        </div>

        {{-- Bottom: Barang Count + Actions --}}
        <div class="relative z-10 flex items-center justify-between pt-3 border-t border-gray-100">
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span class="text-sm font-bold text-gray-700">{{ $lokasi->barang_count }}</span>
                <span class="text-xs text-gray-400">barang</span>
            </div>
            {{-- Action Buttons — always visible --}}
            <div class="flex items-center gap-1">
                <a href="{{ route('lokasi.edit', $lokasi) }}"
                   class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-[#2548cc] bg-blue-50 border border-blue-100 rounded-lg hover:bg-blue-100 transition-colors"
                   title="Edit">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Edit
                </a>
                <form method="POST" action="{{ route('lokasi.destroy', $lokasi) }}" class="inline-block" onsubmit="return confirm('Hapus ruangan {{ $lokasi->nama }}?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-500 bg-red-50 border border-red-100 rounded-lg hover:bg-red-100 transition-colors"
                        title="Hapus">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        {{-- Decorative background icon --}}
        <svg class="w-32 h-32 text-gray-50 absolute -bottom-6 -right-6 z-0 pointer-events-none group-hover:scale-110 group-hover:text-gray-100 transition-all duration-500" fill="currentColor" viewBox="0 0 24 24">
            <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
    </div>

@if($loop->last)
</div>
@endif

@empty
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-16 text-center animate-card" style="animation-delay: 200ms;">
    <svg class="w-16 h-16 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
    </svg>
    <p class="font-semibold text-gray-500 text-lg">Belum ada ruangan</p>
    <p class="text-gray-400 text-sm mt-1 mb-5">Mulai tambahkan ruangan pertama untuk sistem inventaris.</p>
    <a href="{{ route('lokasi.create') }}" class="inline-flex items-center gap-2 bg-[#2548cc] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-blue-800 transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Ruangan Sekarang
    </a>
</div>
@endforelse

{{-- Pagination --}}
@if($lokasis->hasPages())
<div class="mt-4 flex justify-center animate-card" style="animation-delay: 400ms;">
    {{ $lokasis->links() }}
</div>
@endif

@endsection