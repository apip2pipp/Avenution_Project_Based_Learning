<x-admin-layout>
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
                <form action="{{ route('admin.foods.update', $food) }}" method="POST" x-data="foodForm('{{ $food->category }}')">
                    @csrf
                    @method('PUT')
                    @php
                        $dietaryTagOptions = config('food-label-options.dietary_tags', []);
                        $healthBenefitOptions = config('food-label-options.health_benefits', []);
                        $selectedDietaryTags = old('dietary_tags', $food->dietary_tags ?? []);
                        $selectedHealthBenefits = old('health_benefits', $food->health_benefits ?? []);

                        $selectedDietaryTags = is_array($selectedDietaryTags) ? $selectedDietaryTags : [];
                        $selectedHealthBenefits = is_array($selectedHealthBenefits) ? $selectedHealthBenefits : [];
                    @endphp

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
                                <select name="category" id="category" required @change="updateEmoji($event)"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="">Select category</option>
                                    <option value="Protein Hewani" {{ old('category', $food->category) === 'Protein Hewani' ? 'selected' : '' }}>Protein Hewani</option>
                                    <option value="Protein Nabati" {{ old('category', $food->category) === 'Protein Nabati' ? 'selected' : '' }}>Protein Nabati</option>
                                    <option value="Karbohidrat" {{ old('category', $food->category) === 'Karbohidrat' ? 'selected' : '' }}>Karbohidrat</option>
                                    <option value="Sayuran" {{ old('category', $food->category) === 'Sayuran' ? 'selected' : '' }}>Sayuran</option>
                                    <option value="Buah" {{ old('category', $food->category) === 'Buah' ? 'selected' : '' }}>Buah</option>
                                    <option value="Dairy" {{ old('category', $food->category) === 'Dairy' ? 'selected' : '' }}>Dairy</option>
                                    <option value="Lainnya" {{ old('category', $food->category) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('category')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="emoji" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Emoji <span class="text-red-500">*</span> <span class="text-xs text-gray-500">(Auto-generated)</span>
                                </label>
                                <div class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl bg-gray-100 dark:bg-gray-600 text-gray-900 dark:text-white text-center text-3xl font-bold" x-text="emoji">{{ $food->emoji }}</div>
                                <input type="hidden" name="emoji" id="emoji" :value="emoji">
                            </div>
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
                                    Fiber (g)
                                </label>
                                <input type="number" name="fiber" id="fiber" value="{{ old('fiber', $food->fiber) }}" min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('fiber')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="sugars" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Sugars (g)
                                </label>
                                <input type="number" name="sugars" id="sugars" value="{{ old('sugars', $food->sugars) }}" min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('sugars')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="sodium" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Sodium (mg)
                                </label>
                                <input type="number" name="sodium" id="sodium" value="{{ old('sodium', $food->sodium) }}" min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('sodium')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cholesterol" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Cholesterol (mg)
                                </label>
                                <input type="number" name="cholesterol" id="cholesterol" value="{{ old('cholesterol', $food->cholesterol) }}" min="0" step="0.1"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('cholesterol')
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
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Dietary Tags <span class="text-xs text-gray-500">(choose all that apply)</span>
                                </label>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    @foreach ($dietaryTagOptions as $tag)
                                        <label class="flex items-center gap-3 rounded-xl border border-gray-200 dark:border-gray-700 px-4 py-3 bg-gray-50 dark:bg-gray-700/50 hover:border-primary cursor-pointer transition-colors">
                                            <input type="checkbox" name="dietary_tags[]" value="{{ $tag }}" {{ in_array($tag, $selectedDietaryTags, true) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $tag }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('dietary_tags')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Health Benefits <span class="text-xs text-gray-500">(choose all that apply)</span>
                                </label>
                                <div class="grid gap-3 sm:grid-cols-2">
                                    @foreach ($healthBenefitOptions as $benefit)
                                        <label class="flex items-center gap-3 rounded-xl border border-gray-200 dark:border-gray-700 px-4 py-3 bg-gray-50 dark:bg-gray-700/50 hover:border-primary cursor-pointer transition-colors">
                                            <input type="checkbox" name="health_benefits[]" value="{{ $benefit }}" {{ in_array($benefit, $selectedHealthBenefits, true) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-primary focus:ring-primary">
                                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $benefit }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('health_benefits')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all">
                            Update Food
                        </button>
                        <a href="{{ route('admin.foods.index') }}" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold transition-all">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function foodForm(initialCategory) {
            const categoryEmojis = {
                'Protein Hewani': '🍗',
                'Protein Nabati': '🫘',
                'Karbohidrat': '🍞',
                'Sayuran': '🥬',
                'Buah': '🍎',
                'Dairy': '🥛',
                'Lainnya': '🍽️',
            };

            return {
                emoji: categoryEmojis[initialCategory] || '🍽️',
                updateEmoji(event) {
                    const category = event.target.value;
                    this.emoji = categoryEmojis[category] || '🍽️';
                }
            };
        }
    </script>
</x-admin-layout>
