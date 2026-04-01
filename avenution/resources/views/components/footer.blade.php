<footer class="bg-white dark:bg-gray-800/60 border-t border-gray-200 dark:border-gray-800 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 flex items-center justify-center">
                            <!-- Logo Light -->
                            <img src="{{ asset('images/lightmode.png') }}" 
                                class="block dark:hidden w-full h-full object-contain" 
                                alt="Logo Light">

                            <!-- Logo Dark -->
                            <img src="{{ asset('images/darkmode.png') }}" 
                                class="hidden dark:block w-full h-full object-contain" 
                                alt="Logo Dark">
                        </div>
                    <span class="text-gray-900 dark:text-white font-bold text-xl">Avenution</span>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm max-w-md">
                    Smart food recommendations based on your body condition using advanced AI technology.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary text-sm">Home</a></li>
                    <li><a href="{{ route('analyze') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary text-sm">Analyze</a></li>
                    @auth
                    <li><a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary text-sm">Dashboard</a></li>
                    @else
                    <li><a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary text-sm">Login</a></li>
                    <li><a href="{{ route('register') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary text-sm">Register</a></li>
                    @endauth
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Legal</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary text-sm">Privacy Policy</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary text-sm">Terms of Service</a></li>
                    <li><a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary text-sm">Disclaimer</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 text-center">
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                &copy; {{ date('Y') }} Avenution. All rights reserved. Built with ❤️ for better health.
            </p>
        </div>
    </div>
</footer>
