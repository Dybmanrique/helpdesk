<?php

return [
    'sidebar' => [
        [
            'title' => 'DASHBOARD',
            // 'can' => ['manage-theme', 'view-dashboard'],
        ],
        [
            'text' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'fa-solid fa-gauge-high',
            'active' => 'admin/dashboard*',
            // 'can' => ['view-colors'],
        ],
        [
            'text' => 'Tipos de documentos',
            'route' => 'admin.document_types.index',
            'icon' => 'fa-solid fa-file-signature',
            'active' => 'admin/tipos-de-documentos*',
            // 'can' => ['view-colors'],
        ],
        [
            'text' => 'Categorías de trámites',
            'route' => 'admin.procedure_categories.index',
            'icon' => 'fa-solid fa-layer-group',
            'active' => 'admin/categorias-de-tramites*',
            // 'can' => ['view-colors'],
        ],
        [
            'text' => 'Prioridades de trámites',
            'route' => 'admin.procedure_priorities.index',
            'icon' => 'fa-solid fa-arrow-up-wide-short',
            'active' => 'admin/prioridades-de-tramites*',
            // 'can' => ['view-colors'],
        ],
        [
            'text' => 'Estados de trámites',
            'route' => 'admin.procedure_states.index',
            'icon' => 'fa-solid fa-file-circle-question',
            'active' => 'admin/estados-de-tramites*',
            // 'can' => ['view-colors'],
        ],
        [
            'text' => 'Oficinas',
            'route' => 'admin.offices.index',
            'icon' => 'fa-solid fa-building',
            'active' => 'admin/oficinas*',
            // 'can' => ['view-colors'],
        ],
        [
            'title' => 'TRÁMITES',
            // 'can' => ['manage-theme', 'view-dashboard'],
        ],
        [
            'text' => 'Todos los trámites',
            'route' => 'admin.all_procedures.index',
            'icon' => 'fa-solid fa-folder-open',
            'active' => 'admin/todos-los-tramites*',
            // 'can' => ['view-colors'],
        ],
        [
            'text' => 'Trámites oficina',
            'route' => 'admin.procedures_office.index',
            'icon' => 'fa-solid fa-building-circle-arrow-right',
            'active' => 'admin/tramites-mi-oficina*',
            // 'can' => ['view-colors'],
        ],
        [
            'title' => 'RESOLUCIONES',
            // 'can' => ['manage-theme', 'view-dashboard'],
        ],
        [
            'text' => 'Tipos de resolución',
            'route' => 'admin.resolution_types.index',
            'icon' => 'fa-solid fa-layer-group',
            'active' => 'admin/tipos-de-resolucion*',
            // 'can' => ['view-colors'],
        ],
        [
            'text' => 'Estados de resolución',
            'route' => 'admin.resolution_states.index',
            'icon' => 'fa-solid fa-file-circle-question',
            'active' => 'admin/estados-de-resolucion*',
            // 'can' => ['view-colors'],
        ],
        [
            'text' => 'Resoluciones',
            'route' => 'admin.resolutions.index',
            'icon' => 'fa-solid fa-file-contract',
            'active' => 'admin/resoluciones*',
            // 'can' => ['view-colors'],
        ],
        [
            'title' => 'USUARIOS',
            // 'can' => ['manage-theme', 'view-dashboard'],
        ],
        [
            'text' => 'Usuarios administrativos',
            'route' => 'admin.administrative_users.index',
            'icon' => 'fa-solid fa-file-contract',
            'active' => 'admin/usuarios-administrativos*',
            // 'can' => ['view-colors'],
        ],
        // [
        //     'text' => 'Buttons',
        //     'icon' => 'fa-regular fa-file',
        //     // 'can' => ['view-buttons'],
        //     'submenu' => [
        //         [
        //             'text' => 'Buttons',
        //             'route' => 'dashboard',
        //             'active' => 'buttons/index*',
        //             // 'can' => ['view-buttons-simple'],
        //             'badge' => null,
        //         ],
        //         [
        //             'text' => 'Dropdowns',
        //             'url' => 'https://example.com/dropdowns',
        //             'active' => 'buttons/dropdowns.html',
        //             // 'can' => ['view-dropdowns', 'manage-dropdowns'],
        //             'badge' => [
        //                 'text' => 'PRO',
        //                 'class' => 'badge-sm bg-danger ms-auto',
        //             ],
        //         ],
        //     ],
        // ],
        // [
        //     'title' => 'DASHBOARD 2',
        //     // 'can' => ['manage-theme', 'view-dashboard'],
        // ],
        ]
];
