@extends('layouts.dashboard')

@section('title', 'Dashboard Home')

@section('content')
    <div>
        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form id="formModal">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">REGISTRAR TIPO RESOLUCIÓN</h5>
                            <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="w-100 d-none" id="loaderModal">
                                <x-admin.spinner />
                            </div>
                            <div>
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre (*):</label>
                                    <input type="text" class="form-control" name='name' id="name" required
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        @if (auth()->user()->can('Tipos de Resolución: Crear') || auth()->user()->can('Tipos de Resolución: Actualizar'))
                            <div class="modal-footer">
                                <button type="submit" id="buttonSubmitModal" class="btn btn-primary fw-bold"><i
                                        class="fa-solid fa-floppy-disk"></i> GUARDAR</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <h2>TIPOS DE RESOLUCIÓN</h2>
        <div class="card">
            @can('Tipos de Resolución: Crear')
                <div class="card-header">
                    <button id="btnAdd" type="button" class="btn btn-primary fw-bold" data-coreui-toggle="modal"
                        data-coreui-target="#modal">
                        <i class="fa-solid fa-circle-plus"></i> AGREGAR
                    </button>
                </div>
            @endcan
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-md table-striped w-100 my-2 border-top" id="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOMBRE</th>
                                @if (auth()->user()->can('Tipos de Resolución: Actualizar') || auth()->user()->can('Tipos de Resolución: Eliminar'))
                                    <th>ACCIONES</th>
                                @endif
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
    <script type="module" src="{{ asset('js/admin/resolution-types/crud.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
