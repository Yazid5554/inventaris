<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inventaris') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('layouts.styles')
    
</head>

<body class="bg-gray-100 h-screen overflow-hidden flex">

    @include('layouts.sidebar')

    {{-- Main Content --}}
    <div id="main-content" class="flex-1 ml-60 flex flex-col h-screen overflow-y-auto transition-all duration-300">

        @include('layouts.header')

        @include('layouts.flash')

        {{-- Page Content --}}
        <main class="flex-1 p-4 overflow-hidden flex flex-col">
            @yield('content')
        </main>
    </div>

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @include('layouts.modal')

    @include('layouts.scripts')

    @include('layouts.login-success')

</body>

</html>