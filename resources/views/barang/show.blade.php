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

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 animate-card" style="animation-delay: 0ms;">
        <div class="flex items-center gap-4">
            <a href="{{ auth()->check() ? route('barang.index') : route('login') }}" class="p-2 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-[#2548cc] hover:border-[#2548cc] hover:bg-blue-50 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-[#1a2f6e] flex items-center gap-2">
                    {{ $barang->nama }}
                    @guest
                    <span class="bg-blue-50 text-[#2548cc] text-xs font-bold px-2.5 py-1 rounded-full border border-blue-200/60">👁️ Detail Publik</span>
                    @endguest
                </h1>
                <p class="text-sm text-gray-500 mt-1">Detail informasi, kondisi, dan riwayat perbaikan inventaris.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @auth
            <a href="{{ route('barang.print-qr', $barang) }}"
                class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Print QR
            </a>
            <a href="{{ route('barang.edit', $barang) }}"
                class="bg-amber-400 text-amber-900 px-4 py-2 rounded-xl text-sm font-semibold hover:bg-amber-500 hover:-translate-y-0.5 transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                Edit
            </a>
            <form method="POST" action="{{ route('barang.destroy', $barang) }}" onsubmit="return confirmDelete(event, 'Hapus barang {{ $barang->nama }} secara permanen?')" class="m-0">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-red-600 hover:-translate-y-0.5 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    Hapus
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="bg-[#2548cc] hover:bg-blue-800 text-white px-4 py-2 rounded-xl text-xs font-bold shadow-sm transition flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                <span>Login Admin</span>
            </a>
            @endauth
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
                            <p class="font-medium text-gray-900">Gedung {{ strtoupper($barang->lokasi->gedung ?? 'Main') }} — Lt. {{ $barang->lokasi->lantai ?? '1' }}</p>
                        @else
                            <p class="font-medium text-gray-400 italic">-</p>
                        @endif
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Sumber Dana</p>
                        <p class="font-medium text-gray-900">{{ $barang->sumber_dana ?? '-' }}</p>
                    </div>
                    
                    <div class="col-span-2 md:col-span-1">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Status Utama</p>
                        @php
                            $latestKondisi = $barang->riwayatKondisi->first()?->kondisi ?? 'baik';
                        @endphp
                        @if($latestKondisi === 'baik')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Kondisi Baik & Normal
                            </span>
                        @elseif($latestKondisi === 'rusak_ringan')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Rusak Ringan
                            </span>
                        @elseif($latestKondisi === 'dalam_perbaikan')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Dalam Perbaikan / Servis
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                <span class="w-2 h-2 rounded-full bg-red-500"></span> Rusak Berat / Afkir
                            </span>
                        @endif
                    </div>
                </div>

                @if($barang->spesifikasi)
                <div class="mt-6 pt-5 border-t border-gray-100">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Spesifikasi / Catatan Tambahan</p>
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 text-sm text-gray-700 leading-relaxed">
                        {{ $barang->spesifikasi }}
                    </div>
                </div>
                @endif
            </div>

            {{-- Komponen / Aset Pendukung --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-card" style="animation-delay: 200ms;">
                <h2 class="font-extrabold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#2548cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    Komponen & Aset Pendukung
                </h2>

                <div class="overflow-x-auto rounded-xl border border-gray-100">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-gray-50 text-gray-500 font-bold uppercase tracking-wider border-b border-gray-100">
                            <tr>
                                <th class="px-4 py-3">Jenis Komponen</th>
                                <th class="px-4 py-3">Merek / Spesifikasi</th>
                                <th class="px-4 py-3">Kondisi</th>
                                @auth
                                <th class="px-4 py-3 text-right">Aksi</th>
                                @endauth
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse($barang->komponen as $k)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-4 py-3 font-semibold text-gray-900">{{ $k->jenis_komponen }}</td>
                                <td class="px-4 py-3">
                                    <p class="font-medium text-gray-800">{{ $k->merek ?? '-' }}</p>
                                    @if($k->spesifikasi)
                                        <p class="text-[11px] text-gray-400 mt-0.5">{{ $k->spesifikasi }}</p>
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
                                @auth
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="toggleEdit({{ $k->id }})" class="p-1.5 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        </button>
                                        <form method="POST" action="{{ route('komponen.destroy', $k) }}" onsubmit="return confirmDelete(event, 'Hapus komponen {{ $k->jenis_komponen }}?')" class="m-0">
                                            @csrf @method('DELETE')
                                            <button class="p-1.5 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                @endauth
                            </tr>
                            @auth
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
                            @endauth
                            @empty
                            <tr>
                                <td colspan="{{ auth()->check() ? '4' : '3' }}" class="px-4 py-8 text-center text-gray-400 text-sm italic">
                                    Belum ada komponen atau aset pendukung.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Riwayat Kondisi & Servis Terpadu --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-card" style="animation-delay: 300ms;">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="font-extrabold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#2548cc]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        Riwayat Kondisi & Servis
                    </h2>
                    <span class="text-xs text-gray-400 font-medium">Log Historis</span>
                </div>
                
                @if($barang->riwayatKondisi->isEmpty())
                <div class="text-center py-8 border border-dashed border-gray-200 rounded-xl bg-gray-50/50">
                    <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-gray-500 text-xs font-medium">Belum ada catatan riwayat kondisi atau perbaikan.</p>
                </div>
                @else
                <div class="relative border-l-2 border-blue-100 ml-3 space-y-6">
                    @php
                    $kondisiConfig = [
                        'baik'              => ['label' => 'Baik / Normal', 'class' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'bg' => 'bg-emerald-50 border-emerald-100', 'icon' => '✅'],
                        'rusak_ringan'      => ['label' => 'Rusak Ringan', 'class' => 'bg-amber-400', 'text' => 'text-amber-800', 'bg' => 'bg-amber-50 border-amber-100', 'icon' => '⚠️'],
                        'rusak_berat'       => ['label' => 'Rusak Berat', 'class' => 'bg-red-500', 'text' => 'text-red-700', 'bg' => 'bg-red-50 border-red-100', 'icon' => '❌'],
                        'dalam_perbaikan'   => ['label' => 'Dalam Perbaikan / Servis', 'class' => 'bg-blue-500', 'text' => 'text-blue-700', 'bg' => 'bg-blue-50 border-blue-100', 'icon' => '🔧'],
                        'tidak_layak_pakai' => ['label' => 'Tidak Layak Pakai (Afkir)', 'class' => 'bg-gray-700', 'text' => 'text-gray-800', 'bg' => 'bg-gray-100 border-gray-200', 'icon' => '🚫'],
                    ];
                    @endphp

                    @foreach($barang->riwayatKondisi as $r)
                    @php
                        $cfg = $kondisiConfig[$r->kondisi] ?? ['label' => ucfirst($r->kondisi), 'class' => 'bg-gray-400', 'text' => 'text-gray-700', 'bg' => 'bg-gray-50 border-gray-100', 'icon' => '📌'];
                    @endphp
                    <div class="relative pl-6 group">
                        <span class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full border-2 border-white {{ $cfg['class'] }} shadow-sm"></span>
                        
                        <div class="bg-gray-50/70 rounded-xl p-4 border border-gray-100 group-hover:bg-white group-hover:border-blue-100 transition-all">
                            <div class="flex items-center justify-between gap-2 mb-1.5">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $cfg['bg'] }} {{ $cfg['text'] }}">
                                    <span>{{ $cfg['icon'] }}</span>
                                    <span>{{ $cfg['label'] }}</span>
                                </span>
                                <span class="text-[11px] text-gray-400 font-mono">
                                    {{ \Carbon\Carbon::parse($r->tanggal_pencatatan)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                            
                            @if($r->catatan)
                            <p class="text-xs text-gray-700 mt-2 leading-relaxed bg-white p-2.5 rounded-lg border border-gray-100/80">
                                {{ $r->catatan }}
                            </p>
                            @endif
                            
                            <div class="flex items-center justify-between mt-2.5 pt-2 border-t border-gray-100 text-[11px] text-gray-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    Dicatat oleh: <strong class="text-gray-600 font-semibold">{{ $r->pengguna?->name ?? 'Sistem Admin' }}</strong>
                                </span>
                                
                                @auth
                                <form method="POST" action="{{ route('kondisi.destroy', $r) }}" onsubmit="return confirmDelete(event, 'Hapus riwayat kondisi ini?')" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf @method('DELETE')
                                    <button class="text-[11px] text-red-500 hover:text-red-700 hover:underline font-medium">Hapus Log</button>
                                </form>
                                @endauth
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
            
            {{-- Update Kondisi & Servis Cepat --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 animate-card" style="animation-delay: 150ms;">
                <h3 class="font-extrabold text-gray-900 mb-1">Update Kondisi & Servis</h3>
                @auth
                <p class="text-[11px] text-gray-500 mb-4 leading-relaxed">Perbarui status barang saat inspeksi rutin atau setelah tindakan servis.</p>
                <form method="POST" action="{{ route('kondisi.store', $barang) }}" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Status Barang <span class="text-red-500">*</span></label>
                        <select name="kondisi" required class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-gray-50 focus:bg-white transition-colors cursor-pointer font-medium">
                            <option value="">Pilih status terbaru...</option>
                            <option value="baik">✅ Kondisi Baik & Normal</option>
                            <option value="rusak_ringan">⚠️ Rusak Ringan (Masih Bisa Dipakai)</option>
                            <option value="rusak_berat">❌ Rusak Berat (Perlu Perbaikan)</option>
                            <option value="dalam_perbaikan">🔧 Sedang Dalam Perbaikan / Servis</option>
                            <option value="tidak_layak_pakai">🚫 Tidak Layak Pakai (Afkir)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Tanggal Update <span class="text-red-500">*</span></label>
                        <input type="date" name="tanggal_pencatatan" value="{{ date('Y-m-d') }}" required class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-gray-50 focus:bg-white transition-colors">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Catatan / Tindakan Servis</label>
                        <textarea name="catatan" rows="3" placeholder="Tuliskan keluhan kerusakan, hasil inspeksi, atau tindakan servis jika ada..." class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] bg-gray-50 focus:bg-white transition-colors resize-none"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#2548cc] text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-blue-800 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        Simpan Perubahan Status
                    </button>
                </form>
                @else
                <p class="text-xs text-gray-500 mb-3 leading-relaxed">Anda sedang melihat detail inventaris sebagai <b>Pengunjung (Publik)</b>.</p>
                <div class="p-3.5 bg-blue-50/70 rounded-xl border border-blue-100 text-xs text-blue-900 flex items-start gap-2.5">
                    <svg class="w-5 h-5 text-[#2548cc] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <div>
                        <p class="font-bold">Info Hak Akses Admin:</p>
                        <p class="mt-0.5 text-blue-800">Untuk memperbarui status kondisi, mengedit data, atau mencetak QR, silakan <a href="{{ route('login') }}" class="underline font-bold text-[#2548cc]">Login Admin</a>.</p>
                    </div>
                </div>
                @endauth
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
                            <button type="button" onclick="openImageModal('{{ Storage::url($barang->foto) }}', '{{ e($barang->nama) }}')" class="bg-white/90 text-gray-900 px-3 py-1.5 rounded-lg text-xs font-bold backdrop-blur-sm shadow-lg hover:bg-white transition cursor-pointer">Lihat Penuh</button>
                        </div>
                    </div>
                @else
                    @auth
                    <form action="{{ route('barang.upload-foto', $barang) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div class="relative group cursor-pointer">
                            <input type="file" name="foto" id="detail-foto-input" accept="image/*" onchange="previewDetailFoto(this)" required
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <div id="detail-dropzone" class="rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 flex flex-col items-center justify-center py-6 px-4 text-center group-hover:border-[#2548cc] group-hover:bg-blue-50/40 transition-all">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-[#2548cc] mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <p class="text-xs font-semibold text-gray-700">Upload Foto Barang</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">Klik atau drag foto di sini (Max 2MB)</p>
                            </div>

                            <div id="detail-preview-container" class="hidden relative h-36 border border-blue-200 rounded-xl overflow-hidden bg-blue-50/30 p-1 flex items-center justify-center">
                                <img id="detail-image-preview" src="#" alt="Preview" class="h-full w-full object-contain rounded-lg">
                            </div>
                        </div>

                        <button type="submit" id="detail-submit-btn" disabled
                            class="w-full bg-[#2548cc] text-white py-2 rounded-xl text-xs font-semibold shadow-sm hover:bg-blue-800 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                            Simpan Foto
                        </button>
                    </form>
                    @else
                    <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50/70 p-6 text-center text-gray-400 text-xs">
                        <svg class="w-8 h-8 text-gray-300 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span>Belum ada foto visual yang diunggah.</span>
                    </div>
                    @endauth
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
                
                @auth
                <a href="{{ route('barang.print-qr', $barang) }}"
                    class="block w-full bg-white text-[#1a2f6e] py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-blue-50 transition-colors relative z-10">
                    Cetak Label QR
                </a>
                @endauth
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