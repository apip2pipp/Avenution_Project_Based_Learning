<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <x-slot name="header">
        <div>
            <p class="text-sm font-medium uppercase tracking-[0.35em] text-slate-500 dark:text-slate-400">Overview</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">User Dashboard</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-400">Track your progress, review your latest analysis, and jump into your next health check quickly.</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <section class="rounded-[2rem] bg-gradient-to-br from-slate-950 via-slate-900 to-slate-800 p-8 text-white shadow-2xl shadow-slate-950/20 ring-1 ring-white/10">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white/70">Welcome back</div>
                    <h2 class="mt-5 text-3xl font-bold leading-tight sm:text-4xl">Hi, {{ $user->name }}. Keep your nutrition journey moving.</h2>
                    <p class="mt-4 text-sm leading-6 text-white/70">You can review your BMI trend, open your latest report, or start a new analysis from this workspace.</p>
                </div>

                <div class="grid gap-3 sm:grid-cols-3 lg:w-[460px]">
                    <div class="rounded-2xl bg-white/10 px-4 py-4 backdrop-blur">
                        <div class="text-xs uppercase tracking-[0.25em] text-white/45">Analyses</div>
                        <div class="mt-2 text-2xl font-bold">{{ $totalAnalyses }}</div>
                    </div>
                    <div class="rounded-2xl bg-white/10 px-4 py-4 backdrop-blur">
                        <div class="text-xs uppercase tracking-[0.25em] text-white/45">Avg BMI</div>
                        <div class="mt-2 text-2xl font-bold">{{ $avgBMI ? number_format($avgBMI, 1) : 'N/A' }}</div>
                    </div>
                    <div class="rounded-2xl bg-white/10 px-4 py-4 backdrop-blur">
                        <div class="text-xs uppercase tracking-[0.25em] text-white/45">Category</div>
                        <div class="mt-2 text-lg font-bold">{{ $latestAnalysis ? $latestAnalysis->bmi_category : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 md:grid-cols-3">
            <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Total Analyses</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">{{ $totalAnalyses }}</h3>
                    </div>
                    <div class="rounded-2xl bg-sky-50 p-3 text-sky-600 dark:bg-sky-500/10 dark:text-sky-300">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Average BMI</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">{{ $avgBMI ? number_format($avgBMI, 1) : 'N/A' }}</h3>
                    </div>
                    <div class="rounded-2xl bg-emerald-50 p-3 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-300">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Current Category</p>
                        <h3 class="mt-2 text-2xl font-bold text-slate-950 dark:text-white">{{ $latestAnalysis ? $latestAnalysis->bmi_category : 'N/A' }}</h3>
                    </div>
                    <div class="rounded-2xl bg-orange-50 p-3 text-orange-600 dark:bg-orange-500/10 dark:text-orange-300">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <a href="{{ route('analyze') }}" class="group rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Analysis</p>
                        <h3 class="mt-3 text-2xl font-bold text-slate-950 dark:text-white">Start a new check</h3>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-400">Run a new body analysis to refresh your BMI category and recommendations.</p>
                    </div>
                    <span class="rounded-2xl bg-slate-950 px-4 py-3 text-white transition-colors group-hover:bg-emerald-500">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </span>
                </div>
            </a>

            @if($latestAnalysis)
                <a href="{{ route('result.show', $latestAnalysis->session_id) }}" class="group rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Latest Report</p>
                            <h3 class="mt-3 text-2xl font-bold text-slate-950 dark:text-white">Open last analysis</h3>
                            <p class="mt-3 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-400">{{ $latestAnalysis->created_at->format('M d, Y') }} · BMI {{ number_format($latestAnalysis->bmi, 1) }} · {{ $latestAnalysis->bmi_category }}</p>
                        </div>
                        <span class="rounded-2xl bg-slate-950 px-4 py-3 text-white transition-colors group-hover:bg-sky-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </span>
                    </div>
                </a>
            @else
                <div class="rounded-[1.75rem] border border-slate-200/80 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <p class="text-sm font-medium uppercase tracking-[0.25em] text-slate-500 dark:text-slate-400">Latest Report</p>
                    <h3 class="mt-3 text-2xl font-bold text-slate-950 dark:text-white">No report yet</h3>
                    <p class="mt-3 max-w-xl text-sm leading-6 text-slate-600 dark:text-slate-400">Complete your first analysis to see your BMI category and personalized report.</p>
                </div>
            @endif
        </section>

        <section class="rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between border-b border-slate-200/80 px-6 py-5 dark:border-slate-800">
                <div>
                    <h3 class="text-xl font-bold text-slate-950 dark:text-white">Recent Analyses</h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Your latest health analysis activity.</p>
                </div>
                <a href="{{ route('history') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">View all</a>
            </div>

            @if($analyses->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-800/70">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">BMI</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                            @foreach($analyses as $analysis)
                                <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-700 dark:text-slate-300">{{ $analysis->created_at->format('M d, Y') }}</td>
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
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('result.show', $analysis->session_id) }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600">
                                            View report
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">No analyses yet</h3>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Start your first analysis to build your personal health history.</p>
                    <a href="{{ route('analyze') }}" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600">Start analysis</a>
                </div>
            @endif
        </section>
    </div>
</x-app-layout>