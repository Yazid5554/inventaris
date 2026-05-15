@extends('layouts.app')

@section('title', $barang->nama . ' — Detail Barang')

@section('content')
<style>
    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(15px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-card {
        animation: fadeSlideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
</style>

<div class="h-full flex-1 overflow-y-auto pb-8 custom-scrollbar">
    <div class="max-w-7xl mx-auto w-full">

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl px-4 py-3 text-sm mb-6 flex justify-between items-center shadow-sm animate-card" style="animation-delay: 0ms;">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('success') }}
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl px-4 py-3 text-sm mb-6 flex justify-between items-center shadow-sm animate-card" style="animation-delay: 0ms;">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('error') }}
        </div>
        <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    </div>
    @endif

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 animate-card" style="animation-delay: 0ms;">
        <div class="flex items-center gap-4">
            <a href="{{ route('barang.index') }}" class="p-2 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-[#2548cc] hover:border-[#2548cc] hover:bg-blue-50 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-[#1a2f6e]">{{ $barang->nama }}</h1>
                <p class="text-sm text-gray-500 mt-1">Detail informasi, kondisi, dan riwayat perbaikan inventaris.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('barang.print-qr', $barang) }}" target="_blank"
                class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Print QR
            </a>
            <a href="{{ route('barang.edit', $barang) }}"
                class="bg-amber-400 text-amber-900 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-amber-500 hover:-translate-y-0.5 transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('barang.destroy', $barang) }}" onsubmit="return confirm('Hapus barang ini secara permanen?')" class="m-0">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-red-600 hover:-translate-y-0.5 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Kolom Kiri (Data Utama) --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Informasi Dasar --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-card" style="animation-delay: 100ms;">
                <h2 class="font-extrabold text-gray-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#2548cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Informasi Barang
                </h2>
                
                <div class="grid grid-cols-2 md:grid-cols-3 gap-y-6 gap-x-4">
                    <div class="col-span-2 md:col-span-1 p-4 bg-blue-50/50 rounded-xl border border-blue-100/50">
                        <p class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-1">Nomor Inventaris</p>
                        <p class="font-mono text-[#2548cc] font-medium break-all">{{ $barang->nomor_inventaris ?? '-' }}</p>
                    </div>
                    <div class="col-span-2 md:col-span-1 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Kode Barang</p>
                        <p class="font-medium text-gray-900">{{ $barang->kode_barang ?? '-' }}</p>
                    </div>
                    <div class="col-span-2 md:col-span-1 p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Jenis Barang</p>
                        <p class="font-medium text-gray-900">{{ $barang->jenis_barang ?? '-' }}</p>
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Pengadaan</p>
                        <p class="font-medium text-gray-900">
                            @if($barang->tanggal_pengadaan)
                                {{ \Carbon\Carbon::parse($barang->tanggal_pengadaan)->translatedFormat('d F Y') }}
                            @elseif($barang->tahun_pengadaan)
                                {{ $barang->tahun_pengadaan }}
                            @else
                                <span class="text-gray-400 italic">Belum diatur</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Ruangan / Lokasi</p>
                        <p class="font-medium text-gray-900">{{ $barang->lokasi?->nama ?? '-' }}</p>
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Gedung / Lantai</p>
                        @if($barang->lokasi)
                            <div class="flex items-center gap-2 mt-1">
                                <span class="px-2 py-0.5 rounded-md text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-100">
                                    {{ $barang->lokasi->gedung ? 'GD. ' . strtoupper($barang->lokasi->gedung) : '-' }}
                                </span>
                                <span class="px-2 py-0.5 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    Lt. {{ $barang->lokasi->lantai ?? '-' }}
                                </span>
                            </div>
                        @else
                            <p class="font-medium text-gray-900">-</p>
                        @endif
                    </div>
                    
                    @if($barang->keterangan)
                    <div class="col-span-2 md:col-span-3 pt-4 border-t border-gray-100 mt-2">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Keterangan Tambahan</p>
                        <p class="text-sm text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-100">{{ $barang->keterangan }}</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Komponen / Aset Pendukung --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-card" style="animation-delay: 200ms;">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-extrabold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#2548cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        Komponen & Aset Pendukung
                    </h2>
                    <span class="px-2.5 py-1 bg-blue-50 text-[#2548cc] rounded-full text-xs font-bold border border-blue-100">{{ $barang->komponen->count() }} Item</span>
                </div>
                
                <form method="POST" action="{{ route('komponen.store', $barang) }}" class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-3">
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Jenis Komponen <span class="text-red-500">*</span></label>
                            <input type="text" name="jenis_komponen" required placeholder="Remote, RAM, Adaptor..."
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Merek</label>
                            <input type="text" name="merek" placeholder="Merek..."
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc]">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Kondisi <span class="text-red-500">*</span></label>
                            <select name="kondisi" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-white">
                                <option value="baik">✅ Baik</option>
                                <option value="rusak">❌ Rusak</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Spesifikasi</label>
                            <input type="text" name="spesifikasi" placeholder="Spesifikasi teknis..."
                                class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc]">
                        </div>
                        <div class="md:col-span-2 flex items-end gap-3">
                            <div class="flex-1">
                                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Catatan</label>
                                <input type="text" name="catatan" placeholder="Opsional..."
                                    class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc]">
                            </div>
                            <button type="submit" class="bg-[#2548cc] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-800 transition-colors shrink-0 flex items-center gap-2 h-[38px]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Tambah
                            </button>
                        </div>
                    </div>
                </form>

                <div class="border border-gray-100 rounded-xl overflow-hidden">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 border-b border-gray-100 text-xs text-gray-500 uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Komponen</th>
                                <th class="px-4 py-3 font-semibold">Spesifikasi</th>
                                <th class="px-4 py-3 font-semibold">Kondisi</th>
                                <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($barang->komponen as $k)
                            <tr class="hover:bg-gray-50/50 transition-colors" id="komponen-{{ $k->id }}">
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-gray-900">{{ $k->jenis_komponen }}</p>
                                    @if($k->merek)
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $k->merek }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <p class="text-gray-700">{{ $k->spesifikasi ?? '-' }}</p>
                                    @if($k->catatan)
                                    <p class="text-[11px] text-gray-400 mt-0.5">{{ $k->catatan }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($k->kondisi === 'baik')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Baik
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Rusak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="toggleEdit({{ $k->id }})" class="p-1.5 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        <form method="POST" action="{{ route('komponen.destroy', $k) }}" onsubmit="return confirm('Hapus komponen ini?')" class="m-0">
                                            @csrf @method('DELETE')
                                            <button class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <tr id="edit-{{ $k->id }}" class="hidden bg-blue-50/50 border-b border-gray-100">
                                <td colspan="4" class="px-4 py-4">
                                    <form method="POST" action="{{ route('komponen.update', $k) }}">
                                        @csrf @method('PATCH')
                                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-3">
                                            <div class="md:col-span-2">
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Jenis</label>
                                                <input type="text" name="jenis_komponen" value="{{ $k->jenis_komponen }}" class="w-full border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc]">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Merek</label>
                                                <input type="text" name="merek" value="{{ $k->merek }}" class="w-full border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc]">
                                            </div>
                                            <div class="md:col-span-2">
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Spesifikasi</label>
                                                <input type="text" name="spesifikasi" value="{{ $k->spesifikasi }}" class="w-full border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc]">
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                                            <div class="md:col-span-2">
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Kondisi</label>
                                                <select name="kondisi" class="w-full border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-white">
                                                    <option value="baik" {{ $k->kondisi === 'baik'  ? 'selected' : '' }}>✅ Baik</option>
                                                    <option value="rusak" {{ $k->kondisi === 'rusak' ? 'selected' : '' }}>❌ Rusak</option>
                                                </select>
                                            </div>
                                            <div class="md:col-span-3 flex items-end gap-2">
                                                <div class="flex-1">
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Catatan</label>
                                                    <input type="text" name="catatan" value="{{ $k->catatan }}" class="w-full border border-gray-200 rounded-lg px-2.5 py-1.5 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc]">
                                                </div>
                                                <div class="flex gap-2 shrink-0">
                                                    <button type="submit" class="bg-[#2548cc] text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-800 transition-colors h-[34px]">Simpan</button>
                                                    <button type="button" onclick="toggleEdit({{ $k->id }})" class="bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-300 transition-colors h-[34px]">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm italic">
                                    Belum ada komponen atau aset pendukung.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Riwayat Kondisi --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-card" style="animation-delay: 300ms;">
                <h2 class="font-extrabold text-gray-900 mb-5 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#2548cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    Riwayat Kondisi Barang
                </h2>
                
                @if($barang->riwayatKondisi->isEmpty())
                <div class="text-center py-6 border border-dashed border-gray-200 rounded-xl bg-gray-50">
                    <p class="text-gray-400 text-sm italic">Belum ada catatan riwayat kondisi.</p>
                </div>
                @else
                <div class="relative border-l-2 border-blue-100 ml-3 space-y-6">
                    @php
                    $kondisiConfig = [
                        'baik' => ['label' => 'Baik', 'class' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'bg' => 'bg-emerald-50 border-emerald-100'],
                        'rusak_ringan' => ['label' => 'Rusak Ringan', 'class' => 'bg-amber-400', 'text' => 'text-amber-800', 'bg' => 'bg-amber-50 border-amber-100'],
                        'rusak_berat' => ['label' => 'Rusak Berat', 'class' => 'bg-red-500', 'text' => 'text-red-700', 'bg' => 'bg-red-50 border-red-100'],
                        'dalam_perbaikan' => ['label' => 'Dalam Perbaikan', 'class' => 'bg-blue-500', 'text' => 'text-blue-700', 'bg' => 'bg-blue-50 border-blue-100'],
                        'tidak_layak_pakai' => ['label' => 'Tidak Layak Pakai', 'class' => 'bg-gray-500', 'text' => 'text-gray-700', 'bg' => 'bg-gray-100 border-gray-200'],
                    ];
                    @endphp
                    @foreach($barang->riwayatKondisi as $r)
                    @php $cfg = $kondisiConfig[$r->kondisi] ?? ['label' => $r->kondisi, 'class' => 'bg-gray-400', 'text' => 'text-gray-600', 'bg' => 'bg-gray-50 border-gray-100']; @endphp
                    
                    <div class="relative pl-6">
                        {{-- Timeline Dot --}}
                        <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-4 border-white {{ $cfg['class'] }} shadow-sm"></div>
                        
                        <div class="p-4 rounded-xl border {{ $cfg['bg'] }} relative group">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-sm font-bold {{ $cfg['text'] }}">{{ $cfg['label'] }}</span>
                                <span class="text-[11px] text-gray-500 font-medium bg-white px-2 py-0.5 rounded-full shadow-sm border border-gray-100">
                                    {{ \Carbon\Carbon::parse($r->tanggal_pencatatan)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            
                            @if($r->catatan)
                            <p class="text-sm text-gray-700 mb-2">{{ $r->catatan }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between mt-2 pt-2 border-t border-black/5">
                                <span class="text-[11px] text-gray-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    {{ $r->pengguna?->name ?? 'Sistem' }}
                                </span>
                                
                                <form method="POST" action="{{ route('kondisi.destroy', $r) }}" onsubmit="return confirm('Hapus riwayat kondisi ini?')" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf @method('DELETE')
                                    <button class="text-[11px] text-red-500 hover:text-red-700 hover:underline font-medium">Hapus Riwayat</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Catatan Perbaikan --}}
            @php
            $kondisiTerkini = $barang->riwayatKondisi->first()?->kondisi;
            $bolehPerbaikan = in_array($kondisiTerkini, ['rusak_ringan', 'rusak_berat', 'dalam_perbaikan', 'tidak_layak_pakai']);
            @endphp

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-card" style="animation-delay: 400ms;">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-extrabold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#2548cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" /></svg>
                        Catatan Perbaikan & Servis
                    </h2>
                    @if(!$bolehPerbaikan)
                    <span class="px-2.5 py-1 bg-gray-100 text-gray-500 rounded-full text-xs font-semibold border border-gray-200">Tidak Perlu</span>
                    @endif
                </div>

                @if($bolehPerbaikan)
                <form method="POST" action="{{ route('perbaikan.store', $barang) }}" class="space-y-4 mb-8 p-5 bg-blue-50/30 rounded-xl border border-blue-100">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Status Perbaikan <span class="text-red-500">*</span></label>
                            <select name="status" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-white">
                                <option value="menunggu">⏳ Menunggu Jadwal</option>
                                <option value="sedang_diperbaiki">🔧 Sedang Dikerjakan</option>
                                <option value="selesai">✅ Selesai Diperbaiki</option>
                                <option value="tidak_bisa_diperbaiki">❌ Gagal / Tidak Bisa Diperbaiki</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_perbaikan" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-white">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Deskripsi Kerusakan <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi_kerusakan" rows="2" required placeholder="Keluhan / masalah yang harus diperbaiki..." class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-white resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Tindakan / Solusi <span class="text-gray-400 font-normal lowercase">(opsional)</span></label>
                        <textarea name="tindakan" rows="2" placeholder="Tindakan yang telah dilakukan teknisi..." class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-white resize-none"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#2548cc] text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-sm hover:bg-blue-800 transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                            Catat Servis
                        </button>
                    </div>
                </form>
                @else
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center text-sm text-gray-500 mb-6 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Barang dalam kondisi baik. Catatan perbaikan hanya tersedia jika barang rusak.
                </div>
                @endif

                @if($barang->perbaikan->isEmpty())
                <div class="text-center py-6 border border-dashed border-gray-200 rounded-xl bg-gray-50">
                    <p class="text-gray-400 text-sm italic">Belum ada catatan perbaikan atau servis historis.</p>
                </div>
                @else
                @php
                $statusConfig = [
                    'menunggu' => ['label' => 'Menunggu', 'class' => 'bg-amber-100 text-amber-800', 'icon' => '⏳'],
                    'sedang_diperbaiki' => ['label' => 'Proses', 'class' => 'bg-blue-100 text-blue-800', 'icon' => '🔧'],
                    'selesai' => ['label' => 'Selesai', 'class' => 'bg-emerald-100 text-emerald-800', 'icon' => '✅'],
                    'tidak_bisa_diperbaiki' => ['label' => 'Gagal', 'class' => 'bg-red-100 text-red-800', 'icon' => '❌'],
                ];
                @endphp
                <div class="space-y-4">
                    @foreach($barang->perbaikan as $p)
                    @php $sc = $statusConfig[$p->status] ?? ['label' => $p->status, 'class' => 'bg-gray-100 text-gray-800', 'icon' => '❓']; @endphp
                    <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-sm hover:border-[#2548cc]/30 transition-colors">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                    <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wider {{ $sc['class'] }} flex items-center gap-1">
                                        {{ $sc['icon'] }} {{ $sc['label'] }}
                                    </span>
                                    <span class="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">
                                        {{ \Carbon\Carbon::parse($p->tanggal_perbaikan)->translatedFormat('d F Y') }}
                                    </span>
                                </div>
                                <div class="space-y-1.5 mt-3">
                                    <div class="grid grid-cols-[100px_1fr] items-start gap-2">
                                        <span class="text-xs font-bold text-gray-500">Masalah</span>
                                        <p class="text-sm text-gray-900">{{ $p->deskripsi_kerusakan }}</p>
                                    </div>
                                    @if($p->tindakan)
                                    <div class="grid grid-cols-[100px_1fr] items-start gap-2">
                                        <span class="text-xs font-bold text-gray-500">Tindakan</span>
                                        <p class="text-sm text-gray-700 bg-gray-50 p-2 rounded-lg border border-gray-100">{{ $p->tindakan }}</p>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                                    <form method="POST" action="{{ route('perbaikan.update', $p) }}" class="flex items-center gap-2">
                                        @csrf @method('PATCH')
                                        <select name="status" class="border border-gray-200 rounded-lg px-2 py-1.5 text-xs focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-gray-50 font-medium">
                                            @foreach($statusConfig as $val => $cfg)
                                            <option value="{{ $val }}" {{ $p->status === $val ? 'selected' : '' }}>
                                                {{ $cfg['label'] }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="bg-white border border-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-50 hover:border-[#2548cc] transition-colors shadow-sm">
                                            Update Status
                                        </button>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('perbaikan.destroy', $p) }}" onsubmit="return confirm('Hapus riwayat servis ini?')" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-[11px] font-medium text-gray-400 hover:text-red-500 transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>

        {{-- Kolom Kanan (Aksi & Media) --}}
        <div class="space-y-6">
            
            {{-- Update Kondisi Cepat --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-card" style="animation-delay: 150ms;">
                <h3 class="font-extrabold text-gray-900 mb-2">Update Kondisi Barang</h3>
                <p class="text-[11px] text-gray-500 mb-4 leading-relaxed">Catat perubahan kondisi saat inspeksi rutin atau jika ditemukan kerusakan.</p>
                <form method="POST" action="{{ route('kondisi.store', $barang) }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Status Kondisi <span class="text-red-500">*</span></label>
                        <select name="kondisi" required class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-gray-50 focus:bg-white transition-colors cursor-pointer">
                            <option value="">Pilih status terbaru...</option>
                            <option value="baik">✅ Kondisi Baik & Normal</option>
                            <option value="rusak_ringan">⚠️ Rusak Ringan (Masih bisa dipakai)</option>
                            <option value="rusak_berat">❌ Rusak Berat (Perlu servis)</option>
                            <option value="dalam_perbaikan">🔧 Sedang Dalam Perbaikan</option>
                            <option value="tidak_layak_pakai">🚫 Tidak Layak Pakai (Afkir)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Inspeksi <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_pencatatan" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-gray-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Catatan Tambahan</label>
                        <textarea name="catatan" rows="2" placeholder="Detail kondisi saat ini..." class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-gray-50 focus:bg-white transition-colors resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gray-900 text-white px-4 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-black transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Simpan Kondisi
                    </button>
                </form>
            </div>

            {{-- Foto Barang --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 animate-card" style="animation-delay: 250ms;">
                <h3 class="font-extrabold text-gray-900 mb-3 flex items-center gap-2 text-sm uppercase tracking-wider">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Foto Visual
                </h3>
                @if($barang->foto)
                    <div class="rounded-xl overflow-hidden border border-gray-200 bg-gray-100 group relative">
                        <img src="{{ Storage::url($barang->foto) }}" class="w-full aspect-video object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $barang->nama }}">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <a href="{{ Storage::url($barang->foto) }}" target="_blank" class="bg-white/90 text-gray-900 px-3 py-1.5 rounded-lg text-xs font-bold backdrop-blur-sm shadow-lg">Lihat Penuh</a>
                        </div>
                    </div>
                @else
                    <div class="rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center py-10">
                        <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <p class="text-xs text-gray-400 font-medium">Belum ada foto</p>
                    </div>
                @endif
            </div>

            {{-- Label QR Code --}}
            <div class="bg-[#1a2f6e] rounded-2xl border border-blue-800 shadow-md p-6 text-center animate-card relative overflow-hidden" style="animation-delay: 350ms;">
                {{-- Background Pattern --}}
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-5 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-blue-400 opacity-10 rounded-full blur-2xl pointer-events-none"></div>
                
                <h3 class="font-extrabold text-white mb-1 text-sm uppercase tracking-wider relative z-10">Label QR Code</h3>
                <p class="text-[11px] text-blue-200 mb-5 relative z-10">Scan untuk melihat detail barang via mobile</p>
                
                <div class="bg-white p-3 rounded-xl inline-block shadow-xl relative z-10 mb-4 group">
                    <div class="border border-gray-100 rounded-lg overflow-hidden group-hover:border-blue-200 transition-colors">
                        <img src="{{ route('barang.qr', $barang) }}" class="w-40 h-40 object-contain p-2" alt="QR Code">
                    </div>
                </div>
                
                <a href="{{ route('barang.print-qr', $barang) }}" target="_blank"
                    class="block w-full bg-white text-[#1a2f6e] py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-blue-50 transition-colors relative z-10">
                    Cetak Label QR
                </a>
            </div>

        </div>
    </div>
</div>

<script>
    function toggleEdit(id) {
        const row = document.getElementById('edit-' + id);
        if(row.classList.contains('hidden')) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
        }
    }
</script>
@endsection