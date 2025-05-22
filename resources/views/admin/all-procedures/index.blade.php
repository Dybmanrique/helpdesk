@extends('layouts.dashboard')

@section('title', 'Dashboard Home')

@section('content')
    {{-- @livewire('admin.procedures-office.crud') --}}
    <div>
        <h2>TODOS LOS TRÁMITES</h2>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-md table-striped w-100 my-2 border-top" id="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>N. EXPEDIENTE</th>
                                <th>ASUNTO</th>
                                <th>SOLICITANTE</th>
                                <th>IDENTIFICACIÓN</th>
                                <th>T. DOCUMENTO</th>
                                <th>CATEGORÍA</th>
                                <th>PRIORIDAD</th>
                                <th>ESTADO</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    
@endsection

@section('js')
    <script type="module" src="{{ asset('js/admin/all-procedures/crud.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
