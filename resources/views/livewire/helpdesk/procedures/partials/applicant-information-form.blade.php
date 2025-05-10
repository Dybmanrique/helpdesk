<div>
    @auth
        <div class="p-3">
            <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
                {{-- Tipo de identificación --}}
                <div>
                    <x-input-label :value="__('Tipo de documento de identidad: (*)')" />
                    <p
                        class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                        {{ $user->person->identity_type->name === 'RUC' ? 'DNI' : $user->person->identity_type->name }}
                        {{-- si el usuario se registró con la opción RUC, entonces el documento de identidad es DNI (representante legal) --}}
                    </p>
                </div>
                {{-- Num. Identificación --}}
                <div>
                    <x-input-label :value="__('Num. Identificación: (*)')" />
                    <p
                        class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                        {{ $user->person->identity_number }}</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
                {{-- Apellido paterno --}}
                <div>
                    <x-input-label :value="__('Apellido paterno: (*)')" />
                    <p
                        class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                        {{ $user->person->last_name }}</p>
                </div>
                {{-- Apellido materno --}}
                <div>
                    <x-input-label :value="__('Apellido materno: (*)')" />
                    <p
                        class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                        {{ $user->person->second_last_name }}</p>
                </div>
                {{-- Nombre --}}
                <div>
                    <x-input-label :value="__('Nombre: (*)')" />
                    <p
                        class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                        {{ $user->person->name }}</p>
                    <x-input-error :messages="$errors->get('applicant.name')" class="mt-2" />
                </div>
            </div>

            <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
                {{-- Email --}}
                <div>
                    <x-input-label :value="__('Email: (*)')" />
                    <p
                        class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                        {{ $user->email }}</p>
                </div>
                {{-- Celular --}}
                <div>
                    <x-input-label :value="__('Celular: (*)')" />
                    <p
                        class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                        {{ $user->person->phone }}</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
                {{-- Num. RUC --}}
                <div>
                    <x-input-label :value="__('RUC: (*)')" />
                    <p
                        class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                        {{ $legalPerson ? $legalPerson->ruc : '-' }}</p>
                </div>
                {{-- Razón social --}}
                <div class="lg:col-span-2 ">
                    <x-input-label :value="__('Razón social: (*)')" />
                    <p
                        class="block mt-1 w-full border-2 border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md p-2">
                        {{ $legalPerson ? $legalPerson->company_name : '-' }}</p>
                </div>
            </div>
        </div>
    @else
        <div x-data="{ identityTypeId: $wire.entangle('applicant.identityTypeId') }" class="p-3">
            {{-- Campo de búsqueda --}}
            <div class="mx-4 mb-5">
                <div class="flex relative">
                    <select wire:model="searchBy" id="searchBy" title="Buscar por..."
                        class="w-full sm:w-auto max-w-24 sm:max-w-full text-sm truncate pl-5 rounded-l-full bg-gray-50 dark:bg-slate-900 border-gray-500 dark:border-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        @foreach ($identityTypes as $identityType)
                            <option value="{{ $identityType->id }}">{{ $identityType->name }}</option>
                        @endforeach
                    </select>
                    <input wire:model="search" id="search" type="search"
                        class="flex pl-5 w-full rounded-r-full bg-white dark:bg-slate-900 border-gray-500 dark:border-gray-600 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                        placeholder="Buscar..." />
                    <button wire:loading.class="opacity-50" wire:loading.attr="disabled" wire:click="searchApplicant"
                        type="button"
                        class="absolute inset-y-0 right-0 flex items-center px-3 rounded-r-full border bg-gray-50 dark:bg-slate-900 border-gray-500 dark:border-gray-600">
                        <span wire:loading.class="hidden" wire:target="searchApplicant">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                stroke-linecap="round" stroke-linejoin="round" class="h-5" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <span wire:loading wire:target="searchApplicant" class="animate-spin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z" />
                                <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" />
                            </svg>
                        </span>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('search')" class="mt-2" />
            </div>

            <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
                {{-- Tipo de identificación --}}
                <div>
                    <x-input-label for="identityTypeId" :value="__('Tipo de documento de identidad: (*)')" />
                    <x-select wire:model="applicant.identityTypeId" x-model="identityTypeId" id="identityTypeId"
                        class="block mt-1 w-full">
                        <option value="" selected disabled>Seleccione...</option>
                        @foreach ($identityTypes as $identityType)
                            <option value="{{ $identityType->id }}">{{ $identityType->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('applicant.identityTypeId')" class="mt-2" />
                </div>
                {{-- Num. Identificación --}}
                <div>
                    <x-input-label for="identityNumber" :value="__('Num. Identificación: (*)')" />
                    <x-number-input model="applicant.identityNumber" id="identityNumber" class="block mt-1 w-full"
                        type="text" placeholder="Número de identificación" maxlength="12"/>
                    <x-input-error :messages="$errors->get('applicant.identityNumber')" class="mt-2" />
                </div>
            </div>
            <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
                {{-- Apellido paterno --}}
                <div>
                    <x-input-label for="lastName" :value="__('Apellido paterno: (*)')" />
                    <x-text-input wire:model="applicant.lastName" id="lastName" class="block mt-1 w-full" type="text"
                        placeholder="Apellido paterno" maxlength="9" />
                    <x-input-error :messages="$errors->get('applicant.lastName')" class="mt-2" />
                </div>
                {{-- Apellido materno --}}
                <div>
                    <x-input-label for="secondLastName" :value="__('Apellido materno: (*)')" />
                    <x-text-input wire:model="applicant.secondLastName" id="secondLastName" class="block mt-1 w-full"
                        type="text" placeholder="Apellido materno" maxlength="9" />
                    <x-input-error :messages="$errors->get('applicant.secondLastName')" class="mt-2" />
                </div>
                {{-- Nombre --}}
                <div>
                    <x-input-label for="name" :value="__('Nombre(s): (*)')" />
                    <x-text-input wire:model="applicant.name" id="name" class="block mt-1 w-full" type="text"
                        placeholder="Nombre(s)" />
                    <x-input-error :messages="$errors->get('applicant.name')" class="mt-2" />
                </div>
            </div>
            <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
                {{-- Email --}}
                <div>
                    <x-input-label for="email" :value="__('Email: (*)')" />
                    <x-text-input wire:model="applicant.email" id="email" class="block mt-1 w-full" type="email"
                        placeholder="Correo electrónico de contacto" />
                    <x-input-error :messages="$errors->get('applicant.email')" class="mt-2" />
                </div>
                {{-- Celular --}}
                <div>
                    <x-input-label for="phone" :value="__('Celular: (*)')" />
                    <x-number-input model="applicant.phone" id="phone" class="block mt-1 w-full" type="text"
                        placeholder="Celular de contacto" maxlength="9" />

                    <x-input-error :messages="$errors->get('applicant.phone')" class="mt-2" />
                </div>
                {{-- Dirección --}}
                <div>
                    <x-input-label for="address" :value="__('Dirección: (*)')" />
                    <x-text-input wire:model="applicant.address" id="address" class="block mt-1 w-full" type="text"
                        placeholder="Dirección" maxlength="9" />
                    <x-input-error :messages="$errors->get('applicant.address')" class="mt-2" />
                </div>
            </div>

            {{-- Identidad persona jurídica --}}
            <template x-if="identityTypeId == 2 || identityTypeId === 'RUC'">
                <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 10)" x-show="show" x-transition
                    class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
                    {{-- Num. RUC --}}
                    <div>
                        <x-input-label for="ruc" :value="__('RUC: (*)')" />
                        <x-number-input model="applicant.ruc" id="ruc" class="block mt-1 w-full" type="text"
                            placeholder="RUC" maxlength="11" />
                        <x-input-error :messages="$errors->get('applicant.ruc')" class="mt-2" />
                    </div>
                    {{-- Razón social --}}
                    <div class="lg:col-span-2 ">
                        <x-input-label for="companyName" :value="__('Razón social: (*)')" />
                        <x-text-input wire:model="applicant.companyName" id="companyName" class="block mt-1 w-full"
                            type="text" placeholder="Razón social" />
                        <x-input-error :messages="$errors->get('applicant.companyName')" class="mt-2" />
                    </div>
                </div>
            </template>
        </div>
    @endauth
</div>
