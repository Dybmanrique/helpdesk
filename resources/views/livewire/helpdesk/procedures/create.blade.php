<div>
    {{-- Steps --}}
    <section class="flex justify-between items-start">
        <div class="flex flex-col items-center">
            <div
                class="w-12 h-12 rounded-full flex items-center justify-center transition duration-500 ease-in-out border-2 {{ $currentStep >= 1 ? 'bg-teal-500 dark:bg-teal-300 border-teal-500 dark:border-teal-300 text-teal-50 dark:text-teal-950' : 'border-gray-500 text-gray-500' }}">
                @if ($currentStep > 1)
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        stroke-linecap="round" stroke-linejoin="round" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M5 12l5 5l10 -10" />
                    </svg>
                @else
                    1
                @endif
            </div>
            <p
                class="text-center mt-4 w-24 sm:w-32 text-xs uppercase transition duration-500 ease-in-out {{ $currentStep == 1 ? 'text-gray-900 dark:text-gray-50' : 'text-gray-500' }}">
                Información del solicitante
            </p>
        </div>
        {{-- Linea de 1 a 2 --}}
        <div
            class="flex-auto mt-6 -mx-6 sm:-mx-10 border-t-2 transition duration-500 ease-in-out {{ $currentStep >= 2 ? 'border-t-teal-500 dark:border-t-teal-300' : 'border-t-gray-500 dark:border-t-gray-500' }}">
        </div>

        <div class="flex flex-col items-center">
            <div
                class="w-12 h-12 rounded-full flex items-center justify-center transition duration-500 ease-in-out border-2 {{ $currentStep >= 2 ? 'bg-teal-500 dark:bg-teal-300 border-teal-500 dark:border-teal-300 text-teal-50 dark:text-teal-950' : 'border-gray-500 text-gray-500' }}">
                @if ($currentStep > 2)
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        stroke-linecap="round" stroke-linejoin="round" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M5 12l5 5l10 -10" />
                    </svg>
                @else
                    2
                @endif
            </div>
            <p
                class="text-center mt-4 w-24 sm:w-32 text-xs uppercase transition duration-500 ease-in-out {{ $currentStep == 2 ? 'text-gray-900 dark:text-gray-50' : 'text-gray-500' }}">
                Descripción de la solicitud o trámite
            </p>
        </div>
        {{-- Linea de 2 a 3 --}}
        <div
            class="flex-auto mt-6 -mx-6 sm:-mx-10 border-t-2 transition duration-500 ease-in-out {{ $currentStep >= 3 ? 'border-t-teal-500 dark:border-t-teal-300' : 'border-t-gray-500 dark:border-t-gray-500' }}">
        </div>

        <div class="flex flex-col items-center">
            <div
                class="w-12 h-12 rounded-full flex items-center justify-center transition duration-500 ease-in-out border-2 {{ $currentStep >= 3 ? 'bg-teal-500 dark:bg-teal-300 border-teal-500 dark:border-teal-300 text-teal-50 dark:text-teal-950' : 'border-gray-500 text-gray-500' }}">
                @if ($currentStep > 3)
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        stroke-linecap="round" stroke-linejoin="round" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M5 12l5 5l10 -10" />
                    </svg>
                @else
                    3
                @endif
            </div>
            <p
                class="text-center mt-4 w-24 sm:w-32 text-xs uppercase transition duration-500 ease-in-out {{ $currentStep == 3 ? 'text-gray-900 dark:text-gray-50' : 'text-gray-500' }}">
                Archivos a adjuntar
            </p>
        </div>
    </section>

    <form wire:submit="save">
        @if ($currentStep === 1)
            {{-- Información del solicitante --}}
            <section class="mt-6 border-2 border-gray-200 dark:border-gray-700 shadow-sm rounded">
                @include('livewire.helpdesk.procedures.partials.applicant-information-form')
            </section>
        @elseif ($currentStep === 2)
            {{-- Descripción de la solicitud o trámite --}}
            <section class="mt-6 border-2 border-gray-200 dark:border-gray-700 shadow-sm rounded">
                <div class="p-3">
                    <div class="grid lg:grid-cols-3 gap-2 mt-3">
                        {{-- Tipo de documento de trámite --}}
                        <div>
                            <x-input-label for="documentTypeId" :value="__('Tipo de documento de trámite: (*)')" />
                            <x-select wire:model="documentTypeId" id="documentTypeId" class="block mt-1 w-full"
                                name="documentTypeId" :value="old('documentTypeId')">
                                <option value="" selected disabled>Seleccione...</option>
                                @foreach ($documentTypes as $documentType)
                                    <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                                @endforeach
                            </x-select>
                            <x-input-error :messages="$errors->get('documentTypeId')" class="mt-2" />
                        </div>
                        {{-- Categoría de trámite --}}
                        <div>
                            <x-input-label for="procedureCategoryId" :value="__('Categoría: (*)')" />
                            <x-select wire:model="procedureCategoryId" id="procedureCategoryId"
                                class="block mt-1 w-full" name="procedureCategoryId" :value="old('procedureCategoryId')">
                                <option value="" selected disabled>Seleccione...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </x-select>
                            <x-input-error :messages="$errors->get('procedureCategoryId')" class="mt-2" />
                        </div>
                    </div>
                    {{-- Asunto --}}
                    <div class="mt-3">
                        <x-input-label for="reason" :value="__('Asunto: (*)')" />
                        <x-text-input wire:model="reason" id="reason" class="block mt-1 w-full" type="text"
                            name="reason"
                            placeholder="Registre en forma clara el asunto por el cual ingresa el documento o nombre del procedimiento." />
                        <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                    </div>
                    {{-- Descripción --}}
                    <div class="mt-3">
                        <x-input-label for="description" :value="__('Descripción: (*)')" />
                        <x-textarea wire:model="description" id="description" class="block mt-1 w-full" type="text"
                            name="description" :value="old('description')" rows="3"
                            placeholder="Ingrese en forma detallada el contenido de su solicitud, procedimiento o trámite." />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>
            </section>
        @elseif ($currentStep === 3)
            {{-- Archivos a adjuntar --}}
            <section class="mt-6 border-2 border-gray-200 dark:border-gray-700 shadow-sm rounded px-3 py-5">
                <x-input-label for="files" :value="__('Archivo:')" class="mb-3" />
                <x-helpdesk.filepond-input wire:model="files" />
            </section>
        @endif

        <section class="flex items-center justify-end mt-6 gap-2">
            @if ($currentStep > 1)
                <x-secondary-button wire:click="previousStep">Atrás</x-secondary-button>
            @endif
            @if ($currentStep < 3)
                <x-secondary-button wire:loading.attr="disabled" wire:click="nextStep">
                    <span wire:loading wire:target="nextStep" class="animate-spin">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z" />
                            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" />
                        </svg>
                    </span>
                    <span wire:loading.class="hidden" wire:target="nextStep">Siguiente</span>
                </x-secondary-button>
            @endif
            @if ($currentStep === 3)
                <x-primary-button wire:loading.class="opacity-50" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading wire:target="save" class="animate-spin">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z" />
                            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" />
                        </svg>
                    </span>
                    <span wire:loading.class="hidden" wire:target="save">Enviar</span>
                </x-primary-button>
            @endif
        </section>
    </form>
</div>
@push('js')
    <script src="{{ asset('js/helpdesk/procedures/create.js') }}?v={{ env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/helpdesk/notifications.js') }}?v={{ env('APP_VERSION') }}"></script>
    {{-- <script src="{{ asset('js/helpdesk/filepond-handler.js') }}?v={{ env('APP_VERSION') }}"></script> --}}
@endpush
