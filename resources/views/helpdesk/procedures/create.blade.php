@extends('layouts.helpdesk-dashboard')

@section('title', 'Registro de Trámites')

@section('header')
    <div class="text-center text-gray-800 dark:text-gray-200">
        <h1 class="text-3xl font-bold">Formulario de registro de trámites</h1>
        <p class="font-light">Complete el siguiente formulario para registrar un nuevo trámite.</p>
    </div>
@endsection

@section('content')
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @livewire('helpdesk.procedures.create')
                </div>
            </div>
        </div>
    </div>
@endsection
