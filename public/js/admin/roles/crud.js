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
            ajax: "/admin/roles/data",
            columns: [{
                data: null,
                name: 'id',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    let buttonActions = '';
                    if (can('Roles: Actualizar')) {
                        buttonActions += `
                            <button class="btn btn-primary btn-sm fw-bold btn-edit" data-coreui-toggle="modal" data-coreui-target="#modal">
                                <i class="fa-solid fa-pen-to-square"></i> EDITAR
                            </button>
                        `;
                    }
                    if (can('Roles: Eliminar')) {
                        buttonActions += `
                            <button class="btn btn-danger btn-sm fw-bold btn-delete"">
                                <i class="fa-solid fa-trash-can"></i> ELIMINAR
                            </button>
                        `;
                    }
                    return buttonActions;
                }
            }
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            columnDefs: [{
                className: 'dt-body-left dt-head-left text-nowrap',
                targets: [0, 1]
            }, {
                className: 'dt-body-center dt-head-center text-nowrap',
                targets: [2]
            },]
        });
    }

    function can(permission) {
        return App.permissions.includes(permission);
    }

    $(`#table tbody`).on('click', '.btn-edit', function () {
        document.getElementById('modalTitle').textContent = "MODIFICAR ROL";

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
        document.getElementById('modalTitle').innerText = "REGISTRAR ROL";
        Livewire.dispatch('resetInputs');
    });

    // $('.permissions-card .card-header').on('click', 'input[type=checkbox]', function () {
    //     // console.log(this);
    //     console.log($(this).closest('.permissions-card'));
    // })

    document.querySelectorAll('.items-checkbox').forEach(function (itemCheckbox) {
        itemCheckbox.addEventListener('click', function () {
            itemCheckbox.checked = this.checked ? true : false;
            console.log(this);
        });
    });

    let permissions = [];
    document.querySelectorAll('.group-checkbox').forEach(function (groupCheckbox) {
        groupCheckbox.addEventListener('change', function () {
            let groupChecked = this.checked;
            let card = this.closest('.card');

            card.querySelectorAll('.items-checkbox').forEach(function (item) {
                console.log(item.getAttribute('id'));
                item.checked = groupChecked;
                let permissionId = parseInt(item.getAttribute('id'));
                permissions.push(parseInt(item.getAttribute('id')));
                console.log(item.checked);
            });
            console.log(permissions);
            Livewire.dispatch('updatePermissions', { permissions });
        });
    });

})();