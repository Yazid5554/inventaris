<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventaris') — {{ config('app.name') }}</title>
    @if(session('login_success'))
    <script>
        sessionStorage.removeItem('app_navigated');
    </script>
    @else
    <script>
        if (sessionStorage.getItem('app_navigated')) {
            document.documentElement.classList.add('no-boot-animation');
        } else {
            sessionStorage.setItem('app_navigated', 'true');
        }
    </script>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.styles')
    
</head>

<body class="bg-gray-100 h-screen overflow-hidden flex">

    @auth
    @include('layouts.sidebar')
    @endauth

    {{-- Main Content --}}
    <div id="main-content" class="flex-1 {{ auth()->check() ? 'ml-0 md:ml-60 pb-20 md:pb-0' : 'ml-0 pb-6' }} flex flex-col h-screen overflow-y-auto transition-all duration-300">

        @auth
        @include('layouts.header')
        @endauth

        @include('layouts.flash')

        {{-- Page Content --}}
        <main class="flex-1 p-4 flex flex-col">
            @yield('content')
        </main>
    </div>

    @auth
    @include('layouts.bottom-nav')
    @endauth

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @include('layouts.modal')

    @include('layouts.scripts')

    @if(session('login_success') && auth()->check())
    @include('layouts.login-success')
    @endif

</body>

</html>