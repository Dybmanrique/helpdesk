'use strict';

let table;
import { Utils } from '/js/Utils.js';

(function () {
    initDataTable();

    function initDataTable() {
        table = $('#table').DataTable({
            processing: true,
            serverSide: false,
            ordering: false,
            ajax: "/admin/tramites-mi-oficina/data",
            columns: [
                {
                    data: null,
                    name: 'id',
                    render: (data, type, row, meta) => meta.row + 1
                },
                {
                    data: 'expedient_number',
                    name: 'expedient_number',
                    render: data => data ?? 'No tiene'
                },
                {
                    data: 'reason',
                    name: 'reason'
                },
                {
                    data: 'applicant_name',
                    name: 'applicant_name'
                },
                {
                    data: 'applicant_email',
                    name: 'applicant_email'
                },
                {
                    data: 'applicant_identity',
                    name: 'applicant_identity'
                },
                {
                    data: 'document_type',
                    name: 'document_type'
                },
                {
                    data: 'procedure_category',
                    name: 'procedure_category'
                },
                {
                    data: 'procedure_priority',
                    name: 'procedure_priority'
                },
                {
                    data: 'procedure_state',
                    name: 'procedure_state'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function () {
                        let buttonActions = '';
                        if (can('Trámites de mi Oficina: Administrar')) {
                            buttonActions += `
                                <button class="btn btn-primary btn-sm fw-bold btn-edit text-nowrap" data-coreui-toggle="modal" data-coreui-target="#modal">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> ADMINISTRAR
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
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            }, {
                className: 'dt-body-center dt-head-center text-nowrap',
                targets: [10]
            },]
        });
    }

    function can(permission) {
        return App.permissions.includes(permission);
    }

    function showLoader(loaderId, conentId, show = true) {
        const modalLoader = document.getElementById(loaderId);
        const modalContent = document.getElementById(conentId);
        if (modalLoader && modalContent) {
            if (show) {
                modalLoader.classList.remove('d-none');
                modalContent.classList.add('d-none');
            } else {
                modalLoader.classList.add('d-none');
                modalContent.classList.remove('d-none');
            }
        }
    }

    let derivation_id;
    let procedure_id;
    $(`#table tbody`).on('click', '.btn-edit', function () {

        let data = table.row($(this).parents('tr')).data();
        procedure_id = data.procedure.id;
        derivation_id = data.id;

        showInfoProcedure(procedure_id);
        document.getElementById('formSave').reset();
        document.getElementById('actions_container').classList.add('d-none');
    });

    async function showInfoProcedure(procedure_id) {
        try {
            showLoader('modalLoader', 'modalContent');
            const response = await fetch('/admin/tramites-mi-oficina/info-tramite', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ procedure_id: procedure_id })
            });

            if (!response.ok) {
                Toast.fire({ icon: 'error', title: 'Algo salió mal' });
                return;
            }

            const dataResponse = await response.json();
            if (!dataResponse.success) {
                Toast.fire({ icon: 'info', title: data.message });
                return;
            }

            completeFieldsProcedure(dataResponse.data);
            showLoader('modalLoader', 'modalContent', false);

        } catch (Exception) {
            Toast.fire({ icon: 'error', title: 'Algo salió mal' });
            console.error(Exception);
        }
    }

    function completeFieldsProcedure(data) {
        document.getElementById('expedientNumber').value = data.expedient_number;
        document.getElementById('ticketModal').textContent = data.ticket;
        document.getElementById('reasonModal').textContent = data.reason;
        document.getElementById('descriptionModal').textContent = data.description;
        document.getElementById('stateModal').textContent = data.state;
        document.getElementById('categoryModal').textContent = data.category;
        document.getElementById('documentTypeModal').textContent = data.document_type;
        document.getElementById('priorityModal').textContent = data.priority;
        document.getElementById('personModal').textContent = `${data.applicant.last_name} ${data.applicant.second_last_name} ${data.applicant.name}`;
        document.getElementById('personPhoneModal').textContent = data.applicant.phone;
        document.getElementById('personEmailModal').textContent = data.applicant.email;

        const expedientNumber = document.getElementById('expedientNumber');

        if (data.expedient_number === null || data.expedient_number === "") {
            expedientNumber.readOnly = false;
            showButtonsEditExpedient(true, false);
        } else {
            expedientNumber.readOnly = true;
            showButtonsEditExpedient(false);
        }

        const filesModal = document.getElementById('filesModal');
        filesModal.innerHTML = '';
        if (data.procedure_files.length > 0) {
            data.procedure_files.forEach(file => {
                const li = document.createElement('li');
                const a = document.createElement('a');
                a.href = `/tramites/ver-archivo/${file.uuid}`;
                a.target = '_blank';
                a.textContent = file.name;
                li.appendChild(a);
                filesModal.append(li)
            });
        } else if (data.procedure_link != null) {
            const li = document.createElement('li');
            const a = document.createElement('a');
            a.href = data.procedure_link;
            a.target = '_blank';
            a.textContent = 'Enlace compartido';
            li.appendChild(a);
            filesModal.append(li)
        }

        const timelineModal = document.getElementById('timelineModal');
        timelineModal.innerHTML = '';
        data.actions.forEach(action => {
            timelineModal.insertAdjacentHTML('beforeend', setTimelineTemplate(action));
        });
    }

    const actionsMap = {
        'iniciar': 'Se inició el trámite',
        'comentar': 'Se agregó un comentario',
        'derivar': 'Se derivó a otra oficina',
        'concluir': 'Se concluyó el trámite',
        'anular': 'Se anuló el trámite',
        'archivar': 'Se archivó el trámite'
    }

    function setTimelineTemplate(action) {
        // Formatear fecha y hora
        let formattedDate = '';
        let formattedTime = '';

        if (action.created_at) {
            const dateTime = Utils.formatDateTimeString(action.created_at);
            formattedDate = dateTime.date;
            formattedTime = dateTime.time;
        }

        // Preparar el template de archivos solo si hay archivos
        let filesSection = '';
        if (action.files && action.files.length > 0) {
            let templateFiles = '<ol class="ps-3 mb-2">';
            action.files.forEach(file => {
                templateFiles += `<li><a target="_blank" href="${file.id}">${file.name}</a></li>`;
            });
            templateFiles += '</ol>';

            filesSection = `
                <br>
                <span>Archivos Adjuntos: </span>
                ${templateFiles}
            `;
        }

        // Preparar la sección de descripción solo si hay descripción
        let descriptionSection = '';
        if (action.comment) {
            descriptionSection = `<div style="white-space: pre-line">${action.comment}</div>`;
        }

        const template = `
        <div>
            <i class="fas bg-blue"></i>
            <div class="timeline-item">
                <div class="timeline-header">
                    <div class="d-flex justify-content-between">
                        <div>
                            <span class="time text-sm text-muted text-nowrap"><i
                                    class="fas fa-calendar"></i> ${formattedDate}</span>
                            <span class="time text-sm text-muted text-nowrap ms-2"><i
                                    class="fas fa-clock"></i> ${formattedTime}</span>
                        </div>
                    </div>
                </div>
                <div class="timeline-body">
                    <span class="fw-bold d-inline-block mb-2">${actionsMap[action.action]}</span>
                    ${descriptionSection}
                    ${filesSection}
                </div>
            </div>
        </div>`;

        return template;
    }

    const actions_select = document.getElementById('actions_select');
    if (actions_select) {
        actions_select.addEventListener('change', (event) => {

            const actions_container = document.getElementById('actions_container');
            const office_id = document.getElementById('office_id');
            const user_id = document.getElementById('user_id');

            actions_container.classList.remove('d-none');
            const comment = document.getElementById('comment');
            comment.required = false;

            switch (actions_select.value) {
                case 'derivar':
                    showDerivationSection(true);
                    break;

                case 'comentar':
                    comment.required = true;
                    showDerivationSection(false)
                    break;

                default:
                    showDerivationSection(false);
                    break;
            }
        });
    }

    function showDerivationSection(show = true) {
        const container_derivation = document.getElementById('container_derivation');
        if (show) {
            container_derivation.classList.remove('d-none');
            office_id.required = true;
            user_id.required = true;
        } else {
            container_derivation.classList.add('d-none');
            office_id.required = false;
            user_id.required = false;
        }
    }

    const generateExpedientNumber = document.getElementById('generateExpedientNumber');
    generateExpedientNumber.addEventListener('click', async () => {
        showLoader('expedientNumberLoader', 'expedientNumber');

        try {
            const response = await fetch('/admin/tramites-mi-oficina/generar-numero-expediente');

            if (!response.ok) {
                Toast.fire({ icon: 'error', title: 'Ocurrió un error en el servidor' });
                return;
            }

            const data = await response.json();
            if (!data.success) {
                Toast.fire({ icon: 'info', title: data.message });
                return;
            }

            const expedientNumber = document.getElementById('expedientNumber');
            expedientNumber.value = data.data;
        } catch (Exception) {
            Toast.fire({ icon: 'error', title: 'Algo salió mal, intentelo nuevamente' });
        } finally {
            showLoader('expedientNumberLoader', 'expedientNumber', false);
        }

    })

    const office_id = document.getElementById('office_id');
    office_id.addEventListener('change', async (event) => {
        showLoader('usersLoader', 'user_id');
        const office_id = event.target.value;
        const response = await fetch('/admin/tramites-mi-oficina/usuarios-oficina', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ office_id: office_id })
        });

        if (!response.ok) {
            Toast.fire({ icon: 'error', title: 'Algo salió mal' });
            return;
        }

        const data = await response.json();
        if (!data.success) {
            Toast.fire({ icon: 'info', title: data.message });
            return;
        }

        const user_id = document.getElementById('user_id');
        user_id.innerHTML = '<option value="" class="d-none">Seleccione</option>';
        data.data.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = `${user.person.name} ${user.person.last_name} ${user.person.second_last_name}`
            user_id.append(option);
        });

        showLoader('usersLoader', 'user_id', false);
    })

    const btnSave = document.getElementById('btnSave');
    if (btnSave) {
        btnSave.addEventListener('click', (event) => {
            const form = document.getElementById('formSave');
            const formIsValid = form.checkValidity();
            if (!formIsValid) {
                form.reportValidity();
                return;
            }

            Swal.fire({
                title: "¿Esta seguro(a)?",
                text: "Esta acción será permanente",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#5856d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, continuar",
                cancelButtonText: "Cancelar"
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await saveAction();
                }
            });
        })
    }

    async function saveAction() {
        const form = document.getElementById('formSave');
        const formData = new FormData();

        formData.append('derivation_id', derivation_id);
        formData.append('action', document.getElementById('actions_select').value);
        formData.append('office_id', document.getElementById('office_id').value);
        formData.append('user_id', document.getElementById('user_id').value);
        formData.append('comment', document.getElementById('comment').value);

        const fileInput = document.getElementById('file');
        if (fileInput.files.length > 0) {
            formData.append('file', fileInput.files[0]);
        }

        try {
            const response = await fetch('/admin/tramites-mi-oficina/guardar-accion', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });


            if (response.ok) {
                const result = await response.json();
                console.log(result);
                Toast.fire({ icon: 'success', 'title': result.message });
                table.ajax.reload();
                form.reset();
                showDerivationSection(false);

                if (result.will_continue_active_derivation) {
                    showInfoProcedure(procedure_id);
                } else {
                    $('#modal').modal('hide');
                }

            } else {
                console.error(result);
            }
        } catch (error) {
            console.error("Error inesperado", error);
        }
    }

    let oldExpedientNumber;
    const expedientNumber = document.getElementById('expedientNumber');

    const editExpedientNumber = document.getElementById('editExpedientNumber');
    editExpedientNumber.addEventListener('click', () => {
        showButtonsEditExpedient();
        oldExpedientNumber = expedientNumber.value;
    });

    const cancelExpedientNumber = document.getElementById('cancelExpedientNumber');
    cancelExpedientNumber.addEventListener('click', () => {
        showButtonsEditExpedient(false);
        expedientNumber.value = oldExpedientNumber;
    });

    const buttonsEditExpedientContainer = document.getElementById('buttonsEditExpedientContainer');

    function showButtonsEditExpedient(show = true, includeCancelButton = true) {
        if (show) {
            editExpedientNumber.classList.add('d-none');
            buttonsEditExpedientContainer.classList.add('d-flex');
            buttonsEditExpedientContainer.classList.remove('d-none');
            expedientNumber.readOnly = false;
        } else {
            editExpedientNumber.classList.remove('d-none');
            buttonsEditExpedientContainer.classList.remove('d-flex');
            buttonsEditExpedientContainer.classList.add('d-none');
            expedientNumber.readOnly = true;
        }
        if (includeCancelButton) {
            cancelExpedientNumber.classList.remove('d-none');
        } else {
            cancelExpedientNumber.classList.add('d-none');
        }
    }

    const saveExpedientNumber = document.getElementById('saveExpedientNumber');
    const formExpedientNumber = document.getElementById('formExpedientNumber');
    saveExpedientNumber.addEventListener('click', async () => {
        if (!formExpedientNumber.checkValidity()) {
            formExpedientNumber.reportValidity();
            return;
        }

        try {
            const response = await fetch('/admin/tramites-mi-oficina/guardar-numero-expediente', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ procedure_id: procedure_id, expedient_number: expedientNumber.value })
            });


            if (!response.ok) {
                Toast.fire({ icon: 'error', title: 'Ocurrió un error en el servidor' });
                return;
            }

            const dataResponse = await response.json();

            if (!dataResponse.success) {
                Toast.fire({ icon: 'info', title: dataResponse.message });
                return;
            }

            Toast.fire({ icon: 'success', title: dataResponse.message });
            showButtonsEditExpedient(false);
            table.ajax.reload();
        } catch (Exception) {
            Toast.fire({ icon: 'error', title: 'Algo salió mal, inténtelo nuevamente' });
        }
    });

    //Prevenir el comportamiento por defecto de los forms
    document.getElementById('formExpedientNumber').addEventListener('submit', function (event) {
        event.preventDefault();
    });
    document.getElementById('formSave').addEventListener('submit', function (event) {
        event.preventDefault();
    });
})();