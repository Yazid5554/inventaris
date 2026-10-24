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
<div class="flex flex-wrap items-center justify-between gap-4 mb-4 animate-card relative z-10" style="animation-delay: 0ms;">
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
    <div class="flex flex-wrap items-center gap-2.5 w-full sm:w-auto">
        {{-- Tombol Import --}}
        <button onclick="document.getElementById('import-modal').classList.remove('hidden')"
            class="bg-indigo-500 text-white px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold shadow-sm hover:bg-indigo-600 transition-all flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
            Import
        </button>

        {{-- Dropdown Export --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open"
                class="bg-emerald-500 text-white px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold shadow-sm hover:bg-emerald-600 transition-all flex items-center gap-1.5">
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

        <a href="{{ route('barang.print-qr-semua') }}"
            class="bg-gray-800 text-white px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold shadow-sm hover:bg-gray-900 transition-all flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
            Print Semua QR
        </a>

        <a href="{{ route('barang.create') }}"
            class="bg-[#2548cc] text-white px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold shadow-sm hover:bg-blue-800 transition-all flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
            Tambah Barang
        </a>
    </div>
</div>



@if(session('import_errors'))
<div class="bg-amber-50 border border-amber-200 text-amber-800 rounded-xl px-4 py-3 text-sm mb-4 shadow-sm animate-card" style="animation-delay: 75ms;">
    <div class="flex items-center justify-between mb-2">
        <div class="flex items-center gap-2 font-semibold">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            Peringatan Import ({{ count(session('import_errors')) }} masalah)
        </div>
        <button onclick="this.closest('.bg-amber-50').remove()" class="text-amber-600 hover:text-amber-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <ul class="list-disc list-inside space-y-1 text-xs max-h-32 overflow-y-auto">
        @foreach(session('import_errors') as $err)
        <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Filter Box --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 mb-4 animate-card" style="animation-delay: 100ms;">
    <form method="GET" class="flex flex-col sm:flex-row flex-wrap gap-3 items-stretch sm:items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Pencarian</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Nama, kode, atau no inventaris..."
                    class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition">
            </div>
        </div>
        <div class="w-full sm:w-48">
            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter Ruangan</label>
            <select name="id_lokasi" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition">
                <option value="">Semua Ruangan</option>
                @foreach($lokasis as $l)
                <option value="{{ $l->id }}" {{ request('id_lokasi') == $l->id ? 'selected' : '' }}>
                    {{ $l->nama }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="w-full sm:w-56">
            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Filter Kondisi</label>
            <select name="kondisi" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:bg-white transition cursor-pointer">
                <option value="">Semua Kondisi</option>
                <option value="baik" {{ request('kondisi') === 'baik' ? 'selected' : '' }}>✅ Baik / Normal</option>
                <option value="rusak" {{ request('kondisi') === 'rusak' ? 'selected' : '' }}>⚠️ Semua Barang Rusak</option>
                <option value="rusak_ringan" {{ request('kondisi') === 'rusak_ringan' ? 'selected' : '' }}>🟡 Rusak Ringan</option>
                <option value="rusak_berat" {{ request('kondisi') === 'rusak_berat' ? 'selected' : '' }}>🔴 Rusak Berat</option>
                <option value="dalam_perbaikan" {{ in_array(request('kondisi'), ['dalam_perbaikan','perbaikan_aktif']) ? 'selected' : '' }}>🔧 Dalam Perbaikan</option>
                <option value="tidak_layak_pakai" {{ request('kondisi') === 'tidak_layak_pakai' ? 'selected' : '' }}>🚫 Tidak Layak Pakai (Afkir)</option>
            </select>
        </div>
        <div class="flex gap-2 items-center">
            <button type="submit" class="bg-[#2548cc] text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 transition flex items-center justify-center gap-1.5 flex-1 sm:flex-initial">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
            @if(request()->hasAny(['search','id_lokasi','kondisi']))
            <a href="{{ route('barang.index') }}" class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 transition text-center">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden animate-card" style="animation-delay: 200ms;">
    <div class="overflow-x-auto custom-scrollbar">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50/80 border-b border-gray-100">
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-4 py-4 w-10 text-center">
                        <input type="checkbox" id="selectAllBarang" class="w-4 h-4 rounded border-gray-300 text-[#2548cc] focus:ring-[#2548cc] cursor-pointer">
                    </th>
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
                    <td class="px-4 py-3.5 text-center">
                        <input type="checkbox" name="ids[]" value="{{ $b->id }}" class="barang-item-checkbox w-4 h-4 rounded border-gray-300 text-[#2548cc] focus:ring-[#2548cc] cursor-pointer">
                    </td>
                    <td class="px-6 py-3.5 text-gray-500 whitespace-nowrap">
                        {{ ($barang->currentPage() - 1) * $barang->perPage() + $i + 1 }}
                    </td>
                    <td class="px-6 py-3.5 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-mono font-bold bg-gray-100 text-gray-700 border border-gray-200">
                            {{ $b->kode_barang ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-3.5">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('barang.show', $b) }}" class="font-bold text-gray-900 group-hover:text-[#2548cc] transition-colors leading-tight">{{ $b->nama }}</a>
                            @php
                                $kds = $b->riwayatKondisi->first()?->kondisi ?? 'baik';
                            @endphp
                            @if($kds === 'baik')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">Baik</span>
                            @elseif($kds === 'rusak_ringan')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-100">Rusak Ringan</span>
                            @elseif($kds === 'rusak_berat')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-100">Rusak Berat</span>
                            @elseif($kds === 'dalam_perbaikan')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">🔧 Servis</span>
                            @elseif($kds === 'tidak_layak_pakai')
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-700 border border-gray-200">🚫 Afkir</span>
                            @endif
                        </div>
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
                            <button type="button" 
                                onclick="openQrModal('{{ $b->id }}', '{{ e($b->nama) }}', '{{ e($b->kode_barang) }}', '{{ e($b->nomor_inventaris) }}', '{{ e($b->lokasi?->nama) }}', '{{ e(strtoupper($b->lokasi?->gedung ?? '-')) }} (Lt. {{ $b->lokasi?->lantai ?? '-' }})')" 
                                class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors cursor-pointer" 
                                title="Preview QR Code">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                            </button>
                            <form method="POST" action="{{ route('barang.destroy', $b) }}" class="inline-block" onsubmit="return confirmDelete(event, 'Hapus barang {{ $b->nama }}?')">
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
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
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
{{-- Modal Import Excel --}}
<div id="import-modal" class="fixed inset-0 z-[999] bg-black/50 backdrop-blur-sm flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Import Data Barang</h3>
                <p class="text-xs text-gray-400 mt-0.5">Upload file Excel (.xlsx) sesuai format template</p>
            </div>
            <button onclick="document.getElementById('import-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data" id="import-form">
            @csrf
            <div class="p-6">
                {{-- Drop Zone --}}
                <div id="drop-zone"
                    class="border-2 border-dashed border-gray-200 rounded-xl p-8 text-center cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/50 transition-all duration-300"
                    onclick="document.getElementById('import-file').click()"
                    ondragover="event.preventDefault(); this.classList.add('border-indigo-400', 'bg-indigo-50/50');"
                    ondragleave="this.classList.remove('border-indigo-400', 'bg-indigo-50/50');"
                    ondrop="event.preventDefault(); this.classList.remove('border-indigo-400', 'bg-indigo-50/50'); document.getElementById('import-file').files = event.dataTransfer.files; updateFileName();">
                    <div id="drop-zone-content">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <p class="text-sm font-medium text-gray-600">Drag & drop file Excel di sini</p>
                        <p class="text-xs text-gray-400 mt-1">atau klik untuk browse • Max 10MB</p>
                    </div>
                    <div id="file-selected" class="hidden">
                        <svg class="w-10 h-10 text-emerald-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <p class="text-sm font-medium text-emerald-700" id="file-name"></p>
                        <p class="text-xs text-gray-400 mt-1">Klik untuk ganti file</p>
                    </div>
                </div>
                <input type="file" name="file" id="import-file" accept=".xlsx,.xls" class="hidden" onchange="updateFileName()">

                {{-- Info Kolom --}}
                <div class="mt-4 bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kolom yang diproses:</p>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-semibold">Gedung</span>
                        <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-semibold">Lantai</span>
                        <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-semibold">Tahun</span>
                        <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-semibold">Ruangan</span>
                        <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-semibold">Kode Barang</span>
                        <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-semibold">Nama Barang</span>
                        <span class="text-[10px] bg-indigo-100 text-indigo-700 px-2 py-1 rounded-full font-semibold">Keterangan</span>
                        <span class="text-[10px] bg-gray-200 text-gray-500 px-2 py-1 rounded-full font-semibold line-through">No</span>
                        <span class="text-[10px] bg-gray-200 text-gray-500 px-2 py-1 rounded-full font-semibold line-through">Nomor Inventaris</span>
                        <span class="text-[10px] bg-gray-200 text-gray-500 px-2 py-1 rounded-full font-semibold line-through">Barcode</span>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2">Kolom dicoret akan di-skip (auto-generate oleh sistem)</p>
                </div>

                {{-- Download Template --}}
                <a href="{{ route('import.template') }}" class="mt-3 flex items-center gap-2 text-xs text-indigo-600 hover:text-indigo-800 font-medium transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    Download Template Excel
                </a>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('import-modal').classList.add('hidden')"
                    class="px-4 py-2 text-sm text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" id="import-btn"
                    class="px-5 py-2 text-sm text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    Import Data
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Floating Bulk Action Bar --}}
<div id="bulkActionBar" class="fixed bottom-6 left-1/2 -translate-x-1/2 z-40 bg-gray-900/90 text-white backdrop-blur-md px-5 py-3 rounded-2xl shadow-2xl border border-gray-700/50 flex items-center gap-4 transition-all duration-300 transform translate-y-24 opacity-0 pointer-events-none">
    <div class="flex items-center gap-2 text-sm font-medium">
        <span class="inline-flex items-center justify-center bg-[#2548cc] text-white min-w-[24px] h-6 px-1.5 rounded-full text-xs font-bold" id="selectedCount">0</span>
        <span class="text-xs sm:text-sm text-gray-200">barang dipilih</span>
    </div>
    <div class="h-4 w-px bg-gray-700"></div>
    <form id="bulkDeleteForm" action="{{ route('barang.bulk-delete') }}" method="POST" class="m-0 flex items-center">
        @csrf
        <div id="bulkDeleteInputs"></div>
        <button type="button" id="btnBulkDelete" class="bg-red-600 hover:bg-red-700 text-white px-3.5 py-1.5 rounded-xl text-xs sm:text-sm font-semibold transition flex items-center gap-1.5 cursor-pointer shadow-sm shadow-red-900/30">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Hapus Terpilih
        </button>
    </form>
    <button type="button" id="btnCancelSelection" class="text-xs text-gray-400 hover:text-white transition cursor-pointer">
        Batal
    </button>
</div>

<script>
function updateFileName() {
    const input = document.getElementById('import-file');
    const content = document.getElementById('drop-zone-content');
    const selected = document.getElementById('file-selected');
    const nameEl = document.getElementById('file-name');
    const btn = document.getElementById('import-btn');

    if (input.files && input.files[0]) {
        nameEl.textContent = input.files[0].name;
        content.classList.add('hidden');
        selected.classList.remove('hidden');
        btn.disabled = false;
    } else {
        content.classList.remove('hidden');
        selected.classList.add('hidden');
        btn.disabled = true;
    }
}

// Bulk Selection Logic
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAllBarang');
    const itemCheckboxes = document.querySelectorAll('.barang-item-checkbox');
    const bar = document.getElementById('bulkActionBar');
    const countEl = document.getElementById('selectedCount');
    const btnCancel = document.getElementById('btnCancelSelection');
    const btnBulkDelete = document.getElementById('btnBulkDelete');
    const bulkDeleteInputs = document.getElementById('bulkDeleteInputs');

    function updateBulkBar() {
        const checkedBoxes = document.querySelectorAll('.barang-item-checkbox:checked');
        const count = checkedBoxes.length;
        
        if (countEl) countEl.textContent = count;

        if (count > 0) {
            bar.classList.remove('translate-y-24', 'opacity-0', 'pointer-events-none');
            bar.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
        } else {
            bar.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
            bar.classList.add('translate-y-24', 'opacity-0', 'pointer-events-none');
        }

        if (selectAll && itemCheckboxes.length > 0) {
            if (count === 0) {
                selectAll.checked = false;
                selectAll.indeterminate = false;
            } else if (count === itemCheckboxes.length) {
                selectAll.checked = true;
                selectAll.indeterminate = false;
            } else {
                selectAll.checked = false;
                selectAll.indeterminate = true;
            }
        }

        // Highlight row
        itemCheckboxes.forEach(cb => {
            const tr = cb.closest('tr');
            if (tr) {
                if (cb.checked) {
                    tr.classList.add('bg-blue-50/70');
                } else {
                    tr.classList.remove('bg-blue-50/70');
                }
            }
        });
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            itemCheckboxes.forEach(cb => {
                cb.checked = selectAll.checked;
            });
            updateBulkBar();
        });
    }

    itemCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateBulkBar);
    });

    if (btnCancel) {
        btnCancel.addEventListener('click', function() {
            if (selectAll) selectAll.checked = false;
            itemCheckboxes.forEach(cb => cb.checked = false);
            updateBulkBar();
        });
    }

    if (btnBulkDelete) {
        btnBulkDelete.addEventListener('click', function(e) {
            const checkedBoxes = document.querySelectorAll('.barang-item-checkbox:checked');
            if (checkedBoxes.length === 0) return;

            bulkDeleteInputs.innerHTML = '';
            checkedBoxes.forEach(cb => {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'ids[]';
                hidden.value = cb.value;
                bulkDeleteInputs.appendChild(hidden);
            });

            if (typeof confirmDelete === 'function') {
                confirmDelete(e, `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} barang yang dipilih secara permanen?`);
            } else {
                if (confirm(`Apakah Anda yakin ingin menghapus ${checkedBoxes.length} barang yang dipilih?`)) {
                    document.getElementById('bulkDeleteForm').submit();
                }
            }
        });
    }
});
</script>
@endsection