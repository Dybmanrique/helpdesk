'use strict';

let table;

(function () {
    initDataTable();

    function initDataTable() {
        table = $('#table').DataTable({
            processing: true,
            serverSide: false,
            ajax: "/admin/resoluciones/data",
            columns: [{
                data: null,
                name: 'id',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'resolution_number',
                name: 'resolution_number'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                            <button class="btn btn-secondary btn-sm fw-bold btn-view">
                                <i class="fa-solid fa-eye"></i> VER
                            </button>
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
                targets: [0, 1, 2]
            }, {
                className: 'dt-body-center dt-head-center text-nowrap',
                targets: [3]
            },]
        });
    }

    $(`#table tbody`).on('click', '.btn-view', function () {
        let data = table.row($(this).parents('tr')).data();
        const uuid = data.file_resolution.file.uuid;
        window.open(`/admin/resoluciones/ver-archivo/${uuid}`, '_blank');
    });

    $(`#table tbody`).on('click', '.btn-edit', function () {
        document.getElementById('modalTitle').textContent = "MODIFICAR EXPEDIENTE";
        document.getElementById('file').required = false;

        let data = table.row($(this).parents('tr')).data();

        try {
            resolution_id = data.id;
            document.getElementById('resolution_type_id').value = data['resolution_type_id'];
            document.getElementById('resolution_state_id').value = data['resolution_state_id'];
            document.getElementById('resolution_number').value = data['resolution_number'];
            document.getElementById('description').value = data['description'];
            const file = document.getElementById('file');
            file.value = '';
            clearErrors();

            const fileUpload = document.getElementById('fileUpload');
            fileUpload.innerHTML = '';
            const uploadedFileLink = document.createElement('a');
            fileUpload.classList.remove('d-none');
            uploadedFileLink.href = `/admin/resoluciones/ver-archivo/${data.file_resolution.file.uuid}`;
            uploadedFileLink.innerHTML = `<i class="fa-solid fa-paperclip"></i> ${data.file_resolution.file.name}`
            const text = document.createElement('span');
            text.textContent = 'Archivo subido: '
            fileUpload.appendChild(text);
            fileUpload.appendChild(uploadedFileLink);

        } catch (Exception) {

        }
    });

    $(`#table tbody`).on('click', '.btn-delete', async function () {
        let data = table.row($(this).parents('tr')).data();
        if (await confirmationMessage("¿Está seguro?","Se eliminará permanentemente")) {
            remove(data.id);
        }
    });

    $('#modal').on('hidden.coreui.modal', function () {
        document.getElementById('modalTitle').innerText = "REGISTRAR EXPEDIENTE";
    });

    const fileInput = document.getElementById('file');
    const resolution_number = document.getElementById('resolution_number');
    fileInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            if (resolution_number.value.trim() === '') {
                const fileName = file.name.split('.').slice(0, -1).join('.'); // sin extensión
                resolution_number.value = fileName;
            }
        }
    });

    let resolution_id = null;
    const form = document.getElementById('formModal');

    const btnAdd = document.getElementById('btnAdd');
    btnAdd.addEventListener('click', () => {
        if(resolution_id){
            form.reset();
            clearErrors()
            resolution_id = null;
            document.getElementById('fileUpload').classList.add('d-none');
        }
    });

    async function save() {
        const formData = new FormData();

        formData.append('resolution_type_id', document.getElementById('resolution_type_id').value);
        formData.append('resolution_state_id', document.getElementById('resolution_state_id').value);
        formData.append('file', fileInput.files[0]);
        formData.append('resolution_number', document.getElementById('resolution_number').value);
        formData.append('description', document.getElementById('description').value);

        try {
            const response = await fetch('/admin/resoluciones/guardar-resolucion', {
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
                clearErrors()
            } else {
                // Validation errors (422)
                if (response.status === 422) {
                    clearErrors();
                    const result = await response.json();
                    if (result.errors) {
                        Object.keys(result.errors).forEach(field => {
                            const inputElement = document.getElementById(field);
                            if (inputElement) {
                                inputElement.classList.add('is-invalid');
    
                                const errorDiv = document.createElement('div');
                                errorDiv.classList.add('invalid-feedback');
                                errorDiv.textContent = result.errors[field][0];
    
                                inputElement.parentNode.appendChild(errorDiv);
                            }
                        });
                    }
                } else {
                    console.error(result);
                    Toast.fire({ icon: 'error', 'title': 'Error en el servidor' });
                }
            }
        } catch (error) {
            console.error("Error inesperado", error);
            Toast.fire({ icon: 'error', 'title': 'Error inesperado' });
        }
    }

    async function update() {
        const formData = new FormData();

        formData.append('resolution_id', resolution_id);
        formData.append('resolution_type_id', document.getElementById('resolution_type_id').value);
        formData.append('resolution_state_id', document.getElementById('resolution_state_id').value);
        if (fileInput.files[0]) {
            formData.append('file', fileInput.files[0]);
        }
        formData.append('resolution_number', document.getElementById('resolution_number').value);
        formData.append('description', document.getElementById('description').value);

        try {
            const response = await fetch('/admin/resoluciones/actualizar-resolucion', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });
 
            if (response.ok) {
                console.log('ok');
                const result = await response.json();
                if (!result.success) {
                    Toast.fire({ icon: 'error', 'title': result.message });
                    return;
                }
                Toast.fire({ icon: 'success', 'title': result.message });
                table.ajax.reload();
                clearErrors();
            } else {
                // Validation errors (422)
                const result = await response.json();
                if (response.status === 422) {
                    clearErrors();

                    if (result.errors) {
                        Object.keys(result.errors).forEach(field => {
                            const inputElement = document.getElementById(field);
                            if (inputElement) {
                                inputElement.classList.add('is-invalid');

                                const errorDiv = document.createElement('div');
                                errorDiv.classList.add('invalid-feedback');
                                errorDiv.textContent = result.errors[field][0];

                                inputElement.parentNode.appendChild(errorDiv);
                            }
                        });
                    }
                } else {
                    console.error(result);
                    Toast.fire({ icon: 'error', 'title': 'Error en el servidor' });
                }
            }
        } catch (error) {
            console.error("Error inesperado", error);
            Toast.fire({ icon: 'error', 'title': 'Error inesperado' });
        }
    }

    async function remove(resolution_id) {
        try {
            const response = await fetch(`/admin/resoluciones/eliminar-resolucion/${resolution_id}`, {
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
        }
    }


    function clearErrors() {
        const invalidInputs = document.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });

        const errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(div => {
            div.remove();
        });
    }

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        if (resolution_id) {
            update();
        } else {
            save();
        }
    })

})();