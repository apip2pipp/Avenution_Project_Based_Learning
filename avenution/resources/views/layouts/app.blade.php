<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val)); darkMode && document.documentElement.classList.add('dark')" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/icon_Avenution.png') }}">

        <title>{{ config('app.name', 'Avenution') }} - {{ $title ?? 'Smart Food Recommendations' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-[#F9FAFB] dark:bg-[#0F172A] text-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="min-h-screen pt-16">
            @include('components.navbar')

            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                @isset($header)
                    <header class="mb-8 border-b border-slate-200/70 pb-6 dark:border-slate-800/80">
                        {{ $header }}
                    </header>
                @endisset

                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm dark:border-emerald-900/40 dark:bg-emerald-900/20 dark:text-emerald-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm dark:border-red-900/40 dark:bg-red-900/20 dark:text-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </div>

            @include('components.footer')
        </div>
    </body>
</html>
