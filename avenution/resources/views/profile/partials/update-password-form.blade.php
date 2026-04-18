<section>
    <header>
        <h2 class="text-xl font-bold text-slate-950 dark:text-white">
            {{ auth()->user()->password ? __('Update Password') : __('Set Password') }}
        </h2>

        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            @if(auth()->user()->password)
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            @else
                {{ __('You are logged in with Google. Set a password to enable email login.') }}
            @endif
        </p>
    </header>

    <form method="post" action="{{ route('profile.password.update') }}" class="mt-8 space-y-6">
        @csrf

        {{-- 🔥 HANYA tampil kalau user punya password --}}
        @if(auth()->user()->password)
            <div>
                <x-input-label for="current_password" :value="__('Current Password')" />
                <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
            </div>
        @endif

        <div>
            <x-input-label for="new_password" :value="__('New Password')" />
            <x-text-input id="new_password" name="new_password" type="password" class="mt-1 block w-full" />
            <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="new_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="new_password_confirmation" name="new_password_confirmation" type="password" class="mt-1 block w-full" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ auth()->user()->password ? __('Update Password') : __('Set Password') }}
            </x-primary-button>

            @if (session('success'))
                <p class="text-sm text-green-600">
                    {{ session('success') }}
                </p>
            @endif
        </div>
    </form>
</section>