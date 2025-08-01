<div>
    <section>
        <div class="flex gap-2">
            <x-text-input wire:model="search" wire:keydown.enter="searchProcedure" id="search" type="search"
                name="search" class="w-full rounded-l-xl rounded-r-xl" placeholder="Ingrese el código del ticket"
                aria-label="Buscar por el código del ticket" required />
            <button wire:loading.class="opacity-50" wire:loading.attr="disabled" wire:click="searchProcedure"
                class="flex gap-2 items-center p-2 px-4 rounded-xl text-slate-50 dark:text-slate-800 border border-gray-300 dark:border-gray-700 bg-slate-800 dark:bg-slate-200">
                <span wire:loading.class="hidden" wire:target="searchProcedure">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                        stroke-linecap="round" stroke-linejoin="round" fill="none" stroke="currentColor"
                        stroke-width="2" class="h-6">
                        <circle cx="11" cy="11" r="8" />
                        <path d="m21 21-4.3-4.3" />
                    </svg>
                </span>
                <span wire:loading wire:target="searchProcedure" class="animate-spin">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                        fill="currentColor">
                        <path d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z" />
                        <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" />
                    </svg>
                </span>
                <span wire:loading.class="hidden" wire:target="searchProcedure">Buscar</span>
                <span wire:loading wire:target="searchProcedure">Buscando...</span>
            </button>
        </div>
        <x-input-error :messages="$errors->get('search')" class="mt-2" />
    </section>
    @if ($procedure)
        <div class="border rounded-xl p-6 pt-4 space-y-6 mt-4">
            {{-- Datos generales --}}
            <div class="flex flex-col-reverse sm:flex-row items-start justify-between gap-2">
                <div class="space-y-0.5 w-full">
                    <h2 class="text-xl font-bold">Datos generales del trámite</h2>
                    <div class="sm:flex items-center gap-2 text-sm">
                        <h3>Num. Expediente:</h3>
                        <p>{{ $procedure->expedient_number }}</p>
                    </div>
                    <div class="sm:flex items-center gap-2 text-sm">
                        <h3>Ticket:</h3>
                        <div class="flex gap-2">
                            <p class="whitespace-nowrap truncate">{{ $procedure->ticket }}</p>
                            <x-helpdesk.copy-to-clipboard-button text="{{ $procedure->ticket }}" />
                        </div>
                    </div>
                    <div class="sm:flex items-center gap-2 text-sm">
                        <h3>Archivo adjunto:</h3>
                        @if ($procedure->procedure_files->isNotEmpty())
                            <a href="{{ route('procedures.view_file', $procedure->procedure_files->first()->uuid) }}"
                                target="_blank"
                                class="flex items-center gap-1 hover:text-gray-600 dark:hover:text-gray-400 transition-colors duration-300"
                                title="Ver archivo adjunto">
                                <span
                                    class="whitespace-nowrap truncate">{{ $procedure->procedure_files->first()->name }}</span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="size-5">
                                        <path d="m10 18 3-3-3-3" />
                                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                                        <path
                                            d="M4 11V4a2 2 0 0 1 2-2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h7" />
                                    </svg>
                                </span>
                            </a>
                        @elseif(!empty($procedure->procedure_link))
                            <a href="{{ $procedure->procedure_link->url }}" target="_blank"
                                class="flex items-center gap-1 hover:text-gray-600 dark:hover:text-gray-400 transition-colors duration-300"
                                title="Ver archivo adjunto">
                                <span class="whitespace-nowrap truncate">Abrir enlace compartido</span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="size-5">
                                        <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                                        <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
                                    </svg>
                                </span>
                            </a>
                        @else
                            <p class="text-gray-600 dark:text-gray-400">-Sin archivo adjunto-</p>
                        @endif
                    </div>
                </div>
                <p
                    class="rounded-full px-3 py-1 font-bold shadow {{ $stateBadgeStyles[$procedure->state->name] ?? 'text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-gray-800 border border-blue-600 dark:border-blue-400' }}">
                    {{ $procedure->state->name }}</p>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <h3 class="text-sm font-light">Asunto</h3>
                    <p class="font-medium">{{ $procedure->reason }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-light">Fecha de registro</h3>
                    <p class="font-medium">{{ $procedure->created_at->format('d-m-Y') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-light">Tipo de documento</h3>
                    <p class="capitalize font-medium">{{ $procedure->document_type->name }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-light">Categoría</h3>
                    <p class="capitalize font-medium">{{ $procedure->category->name }}</p>
                </div>
            </div>
            {{-- Información del solicitante --}}
            <div class="mt-6">
                <h3 class="text-sm font-light">Información del solicitante</h3>
                <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <p class="text-sm font-medium">Nombre: {{ $applicant['name'] }}</p>
                        <p class="text-sm font-medium">Tipo: {{ $applicant['type'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium">Identificación:
                            {{ $applicant['identityType'] . '-' . $applicant['identityNumber'] }}</p>
                        <p class="text-sm font-medium">Email: {{ $applicant['email'] }}</p>
                    </div>
                    @if ($procedure->is_juridical)
                        <div>
                            <p class="text-sm font-medium">RUC: {{ $applicant['ruc'] }}</p>
                            <p class="text-sm font-medium">Razón social: {{ $applicant['companyName'] }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        {{-- Linea de tiempo - Derivaciones --}}
        <h2 class="text-xl font-bold mt-4">Trazabilidad del trámite</h2>
        <div class="space-y-3 mt-3">
            @foreach ($derivations as $derivation)
                <div
                    class="rounded-xl border border-l-2 overflow-hidden {{ $loop->iteration < count($derivations) || count($derivations) === 1 ? 'border-l-green-500' : 'border-l-cyan-500' }}">
                    <details class="group" name="derivations">
                        <summary class="flex items-center justify-between cursor-pointer list-none p-4">
                            <div class="flex items-center space-x-2">
                                {{-- icono --}}
                                @if ($loop->iteration < count($derivations) || count($derivations) === 1)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="h-5 w-5 text-green-500 shrink-0">
                                        <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                                        <path d="m9 11 3 3L22 4" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="h-5 w-5 text-cyan-500 shrink-0">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                @endif
                                <div>
                                    <h3 class="text-base font-semibold tracking-tight">{{ $loop->iteration }}:
                                        {{ $derivation['fromOffice'] }} →
                                        {{ $derivation['toOffice'] }}</h3>
                                    <p class="text-sm">{{ $derivation['date'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <p
                                    class="rounded-full px-2.5 py-0.5 text-xs capitalize font-semibold whitespace-nowrap border {{ $loop->iteration < count($derivations) || count($derivations) === 1 ? 'text-green-700 dark:text-green-500 border-green-700 dark:border-green-500' : 'text-cyan-700 dark:text-cyan-500 border-cyan-700 dark:border-cyan-500' }}">
                                    {{ $derivation['state'] }}
                                </p>
                                <div class="transition-transform group-open:rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </div>
                            </div>
                        </summary>
                        {{-- Información de la derivación --}}
                        <div class="space-y-3 p-4 pt-0">
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
                                            <div class="rounded-xl border px-3 py-2 space-y-3">
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
                                                                    <a href="{{ route('procedures.view_action_file', $actionFile->uuid) }}"
                                                                        target="_blank"
                                                                        class="inline-flex items-center gap-2 hover:text-gray-600 dark:hover:text-gray-400 transition-colors duration-300">
                                                                        <span>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                width="24" height="24"
                                                                                viewBox="0 0 24 24" fill="none"
                                                                                stroke="currentColor" stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
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
                                                                <div class="flex items-start justify-between">
                                                                    <div>
                                                                        <p class="font-normal">
                                                                            {{ $resolution->resolution_number }}</p>
                                                                        <p class="text-sm font-light">
                                                                            {{ $resolution->description }}
                                                                        </p>
                                                                    </div>
                                                                    <p
                                                                        class="rounded-full px-2.5 py-0.5 text-xs font-semibold text-cyan-700 dark:text-cyan-500 border border-cyan-700 dark:border-cyan-500">
                                                                        {{ $resolution->resolution_state->name }}</p>
                                                                </div>
                                                                {{-- Archivos de resoluciones adjuntos --}}
                                                                <div class="space-y-1">
                                                                    <p class="text-xs">Archivo resolución:</p>
                                                                    @if (!empty($resolution->file_resolution))
                                                                        <div class="text-sm font-light">
                                                                            <a href="{{ route('procedures.view_resolution_file', $resolution->file_resolution->uuid) }}"
                                                                                target="_blank"
                                                                                class="inline-flex items-center gap-2 hover:text-gray-600 dark:hover:text-gray-400 transition-colors duration-300">
                                                                                <span>
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        width="24" height="24"
                                                                                        viewBox="0 0 24 24"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-width="2"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        class="size-4">
                                                                                        <path d="m10 18 3-3-3-3" />
                                                                                        <path
                                                                                            d="M14 2v4a2 2 0 0 0 2 2h4" />
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
            @endforeach
        </div>
        {{-- Botón Ver más --}}
        @if (count($derivations) < count($allProcedureDerivations))
            <div class="w-full flex items-center justify-center mt-4">
                <button wire:loading.class="opacity-50" wire:loading.attr="disabled" wire:click="loadMoreDerivations"
                    class="flex items-center justify-center space-x-2" type="button">
                    <span>Ver más</span>
                    <span wire:loading.class="hidden" wire:target="loadMoreDerivations">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </span>
                    <span wire:loading wire:target="loadMoreDerivations" class="animate-spin">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z" />
                            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" />
                        </svg>
                    </span>
                </button>
            </div>
        @endif
    @else
        {{-- Loader Squeleton - cargas muy lentas --}}
        <div wire:loading.delay.longest wire:target="searchProcedure"
            class="mt-4 flex h-dvh w-full flex-col space-y-4">
            <div class="h-1/2 w-full animate-pulse rounded-md bg-neutral-400/50"></div>
            <div class="flex flex-col gap-2 h-1/2">
                <div class="h-1/5 w-2/4 animate-pulse rounded-md bg-neutral-400/50"></div>
                <div class="h-2/5 w-full animate-pulse rounded-md bg-neutral-400/50"></div>
                <div class="h-2/5 w-full animate-pulse rounded-md bg-neutral-400/50"></div>
                <div class="h-2/5 w-full animate-pulse rounded-md bg-neutral-400/50"></div>
            </div>
        </div>
    @endif
</div>
@push('js')
    <script src="{{ asset('js/helpdesk/notifications.js') }}?v={{ env('APP_VERSION') }}"></script>
@endpush
