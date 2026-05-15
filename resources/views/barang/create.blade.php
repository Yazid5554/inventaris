@extends('layouts.app')

@section('title', 'Tambah Barang')

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
    <div class="max-w-5xl mx-auto w-full">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-6 animate-card" style="animation-delay: 0ms;">
        <a href="{{ route('barang.index') }}" class="p-2 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-[#2548cc] hover:border-[#2548cc] hover:bg-blue-50 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-[#1a2f6e]">Tambah Barang</h1>
            <p class="text-sm text-gray-500 mt-1">Tambahkan data inventaris baru ke sistem.</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 animate-card" style="animation-delay: 100ms;">
        <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Kolom Kiri --}}
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Barang --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Barang <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Kulkas, Laptop, Meja, dll"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white @error('nama') border-red-400 bg-red-50 @enderror">
                            @error('nama')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                        </div>

                        {{-- Kode Barang --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kode Barang <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_barang" value="{{ old('kode_barang') }}" placeholder="KL, LT, MJ, dll"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white @error('kode_barang') border-red-400 bg-red-50 @enderror">
                            @error('kode_barang')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- No Inventaris --}}
                    <div class="p-4 bg-blue-50/50 border border-blue-100 rounded-xl">
                        <label class="block text-xs font-bold text-[#1a2f6e] uppercase tracking-wider mb-1">
                            Nomor Inventaris
                        </label>
                        <p class="text-[11px] text-blue-600 mb-2">Otomatis digenerate setelah barang disimpan dengan format standar sistem.</p>
                        <div class="w-full border border-dashed border-blue-200 rounded-lg px-4 py-2 text-sm bg-white text-gray-400 font-mono italic">
                            {Gedung}-{Lantai}-{Tahun}-{Ruangan}-{Kode}-{No}/{Total}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Jenis Barang --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jenis Barang</label>
                            <input type="text" name="jenis_barang" value="{{ old('jenis_barang') }}" placeholder="Elektronik, Furnitur, dll"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white">
                        </div>

                        {{-- Tanggal Pengadaan --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Pengadaan</label>
                            <input type="date" name="tanggal_pengadaan" value="{{ old('tanggal_pengadaan') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white text-gray-700">
                        </div>
                    </div>

                    {{-- Ruangan --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Ruangan (Lokasi)</label>
                        <div class="relative">
                            <select name="id_lokasi"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                                <option value="">Pilih ruangan lokasi inventaris...</option>
                                @foreach($lokasis as $l)
                                <option value="{{ $l->id }}" {{ old('id_lokasi') == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama }}
                                    @if($l->gedung || $l->lantai)
                                    (Gd. {{ strtoupper($l->gedung ?? '-') }} / Lt. {{ $l->lantai ?? '-' }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="space-y-6">
                    {{-- Keterangan --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Keterangan Tambahan</label>
                        <textarea name="keterangan" rows="6" placeholder="Spesifikasi atau informasi detail mengenai barang..."
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white resize-none">{{ old('keterangan') }}</textarea>
                    </div>

                    {{-- Foto --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Foto Barang</label>
                        <div class="relative group cursor-pointer h-56">
                            <input type="file" name="foto" accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="h-full flex flex-col justify-center border-2 border-dashed border-gray-300 rounded-xl px-4 text-center group-hover:border-[#2548cc] transition-colors bg-gray-50 group-hover:bg-blue-50/50 @error('foto') border-red-400 bg-red-50 @enderror">
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-[#2548cc] mb-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-700">Klik atau drag gambar ke area ini</p>
                                <p class="text-[11px] text-gray-500 mt-1">Format JPG, PNG, atau WEBP. Maksimal 2MB.</p>
                            </div>
                        </div>
                        @error('foto')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('barang.index') }}"
                    class="px-6 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="bg-[#2548cc] text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-blue-800 hover:-translate-y-0.5 hover:shadow-md transition-all duration-300 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Barang
                </button>
            </div>
        </form>
    </div>
    </div>
</div>
@endsection