<div>
    <div x-data="{ isJuridical: $wire.entangle('applicant.isJuridical') }" class="p-3">
        {{-- Tipo de solicitante --}}
        <div class="mt-3 space-y-2">
            <x-input-label for="applicantType" :value="__('Tipo de solicitante: (*)')" />
            <div class="flex items-center gap-1">
                <input wire:model="applicant.isJuridical" x-model="isJuridical" type="radio" value="0" id="person"
                    class="cursor-pointer text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                <label for="person" class="cursor-pointer">Persona Natural</label>
            </div>
            <div class="flex items-center gap-1">
                <input wire:model="applicant.isJuridical" x-model="isJuridical" type="radio" value="1"
                    id="legalPerson"
                    class="cursor-pointer text-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                <label for="legalPerson" class="cursor-pointer">Persona Jurídica</label>
            </div>
            <x-input-error :messages="$errors->get('applicant.isJuridical')" class="mt-2" />
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Tipo de identificación --}}
            <div>
                <x-input-label for="identityTypeId" :value="__('Tipo de documento de identidad: (*)')" />
                <x-select wire:model="applicant.identityTypeId" id="identityTypeId"
                    class="block mt-1 w-full cursor-pointer">
                    <option value="" class="hidden" selected disabled>Seleccione...</option>
                    @foreach ($identityTypes as $identityType)
                        <option value="{{ $identityType->id }}">{{ $identityType->name }}</option>
                    @endforeach
                </x-select>
                <x-input-error :messages="$errors->get('applicant.identityTypeId')" class="mt-2" />
            </div>
            {{-- Num. Identificación --}}
            <div>
                <x-input-label for="identityNumber" :value="__('Num. Identificación: (*)')" />
                <div class="w-full flex grow items-center justify-center mt-1 gap-1">
                    <x-number-input wire:keydown.enter="searchPerson" model="applicant.identityNumber"
                        id="identityNumber" class="w-full" type="text" placeholder="Número de identificación"
                        maxlength="12" />
                    {{-- Botón de búsqueda por Num. Identificación --}}
                    <x-primary-button wire:loading.class="opacity-50" wire:loading.attr="disabled"
                        wire:click="searchPerson" type="button" class="border border-gray-300 dark:border-gray-700"
                        title="Buscar persona natural">
                        <span wire:loading.class="hidden" wire:target="searchPerson">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                stroke-linecap="round" stroke-linejoin="round" fill="none" stroke="currentColor"
                                stroke-width="2" class="h-6">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </span>
                        <span wire:loading wire:target="searchPerson" class="animate-spin">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z" />
                                <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" />
                            </svg>
                        </span>
                    </x-primary-button>
                </div>
                <x-input-error :messages="$errors->get('applicant.identityNumber')" class="mt-2" />
            </div>
        </div>

        <div class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
            {{-- Apellido paterno --}}
            <div>
                <x-input-label for="lastName" :value="__('Apellido paterno: (*)')" />
                <x-text-input wire:model="applicant.lastName" id="lastName" class="block mt-1 w-full" type="text"
                    placeholder="Apellido paterno" />
                <x-input-error :messages="$errors->get('applicant.lastName')" class="mt-2" />
            </div>
            {{-- Apellido materno --}}
            <div>
                <x-input-label for="secondLastName" :value="__('Apellido materno: (*)')" />
                <x-text-input wire:model="applicant.secondLastName" id="secondLastName" class="block mt-1 w-full"
                    type="text" placeholder="Apellido materno" />
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
                    placeholder="Correo electrónico de contacto" autocomplete="off" />
                <x-input-error :messages="$errors->get('applicant.email')" class="mt-2" />
            </div>
            {{-- Celular --}}
            <div>
                <x-input-label for="phone" :value="__('Celular: (*)')" />
                <x-number-input model="applicant.phone" id="phone" class="block mt-1 w-full" type="text"
                    placeholder="Celular de contacto" maxlength="9" autocomplete="off" />
                <x-input-error :messages="$errors->get('applicant.phone')" class="mt-2" />
            </div>
            {{-- Dirección --}}
            <div>
                <x-input-label for="address" :value="__('Dirección: (*)')" />
                <x-text-input wire:model="applicant.address" id="address" class="block mt-1 w-full" type="text"
                    placeholder="Dirección" autocomplete="off" />
                <x-input-error :messages="$errors->get('applicant.address')" class="mt-2" />
            </div>
        </div>

        {{-- Identidad persona jurídica --}}
        <template x-if="isJuridical === '1'">
            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 10)" x-show="show" x-transition
                class="grid lg:grid-cols-3 sm:grid-cols-2 gap-2 mt-3">
                {{-- Num. RUC --}}
                <div>
                    <x-input-label for="ruc" :value="__('RUC: (*)')" />
                    <div class="w-full flex grow items-center justify-center mt-1 gap-1">
                        <x-number-input wire:keydown.enter="searchLegalPerson" model="applicant.ruc" id="ruc"
                            class="w-full" type="text" placeholder="RUC" maxlength="11" />
                        {{-- Botón de búsqueda por RUC --}}
                        <x-primary-button wire:loading.class="opacity-50" wire:loading.attr="disabled"
                            wire:click="searchLegalPerson" type="button"
                            class="border border-gray-300 dark:border-gray-500" title="Buscar persona jurídica">
                            <span wire:loading.class="hidden" wire:target="searchLegalPerson">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"
                                    fill="none" stroke="currentColor" stroke-width="2" class="h-6">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.3-4.3" />
                                </svg>
                            </span>
                            <span wire:loading wire:target="searchLegalPerson" class="animate-spin">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 22C17.5228 22 22 17.5228 22 12H19C19 15.866 15.866 19 12 19V22Z" />
                                    <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" />
                                </svg>
                            </span>
                        </x-primary-button>
                    </div>
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
</div>
