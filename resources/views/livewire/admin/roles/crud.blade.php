<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form wire:submit='save'>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle" wire:ignore>REGISTRAR ROL</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div wire:loading wire:target.except="save" class="w-100">
                            <x-admin.spinner />
                        </div>
                        <div class="mb-3" wire:loading.remove wire:target.except="save">
                            <label for="name" class="form-label">Nombre (*):</label>
                            <input type="text" class="form-control" wire:model='name' id="name"
                                autocomplete="off">
                            @error('name')
                                <div class="form-text text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <p>Permisos (*):</p>
                        @foreach ($groupedPermissions as $group => $groupedPermission)
                            <div class="card mb-3 permissions-card">
                                <div class="card-header d-flex justify-content-between">{{ $group }}</div>
                                <div class="card-body text-start">
                                    <div class="row">
                                        @foreach ($groupedPermission as $permission)
                                            <div class="col-sm-4">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input items-checkbox" type="checkbox"
                                                        wire:model="selectedPermissions"
                                                        id="perm-{{ $permission['permission']['id'] }}"
                                                        value="{{ $permission['permission']['id'] }}">
                                                    <label class="form-check-label"
                                                        for="perm-{{ $permission['permission']['id'] }}">{{ $permission['permission']['name'] }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @error('selectedPermissions')
                            <div class="form-text text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    @if (auth()->user()->can('Roles: Crear') || auth()->user()->can('Roles: Actualizar'))
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
    <h2>ROLES Y PERMISOS</h2>
    <div class="card">
        @can('Roles: Crear')
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
                            @if (auth()->user()->can('Roles: Actualizar') || auth()->user()->can('Roles: Eliminar'))
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
    <script src="{{ asset('js/admin/roles/crud.js') }}?v={{ env('APP_VERSION') }}"></script>
@endpush
