/**
 * Sidebar Navigation Toggle & Collapse Handler
 */

export function applySidebarState(isCollapsed, animate = true) {
    const sidebar = document.getElementById('sidebar');
    const main = document.getElementById('main-content');
    const icon = document.getElementById('collapse-icon');
    const avatar = document.getElementById('sidebar-avatar');
    const avatarSvg = avatar ? avatar.querySelector('svg') : null;
    const sidebarName = document.getElementById('sidebar-name');
    const sidebarRole = document.getElementById('sidebar-role');
    const sidebarDivider = document.getElementById('sidebar-divider');
    const userSection = document.getElementById('sidebar-user-section');

    if (!sidebar || !main) return;

    if (!animate) {
        sidebar.style.transition = 'none';
        main.style.transition = 'none';
        if (avatar) avatar.style.transition = 'none';
    }

    if (isCollapsed) {
        sidebar.classList.remove('w-60', 'w-16');
        sidebar.classList.add('w-20');

        main.classList.remove('ml-60', 'ml-16', 'md:ml-60', 'md:ml-16');
        main.classList.add('md:ml-20');

        if (userSection) {
            userSection.classList.remove('pt-10', 'px-4');
            userSection.classList.add('pt-4', 'px-2');
        }

        // Sembunyikan teks nav, nama, role, divider, system info
        document.querySelectorAll('#sidebar nav a span, .system-info-box').forEach(el => {
            el.classList.add('hidden');
        });
        if (sidebarName) sidebarName.classList.add('hidden');
        if (sidebarRole) sidebarRole.classList.add('hidden');
        if (sidebarDivider) sidebarDivider.classList.add('hidden');

        // Pusatkan icon nav
        document.querySelectorAll('#sidebar nav a').forEach(el => {
            el.classList.replace('px-4', 'px-0');
            el.classList.add('justify-center');
        });

        // Kecilkan avatar
        if (avatar) {
            avatar.classList.remove('w-24', 'w-32', 'w-10', 'h-24', 'h-32', 'h-10');
            avatar.classList.add('w-12', 'h-12');
            avatar.classList.replace('border-4', 'border-2');
            avatar.classList.replace('mb-3', 'mb-1');
        }
        if (avatarSvg) {
            avatarSvg.classList.remove('w-14', 'w-16', 'w-6', 'h-14', 'h-16', 'h-6');
            avatarSvg.classList.add('w-7', 'h-7');
        }

        if (icon) icon.classList.add('rotate-180');

    } else {
        sidebar.classList.remove('w-20', 'w-16');
        sidebar.classList.add('w-60');

        main.classList.remove('ml-20', 'ml-16', 'md:ml-20', 'md:ml-16');
        main.classList.add('md:ml-60');

        if (userSection) {
            userSection.classList.remove('pt-4', 'px-2');
            userSection.classList.add('pt-10', 'px-4');
        }

        // Tampilkan kembali
        document.querySelectorAll('#sidebar nav a span, .system-info-box').forEach(el => {
            el.classList.remove('hidden');
        });
        if (sidebarName) sidebarName.classList.remove('hidden');
        if (sidebarRole) sidebarRole.classList.remove('hidden');
        if (sidebarDivider) sidebarDivider.classList.remove('hidden');

        // Kembalikan padding nav
        document.querySelectorAll('#sidebar nav a').forEach(el => {
            el.classList.replace('px-0', 'px-4');
            el.classList.remove('justify-center');
        });

        // Besarkan avatar
        if (avatar) {
            avatar.classList.remove('w-10', 'w-12', 'h-10', 'h-12');
            avatar.classList.add('w-32', 'h-32');
            avatar.classList.replace('border-2', 'border-4');
            avatar.classList.replace('mb-1', 'mb-3');
        }
        if (avatarSvg) {
            avatarSvg.classList.remove('w-6', 'w-7', 'h-6', 'h-7');
            avatarSvg.classList.add('w-16', 'h-16');
        }

        if (icon) icon.classList.remove('rotate-180');
    }

    if (!animate) {
        void sidebar.offsetHeight;
        sidebar.style.transition = '';
        main.style.transition = '';
        if (avatar) avatar.style.transition = '';
    }
}

export function toggleSidebar() {
    const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
    localStorage.setItem('sidebar_collapsed', !isCollapsed);
    applySidebarState(!isCollapsed, true);
}

// Auto init state on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
    if (isCollapsed) {
        applySidebarState(true, false);
    }
});
