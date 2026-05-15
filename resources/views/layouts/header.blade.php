{{-- Top Header --}}
<header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between sticky top-0 z-20">
    <div class="flex-1 max-w-xl">
        <form action="{{ route('barang.index') }}" method="GET" class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" name="search" placeholder="Cari inventaris, ruangan, atau laporan..."
                class="w-full pl-9 pr-4 py-2 bg-gray-100 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                value="{{ request('search') }}">
        </form>
    </div>

    <div class="flex items-center gap-4 ml-4">
        {{-- QR Scan Icon --}}
        <a href="{{ route('scan.index') }}" class="text-gray-500 hover:text-[#1a2f6e] transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
        </a>
        <div class="w-px h-6 bg-gray-300/40"></div>

        {{-- User Dropdown --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 text-sm text-gray-700 hover:text-[#1a2f6e] transition">
                @if(auth()->user()->avatar)
                <img src="{{ Storage::url(auth()->user()->avatar) }}"
                    class="w-8 h-8 rounded-full object-cover border-2 border-gray-200">
                @else
                <div class="w-8 h-8 rounded-full bg-[#1a2f6e] flex items-center justify-center text-white text-xs font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                @endif
                <span class="font-medium">My Account</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" @click.outside="open = false"
                class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-gray-100 z-50">

                {{-- User Info --}}
                <div class="px-4 py-3 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        @if(auth()->user()->avatar)
                        <img src="{{ Storage::url(auth()->user()->avatar) }}"
                            class="w-10 h-10 rounded-full object-cover">
                        @else
                        <div class="w-10 h-10 rounded-full bg-[#1a2f6e] flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                            @if(auth()->user()->role === 'super_admin')
                            <p class="text-xs text-blue-600 font-semibold uppercase tracking-[0.1em]">Super admin</p>
                            @endif
                            <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                </div>

                {{-- Upload Avatar --}}
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-xs text-gray-400 mb-2 font-medium uppercase tracking-wide">Ganti Foto Profil</p>
                    <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatar-form">
                        @csrf
                        <div class="flex gap-2 items-center">
                            <input type="file" name="avatar" accept="image/*" id="avatar-input"
                                class="hidden" onchange="document.getElementById('avatar-form').submit()">
                            <label for="avatar-input"
                                class="cursor-pointer flex items-center gap-2 text-xs text-[#1a2f6e] border border-[#1a2f6e] px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Pilih Foto
                            </label>
                            <span class="text-xs text-gray-400">Max 2MB</span>
                        </div>
                    </form>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition rounded-b-xl flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>