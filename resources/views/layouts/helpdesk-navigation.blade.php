<header
    class="sticky top-0 z-10 h-16 w-full text-gray-800 dark:text-gray-200 bg-gray-100/80 dark:bg-gray-900/80 backdrop-filter backdrop-blur-sm">
    <nav x-data="{ open: false }"
        class="mx-auto flex h-16 max-w-2xl items-center justify-between px-4 sm:px-6 md:max-w-7xl lg:px-8">
        <!-- Primary Navigation Menu -->
        <div class="flex w-full h-full justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center justify-center gap-2">
                        <x-application-logo class="block h-9 w-auto fill-current shrink-0" />
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="shrink-0">
                                    <path d="M12 7v14" />
                                    <path d="M16 12h2" />
                                    <path d="M16 8h2" />
                                    <path
                                        d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                    <path d="M6 12h2" />
                                    <path d="M6 8h2" />
                                </svg> --}}
                        <span class="hidden md:block md:text-base lg:text-lg">Mesa de Partes Virtual - UGEL
                            Asunción</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center justify-center">
                    @if (auth()->check() && auth()->user()->can('Dashboard de Trámites: Ver'))
                        <x-nav-link :href="route('helpdesk.dashboard')" :active="request()->routeIs('helpdesk.dashboard')" class="h-full">
                            {{ __('Panel de control') }}
                        </x-nav-link>
                    @endif
                    <x-nav-link :href="route('procedures.create')" :active="request()->routeIs('procedures.create')" class="h-full">
                        {{ __('Registro de Trámites') }}
                    </x-nav-link>
                    <x-nav-link :href="route('procedures.consult')" :active="request()->routeIs('procedures.consult')" class="h-full">
                        {{ __('Seguimiento de Trámites') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden h-full sm:flex items-center gap-3">
                <x-helpdesk.theme-select alignmentClasses="bottom-right" roundedMenu="rounded-xl" class="border-none" />
                {{-- <div class="w-px h-1/2 border border-gray-600"></div> --}}
                @auth
                    <x-dropdown alignmentClasses="bottom-right" roundedMenu="rounded-xl"
                        class="rounded-full pt-1 pr-1 pb-1 pl-1">
                        <x-slot name="toggleButtonContent">
                            <div class="relative flex h-8 w-8 items-center justify-center overflow-hidden rounded-full">
                                <span class="text-lg uppercase">
                                    {{ substr(auth()->user()->person->name, 0, 1) . substr(auth()->user()->person->last_name, 0, 1) }}
                                </span>
                            </div>
                        </x-slot>
                        <x-slot name="dropdownSections">
                            {{-- Dropdown Section --}}
                            <div class="flex flex-col py-1.5 bg-gray-100 dark:bg-gray-800">
                                <p class="px-4 py-2 text-xs text-gray-600 dark:text-gray-300" role="menuitem">
                                    {{ auth()->user()->person->full_name }}
                                </p>
                            </div>
                            {{-- Dropdown Section --}}
                            <div class="flex flex-col py-1.5">
                                @can('Perfil de Usuario: Ver')
                                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2" role="menuitem">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="size-4 shrink-0">
                                            <circle cx="12" cy="8" r="5" />
                                            <path d="M20 21a8 8 0 0 0-16 0" />
                                        </svg>
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
                                @endcan
                                @can('Dashboard de Trámites: Ver')
                                    <x-dropdown-link :href="route('helpdesk.dashboard')" class="flex items-center gap-2" role="menuitem">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="size-4 shrink-0">
                                            <path d="m12 14 4-4" />
                                            <path d="M3.34 19a10 10 0 1 1 17.32 0" />
                                        </svg>
                                        Panel de control
                                    </x-dropdown-link>
                                @endcan
                            </div>
                            {{-- Dropdown Section --}}
                            <div class="flex flex-col py-1.5">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="flex items-center gap-2" role="menuitem"
                                        onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="size-4 shrink-0">
                                            <path d="m16 17 5-5-5-5" />
                                            <path d="M21 12H9" />
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                        </svg>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                            class="relative border-2 border-gray-800 dark:border-gray-200 bg-transparent rounded-md px-3 py-2 text-center text-gray-800 dark:text-gray-200 transition-colors before:absolute before:left-0 before:top-0 before:-z-10 before:h-full before:w-full before:origin-top-left before:scale-x-0 before:bg-gray-800 before:dark:bg-gray-200 before:transition-transform before:duration-300 before:content-[''] hover:text-white hover:dark:text-gray-800 before:hover:scale-x-100 whitespace-nowrap">
                            {{ __('Log in') }}
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="relative border-2 border-gray-800 dark:border-gray-200 bg-transparent rounded-md px-3 py-2 text-center text-gray-800 dark:text-gray-200 transition-colors before:absolute before:left-0 before:top-0 before:-z-10 before:h-full before:w-full before:origin-top-left before:scale-x-0 before:bg-gray-800 before:dark:bg-gray-200 before:transition-transform before:duration-300 before:content-[''] hover:text-white hover:dark:text-gray-800 before:hover:scale-x-100">
                            {{ __('Register') }}
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            x-on:keydown.escape.window="open = false"
            class="block sm:hidden fixed inset-0 w-full h-screen bg-gray-500/75 dark:bg-gray-900/75 z-10">
            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-x-full"
                x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-full" x-trap.noscroll="open"
                @click.outside="open = false" class="absolute inset-0 w-[90vw] p-5 bg-gray-50 dark:bg-gray-800">
                <div class="flex items-center justify-end w-full pb-1 border-b border-gray-400">
                    <button @click="open = false" type="button"
                        class="p-2 rounded-lg hover:bg-gray-200 dark:hover:bg-neutral-950">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </div>
                {{-- Menu --}}
                <div class="grid gap-3 mt-3">
                    @if (auth()->check() && auth()->user()->can('Dashboard de Trámites: Ver'))
                        <x-responsive-nav-link :href="route('helpdesk.dashboard')" :active="request()->routeIs('helpdesk.dashboard')">
                            {{ __('Panel de control') }}
                        </x-responsive-nav-link>
                    @endif
                    <x-responsive-nav-link :href="route('procedures.create')" :active="request()->routeIs('procedures.create')">
                        {{ __('Registro de Trámites') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('procedures.consult')" :active="request()->routeIs('procedures.consult')">
                        {{ __('Seguimiento de Trámites') }}
                    </x-responsive-nav-link>
                </div>
                {{-- Perfil y Tema --}}
                <div class="absolute bottom-0 left-0 right-0 p-5">
                    <div class="mb-3 border-b border-gray-400"></div>
                    <div class="flex items-center justify-between">
                        <x-dropdown alignmentClasses="top-left" roundedMenu="rounded-lg"
                            class="rounded-full px-1 py-1">
                            <x-slot name="toggleButtonContent">
                                <div
                                    class="relative flex h-8 w-8 items-center justify-center overflow-hidden rounded-full">
                                    @auth
                                        <span
                                            class="text-lg uppercase">{{ substr(auth()->user()->person->name, 0, 1) . substr(auth()->user()->person->last_name, 0, 1) }}</span>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor"
                                            class="absolute aspect-square size-9 -bottom-1.5 text-gray-600 dark:text-gray-400 shrink-0"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                        </svg>
                                    @endauth
                                </div>
                            </x-slot>
                            <x-slot name="dropdownSections">
                                @auth
                                    {{-- Dropdown Section --}}
                                    <div class="flex flex-col py-1.5 bg-gray-100 dark:bg-gray-800">
                                        <p class="px-4 py-2 text-xs text-gray-600 dark:text-gray-300" role="menuitem">
                                            {{ auth()->user()->person->full_name }}
                                        </p>
                                    </div>
                                    {{-- Dropdown Section --}}
                                    <div class="flex flex-col py-1.5">
                                        @can('Perfil de Usuario: Ver')
                                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2"
                                                role="menuitem">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="size-4 shrink-0">
                                                    <circle cx="12" cy="8" r="5" />
                                                    <path d="M20 21a8 8 0 0 0-16 0" />
                                                </svg>
                                                {{ __('Profile') }}
                                            </x-dropdown-link>
                                        @endcan
                                        @can('Dashboard de Trámites: Ver')
                                            <x-dropdown-link :href="route('helpdesk.dashboard')" class="flex items-center gap-2"
                                                role="menuitem">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="size-4 shrink-0">
                                                    <path d="m12 14 4-4" />
                                                    <path d="M3.34 19a10 10 0 1 1 17.32 0" />
                                                </svg>
                                                Panel de control
                                            </x-dropdown-link>
                                        @endcan
                                    </div>
                                    {{-- Dropdown Section --}}
                                    <div class="flex flex-col py-1.5">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" class="flex items-center gap-2"
                                                role="menuitem"
                                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="size-4 shrink-0">
                                                    <path d="m16 17 5-5-5-5" />
                                                    <path d="M21 12H9" />
                                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                                </svg>
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                @else
                                    {{-- Dropdown Section --}}
                                    <div class="flex flex-col py-1.5">
                                        <x-dropdown-link :href="route('login')" class="flex items-center gap-2"
                                            role="menuitem">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="size-4 shrink-0">
                                                <path d="m10 17 5-5-5-5" />
                                                <path d="M15 12H3" />
                                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                            </svg>
                                            {{ __('Log in') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('register')" class="flex items-center gap-2"
                                            role="menuitem">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="size-4 shrink-0">
                                                <path d="M2 21a8 8 0 0 1 13.292-6" />
                                                <circle cx="10" cy="8" r="5" />
                                                <path d="M19 16v6" />
                                                <path d="M22 19h-6" />
                                            </svg>
                                            {{ __('Register') }}
                                        </x-dropdown-link>
                                    </div>
                                @endauth
                            </x-slot>
                        </x-dropdown>

                        <x-helpdesk.theme-select alignmentClasses="top-right" roundedMenu="rounded-lg"
                            class="" />
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
