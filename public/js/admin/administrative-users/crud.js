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
            ajax: "/admin/usuarios-administrativos/data",
            columns: [{
                data: null,
                name: 'id',
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'user.person',
                name: 'identity',
                render: function (data, type, row) {
                    return `${data.identity_type.name}: ${data.identity_number}`;
                }
            },
            {
                data: 'user.person',
                name: 'name',
                render: function (data, type, row) {
                    return `${data.last_name} ${data.second_last_name} ${data.name}`;
                }
            },
            {
                data: 'user.email',
                name: 'email'
            },
            {
                data: 'office.name',
                name: 'office'
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
                targets: [0, 1, 2, 3]
            }, {
                className: 'dt-body-center dt-head-center text-nowrap',
                targets: [4]
            },]
        });
    }

    const passwordTemplate = `
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <label for="password" class="form-label">Contraseña (*):</label>
            <button id="buttonGeneratePassword" type="button" class="btn btn-sm btn-outline-info mb-1"><i class="fa-solid fa-rotate"></i> Generar</button>
        </div>
        <input type="password" class="form-control" name='password'
            id="password" required autocomplete="off">
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmar contraseña
            (*):</label>
        <input type="password" class="form-control" name='password_confirmation'
            id="password_confirmation" required autocomplete="off">
    </div>
    `;

    const changePasswordTemplate = `
    <button id="buttonCollapse" class="btn btn-secondary" type="button" data-coreui-toggle="collapse" data-coreui-target="#collapsePassword" aria-expanded="false" aria-controls="collapsePassword">
        <i class="fa-solid fa-key"></i> Cambiar contraseña
    </button>
    <div class="collapse mt-2" id="collapsePassword">
        <div class="card card-body">
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="password" class="form-label">Contraseña (*):</label>
                    <button id="buttonGeneratePassword" type="button" class="btn btn-sm btn-outline-info mb-1"><i class="fa-solid fa-rotate"></i> Generar</button>
                </div>
                <input type="password" class="form-control" name='password'
                    id="password" required autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar contraseña
                    (*):</label>
                <input type="password" class="form-control" name='password_confirmation'
                    id="password_confirmation" required autocomplete="off">
            </div>
        </div>
    </div>
    `;

    const buttonSubmitModal = new Buttons(document.getElementById('buttonSubmitModal'));

    $(`#table tbody`).on('click', '.btn-edit', function () {
        document.getElementById('modalTitle').textContent = "MODIFICAR USUARIO";

        let data = table.row($(this).parents('tr')).data();

        try {
            selected_item = data;
            document.getElementById('identity_type_id').value = data.user.person.identity_type_id;
            document.getElementById('identity_number').value = data.user.person.identity_number;
            document.getElementById('name').value = data.user.person.name;
            document.getElementById('last_name').value = data.user.person.last_name;
            document.getElementById('second_last_name').value = data.user.person.second_last_name;
            document.getElementById('phone').value = data.user.person.phone;
            document.getElementById('address').value = data.user.person.address;
            document.getElementById('office_id').value = data.office_id;
            document.getElementById('email').value = data.user.email;
            
            const passwordContainer = document.getElementById('passwordContainer');
            passwordContainer.innerHTML = changePasswordTemplate;

            setupCollapsePassword();
            setupGenerateRandomPassword();

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
        document.getElementById('modalTitle').innerText = "REGISTRAR USUARIO";
    });

    let selected_item = null;
    const form = document.getElementById('formModal');

    const btnAdd = document.getElementById('btnAdd');
    btnAdd.addEventListener('click', () => {

        if(selected_item){
            form.reset();
            Forms.clearErrors('formModal')
            selected_item = null;
            const passwordContainer = document.getElementById('passwordContainer');
            passwordContainer.innerHTML = passwordTemplate;
            setupGenerateRandomPassword();
        }
    });

    async function save() {
        Forms.disableForm('formModal');
        buttonSubmitModal.showLoad('GUARDANDO...');
        const formData = new FormData();

        formData.append('identity_type_id', document.getElementById('identity_type_id').value);
        formData.append('identity_number', document.getElementById('identity_number').value);
        formData.append('name', document.getElementById('name').value);
        formData.append('last_name', document.getElementById('last_name').value);
        formData.append('second_last_name', document.getElementById('second_last_name').value);
        formData.append('phone', document.getElementById('phone').value);
        formData.append('address', document.getElementById('address').value);
        formData.append('office_id', document.getElementById('office_id').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('password', document.getElementById('password').value);
        formData.append('password_confirmation', document.getElementById('password_confirmation').value);

        try {
            const response = await fetch('/admin/usuarios-administrativos/guardar-usuario', {
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

        formData.append('administrative_user_id', selected_item.id);
        formData.append('user_id', selected_item.user.id);
        formData.append('identity_type_id', document.getElementById('identity_type_id').value);
        formData.append('identity_number', document.getElementById('identity_number').value);
        formData.append('name', document.getElementById('name').value);
        formData.append('last_name', document.getElementById('last_name').value);
        formData.append('second_last_name', document.getElementById('second_last_name').value);
        formData.append('phone', document.getElementById('phone').value);
        formData.append('address', document.getElementById('address').value);
        formData.append('office_id', document.getElementById('office_id').value);
        formData.append('email', document.getElementById('email').value);

        const collapsePassword = document.getElementById('collapsePassword');
        if(collapsePassword.classList.contains('show')){
            formData.append('password', document.getElementById('password').value);
            formData.append('password_confirmation', document.getElementById('password_confirmation').value);
        }
        
        try {
            const response = await fetch('/admin/usuarios-administrativos/actualizar-usuario', {
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

    async function remove(administrative_user_id) {
        try {
            const response = await fetch(`/admin/usuarios-administrativos/eliminar-usuario/${administrative_user_id}`, {
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
        if (selected_item) {
            update();
        } else {
            save();
        }
    })

    function setupCollapsePassword(){
        const buttonCollapse = document.getElementById('buttonCollapse');
        const collapsePassword = document.getElementById('collapsePassword');
        if(buttonCollapse && collapsePassword){
            buttonCollapse.addEventListener('click', () =>{
                console.log('click');
                
                const password = document.getElementById('password');
                const password_confirmation = document.getElementById('password_confirmation');
    
                if(password && password_confirmation){
                    setTimeout(() => {
                        if(collapsePassword.classList.contains('show')){
                            console.log('has show');
                            
                            password.required = true;
                            password_confirmation.required = true;
                        } else {
                            console.log('dont has show');
                            password.required = false;
                            password_confirmation.required = false;
                        }
                    }, 800);
                }
            });
        }
    }

    setupGenerateRandomPassword();
    function setupGenerateRandomPassword() {
        const buttonGeneratePassword = document.getElementById('buttonGeneratePassword');
        if (buttonGeneratePassword) {
            buttonGeneratePassword.addEventListener('click', () => {
                const passwordField = document.getElementById('password');
                const passwordConfirmationField = document.getElementById('password_confirmation');

                if (passwordField && passwordConfirmationField) {
                    const generatedPassword = generateRandomPassword(12); // Puedes ajustar la longitud

                    // Asignar la contraseña a los campos
                    passwordField.value = generatedPassword;
                    passwordConfirmationField.value = generatedPassword;

                    // Copiar al portapapeles
                    navigator.clipboard.writeText(generatedPassword)
                        .then(() => {
                            Toast.fire({icon: 'info', title: `Contraseña copiada al portapapeles`})

                        })
                        .catch(err => {
                            console.error('Error al copiar la contraseña: ', err);
                        });
                }
            });
        }

        // Función para generar una contraseña aleatoria
        function generateRandomPassword(length) {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+[]{}|;:,.<>?';
            let password = '';
            for (let i = 0; i < length; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return password;
        }
    }

})();