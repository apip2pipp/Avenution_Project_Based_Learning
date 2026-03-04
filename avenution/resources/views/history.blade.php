<x-app-layout>
    <x-slot name="title">Analysis History</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Analysis History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Your Health Journey</h1>
                            <p class="text-gray-600 dark:text-gray-400">Track your body condition analyses over time</p>
                        </div>
                        <a href="{{ route('analyze') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-xl font-semibold transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Analysis
                        </a>
                    </div>
                </div>

                @if($analyses->count() > 0)
                    <!-- Desktop Table View -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800/80">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">BMI</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Weight</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Recommendations</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($analyses as $analysis)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $analysis->created_at->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $analysis->created_at->format('h:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-lg font-bold text-gray-900 dark:text-white">
                                                {{ number_format($analysis->bmi, 1) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if($analysis->bmi_category === 'Normal') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                                                @elseif($analysis->bmi_category === 'Underweight') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400
                                                @elseif($analysis->bmi_category === 'Overweight') bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400
                                                @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400
                                                @endif">
                                                {{ $analysis->bmi_category }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $analysis->weight }} kg
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 text-sm text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $analysis->recommendations->count() }} foods
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <a href="{{ route('result.show', $analysis->session_id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg font-medium transition-all text-sm">
                                                View Report
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($analyses as $analysis)
                            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white mb-1">
                                            {{ $analysis->created_at->format('M d, Y - h:i A') }}
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($analysis->bmi_category === 'Normal') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                                            @elseif($analysis->bmi_category === 'Underweight') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400
                                            @elseif($analysis->bmi_category === 'Overweight') bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400
                                            @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400
                                            @endif">
                                            {{ $analysis->bmi_category }}
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                            {{ number_format($analysis->bmi, 1) }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">BMI</div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Weight:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1">{{ $analysis->weight }} kg</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600 dark:text-gray-400">Recommendations:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1">{{ $analysis->recommendations->count() }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('result.show', $analysis->session_id) }}" class="block w-full py-2 bg-primary hover:bg-primary-dark text-white text-center rounded-lg font-medium transition-all">
                                    View Full Report
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                        {{ $analyses->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="p-12 text-center">
                        <svg class="w-20 h-20 mx-auto text-gray-400 dark:text-gray-600 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Analysis History Yet</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                            Start your health journey by completing your first body condition analysis. Get personalized food recommendations based on your health metrics.
                        </p>
                        <a href="{{ route('analyze') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-primary hover:bg-primary-dark text-white rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-primary/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Start Your First Analysis
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
