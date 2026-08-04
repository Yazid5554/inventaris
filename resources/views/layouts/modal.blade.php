{{-- Modal Cropper --}}
<div id="cropper-modal" class="fixed inset-0 z-[999] bg-black/60 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">

        {{-- Header --}}
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-800">Atur Foto Profil</h3>
                <p class="text-xs text-gray-400 mt-0.5">Geser & zoom untuk mengatur posisi foto</p>
            </div>
            <button onclick="closeCropper()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Crop Area --}}
        <div class="p-5">
            <div class="relative w-full bg-gray-900 rounded-xl overflow-hidden" style="height: 280px;">
                <img id="cropper-image" src="" alt="crop" class="max-w-full">
            </div>

            {{-- Zoom Controls --}}
            <div class="flex items-center gap-3 mt-4">
                <span class="text-xs text-gray-400">Zoom</span>
                <input type="range" id="zoom-slider" min="0" max="3" step="0.01" value="0"
                    class="flex-1 accent-blue-600"
                    oninput="cropperInstance.zoom(parseFloat(this.value) - currentZoom); currentZoom = parseFloat(this.value);">
                <span class="text-xs text-gray-400">Putar</span>
                <button onclick="cropperInstance.rotate(-90)" class="text-xs border border-gray-200 px-2 py-1 rounded-lg hover:bg-gray-50 transition">↺</button>
                <button onclick="cropperInstance.rotate(90)" class="text-xs border border-gray-200 px-2 py-1 rounded-lg hover:bg-gray-50 transition">↻</button>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-5 py-4 border-t border-gray-100 flex justify-end gap-3">
            <button onclick="closeCropper()"
                class="px-4 py-2 text-sm text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                Batal
            </button>
            <button onclick="saveCrop()"
                class="px-4 py-2 text-sm text-white bg-[#1a2f6e] rounded-lg hover:bg-blue-800 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Foto
            </button>
        </div>
    </div>
</div>

{{-- Form hidden untuk submit hasil crop --}}
<form id="avatar-form" method="POST" action="{{ route('profile.avatar.update') }}">
    @csrf
    <input type="hidden" name="avatar_cropped" id="avatar-cropped-input">
</form>

{{-- Modal Konfirmasi Hapus Custom --}}
<div id="deleteConfirmModal" class="fixed inset-0 z-[9999] bg-black/60 backdrop-blur-sm flex items-center justify-center hidden opacity-0 transition-all duration-200">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-6 text-center transform scale-95 transition-all duration-200" id="deleteConfirmModalContent">
        {{-- Trash Icon Badge --}}
        <div class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-red-100 shadow-sm">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>

        <h3 class="text-base font-extrabold text-gray-900 mb-1">Konfirmasi Hapus</h3>
        <p class="text-xs text-gray-500 mb-6 leading-relaxed" id="deleteModalMessage">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>

        <div class="flex items-center justify-center gap-3">
            <button type="button" onclick="closeDeleteModal()" class="w-1/2 bg-gray-100 text-gray-700 px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-gray-200 transition cursor-pointer">
                Batal
            </button>
            <button type="button" id="confirmDeleteBtn" class="w-1/2 bg-red-600 text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-red-700 transition shadow-md shadow-red-200 cursor-pointer">
                Ya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    let activeDeleteForm = null;

    function confirmDelete(event, message) {
        if (event) event.preventDefault();
        const form = event ? (event.target.closest('form') || event.target) : null;
        if (!form) return false;

        activeDeleteForm = form;
        if (message) {
            document.getElementById('deleteModalMessage').textContent = message;
        }
        
        const modal = document.getElementById('deleteConfirmModal');
        const content = document.getElementById('deleteConfirmModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);

        return false;
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteConfirmModal');
        const content = document.getElementById('deleteConfirmModalContent');

        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
            activeDeleteForm = null;
        }, 200);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', function() {
                if (activeDeleteForm) {
                    activeDeleteForm.submit();
                }
                closeDeleteModal();
            });
        }
    });

    function openQrModal(id, nama, kode, noInventaris, ruangan, gedungLantai) {
        document.getElementById('qrModalNama').textContent = nama;
        document.getElementById('qrModalKode').textContent = kode || '-';
        document.getElementById('qrModalNoInv').textContent = noInventaris || '-';
        document.getElementById('qrModalRuangan').textContent = ruangan || '-';
        document.getElementById('qrModalGedung').textContent = gedungLantai || '-';
        
        // Set QR Image URL
        const qrImg = document.getElementById('qrModalImg');
        qrImg.src = '/barang/' + id + '/qr';

        // Set Action URLs
        document.getElementById('qrModalDetailBtn').href = '/barang/' + id;
        document.getElementById('qrModalPrintBtn').href = '/barang/' + id + '/print-qr';

        const modal = document.getElementById('qrModal');
        const content = document.getElementById('qrModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeQrModal() {
        const modal = document.getElementById('qrModal');
        const content = document.getElementById('qrModalContent');

        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }

    function openImageModal(src, title) {
        document.getElementById('imageModalSrc').src = src;
        document.getElementById('imageModalTitle').textContent = title || 'Preview Foto';
        
        const modal = document.getElementById('imageModal');
        const content = document.getElementById('imageModalContent');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
            content.classList.add('scale-100');
        }, 10);
    }

    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        const content = document.getElementById('imageModalContent');

        modal.classList.add('opacity-0');
        content.classList.remove('scale-100');
        content.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 200);
    }
