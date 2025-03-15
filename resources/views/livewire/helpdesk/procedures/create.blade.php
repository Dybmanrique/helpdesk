<div>
    <h3 class="font-bold bg-indigo-300 dark:bg-slate-700 rounded-t p-2">Información del solicitante</h3>
    <div class="border-2 border-gray-200 dark:border-gray-700 shadow-sm p-3 rounded-b">
        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Tipo de identificación --}}
            <div>
                <x-input-label for="identity_type_id" :value="__('Tipo de documento de identidad:')" />
                @foreach ($identityTypes as $identityType)
                    @if ($user->person->identity_type_id == $identityType->id)
                        <p
                            class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                            {{ $user->person->identity_type->name === 'RUC' ? 'DNI' : $identityType->name }}
                            {{-- si el usuario se registró con la opción RUC, entonces el documento de identidad es DNI (representante legal) --}}
                        </p>
                    @endif
                @endforeach
            </div>
            {{-- Num. Identificación --}}
            <div>
                <x-input-label for="identity_number" :value="__('Num. Identificación:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $user->person->identity_number }}</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Apellido paterno --}}
            <div>
                <x-input-label for="last_name" :value="__('Apellido paterno:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $user->person->last_name }}</p>
            </div>
            {{-- Apellido materno --}}
            <div>
                <x-input-label for="second_last_name" :value="__('Apellido materno:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $user->person->second_last_name }}</p>
            </div>
            {{-- Nombre --}}
            <div>
                <x-input-label for="name" :value="__('Nombre:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $user->person->name }}</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Num. RUC --}}
            <div>
                <x-input-label for="ruc" :value="__('RUC:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $legalPerson ? $legalPerson->ruc : '-' }}</p>
            </div>
            {{-- Razón social --}}
            <div class="lg:col-span-2 ">
                <x-input-label for="company_name" :value="__('Razón social:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $legalPerson ? $legalPerson->company_name : '-' }}</p>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $user->email }}</p>
            </div>
            {{-- Celular --}}
            <div>
                <x-input-label for="phone" :value="__('Celular:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $user->person->phone }}</p>
            </div>
        </div>
    </div>

    <form wire:submit="save">
        @csrf
        <h3 class="mt-6 font-bold bg-indigo-300 dark:bg-slate-700 rounded-t p-2">Descripción de la solicitud o trámite
        </h3>
        <div class="border-2 border-gray-200 dark:border-gray-700 shadow-sm p-3 rounded-b">
            <div class="grid lg:grid-cols-3 gap-2 mt-3">
                {{-- Tipo de documento de trámite --}}
                <div>
                    <x-input-label for="documentTypeId" :value="__('Tipo de documento de trámite:') . ' (*)'" />
                    <x-select id="documentTypeId" class="block mt-1 w-full" wire:model="documentTypeId"
                        name="documentTypeId" :value="old('documentTypeId')" required>
                        <option value="">Seleccione...</option>
                        @foreach ($documentTypes as $documentType)
                            <option value="{{ $documentType->id }}">{{ $documentType->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('documentTypeId')" class="mt-2" />
                </div>
                {{-- Categoría de trámite --}}
                <div>
                    <x-input-label for="procedureCategoryId" :value="__('Categoría:') . ' (*)'" />
                    <x-select id="procedureCategoryId" class="block mt-1 w-full" wire:model="procedureCategoryId"
                        name="procedureCategoryId" :value="old('procedureCategoryId')" required>
                        <option value="">Seleccione...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('procedureCategoryId')" class="mt-2" />
                </div>
            </div>
            {{-- Asunto --}}
            <div class="mt-3">
                <x-input-label for="reason" :value="__('Asunto:') . ' (*)'" />
                <x-text-input id="reason" class="block mt-1 w-full" type="text" wire:model.live="reason"
                    name="reason"
                    placeholder="Registre en forma clara el asunto por el cual ingresa el documento o nombre del procedimiento."
                    required />
                <x-input-error :messages="$errors->get('reason')" class="mt-2" />
            </div>
            {{-- Descripción --}}
            <div class="mt-3">
                <x-input-label for="description" :value="__('Descripción:') . ' (*)'" />
                <x-textarea id="description" class="block mt-1 w-full" type="text" wire:model="description"
                    name="description" :value="old('description')" rows="3"
                    placeholder="Ingrese en forma detallada el contenido de su solicitud, procedimiento o trámite."
                    required />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
        </div>

        <h3 class="mt-6 font-bold bg-indigo-300 dark:bg-slate-700 rounded-t p-2">Archivos a adjuntar</h3>
        <div class="border-2 border-gray-200 dark:border-gray-700 shadow-sm p-3 rounded-b">
            {{-- Archivos a adjuntar --}}
            <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress" class="my-3">
                {{-- Progress Bar --}}
                <x-input-label for="files" :value="__('Archivo:')" />
                <div x-show="uploading" class="flex items-center mt-1">
                    <div class="w-[15rem] rounded-full bg-gray-300 dark:bg-gray-700">
                        <div class="bg-blue-500 h-full rounded-full text-white font-medium p-0.5 text-xs text-center"
                            :style="'width:' + progress + '%'">
                            <span x-text="progress + '%'"></span>
                        </div>
                    </div>
                </div>
                {{-- File Input --}}
                <x-text-input id="files" class="block mt-1 w-full" type="file" wire:model="files" name="files"
                    :value="old('files')" accept="application/pdf, image/*" />
                <x-input-error :messages="$errors->get('files')" class="mt-2" />
            </div>
        </div>
        <div class="flex items-center justify-end mt-6">
            <x-primary-button wire:loading.class="opacity-50">
                <span wire:loading wire:target="save" class="animate-spin mr-2">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z"
                            fill="currentColor" />
                        <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor" />
                    </svg>
                </span>
                {{ __('Enviar') }}
            </x-primary-button>
        </div>
    </form>
</div>
@push('js')
    <script src="{{ asset('js/helpdesk/notifications.js') }}?v={{ env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/helpdesk/procedures/create.js') }}?v={{ env('APP_VERSION') }}"></script>
@endpush
