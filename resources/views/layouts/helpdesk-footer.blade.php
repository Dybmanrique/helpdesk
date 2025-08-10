<footer class="py-3 bg-neutral-300 dark:bg-neutral-900/20 text-gray-800 dark:text-gray-200">
    <div
        class="flex flex-col sm:flex-row items-center justify-between gap-2 mx-auto w-full max-w-2xl md:max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col items-center">
            <div class="flex items-center justify-center gap-2">
                <x-application-logo class="block size-5 w-auto fill-current shrink-0" />
                <p>UGEL Asunción</p>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400">&copy; {{ now()->year }} - Todos los derechos
                reservados.</p>
        </div>
        <div class="flex items-center gap-6">
            <a href="https://facebook.com/profile.php?id=61577579793251" target="_blank"
                class="text-gray-800 dark:text-gray-200 hover:text-gray-600 dark:hover:text-gray-400 transition-colors duration-200">
                <span class="sr-only">Facebook</span>
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 32 32" version="1.1"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path
                        d="M30.996 16.091c-0.001-8.281-6.714-14.994-14.996-14.994s-14.996 6.714-14.996 14.996c0 7.455 5.44 13.639 12.566 14.8l0.086 0.012v-10.478h-3.808v-4.336h3.808v-3.302c-0.019-0.167-0.029-0.361-0.029-0.557 0-2.923 2.37-5.293 5.293-5.293 0.141 0 0.281 0.006 0.42 0.016l-0.018-0.001c1.199 0.017 2.359 0.123 3.491 0.312l-0.134-0.019v3.69h-1.892c-0.086-0.012-0.185-0.019-0.285-0.019-1.197 0-2.168 0.97-2.168 2.168 0 0.068 0.003 0.135 0.009 0.202l-0.001-0.009v2.812h4.159l-0.665 4.336h-3.494v10.478c7.213-1.174 12.653-7.359 12.654-14.814v-0z">
                    </path>
                </svg>
            </a>
        </div>
    </div>
</footer>
