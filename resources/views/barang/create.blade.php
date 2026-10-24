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
                            <input type="text" name="nama" id="input-nama" value="{{ old('nama') }}" placeholder="Kulkas, Laptop, Meja, dll"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white @error('nama') border-red-400 bg-red-50 @enderror">
                            @error('nama')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                        </div>

                        {{-- Kode Barang --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Kode Barang <span class="text-red-500">*</span></label>
                            <input type="text" name="kode_barang" id="input-kode" value="{{ old('kode_barang') }}" placeholder="KL, LT, MJ, dll"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white uppercase font-mono @error('kode_barang') border-red-400 bg-red-50 @enderror">
                            @error('kode_barang')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- No Inventaris Live Box --}}
                    <div class="p-4 bg-gradient-to-r from-blue-50/70 to-indigo-50/50 border border-blue-100 rounded-2xl shadow-sm transition-all">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-extrabold text-[#1a2f6e] uppercase tracking-wider flex items-center gap-1.5">
                                <span>Nomor Inventaris</span>
                                <span id="badge-live-status" class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Preview
                                </span>
                            </label>
                            <span id="badge-urutan" class="text-[11px] font-mono font-bold text-blue-600 bg-white/80 px-2 py-0.5 rounded-md border border-blue-100 shadow-2xs">
                                Urutan: -
                            </span>
                        </div>
                        <p class="text-[11px] text-gray-500 mb-2">Live preview nomor inventaris yang otomatis digenerate dari data yang Anda input.</p>
                        
                        <div class="relative flex items-center">
                            <input type="text" id="nomor-inventaris-preview" readonly
                                value="{Gedung}-{Lantai}-{{ date('Y') }}-{Ruangan}-{Kode}-001/001"
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
                            <input type="text" name="jenis_barang" id="input-jenis" value="{{ old('jenis_barang') }}" placeholder="Elektronik, Furnitur, dll"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2548cc]/20 focus:border-[#2548cc] transition-all bg-gray-50 focus:bg-white">
                        </div>

                        {{-- Tanggal Pengadaan --}}
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Pengadaan</label>
                            <input type="date" name="tanggal_pengadaan" id="input-tanggal" value="{{ old('tanggal_pengadaan') }}"
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
                                    {{ old('id_lokasi') == $l->id ? 'selected' : '' }}>
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
                        <div class="relative group cursor-pointer min-h-[220px]">
                            <input type="file" name="foto" id="foto-input" accept="image/*" onchange="previewImage(this)"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            {{-- Placeholder Dropzone --}}
                            <div id="dropzone-placeholder" class="h-56 flex flex-col justify-center border-2 border-dashed border-gray-300 rounded-xl px-4 text-center group-hover:border-[#2548cc] transition-colors bg-gray-50 group-hover:bg-blue-50/50 @error('foto') border-red-400 bg-red-50 @enderror">
                                <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-[#2548cc] mb-3 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm font-medium text-gray-700">Klik atau drag gambar ke area ini</p>
                                <p class="text-[11px] text-gray-500 mt-1">Format JPG, PNG, atau WEBP. Maksimal 2MB.</p>
                            </div>

                            {{-- Image Preview Container --}}
                            <div id="preview-container" class="hidden relative h-56 border-2 border-solid border-[#2548cc]/30 rounded-xl p-2 bg-blue-50/30 flex items-center justify-center overflow-hidden">
                                <img id="image-preview" src="#" alt="Preview" class="h-full w-full object-contain rounded-lg">
                                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 bg-black/70 text-white text-xs px-3 py-1.5 rounded-full backdrop-blur-sm pointer-events-none flex items-center gap-1.5 shadow-lg">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Klik untuk ganti gambar
                                </div>
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
<script>
function previewImage(input) {
    const placeholder = document.getElementById('dropzone-placeholder');
    const container = document.getElementById('preview-container');
    const preview = document.getElementById('image-preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            placeholder.classList.add('hidden');
            container.classList.remove('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// ============================================================
// LIVE NOMOR INVENTARIS GENERATOR
// ============================================================
document.addEventListener('DOMContentLoaded', function() {
    let kodeManuallyEdited = false;
    let currentSeqStr = '001/001';
    let fetchTimeout = null;

    const inputNama = document.getElementById('input-nama');
    const inputKode = document.getElementById('input-kode');
    const inputJenis = document.getElementById('input-jenis');
    const inputTanggal = document.getElementById('input-tanggal');
    const selectLokasi = document.getElementById('select-lokasi');
    const previewEl = document.getElementById('nomor-inventaris-preview');
    const badgeStatus = document.getElementById('badge-live-status');
    const badgeUrutan = document.getElementById('badge-urutan');

    function generateCandidateCode(name) {
        if (!name) return '';
        const clean = name.replace(/[^a-zA-Z0-9\s]/g, '').trim();
        const words = clean.split(/\s+/).filter(Boolean);
        if (words.length >= 2) {
            return (words[0][0] + words[1][0]).toUpperCase();
        } else if (words.length === 1 && words[0].length >= 2) {
            return words[0].substring(0, 2).toUpperCase();
        } else if (words.length === 1 && words[0].length === 1) {
            return words[0].toUpperCase();
        }
        return '';
    }

    function updateNomorInventaris() {
        if (!previewEl) return;

        // 1. Lokasi (Gedung, Lantai, Ruangan)
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

        // 2. Tahun Pengadaan
        let tahun = '{{ date('Y') }}';
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

        // 4. Update Preview String
        const result = `${gedung}-${lantai}-${tahun}-${ruangan}-${kode}-${currentSeqStr}`;
        previewEl.value = result;

        // Visual animation on preview box
        previewEl.classList.add('bg-blue-50/50');
        setTimeout(() => previewEl.classList.remove('bg-blue-50/50'), 150);

        // 5. Update Status Badges
        if (badgeStatus) {
            if (isLokasiFilled && isKodeFilled) {
                badgeStatus.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200 transition-all';
                badgeStatus.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Siap';
            } else {
                badgeStatus.className = 'inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200 transition-all';
                badgeStatus.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Mengisi Data...';
            }
        }
    }

    function fetchNextNumber(kode) {
        if (!kode || kode.includes('{')) {
            currentSeqStr = '001/001';
            if (badgeUrutan) badgeUrutan.textContent = 'Urutan: -';
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
                console.error('Error checking next number:', err);
                updateNomorInventaris();
            });
    }

    // Nama Barang Listener -> auto-generate candidate kode if empty
    if (inputNama) {
        inputNama.addEventListener('input', function() {
            if (!kodeManuallyEdited && (!inputKode.value || inputKode.value.length <= 2)) {
                const candidate = generateCandidateCode(this.value);
                if (candidate) {
                    inputKode.value = candidate;
                    clearTimeout(fetchTimeout);
                    fetchTimeout = setTimeout(() => fetchNextNumber(candidate), 200);
                }
            }
            updateNomorInventaris();
        });
    }

    // Kode Barang Listener
    if (inputKode) {
        if (inputKode.value.trim()) {
            kodeManuallyEdited = true;
            fetchNextNumber(inputKode.value.trim());
        }

        inputKode.addEventListener('input', function() {
            kodeManuallyEdited = true;
            this.value = this.value.toUpperCase();
            const val = this.value.trim();
            clearTimeout(fetchTimeout);
            fetchTimeout = setTimeout(() => fetchNextNumber(val), 200);
            updateNomorInventaris();
        });
    }

    // Tanggal Pengadaan Listener
    if (inputTanggal) {
        inputTanggal.addEventListener('change', updateNomorInventaris);
        inputTanggal.addEventListener('input', updateNomorInventaris);
    }

    // Ruangan Listener
    if (selectLokasi) {
        selectLokasi.addEventListener('change', updateNomorInventaris);
    }

    // Initial render
    updateNomorInventaris();
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