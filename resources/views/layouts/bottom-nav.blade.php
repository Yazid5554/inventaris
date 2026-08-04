{{-- Mobile Bottom Navigation Bar --}}
<div class="fixed bottom-0 left-0 right-0 z-[88] md:hidden bg-white/95 backdrop-blur-xl border-t border-gray-200/80 px-2 py-1 shadow-[0_-4px_25px_rgba(0,0,0,0.08)]">
    <div class="flex items-center justify-around max-w-md mx-auto relative h-14">

        {{-- 1. Dashboard --}}
        <a href="{{ route('dashboard') }}" 
           class="flex flex-col items-center justify-center w-14 h-full text-xs font-semibold transition-all duration-200 
           {{ request()->routeIs('dashboard') ? 'text-[#2548cc]' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-5 h-5 mb-0.5 {{ request()->routeIs('dashboard') ? 'scale-110 text-[#2548cc]' : '' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span class="text-[10px] font-bold">Dashboard</span>
        </a>

        {{-- 2. Barang --}}
        <a href="{{ route('barang.index') }}" 
           class="flex flex-col items-center justify-center w-14 h-full text-xs font-semibold transition-all duration-200 
           {{ request()->routeIs('barang.*') ? 'text-[#2548cc]' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-5 h-5 mb-0.5 {{ request()->routeIs('barang.*') ? 'scale-110 text-[#2548cc]' : '' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span class="text-[10px] font-bold">Barang</span>
        </a>

        {{-- 3. Scan QR (CENTER FLOATING BUTTON - FAB) --}}
        <div class="relative -top-5 flex flex-col items-center justify-center">
            <a href="{{ route('scan.index') }}" 
               class="w-14 h-14 rounded-full bg-gradient-to-tr from-[#1a2f6e] to-[#2548cc] text-white flex flex-col items-center justify-center shadow-lg shadow-blue-600/40 border-4 border-gray-100 active:scale-90 hover:scale-105 transition-all duration-300 relative group">
                {{-- Glow Pulse --}}
                <span class="absolute inset-0 rounded-full bg-blue-500/30 animate-ping pointer-events-none opacity-40"></span>
                <svg class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </a>
            <span class="text-[10px] font-extrabold text-[#2548cc] mt-0.5">Scan QR</span>
        </div>

        {{-- 4. Ruangan --}}
        <a href="{{ route('lokasi.index') }}" 
           class="flex flex-col items-center justify-center w-14 h-full text-xs font-semibold transition-all duration-200 
           {{ request()->routeIs('lokasi.*') ? 'text-[#2548cc]' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-5 h-5 mb-0.5 {{ request()->routeIs('lokasi.*') ? 'scale-110 text-[#2548cc]' : '' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span class="text-[10px] font-bold">Ruangan</span>
        </a>

        {{-- 5. Users / Profil --}}
        @if(auth()->check() && auth()->user()->role === 'super_admin')
        <a href="{{ route('users.index') }}" 
           class="flex flex-col items-center justify-center w-14 h-full text-xs font-semibold transition-all duration-200 
           {{ request()->routeIs('users.*') ? 'text-[#2548cc]' : 'text-gray-400 hover:text-gray-600' }}">
            <svg class="w-5 h-5 mb-0.5 {{ request()->routeIs('users.*') ? 'scale-110 text-[#2548cc]' : '' }} transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="text-[10px] font-bold">Users</span>
        </a>
        @else
        <a href="{{ route('dashboard') }}" 
           class="flex flex-col items-center justify-center w-14 h-full text-xs font-semibold transition-all duration-200 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
        @endif

    </div>
</div>
