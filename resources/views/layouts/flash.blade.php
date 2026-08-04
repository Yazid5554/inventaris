{{-- Master Flash Messages Toast System --}}
<div id="flashAlertContainer" class="fixed top-20 right-6 z-50 flex flex-col gap-3 max-w-sm pointer-events-none">
    @if(session('success') && !session('login_success'))
    <div class="flash-toast pointer-events-auto bg-emerald-600 text-white rounded-xl p-4 shadow-xl border border-emerald-500 flex items-center justify-between gap-3 transform transition-all duration-300 translate-x-0 opacity-100">
        <div class="flex items-center gap-2.5">
            <svg class="w-5 h-5 text-emerald-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-xs font-semibold leading-snug">{{ session('success') }}</span>
        </div>
        <button onclick="closeToast(this.parentElement)" class="text-emerald-200 hover:text-white transition font-bold text-sm">✕</button>
    </div>
    @endif

    @if(session('error') || session('import_error'))
    <div class="flash-toast pointer-events-auto bg-red-600 text-white rounded-xl p-4 shadow-xl border border-red-500 flex items-center justify-between gap-3 transform transition-all duration-300 translate-x-0 opacity-100">
        <div class="flex items-center gap-2.5">
            <svg class="w-5 h-5 text-red-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-xs font-semibold leading-snug">{{ session('error') ?? session('import_error') }}</span>
        </div>
        <button onclick="closeToast(this.parentElement)" class="text-red-200 hover:text-white transition font-bold text-sm">✕</button>
    </div>
    @endif

    @if(session('warning'))
    <div class="flash-toast pointer-events-auto bg-amber-500 text-white rounded-xl p-4 shadow-xl border border-amber-400 flex items-center justify-between gap-3 transform transition-all duration-300 translate-x-0 opacity-100">
        <div class="flex items-center gap-2.5">
            <svg class="w-5 h-5 text-amber-100 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            <span class="text-xs font-semibold leading-snug">{{ session('warning') }}</span>
        </div>
        <button onclick="closeToast(this.parentElement)" class="text-amber-100 hover:text-white transition font-bold text-sm">✕</button>
    </div>
    @endif
</div>

<script>
    function closeToast(el) {
        if (!el) return;
        el.style.opacity = '0';
        el.style.transform = 'translateX(20px)';
        setTimeout(() => el.remove(), 300);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.flash-toast');
        toasts.forEach(toast => {
            setTimeout(() => {
                closeToast(toast);
            }, 3000);
        });
    });
</script>