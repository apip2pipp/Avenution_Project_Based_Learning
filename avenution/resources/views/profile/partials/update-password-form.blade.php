<section
    x-data="{ confirmPopup: false }"
>

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

    <!-- FORM -->
    <form
        method="post"
        action="{{ route('profile.password.update') }}"
        class="mt-8 space-y-6"
        @submit.prevent="confirmPopup = true"
        id="passwordForm"
    >

        @csrf

        {{-- CURRENT PASSWORD --}}
        @if(auth()->user()->password)
            <div>
                <x-input-label
                    for="current_password"
                    :value="__('Current Password')"
                />

                <x-text-input
                    id="current_password"
                    name="current_password"
                    type="password"
                    class="mt-1 block w-full"
                />

                <x-input-error
                    :messages="$errors->get('current_password')"
                    class="mt-2"
                />
            </div>
        @endif

        {{-- NEW PASSWORD --}}
        <div>
            <x-password-input
                id="new_password"
                name="new_password"
                placeholder="Enter new password"
            >
                {{ __('New Password') }}
            </x-password-input>

            <x-input-error
                :messages="$errors->get('new_password')"
                class="mt-2"
            />
        </div>

        {{-- CONFIRM PASSWORD --}}
        <div>
            <x-password-input
                id="new_password_confirmation"
                name="new_password_confirmation"
                placeholder="Confirm new password"
            >
                {{ __('Confirm Password') }}
            </x-password-input>
        </div>

        {{-- BUTTON --}}
        <div class="flex items-center gap-4">

            <x-primary-button type="submit">
                {{ auth()->user()->password ? __('Update Password') : __('Set Password') }}
            </x-primary-button>

            @if (session('success'))
                <p class="text-sm text-green-600">
                    {{ session('success') }}
                </p>
            @endif

        </div>

    </form>


    <!-- POPUP -->
    <div
        x-show="confirmPopup"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm"
        style="display: none;"
    >

        <!-- CARD -->
        <div class="w-full max-w-md rounded-3xl bg-white dark:bg-slate-900 p-8 shadow-2xl text-center">

            <!-- ICON -->
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-10 h-10 text-blue-600"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />

                </svg>

            </div>

            <!-- TITLE -->
            <h2 class="mt-5 text-2xl font-bold text-slate-900 dark:text-white">
                Confirm Password Update
            </h2>

            <!-- MESSAGE -->
            <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                Are you sure you want to update your password?
                Please make sure your new password is secure.
            </p>

            <!-- BUTTON -->
            <div class="mt-7 flex items-center justify-center gap-4">

                <!-- CANCEL -->
                <button
                    type="button"
                    @click="confirmPopup = false"
                    class="rounded-xl border border-slate-300 dark:border-slate-700 px-5 py-3 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                >
                    Cancel
                </button>

                <!-- OK -->
                <button
                    type="button"
                    onclick="document.getElementById('passwordForm').submit()"
                    class="rounded-xl bg-blue-600 hover:bg-blue-700 px-6 py-3 text-sm font-semibold text-white transition"
                >
                    Yes, Update
                </button>

            </div>

        </div>

    </div>

</section>