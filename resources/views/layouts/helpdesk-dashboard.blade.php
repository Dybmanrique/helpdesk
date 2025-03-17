<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Local Styles -->
    <link rel="stylesheet" href="{{ asset('css/helpdesk/loader.css') }}">
    <!-- Livewire Styles -->
    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')
    @stack('css')
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

    <div id="preloader">
        <div id="loader"></div>
    </div>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.helpdesk-navigation')

        <!-- Page Heading -->
        @hasSection('header')
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
    <!-- Sweet Alert 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.15.10/dist/sweetalert2.all.min.js"></script>
    <!-- Local Scripts -->
    <script src="{{ asset('js/helpers.js') }}?v={{ env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/helpdesk/loader.js') }}?v={{ env('APP_VERSION') }}"></script>
    <!-- Livewire Scripts -->
    @livewireScripts
    @yield('js')
    @stack('js')
</body>

</html>
