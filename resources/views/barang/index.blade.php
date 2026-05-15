@extends('layouts.app')
@section('title', 'Barang')

@section('content')
<style>
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-card { animation: fadeSlideUp 1.2s cubic-bezier(0.16, 1, 0.3, 1) both; }
</style>

{{-- Header --}}
<div class="flex flex-wrap items-center justify-between gap-4 mb-4 animate-card relative z-20" style="animation-delay: 0ms;">
    <div class="flex items-center gap-3">
        <div class="text-[#1a2f6e]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-[#1a2f6e]">Daftar Barang</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola semua inventaris barang.</p>
        </div>
    </div>
    <div class="flex items-center gap-3">
        {{-- Dropdown Export --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="bg-emerald-500 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-emerald-600 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                Export
            </button>
            <div x-show="open" @click.outside="open = false" style="display: none;"
                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden">
                <a href="{{ route('export.excel') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Excel (.xlsx)
                </a>
                <a href="{{ route('export.pdf') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 border-t border-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    PDF Document
                </a>
            </div>
        </div>

        <a href="{{ route('barang.print-qr-semua') }}" target="_blank"
            class="bg-gray-800 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-gray-900 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
            Print Semua QR
        </a>

        <a href="{{ route('barang.create') }}"
            class="bg-[#2548cc] text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-blue-800 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Barang
        </a>
    </div>
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm mb-4 flex justify-between items-center shadow-sm animate-card" style="animation-delay: 50ms;">
    <div class="flex items-center gap-2">
        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
</div>
@endif

{{-- Filter Box --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-4 animate-card" style="animation-delay: 100ms;">
    <form method="GET" class="flex flex-wrap gap-4 items-end">
        <div class="flex-1 min-w-[250px]">
            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Pencarian</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Nama, kode, atau no inventaris..."
                    class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition">
            </div>
        </div>
        <div class="w-64">
            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Filter Ruangan</label>
            <select name="id_lokasi" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition">
                <option value="">Semua Ruangan</option>
                @foreach($lokasis as $l)
                <option value="{{ $l->id }}" {{ request('id_lokasi') == $l->id ? 'selected' : '' }}>
                    {{ $l->nama }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-[#2548cc] text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-blue-800 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
            Filter
        </button>
        @if(request()->hasAny(['search','id_lokasi','kondisi']))
        <a href="{{ route('barang.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">
            Reset
        </a>
        @endif
        @if(request('kondisi'))
        <input type="hidden" name="kondisi" value="{{ request('kondisi') }}" />
        @endif
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden animate-card" style="animation-delay: 200ms;">
    <div class="overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50/80 border-b border-gray-100">
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Kode</th>
                    <th class="px-6 py-4">Nama Barang</th>
                    <th class="px-6 py-4">Lokasi</th>
                    <th class="px-6 py-4">Tahun</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($barang as $i => $b)
                <tr class="hover:bg-blue-50/50 transition-colors group animate-card" style="animation-delay: {{ 250 + ($i * 50) }}ms;">
                    <td class="px-6 py-3.5 text-gray-500 whitespace-nowrap">
                        {{ ($barang->currentPage() - 1) * $barang->perPage() + $i + 1 }}
                    </td>
                    <td class="px-6 py-3.5 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-bold bg-gray-100 text-gray-700 border border-gray-200">
                            {{ $b->kode_barang ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="font-bold text-gray-900 group-hover:text-[#2548cc] transition-colors leading-tight">{{ $b->nama }}</div>
                        <div class="text-xs font-mono text-gray-500 mt-1">{{ $b->nomor_inventaris ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="font-medium text-gray-700 leading-tight">{{ $b->lokasi?->nama ?? '-' }}</div>
                        <div class="flex items-center gap-2 mt-1">
                            @if($b->lokasi?->gedung)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-purple-50 text-purple-600 border border-purple-100 uppercase">
                                Gd. {{ $b->lokasi->gedung }}
                            </span>
                            @endif
                            @if($b->lokasi?->lantai)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 512 512"><path d="M234.3 9.4C247.3 3.1 264.7 3.1 277.7 9.4l224 106.7c11.9 5.7 11.9 22.9 0 28.5L277.7 251.3c-13 6.2-30.4 6.2-43.3 0L10.3 144.6c-11.9-5.7-11.9-22.9 0-28.5l224-106.7zM10.3 256.6l224 106.7c13 6.2 30.4 6.2 43.3 0l224-106.7c11.9-5.7 11.9-22.9 0-28.5l-224 106.7c-13 6.2-30.4 6.2-43.3 0L10.3 228.1c-11.9 5.7-11.9 22.9 0 28.5zM10.3 368.6l224 106.7c13 6.2 30.4 6.2 43.3 0l224-106.7c11.9-5.7 11.9-22.9 0-28.5l-224 106.7c-13 6.2-30.4 6.2-43.3 0L10.3 340.1c-11.9 5.7-11.9 22.9 0 28.5z"/></svg>
                                Lt. {{ $b->lokasi->lantai }}
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-3.5 text-gray-500 whitespace-nowrap">
                        {{ $b->tahun_pengadaan ?? '-' }}
                    </td>
                    <td class="px-6 py-3.5 whitespace-nowrap text-right">
                        <div class="flex items-center justify-end gap-1.5 opacity-60 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('barang.show', $b) }}" class="p-2 text-gray-400 hover:text-[#2548cc] hover:bg-blue-50 rounded-lg transition-colors" title="Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </a>
                            <a href="{{ route('barang.edit', $b) }}" class="p-2 text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                            <a href="{{ route('barang.qr', $b) }}" target="_blank" class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="Print QR">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            </a>
                            <form method="POST" action="{{ route('barang.destroy', $b) }}" class="inline-block" onsubmit="return confirm('Hapus barang {{ $b->nama }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                        <p class="text-lg font-medium text-gray-900">Belum ada data barang</p>
                        <p class="text-sm mt-1">Mulai tambahkan barang inventaris pertama Anda.</p>
                        <a href="{{ route('barang.create') }}" class="inline-flex items-center gap-2 mt-4 text-[#2548cc] hover:text-blue-800 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                            Tambah Barang
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="flex justify-between items-center px-6 py-3 border-t border-gray-100 bg-gray-50/50">
        <p class="text-xs text-gray-500">Menampilkan {{ $barang->firstItem() ?? 0 }} - {{ $barang->lastItem() ?? 0 }} dari {{ $barang->total() }} barang</p>

        @if ($barang->hasPages())
        <div class="flex gap-1">
            {{-- Previous Page Link --}}
            @if ($barang->onFirstPage())
            <span class="w-8 h-8 flex items-center justify-center rounded border border-gray-100 text-gray-300 bg-gray-50 cursor-not-allowed">&lt;</span>
            @else
            <a href="{{ $barang->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded border border-gray-200 text-gray-500 hover:bg-gray-50 bg-white shadow-sm transition-colors">&lt;</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($barang->links()->elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                <span class="w-8 h-8 flex items-center justify-center rounded border border-gray-100 text-gray-500 bg-white shadow-sm">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $barang->currentPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded bg-[#1a2f6e] text-white font-medium shadow-sm">{{ $page }}</span>
                        @else
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded border border-gray-200 text-gray-500 hover:bg-gray-50 bg-white shadow-sm transition-colors">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($barang->hasMorePages())
            <a href="{{ $barang->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded border border-gray-200 text-gray-500 hover:bg-gray-50 bg-white shadow-sm transition-colors">&gt;</a>
            @else
            <span class="w-8 h-8 flex items-center justify-center rounded border border-gray-100 text-gray-300 bg-gray-50 cursor-not-allowed">&gt;</span>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection