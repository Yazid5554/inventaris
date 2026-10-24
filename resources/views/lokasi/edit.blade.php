@extends('layouts.app')

@section('title', 'Edit Ruangan')

@section('content')
<div class="h-full flex-1 overflow-y-auto pb-8 custom-scrollbar">
    <div class="max-w-3xl mx-auto w-full">
        {{-- Header --}}
        <div class="flex items-center gap-4 mb-6 animate-card" style="animation-delay: 0ms;">
            <a href="{{ route('lokasi.index') }}" class="p-2 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-[#2548cc] hover:border-[#2548cc] hover:bg-blue-50 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-[#1a2f6e]">Edit Ruangan</h1>
                <p class="text-sm text-gray-500 mt-1">Perbarui data lokasi ruangan inventaris.</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 animate-card" style="animation-delay: 100ms;">
            <form method="POST" action="{{ route('lokasi.update', $lokasi) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Ruangan --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                        Nama Ruangan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $lokasi->nama) }}" required
                        placeholder="Dapur, Lab Komputer, Ruang Rapat, dll"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white @error('nama') border-red-400 bg-red-50 @enderror">
                    @error('nama')
                    <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Gedung & Lantai --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Gedung</label>
                        <input type="text" name="gedung" value="{{ old('gedung', $lokasi->gedung) }}"
                            placeholder="A, B, C, dll"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Lantai</label>
                        <input type="text" name="lantai" value="{{ old('lantai', $lokasi->lantai) }}"
                            placeholder="01, 02, 03, dll"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white">
                    </div>
                </div>

                {{-- Jenis Ruangan --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jenis Ruangan</label>
                    <input type="text" name="jenis" value="{{ old('jenis', $lokasi->jenis) }}"
                        placeholder="Lab, Gudang, Ruang Kelas, dll"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white">
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Keterangan</label>
                    <textarea name="keterangan" rows="4"
                        placeholder="Keterangan tambahan mengenai ruangan..."
                        class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white resize-none">{{ old('keterangan', $lokasi->keterangan) }}</textarea>
                </div>

                {{-- Footer Actions --}}
                <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('lokasi.index') }}"
                        class="px-6 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-[#2548cc] text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-blue-800 hover:-translate-y-0.5 hover:shadow-md transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection