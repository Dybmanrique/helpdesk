<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <form wire:submit='save'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle" wire:ignore>REGISTRAR TRÁMITE</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div wire:loading wire:target.except="save" class="w-100">
                            <x-admin.spinner />
                        </div>
                        <div wire:loading.remove wire:target.except="save">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre (*):</label>
                                <input type="text" class="form-control" wire:model='name' id="name" required autocomplete="off">
                                @error('name')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción (*):</label>
                                <textarea wire:model='description' id="description" required class="form-control" rows="6"></textarea>
                                @error('description')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary fw-bold"><i class="fa-solid fa-floppy-disk"></i> GUARDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <h2>TRÁMITES DE MI OFICINA - {{strtoupper(auth()->user()->office->name)}}</h2>
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary fw-bold" data-coreui-toggle="modal"
                data-coreui-target="#modal">
                <i class="fa-solid fa-circle-plus"></i> AGREGAR
            </button>
        </div>
        <div class="card-body" wire:ignore>
            <div class="table-responsive">
                <table class="table table-md table-striped w-100 my-2 border-top" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>TICKET</th>
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
    <script src="{{ asset('js/admin/procedures-office/crud.js') }}?v={{ env('APP_VERSION')}}"></script>
@endpush
