'use strict';

let table;
import { Utils } from '/js/Utils.js';
import { Loader } from '/js/admin/loader.js';

(function () {
    initDataTable();

    function initDataTable() {
        table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: "/admin/todos-los-tramites/data",
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
                    data: 'applicant_identity',
                    name: 'applicant_identity'
                },
                {
                    data: 'document_type_name',
                    name: 'document_type_name'
                },
                {
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'priority_name',
                    name: 'priority_name'
                },
                {
                    data: 'state_name',
                    name: 'state_name'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false,
                    render: function () {
                        let buttonActions = '';
                        if (can('Todos los Trámites: Administrar')) {
                            buttonActions += `
                                <button class="btn btn-secondary btn-sm fw-bold btn-view text-nowrap" data-coreui-toggle="modal" data-coreui-target="#modal">
                                    <i class="fa-solid fa-eye"></i> VISUALIZAR
                                </button>
                            `;
                        }
                        return buttonActions;
                    }
                }
            ],
            // Configuración para la búsqueda
            // search: {
            //     return: true,    // Envía búsqueda al servidor
            // },
            // searchDelay: 500,    // Retraso en milisegundos antes de buscar
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json',
                // searchPlaceholder: "Buscar por expediente, asunto, solicitante o identificación"
            },
            columnDefs: [{
                className: 'dt-body-left dt-head-left text-nowrap',
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
            }, {
                className: 'dt-body-center dt-head-center text-nowrap',
                targets: [9]
            }, {
                // Columnas que serán buscables (especificar solo estas columnas)
                searchable: true,
                targets: [1, 2, 3, 4] // Expediente, Razón, Solicitante, Identidad
            }, {
                searchable: false,
                targets: [0, 5, 6, 7, 8, 9] // El resto de columnas no son buscables
            }]
        });

        // Opcional: Personalizar el campo de búsqueda
        // $('#table_filter input').attr('placeholder', 'Expediente, asunto, solicitante, identificación...');
    }

    let procedure_id;
    $(`#table tbody`).on('click', '.btn-view', function () {

        let data = table.row($(this).parents('tr')).data();
        console.log(data)
        procedure_id = data.id;

        showInfoProcedure(procedure_id);
    });

    async function showInfoProcedure(procedure_id) {
        try {
            Loader.showLoader('modalLoader', 'modalContent');
            const response = await fetch('/admin/todos-los-tramites/info-tramite', {
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
            Loader.showLoader('modalLoader', 'modalContent', false);

        } catch (Exception) {
            Toast.fire({ icon: 'error', title: 'Algo salió mal' });
            console.error(Exception);
        }
    }

    function completeFieldsProcedure(data) {
        document.getElementById('expedientNumber').textContent = data.expedient_number;
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
        } else {
            expedientNumber.readOnly = true;
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
                templateFiles += `<li><a target="_blank" href="/acciones/ver-archivo/${file.uuid}">${file.name}</a></li>`;
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

    const actionsMap = {
        'iniciar': 'Se inició el trámite',
        'comentar': 'Se agregó un comentario',
        'derivar': 'Se derivó a otra oficina',
        'concluir': 'Se concluyó el trámite',
        'anular': 'Se anuló el trámite',
        'archivar': 'Se archivó el trámite'
    }

    function can(permission) {
        return App.permissions.includes(permission);
    }

})();