@extends('layouts.dashboard')

@section('title', 'Dashboard Home')

@section('content')
    {{-- @livewire('admin.procedures-office.crud') --}}
    <div>
        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">ADMINISTRAR TRÁMITE</h5>
                            <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="w-100 d-none" id="modalLoader">
                                <x-admin.spinner />
                            </div>
                            <div id="modalContent">
                                <div class="row">
                                    
                                    <div class="col-md-4">
                                        <div class="rounded border shadow-sm p-3">
                                            <h6>DATOS DEL TRÁMITE</h6>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>N° Expediente</td>
                                                            <td class="fw-light">
                                                                <div class="d-flex gap-1">
                                                                    <input type="text" class="form-control px-2" placeholder="N° expediente" id="expedientNumber">
                                                                    <button class="btn btn-outline-secondary" type="button" id="generateExpedientNumber" title="Generar automáticamente">
                                                                        <i class="fa-solid fa-arrows-rotate"></i>
                                                                    </button>
                                                                  </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ticket</td>
                                                            <td id="ticketModal" class="fw-light"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Asunto</td>
                                                            <td id="reasonModal" class="fw-light"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Solicitante</td>
                                                            <td id="personModal" class="fw-light"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Contacto</td>
                                                            <td class="fw-light">
                                                                <p class="w-100 mb-1"><i class="fa-solid fa-phone"></i> <span id="personPhoneModal"></span></p>
                                                                <p class="w-100 mb-1"><i class="fa-solid fa-envelope"></i> <span id="personEmailModal"></span></p>
                                                                
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Adjunto</td>
                                                            <td class="fw-light">
                                                                <ol id="filesModal" class="ps-3 mb-2">
                                                                    <li><a target="_blank" href="#">Name</a></li>
                                                                </ol>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Estado</td>
                                                            <td id="stateModal" class="fw-light"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Categoría</td>
                                                            <td id="categoryModal" class="fw-light"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tipo documento</td>
                                                            <td id="documentTypeModal" class="fw-light"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Prioridad</td>
                                                            <td id="priorityModal" class="fw-light"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Descripción</td>
                                                            <td id="descriptionModal" class="fw-light"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="rounded border shadow-sm p-3">
                                            <h6>HISTORIAL</h6>
                                            
                                            <div id="timelineModal" class="timeline mb-1" style="max-height: 50vh; overflow-y: auto;">

                                                    <div>
                                                        <i class="fas bg-blue"></i>
                                                        <div class="timeline-item">
                                                            <div class="timeline-header">
                                                                <div class="d-flex justify-content-between">
                                                                    <div>
                                                                        <span class="time text-sm text-muted text-nowrap"><i
                                                                                class="fas fa-calendar"></i> </span>
                                                                        <span class="time text-sm text-muted text-nowrap ms-2"><i
                                                                                class="fas fa-clock"></i> </span>
                                                                    </div>
                                                                    <div>
                                                                        {{-- <a class="text-primary"><i class="fas fa-edit"></i></a> --}}
                                                                        {{-- <button class="btn m-0 p-0 text-danger"><i class="fas fa-times"></i></button> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="timeline-body">
                                                                <span class="fw-bold d-inline-block mb-2"></span>
                                                                    <div style="white-space: pre-line"></div>
                                                                
                                                                    <br>
                                                                    <span>Archivos Adjuntos: </span>
                                                                    <ol class="ps-3 mb-2">
                                                                        <li><a target="_blank" href=""></a></li>
                                                                    </ol>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <form id="formSave">
                                            <div class="shadow-sm rounded border p-3">
                                                <h6>ACCIONES</h6>
                                                <div class="form-group">
                                                    <label for="actions_select" class="form-label">Seleccione una acción:</label>
                                                    <select id="actions_select" class="form-select" required>
                                                        {{-- 'visualizar', 'comentar', 'derivar', 'concluir', 'anular', 'archivar' --}}
                                                        <option value="" class="d-none">Seleccione</option>
                                                        <option value="derivar">Derivar</option>
                                                        <option value="comentar">Comentar</option>
                                                        <option value="concluir">Concluir</option>
                                                        <option value="anular">Anular</option>
                                                        <option value="archivar">Archivar</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div id="actions_container" class="mt-2 shadow-sm border rounded p-3 d-none">
                                                <div id="container_derivation" class="d-none">
                                                    <div class="form-group mt-2">
                                                        <label for="office_id" class="form-label">Oficina a derivar:</label>
                                                        <select id="office_id" class="form-select">
                                                            <option value="" class="d-none">Seleccione</option>
                                                            @foreach ($offices as $office)
                                                                <option value="{{$office->id}}">{{$office->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="user_id" class="form-label">Encargado:</label>
                                                        <select id="user_id" class="form-select">
                                                            <option value="" class="d-none">Seleccione</option>
                                                        </select>
                                                        <div class="w-100 border rounded p-1 d-none" id="usersLoader">
                                                            <x-admin.spinner />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="comment" class="form-label">Comentario:</label>
                                                    <textarea id="comment" class="form-control" placeholder="Puede agregar un comentario" rows="4"></textarea>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="file" class="form-label">Adjuntar archivo:</label>
                                                    <input type="file" id="file" class="form-control">
                                                </div>
                                                <button type="button" id="btnSave" class="btn btn-primary fw-bold mt-4 w-100"><i class="fa-solid fa-floppy-disk"></i>
                                                    ACEPTAR</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    
        <h2>TRÁMITES DE MI OFICINA - {{ strtoupper(auth()->user()->office->name) }}</h2>
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
                                <th>CORREO</th>
                                <th>CELULAR</th>
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
    <link rel="stylesheet" href="{{asset('css/admin/proceduresOffice.css')}}">
@endsection

@section('js')
    <script type="module" src="{{ asset('js/admin/procedures-office/crud.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
