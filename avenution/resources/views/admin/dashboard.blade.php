<x-admin-layout>
    <x-slot name="title">Dashboard</x-slot>

    <x-slot name="header">
        <div>
            <p class="text-sm font-medium uppercase tracking-[0.35em] text-slate-500 dark:text-slate-400">Overview</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">Admin Dashboard</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-400">Monitor the food catalog, review registered users, and keep the admin workspace focused on the three core actions.</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <section class="rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-slate-800 p-8 text-white shadow-2xl shadow-slate-950/20 ring-1 ring-white/10">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white/70">Admin workspace</div>
                    <h2 class="mt-5 text-3xl font-bold leading-tight sm:text-4xl">Manage foods, manage users, and keep the dashboard clean.</h2>
                    <p class="mt-4 text-sm leading-6 text-white/70">Use the sidebar to jump between the overview, food catalog, and user management without extra headings or duplicate entry points.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3 lg:w-[420px]">
                    <a href="{{ route('admin.foods.index') }}" class="rounded-2xl bg-white/10 px-4 py-4 backdrop-blur transition-colors hover:bg-white/15">
                        <div class="text-xs uppercase tracking-[0.25em] text-white/45">Foods</div>
                        <div class="mt-2 text-2xl font-bold">{{ $stats['totalFoods'] }}</div>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="rounded-2xl bg-white/10 px-4 py-4 backdrop-blur transition-colors hover:bg-white/15">
                        <div class="text-xs uppercase tracking-[0.25em] text-white/45">Users</div>
                        <div class="mt-2 text-2xl font-bold">{{ $stats['totalUsers'] }}</div>
                    </a>
                    <div class="rounded-2xl bg-white/10 px-4 py-4 backdrop-blur">
                        <div class="text-xs uppercase tracking-[0.25em] text-white/45">Analyses</div>
                        <div class="mt-2 text-2xl font-bold">{{ $stats['totalAnalyses'] }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-3">
            <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Total Users</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">{{ $stats['totalUsers'] }}</h3>
                    </div>
                    <div class="rounded-2xl bg-sky-50 p-3 text-sky-600 dark:bg-sky-500/10 dark:text-sky-300">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Total Foods</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">{{ $stats['totalFoods'] }}</h3>
                    </div>
                    <div class="rounded-2xl bg-orange-50 p-3 text-orange-600 dark:bg-orange-500/10 dark:text-orange-300">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </div>

            <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Analyses</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">{{ $stats['totalAnalyses'] }}</h3>
                    </div>
                    <div class="rounded-2xl bg-emerald-50 p-3 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <a href="{{ route('admin.foods.index') }}" class="group rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Manage Foods</p>
                        <h3 class="mt-3 text-2xl font-bold text-slate-950 dark:text-white">Food catalog control</h3>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-400">View, filter, create, edit, and delete food entries from one place.</p>
                    </div>
                    <span class="rounded-2xl bg-slate-950 px-4 py-3 text-white transition-colors group-hover:bg-orange-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </span>
                </div>
            </a>

            <a href="{{ route('admin.analyses.export') }}" class="group rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Export Analyses</p>
                        <h3 class="mt-3 text-2xl font-bold text-slate-950 dark:text-white">Download Excel report</h3>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-400">Export every analysis row with user identity, health metrics, lifestyle data, BMI, and recommendation summary.</p>
                    </div>
                    <span class="rounded-2xl bg-slate-950 px-4 py-3 text-white transition-colors group-hover:bg-emerald-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v8m0 0l-3-3m3 3l3-3m-9 8h12"></path></svg>
                    </span>
                </div>
            </a>

            <a href="{{ route('admin.users.index') }}" class="group rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Manage User</p>
                        <h3 class="mt-3 text-2xl font-bold text-slate-950 dark:text-white">User account</h3>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-400">Create, update, and assign roles for user accounts from one place.</p>
                    </div>
                    <span class="rounded-2xl bg-slate-950 px-4 py-3 text-white transition-colors group-hover:bg-sky-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </span>
                </div>
            </a>
        </section>

        <section class="rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex flex-col gap-4 border-b border-slate-200/80 px-6 py-5 dark:border-slate-800 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-950 dark:text-white">Recent Analyses</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Latest activity from the analysis flow.</p>
                </div>
            </div>

            @if($recentAnalyses->count() > 0)
                <div class="border-b border-slate-200/80 px-6 py-4 dark:border-slate-800">
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="grid gap-4 lg:grid-cols-[1fr_120px_auto]">
                        <div>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name/email..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        </div>
                        <div class="relative">
                            <select name="per_page" class="w-full appearance-none rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 pr-8 text-sm text-slate-900 outline-none transition focus:border-slate-400 focus:bg-white dark:border-slate-700 dark:bg-slate-800 dark:text-white" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>Show 10 rows</option>
                                <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>Show 20 rows</option>
                                <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>Show 50 rows</option>
                            </select>
                        </div>
                        <button type="submit" class="rounded-2xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-slate-800">Search</button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-800/70">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    <a href="{{ route('admin.dashboard', [...request()->query(), 'sort_by' => 'created_at', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-slate-700 dark:hover:text-slate-300">
                                        Date
                                        @if(request('sort_by') === 'created_at')
                                            <span>{{ request('sort_order') === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">User</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                                    <a href="{{ route('admin.dashboard', [...request()->query(), 'sort_by' => 'bmi', 'sort_order' => request('sort_order') === 'asc' ? 'desc' : 'asc']) }}" class="hover:text-slate-700 dark:hover:text-slate-300">
                                        BMI
                                        @if(request('sort_by') === 'bmi')
                                            <span>{{ request('sort_order') === 'asc' ? '▲' : '▼' }}</span>
                                        @endif
                                    </a>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Recommendations</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach($recentAnalyses as $analysis)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300">{{ $analysis->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($analysis->user)
                                            <div class="text-sm font-medium text-slate-900 dark:text-white">{{ $analysis->user->name }}</div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $analysis->user->email }}</div>
                                        @else
                                            <span class="text-sm text-slate-500 dark:text-slate-400 italic">Guest</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900 dark:text-white">{{ number_format($analysis->bmi, 1) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold
                                            @if($analysis->bmi_category === 'Normal') bg-emerald-100 text-emerald-800 dark:bg-emerald-500/15 dark:text-emerald-300
                                            @elseif($analysis->bmi_category === 'Underweight') bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300
                                            @elseif($analysis->bmi_category === 'Overweight') bg-orange-100 text-orange-800 dark:bg-orange-500/15 dark:text-orange-300
                                            @else bg-red-100 text-red-800 dark:bg-red-500/15 dark:text-red-300
                                            @endif">
                                            {{ $analysis->bmi_category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">{{ $analysis->recommendations->count() }} foods</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200/80 px-6 py-5 dark:border-slate-800">
                    {{ $recentAnalyses->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">No analyses yet</div>
            @endif
        </section>
    </div>
</x-admin-layout>
