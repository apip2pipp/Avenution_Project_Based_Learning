<x-guest-layout>
    <x-slot name="title">Analyze Your Health - Get Personalized Recommendations</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Body Condition Analysis</h1>
                <p class="text-gray-600 dark:text-gray-400 text-lg">
                    Enter your health information to get personalized food recommendations
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-gray-800/60 rounded-2xl shadow-lg p-8">
                <form action="{{ route('analyze.post') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Personal Information -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                            </svg>
                            Personal Information
                        </h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Age -->
                            <div>
                                <label for="age" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Age (years)</label>
                                <input type="number" name="age" id="age" value="{{ old('age') }}" min="1" max="120" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                @error('age')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Gender</label>
                                <select name="gender" id="gender" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Weight -->
                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Weight (kg)</label>
                                <input type="number" name="weight" id="weight" value="{{ old('weight') }}" min="20" max="300"  step="0.1" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                @error('weight')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Height -->
                            <div>
                                <label for="height" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Height (cm)</label>
                                <input type="number" name="height" id="height" value="{{ old('height') }}" min="50" max="250" step="0.1" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                @error('height')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Health Metrics -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                            </svg>
                            Health Metrics
                        </h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Blood Pressure Systolic -->
                            <div>
                                <label for="blood_pressure_systolic" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blood Pressure (Systolic) mmHg</label>
                                <input type="number" name="blood_pressure_systolic" id="blood_pressure_systolic" value="{{ old('blood_pressure_systolic') }}" min="70" max="200" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                @error('blood_pressure_systolic')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Blood Pressure Diastolic -->
                            <div>
                                <label for="blood_pressure_diastolic" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blood Pressure (Diastolic) mmHg</label>
                                <input type="number" name="blood_pressure_diastolic" id="blood_pressure_diastolic" value="{{ old('blood_pressure_diastolic') }}" min="40" max="130" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                @error('blood_pressure_diastolic')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Blood Sugar -->
                            <div>
                                <label for="blood_sugar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blood Sugar (mg/dL)</label>
                                <input type="number" name="blood_sugar" id="blood_sugar" value="{{ old('blood_sugar') }}" min="50" max="400" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                @error('blood_sugar')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cholesterol -->
                            <div>
                                <label for="cholesterol" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cholesterol (mg/dL)</label>
                                <input type="number" name="cholesterol" id="cholesterol" value="{{ old('cholesterol') }}" min="100" max="400" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                @error('cholesterol')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Lifestyle & Goals -->
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"></path>
                            </svg>
                            Lifestyle & Goals
                        </h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <!-- Activity Level -->
                            <div>
                                <label for="activity_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Activity Level</label>
                                <select name="activity_level" id="activity_level" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                    <option value="">Select Level</option>
                                    <option value="low" {{ old('activity_level') == 'low' ? 'selected' : '' }}>Low (Sedentary)</option>
                                    <option value="moderate" {{ old('activity_level') == 'moderate' ? 'selected' : '' }}>Moderate (Active 3-4 days/week)</option>
                                    <option value="high" {{ old('activity_level') == 'high' ? 'selected' : '' }}>High (Very Active)</option>
                                </select>
                                @error('activity_level')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Dietary Restriction -->
                            <div>
                                <label for="dietary_restriction" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dietary Restriction</label>
                                <select name="dietary_restriction" id="dietary_restriction" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                    <option value="">Select Restriction</option>
                                    <option value="none" {{ old('dietary_restriction') == 'none' ? 'selected' : '' }}>None</option>
                                    <option value="vegetarian" {{ old('dietary_restriction') == 'vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                                    <option value="vegan" {{ old('dietary_restriction') == 'vegan' ? 'selected' : '' }}>Vegan</option>
                                    <option value="gluten-free" {{ old('dietary_restriction') == 'gluten-free' ? 'selected' : '' }}>Gluten-Free</option>
                                </select>
                                @error('dietary_restriction')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Health Goal -->
                            <div class="md:col-span-2">
                                <label for="health_goal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Health Goal</label>
                                <select name="health_goal" id="health_goal" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                    <option value="">Select Goal</option>
                                    <option value="balanced" {{ old('health_goal') == 'balanced' ? 'selected' : '' }}>Balanced Nutrition</option>
                                    <option value="weight_loss" {{ old('health_goal') == 'weight_loss' ? 'selected' : '' }}>Weight Loss</option>
                                    <option value="muscle_gain" {{ old('health_goal') == 'muscle_gain' ? 'selected' : '' }}>Muscle Gain</option>
                                    <option value="heart_health" {{ old('health_goal') == 'heart_health' ? 'selected' : '' }}>Heart Health</option>
                                </select>
                                @error('health_goal')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" class="w-full py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-[1.02] flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            Analyze & Get Recommendations
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
