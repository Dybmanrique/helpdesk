'use strict';

let table;

document.addEventListener('livewire:initialized', () => {
    Livewire.on('refreshTable', () => {
        table.ajax.reload();
    });
});

(function () {
    initDataTable();

    function initDataTable() {
        table = $('#table').DataTable({
            processing: true,
            serverSide: false,
            ajax: "/admin/todos-los-tramites/data",
            columns: [{
                data: null,
                name: 'id',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'ticket',
                name: 'ticket'
            },
            {
                data: 'reason',
                name: 'reason'
            },
            {
                data: null,
                name: 'person',
                render: function (data, type, row, meta) {
                    return `${data.user.person.name} ${data.user.person.last_name} ${data.user.person.second_last_name}`;
                }
            },
            {
                data: 'user.email',
                name: 'email'
            },
            {
                data: 'user.person.phone',
                name: 'phone'
            },
            {
                data: 'document_type.name',
                name: 'document_type'
            },
            {
                data: 'procedure_category.name',
                name: 'procedure_category'
            },
            {
                data: 'procedure_priority.name',
                name: 'procedure_priority'
            },
            {
                data: 'procedure_state.name',
                name: 'procedure_state'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                            <button class="btn btn-primary btn-sm fw-bold btn-edit" data-coreui-toggle="modal" data-coreui-target="#modal">
                                <i class="fa-solid fa-pen-to-square"></i> EDITAR
                            </button>
                            <button class="btn btn-danger btn-sm fw-bold btn-delete"">
                                <i class="fa-solid fa-trash-can"></i> ELIMINAR
                            </button>
                        `;
                }
            }
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            columnDefs: [{
                className: 'dt-body-left dt-head-left text-nowrap',
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            }, {
                className: 'dt-body-center dt-head-center text-nowrap',
                targets: [10]
            },]
        });
    }

    $(`#table tbody`).on('click', '.btn-edit', function () {
        document.getElementById('modalTitle').textContent = "MODIFICAR TIPO DE DOCUMENTO";

        let data = table.row($(this).parents('tr')).data();
        Livewire.dispatch('editItem', {
            id: data['id'],
            name: data['name'],
        });
    });

    $(`#table tbody`).on('click', '.btn-delete', async function () {
        let data = table.row($(this).parents('tr')).data();
        if (await confirmationMessage()) {
            Livewire.dispatch('deleteItem', {
                id: data['id']
            });
        }
    });

    $('#modal').on('hidden.coreui.modal', function () {
        document.getElementById('modalTitle').innerText = "REGISTRAR TIPO DE DOCUMENTO";
        Livewire.dispatch('resetInputs');
    });

})();