<x-guest-layout>
    <x-slot name="title">Analysis Results</x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Your Health Analysis</h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Analysis completed on {{ $analysis->created_at->format('F j, Y') }}
                </p>
            </div>

            <!-- BMI Summary -->
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-8 mb-8">
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Your BMI</div>
                        <div class="text-5xl font-bold {{ $healthSummary['category_color'] }} mb-2">
                            {{ number_format($healthSummary['bmi'], 1) }}
                        </div>
                        <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $healthSummary['category'] }}</div>
                    </div>

                    <div class="text-center">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Risk Level</div>
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full 
                            @if($healthSummary['risk_level'] == 'low') bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300
                            @elseif($healthSummary['risk_level'] == 'medium') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300
                            @else bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300
                            @endif">
                            <span class="text-2xl font-bold capitalize">{{ $healthSummary['risk_level'] }}</span>
                        </div>
                    </div>

                    <div class="text-center">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">Health Warnings</div>
                        <div class="text-5xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ count($warnings) }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Issues detected</div>
                    </div>
                </div>
            </div>

            <!-- Health Warnings -->
            @if(count($warnings) > 0)
                <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Health Warnings
                    </h2>
                    <div class="space-y-4">
                        @foreach($warnings as $warning)
                            <div class="flex gap-4 p-4 rounded-xl border
                                @if($warning['severity'] == 'high') border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20
                                @else border-yellow-200 dark:border-yellow-800 bg-yellow-50 dark:bg-yellow-900/20
                                @endif">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 @if($warning['severity'] == 'high') text-red-600 @else text-yellow-600 @endif" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="font-semibold @if($warning['severity'] == 'high') text-red-800 dark:text-red-200 @else text-yellow-800 dark:text-yellow-200 @endif mb-1">
                                        {{ $warning['type'] }}
                                    </div>
                                    <div class="@if($warning['severity'] == 'high') text-red-700 dark:text-red-300 @else text-yellow-700 dark:text-yellow-300 @endif text-sm">
                                        {{ $warning['message'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Food Recommendations -->
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-6 h-6 text-primary" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Recommended Foods
                </h2>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($analysis->recommendations as $recommendation)
                        @php
                            $food = $recommendation->food;
                        @endphp
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-6 hover:border-primary dark:hover:border-primary transition-all duration-200 hover:shadow-lg">
                            <!-- Food Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <div class="text-4xl mb-2">{{ $food->emoji }}</div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $food->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 capitalize">{{ $recommendation->timing }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-accent">{{ $recommendation->match_score }}%</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">Match</div>
                                </div>
                            </div>

                            <!-- Nutrition Info -->
                            <div class="grid grid-cols-2 gap-2 mb-4 text-sm">
                                <div class="text-gray-600 dark:text-gray-400">Calories: <span class="font-semibold text-gray-900 dark:text-white">{{ $food->calories }}</span></div>
                                <div class="text-gray-600 dark:text-gray-400">Protein: <span class="font-semibold text-gray-900 dark:text-white">{{ $food->protein }}g</span></div>
                                <div class="text-gray-600 dark:text-gray-400">Carbs: <span class="font-semibold text-gray-900 dark:text-white">{{ $food->carbs }}g</span></div>
                                <div class="text-gray-600 dark:text-gray-400">Fiber: <span class="font-semibold text-gray-900 dark:text-white">{{ $food->fiber }}g</span></div>
                            </div>

                            <!-- Benefits -->
                            @if($food->health_benefits && count($food->health_benefits) > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach(array_slice($food->health_benefits, 0, 3) as $benefit)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $benefit }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- CTA for Guest Users -->
            @guest
                <div class="mt-8 bg-gradient-to-br from-primary/10 to-accent/10 dark:from-primary/20 dark:to-accent/20 rounded-2xl p-8 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Want to save these results?</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Create an account to track your health progress and access your history anytime.
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('register') }}" class="px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-xl font-semibold transition-all duration-200">
                            Create Free Account
                        </a>
                        <a href="{{ route('login') }}" class="px-6 py-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                            Login
                        </a>
                    </div>
                </div>
            @endguest

            <!-- Back Button -->
            <div class="mt-8 text-center">
                <a href="{{ route('analyze') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary-dark dark:text-primary-light font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Do Another Analysis
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
