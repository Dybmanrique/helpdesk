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
            <x-text-input x-ref="focusInput" x-init="$nextTick(() => { $refs.focusInput.focus() })" id="email" class="block mt-1 w-full"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
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
    <p class="flex items-center my-5 w-full text-gray-600 dark:text-gray-400">
        <span class="flex-grow bg-gray-400 dark:bg-gray-600 h-px"></span>
        <span class="mx-3">o</span>
        <span class="flex-grow bg-gray-400 dark:bg-gray-600 h-px"></span>
    </p>
    <a href="{{ route('auth.google') }}"
        class="flex items-center justify-center gap-2 my-3 w-full px-3 py-2.5 text-gray-800 dark:text-gray-200 shadow-sm rounded-md border border-gray-300 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition duration-300">
        <span>
            <svg viewBox="0 0 256 262" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" class="size-6">
                <path
                    d="M255.878 133.451c0-10.734-.871-18.567-2.756-26.69H130.55v48.448h71.947c-1.45 12.04-9.283 30.172-26.69 42.356l-.244 1.622 38.755 30.023 2.685.268c24.659-22.774 38.875-56.282 38.875-96.027"
                    fill="#4285F4" />
                <path
                    d="M130.55 261.1c35.248 0 64.839-11.605 86.453-31.622l-41.196-31.913c-11.024 7.688-25.82 13.055-45.257 13.055-34.523 0-63.824-22.773-74.269-54.25l-1.531.13-40.298 31.187-.527 1.465C35.393 231.798 79.49 261.1 130.55 261.1"
                    fill="#34A853" />
                <path
                    d="M56.281 156.37c-2.756-8.123-4.351-16.827-4.351-25.82 0-8.994 1.595-17.697 4.206-25.82l-.073-1.73L15.26 71.312l-1.335.635C5.077 89.644 0 109.517 0 130.55s5.077 40.905 13.925 58.602l42.356-32.782"
                    fill="#FBBC05" />
                <path
                    d="M130.55 50.479c24.514 0 41.05 10.589 50.479 19.438l36.844-35.974C195.245 12.91 165.798 0 130.55 0 79.49 0 35.393 29.301 13.925 71.947l42.211 32.783c10.59-31.477 39.891-54.251 74.414-54.251"
                    fill="#EB4335" />
            </svg>
        </span>
        <span>Inicia con Google</span>
    </a>
</x-guest-layout>
