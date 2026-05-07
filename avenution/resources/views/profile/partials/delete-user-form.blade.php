<section class="space-y-6">
    <header>
        <h2 class="text-xl font-bold text-red-700 dark:text-red-400">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            {{ __('This will delete your local account, analyses, recommendations, and history. After that, you can sign in again with the same Google account and it will be created as a fresh user.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Reset Test Account') }}</x-danger-button>

    
<x-modal 
    name="confirm-user-deletion" 
    :show="auth()->user()->password && $errors->userDeletion->isNotEmpty()" 
    focusable>
    
    <form method="post" action="{{ route('profile.reset-test-account') }}" class="p-6">
        @csrf
        @method('delete')

        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
            {{ __('Are you sure you want to reset this test account?') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ __('Your local login record, analysis history, and recommendations will be removed. You can then log in again with the same Google account as a new user.') }}
        </p>

        {{-- 🔥 CONDITIONAL --}}
        @if(auth()->user()->password)

            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                {{ __('Please enter your password to confirm.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

        @else

            <p class="mt-2 text-sm text-yellow-500">
                {{ __('You are logged in via Google. No password is required.') }}
            </p>

        @endif

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button type="submit" class="ms-3">
                {{ __('Reset Test Account') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
</section>
