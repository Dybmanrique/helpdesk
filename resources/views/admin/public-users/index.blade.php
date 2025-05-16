@extends('layouts.dashboard')

@section('title', 'Dashboard Home')

@section('content')
    <div>
        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form id="formModal">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">REGISTRAR USUARIO</h5>
                            <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="rounded border p-3 mb-2">
                                        <div class="mb-3">
                                            <label for="identity_type_id" class="form-label">Tipo de identificación
                                                (*):</label>
                                            <select name="identity_type_id" id="identity_type_id" class="form-select"
                                                required>
                                                <option value="" class="d-none">-Seleccione-</option>
                                                @foreach ($identity_types as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="identity_number" class="form-label">N° de identificación
                                                (*):</label>
                                            <input type="text" class="form-control" name='identity_number'
                                                id="identity_number" required autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombres (*):</label>
                                            <input type="text" class="form-control" name='name' id="name"
                                                required autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Apellido paterno (*):</label>
                                            <input type="text" class="form-control" name='last_name' id="last_name"
                                                required autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="second_last_name" class="form-label">Apellido materno (*):</label>
                                            <input type="text" class="form-control" name='second_last_name'
                                                id="second_last_name" required autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Celular (*):</label>
                                            <input type="text" class="form-control" name='phone' id="phone"
                                                required autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Dirección (*):</label>
                                            <input type="text" class="form-control" name='address' id="address"
                                                required autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="rounded border p-3">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email (*):</label>
                                            <input type="email" class="form-control" name='email' id="email"
                                                required autocomplete="off">
                                        </div>
                                        <div id="passwordContainer">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label for="password" class="form-label">Contraseña (*):</label>
                                                    <button id="buttonGeneratePassword" type="button" class="btn btn-sm btn-outline-info mb-1"><i class="fa-solid fa-rotate"></i> Generar</button>
                                                </div>
                                                <input type="password" class="form-control" name='password'
                                                    id="password" required autocomplete="off">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">Confirmar contraseña
                                                    (*):</label>
                                                <input type="password" class="form-control" name='password_confirmation'
                                                    id="password_confirmation" required autocomplete="off">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="buttonSubmitModal" class="btn btn-primary fw-bold"><i
                                    class="fa-solid fa-floppy-disk"></i> GUARDAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <h2>USUARIOS PÚBLICOS</h2>
        <div class="card">
            <div class="card-header">
                <button id="btnAdd" type="button" class="btn btn-primary fw-bold" data-coreui-toggle="modal"
                    data-coreui-target="#modal">
                    <i class="fa-solid fa-circle-plus"></i> AGREGAR
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-md table-striped w-100 my-2 border-top" id="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>IDENTIFICACIÓN</th>
                                <th>NOMBRE</th>
                                <th>CORREO</th>
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
    <script type="module" src="{{ asset('js/admin/public-users/crud.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
