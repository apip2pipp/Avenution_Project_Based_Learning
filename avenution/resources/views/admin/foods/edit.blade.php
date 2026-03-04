<x-app-layout>
    <x-slot name="title">Edit Food</x-slot>

    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.foods.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Food') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-8">
                <form action="{{ route('admin.foods.update', $food) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Basic Information</h3>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Food Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $food->name) }}" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select name="category" id="category" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="">Select category</option>
                                    <option value="breakfast" {{ old('category', $food->category) === 'breakfast' ? 'selected' : '' }}>Breakfast</option>
                                    <option value="lunch" {{ old('category', $food->category) === 'lunch' ? 'selected' : '' }}>Lunch</option>
                                    <option value="dinner" {{ old('category', $food->category) === 'dinner' ? 'selected' : '' }}>Dinner</option>
                                    <option value="snack" {{ old('category', $food->category) === 'snack' ? 'selected' : '' }}>Snack</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="emoji" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Emoji <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="emoji" id="emoji" value="{{ old('emoji', $food->emoji) }}" required maxlength="4"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    placeholder="🥗">
                                @error('emoji')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="image_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Image URL
                                </label>
                                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $food->image_url) }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    placeholder="https://example.com/image.jpg">
                                @error('image_url')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="3" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('description', $food->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Nutritional Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Nutritional Information</h3>
                        
                        <div class="grid md:grid-cols-3 gap-6">
                            <div>
                                <label for="calories" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Calories (kcal) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="calories" id="calories" value="{{ old('calories', $food->calories) }}" required min="0" step="1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('calories')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="protein" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Protein (g) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="protein" id="protein" value="{{ old('protein', $food->protein) }}" required min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('protein')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="carbs" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Carbs (g) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="carbs" id="carbs" value="{{ old('carbs', $food->carbs) }}" required min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('carbs')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Fat (g) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="fat" id="fat" value="{{ old('fat', $food->fat) }}" required min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('fat')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fiber" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Fiber (g) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="fiber" id="fiber" value="{{ old('fiber', $food->fiber) }}" required min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('fiber')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Tags & Benefits -->
                    <div class="mb-8">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Tags & Benefits</h3>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="dietary_tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Dietary Tags <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="dietary_tags" id="dietary_tags" value="{{ old('dietary_tags', implode(', ', $food->dietary_tags)) }}" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    placeholder="vegetarian, gluten-free, low-sodium">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Separate multiple tags with commas</p>
                                @error('dietary_tags')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="health_benefits" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Health Benefits <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="health_benefits" id="health_benefits" value="{{ old('health_benefits', implode(', ', $food->health_benefits)) }}" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white"
                                    placeholder="Heart-healthy, High fiber, Rich in vitamins">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Separate multiple benefits with commas</p>
                                @error('health_benefits')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-xl font-semibold transition-all">
                            Update Food
                        </button>
                        <a href="{{ route('admin.foods.index') }}" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition-all">
                            Cancel
                        </a>
                        <form action="{{ route('admin.foods.destroy', $food) }}" method="POST" class="ml-auto" onsubmit="return confirm('Are you sure you want to delete this food? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all">
                                Delete Food
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
