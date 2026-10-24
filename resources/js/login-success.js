/**
 * Login Success Popup Transition Handler
 */

document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('loginSuccessPopup');
    if (!popup) return;

    const justLoggedIn = popup.dataset.loginSuccess === 'true';

    if (justLoggedIn) {
        // Pause semua animasi dashboard + sidebar
        document.querySelectorAll('.animate-card, .animate-sidebar').forEach(el => {
            el.style.animationPlayState = 'paused';
            el.style.opacity = '0';
        });

        setTimeout(() => {
            popup.classList.add('show');

            // Setelah popup selesai, resume semua animasi
            setTimeout(() => {
                popup.style.transition = 'opacity 0.4s ease, visibility 0.4s ease';
                popup.classList.remove('show');

                setTimeout(() => {
                    document.querySelectorAll('.animate-card, .animate-sidebar').forEach(el => {
                        el.style.opacity = '';
                        el.style.animationPlayState = 'running';
                    });
                    sessionStorage.setItem('app_navigated', 'true');
                }, 400);
            }, 1700);
        }, 150);
    }
});
