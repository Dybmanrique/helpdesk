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

<body class="font-sans antialiased" x-data="{
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
        class="mx-auto grid min-h-dvh grid-rows-[auto_1fr_auto] text-slate-200 bg-neutral-100 dark:bg-neutral-950 bg-[radial-gradient(ellipse_80%_80%_at_50%_90%,rgba(120,119,198,0.3),rgba(255,255,255,0))]">
        @include('layouts.helpdesk-navigation')
        <main
            class="flex flex-col w-full mx-auto max-w-2xl md:max-w-7xl space-y-10 sm:space-y-16 px-4 sm:px-6 lg:px-8 py-5 md:py-10">
            <div class="sm:mt-6 max-w-3xl">
                <p class="mt-4 md:text-lg text-gray-800 dark:text-gray-200">Bienvenido(a) al</p>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-200">
                    Sistema de Mesa de Partes Virtual de la UGEL Asunción
                </h1>
                <p class="mt-4 text-gray-600 dark:text-gray-400">Aquí podrás registrar y consultar tus trámites de
                    manera rápida y sencilla.</p>
            </div>

            <div class="relative w-full max-w-2xl md:max-w-7xl">
                <div class="grid gap-6 md:grid-cols-2">
                    <a href="{{ route('procedures.create') }}"
                        class="flex flex-col rounded-xl bg-white bg-clip-border text-gray-800 shadow-md ring-1 ring-gray-200 dark:bg-neutral-900 dark:text-gray-200 dark:ring-gray-800 hover:ring-gray-400 dark:hover:ring-gray-600 group transition duration-300">
                        <div class="p-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mb-4 h-12 w-12 text-indigo-500">
                                <path
                                    d="m18 5-2.414-2.414A2 2 0 0 0 14.172 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2" />
                                <path
                                    d="M21.378 12.626a1 1 0 0 0-3.004-3.004l-4.01 4.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                                <path d="M8 18h1" />
                            </svg>
                            <h2
                                class="text-blue-gray-900 mb-2 block font-sans text-xl leading-snug font-semibold tracking-normal antialiased">
                                Registrar Trámite</h2>
                            <p class="text-sm/relaxed">
                                Inicia un nuevo trámite de manera rápida y sencilla. Completa el formulario con la
                                información requerida y envíalo para su procesamiento.</p>
                        </div>
                        <div class="p-6 pt-0">
                            <div
                                class="flex items-center gap-2 rounded-lg px-4 py-2 text-xs font-bold text-indigo-500 uppercase hover:bg-indigo-500/10 active:bg-indigo-500/30 group-hover:gap-4 transition-all duration-300">
                                <span>Registrar</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('procedures.consult') }}"
                        class="flex flex-col rounded-xl bg-white bg-clip-border text-gray-800 shadow-md ring-1 ring-gray-200 dark:bg-neutral-900 dark:text-gray-200 dark:ring-gray-800 hover:ring-gray-400 dark:hover:ring-gray-600 group transition duration-300">
                        <div class="p-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mb-4 h-12 w-12 text-indigo-500">
                                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                <path d="M4.268 21a2 2 0 0 0 1.727 1H18a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v3" />
                                <path d="m9 18-1.5-1.5" />
                                <circle cx="5" cy="14" r="3" />
                            </svg>
                            <h2
                                class="text-blue-gray-900 mb-2 block font-sans text-xl leading-snug font-semibold tracking-normal antialiased">
                                Consultar Trámite</h2>
                            <p class="text-sm/relaxed">
                                Consulta el estado de tus trámites en cualquier momento. Ingresa el código del ticket de
                                tu
                                trámite y verifica su progreso.</p>
                        </div>
                        <div class="p-6 pt-0">
                            <div
                                class="flex items-center gap-2 rounded-lg px-4 py-2 text-xs font-bold text-indigo-500 uppercase hover:bg-indigo-500/10 active:bg-indigo-500/30 group-hover:gap-4 transition-all duration-300">
                                <span>Consultar</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" aria-hidden="true" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </main>
        @include('layouts.helpdesk-footer')
    </div>
    <!-- Livewire Scripts -->
    @livewireScripts
</body>

</html>
