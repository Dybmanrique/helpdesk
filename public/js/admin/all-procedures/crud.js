'use strict';

let table;
import { Utils } from '/js/utils.js';

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
                                <button class="btn btn-primary btn-sm fw-bold btn-edit text-nowrap" data-coreui-toggle="modal" data-coreui-target="#modal">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> ADMINISTRAR
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

    function can(permission) {
        return App.permissions.includes(permission);
    }

})();