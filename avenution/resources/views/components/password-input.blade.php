@props(['disabled' => false, 'name', 'id', 'value' => '', 'placeholder' => '', 'showStrength' => false, 'showForgotPassword' => false])

<div x-data="{ show: false, password: '{{ $value }}' }">
    <div class="flex items-center justify-between mb-1.5">
        <label for="{{ $id }}" class="text-xs font-semibold text-gray-600 dark:text-gray-400">
            {{ $slot }}
        </label>
        @if($showForgotPassword)
        <a href="{{ route('password.request') }}" class="text-xs text-[#C62828] hover:underline font-medium">
            Forgot password?
        </a>
        @endif
    </div>
    <div class="relative">
        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
        <input 
            :type="show ? 'text' : 'password'"
            x-model="password"
            name="{{ $name }}"
            id="{{ $id }}"
            {{ $disabled ? 'disabled' : '' }}
            placeholder="{{ $placeholder }}"
            {!! $attributes->merge(['class' => 'w-full pl-10 pr-11 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/60 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#C62828]/30 focus:border-[#C62828] text-sm transition-all']) !!}
        >
        <button 
            type="button"
            @click="show = !show"
            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors"
        >
            <svg x-show="!show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="show" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
        </button>
    </div>
    
    @if($showStrength)
    <div x-show="password.length > 0" class="mt-2" style="display: none;">
        <div class="flex gap-1 mb-1">
            <div class="h-1 flex-1 rounded-full transition-all duration-300"
                :class="password.length >= 6 ? (password.length >= 10 ? 'bg-green-500' : 'bg-yellow-500') : 'bg-red-500'">
            </div>
            <div class="h-1 flex-1 rounded-full transition-all duration-300"
                :class="password.length >= 10 ? 'bg-green-500' : (password.length >= 6 ? 'bg-yellow-500' : 'bg-gray-200 dark:bg-gray-700')">
            </div>
            <div class="h-1 flex-1 rounded-full transition-all duration-300"
                :class="password.length >= 10 ? 'bg-green-500' : 'bg-gray-200 dark:bg-gray-700'">
            </div>
        </div>
        <p class="text-xs"
            :class="password.length >= 10 ? 'text-green-500' : (password.length >= 6 ? 'text-yellow-500' : 'text-red-500')">
            <span x-text="password.length >= 10 ? 'Strong' : (password.length >= 6 ? 'Fair' : 'Weak')"></span> password
        </p>
    </div>
    @endif
</div>
