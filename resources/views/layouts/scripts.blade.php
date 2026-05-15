{{-- Cropper.js CDN --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<script>
    let cropperInstance = null;
    let currentZoom = 0;

    function openCropper(input) {
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
            image.src = e.target.result;

            // Tampilkan modal
            document.getElementById('cropper-modal').classList.remove('hidden');

            // Destroy cropper lama kalau ada
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }

            // Reset zoom slider
            currentZoom = 0;
            document.getElementById('zoom-slider').value = 0;

            // Init cropper baru
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
                    document.getElementById('zoom-slider').value = currentZoom;
                },
            });
        };
        reader.readAsDataURL(file);
    }

    function closeCropper() {
        document.getElementById('cropper-modal').classList.add('hidden');
        if (cropperInstance) {
            cropperInstance.destroy();
            cropperInstance = null;
        }
        document.getElementById('avatar-input').value = '';
    }

    function saveCrop() {
        if (!cropperInstance) return;

        const canvas = cropperInstance.getCroppedCanvas({
            width: 400,
            height: 400,
            imageSmoothingEnabled: true,
            imageSmoothingQuality: 'high',
        });

        const base64 = canvas.toDataURL('image/jpeg', 0.9);

        document.getElementById('avatar-cropped-input').value = base64;
        document.getElementById('avatar-form').submit();

        closeCropper();
    }

    function applySidebarState(isCollapsed, animate = true) {
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('main-content');
        const icon = document.getElementById('collapse-icon');
        const avatar = document.getElementById('sidebar-avatar');
        const avatarSvg = avatar ? avatar.querySelector('svg') : null;
        const sidebarName = document.getElementById('sidebar-name');
        const sidebarDivider = document.getElementById('sidebar-divider');

        if (!animate) {
            sidebar.style.transition = 'none';
            main.style.transition = 'none';
            if (avatar) avatar.style.transition = 'none';
        }

        if (isCollapsed) {
            sidebar.classList.replace('w-60', 'w-16');
            main.classList.replace('ml-60', 'ml-16');

            // Sembunyikan teks nav, nama, divider, system info
            document.querySelectorAll('#sidebar nav a span, .system-info-box').forEach(el => {
                el.classList.add('hidden');
            });
            if (sidebarName) sidebarName.classList.add('hidden');
            if (sidebarDivider) sidebarDivider.classList.add('hidden');

            // Pusatkan icon nav
            document.querySelectorAll('#sidebar nav a').forEach(el => {
                el.classList.replace('px-4', 'px-0');
                el.classList.add('justify-center');
            });

            // Kecilkan avatar
            if (avatar) {
                avatar.classList.remove('w-24', 'w-32');
                avatar.classList.add('w-10');
                avatar.classList.remove('h-24', 'h-32');
                avatar.classList.add('h-10');
                avatar.classList.replace('border-4', 'border-2');
            }
            if (avatarSvg) {
                avatarSvg.classList.remove('w-14', 'w-16');
                avatarSvg.classList.add('w-6');
                avatarSvg.classList.remove('h-14', 'h-16');
                avatarSvg.classList.add('h-6');
            }

            icon.classList.add('rotate-180');

        } else {
            sidebar.classList.replace('w-16', 'w-60');
            main.classList.replace('ml-16', 'ml-60');

            // Tampilkan kembali
            document.querySelectorAll('#sidebar nav a span, .system-info-box').forEach(el => {
                el.classList.remove('hidden');
            });
            if (sidebarName) sidebarName.classList.remove('hidden');
            if (sidebarDivider) sidebarDivider.classList.remove('hidden');

            // Kembalikan padding nav
            document.querySelectorAll('#sidebar nav a').forEach(el => {
                el.classList.replace('px-0', 'px-4');
                el.classList.remove('justify-center');
            });

            // Besarkan avatar
            if (avatar) {
                avatar.classList.remove('w-10');
                avatar.classList.add('w-32');
                avatar.classList.remove('h-10');
                avatar.classList.add('h-32');
                avatar.classList.replace('border-2', 'border-4');
            }
            if (avatarSvg) {
                avatarSvg.classList.remove('w-6');
                avatarSvg.classList.add('w-16');
                avatarSvg.classList.remove('h-6');
                avatarSvg.classList.add('h-16');
            }

            icon.classList.remove('rotate-180');
        }

        if (!animate) {
            void sidebar.offsetHeight;
            sidebar.style.transition = '';
            main.style.transition = '';
            if (avatar) avatar.style.transition = '';
        }
    }

    function toggleSidebar() {
        const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
        localStorage.setItem('sidebar_collapsed', !isCollapsed);
        applySidebarState(!isCollapsed, true);
    }

    // Apply state on load
    const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
    if (isCollapsed) {
        applySidebarState(true, false);
    }

    // Auto-hide flash messages after 4.5 seconds
    document.querySelectorAll('.flash-message').forEach(el => {
        setTimeout(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-10px)';
            setTimeout(() => el.remove(), 500);
        }, 4500);
    });
</script>