<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Livewire Styles -->
    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased" x-data="{
    theme: localStorage.getItem('theme') || 'auto',
    updateTheme(theme) {
        const isDark = theme === 'dark' || (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches);
        document.documentElement.classList.toggle('dark', isDark);
    }
}" x-init=" updateTheme(theme);
 $watch('theme', value => {
     localStorage.setItem('theme', value);
     updateTheme(value);
 });" x-cloak>
    <div
        class="mx-auto grid min-h-dvh grid-rows-[auto_1fr_auto] bg-neutral-100 dark:bg-neutral-950 bg-[radial-gradient(ellipse_80%_80%_at_50%_90%,rgba(120,119,198,0.3),rgba(255,255,255,0))]">
        <header class="w-full text-gray-800 dark:text-gray-200">
            <nav class="flex items-center justify-end h-16 mx-auto max-w-2xl px-4 sm:px-6 md:max-w-7xl lg:px-8">
                <x-helpdesk.theme-select alignmentClasses="bottom-right" roundedMenu="rounded-lg"
                    class="dark:bg-transparent" />
            </nav>
        </header>
        <main class="lg:flex items-center mx-auto w-full max-w-2xl md:max-w-7xl mb-4">
            <div class="flex items-center justify-center lg:justify-start lg:w-1/2 px-6">
                <div class="">
                    @isset($mainHeader)
                        {{ $mainHeader }}
                    @else
                        <div class="flex justify-center lg:justify-start">
                            <a href="/" class="">
                                <x-application-logo class="h-20 w-20 fill-current text-gray-500" />
                            </a>
                        </div>
                        <div class="text-center lg:text-start">
                            <h2
                                class="flex flex-col mt-4 text-2xl font-medium text-gray-800 lg:text-3xl dark:text-gray-200">
                                <span class="">
                                    Sistema de Mesa de Partes Virtual
                                </span>
                                <span class="text-indigo-600 dark:text-indigo-400">
                                    UGEL Asunción
                                </span>
                            </h2>
                        </div>
                    @endisset
                </div>
            </div>

            <div class="my-8 lg:my-0 lg:w-1/2 flex items-center justify-center">
                <div
                    class="w-full sm:max-w-xl px-6 py-4 sm:border sm:border-gray-300 sm:dark:border-gray-800 bg-neutral-100 dark:bg-neutral-950 dark:bg-opacity-10 dark:backdrop-filter dark:backdrop-blur shadow-md overflow-hidden sm:rounded-xl">
                    {{ $slot }}
                </div>
            </div>
        </main>
        <footer class="py-6 bg-neutral-300 dark:bg-neutral-900/20 text-gray-800 dark:text-gray-200">
            <div class="mx-auto w-full max-w-2xl md:max-w-7xl px-6 flex justify-between">
                <p class="">
                    Todos los derechos reservados v{{ Illuminate\Foundation\Application::VERSION }} (PHP
                    v{{ PHP_VERSION }})
                </p>
            </div>
        </footer>
    </div>
    <!-- Livewire Scripts -->
    @livewireScripts
</body>

</html>
