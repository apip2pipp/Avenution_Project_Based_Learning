<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val)); darkMode && document.documentElement.classList.add('dark')" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Avenution') }} - {{ $title ?? 'Sign In' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased" style="font-family: 'Poppins', sans-serif;">
        <div class="flex min-h-screen bg-white dark:bg-[#0F172A]">
            <!-- LEFT PANEL - Brand Section (Desktop Only) -->
            <div class="hidden lg:flex lg:w-[44%] xl:w-2/5 sticky top-0 h-screen flex-col overflow-hidden relative">
                <!-- Background -->
                <div class="absolute inset-0 bg-gradient-to-br from-[#0c0f1a] via-[#111827] to-[#0c0f1a]"></div>
                
                <!-- Glows -->
                <div class="absolute -top-20 -right-20 w-96 h-96 bg-[#C62828]/25 rounded-full blur-[80px]"></div>
                <div class="absolute bottom-0 left-0 w-80 h-80 bg-[#C62828]/10 rounded-full blur-[60px]"></div>
                <div class="absolute top-1/2 right-0 w-64 h-64 bg-[#16A34A]/8 rounded-full blur-[80px]"></div>

                <!-- Subtle grid texture -->
                <div class="absolute inset-0 opacity-[0.04]" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 40px 40px;"></div>

                <!-- Content -->
                <div class="relative z-10 flex flex-col h-full px-10 py-8">
                    <!-- Logo -->
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-xl bg-[#C62828] flex items-center justify-center shadow-lg shadow-red-900/50">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <span class="text-white tracking-tight font-bold text-lg">Avenution</span>
                    </div>

                    <!-- Main text -->
                    <div class="flex-1 flex flex-col justify-center">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#C62828]/20 border border-[#C62828]/30 mb-6">
                                <svg class="w-3 h-3 text-red-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-red-200 text-xs font-medium">AI-Powered Nutrition Platform</span>
                            </div>

                            <h2 class="text-white mb-4 font-bold leading-tight" style="font-size: clamp(1.9rem, 2.4vw, 2.6rem);">
                                Your Personal<br>
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ef5350] to-[#ff8a80]">AI Nutrition</span><br>
                                Coach
                            </h2>

                            <p class="text-gray-400 mb-8 leading-relaxed max-w-xs text-sm">
                                Advanced AI analyzes your body metrics to deliver personalized nutrition plans that actually work for you.
                            </p>

                            <!-- Features -->
                            <div class="space-y-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-300 text-sm">AI-powered body condition analysis</span>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-300 text-sm">Personalized nutrition plans</span>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-300 text-sm">Real-time progress tracking</span>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-300 text-sm">HIPAA-compliant & secure</span>
                                </div>
                            </div>
                        </div>

                        <!-- Stat card -->
                        <div class="mt-10 bg-white/5 border border-white/10 rounded-2xl p-4 backdrop-blur-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-9 h-9 rounded-full bg-[#C62828]/30 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white text-xs font-semibold">Today's Nutrition Score</p>
                                    <p class="text-gray-400 text-xs truncate">Mediterranean Diet Plan</p>
                                </div>
                                <div class="text-right shrink-0">
                                    <p class="text-[#4ade80] font-bold text-sm">96%</p>
                                    <p class="text-gray-500 text-xs">Match</p>
                                </div>
                            </div>
                            <div class="w-full bg-white/10 rounded-full h-1.5">
                                <div class="bg-gradient-to-r from-[#C62828] to-[#4ade80] h-1.5 rounded-full transition-all" style="width: 96%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial -->
                    <div class="bg-white/5 border border-white/10 rounded-2xl p-5 backdrop-blur-sm">
                        <div class="flex gap-0.5 mb-3">
                            @for($i = 0; $i < 5; $i++)
                            <svg class="w-3.5 h-3.5 fill-yellow-400 text-yellow-400" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                        <p class="text-gray-300 text-sm leading-relaxed mb-4">
                            "Avenution completely transformed how I think about food. Lost 8kg in 3 months with the AI recommendations!"
                        </p>
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#C62828] to-[#ef5350] flex items-center justify-center text-white text-xs font-bold shrink-0">
                                RD
                            </div>
                            <div>
                                <p class="text-white text-xs font-semibold">Rina Dewi</p>
                                <p class="text-gray-500 text-xs">Jakarta, Indonesia 🇮🇩</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT PANEL - Form Section -->
            <div class="flex-1 flex flex-col min-h-screen">
                <!-- Top bar -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800/60">
                    <a href="{{ route('home') }}" class="flex items-center gap-1.5 text-gray-500 dark:text-gray-400 hover:text-[#C62828] transition-colors text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Home
                    </a>

                    <!-- Mobile logo -->
                    <div class="flex lg:hidden items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-[#C62828] flex items-center justify-center">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <span class="text-gray-900 dark:text-white font-bold text-sm">Avenution</span>
                    </div>

                    <button @click="darkMode = !darkMode" class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" aria-label="Toggle theme">
                        <svg x-show="!darkMode" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Scrollable form area -->
                <div class="flex-1 flex items-start justify-center px-6 py-10 overflow-y-auto">
                    <div class="w-full max-w-[360px]">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
