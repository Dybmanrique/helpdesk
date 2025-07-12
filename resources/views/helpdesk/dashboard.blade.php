@extends('layouts.helpdesk-dashboard')

@section('title', 'Mesa de Partes Virtual')

@section('header')
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Panel de control</h1>
    <p class="font-light text-gray-800 dark:text-gray-200">Visualice fácilmente el histórico y la información de sus trámites
        registrados.</p>
@endsection

@section('content')
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('helpdesk.dashboard')
        </div>
    </div>
@endsection
