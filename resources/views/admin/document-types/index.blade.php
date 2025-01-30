@extends('layouts.dashboard')

@section('title', 'Dashboard Home')

@section('content')
    <h2>TIPOS DE DOCUMENTOS</h2>
    <div class="card">

        <div class="card-header">
            <a href="#" class="btn btn-primary text-uppercase font-weight-bold">Registrar
                nueva facultad</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-md w-100 my-2 border-top" id="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NOMBRE</th>
                            <th scope="col">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('css')

@endsection

@section('js')
    <script>
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        $(document).ready(function() {

            let columnAttributes = [{
                    "data": "id",
                    "render": function(data, type, row, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    "data": "name",
                },
                {
                    "data": null,
                    "render": function(data, type, row, meta) {
                        return (
                            `<div class="d-flex flex-row justify-content-end">
                            <a class="btn btn-primary btn-sm mr-2 font-weight-bold btn-edit" href="#"><i class="far fa-edit"></i> EDITAR</a>
                            <button class="btn btn-sm btn-danger font-weight-bold btn-delete" type="button"><i class=" fas fa-trash"></i> ELIMINAR</button>
                        </div>`.replace(':id', data.id)
                        );
                    }
                }
            ];

            columnDefs = [{
                    className: 'dt-body-left dt-head-left text-nowrap',
                    targets: [0, 1, 2 ]
                },
            ];

            let table = $(`#table`).DataTable({
                "ajax": {
                    "url": "{{ route('admin.document_types.data') }}",
                    "type": "GET",
                    "dataSrc": "",
                },
                "columns": columnAttributes,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                },
                columnDefs: columnDefs,
            });

            $(`#table tbody`).on('click', '.btn-delete', function() {
                let data = table.row($(this).parents('tr')).data();
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "Esta acción no se puede revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1e40af',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'SÍ, ELIMINAR!',
                    cancelButtonText: 'CANCELAR'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "#",
                            type: "POST",
                            dataType: 'json',
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: data["id"],
                            }
                        }).done(function(response) {
                            if (response.code == '200') {
                                table.ajax.reload();
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                            } else if (response.code == '500') {
                                Toast.fire({
                                    icon: 'info',
                                    title: response.message
                                });
                            }
                        });
                    }
                })
            });

        });
    </script>
@endsection
