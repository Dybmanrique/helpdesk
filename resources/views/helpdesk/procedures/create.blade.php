@extends('layouts.helpdesk-dashboard')

@section('title', 'Registro de Trámites')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Formulario de registro de trámite
    </h2>
@endsection

@section('content')
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('tramites.store') }}">
                        @csrf
                        <h3 class="font-bold">Información del solicitante</h3>
                        <div class="grid lg:grid-cols-2 gap-2 mt-3">
                            {{-- Tipo de identificación --}}
                            <div>
                                <x-input-label for="identity_type_id" :value="__('Tipo de documento de identidad')" />
                                <x-select id="identity_type_id" class="block mt-1 w-full" name="identity_type_id"
                                    :value="old('identity_type_id')" required disabled>
                                    <option value="">Seleccione...</option>
                                    @foreach ($identity_types as $identity_type)
                                        <option value="{{ $identity_type->id }}"
                                            {{ $user->person->identity_type_id == $identity_type->id ? 'selected' : '' }}>
                                            {{ $identity_type->name }}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error :messages="$errors->get('identity_type_id')" class="mt-2" />
                            </div>
                            {{-- Num. Identificación --}}
                            <div>
                                <x-input-label for="identity_number" :value="__('Num. Identificación')" />
                                <x-number-input id="identity_number" class="block mt-1 w-full" type="text"
                                    name="identity_number" :value="old('identity_number', $identity_number)" placeholder="Número de identificación" required
                                    disabled />
                                <x-input-error :messages="$errors->get('identity_number')" class="mt-2" />
                            </div>
                        </div>
                        @if ($user->person->identity_type->name === 'RUC')
                            {{-- Identidad persona jurídica --}}
                            <div class="mt-3">
                                {{-- Razón social --}}
                                <div>
                                    <x-input-label for="company_name" :value="__('Razón social')" />
                                    <x-text-input id="company_name" class="block mt-1 w-full" type="text"
                                        name="company_name" :value="old('company_name', $user->person->legal_person->company_name)" placeholder="Razón social" required
                                        disabled />
                                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                                </div>
                            </div>
                            {{-- Representante legal --}}
                            <h4 class="mt-3 text-sm font-bold">Datos Representante Legal</h4>
                            <div class="grid lg:grid-cols-3 gap-2 mt-3">
                                {{-- Nombre --}}
                                <div>
                                    <x-input-label for="name" :value="__('Nombre')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                        :value="old('name', $user->person->name)" placeholder="Nombre" required disabled />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                {{-- Apellido paterno --}}
                                <div>
                                    <x-input-label for="last_name" :value="__('Apellido paterno')" />
                                    <x-number-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                        :value="old('last_name', $user->person->last_name)" placeholder="Apellido paterno" required maxlength="9"
                                        disabled />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                                {{-- Apellido materno --}}
                                <div>
                                    <x-input-label for="second_last_name" :value="__('Apellido materno')" />
                                    <x-number-input id="second_last_name" class="block mt-1 w-full" type="text"
                                        name="second_last_name" :value="old('second_last_name', $user->person->second_last_name)" placeholder="Apellido materno" required
                                        maxlength="9" disabled />
                                    <x-input-error :messages="$errors->get('second_last_name')" class="mt-2" />
                                </div>
                            </div>
                        @else
                            {{-- Identidad persona natural --}}
                            <div class="grid lg:grid-cols-3 gap-2 mt-3">
                                {{-- Nombre --}}
                                <div>
                                    <x-input-label for="name" :value="__('Nombre')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                        :value="old('name', $user->person->name)" placeholder="Nombre" required disabled />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                {{-- Apellido paterno --}}
                                <div>
                                    <x-input-label for="last_name" :value="__('Apellido paterno')" />
                                    <x-number-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                        :value="old('last_name', $user->person->last_name)" placeholder="Apellido paterno" required maxlength="9"
                                        disabled />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                                {{-- Apellido materno --}}
                                <div>
                                    <x-input-label for="second_last_name" :value="__('Apellido materno')" />
                                    <x-number-input id="second_last_name" class="block mt-1 w-full" type="text"
                                        name="second_last_name" :value="old('second_last_name', $user->person->second_last_name)" placeholder="Apellido materno" required
                                        maxlength="9" disabled />
                                    <x-input-error :messages="$errors->get('second_last_name')" class="mt-2" />
                                </div>
                            </div>
                        @endif

                        <div class="grid lg:grid-cols-2 gap-2 mt-3">
                            {{-- Email --}}
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                    :value="old('email', $user->email)" placeholder="Correo electrónico de contacto" required disabled />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            {{-- Celular --}}
                            <div>
                                <x-input-label for="phone" :value="__('Celular')" />
                                <x-number-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                    :value="old('phone', $user->person->phone)" placeholder="Celular de contacto" required maxlength="9" disabled />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                        </div>
                        <h3 class="mt-6 font-bold">Descripción de la solicitud o trámite</h3>
                        <div class="grid lg:grid-cols-3 gap-2 mt-3">
                            {{-- Categoría de trámite --}}
                            <div>
                                <x-input-label for="procedure_category_id" :value="__('Categoría')" />
                                <x-select id="procedure_category_id" class="block mt-1 w-full" name="procedure_category_id"
                                    :value="old('procedure_category_id')" required>
                                    <option value="">Seleccione...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error :messages="$errors->get('procedure_category_id')" class="mt-2" />
                            </div>
                            {{-- Prioridad de trámite --}}
                            <div>
                                <x-input-label for="procedure_priority_id" :value="__('Prioridad')" />
                                <x-select id="procedure_priority_id" class="block mt-1 w-full"
                                    name="procedure_priority_id" :value="old('procedure_priority_id')" required>
                                    <option value="">Seleccione...</option>
                                    @foreach ($priorities as $priority)
                                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error :messages="$errors->get('procedure_priority_id')" class="mt-2" />
                            </div>
                            {{-- Tipo de documento de trámite --}}
                            <div>
                                <x-input-label for="document_type_id" :value="__('Tipo de documento de trámite')" />
                                <x-select id="document_type_id" class="block mt-1 w-full" name="document_type_id"
                                    :value="old('document_type_id')" required>
                                    <option value="">Seleccione...</option>
                                    @foreach ($document_types as $document_type)
                                        <option value="{{ $document_type->id }}">{{ $document_type->name }}</option>
                                    @endforeach
                                </x-select>
                                <x-input-error :messages="$errors->get('document_type_id')" class="mt-2" />
                            </div>
                        </div>
                        {{-- Asunto --}}
                        <div class="mt-3">
                            <x-input-label for="reason" :value="__('Asunto')" />
                            <x-text-input id="reason" class="block mt-1 w-full" type="text" name="reason"
                                :value="old('reason')"
                                placeholder="Registre en forma clara el asunto por el cual ingresa el documento o nombre del procedimiento."
                                required />
                            <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                        </div>
                        {{-- Descripción --}}
                        <div class="mt-3">
                            <x-input-label for="description" :value="__('Descripción')" />
                            <x-textarea id="description" class="block mt-1 w-full" type="text" name="description"
                                :value="old('description')" rows="3"
                                placeholder="Ingrese en forma detallada el contenido de su solicitud, procedimiento o trámite."
                                required />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>


                        <h3 class="mt-6 font-bold">Archivos a adjuntar</h3>
                        {{-- Archivos a adjuntar --}}
                        <div class="mt-3">
                            <x-input-label for="files" :value="__('Archivo')" />
                            <x-text-input id="files" class="block mt-1 w-full" type="file" name="files"
                                :value="old('files')" required />
                            <x-input-error :messages="$errors->get('files')" class="mt-2" />
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Enviar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
