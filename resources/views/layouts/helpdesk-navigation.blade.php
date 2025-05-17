<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('helpdesk.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('procedures.create')" :active="request()->routeIs('procedures.create')">
                        {{ __('Registro de Trámites') }}
                    </x-nav-link>
                    <x-nav-link :href="route('procedures.consult')" :active="request()->routeIs('procedures.consult')">
                        {{ __('Seguimiento de Trámites') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center gap-2">
                <x-helpdesk.theme-select />
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->person->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{-- <img class="rounded-full h-9 w-9" src="http://127.0.0.1:8000/coreui/assets/img/avatars/8.jpg" alt="Perfil"> --}}
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="hidden sm:flex sm:items-center sm:ms-2 gap-6 z-10">
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
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-y border-gray-200 dark:border-gray-600">
            @auth
                <div class="px-4 flex justify-between items-center">
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    <div class=" border-gray-200 dark:border-gray-600">
                        <x-helpdesk.theme-select />
                    </div>
                </div>
                <div class="-space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mx-3 mb-3 border-2 dark:border-gray-600 rounded-lg">
                    <a href="{{ route('login') }}"
                        class="block px-2 py-3 text-gray-600 dark:text-gray-200 border-b-2 dark:border-gray-600">{{ __('Log in') }}</a>
                    <a href="{{ route('register') }}"
                        class="block px-2 py-3 text-gray-600 dark:text-gray-200">{{ __('Register') }}</a>
                </div>
            @endauth
        </div>

        <div class="pt-2 pb-3 space-y-2 border-b border-gray-400">
            <x-responsive-nav-link :href="route('procedures.create')" :active="request()->routeIs('procedures.create')">
                {{ __('Registro de Trámites') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('procedures.consult')" :active="request()->routeIs('procedures.consult')">
                {{ __('Seguimiento de Trámites') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
