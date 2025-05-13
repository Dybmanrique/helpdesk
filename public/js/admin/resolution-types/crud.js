'use strict';
import { Forms } from "/js/admin/forms.js";
import { Buttons } from "/js/admin/forms.js";

let table;

(function () {
    initDataTable();

    function initDataTable() {
        table = $('#table').DataTable({
            processing: true,
            serverSide: false,
            ajax: "/admin/estados-de-resolucion/data",
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
                targets: [0, 1]
            }, {
                className: 'dt-body-center dt-head-center text-nowrap',
                targets: [2]
            },]
        });
    }

    const buttonSubmitModal = new Buttons(document.getElementById('buttonSubmitModal'));

    $(`#table tbody`).on('click', '.btn-edit', function () {
        document.getElementById('modalTitle').textContent = "MODIFICAR ESTADO DE RESOLUCIÓN";

        let data = table.row($(this).parents('tr')).data();

        try {
            resolution_type_id = data.id;
            document.getElementById('name').value = data['name'];
            Forms.clearErrors('formModal');
        } catch (Exception) {
            console.error(Exception)
        }
    });

    $(`#table tbody`).on('click', '.btn-delete', async function () {
        let data = table.row($(this).parents('tr')).data();
        if (await confirmationMessage("¿Está seguro?","Se eliminará permanentemente")) {
            remove(data.id);
        }
    });

    $('#modal').on('hidden.coreui.modal', function () {
        document.getElementById('modalTitle').innerText = "REGISTRAR ESTADO DE RESOLUCIÓN";
    });

    let resolution_type_id = null;
    const form = document.getElementById('formModal');

    const btnAdd = document.getElementById('btnAdd');
    btnAdd.addEventListener('click', () => {
        if(resolution_type_id){
            form.reset();
            Forms.clearErrors('formModal')
            resolution_type_id = null;
        }
    });

    async function save() {
        Forms.disableForm('formModal');
        buttonSubmitModal.showLoad('GUARDANDO...');
        const formData = new FormData();

        formData.append('name', document.getElementById('name').value);

        try {
            const response = await fetch('/admin/estados-de-resolucion/guardar-estado-resolucion', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });
    
            
            if (response.ok) {
                const result = await response.json();
                if (!result.success) {
                    Toast.fire({ icon: 'error', 'title': result.message });
                    return;
                }
    
                Toast.fire({ icon: 'success', 'title': result.message });
                table.ajax.reload();
                form.reset();
                Forms.clearErrors('formModal')
            } else {
                // Validation errors (422)
                if (response.status === 422) {
                    Forms.clearErrors('formModal');
                    const result = await response.json();
                    if (result.errors) {
                        Forms.showErrors(result);
                    }
                } else {
                    console.error(result);
                    Toast.fire({ icon: 'error', 'title': 'Error en el servidor' });
                }
            }
        } catch (error) {
            console.error("Error inesperado", error);
            Toast.fire({ icon: 'error', 'title': 'Error inesperado' });
        } finally{
            Forms.enableForm('formModal');
            buttonSubmitModal.reset();
        }
    }

    async function update() {
        Forms.disableForm('formModal');
        buttonSubmitModal.showLoad('GUARDANDO...');
        const formData = new FormData();

        formData.append('resolution_type_id', resolution_type_id);
        formData.append('name', document.getElementById('name').value);
        
        try {
            const response = await fetch('/admin/estados-de-resolucion/actualizar-estado-resolucion', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });
 
            if (response.ok) {
                const result = await response.json();
                if (!result.success) {
                    Toast.fire({ icon: 'error', 'title': result.message });
                    return;
                }
                Toast.fire({ icon: 'success', 'title': result.message });
                table.ajax.reload();
                Forms.clearErrors('formModal');
            } else {
                // Validation errors (422)
                const result = await response.json();
                if (response.status === 422) {
                    Forms.clearErrors('formModal');

                    if (result.errors) {
                        Forms.showErrors(result)
                    }
                } else {
                    console.error(result);
                    Toast.fire({ icon: 'error', 'title': 'Error en el servidor' });
                }
            }
        } catch (error) {
            console.error("Error inesperado", error);
            Toast.fire({ icon: 'error', 'title': 'Error inesperado' });
        } finally{
            Forms.enableForm('formModal');
            buttonSubmitModal.reset();
        }
    }

    async function remove(resolution_type_id) {
        try {
            const response = await fetch(`/admin/estados-de-resolucion/eliminar-estado-resolucion/${resolution_type_id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                Toast.fire({ icon: 'error', 'title': 'Error en el servidor' });
                return;
            }

            const result = await response.json();
            if (!result.success) {
                Toast.fire({ icon: 'error', 'title': result.message });
                return;
            }

            Toast.fire({ icon: 'success', 'title': result.message });
            table.ajax.reload();
        } catch (error) {
            Toast.fire({ icon: 'error', 'title': 'Error en el servidor' });
            console.error(error);
        }
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (resolution_type_id) {
            update();
        } else {
            save();
        }
    })

})();