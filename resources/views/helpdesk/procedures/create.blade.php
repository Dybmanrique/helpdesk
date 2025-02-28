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
                    @livewire('helpdesk.procedures.create')
                </div>
            </div>
        </div>
    </div>
@endsection
