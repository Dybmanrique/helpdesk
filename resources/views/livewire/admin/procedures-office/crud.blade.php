<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle" wire:ignore>ADMINISTRAR TRÁMITE</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div wire:loading wire:target.except="save,actions_select,office_id,setExpedientNumber,file" class="w-100">
                            <x-admin.spinner />
                        </div>
                        <div wire:loading.remove wire:target.except="save,actions_select,office_id,setExpedientNumber,file">
                            <div class="row">
                                @if ($derivation)
                                <div class="col-md-4">
                                    <div class="rounded border shadow-sm p-3">
                                        <h6>DATOS DEL TRÁMITE</h6>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td>N° Expediente</td>
                                                        <td class="fw-light">
                                                            <div class="input-group mb-3">
                                                                <input wire:model='expedient_number' type="text" class="form-control" placeholder="N° expediente" aria-label="N° expediente" aria-describedby="n_expedient">
                                                                <button class="btn btn-outline-secondary" wire:click='setExpedientNumber' type="button" id="n_expedient" title="Generar automáticamente">
                                                                    <i class="fa-solid fa-arrows-rotate"></i>
                                                                </button>
                                                              </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ticket</td>
                                                        <td class="fw-light">{{ $derivation->procedure->ticket ?? 'No tiene' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Asunto</td>
                                                        <td class="fw-light">{{ $derivation->procedure->reason ?? 'No tiene' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Solicitante</td>
                                                        <td class="fw-light">
                                                            @if ($derivation->procedure->user)
                                                                {{$derivation->procedure->user->person->last_name }} {{ $derivation->procedure->user->person->second_last_name }} {{$derivation->procedure->user->person->name}}
                                                            @else
                                                                No tiene
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Adjunto</td>
                                                        <td class="fw-light">
                                                            <ol class="ps-3 mb-2">
                                                                @foreach ($derivation->procedure->files as $file)
                                                                    <li><a target="_blank" href="{{ route('file_view.view', $file->id) }}">{{$file->name}}</a></li>
                                                                @endforeach
                                                            </ol>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="rounded border shadow-sm p-3">
                                        <h6>HISTORIAL</h6>
                                        
                                        <div class="timeline mb-1" style="max-height: 50vh; overflow-y: auto;">
                                            @forelse ($derivation->procedure->actions as $action)
                                                <div>
                                                    <i class="fas bg-blue"></i>
                                                    <div class="timeline-item">
                                                        <div class="timeline-header">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <span class="time text-sm text-muted text-nowrap"><i
                                                                            class="fas fa-calendar"></i> {{ $action->created_at->format('d/m/Y') }}</span>
                                                                    <span class="time text-sm text-muted text-nowrap ms-2"><i
                                                                            class="fas fa-clock"></i> {{ $action->created_at->format('h:i A') }}</span>
                                                                </div>
                                                                <div>
                                                                    {{-- <a class="text-primary"><i class="fas fa-edit"></i></a> --}}
                                                                    {{-- <button class="btn m-0 p-0 text-danger"><i class="fas fa-times"></i></button> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="timeline-body">
                                                            <span class="fw-bold d-inline-block mb-2">{{ $actions_map[$action->action] }}</span>
                                                            @if ($action->comment)
                                                                <div style="white-space: pre-line">{{ $action->comment }}</div>
                                                            @endif
                                                            @if (count($action->action_files) > 0)   
                                                                <br>
                                                                <span>Archivos Adjuntos: </span>
                                                                <ol class="ps-3 mb-2">
                                                                    @foreach ($action->action_files as $file)
                                                                        <li><a target="_blank" href="{{ route('file_view.view', $file->id) }}">{{$file->name}}</a></li>
                                                                    @endforeach
                                                                </ol>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty

                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <form wire:submit='save' id="formSave">
                                        <div class="shadow-sm rounded border p-3">
                                            <h6>ACCIONES</h6>
                                            <div class="form-group">
                                                <label for="actions_select" class="form-label">Seleccione una acción:</label>
                                                <select id="actions_select" wire:model.live='actions_select' class="form-select" required>
                                                    {{-- 'visualizar', 'comentar', 'derivar', 'concluir', 'anular', 'archivar' --}}
                                                    <option value="" class="d-none">Seleccione</option>
                                                    <option value="derivar">Derivar</option>
                                                    <option value="comentar">Comentar</option>
                                                    <option value="concluir">Concluir</option>
                                                    <option value="anular">Anular</option>
                                                    <option value="archivar">Archivar</option>
                                                </select>
                                                @error('actions_select')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div wire:loading wire:target='actions_select' class="w-100 mt-2 shadow-sm border rounded p-3">
                                            <x-admin.spinner />
                                        </div>
                                        <div wire:loading.remove wire:target='actions_select' id="actions_container" class="mt-2 shadow-sm border rounded p-3">
                                            <div id="container_derivation" class="{{ ($show_derivation_section) ? '' : 'd-none' }}">
                                                <div class="form-group mt-2">
                                                    <label for="office_id" class="form-label">Oficina a derivar:</label>
                                                    <select id="office_id" wire:model.live='office_id' class="form-select">
                                                        <option value="" class="d-none">Seleccione</option>
                                                        @foreach ($offices as $office)
                                                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('office_id')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group mt-2">
                                                    <label for="user_id" class="form-label">Encargado:</label>
                                                    <select id="user_id" wire:loading.attr='disabled' wire:target='office_id' wire:model='user_id' class="form-select">
                                                        <option value="" class="d-none">Seleccione</option>
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->person->last_name }} {{ $user->person->second_last_name }} {{ $user->person->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group mt-2">
                                                <label for="comment" class="form-label">Comentario:</label>
                                                <textarea wire:model="comment" id="comment" class="form-control" placeholder="Puede agregar un comentario" rows="4"></textarea>
                                                @error('comment')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-group mt-2">
                                                <label for="file" class="form-label">Adjuntar archivo:</label>
                                                <input type="file" wire:model="file" id="file" class="form-control">
                                                @error('file')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <button type="button" id="btnSave" class="btn btn-primary fw-bold mt-4 w-100"><i class="fa-solid fa-floppy-disk"></i>
                                                ACEPTAR</button>
                                            <button type="submit" id="btnConfirm" class="d-none">boton confirmacion</button>
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
        {{-- <div class="card-header">
            <button type="button" class="btn btn-primary fw-bold" data-coreui-toggle="modal"
                data-coreui-target="#modal">
                <i class="fa-solid fa-circle-plus"></i> AGREGAR
            </button>
        </div> --}}
        <div class="card-body" wire:ignore>
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

@push('js')
    <script src="{{ asset('js/admin/procedures-office/crud.js') }}?v={{ env('APP_VERSION') }}"></script>
@endpush
