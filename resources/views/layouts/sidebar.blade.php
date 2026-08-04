<aside id="sidebar" class="w-60 min-h-screen bg-[#1a2f6e] hidden md:flex flex-col fixed top-0 left-0 z-30 transition-all duration-300 overflow-hidden">

    {{-- Avatar & Nama --}}
    <div class="flex flex-col items-center pt-10 pb-2 px-4 overflow-hidden animate-sidebar" style="animation-delay: 0ms;">

        @auth
        {{-- Avatar --}}
        <div id="sidebar-avatar" class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center mb-3 border-4 border-white/20 transition-all duration-300 flex-shrink-0 shadow-lg overflow-hidden">
            @if(auth()->user()->avatar)
            <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-full h-full object-cover">
            @else
            <svg class="w-16 h-16 text-[#1a2f6e] transition-all duration-300" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
            </svg>
            @endif
        </div>

        {{-- Nama User --}}
        <p id="sidebar-name" class="text-white font-bold text-2xl truncate text-center max-w-full px-2">
            {{ auth()->user()->name }}
        </p>
        @if(auth()->user()->role === 'super_admin')
        <p id="sidebar-role" class="text-[#a7c8ff] text-sm mt-1 uppercase tracking-[0.18em]">Super admin</p>
        @endif
        @else
        <div id="sidebar-avatar" class="w-24 h-24 rounded-full bg-blue-500/20 border-2 border-white/20 flex items-center justify-center mb-3 text-white">
            <svg class="w-12 h-12 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
        </div>
        <p class="text-white font-bold text-lg text-center">Pengunjung</p>
        <span class="text-[#a7c8ff] text-xs font-semibold uppercase tracking-wider bg-white/10 px-2.5 py-0.5 rounded-full mt-1">Mode Publik</span>
        @endauth

        {{-- Divider --}}
        <div id="sidebar-divider" class="w-44 h-0.5 bg-white/40 mt-3 mb-2"></div>

    </div>

    {{-- Navigation --}}
    <nav class="flex-1 pt-2 pb-4 px-3 space-y-1 z-10 overflow-x-hidden">
        <a href="{{ route('dashboard') }}" style="animation-delay: 200ms;"
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 animate-sidebar
            {{ request()->routeIs('dashboard')
                ? 'bg-blue-600 text-white shadow-md'
                : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('barang.index') }}" style="animation-delay: 400ms;"
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 animate-sidebar
            {{ request()->routeIs('barang.*')
                ? 'bg-blue-600 text-white shadow-md'
                : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span>Barang</span>
        </a>

        <a href="{{ route('lokasi.index') }}" style="animation-delay: 600ms;"
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 animate-sidebar
            {{ request()->routeIs('lokasi.*')
                ? 'bg-blue-600 text-white shadow-md'
                : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span>Ruangan</span>
        </a>

        @if(auth()->check() && auth()->user()->role === 'super_admin')
        <a href="{{ route('users.index') }}" style="animation-delay: 800ms;"
            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 animate-sidebar
            {{ request()->routeIs('users.*')
                ? 'bg-blue-600 text-white shadow-md'
                : 'text-gray-300 hover:bg-blue-800 hover:text-white' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span>Users</span>
        </a>
        @endif

    </nav>

    {{-- System Info Box --}}
    <div class="px-4 mb-2 z-10 system-info-box transition-all duration-300 animate-sidebar" style="animation-delay: 1000ms;">
        <div class="bg-white/10 rounded-xl p-4 border border-white/10 backdrop-blur-md shadow-lg">
            <div class="flex justify-between items-center mb-2">
                <span class="text-[11px] font-semibold text-blue-200 uppercase tracking-wider">Kapasitas Server</span>
                <span class="text-[11px] font-bold text-white">74%</span>
            </div>
            <div class="w-full bg-[#1a2f6e] rounded-full h-1.5 mb-3 overflow-hidden">
                <div class="bg-blue-400 h-1.5 rounded-full" style="width: 74%"></div>
            </div>
            <div class="flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-[10px] text-blue-200 tracking-wide uppercase font-bold">Sistem Online</span>
            </div>
        </div>
    </div>

    {{-- Collapse Button --}}
    <div class="w-full py-4 flex justify-center z-10 border-t border-white/10 mt-auto animate-sidebar" style="animation-delay: 1200ms;">
        <button onclick="toggleSidebar()"
            class="flex items-center justify-center w-10 h-10 rounded-full bg-white/5 border border-white/20 hover:bg-white/10 transition text-white backdrop-blur-sm shadow-sm">
            <svg id="collapse-icon" class="w-5 h-5 text-white transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
    </div>

    {{-- Watermark Background --}}
    <svg class="w-80 h-80 text-white/[0.03] absolute -bottom-16 -left-16 z-0 pointer-events-none transform -rotate-12" fill="currentColor" viewBox="0 0 24 24">
        <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375z" />
        <path fill-rule="evenodd" d="M3.087 9l.54 9.176A3 3 0 006.62 21h10.757a3 3 0 002.995-2.824L20.913 9H3.087zm6.163 3.75A.75.75 0 0110 12h4a.75.75 0 010 1.5h-4a.75.75 0 01-.75-.75z" clip-rule="evenodd" />
    </svg>

</aside>