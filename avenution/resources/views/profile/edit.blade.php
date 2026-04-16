<x-app-layout>
    <x-slot name="title">Profile</x-slot>

    <x-slot name="header">
        <div>
            <p class="text-sm font-medium uppercase tracking-[0.35em] text-slate-500 dark:text-slate-400">Account</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">Profile Settings</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-400">Manage your profile information, update your password, and control account security.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-4 shadow-sm sm:p-8 dark:border-slate-800 dark:bg-slate-900">
            <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-4 shadow-sm sm:p-8 dark:border-slate-800 dark:bg-slate-900">
            <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="rounded-[1.75rem] border border-red-200/70 bg-white p-4 shadow-sm sm:p-8 dark:border-red-900/40 dark:bg-slate-900">
            <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
