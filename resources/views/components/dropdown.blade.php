@props(['alignmentClasses' => 'bottom-right', 'width' => '48', 'roundedMenu' => 'sm'])

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
        {{ $attributes->merge(['class' => 'flex items-center gap-2 whitespace-nowrap border border-gray-300 bg-gray-50 p-2 text-sm font-medium tracking-wide transition hover:opacity-75 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:focus-visible:outline-gray-300']) }}
        x-bind:class="isOpen || openedWithKeyboard ? 'text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-300'"
        x-bind:aria-expanded="isOpen || openedWithKeyboard" aria-haspopup="true">
        {{ $toggleButtonContent }}
    </button>
    {{-- Dropdown Menu --}}
    <div x-cloak x-show="isOpen || openedWithKeyboard" x-transition x-trap="openedWithKeyboard"
        x-on:click.outside="isOpen = false, openedWithKeyboard = false" x-on:keydown.down.prevent="$focus.wrap().next()"
        x-on:keydown.up.prevent="$focus.wrap().previous()"
        class="absolute {{ $alignmentClasses }} flex flex-col w-fit {{ $width }} divide-y divide-gray-300 overflow-hidden {{ $roundedMenu }} border border-gray-300 bg-gray-50 dark:divide-gray-700 dark:border-gray-700 dark:bg-gray-900"
        role="menu">
        {{-- Dropdown Section --}}
        {{ $dropdownSections }}
    </div>
</div>
