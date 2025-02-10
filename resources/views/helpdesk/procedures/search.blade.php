@extends('layouts.helpdesk-dashboard')

@section('title', 'Seguimiento de Trámites')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Consulta de trámites presentados
    </h2>
@endsection

@section('content')
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="">
                        @csrf
                        <div class="grid lg:grid-cols-2">
                            {{-- Número del ticket del trámite --}}
                            <div class="">
                                <x-input-label for="ticket" :value="__('Número de Trámite')" />
                                <x-number-input id="ticket" class="block mt-1 w-full" type="text" name="ticket"
                                    :value="old('ticket')" placeholder="Ingrese el número de trámite" required />
                                <x-input-error :messages="$errors->get('ticket')" class="mt-2" />
                            </div>
                            <div class="flex items-center justify-end mt-3">
                                <x-primary-button>
                                    {{ __('Consultar') }}
                                </x-primary-button>
                                <x-secondary-button class="ms-4">
                                    {{ __('Cancelar') }}
                                </x-secondary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
