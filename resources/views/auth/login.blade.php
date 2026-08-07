<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login — Inventaris Politeknik Mitra Industri</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Input Focus Glow */
        .input-glow:focus-within {
            box-shadow: 0 0 0 3.5px rgba(37, 72, 204, 0.15);
        }

        /* Button Loading Spinner */
        .btn-loading {
            pointer-events: none;
            opacity: 0.85;
        }
        .btn-loading .btn-text {
            display: none !important;
        }
        .btn-loading .btn-spinner {
            display: inline-flex !important;
        }
    </style>
</head>

<body class="bg-slate-900 text-slate-800 antialiased min-h-screen flex items-center justify-center p-0 sm:p-4 md:p-6 overflow-x-hidden selection:bg-[#2548cc] selection:text-white">

    {{-- Main Container Card --}}
    <div class="w-full max-w-5xl min-h-screen sm:min-h-[520px] md:h-[540px] bg-white sm:rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row border border-slate-200 relative">

        {{-- LEFT PANEL: Full-Bleed Edge-to-Edge Logo Banner --}}
        <div class="hidden md:flex md:w-1/2 h-full bg-[#dbdcde] relative overflow-hidden border-r border-slate-300/80 items-center justify-center">
            {{-- Main Logo Image --}}
            <img src="{{ asset('img/logo-politeknik.png') }}" 
                 alt="Politeknik Mitra Industri" 
                 class="w-full h-full object-cover">
        </div>

        {{-- RIGHT PANEL: Clean Form Login --}}
        <div class="w-full md:w-1/2 bg-white p-6 sm:p-10 lg:p-12 flex flex-col justify-center relative">
            
            {{-- Top Inventaris App Badge (Desktop Top Corner) --}}
            <div class="hidden md:block absolute top-4 left-6 sm:top-6 sm:left-10 lg:left-12">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-blue-50 border border-blue-200/80 text-[#1a2f6e] text-xs font-extrabold shadow-xs">
                    <i class="fas fa-boxes-stacked text-blue-600 text-sm"></i>
                    <span>Inventaris App</span>
                </div>
            </div>

            {{-- Mobile Top Header Official Logo --}}
            <div class="md:hidden flex flex-col items-center text-center mb-6 pt-2">
                <img src="{{ asset('img/logo-politeknik.png') }}" 
                     alt="Logo Politeknik Mitra Industri" 
                     class="max-w-[220px] h-auto object-contain mb-2">
                <p class="text-xs text-slate-500 font-medium">Sistem Informasi Inventaris Gudang</p>
            </div>

            {{-- Form Header --}}
            <div class="mb-4 pt-0 md:-mt-3">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1a2f6e] tracking-tight">Selamat Datang</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Masukkan email & kata sandi akun Anda untuk masuk</p>
            </div>

            {{-- Flash Alert Session Error / Success --}}
            @if (session('error'))
            <div class="mb-4 p-3.5 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold flex items-center gap-2.5">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if ($errors->any())
            <div class="mb-4 p-3.5 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold flex items-center gap-2.5">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            @if (session('success'))
            <div class="mb-4 p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2.5">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            {{-- Main Login Form --}}
            <form id="login-form" action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Email Input --}}
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email</label>
                    <div class="relative input-glow rounded-2xl transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" autofocus
                            placeholder="nama@email.com"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#2548cc] transition-all">
                    </div>
                </div>

                {{-- Password Input --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="passwordInput" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi</label>
                    </div>
                    <div class="relative input-glow rounded-2xl transition-all">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <input type="password" id="passwordInput" name="password" required autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-11 py-3 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-[#2548cc] transition-all">
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </button>
                    </div>
                </div>

                {{-- Remember Me & Info --}}
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 text-slate-600 cursor-pointer select-none">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded text-[#2548cc] focus:ring-[#2548cc] border-slate-300 transition">
                        <span class="font-medium">Ingat Saya</span>
                    </label>
                    <a href="javascript:void(0)" onclick="alert('Silakan hubungi Super Admin untuk reset kata sandi Anda.')" class="text-[#2548cc] font-semibold hover:underline">Bantuan Login</a>
                </div>

                {{-- Submit Button --}}
                <button type="submit" id="submitBtn" class="relative w-full bg-gradient-to-r from-[#1a2f6e] to-[#2548cc] hover:from-blue-900 hover:to-blue-700 text-white font-extrabold py-3.5 px-6 rounded-2xl shadow-md shadow-blue-600/20 hover:shadow-blue-600/30 active:scale-[0.99] transition-all flex items-center justify-center gap-2 cursor-pointer mt-4">
                    <span class="btn-text flex items-center justify-center gap-2">
                        <span>Masuk</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                    </span>
                    <span class="btn-spinner hidden items-center justify-center gap-2 text-white">
                        <svg class="animate-spin w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Memproses...</span>
                    </span>
                </button>
            </form>

            {{-- Footer Info --}}
            <div class="mt-6 md:mt-0 md:absolute md:bottom-5 inset-x-0 text-center text-xs text-slate-400">
                <p>© {{ date('Y') }} Politeknik Mitra Industri</p>
            </div>

        </div>

    </div>

    <script>
        // Toggle Show/Hide Password
        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858-5.908a9.04 9.04 0 012.122-.363c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18" />`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />`;
            }
        }

        // Form Submit Loading State
        document.getElementById('login-form').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('btn-loading');
        });
    </script>
</body>

</html>