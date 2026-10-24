/**
 * Auto-hiding Flash Alerts Handler
 */

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.flash-message').forEach(el => {
        setTimeout(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-10px)';
            setTimeout(() => el.remove(), 500);
        }, 4500);
    });
});
