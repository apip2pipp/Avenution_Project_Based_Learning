<x-admin-layout>
    <x-slot name="title">Manage User</x-slot>

    <x-slot name="header">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.35em] text-slate-500 dark:text-slate-400">Accounts</p>
                <h1 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">Manage User</h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Create, edit, and assign roles for all accounts.</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-950/20 transition-colors hover:bg-sky-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New User
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="grid gap-6 md:grid-cols-2">
            <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="text-sm text-slate-500 dark:text-slate-400">Total Users</div>
                <div class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">{{ $stats['totalUsers'] }}</div>
            </div>
            <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="text-sm text-slate-500 dark:text-slate-400">Admin Accounts</div>
                <div class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">{{ $stats['adminUsers'] }}</div>
            </div>
        </section>

        <section class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <form action="{{ route('admin.users.index') }}" method="GET" class="grid gap-4 lg:grid-cols-[1fr_120px_auto_auto]">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name/email..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                </div>
                <div class="relative">
                    <select name="per_page" class="w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 pr-8 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white" onchange="this.form.submit()">
                        <option value="10" {{ request('per_page', 20) == 10 ? 'selected' : '' }}>Show 10 rows</option>
                        <option value="20" {{ request('per_page', 20) == 20 ? 'selected' : '' }}>Show 20 rows</option>
                        <option value="50" {{ request('per_page', 20) == 50 ? 'selected' : '' }}>Show 50 rows</option>
                    </select>
                </div>
                <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-slate-800">Search</button>
                @if(request('search'))
                    <a href="{{ route('admin.users.index') }}" class="rounded-2xl border border-slate-200 px-5 py-3 text-center text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">Clear</a>
                @endif
            </form>
        </section>

        <section class="overflow-hidden rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            @if($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-800/70">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    <a href="{{ route('admin.users.index', [...request()->query(), 'sort_by' => 'name', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-slate-700 dark:hover:text-slate-300">
                                        User
                                        @if(request('sort_by') === 'name')
                                            <span>{{ request('sort_order') === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Profile</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    <a href="{{ route('admin.users.index', [...request()->query(), 'sort_by' => 'role', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-slate-700 dark:hover:text-slate-300">
                                        Role
                                        @if(request('sort_by') === 'role')
                                            <span>{{ request('sort_order') === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    <a href="{{ route('admin.users.index', [...request()->query(), 'sort_by' => 'analyses_count', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-slate-700 dark:hover:text-slate-300">
                                        Analysis
                                        @if(request('sort_by') === 'analyses_count')
                                            <span>{{ request('sort_order') === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach($users as $user)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-950 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400">{{ $user->username }}</div>
                                        <div class="mt-2 text-xs text-slate-500 dark:text-slate-400">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                                        <div>Age: {{ $user->age ?? '-' }}</div>
                                        <div>Gender: {{ $user->gender ?? '-' }}</div>
                                        <div>Phone: {{ $user->phone ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php($roleName = $user->hasRole('admin') ? 'Admin' : 'User')
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $roleName === 'Admin' ? 'bg-violet-100 text-violet-800 dark:bg-violet-500/15 dark:text-violet-300' : 'bg-sky-100 text-sky-800 dark:bg-sky-500/15 dark:text-sky-300' }}">
                                            {{ $roleName }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-2">
                                            <span class="rounded-full {{ $user->email_verified_at ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-500/15 dark:text-emerald-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300' }} px-3 py-1 text-xs font-semibold">
                                                {{ $user->email_verified_at ? 'Verified' : 'Pending' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-950 dark:text-white">{{ $user->analyses_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="rounded-xl bg-sky-50 px-3 py-2 text-sm font-medium text-sky-700 transition-colors hover:bg-sky-100 dark:bg-sky-500/10 dark:text-sky-300 dark:hover:bg-sky-500/20">Edit</a>
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-xl bg-red-50 px-3 py-2 text-sm font-medium text-red-700 transition-colors hover:bg-red-100 dark:bg-red-500/10 dark:text-red-300 dark:hover:bg-red-500/20">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 px-6 py-5 dark:border-slate-800">
                    {{ $users->links() }}
                </div>
            @else
                <div class="px-6 py-16 text-center text-slate-500 dark:text-slate-400">No regular users found.</div>
            @endif
        </section>
    </div>
</x-admin-layout>