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

            <!-- Demo Data Buttons -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-6 mb-8 border border-blue-200 dark:border-blue-800">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Quick Demo Data</h3>
                    <span class="text-xs text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/50 px-2 py-1 rounded-full">Click to auto-fill form</span>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                    <!-- Demo 1: Healthy & Normal -->
                    <button type="button" onclick="fillDemoData('healthy')" class="demo-btn bg-green-100 hover:bg-green-200 dark:bg-green-900/30 dark:hover:bg-green-900/50 border border-green-300 dark:border-green-700 rounded-xl p-3 text-left transition-all hover:scale-105 hover:shadow-md min-h-[90px] flex flex-col justify-between">
                        <div class="mb-1">
                            <div class="text-2xl mb-1">✅</div>
                            <div class="font-semibold text-green-800 dark:text-green-300 text-sm leading-tight break-words">Healthy</div>
                        </div>
                        <p class="text-xs text-green-700 dark:text-green-400 leading-tight">Normal BMI, Active</p>
                    </button>

                    <!-- Demo 2: Overweight -->
                    <button type="button" onclick="fillDemoData('overweight')" class="demo-btn bg-orange-100 hover:bg-orange-200 dark:bg-orange-900/30 dark:hover:bg-orange-900/50 border border-orange-300 dark:border-orange-700 rounded-xl p-3 text-left transition-all hover:scale-105 hover:shadow-md min-h-[90px] flex flex-col justify-between">
                        <div class="mb-1">
                            <div class="text-2xl mb-1">⚠️</div>
                            <div class="font-semibold text-orange-800 dark:text-orange-300 text-sm leading-tight break-words">Overweight</div>
                        </div>
                        <p class="text-xs text-orange-700 dark:text-orange-400 leading-tight">High BMI, Sedentary</p>
                    </button>

                    <!-- Demo 3: Hypertension -->
                    <button type="button" onclick="fillDemoData('hypertension')" class="demo-btn bg-red-100 hover:bg-red-200 dark:bg-red-900/30 dark:hover:bg-red-900/50 border border-red-300 dark:border-red-700 rounded-xl p-3 text-left transition-all hover:scale-105 hover:shadow-md min-h-[90px] flex flex-col justify-between">
                        <div class="mb-1">
                            <div class="text-2xl mb-1">🩺</div>
                            <div class="font-semibold text-red-800 dark:text-red-300 text-sm leading-tight break-words">Hypertension</div>
                        </div>
                        <p class="text-xs text-red-700 dark:text-red-400 leading-tight">High Blood Pressure</p>
                    </button>

                    <!-- Demo 4: Diabetes Risk -->
                    <button type="button" onclick="fillDemoData('diabetes')" class="demo-btn bg-purple-100 hover:bg-purple-200 dark:bg-purple-900/30 dark:hover:bg-purple-900/50 border border-purple-300 dark:border-purple-700 rounded-xl p-3 text-left transition-all hover:scale-105 hover:shadow-md min-h-[90px] flex flex-col justify-between">
                        <div class="mb-1">
                            <div class="text-2xl mb-1">💉</div>
                            <div class="font-semibold text-purple-800 dark:text-purple-300 text-sm leading-tight break-words">Diabetes<br>Risk</div>
                        </div>
                        <p class="text-xs text-purple-700 dark:text-purple-400 leading-tight">High Blood Sugar</p>
                    </button>

                    <!-- Demo 5: Underweight -->
                    <button type="button" onclick="fillDemoData('underweight')" class="demo-btn bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900/30 dark:hover:bg-yellow-900/50 border border-yellow-300 dark:border-yellow-700 rounded-xl p-3 text-left transition-all hover:scale-105 hover:shadow-md min-h-[90px] flex flex-col justify-between">
                        <div class="mb-1">
                            <div class="text-2xl mb-1">📉</div>
                            <div class="font-semibold text-yellow-800 dark:text-yellow-300 text-sm leading-tight break-words">Underweight</div>
                        </div>
                        <p class="text-xs text-yellow-700 dark:text-yellow-400 leading-tight">Low BMI, Gain Muscle</p>
                    </button>
                </div>
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
                                <label for="blood_pressure_systolic" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blood Pressure (Systolic) mmHg <span class="text-gray-400 text-xs">(Optional)</span></label>
                                <input type="number" name="blood_pressure_systolic" id="blood_pressure_systolic" value="{{ old('blood_pressure_systolic') }}" min="70" max="200"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                @error('blood_pressure_systolic')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Blood Pressure Diastolic -->
                            <div>
                                <label for="blood_pressure_diastolic" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blood Pressure (Diastolic) mmHg <span class="text-gray-400 text-xs">(Optional)</span></label>
                                <input type="number" name="blood_pressure_diastolic" id="blood_pressure_diastolic" value="{{ old('blood_pressure_diastolic') }}" min="40" max="130"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                @error('blood_pressure_diastolic')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Blood Sugar -->
                            <div>
                                <label for="blood_sugar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blood Sugar (mg/dL) <span class="text-gray-400 text-xs">(Optional)</span></label>
                                <input type="number" name="blood_sugar" id="blood_sugar" value="{{ old('blood_sugar') }}" min="50" max="400"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                @error('blood_sugar')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cholesterol -->
                            <div>
                                <label for="cholesterol" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cholesterol (mg/dL) <span class="text-gray-400 text-xs">(Optional)</span></label>
                                <input type="number" name="cholesterol" id="cholesterol" value="{{ old('cholesterol') }}" min="100" max="400"
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
                                    <option value="sedentary" {{ old('activity_level') == 'sedentary' ? 'selected' : '' }}>Sedentary (Little or no exercise)</option>
                                    <option value="light" {{ old('activity_level') == 'light' ? 'selected' : '' }}>Light (Exercise 1-3 days/week)</option>
                                    <option value="moderate" {{ old('activity_level') == 'moderate' ? 'selected' : '' }}>Moderate (Exercise 3-5 days/week)</option>
                                    <option value="active" {{ old('activity_level') == 'active' ? 'selected' : '' }}>Active (Exercise 6-7 days/week)</option>
                                    <option value="very_active" {{ old('activity_level') == 'very_active' ? 'selected' : '' }}>Very Active (Hard exercise daily)</option>
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

                            <!-- Goal -->
                            <div class="md:col-span-2">
                                <label for="goal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Health Goal</label>
                                <select name="goal" id="goal" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-colors">
                                    <option value="">Select Goal</option>
                                    <option value="maintain" {{ old('goal') == 'maintain' ? 'selected' : '' }}>Maintain Weight</option>
                                    <option value="weight_loss" {{ old('goal') == 'weight_loss' ? 'selected' : '' }}>Weight Loss</option>
                                    <option value="muscle_gain" {{ old('goal') == 'muscle_gain' ? 'selected' : '' }}>Muscle Gain</option>
                                </select>
                                @error('goal')
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

    <script>
        function fillDemoData(type) {
            const demoData = {
                healthy: {
                    age: 28,
                    gender: 'male',
                    weight: 70,
                    height: 175,
                    blood_pressure_systolic: 120,
                    blood_pressure_diastolic: 80,
                    blood_sugar: 95,
                    cholesterol: 180,
                    activity_level: 'active',
                    dietary_restriction: 'none',
                    goal: 'maintain'
                },
                overweight: {
                    age: 35,
                    gender: 'male',
                    weight: 95,
                    height: 170,
                    blood_pressure_systolic: 135,
                    blood_pressure_diastolic: 88,
                    blood_sugar: 105,
                    cholesterol: 220,
                    activity_level: 'sedentary',
                    dietary_restriction: 'none',
                    goal: 'weight_loss'
                },
                hypertension: {
                    age: 45,
                    gender: 'female',
                    weight: 75,
                    height: 165,
                    blood_pressure_systolic: 155,
                    blood_pressure_diastolic: 95,
                    blood_sugar: 100,
                    cholesterol: 240,
                    activity_level: 'light',
                    dietary_restriction: 'none',
                    goal: 'weight_loss'
                },
                diabetes: {
                    age: 50,
                    gender: 'male',
                    weight: 88,
                    height: 172,
                    blood_pressure_systolic: 140,
                    blood_pressure_diastolic: 90,
                    blood_sugar: 160,
                    cholesterol: 230,
                    activity_level: 'light',
                    dietary_restriction: 'none',
                    goal: 'weight_loss'
                },
                underweight: {
                    age: 22,
                    gender: 'female',
                    weight: 48,
                    height: 168,
                    blood_pressure_systolic: 110,
                    blood_pressure_diastolic: 70,
                    blood_sugar: 85,
                    cholesterol: 160,
                    activity_level: 'moderate',
                    dietary_restriction: 'none',
                    goal: 'muscle_gain'
                }
            };

            const data = demoData[type];
            if (!data) return;

            // Fill all form fields
            document.getElementById('age').value = data.age;
            document.getElementById('gender').value = data.gender;
            document.getElementById('weight').value = data.weight;
            document.getElementById('height').value = data.height;
            document.getElementById('blood_pressure_systolic').value = data.blood_pressure_systolic;
            document.getElementById('blood_pressure_diastolic').value = data.blood_pressure_diastolic;
            document.getElementById('blood_sugar').value = data.blood_sugar;
            document.getElementById('cholesterol').value = data.cholesterol;
            document.getElementById('activity_level').value = data.activity_level;
            document.getElementById('dietary_restriction').value = data.dietary_restriction;
            document.getElementById('goal').value = data.goal;

            // Scroll to form smoothly
            document.querySelector('form').scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Show success notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50 animate-fade-in';
            notification.innerHTML = `
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Demo data loaded: ${type.charAt(0).toUpperCase() + type.slice(1)}</span>
                </div>
            `;
            document.body.appendChild(notification);
            setTimeout(() => notification.remove(), 3000);
        }
    </script>
</x-guest-layout>
