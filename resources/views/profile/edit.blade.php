@extends('layouts.helpdesk-dashboard')

@section('title', 'Perfil de Usuario')

@section('header')
    <div class="text-gray-800 dark:text-gray-200">
        <h1 class="text-3xl font-bold">Perfil de Usuario</h1>
        <p class="font-light">Administra tu perfil de usuario.</p>
    </div>
@endsection

@section('content')
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @can('Perfil de Usuario: Desactivar cuenta')
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.deactivate-user-form')
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endsection
