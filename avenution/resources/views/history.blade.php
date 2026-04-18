<x-app-layout>
    <x-slot name="title">Analysis History</x-slot>

    <x-slot name="header">
        <div>
            <p class="text-sm font-medium uppercase tracking-[0.35em] text-slate-500 dark:text-slate-400">History</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-950 dark:text-white">Analysis History</h1>
            <p class="mt-2 max-w-2xl text-sm text-slate-600 dark:text-slate-400">Review your previous BMI checks and reopen any result report whenever you need it.</p>
        </div>
    </x-slot>

    <div class="rounded-[1.75rem] border border-slate-200/80 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900 overflow-hidden">
        <div class="p-8 border-b border-slate-200/80 dark:border-slate-800">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-950 dark:text-white mb-2">Your Health Journey</h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Track your body condition analyses over time with one unified timeline.</p>
                </div>
                <a href="{{ route('analyze') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Analysis
                </a>
            </div>
        </div>

        @if($analyses->count() > 0)
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/70">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">BMI</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Weight</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Recommendations</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @foreach($analyses as $analysis)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-900 dark:text-white">
                                        {{ $analysis->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">
                                        {{ $analysis->created_at->format('h:i A') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-lg font-bold text-slate-900 dark:text-white">
                                        {{ number_format($analysis->bmi, 1) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if($analysis->bmi_category === 'Normal') bg-emerald-100 text-emerald-800 dark:bg-emerald-500/15 dark:text-emerald-300
                                        @elseif($analysis->bmi_category === 'Underweight') bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300
                                        @elseif($analysis->bmi_category === 'Overweight') bg-orange-100 text-orange-800 dark:bg-orange-500/15 dark:text-orange-300
                                        @else bg-red-100 text-red-800 dark:bg-red-500/15 dark:text-red-300
                                        @endif">
                                        {{ $analysis->bmi_category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900 dark:text-white">
                                    {{ $analysis->weight }} kg
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-400">
                                    {{ $analysis->recommendations->count() }} foods
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

            <div class="md:hidden divide-y divide-slate-200 dark:divide-slate-800">
                @foreach($analyses as $analysis)
                    <div class="p-6 hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                        <div>
                            <div class="text-sm font-medium text-slate-900 dark:text-white mb-1">
                                {{ $analysis->created_at->format('M d, Y - h:i A') }}
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($analysis->bmi_category === 'Normal') bg-emerald-100 text-emerald-800 dark:bg-emerald-500/15 dark:text-emerald-300
                                @elseif($analysis->bmi_category === 'Underweight') bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300
                                @elseif($analysis->bmi_category === 'Overweight') bg-orange-100 text-orange-800 dark:bg-orange-500/15 dark:text-orange-300
                                @else bg-red-100 text-red-800 dark:bg-red-500/15 dark:text-red-300
                                @endif">
                                {{ $analysis->bmi_category }}
                            </span>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="text-right">
                                <div class="text-2xl font-bold text-slate-900 dark:text-white">{{ number_format($analysis->bmi, 1) }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">BMI</div>
                            </div>
                            <a href="{{ route('result.show', $analysis->session_id) }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600">
                                View report
                            </a>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-slate-600 dark:text-slate-400">Weight:</span>
                                <span class="font-medium text-slate-900 dark:text-white ml-1">{{ $analysis->weight }} kg</span>
                            </div>
                            <div>
                                <span class="text-slate-600 dark:text-slate-400">Recommendations:</span>
                                <span class="font-medium text-slate-900 dark:text-white ml-1">{{ $analysis->recommendations->count() }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-6 border-t border-slate-200 dark:border-slate-800">
                {{ $analyses->links() }}
            </div>
        @else
            <div class="p-12 text-center">
                <svg class="w-20 h-20 mx-auto text-slate-400 dark:text-slate-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">No analysis history yet</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 max-w-md mx-auto">Start your first body condition analysis and your reports will appear here.</p>
                <a href="{{ route('analyze') }}" class="inline-flex items-center gap-2 rounded-xl bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600">
                    Start Your First Analysis
                </a>
            </div>
        @endif
    </div>
</x-app-layout>