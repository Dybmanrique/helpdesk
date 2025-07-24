@props(['alignmentClasses' => 'top-right', 'width' => '48', 'roundedMenu' => 'sm'])

@php
    $alignmentClasses = match ($alignmentClasses) {
        'bottom-right' => 'top-11 right-0',
        'bottom-left' => 'top-11 left-0',
        'top-right' => 'bottom-11 right-0',
        'top-left' => 'bottom-11 left-0',
        default => $alignmentClasses,
    };

    $width = match ($width) {
        '48' => 'min-w-48',
        default => $width,
    };

    $roundedMenu = match ($roundedMenu) {
        'sm' => 'rounded-sm',
        default => $roundedMenu,
    };
@endphp

<div x-data="{ isOpen: false, openedWithKeyboard: false }" x-on:keydown.esc.window="isOpen = false, openedWithKeyboard = false" class="relative w-fit">
    {{-- Toggle Button --}}
    <button type="button" x-on:click="isOpen = ! isOpen" x-on:keydown.space.prevent="openedWithKeyboard = true"
        x-on:keydown.enter.prevent="openedWithKeyboard = true" x-on:keydown.down.prevent="openedWithKeyboard = true"
        {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 whitespace-nowrap rounded-full border border-gray-300 bg-gray-50 p-2 text-sm font-medium tracking-wide transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:focus-visible:outline-gray-300 ']) }}
        x-bind:class="isOpen || openedWithKeyboard ? 'text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300'"
        x-bind:aria-expanded="isOpen || openedWithKeyboard" aria-haspopup="true">
        <span x-show="theme == 'light'">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="currentColor" class="size-6">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 19a1 1 0 0 1 .993 .883l.007 .117v1a1 1 0 0 1 -1.993 .117l-.007 -.117v-1a1 1 0 0 1 1 -1z" />
                <path
                    d="M18.313 16.91l.094 .083l.7 .7a1 1 0 0 1 -1.32 1.497l-.094 -.083l-.7 -.7a1 1 0 0 1 1.218 -1.567l.102 .07z" />
                <path
                    d="M7.007 16.993a1 1 0 0 1 .083 1.32l-.083 .094l-.7 .7a1 1 0 0 1 -1.497 -1.32l.083 -.094l.7 -.7a1 1 0 0 1 1.414 0z" />
                <path d="M4 11a1 1 0 0 1 .117 1.993l-.117 .007h-1a1 1 0 0 1 -.117 -1.993l.117 -.007h1z" />
                <path d="M21 11a1 1 0 0 1 .117 1.993l-.117 .007h-1a1 1 0 0 1 -.117 -1.993l.117 -.007h1z" />
                <path
                    d="M6.213 4.81l.094 .083l.7 .7a1 1 0 0 1 -1.32 1.497l-.094 -.083l-.7 -.7a1 1 0 0 1 1.217 -1.567l.102 .07z" />
                <path
                    d="M19.107 4.893a1 1 0 0 1 .083 1.32l-.083 .094l-.7 .7a1 1 0 0 1 -1.497 -1.32l.083 -.094l.7 -.7a1 1 0 0 1 1.414 0z" />
                <path d="M12 2a1 1 0 0 1 .993 .883l.007 .117v1a1 1 0 0 1 -1.993 .117l-.007 -.117v-1a1 1 0 0 1 1 -1z" />
                <path d="M12 7a5 5 0 1 1 -4.995 5.217l-.005 -.217l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
            </svg>
        </span>
        <span x-show="theme == 'dark'">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                <path d="M17 4a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2" />
                <path d="M19 11h2m-1 -1v2" />
            </svg>
        </span>
        <span x-show="theme == 'auto'">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="currentColor" class="size-6">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path
                    d="M17 3.34a10 10 0 1 1 -15 8.66l.005 -.324a10 10 0 0 1 14.995 -8.336m-9 1.732a8 8 0 0 0 4.001 14.928l-.001 -16a8 8 0 0 0 -4 1.072" />
            </svg>
        </span>
    </button>
    {{-- Dropdown Menu --}}
    <div x-cloak x-show="isOpen || openedWithKeyboard" x-transition x-trap="openedWithKeyboard"
        x-on:click.outside="isOpen = false, openedWithKeyboard = false" x-on:keydown.down.prevent="$focus.wrap().next()"
        x-on:keydown.up.prevent="$focus.wrap().previous()"
        class="absolute {{ $alignmentClasses }} flex flex-col w-fit {{ $width }} divide-y divide-gray-300 overflow-hidden {{ $roundedMenu }} border border-gray-300 bg-gray-50 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-900"
        role="menu">
        {{-- Dropdown Section --}}
        <div class="flex flex-col py-1.5">
            <button type="button" x-on:click="theme = 'light'; isOpen = false"
                class="flex items-center gap-2 bg-gray-50 px-4 py-2 text-sm text-gray-600 hover:bg-gray-900/5 hover:text-gray-900 focus-visible:bg-gray-900/10 focus-visible:text-gray-900 focus-visible:outline-hidden dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-50/5 dark:hover:text-white dark:focus-visible:bg-gray-50/10 dark:focus-visible:text-white"
                role="menuitem">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="currentColor" class="size-5">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M12 19a1 1 0 0 1 .993 .883l.007 .117v1a1 1 0 0 1 -1.993 .117l-.007 -.117v-1a1 1 0 0 1 1 -1z" />
                    <path
                        d="M18.313 16.91l.094 .083l.7 .7a1 1 0 0 1 -1.32 1.497l-.094 -.083l-.7 -.7a1 1 0 0 1 1.218 -1.567l.102 .07z" />
                    <path
                        d="M7.007 16.993a1 1 0 0 1 .083 1.32l-.083 .094l-.7 .7a1 1 0 0 1 -1.497 -1.32l.083 -.094l.7 -.7a1 1 0 0 1 1.414 0z" />
                    <path d="M4 11a1 1 0 0 1 .117 1.993l-.117 .007h-1a1 1 0 0 1 -.117 -1.993l.117 -.007h1z" />
                    <path d="M21 11a1 1 0 0 1 .117 1.993l-.117 .007h-1a1 1 0 0 1 -.117 -1.993l.117 -.007h1z" />
                    <path
                        d="M6.213 4.81l.094 .083l.7 .7a1 1 0 0 1 -1.32 1.497l-.094 -.083l-.7 -.7a1 1 0 0 1 1.217 -1.567l.102 .07z" />
                    <path
                        d="M19.107 4.893a1 1 0 0 1 .083 1.32l-.083 .094l-.7 .7a1 1 0 0 1 -1.497 -1.32l.083 -.094l.7 -.7a1 1 0 0 1 1.414 0z" />
                    <path
                        d="M12 2a1 1 0 0 1 .993 .883l.007 .117v1a1 1 0 0 1 -1.993 .117l-.007 -.117v-1a1 1 0 0 1 1 -1z" />
                    <path d="M12 7a5 5 0 1 1 -4.995 5.217l-.005 -.217l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
                </svg>
                Claro
            </button>
            <button type="button" x-on:click="theme = 'dark'; isOpen = false"
                class="flex items-center gap-2 bg-gray-50 px-4 py-2 text-sm text-gray-600 hover:bg-gray-900/5 hover:text-gray-900 focus-visible:bg-gray-900/10 focus-visible:text-gray-900 focus-visible:outline-hidden dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-50/5 dark:hover:text-white dark:focus-visible:bg-gray-50/10 dark:focus-visible:text-white"
                role="menuitem">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="size-5">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                    <path d="M17 4a2 2 0 0 0 2 2a2 2 0 0 0 -2 2a2 2 0 0 0 -2 -2a2 2 0 0 0 2 -2" />
                    <path d="M19 11h2m-1 -1v2" />
                </svg>
                Oscuro
            </button>
            <button type="button" x-on:click="theme = 'auto'; isOpen = false"
                class="flex items-center gap-2 bg-gray-50 px-4 py-2 text-sm text-gray-600 hover:bg-gray-900/5 hover:text-gray-900 focus-visible:bg-gray-900/10 focus-visible:text-gray-900 focus-visible:outline-hidden dark:bg-gray-900 dark:text-gray-300 dark:hover:bg-gray-50/5 dark:hover:text-white dark:focus-visible:bg-gray-50/10 dark:focus-visible:text-white"
                role="menuitem">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="currentColor" class="size-5">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M17 3.34a10 10 0 1 1 -15 8.66l.005 -.324a10 10 0 0 1 14.995 -8.336m-9 1.732a8 8 0 0 0 4.001 14.928l-.001 -16a8 8 0 0 0 -4 1.072" />
                </svg>
                Auto
            </button>
        </div>
    </div>
</div>
