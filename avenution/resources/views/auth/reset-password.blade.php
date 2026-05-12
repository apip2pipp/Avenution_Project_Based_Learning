<x-auth-layout>
    <x-slot name="title">Reset Password</x-slot>

    <div x-data="{ email: '{{ old('email', $request->email) }}', loading: false, showConfirm: false }">
        <!-- Heading -->
        <div class="mb-7">
            <h1 class="text-gray-900 dark:text-white font-bold text-2xl">Create a new password</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1.5">
                Use a strong password to secure your account and continue safely.
            </p>
        </div>

        <!-- Helper card -->
        <div class="mb-5 p-3.5 rounded-xl bg-gray-50 dark:bg-gray-800/60 border border-gray-200 dark:border-gray-700">
            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                Password must be at least 8 characters. Use a mix of letters, numbers, and symbols for better security.
            </p>
        </div>

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

        <form method="POST" action="{{ route('password.store') }}" @submit="loading = true">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="space-y-5">
                <!-- Email Address -->
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
                            autocomplete="username"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                        >
                    </div>
                </div>

                <!-- New Password -->
                <x-password-input
                    name="password"
                    id="password"
                    placeholder="Enter your new password"
                    :showStrength="true"
                    required
                    autocomplete="new-password"
                >
                    New Password
                </x-password-input>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                        Confirm New Password
                    </label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <input
                            :type="showConfirm ? 'text' : 'password'"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="Re-enter new password"
                            class="w-full pl-10 pr-11 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                        >
                        <button
                            type="button"
                            @click="showConfirm = !showConfirm"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
                        >
                            <svg x-show="!showConfirm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showConfirm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
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
                <span x-text="loading ? 'Resetting password…' : 'Reset Password'">Reset Password</span>
            </button>
        </form>

        <p class="mt-5 text-center text-sm text-gray-500 dark:text-gray-400">
            Remember your password?
            <a href="{{ route('login') }}" class="text-[#C62828] font-semibold hover:underline">
                Back to Sign In
            </a>
        </p>
    </div>

    @if (session('status'))
        <div 
            x-data="{ show: true }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-init="setTimeout(() => show = false, 3500)"
            class="fixed top-5 right-5 z-50"
            style="display: none;"
        >
            <div class="flex items-start gap-3 rounded-2xl bg-green-500 px-5 py-4 shadow-2xl text-white min-w-[320px]">

                <!-- ICON -->
                <div class="mt-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                        class="w-6 h-6" 
                        fill="none" 
                        viewBox="0 0 24 24" 
                        stroke="currentColor">
                        <path stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <!-- TEXT -->
                <div>
                    <h3 class="font-semibold text-sm">
                        Password Updated
                    </h3>

                    <p class="text-sm text-green-100 mt-0.5">
                        Your password has been reset successfully.
                    </p>
                </div>

            </div>
        </div>
    @endif
</x-auth-layout>
