<x-guest-layout>

    <x-slot name="mainHeader">
        <div class="flex justify-center lg:justify-start">
            <a href="/" class="">
                <x-application-logo class="h-20 w-20 fill-current text-gray-500" />
            </a>
        </div>
        <div class="text-center lg:text-start">
            <p class="mt-4 text-indigo-600 md:text-lg dark:text-indigo-300">¡Hola, bienvenido(a) de nuevo!</p>
            <h2 class="flex flex-col mt-4 text-2xl font-medium text-gray-800 lg:text-3xl dark:text-gray-200">
                <span class="">
                    Sistema de Mesa de Partes Virtual
                </span>
                <span class="text-indigo-600 dark:text-indigo-400">
                    UGEL Asunción
                </span>
            </h2>
        </div>
    </x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h1 class="font-medium text-2xl text-gray-800 dark:text-gray-200">Iniciar sesión</h1>
    <div class="flex gap-2 text-sm text-gray-600 dark:text-gray-400">
        <p>¿No estás registrado?</p>
        <a class="underline hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
            href="{{ route('register') }}">
            Regístrate
        </a>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mt-6">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
