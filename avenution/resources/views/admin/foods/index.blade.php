<x-app-layout>
    <x-slot name="title">Manage Foods</x-slot>

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manage Foods') }}
            </h2>
            <a href="{{ route('admin.foods.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-dark text-white rounded-lg font-medium transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Food
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-800/80">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Food</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Nutrition</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Dietary Tags</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($foods as $food)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">{{ $food->emoji }}</span>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $food->name }}</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ Str::limit($food->description, 50) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($food->category === 'breakfast') bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400
                                            @elseif($food->category === 'lunch') bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-400
                                            @elseif($food->category === 'dinner') bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-400
                                            @else bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400
                                            @endif">
                                            {{ ucfirst($food->category) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs text-gray-900 dark:text-white space-y-1">
                                            <div><span class="font-semibold">Cal:</span> {{ $food->calories }}</div>
                                            <div><span class="font-semibold">P:</span> {{ $food->protein }}g <span class="font-semibold">C:</span> {{ $food->carbs }}g <span class="font-semibold">F:</span> {{ $food->fat }}g</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($food->dietary_tags, 0, 3) as $tag)
                                                <span class="px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400 rounded text-xs">
                                                    {{ $tag }}
                                                </span>
                                            @endforeach
                                            @if(count($food->dietary_tags) > 3)
                                                <span class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded text-xs">
                                                    +{{ count($food->dietary_tags) - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.foods.edit', $food) }}" class="px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50 text-blue-700 dark:text-blue-400 rounded-lg font-medium transition-all text-sm">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.foods.destroy', $food) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this food?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1.5 bg-red-100 dark:bg-red-900/30 hover:bg-red-200 dark:hover:bg-red-900/50 text-red-700 dark:text-red-400 rounded-lg font-medium transition-all text-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    {{ $foods->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
