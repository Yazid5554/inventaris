/**
 * Avatar Cropper JS Handler
 */

let cropperInstance = null;
let currentZoom = 0;

export function openCropper(input) {
    if (!input.files || !input.files[0]) return;

    const file = input.files[0];

    // Validasi ukuran (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran foto maksimal 2MB.');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const image = document.getElementById('cropper-image');
        if (!image) return;

        image.src = e.target.result;

        // Tampilkan modal
        const modal = document.getElementById('cropper-modal');
        if (modal) modal.classList.remove('hidden');

        // Destroy cropper lama kalau ada
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }

        // Reset zoom slider
        currentZoom = 0;
        const zoomSlider = document.getElementById('zoom-slider');
        if (zoomSlider) zoomSlider.value = 0;

        // Init cropper baru (jika Cropper.js sudah terload dari CDN)
        if (typeof Cropper !== 'undefined') {
            cropperInstance = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.8,
                restore: false,
                guides: true,
                center: true,
                highlight: false,
                cropBoxMovable: false,
                cropBoxResizable: false,
                toggleDragModeOnDblclick: false,
                zoom(event) {
                    currentZoom = event.detail.ratio;
                    if (zoomSlider) zoomSlider.value = currentZoom;
                },
            });
            window.cropperInstance = cropperInstance;
            window.currentZoom = currentZoom;
        }
    };
    reader.readAsDataURL(file);
}

export function closeCropper() {
    const modal = document.getElementById('cropper-modal');
    if (modal) modal.classList.add('hidden');
    if (cropperInstance) {
        cropperInstance.destroy();
        cropperInstance = null;
        window.cropperInstance = null;
    }
    const input = document.getElementById('avatar-input');
    if (input) input.value = '';
}

export function saveCrop() {
    if (!cropperInstance) return;

    const canvas = cropperInstance.getCroppedCanvas({
        width: 400,
        height: 400,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
    });

    const base64 = canvas.toDataURL('image/jpeg', 0.9);

    const avatarCroppedInput = document.getElementById('avatar-cropped-input');
    const avatarForm = document.getElementById('avatar-form');

    if (avatarCroppedInput) avatarCroppedInput.value = base64;
    if (avatarForm) avatarForm.submit();

    closeCropper();
}
