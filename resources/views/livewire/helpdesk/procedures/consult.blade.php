<div>
    <section>
        {{-- Campo de búsqueda --}}
        <div class="flex gap-2">
            <x-text-input wire:model="search" wire:keydown.enter="searchProcedure" x-ref="focusInput"
                x-init="$nextTick(() => { $refs.focusInput.focus() })" id="search" type="search" name="search" class="w-full rounded-l-xl rounded-r-xl"
                placeholder="Ingrese el código del ticket" aria-label="Buscar por el código del ticket" required
                autocomplete="off" />
            <x-primary-button wire:loading.class="opacity-50" wire:loading.attr="disabled" wire:click="searchProcedure"
                class="sm:flex gap-2 items-center rounded-xl" title="Buscar trámite">
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
                <div class="hidden sm:block">
                    <span wire:loading.class="hidden" wire:target="searchProcedure">Buscar</span>
                    <span wire:loading wire:target="searchProcedure">Buscando...</span>
                </div>
            </x-primary-button>
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
                            <a href="{{ route('file_view.view_procedure_file', $procedure->procedure_files->first()->uuid) }}"
                                target="_blank"
                                class="flex items-center gap-1 hover:underline hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none focus:underline focus:text-indigo-600 dark:focus:text-indigo-400 transition duration-300"
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
                                class="flex items-center gap-1 hover:underline hover:text-indigo-600 dark:hover:text-indigo-400 focus:outline-none focus:underline focus:text-indigo-600 dark:focus:text-indigo-400 transition duration-300"
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
                <p class="rounded-full px-3 py-1 font-bold shadow whitespace-nowrap {{ $procedureStateBadgeStyles }}">
                    {{ $procedure->state->name }}</p>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div x-data="{ showDescription: false }">
                    <h3 class="text-sm font-light">Asunto</h3>
                    <div x-on:click="showDescription = !showDescription; $refs.showDescriptionButton.focus();"
                        class="flex items-center justify-between hover:text-indigo-600 dark:hover:text-indigo-400 cursor-pointer">
                        <p class="font-medium ">{{ $procedure->reason }}</p>
                        <button x-ref="showDescriptionButton"
                            class="flex items-center gap-2 px-2.5 py-1 rounded-md focus:outline-none focus:text-indigo-600 dark:focus:text-indigo-400 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                            type="button" title="Ver descripción">
                            <span class="transition-transform" x-bind:class="showDescription ? 'rotate-180' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="size-5">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div x-show="showDescription" x-collapse.duration.300ms
                        class="font-light text-sm border-s border-s-indigo-400 dark:border-indigo-600">
                        <p class="px-3 py-1">{{ $procedure->description }}</p>
                    </div>
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
                @livewire('helpdesk.procedures.partials.procedure-derivation', ['derivation' => collect($derivation)], key($loop->iteration))
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
