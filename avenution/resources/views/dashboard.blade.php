<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Welcome back, {{ $user->name }}! 👋
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Track your health journey and get personalized food recommendations.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Analyses</div>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalAnalyses }}</div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Average BMI</div>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $avgBMI ? number_format($avgBMI, 1) : 'N/A' }}
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Current Category</div>
                            <div class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ $latestAnalysis ? $latestAnalysis->bmi_category : 'N/A' }}
                            </div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Latest Analysis -->
            @if($latestAnalysis)
                <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Latest Analysis</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Date:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $latestAnalysis->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">BMI:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($latestAnalysis->bmi, 1) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Category:</span>
                                    <span class="font-semibold text-gray-900 dark:text-white">{{ $latestAnalysis->bmi_category }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('result.show', $latestAnalysis->session_id) }}" class="block w-full py-3 bg-primary hover:bg-primary-dark text-white text-center rounded-xl font-semibold transition-all duration-200">
                                View Full Report
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Analyses -->
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Recent Analyses</h2>
                    <a href="{{ route('history') }}" class="text-primary hover:text-primary-dark dark:text-primary-light font-medium text-sm">
                        View All →
                    </a>
                </div>

                @if($analyses->count() > 0)
                    <div class="space-y-4">
                        @foreach($analyses as $analysis)
                            <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-primary dark:hover:border-primary transition-all">
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white">{{ $analysis->created_at->format('F j, Y') }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        BMI: {{ number_format($analysis->bmi, 1) }} - {{ $analysis->bmi_category }}
                                    </div>
                                </div>
                                <a href="{{ route('result.show', $analysis->session_id) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-primary hover:text-white dark:hover:bg-primary text-gray-700 dark:text-gray-300 rounded-lg font-medium transition-all text-sm">
                                    View
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-400 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No analyses yet</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Start your health journey by analyzing your body condition</p>
                        <a href="{{ route('analyze') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-xl font-semibold transition-all duration-200">
                            Start Analysis
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
