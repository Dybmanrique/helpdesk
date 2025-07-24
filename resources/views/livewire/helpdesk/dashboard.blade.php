<div class="space-y-4">
    {{-- Conteo de trámites por estado --}}
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3 mx-2 sm:mx-0">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <p class="text-sm font-medium">
                    Pendientes
                </p>
                <p class="text-2xl font-bold">{{ $pendingProcedures }}</p>
                <p class="text-xs font-light text-gray-600 dark:text-gray-400">Trámites registrados en Mesa de Partes</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <p class="text-sm font-medium">
                    Rechazados
                </p>
                <p class="text-2xl font-bold">{{ $rejectedProcedures }}</p>
                <p class="text-xs font-light text-gray-600 dark:text-gray-400">Trámites rechazados</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <p class="text-sm font-medium">
                    Archivados
                </p>
                <p class="text-2xl font-bold">{{ $archivedProcedures }}</p>
                <p class="text-xs font-light text-gray-600 dark:text-gray-400">Trámites archivados</p>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-xl">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <p class="text-sm font-medium">
                    Concluidos
                </p>
                <p class="text-2xl font-bold">{{ $closedProcedures }}</p>
                <p class="text-xs font-light text-gray-600 dark:text-gray-400">Trámites cerrados / concluidos</p>
            </div>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl p-6 ">
        <div class="mx-auto">
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">Trámites</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Puede encontrar todos los trámites que ha
                registrado en la siguiente tabla.</p>
            <div class="md:flex items-end justify-between mt-2">
                {{-- Filtros de búsqueda --}}
                <div class="grid sm:grid-cols-4 gap-2">
                    <div class="flex flex-col">
                        <label for="procedureState"
                            class="text-sm font-light text-gray-600 dark:text-gray-400">Estado:</label>
                        <select wire:model.live="procedureState" id="procedureState"
                            class="rounded-xl text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 dark:bg-gray-900">
                            <option value="" selected>Todos</option>
                            @foreach ($procedureStates as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label for="startDate"
                            class="text-sm font-light text-gray-600 dark:text-gray-400">Desde:</label>
                        <input wire:model.change="startDate" type="date" id="startDate"
                            class="rounded-xl text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                    </div>
                    <div class="flex flex-col">
                        <label for="endDate" class="text-sm font-light text-gray-600 dark:text-gray-400">Hasta:</label>
                        <input wire:model.change="endDate" type="date" id="endDate"
                            class="rounded-xl text-gray-900 dark:text-gray-100 border-gray-300 dark:border-gray-700 dark:bg-gray-900" />
                    </div>
                    @if ($procedureState || $startDate || $endDate)
                        <div class="flex items-center justify-end sm:justify-start">
                            <button wire:click="resetFilters" type="button"
                                class="flex items-center gap-1 text-sm font-light text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition-colors duration-300">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="">
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                                        <path d="M3 6h18" />
                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </span>
                                <span>Limpiar filtros</span>
                            </button>
                        </div>
                    @endif
                </div>
                {{-- Campo de búsqueda --}}
                <div class="">
                    <div class="relative mt-3 flex items-center md:mt-0 text-gray-900 dark:text-gray-100">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                stroke-linecap="round" stroke-linejoin="round" fill="none" stroke="currentColor"
                                stroke-width="2" class="mx-3 h-5 w-5">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <input wire:model.live.debounce.350ms="search" type="search" placeholder="Buscar"
                            aria-label="Buscar número de expediente o asunto"
                            class="block w-full py-1.5 pr-5 pl-11 lg:w-80 rounded-xl border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900" />
                    </div>
                </div>
            </div>
            {{-- Tabla de todos los trámites registrados por el usuario --}}
            <div class="mt-3 relative">
                <div class="overflow-x-auto">
                    <div
                        class="inline-block min-w-full overflow-hidden border border-gray-200 md:rounded-xl dark:border-gray-700">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-white dark:bg-gray-900">
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 dark:text-gray-400">
                                        #</th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 dark:text-gray-400">
                                        {{-- Botón para cambiar el orden por fecha --}}
                                        <button wire:click="changeSortDirection" wire:loading.attr="disabled"
                                            class="flex cursor-pointer items-center gap-x-3 focus:outline-none hover:text-gray-800 dark:hover:text-gray-50">
                                            @if ($sortCreatedDateDirection === 'desc')
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="h-4">
                                                    <path d="m14 18 4 4 4-4" />
                                                    <path d="M16 2v4" />
                                                    <path d="M18 14v8" />
                                                    <path
                                                        d="M21 11.354V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7.343" />
                                                    <path d="M3 10h18" />
                                                    <path d="M8 2v4" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="h-4">
                                                    <path d="m14 18 4-4 4 4" />
                                                    <path d="M16 2v4" />
                                                    <path d="M18 22v-8" />
                                                    <path
                                                        d="M21 11.343V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h9" />
                                                    <path d="M3 10h18" />
                                                    <path d="M8 2v4" />
                                                </svg>
                                            @endif
                                            <span>Fecha</span>
                                        </button>
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 dark:text-gray-400">
                                        Num. Expediente</th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 dark:text-gray-400">
                                        Asunto</th>
                                    <th scope="col"
                                        class="px-4 py-3.5 text-left text-sm font-normal text-gray-500 dark:text-gray-400">
                                        Estado</th>
                                    <th scope="col" class="px-4 py-3.5">
                                        <span class="sr-only">Ver</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                                @if ($this->procedures->isNotEmpty())
                                    @foreach ($this->procedures as $procedure)
                                        <tr class="hover:bg-gray-300/50 dark:hover:bg-gray-800/50">
                                            <td
                                                class="px-4 py-4 text-sm font-medium whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                {{ ($this->procedures->currentPage() - 1) * $this->procedures->perPage() + $loop->iteration }}
                                            </td>
                                            <td
                                                class="px-4 py-4 text-sm whitespace-nowrap text-gray-600 dark:text-gray-400">
                                                {{ $procedure->created_at->format('d-m-Y') }}</td>
                                            <td
                                                class="px-4 py-4 text-sm font-medium whitespace-nowrap text-gray-800 dark:text-white">
                                                {{ $procedure->expedient_number }}</td>
                                            <td class="px-4 py-4 text-sm min-w-52 text-gray-700 dark:text-gray-200">
                                                {{ $procedure->reason }}</td>
                                            <td class="px-4 py-4 text-sm font-medium whitespace-nowrap">
                                                <span
                                                    class="rounded-full px-3 py-1 text-sm font-normal {{ $this->getStateBadgeStyles($procedure->state->name) }}">
                                                    {{ $procedure->state->name }}</span>
                                            </td>
                                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                {{-- Botón para ver la información completa del trámite --}}
                                                <button wire:click="getProcedureInformation({{ $procedure->id }})"
                                                    wire:loading.class="opacity-50" wire:loading.attr="disabled"
                                                    type="button"
                                                    class="flex items-center justify-center space-x-2 rounded-xl px-3 py-1 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors duration-200">
                                                    <span wire:loading.class="hidden"
                                                        wire:target="getProcedureInformation({{ $procedure->id }})">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22"
                                                            height="22" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="">
                                                            <path
                                                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                                            <circle cx="12" cy="12" r="3" />
                                                        </svg>
                                                    </span>
                                                    <span wire:loading
                                                        wire:target="getProcedureInformation({{ $procedure->id }})"
                                                        class="animate-spin">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="22"
                                                            height="22" viewBox="0 0 24 24" fill="currentColor">
                                                            <path
                                                                d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z" />
                                                            <path
                                                                d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" />
                                                        </svg>
                                                    </span>
                                                    <span>Ver detalles</span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6"
                                            class="px-4 py-4 text-center text-sm font-medium whitespace-nowrap text-gray-600 dark:text-gray-400">
                                            No hay registros disponibles
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div wire:loading.class="absolute inset-0 md:rounded-xl flex items-center justify-center bg-gray-300/80 dark:bg-gray-900/80 pointer-events-none"
                    wire:target="search, startDate, endDate, procedureState,changeSortDirection, perPage">
                    <div wire:loading.class="md:rounded-xl"
                        wire:target="search, startDate, endDate, procedureState,changeSortDirection, perPage"
                        wire:loading.class.remove="hidden" class="hidden">
                        <div class="flex items-center justify-center gap-2 text-gray-700 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                viewBox="0 0 24 24" fill="currentColor" class="animate-spin">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z" />
                                <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" />
                            </svg>
                            <span>Cargando datos...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-0.5">
                {{ $this->procedures->links(data: ['scrollTo' => false]) }}
            </div>
        </div>

        {{-- Modal de la información del trámite --}}
        <x-modal name="procedure-information-modal" maxWidth="2xl" focusable>
            {{-- Modal header --}}
            <div class="m-3 flex items-center justify-between text-gray-800 dark:text-gray-200">
                <h2 class="text-lg font-bold">Información del trámite</h2>
                <button @click="$dispatch('close-modal', { name: 'procedure-information-modal' })" type="button"
                    class="rounded-lg p-1 hover:bg-gray-800 hover:text-gray-200 dark:hover:bg-gray-200 dark:hover:text-gray-800 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>
            {{-- Modal body --}}
            <div class="m-4 text-gray-800 dark:text-gray-200">
                @livewire('helpdesk.procedures.partials.procedure-information', ['procedureId' => $procedureId], key($procedureId))
            </div>
        </x-modal>

    </div>
</div>
