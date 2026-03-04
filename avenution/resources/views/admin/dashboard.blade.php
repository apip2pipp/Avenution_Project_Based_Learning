<x-app-layout>
    <x-slot name="title">Admin Dashboard</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-gradient-to-r from-primary to-primary-dark rounded-2xl shadow-lg p-8 mb-8 text-white">
                <h1 class="text-3xl font-bold mb-2">
                    Admin Dashboard
                </h1>
                <p class="text-white/80">
                    Manage foods, users, and monitor system activity
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Users</div>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['totalUsers'] }}</div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Analyses</div>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['totalAnalyses'] }}</div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent dark:text-accent" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Total Foods</div>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['totalFoods'] }}</div>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                <a href="{{ route('admin.foods.index') }}" class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all group">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Manage Foods</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Add, edit, or remove food items</p>
                        </div>
                        <svg class="w-8 h-8 text-primary group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>

                <a href="{{ route('admin.foods.create') }}" class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all group">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Add New Food</h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Create a new food entry</p>
                        </div>
                        <svg class="w-8 h-8 text-accent group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Recent Analyses -->
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Recent Analyses</h2>
                
                @if($recentAnalyses->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-800/80">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">BMI</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Recommendations</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentAnalyses as $analysis)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $analysis->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($analysis->user)
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $analysis->user->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $analysis->user->email }}</div>
                                            @else
                                                <span class="text-sm text-gray-500 dark:text-gray-400 italic">Guest</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-gray-900 dark:text-white">
                                                {{ number_format($analysis->bmi, 1) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                @if($analysis->bmi_category === 'Normal') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                                                @elseif($analysis->bmi_category === 'Underweight') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400
                                                @elseif($analysis->bmi_category === 'Overweight') bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400
                                                @else bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400
                                                @endif">
                                                {{ $analysis->bmi_category }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                            {{ $analysis->recommendations->count() }} foods
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        No analyses yet
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
