<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false, darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val)); darkMode && document.documentElement.classList.add('dark')" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('images/icon_Avenution.png') }}">

        <title>{{ config('app.name', 'Avenution') }} - {{ $title ?? 'Admin' }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-[#F3F6FB] dark:bg-[#020617] text-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.12),_transparent_30%),radial-gradient(circle_at_top_right,_rgba(249,115,22,0.12),_transparent_25%)] dark:bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.12),_transparent_30%),radial-gradient(circle_at_top_right,_rgba(249,115,22,0.12),_transparent_25%)]">
            <aside
                class="fixed inset-y-0 left-0 z-40 w-72 transform border-r border-white/10 bg-slate-950 text-white shadow-2xl transition-transform duration-300 lg:translate-x-0"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            >
                <div class="flex h-full flex-col">
                    <div class="flex items-center justify-between border-b border-white/10 px-6 py-6">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                            <img src="{{ asset('images/lightmode.png') }}" class="h-10 w-10 rounded-xl bg-white/10 p-1.5 object-contain">
                            <div>
                                <div class="text-sm uppercase tracking-[0.3em] text-white/40">Admin</div>
                                <div class="text-lg font-bold leading-tight">Avenution</div>
                            </div>
                        </a>
                        <button class="lg:hidden rounded-xl border border-white/10 p-2 text-white/70 hover:bg-white/10" @click="sidebarOpen = false">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="overflow-y-auto px-6 py-6 space-y-6">
                        <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                            <div class="text-xs uppercase tracking-[0.3em] text-white/40">Signed in as</div>
                            <div class="mt-2 text-lg font-semibold">{{ auth()->user()->name }}</div>
                            <div class="mt-1 text-sm text-white/60">{{ auth()->user()->email }}</div>
                        </div>

                        <nav class="space-y-2">
                            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white text-slate-950 shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-slate-950/10' : 'bg-white/10' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 13h6v7H4v-7zm10-9h6v16h-6V4zM4 4h6v5H4V4zm10 8h6v4h-6v-4z"></path>
                                    </svg>
                                </span>
                                <div>
                                    <div class="font-semibold">Dashboard</div>
                                    <div class="text-xs {{ request()->routeIs('admin.dashboard') ? 'text-slate-600' : 'text-white/45' }}">Overview</div>
                                </div>
                            </a>

                            <a href="{{ route('admin.foods.index') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3 transition-colors {{ request()->routeIs('admin.foods.*') ? 'bg-white text-slate-950 shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('admin.foods.*') ? 'bg-slate-950/10' : 'bg-white/10' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </span>
                                <div>
                                    <div class="font-semibold">Manage Foods</div>
                                    <div class="text-xs {{ request()->routeIs('admin.foods.*') ? 'text-slate-600' : 'text-white/45' }}">Food catalog</div>
                                </div>
                            </a>

                            <a href="{{ route('admin.users.index') }}" class="group flex items-center gap-3 rounded-2xl px-4 py-3 transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-white text-slate-950 shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-slate-950/10' : 'bg-white/10' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </span>
                                <div>
                                    <div class="font-semibold">Manage User</div>
                                    <div class="text-xs {{ request()->routeIs('admin.users.*') ? 'text-slate-600' : 'text-white/45' }}">User accounts</div>
                                </div>
                            </a>
                        </nav>
                    </div>

                    <div class="mt-auto border-t border-white/10 p-6 space-y-3">
                        <button @click="darkMode = !darkMode; document.documentElement.classList.toggle('dark', darkMode)" class="flex w-full items-center justify-between rounded-2xl border border-white/10 px-4 py-3 text-left text-sm text-white/70 transition-colors hover:bg-white/10 hover:text-white">
                            <span>Toggle theme</span>
                            <svg x-show="!darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646A9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <svg x-show="darkMode" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </button>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-950 transition-colors hover:bg-white/90">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="lg:pl-72">
                <div class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/80 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/70 lg:hidden">
                    <div class="flex items-center justify-between px-4 py-4 sm:px-6">
                        <button class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200" @click="sidebarOpen = true">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            Menu
                        </button>
                        <div class="text-sm font-semibold text-slate-700 dark:text-slate-200">Admin Panel</div>
                    </div>
                </div>

                <header class="border-b border-slate-200/70 bg-white/80 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/70">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $title ?? 'Admin' }}</h1>
                        @endisset
                    </div>
                </header>

                @if (session('success'))
                    <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm dark:border-emerald-900/40 dark:bg-emerald-900/20 dark:text-emerald-200">
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-red-800 shadow-sm dark:border-red-900/40 dark:bg-red-900/20 dark:text-red-200">
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    {{ $slot }}
                </main>
            </div>

            <div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-slate-950/60 lg:hidden" @click="sidebarOpen = false"></div>
        </div>
    </body>
</html>