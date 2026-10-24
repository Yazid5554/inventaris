@extends('layouts.app')

@section('title', 'Edit Barang')

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
        <a href="{{ route('barang.show', $barang) }}" class="p-2 rounded-xl bg-white border border-gray-200 text-gray-500 hover:text-[#2548cc] hover:border-[#2548cc] hover:bg-blue-50 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-[#1a2f6e]">Edit Barang</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui data inventaris yang sudah ada.</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 animate-card" style="animation-delay: 100ms;">
        <form method="POST" action="{{ route('barang.update', $barang) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Kolom Kiri --}}
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Barang --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Barang <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="input-nama" value="{{ old('nama', $barang->nama) }}" placeholder="Kulkas, Laptop, Meja, dll"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white @error('nama') border-red-400 bg-red-50 @enderror">
                            @error('nama')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                        </div>

                        {{-- Kode Barang --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kode Barang <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_barang" id="input-kode" value="{{ old('kode_barang', $barang->kode_barang) }}" placeholder="KL, LT, MJ, dll"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white uppercase font-mono @error('kode_barang') border-red-400 bg-red-50 @enderror">
                            @error('kode_barang')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- No Inventaris Live Box --}}
                    <div class="p-4 bg-gradient-to-r from-blue-50/70 to-indigo-50/50 border border-blue-100 rounded-2xl shadow-sm transition-all">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-extrabold text-[#1a2f6e] uppercase tracking-wider flex items-center gap-1.5">
                                <span>Nomor Inventaris</span>
                                <span id="badge-live-status" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Tersimpan
                                </span>
                            </label>
                            <span id="badge-urutan" class="text-[11px] font-mono font-bold text-blue-600 bg-white/80 px-2 py-0.5 rounded-md border border-blue-100 shadow-2xs">
                                Urutan: {{ preg_match('/(\d{3}\/\d{3})$/', $barang->nomor_inventaris ?? '', $m) ? $m[1] : '-' }}
                            </span>
                        </div>
                        <p class="text-[11px] text-gray-500 mb-2">Nomor inventaris otomatis tersinkronisasi jika data ruangan, kode, atau tahun diubah.</p>
                        
                        <div class="relative flex items-center">
                            <input type="text" id="nomor-inventaris-preview" readonly
                                value="{{ $barang->nomor_inventaris ?? '{Gedung}-{Lantai}-' . date('Y') . '-{Ruangan}-{Kode}-001/001' }}"
                                class="w-full bg-white border border-blue-200 text-[#1a2f6e] font-mono font-bold text-xs sm:text-sm px-3.5 py-2.5 rounded-xl shadow-xs focus:outline-none select-all transition-all tracking-wide">
                            <button type="button" id="btn-copy-no-inv" onclick="copyNomorInventaris()" title="Salin Nomor Inventaris"
                                class="absolute right-1.5 px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-[#2548cc] rounded-lg text-xs font-semibold flex items-center gap-1 transition cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span id="copy-text">Salin</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Jenis Barang --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Jenis Barang</label>
                            <input type="text" name="jenis_barang" id="input-jenis" value="{{ old('jenis_barang', $barang->jenis_barang) }}" placeholder="Elektronik, Furnitur, dll"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white">
                        </div>

                        {{-- Tanggal Pengadaan --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Pengadaan</label>
                            <input type="date" name="tanggal_pengadaan" id="input-tanggal" value="{{ old('tanggal_pengadaan', $barang->tanggal_pengadaan) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white text-gray-700">
                        </div>
                    </div>

                    {{-- Ruangan --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Ruangan (Lokasi)</label>
                        <div class="relative">
                            <select name="id_lokasi" id="select-lokasi"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white appearance-none cursor-pointer">
                                <option value="" data-gedung="{Gedung}" data-lantai="{Lantai}" data-nama="{Ruangan}">Pilih ruangan lokasi inventaris...</option>
                                @foreach($lokasis as $l)
                                <option value="{{ $l->id }}"
                                    data-gedung="{{ strtoupper($l->gedung ?? 'X') }}"
                                    data-lantai="{{ $l->lantai ?? '00' }}"
                                    data-nama="{{ strtoupper($l->nama ?? 'X') }}"
                                    {{ old('id_lokasi', $barang->id_lokasi) == $l->id ? 'selected' : '' }}>
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
                            class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white resize-none">{{ old('keterangan', $barang->keterangan) }}</textarea>
                    </div>

                    {{-- Foto --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Foto Barang</label>

                        <div class="relative group cursor-pointer min-h-[220px]">
                            <input type="file" name="foto" id="foto-input" accept="image/*" onchange="previewImage(this)"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            {{-- Placeholder Dropzone (hanya jika belum ada foto & belum ada preview baru) --}}
                            <div id="dropzone-placeholder" class="h-56 {{ $barang->foto ? 'hidden' : 'flex' }} flex-col justify-center border-2 border-dashed border-gray-300 rounded-xl px-4 text-center group-hover:border-[#2548cc] transition-colors bg-gray-50 group-hover:bg-blue-50/50 @error('foto') border-red-400 bg-red-50 @enderror">
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-[#2548cc] mb-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-700">Klik atau drag gambar baru di sini</p>
                                <p class="text-[11px] text-gray-500 mt-1">Kosongkan jika tidak ingin mengganti foto.</p>
                            </div>

                            {{-- Image Preview Container (Muncul jika ada foto lama atau foto baru terpilih) --}}
                            <div id="preview-container" class="{{ $barang->foto ? 'flex' : 'hidden' }} relative h-56 border-2 border-solid border-[#2548cc]/30 rounded-xl p-2 bg-blue-50/30 items-center justify-center overflow-hidden">
                                <img id="image-preview" src="{{ $barang->foto ? Storage::url($barang->foto) : '#' }}" alt="Preview" class="h-full w-full object-contain rounded-lg">
                                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 bg-black/70 text-white text-xs px-3 py-1.5 rounded-full backdrop-blur-sm pointer-events-none flex items-center gap-1.5 shadow-lg">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    <span id="preview-text">{{ $barang->foto ? 'Klik untuk mengganti foto' : 'Klik untuk ganti gambar' }}</span>
                                </div>
                            </div>
                        </div>
                        @error('foto')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('barang.show', $barang) }}"
                    class="px-6 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                <button type="submit"
                    class="bg-[#2548cc] text-white px-6 py-2.5 rounded-xl text-sm font-semibold shadow-sm hover:bg-blue-800 hover:-translate-y-0.5 hover:shadow-md transition-all duration-300 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    </div>
</div>
<script>
function previewImage(input) {
    const placeholder = document.getElementById('dropzone-placeholder');
    const container = document.getElementById('preview-container');
    const preview = document.getElementById('image-preview');
    const previewText = document.getElementById('preview-text');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            placeholder.classList.add('hidden');
            placeholder.classList.remove('flex');
            container.classList.remove('hidden');
            container.classList.add('flex');
            if (previewText) previewText.textContent = 'Foto baru terpilih (klik untuk ganti)';
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// ============================================================
// LIVE NOMOR INVENTARIS GENERATOR (EDIT)
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    const originalKode = "{{ $barang->kode_barang }}";
    @php
        $origSeq = preg_match('/(\d{3}\/\d{3})$/', $barang->nomor_inventaris ?? '', $m) ? $m[1] : '001/001';
    @endphp
    const originalSeqStr = "{{ $origSeq }}";
    let currentSeqStr = originalSeqStr;
    let fetchTimeout = null;

    const inputNama = document.getElementById('input-nama');
    const inputKode = document.getElementById('input-kode');
    const inputTanggal = document.getElementById('input-tanggal');
    const selectLokasi = document.getElementById('select-lokasi');
    const previewEl = document.getElementById('nomor-inventaris-preview');
    const badgeStatus = document.getElementById('badge-live-status');
    const badgeUrutan = document.getElementById('badge-urutan');

    function updateNomorInventaris() {
        if (!previewEl) return;

        // 1. Lokasi
        let gedung = '{Gedung}';
        let lantai = '{Lantai}';
        let ruangan = '{Ruangan}';
        let isLokasiFilled = false;

        if (selectLokasi && selectLokasi.selectedIndex > 0) {
            const opt = selectLokasi.options[selectLokasi.selectedIndex];
            gedung = (opt.dataset.gedung || 'X').toUpperCase();
            lantai = opt.dataset.lantai || '00';
            ruangan = (opt.dataset.nama || 'X').toUpperCase();
            isLokasiFilled = true;
        }

        // 2. Tahun
        let tahun = '{{ $barang->tahun_pengadaan ?? date('Y') }}';
        if (inputTanggal && inputTanggal.value) {
            const parts = inputTanggal.value.split('-');
            if (parts.length > 0 && parts[0]) {
                tahun = parts[0];
            }
        }

        // 3. Kode Barang
        let kode = '{Kode}';
        let isKodeFilled = false;
        if (inputKode && inputKode.value.trim()) {
            kode = inputKode.value.trim().toUpperCase();
            isKodeFilled = true;
        }

        // 4. Sequence string
        const result = `${gedung}-${lantai}-${tahun}-${ruangan}-${kode}-${currentSeqStr}`;
        previewEl.value = result;

        // Visual flash
        previewEl.classList.add('bg-blue-50/50');
        setTimeout(() => previewEl.classList.remove('bg-blue-50/50'), 150);

        if (badgeStatus) {
            badgeStatus.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200 transition-all';
            badgeStatus.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Siap';
        }
    }

    function fetchNextNumber(kode) {
        if (!kode) {
            currentSeqStr = '001/001';
            if (badgeUrutan) badgeUrutan.textContent = 'Urutan: -';
            updateNomorInventaris();
            return;
        }

        if (kode === originalKode) {
            currentSeqStr = originalSeqStr;
            if (badgeUrutan) badgeUrutan.textContent = `Urutan: ${originalSeqStr}`;
            updateNomorInventaris();
            return;
        }

        fetch(`{{ route('barang.check-next-number') }}?kode=${encodeURIComponent(kode)}`)
            .then(res => res.json())
            .then(data => {
                currentSeqStr = data.formatted || '001/001';
                if (badgeUrutan) {
                    badgeUrutan.textContent = `Urutan ke-${data.next} (Total: ${data.next})`;
                }
                updateNomorInventaris();
            })
            .catch(err => {
                console.error(err);
                updateNomorInventaris();
            });
    }

    if (inputKode) {
        inputKode.addEventListener('input', function() {
            this.value = this.value.toUpperCase();
            const val = this.value.trim();
            clearTimeout(fetchTimeout);
            fetchTimeout = setTimeout(() => fetchNextNumber(val), 200);
            updateNomorInventaris();
        });
    }

    if (inputTanggal) {
        inputTanggal.addEventListener('change', updateNomorInventaris);
        inputTanggal.addEventListener('input', updateNomorInventaris);
    }

    if (selectLokasi) {
        selectLokasi.addEventListener('change', updateNomorInventaris);
    }
});

function copyNomorInventaris() {
    const previewEl = document.getElementById('nomor-inventaris-preview');
    if (!previewEl) return;
    
    navigator.clipboard.writeText(previewEl.value).then(() => {
        const copyText = document.getElementById('copy-text');
        if (copyText) {
            copyText.textContent = 'Tersalin!';
            setTimeout(() => copyText.textContent = 'Salin', 2000);
        }
    }).catch(() => {
        previewEl.select();
        document.execCommand('copy');
        const copyText = document.getElementById('copy-text');
        if (copyText) {
            copyText.textContent = 'Tersalin!';
            setTimeout(() => copyText.textContent = 'Salin', 2000);
        }
    });
}
</script>
@endsection