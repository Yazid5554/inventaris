{{-- Flash Messages --}}
@if(session('success') && !session('login_success'))
<div class="flash-message fixed right-6 z-50 w-[320px] bg-green-50 border border-green-200 text-green-800 rounded-2xl px-4 py-3 text-sm flex justify-between items-start gap-3 shadow-lg ring-1 ring-green-100 transition-all duration-300" style="top:4.5rem;">
    <span class="flex-1">{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="text-green-600 font-bold">×</button>
</div>
@endif
@if(session('error'))
<div class="flash-message fixed right-6 z-50 w-[320px] bg-red-50 border border-red-200 text-red-800 rounded-2xl px-4 py-3 text-sm flex justify-between items-start gap-3 shadow-lg ring-1 ring-red-100 transition-all duration-300" style="top:4.5rem;">
    <span class="flex-1">{{ session('error') }}</span>
    <button onclick="this.parentElement.remove()" class="text-red-600 font-bold">×</button>
</div>
@endif