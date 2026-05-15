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