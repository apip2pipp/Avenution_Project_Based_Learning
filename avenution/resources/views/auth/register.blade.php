<x-auth-layout>
    <x-slot name="title">Create Account</x-slot>

    <div x-data="{ 
        name: '{{ old('name') }}',
        email: '{{ old('email') }}',
        password: '',
        confirmPassword: '',
        healthGoal: '{{ old('health_goal') }}',
        loading: false,
        get passwordMatch() {
            return this.confirmPassword.length > 0 && this.confirmPassword === this.password;
        },
        get passwordMismatch() {
            return this.confirmPassword.length > 0 && this.confirmPassword !== this.password;
        }
    }">
        <!-- Heading -->
        <div class="mb-7">
            <h1 class="text-gray-900 dark:text-white font-bold text-2xl">Create your account</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1.5">Join thousands getting personalized nutrition plans</p>
        </div>

        <!-- Mode toggle tabs -->
        <div class="flex bg-gray-100 dark:bg-gray-800 rounded-xl p-1 mb-6">
            <a href="{{ route('login') }}" class="flex-1 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 text-center">
                Sign In
            </a>
            <a href="{{ route('register') }}" class="flex-1 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm text-center">
                Sign Up
            </a>
        </div>

        <!-- Google button (visual only) -->
        <button type="button" class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-700 dark:text-gray-200 font-medium text-sm hover:bg-gray-50 dark:hover:bg-gray-700/80 hover:border-gray-300 dark:hover:border-gray-600 transition-all duration-200 shadow-sm mb-5 group">
            <svg width="18" height="18" viewBox="0 0 18 18" class="shrink-0">
                <path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/>
                <path d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.258c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332C2.438 15.983 5.482 18 9 18z" fill="#34A853"/>
                <path d="M3.964 10.707c-.18-.54-.282-1.117-.282-1.707s.102-1.167.282-1.707V4.961H.957C.347 6.175 0 7.55 0 9s.348 2.825.957 4.039l3.007-2.332z" fill="#FBBC05"/>
                <path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0 5.482 0 2.438 2.017.957 4.961L3.964 7.293C4.672 5.163 6.656 3.58 9 3.58z" fill="#EA4335"/>
            </svg>
            Continue with Google
        </button>

        <!-- OR divider -->
        <div class="flex items-center gap-3 mb-5">
            <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
            <span class="text-gray-400 dark:text-gray-500 text-xs font-medium">or continue with email</span>
            <div class="flex-1 h-px bg-gray-200 dark:bg-gray-700"></div>
        </div>

        <!-- Error banner -->
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

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" @submit="loading = true">
            @csrf

            <div class="space-y-4">
                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                        Full Name
                    </label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <input 
                            type="text"
                            x-model="name"
                            name="name"
                            id="name"
                            placeholder="Your full name"
                            required
                            autofocus
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                        >
                    </div>
                </div>

                <!-- Email -->
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
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all"
                        >
                    </div>
                </div>

                <!-- Password -->
                <x-password-input 
                    name="password" 
                    id="password"
                    placeholder="Min. 6 characters"
                    :showStrength="true"
                    required
                >
                    Password
                </x-password-input>

                <!-- Confirm Password -->
                <div x-data="{ showConfirm: false }">
                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <input 
                            :type="showConfirm ? 'text' : 'password'"
                            x-model="confirmPassword"
                            name="password_confirmation"
                            id="password_confirmation"
                            placeholder="Repeat your password"
                            required
                            :class="passwordMismatch ? 'border-red-400 focus:ring-red-500/30 focus:border-red-500' : (passwordMatch ? 'border-green-400 focus:ring-green-500/30 focus:border-green-500' : 'border-gray-200 dark:border-gray-700 focus:ring-[#C62828]/30 focus:border-[#C62828]')"
                            class="w-full pl-10 pr-11 py-3 rounded-xl bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 text-sm transition-all"
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
                    <div x-show="passwordMatch" class="text-xs text-green-500 mt-1.5 flex items-center gap-1" style="display: none;">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Passwords match
                    </div>
                    <div x-show="passwordMismatch" class="text-xs text-red-500 mt-1.5" style="display: none;">
                        Passwords don't match
                    </div>
                </div>

                <!-- Health Goal -->
                <div>
                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-2">
                        Health Goal <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <button 
                            type="button"
                            @click="healthGoal = healthGoal === 'lose_weight' ? '' : 'lose_weight'"
                            :class="healthGoal === 'lose_weight' ? 'border-[#C62828] bg-[#C62828]/10 text-[#C62828] dark:text-red-300' : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
                            class="flex items-center gap-2 px-3 py-2.5 rounded-xl border text-xs font-medium transition-all duration-150"
                        >
                            <span class="text-base">🏃</span>
                            Lose Weight
                        </button>
                        <button 
                            type="button"
                            @click="healthGoal = healthGoal === 'build_muscle' ? '' : 'build_muscle'"
                            :class="healthGoal === 'build_muscle' ? 'border-[#C62828] bg-[#C62828]/10 text-[#C62828] dark:text-red-300' : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
                            class="flex items-center gap-2 px-3 py-2.5 rounded-xl border text-xs font-medium transition-all duration-150"
                        >
                            <span class="text-base">💪</span>
                            Build Muscle
                        </button>
                        <button 
                            type="button"
                            @click="healthGoal = healthGoal === 'improve_health' ? '' : 'improve_health'"
                            :class="healthGoal === 'improve_health' ? 'border-[#C62828] bg-[#C62828]/10 text-[#C62828] dark:text-red-300' : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
                            class="flex items-center gap-2 px-3 py-2.5 rounded-xl border text-xs font-medium transition-all duration-150"
                        >
                            <span class="text-base">❤️</span>
                            Improve Health
                        </button>
                        <button 
                            type="button"
                            @click="healthGoal = healthGoal === 'stay_balanced' ? '' : 'stay_balanced'"
                            :class="healthGoal === 'stay_balanced' ? 'border-[#C62828] bg-[#C62828]/10 text-[#C62828] dark:text-red-300' : 'border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:border-gray-300 dark:hover:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
                            class="flex items-center gap-2 px-3 py-2.5 rounded-xl border text-xs font-medium transition-all duration-150"
                        >
                            <span class="text-base">⚖️</span>
                            Stay Balanced
                        </button>
                    </div>
                    <input type="hidden" name="health_goal" :value="healthGoal">
                </div>
            </div>

            <!-- Submit button -->
            <button 
                type="submit"
                :disabled="loading"
                class="w-full flex items-center justify-center gap-2 py-3.5 bg-[#C62828] hover:bg-[#b71c1c] disabled:opacity-70 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-red-900/25 mt-5"
            >
                <span x-show="loading">
                    <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </span>
                <span x-text="loading ? 'Creating account…' : 'Create Account'">Create Account</span>
            </button>
        </form>

        <!-- Switch mode -->
        <p class="mt-5 text-center text-sm text-gray-500 dark:text-gray-400">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-[#C62828] font-semibold hover:underline">
                Sign In
            </a>
        </p>

        <!-- Guest link -->
        <div class="mt-4 text-center">
            <a href="{{ route('analyze') }}" class="text-xs text-gray-400 dark:text-gray-500 hover:text-[#C62828] dark:hover:text-[#ef4444] transition-colors">
                Continue without account →
            </a>
        </div>

        <!-- Terms notice -->
        <p class="mt-5 text-xs text-gray-400 dark:text-gray-500 text-center leading-relaxed">
            By creating an account, you agree to our 
            <span class="text-[#C62828] cursor-pointer hover:underline">Terms of Service</span> and 
            <span class="text-[#C62828] cursor-pointer hover:underline">Privacy Policy</span>.
        </p>
    </div>
</x-auth-layout>
