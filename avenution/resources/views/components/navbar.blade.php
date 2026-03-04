<nav class="sticky top-0 z-50 border-b border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-[#0F172A]/80 backdrop-blur-md" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <span class="text-gray-900 dark:text-white font-bold text-xl">Avenution</span>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}#features" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary-light transition-colors text-sm font-medium">
                    Features
                </a>
                <a href="{{ route('analyze') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-primary-light transition-colors text-sm font-medium">
                    Analyze
                </a>
                @auth
                    <a href="{{ auth()->user()->hasRole('admin') ? route('admin.dashboard') : route('dashboard') }}" class="text-gray-600 dark:text-gray-300 hover:text-primary transition-colors text-sm font-medium">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-sm font-medium">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-sm font-medium">
                        Login
                    </a>
                @endauth
            </div>

            <!-- Right side -->
            <div class="flex items-center gap-3">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode; document.documentElement.classList.toggle('dark', darkMode)" class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </button>

                <!-- Mobile Menu Button -->
                <button @click="mobileOpen = !mobileOpen" class="md:hidden w-9 h-9 rounded-lg flex items-center justify-center text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg x-show="!mobileOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-show="mobileOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileOpen" x-transition class="md:hidden border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0F172A] px-4 py-3 space-y-2">
        <a href="{{ route('home') }}#features" class="block py-2 text-gray-600 dark:text-gray-300 text-sm font-medium">Features</a>
        <a href="{{ route('analyze') }}" class="block py-2 text-gray-600 dark:text-gray-300 text-sm font-medium">Analyze</a>
        @auth
            <a href="{{ auth()->user()->hasRole('admin') ? route('admin.dashboard') : route('dashboard') }}" class="block py-2 text-gray-600 dark:text-gray-300 text-sm font-medium">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block py-2 text-primary text-sm font-medium">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block py-2 text-gray-600 dark:text-gray-300 text-sm font-medium">Login</a>
        @endauth
    </div>
</nav>
