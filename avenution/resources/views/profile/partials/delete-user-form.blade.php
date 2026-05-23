<section 
    class="space-y-6"
    x-data="{ successPopup: false }"
>
    <header>
        <h2 class="text-xl font-bold text-red-700 dark:text-red-400">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
            {{ __('This will delete your local account, analyses, recommendations, and history. After that, you can sign in again with the same Google account and it will be created as a fresh user.') }}
        </p>
    </header>

    <!-- OPEN MODAL BUTTON -->
    <x-danger-button
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >
        {{ __('Reset Account') }}
    </x-danger-button>

    <!-- MODAL -->
    <x-modal 
        name="confirm-user-deletion" 
        :show="auth()->user()->password && $errors->userDeletion->isNotEmpty()" 
        focusable
    >

        <form 
            method="post" 
            action="{{ route('profile.reset-test-account') }}" 
            class="p-6"

            @submit.prevent="
                fetch($el.action, {
                    method: 'POST',
                    body: new FormData($el),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(response => {
                    if(response.ok){
                        successPopup = true
                        $dispatch('close')
                    }
                })
            "
        >
            @csrf
            @method('delete')

            <!-- TITLE -->
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">
                {{ __('Are you sure you want to reset this test account?') }}
            </h2>

            <!-- DESC -->
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                {{ __('Your local login record, analysis history, and recommendations will be removed. You can then log in again with the same Google account as a new user.') }}
            </p>

            {{-- PASSWORD CHECK --}}
            @if(auth()->user()->password)

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-400">
                    {{ __('Please enter your password to confirm.') }}
                </p>

                <div class="mt-6">
                    <x-input-label 
                        for="password" 
                        value="{{ __('Password') }}" 
                        class="sr-only" 
                    />

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="{{ __('Password') }}"
                    />

                    <x-input-error 
                        :messages="$errors->userDeletion->get('password')" 
                        class="mt-2" 
                    />
                </div>

            @else

                <p class="mt-3 text-sm text-yellow-500">
                    {{ __('You are logged in via Google. No password is required.') }}
                </p>

            @endif

            <!-- BUTTON -->
            <div class="mt-6 flex justify-end gap-3">

                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button type="submit">
                    {{ __('Reset Account') }}
                </x-danger-button>

            </div>
        </form>
    </x-modal>

    <!-- SUCCESS POPUP -->
    <div
        x-show="successPopup"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="fixed inset-0 z-[999] flex items-center justify-center bg-black/50 backdrop-blur-sm"
        style="display: none;"
    >

        <!-- CARD -->
        <div class="w-full max-w-md rounded-3xl bg-white dark:bg-slate-900 p-8 shadow-2xl text-center">

            <!-- ICON -->
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30">
                
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-10 h-10 text-green-600"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 13l4 4L19 7" />

                </svg>

            </div>

            <!-- TITLE -->
            <h2 class="mt-5 text-2xl font-bold text-slate-900 dark:text-white">
                Account Deleted
            </h2>

            <!-- MESSAGE -->
            <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                Your account, analyses, recommendations, and history have been successfully removed.
            </p>

            <!-- BUTTON -->
            <div class="mt-7">

                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-green-600 hover:bg-green-700 px-6 py-3 text-sm font-semibold text-white transition"
                >
                    OK
                </a>

            </div>

        </div>
    </div>
</section>