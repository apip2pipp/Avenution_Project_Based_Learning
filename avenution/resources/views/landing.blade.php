<x-guest-layout>
    <x-slot name="title">Home - Smart Food Recommendations</x-slot>

    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-16 pb-24 lg:pt-24 lg:pb-32">
        <!-- Background gradient -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-primary/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-accent/5 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary/10 text-primary dark:text-primary-light text-xs font-semibold mb-6">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"/>
                        </svg>
                        AI-Powered Health Tech Platform
                    </div>
                    
                    <h1 class="text-gray-900 dark:text-white mb-6 font-extrabold leading-tight" style="font-size: clamp(2rem, 4vw, 3.2rem);">
                        Smart Food<br />
                        Recommendations<br />
                        <span class="text-primary">Based on Your</span><br />
                        Body Condition
                    </h1>
                    
                    <p class="text-gray-600 dark:text-gray-400 text-lg mb-8 leading-relaxed max-w-lg">
                        Avenution uses advanced AI to analyze your health metrics and deliver personalized nutrition plans tailored specifically to your body's needs.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('analyze') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-xl font-semibold transition-all duration200 shadow-lg shadow-red-900/20 hover:shadow-red-900/30 hover:scale-105">
                            Try Now
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                            Login
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Trust badges -->
                    <div class="mt-8 flex flex-wrap items-center gap-5">
                        @foreach(['HIPAA Compliant', '256-bit Encryption', 'ISO 27001'] as $badge)
                            <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400">
                                <svg class="w-3.5 h-3.5 text-accent" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $badge }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right - Hero Image -->
                            <div class="relative">
                                <div class="relative shadow-sm">
                                    
                                    <img src="{{ asset('images/hero.png') }}" 
                                        alt="Mediterranean Diet"
                                        class="w-full h-[550px] object-cover">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-12 bg-white dark:bg-gray-800/40" id="stats">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                @foreach([
                    ['value' => $stats['users'], 'label' => 'Active Users'],
                    ['value' => $stats['accuracy'], 'label' => 'Accuracy Rate'],
                    ['value' => $stats['foods'], 'label' => 'Food Database'],
                    ['value' => $stats['rating'], 'label' => 'User Rating'],
                ] as $stat)
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-primary mb-2">{{ $stat['value'] }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">How Avenution Works</h2>
                <p class="text-gray-600 dark:text-gray-400 text-lg max-w-2xl mx-auto">
                    Our AI-powered platform analyzes your health data and provides personalized nutrition recommendations
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @foreach([
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>',
                        'title' => 'Body Condition Analysis',
                        'description' => 'Our AI analyzes your personal health metrics including age, weight, blood pressure, and more to understand your unique body condition.',
                        'color' => 'bg-rose-50 dark:bg-rose-950/30',
                        'textColor' => 'text-primary',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>',
                        'title' => 'Personalized Menu Recommendation',
                        'description' => 'Get tailored food recommendations that match your body\'s nutritional needs, dietary restrictions, and health goals.',
                        'color' => 'bg-green-50 dark:bg-green-950/30',
                        'textColor' => 'text-accent',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>',
                        'title' => 'Progress Tracking',
                        'description' => 'Monitor your health journey over time with detailed charts and insights. Stay motivated with visual progress indicators.',
                        'color' => 'bg-blue-50 dark:bg-blue-950/30',
                        'textColor' => 'text-blue-600 dark:text-blue-400',
                    ],
                ] as $feature)
                    <div class="p-6 rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-primary dark:hover:border-primary transition-all duration-200 hover:shadow-lg">
                        <div class="w-12 h-12 rounded-xl {{ $feature['color'] }} flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 {{ $feature['textColor'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $feature['icon'] !!}
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-24 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid lg:grid-cols-2 gap-12 items-center">

                <!-- Left Content -->
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                        Powered by Advanced <br>
                        Health AI Technology
                    </h2>

                    <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-lg">
                        Our proprietary AI model is trained on thousands of clinical nutrition studies and health datasets, ensuring recommendations that are both safe and effective.
                    </p>

                    <!-- Steps -->
                    <div class="space-y-6">

                        <!-- Step 1 -->
                        <div class="flex gap-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6M9 8h6M7 5h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                </svg>
                            </div>

                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Input Your Data</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Enter your body condition metrics securely.
                                </p>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="flex gap-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 3a6 6 0 016 6v1.5a3 3 0 003 3V15a6 6 0 11-12 0v-1.5a3 3 0 003-3V9a6 6 0 016-6z"/>
                                </svg>
                            </div>

                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">AI Analysis</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Our model processes your data in seconds.
                                </p>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="flex gap-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.5 0-3 .5-3 2v6h6v-6c0-1.5-1.5-2-3-2z"/>
                                </svg>
                            </div>

                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Get Recommendations</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Receive personalized food plans instantly.
                                </p>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="flex gap-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary/10 text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 17l6-6 4 4 8-8"/>
                                </svg>
                            </div>

                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Track Progress</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Monitor and improve your health over time.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Button -->
                    <a href="{{ route('analyze') }}"
                    class="inline-flex items-center gap-2 mt-8 px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition shadow-md hover:scale-105">
                        Start Your Analysis
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>

                </div>

                <!-- Right Image -->
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/food.png') }}"
                            alt="Healthy Food"
                            class="w-full h-[500px] object-cover">
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-primary/10 to-accent/10 dark:from-primary/20 dark:to-accent/20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Start Your Health Journey Today
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-lg mb-8">
                Get personalized food recommendations in minutes. No credit card required.
            </p>
            <a href="{{ route('analyze') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-primary hover:bg-primary-dark text-white rounded-xl font-semibold transition-all duration-200 shadow-lg hover:scale-105">
                Get Started Free
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </section>
</x-guest-layout>
