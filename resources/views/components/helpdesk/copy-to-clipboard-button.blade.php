@props(['text' => ''])

<div x-data="{ texto: @js($text), copiado: false }">
    <button
        x-on:click="
            navigator.clipboard.writeText(texto).then(() => {
                copiado = true;
                setTimeout(() => copiado = false, 5000);
            })
        "
        class="rounded flex hover:text-gray-600 dark:hover:text-gray-400 transition-colors duration-300" title="Copiar">
        <span x-show="!copiado" x-transition:enter.duration.500ms class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                <rect width="14" height="14" x="8" y="8" rx="2" ry="2" />
                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
            </svg>
        </span>
        <span x-show="copiado" x-transition:enter.duration.500ms
            class="text-green-500 flex items-center justify-center gap-2 text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5">
                <path d="m12 15 2 2 4-4" />
                <rect width="14" height="14" x="8" y="8" rx="2" ry="2" />
                <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
            </svg>
            ¡Copiado!
        </span>
    </button>
</div>