</script>

{{-- Modal Preview QR Code Custom --}}
<div id="qrModal" class="fixed inset-0 z-[9999] bg-black/60 backdrop-blur-sm flex items-center justify-center hidden opacity-0 transition-all duration-200" onclick="if(event.target===this) closeQrModal()">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden transform scale-95 transition-all duration-200" id="qrModalContent">
        
        {{-- Header --}}
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-[#1a2f6e] to-[#2548cc] text-white">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                <h3 class="text-sm font-extrabold tracking-wide">Preview QR Code</h3>
            </div>
            <button type="button" onclick="closeQrModal()" class="text-white/80 hover:text-white transition cursor-pointer p-1 rounded-lg hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 text-center">
            <div class="p-3 bg-white border border-gray-100 rounded-2xl inline-block mb-3 shadow-inner">
                <img id="qrModalImg" src="" alt="QR Code" class="w-44 h-44 object-contain mx-auto">
            </div>

            <h3 class="font-extrabold text-base text-gray-900 mb-0.5 line-clamp-1" id="qrModalNama">-</h3>
            <p class="text-xs font-semibold text-gray-400 mb-3" id="qrModalKode">-</p>

            <div class="bg-gray-50 rounded-xl p-3 text-xs space-y-1.5 text-gray-600 border border-gray-100 text-left mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-400">Ruangan:</span>
                    <strong class="text-gray-800" id="qrModalRuangan">-</strong>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Gedung / Lt:</span>
                    <strong class="text-gray-800" id="qrModalGedung">-</strong>
                </div>
            </div>

            <div class="font-mono text-xs font-bold text-[#2548cc] bg-blue-50 border border-blue-100 py-2 px-3 rounded-xl truncate" id="qrModalNoInv">
                -
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between gap-3">
            <a id="qrModalDetailBtn" href="#" class="px-4 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-100 text-xs font-bold transition flex-1 text-center">
                Detail Barang
            </a>
            <a id="qrModalPrintBtn" href="#" class="px-4 py-2.5 rounded-xl bg-[#2548cc] text-white hover:bg-blue-800 text-xs font-bold transition flex-1 text-center shadow-md flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print Label
            </a>
        </div>

    </div>
</div>

{{-- Modal Preview Foto Custom --}}
<div id="imageModal" class="fixed inset-0 z-[9999] bg-black/80 backdrop-blur-md flex items-center justify-center hidden opacity-0 transition-all duration-200" onclick="if(event.target===this) closeImageModal()">
    <div class="relative bg-white rounded-2xl shadow-2xl max-w-4xl max-h-[90vh] w-full mx-4 overflow-hidden transform scale-95 transition-all duration-200 flex flex-col" id="imageModalContent">
        
        {{-- Header --}}
        <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between bg-[#1a2f6e] text-white">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-sm font-extrabold tracking-wide truncate" id="imageModalTitle">Preview Foto</h3>
            </div>
            <button type="button" onclick="closeImageModal()" class="text-white/80 hover:text-white transition cursor-pointer p-1 rounded-lg hover:bg-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Image Display Container --}}
        <div class="p-4 bg-gray-950 flex items-center justify-center overflow-auto max-h-[80vh]">
            <img id="imageModalSrc" src="" alt="Foto Visual" class="max-w-full max-h-[75vh] object-contain rounded-xl shadow-2xl">
        </div>

        {{-- Footer --}}
        <div class="px-5 py-3 bg-gray-900 border-t border-gray-800 flex items-center justify-end">
            <button type="button" onclick="closeImageModal()" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white text-xs font-bold transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>