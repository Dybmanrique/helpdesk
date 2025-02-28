<div>
    <h3 class="font-bold bg-indigo-300 dark:bg-slate-700 rounded-t p-2">Información del solicitante</h3>
    <div class="border-2 border-gray-200 dark:border-gray-700 shadow-sm p-3 rounded-b">
        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Tipo de identificación --}}
            <div>
                <x-input-label for="identity_type_id" :value="__('Tipo de documento de identidad:')" />
                @foreach ($identity_types as $identity_type)
                    @if ($user->person->identity_type_id == $identity_type->id)
                        <p
                            class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                            {{ $user->person->identity_type->name === 'RUC' ? 'DNI' : $identity_type->name }}
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
            {{-- Nombre --}}
            <div>
                <x-input-label for="name" :value="__('Nombre:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $user->person->name }}</p>
            </div>
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
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Num. RUC --}}
            <div>
                <x-input-label for="ruc" :value="__('RUC:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $legal_person ? $legal_person->ruc : '-' }}</p>
            </div>
            {{-- Razón social --}}
            <div class="lg:col-span-2 ">
                <x-input-label for="company_name" :value="__('Razón social:')" />
                <p
                    class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                    {{ $legal_person ? $legal_person->company_name : '-' }}</p>
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
                    <x-input-label for="document_type_id" :value="__('Tipo de documento de trámite:') . ' (*)'" />
                    <x-select id="document_type_id" class="block mt-1 w-full" wire:model="document_type_id"
                        name="document_type_id" :value="old('document_type_id')" required>
                        <option value="">Seleccione...</option>
                        @foreach ($document_types as $document_type)
                            <option value="{{ $document_type->id }}">{{ $document_type->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('document_type_id')" class="mt-2" />
                </div>
                {{-- Categoría de trámite --}}
                <div>
                    <x-input-label for="procedure_category_id" :value="__('Categoría:') . ' (*)'" />
                    <x-select id="procedure_category_id" class="block mt-1 w-full" wire:model="procedure_category_id"
                        name="procedure_category_id" :value="old('procedure_category_id')" required>
                        <option value="">Seleccione...</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('procedure_category_id')" class="mt-2" />
                </div>
                {{-- Prioridad de trámite --}}
                <div>
                    <x-input-label for="procedure_priority_id" :value="__('Prioridad:') . ' (*)'" />
                    <x-select id="procedure_priority_id" class="block mt-1 w-full" wire:model="procedure_priority_id"
                        name="procedure_priority_id" :value="old('procedure_priority_id')" required>
                        <option value="">Seleccione...</option>
                        @foreach ($priorities as $priority)
                            <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('procedure_priority_id')" class="mt-2" />
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
                <!-- File Input -->
                <x-input-label for="files" :value="__('Archivo:')" />
                <x-text-input id="files" class="block mt-1 w-full" type="file" wire:model="files" name="files"
                    :value="old('files')" accept="application/pdf, image/*" required />
                <x-input-error :messages="$errors->get('files')" class="mt-2" />
                <!-- Progress Bar -->
                <div x-show="uploading" class="flex items-center bg-gray-800 mt-1">
                    <div class="w-[15rem] rounded-full bg-gray-700">
                        <div class="bg-blue-500 h-full rounded-full text-white font-medium p-0.5 text-xs text-center"
                            :style="'width:' + progress + '%'">
                            <span x-text="progress + '%'"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end mt-6">
            <x-primary-button>
                {{ __('Enviar') }}
            </x-primary-button>
        </div>
    </form>
</div>
@push('js')
    <script src="{{ asset('js/helpdesk/notifications.js') }}?v={{ env('APP_VERSION') }}"></script>
    <script src="{{ asset('js/helpdesk/procedures/create.js') }}?v={{ env('APP_VERSION') }}"></script>
@endpush
