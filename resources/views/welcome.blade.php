<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Mesa de Partes Virtual - UGEL Asunción') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased" 
{{-- x-data="{ theme: localStorage.getItem('theme') || 'auto' }" x-init="const isDark = theme === 'dark' || (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches);
document.documentElement.classList.toggle('dark', isDark);" x-cloak --}}
>
    <div
        class="absolute top-0 w-screen grid min-h-dvh grid-rows-[auto_1fr_auto] text-black/50 dark:text-white/50 bg-sky-100 dark:bg-gray-900 bg-[radial-gradient(ellipse_80%_80%_at_50%_20%,rgba(120,119,198,0.3),rgba(255,255,255,0))]">
        <header class="w-full bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700">
            <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <a href="{{ url('/') }}" class="flex items-center gap-2">
                                <x-application-logo
                                    class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                                <span class="text-xl text-gray-800 dark:text-gray-200 hidden sm:block">Mesa de Partes
                                    Virtual - UGEL
                                    Asunción</span>
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center ms-6 gap-6 z-10">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('helpdesk.dashboard') }}"
                                    class="relative border-2 border-gray-800 dark:border-gray-200 bg-transparent rounded-md px-3 py-2 text-center text-gray-800 dark:text-gray-200 transition-colors before:absolute before:left-0 before:top-0 before:-z-10 before:h-full before:w-full before:origin-top-left before:scale-x-0 before:bg-gray-800 before:dark:bg-gray-200 before:transition-transform before:duration-300 before:content-[''] hover:text-white hover:dark:text-gray-800 before:hover:scale-x-100">
                                    {{ __('Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="relative border-2 border-gray-800 dark:border-gray-200 bg-transparent rounded-md px-3 py-2 text-center text-gray-800 dark:text-gray-200 transition-colors before:absolute before:left-0 before:top-0 before:-z-10 before:h-full before:w-full before:origin-top-left before:scale-x-0 before:bg-gray-800 before:dark:bg-gray-200 before:transition-transform before:duration-300 before:content-[''] hover:text-white hover:dark:text-gray-800 before:hover:scale-x-100 whitespace-nowrap">
                                    {{ __('Log in') }}
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="relative border-2 border-gray-800 dark:border-gray-200 bg-transparent rounded-md px-3 py-2 text-center text-gray-800 dark:text-gray-200 transition-colors before:absolute before:left-0 before:top-0 before:-z-10 before:h-full before:w-full before:origin-top-left before:scale-x-0 before:bg-gray-800 before:dark:bg-gray-200 before:transition-transform before:duration-300 before:content-[''] hover:text-white hover:dark:text-gray-800 before:hover:scale-x-100">
                                        {{ __('Register') }}
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </nav>
        </header>
        <main class="flex flex-col items-center justify-center my-6">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <div class="grid gap-6 lg:grid-cols-2 lg:gap-8">
                    <a href="#"
                        class="flex items-start gap-4 rounded-lg bg-white p-6 lg:p-20 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-red-300 focus:outline-none focus-visible:ring-red-400 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-red-400 dark:focus-visible:ring-red-400">
                        <div
                            class="flex size-12 shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-500 sm:size-16">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="">
                                <path
                                    d="m18 5-2.414-2.414A2 2 0 0 0 14.172 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2" />
                                <path
                                    d="M21.378 12.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                <path d="M8 18h1" />
                            </svg>
                        </div>
                        <div class="pt-3 sm:pt-5">
                            <h2 class="text-xl font-semibold text-black dark:text-white">Registrar Trámite</h2>
                            <p class="mt-4 text-sm/relaxed">Inicia un nuevo trámite de manera rápida y sencilla.</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="self-center shrink-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                            <path d="M11 13l9 -9" />
                            <path d="M15 4h5v5" />
                        </svg>
                    </a>

                    <a href="#"
                        class="flex items-start gap-4 rounded-lg bg-white p-6 lg:p-20 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-blue-300 focus:outline-none focus-visible:ring-blue-400 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-blue-400 dark:focus-visible:ring-blue-400">
                        <div
                            class="flex size-12 shrink-0 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-500 sm:size-16">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="">
                                {{-- <path d="M14 2v4a2 2 0 0 0 2 2h4" /> --}}
                                <path d="M4.268 21a2 2 0 0 0 1.727 1H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3" />
                                <path d="m9 18-1.5-1.5" />
                                <circle cx="5" cy="14" r="3" />
                            </svg>
                        </div>
                        <div class="pt-3 sm:pt-5">
                            <h2 class="text-xl font-semibold text-black dark:text-white">Consultar Trámite</h2>
                            <p class="mt-4 text-sm/relaxed">Consulta el estado de tus trámites en cualquier momento.
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="self-center shrink-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                            <path d="M11 13l9 -9" />
                            <path d="M15 4h5v5" />
                        </svg>
                    </a>

                </div>
            </div>
        </main>
        <footer class="py-10 text-center text-sm text-black dark:text-white/70">
            Todos los derechos reservados v{{ Illuminate\Foundation\Application::VERSION }} (PHP
            v{{ PHP_VERSION }})
        </footer>
    </div>
    <!-- Livewire Scripts -->
    @livewireScripts
</body>

</html>
