@extends('layouts.dashboard')

@section('title', 'Dashboard Home')

@section('content')
    {{-- @livewire('admin.procedures-office.crud') --}}
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">ADMINISTRAR TRÁMITE</h5>
                    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="w-100 d-none" id="modalLoader">
                        <x-admin.spinner />
                    </div>
                    <div id="modalContent">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="rounded border shadow-sm p-3">
                                    <h6>DATOS DEL TRÁMITE</h6>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>N° Expediente</td>
                                                    <td id="expedientNumber" class="fw-light"></td>
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
                                                        <p class="w-100 mb-1"><i class="fa-solid fa-phone"></i> <span
                                                                id="personPhoneModal"></span></p>
                                                        <p class="w-100 mb-1"><i class="fa-solid fa-envelope"></i> <span
                                                                id="personEmailModal"></span></p>

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
                            <div class="col-md-6">
                                <div class="rounded border shadow-sm p-3">
                                    <h6>HISTORIAL</h6>

                                    <div id="timelineModal" class="timeline mb-1"
                                        style="max-height: 50vh; overflow-y: auto;">

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                @if (auth()->user()->can('Todos los Trámites: Administrar'))
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
    <link rel="stylesheet" href="{{ asset('css/admin/allProcedures.css') }}">
@endsection

@section('js')
    <script type="module" src="{{ asset('js/admin/all-procedures/crud.js') }}?v={{ env('APP_VERSION') }}"></script>
@endsection
