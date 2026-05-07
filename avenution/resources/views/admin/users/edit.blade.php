<x-admin-layout>
    <x-slot name="title">Edit User</x-slot>

    <x-slot name="header">
        <div>
            <p class="text-sm font-medium uppercase tracking-[0.35em] text-slate-500 dark:text-slate-400">Users</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">Edit User</h1>
            <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Updating regular user account: {{ $user->name }}</p>
        </div>
    </x-slot>

    <section class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm sm:p-8 lg:p-10 dark:border-slate-800 dark:bg-slate-900">
        @include('admin.users._form', [
            'user' => $user,
            'action' => route('admin.users.update', $user),
            'method' => 'PUT',
            'submitLabel' => 'Update User',
        ])
    </section>
</x-admin-layout>
