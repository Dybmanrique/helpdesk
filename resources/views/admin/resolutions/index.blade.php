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
                            <h5 class="modal-title" id="modalTitle">REGISTRAR RESOLUCIÓN</h5>
                            <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="w-100 d-none" id="loaderModal">
                                <x-admin.spinner />
                            </div>
                            <div>
                                <div class="mb-3">
                                    <label for="resolution_type_id" class="form-label">Tipo de resolución (*):</label>
                                    <select name="resolution_type_id" id="resolution_type_id" class="form-select" required>
                                        <option value="" class="d-none">-Seleccione-</option>
                                        @foreach ($resolution_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('resolution_type_id')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="resolution_state_id" class="form-label">Estado de resolución (*):</label>
                                    <select name="resolution_state_id" id="resolution_state_id" class="form-select"
                                        required>
                                        <option value="" class="d-none">-Seleccione-</option>
                                        @foreach ($resolution_states as $state)
                                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('resolution_state_id')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="file" class="form-label">Adjunto (*):</label>
                                    <input type="file" class="form-control" name='file' id="file" required
                                        autocomplete="off">
                                    @error('file')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 d-none" id="fileUpload">
                                    Archivo subido:
                                    <a id="uploadedFileLink" target="_blank" class="d-none" href="#">
                                        Nombre archivo
                                    </a>
                                </div>
                                <div class="mb-3">
                                    <label for="resolution_number" class="form-label">Número de resolución (*):</label>
                                    <input type="text" class="form-control" name='resolution_number'
                                        id="resolution_number" required autocomplete="off">
                                    @error('resolution_number')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Asunto/Descripción (*):</label>
                                    <textarea name='description' id="description" required class="form-control" rows="6"></textarea>
                                    @error('description')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if (auth()->user()->can('Resoluciones: Crear') || auth()->user()->can('Resoluciones: Actualizar'))
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary fw-bold"><i
                                        class="fa-solid fa-floppy-disk"></i>
                                    GUARDAR</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <h2>RESOLUCIONES</h2>
        <div class="card">
            @can('Resoluciones: Crear')
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
                                <th>NÚMERO</th>
                                <th>ASUNTO/DESCRIPCIÓN</th>
                                @if (auth()->user()->can('Resoluciones: Actualizar') || auth()->user()->can('Resoluciones: Eliminar'))
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
    <script src="{{ asset('js/admin/resolutions/crud.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
