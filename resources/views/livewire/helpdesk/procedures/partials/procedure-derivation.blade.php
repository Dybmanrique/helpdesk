<div>
    <div
        class="rounded-xl border border-l-2 overflow-hidden hover:bg-gray-300/30 dark:hover:bg-gray-950/20 {{ $borderStyles }}">
        <details class="group focus-within:bg-gray-300/30 dark:focus-within:bg-gray-950/20" name="derivations">
            <summary
                class="flex flex-col-reverse sm:flex-row items-center justify-between gap-2 cursor-pointer list-none p-4 group-open:bg-gray-200/30 dark:group-open:bg-gray-900/20">
                <div class="flex items-center justify-start sm:justify-center w-full sm:w-auto space-x-2">
                    {{-- icono --}}
                    <i class="{{ $iconStyles }}"></i>
                    <div>
                        <h3 class="text-base font-semibold tracking-tight">{{ $derivation['iteration'] }}:
                            {{ $derivation['fromOffice'] }} →
                            {{ $derivation['toOffice'] }}</h3>
                        <p class="text-sm">{{ $derivation['date'] }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between sm:justify-center w-full sm:w-auto gap-2">
                    <p
                        class="rounded-full px-2.5 py-0.5 text-xs capitalize font-semibold whitespace-nowrap border {{ $badgeStyles }}">
                        {{ $derivation['state'] }}
                    </p>
                    <div class="transition-transform group-open:rotate-180">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </div>
                </div>
            </summary>
            {{-- Información de la derivación --}}
            <div class="space-y-3 p-4 pt-1 group-open:bg-gray-200/30 dark:group-open:bg-gray-900/20">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-1">
                    <div>
                        <h3 class="text-sm font-medium">De</h3>
                        <p class="text-sm">{{ $derivation['fromUser'] }}</p>
                        <p class="text-sm">{{ $derivation['fromOffice'] }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium">Para</h3>
                        <p class="text-sm">{{ $derivation['toUser'] }}</p>
                        <p class="text-sm">{{ $derivation['toOffice'] }}</p>
                    </div>
                </div>
                {{-- Información de las acciones --}}
                @if ($derivation['actions']->isNotEmpty())
                    <div class="space-y-1">
                        <h3 class="text-sm font-semibold">Acciones</h3>
                        <div class="space-y-3">
                            @foreach ($derivation['actions'] as $action)
                                <div class="rounded-xl border border-gray-400 px-3 py-2 space-y-3">
                                    <div>
                                        <p class="capitalize font-medium">{{ $action->action }} <span
                                                class="text-xs font-light ml-1">{{ $action->created_at->format('d-m-Y') }}</span>
                                        </p>
                                        <p class="text-sm font-light">{{ $action->comment }}</p>
                                    </div>
                                    {{-- Archivos de acciones adjuntos --}}
                                    <div class="space-y-1">
                                        <p class="text-xs">Archivos adjuntos:</p>
                                        @if ($action->action_files->isNotEmpty())
                                            <div class="space-y-1">
                                                @foreach ($action->action_files as $actionFile)
                                                    <div class="text-sm font-light">
                                                        <a href="{{ route('file_view.view_action_file', $actionFile->uuid) }}"
                                                            target="_blank"
                                                            class="inline-flex items-center gap-2 hover:underline hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none focus:underline focus:text-indigo-600 dark:focus:text-indigo-400 transition duration-300">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="size-4">
                                                                    <path d="m10 18 3-3-3-3" />
                                                                    <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                                                    <path
                                                                        d="M4 11V4a2 2 0 0 1 2-2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h7" />
                                                                </svg>
                                                            </span>
                                                            <span>{{ $actionFile->name }}</span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-xs font-light text-gray-600 dark:text-gray-400">
                                                -Sin archivos adjuntos-
                                            </p>
                                        @endif
                                    </div>
                                    {{-- Información de las resoluciones --}}
                                    @if ($action->resolutions->isNotEmpty())
                                        <div class="space-y-1">
                                            <h4 class="text-sm font-semibold">Resoluciones</h4>
                                            @foreach ($action->resolutions as $resolution)
                                                <div
                                                    class="rounded-xl border border-slate-300 dark:border-slate-600 px-3 py-2 space-y-2">
                                                    <div class="flex flex-col-reverse sm:flex-row items-start justify-between gap-2">
                                                        <div>
                                                            <p class="font-normal">
                                                                {{ $resolution->resolution_number }}</p>
                                                            <p class="text-sm font-light">
                                                                {{ $resolution->description }}
                                                            </p>
                                                        </div>
                                                        <p
                                                            class="rounded-full px-2.5 py-0.5 text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-gray-800">
                                                            {{ $resolution->resolution_state->name }}</p>
                                                    </div>
                                                    {{-- Archivos de resoluciones adjuntos --}}
                                                    <div class="space-y-1">
                                                        <p class="text-xs">Archivo resolución:</p>
                                                        @if (!empty($resolution->file_resolution))
                                                            <div class="text-sm font-light">
                                                                <a href="{{ route('file_view.view_resolution_file', $resolution->file_resolution->uuid) }}"
                                                                    target="_blank"
                                                                    class="inline-flex items-center gap-2 hover:underline hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none focus:underline focus:text-indigo-600 dark:focus:text-indigo-400 transition duration-300">
                                                                    <span>
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none"
                                                                            stroke="currentColor" stroke-width="2"
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round" class="size-4">
                                                                            <path d="m10 18 3-3-3-3" />
                                                                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                                                            <path
                                                                                d="M4 11V4a2 2 0 0 1 2-2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h7" />
                                                                        </svg>
                                                                    </span>
                                                                    <span>{{ $resolution->file_resolution->name }}</span>
                                                                </a>
                                                            </div>
                                                        @else
                                                            <p
                                                                class="text-xs font-light text-gray-600 dark:text-gray-400">
                                                                -Sin archivos adjuntos-
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </details>
    </div>
</div>
