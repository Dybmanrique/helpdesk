<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit='save'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle" wire:ignore>REGISTRAR PRIORIDAD DE TRÁMITE</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div wire:loading wire:target.except="save" class="w-100">
                            <x-admin.spinner />
                        </div>
                        <div class="mb-3" wire:loading.remove wire:target.except="save">
                            <label for="name" class="form-label">Nombre (*):</label>
                            <input type="text" class="form-control" wire:model='name' id="name" required
                                autocomplete="off">
                            @error('name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    @if (auth()->user()->can('Prioridades de Trámites: Crear') || auth()->user()->can('Prioridades de Trámites: Actualizar'))
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

    <h2>PRIORIDADES DE TRÁMITES</h2>
    <div class="card">
        @can('Prioridades de Trámites: Crear')
            <div class="card-header">
                <button type="button" class="btn btn-primary fw-bold" data-coreui-toggle="modal"
                    data-coreui-target="#modal">
                    <i class="fa-solid fa-circle-plus"></i> AGREGAR
                </button>
            </div>
        @endcan
        <div class="card-body" wire:ignore>
            <div class="table-responsive">
                <table class="table table-md table-striped w-100 my-2 border-top" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            @if (auth()->user()->can('Prioridades de Trámites: Actualizar') ||
                                    auth()->user()->can('Prioridades de Trámites: Eliminar'))
                                <th>ACCIONES</th>
                            @endif
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script src="{{ asset('js/admin/procedure-priorities/crud.js') }}?v={{ env('APP_VERSION') }}"></script>
@endpush
