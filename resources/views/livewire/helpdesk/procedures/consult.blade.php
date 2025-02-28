<div>
    <form wire:submit.prevent="searchTicket">
        @csrf
        <div class="md:flex sm:block items-center gap-4">
            {{-- Código del ticket del trámite --}}
            <x-input-label :value="__('Código del Trámite:')" class="whitespace-nowrap" />
            <div class="w-full my-2">
                <x-text-input id="ticket" class="w-full" type="text" wire:model="ticket" name="ticket"
                    :value="old('ticket')" placeholder="Ingrese el código de trámite" required />
                <x-input-error :messages="$errors->get('ticket')" class="mt-2" />
            </div>
            <div>
                <x-primary-button>
                    {{ __('Consultar') }}
                </x-primary-button>
            </div>
        </div>
    </form>
    <h3 class="mt-6 font-bold bg-indigo-300 dark:bg-slate-700 rounded-t p-2">Datos Generales</h3>
    <div class="border-2 border-gray-200 dark:border-gray-700 shadow-sm p-3 rounded-b">
        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Códido del trámite --}}
            <div>
                <x-input-label :value="__('Código del trámite:')" />
            </div>
            {{-- Fecha de registro --}}
            <div>
                <x-input-label :value="__('Fecha de registro:')" />
            </div>
            {{-- Estado actual --}}
            <div>
                <x-input-label :value="__('Estado actual:')" />
            </div>
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Tipo de identificación --}}
            <div>
                <x-input-label :value="__('Tipo de documento de identidad:')" />
            </div>
            {{-- Num. Identificación --}}
            <div>
                <x-input-label :value="__('Num. Identificación:')" />
            </div>
            {{-- Nombre completo --}}
            <div>
                <x-input-label :value="__('Nombre completo:')" />
            </div>
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Num. RUC --}}
            <div>
                <x-input-label :value="__('RUC:')" />
            </div>
            {{-- Razón social --}}
            <div class="lg:col-span-2 ">
                <x-input-label :value="__('Razón social:')" />
            </div>
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Tipo de documento de trámite --}}
            <div>
                <x-input-label :value="__('Tipo de documento de trámite:')" />
            </div>
            {{-- Categoría --}}
            <div>
                <x-input-label :value="__('Categoría:')" />
            </div>
            {{-- Prioridad --}}
            <div>
                <x-input-label :value="__('Prioridad:')" />
            </div>
        </div>

        {{-- Asunto --}}
        <div class="mt-3">
            <x-input-label :value="__('Asunto:')" />
        </div>
    </div>
    <h3 class="mt-6 font-bold bg-indigo-300 dark:bg-slate-700 rounded-t p-2">Derivaciones</h3>
    <div class="border-2 border-gray-200 dark:border-gray-700 shadow-sm p-3 rounded-b">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Fecha Derivación</th>
                        <th scope="col" class="px-6 py-3">Oficina</th>
                        <th scope="col" class="px-6 py-3">Estado Trámite</th>
                        <th scope="col" class="px-6 py-3">Documento</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            1
                        </td>
                        <td class="px-6 py-4">
                            01/01/2025
                        </td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Oficina de Administración
                        </td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Pendiente
                        </td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Oficio
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <h3 class="mt-6 font-bold bg-indigo-300 dark:bg-slate-700 rounded-t p-2">Comentarios adicionales</h3>
    <div class="border-2 border-gray-200 dark:border-gray-700 shadow-sm p-3 rounded-b">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Fecha Comentario</th>
                        <th scope="col" class="px-6 py-3">Comentario</th>
                        <th scope="col" class="px-6 py-3">Oficina</th>
                        <th scope="col" class="px-6 py-3">Estado Trámite</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            1
                        </td>
                        <td class="px-6 py-4">
                            01/01/2025
                        </td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Comentario de ejemplo
                        </td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Oficina de Administración
                        </td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Pendiente
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('js')
    <script src="{{ asset('js/helpdesk/notifications.js') }}?v={{ env('APP_VERSION') }}"></script>
@endpush
