<x-auth-layout>
    <x-slot name="title">Forgot Password</x-slot>

    <div x-data="{ email: '{{ old('email') }}', loading: false }">
        <!-- Heading -->
        <div class="mb-7">
            <h1 class="text-gray-900 dark:text-white font-bold text-2xl">Reset your password</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1.5">
                Enter your email and we will send a secure reset link.
            </p>
        </div>

        <!-- Helper card -->
        <div class="mb-5 p-3.5 rounded-xl bg-gray-50 dark:bg-gray-800/60 border border-gray-200 dark:border-gray-700">
            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                Make sure you use the same email you registered with. The reset link is usually delivered in under 1 minute.
            </p>
        </div>

        @if (session('status'))
            <div class="flex items-start gap-2.5 px-3.5 py-3 bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800/50 rounded-xl mb-4">
                <svg class="w-4 h-4 text-green-600 dark:text-green-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <p class="text-sm text-green-700 dark:text-green-300">{{ session('status') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="flex items-start gap-2.5 px-3.5 py-3 bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/50 rounded-xl mb-4">
                <svg class="w-4 h-4 text-[#C62828] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-red-700 dark:text-red-400">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" @submit="loading = true">
            @csrf

            <div>
                <label for="email" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                    Email Address
                </label>
                <div class="relative">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <input
                        type="email"
                        x-model="email"
                        name="email"
                        id="email"
                        placeholder="you@example.com"
                        required
                        autofocus
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                    >
                </div>
            </div>

            <button
                type="submit"
                :disabled="loading"
                class="w-full flex items-center justify-center gap-2 py-3.5 bg-[#C62828] hover:bg-[#b71c1c] disabled:opacity-70 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-red-900/25 mt-6"
            >
                <span x-show="loading">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <span x-text="loading ? 'Sending reset link…' : 'Send Password Reset Link'">Send Password Reset Link</span>
            </button>
        </form>

        <p class="mt-5 text-center text-sm text-gray-500 dark:text-gray-400">
            Remember your password?
            <a href="{{ route('login') }}" class="text-[#C62828] font-semibold hover:underline">
                Back to Sign In
            </a>
        </p>
    </div>
</x-auth-layout>
