<?php

return [
    'sidebar' => [
        [
            'title' => 'DASHBOARD',
            'can' => [
                'Dashboard Administrativo: Ver',
                'Tipos de Documentos: Listar',
                'Categorías de Trámites: Listar',
                'Prioridades de Trámites: Listar',
                'Estados de Trámites: Listar',
                'Oficinas: Listar'
            ],
        ],
        [
            'text' => 'Dashboard',
            'route' => 'admin.dashboard',
            'icon' => 'fa-solid fa-gauge-high',
            'active' => 'admin/dashboard*',
            'can' => ['Dashboard Administrativo: Ver'],
        ],
        [
            'text' => 'Tipos de documentos',
            'route' => 'admin.document_types.index',
            'icon' => 'fa-solid fa-file-signature',
            'active' => 'admin/tipos-de-documentos*',
            'can' => ['Tipos de Documentos: Listar'],
        ],
        [
            'text' => 'Categorías de trámites',
            'route' => 'admin.procedure_categories.index',
            'icon' => 'fa-solid fa-layer-group',
            'active' => 'admin/categorias-de-tramites*',
            'can' => ['Categorías de Trámites: Listar'],
        ],
        [
            'text' => 'Prioridades de trámites',
            'route' => 'admin.procedure_priorities.index',
            'icon' => 'fa-solid fa-arrow-up-wide-short',
            'active' => 'admin/prioridades-de-tramites*',
            'can' => ['Prioridades de Trámites: Listar'],
        ],
        [
            'text' => 'Estados de trámites',
            'route' => 'admin.procedure_states.index',
            'icon' => 'fa-solid fa-file-circle-question',
            'active' => 'admin/estados-de-tramites*',
            'can' => ['Estados de Trámites: Listar'],
        ],
        [
            'text' => 'Oficinas',
            'route' => 'admin.offices.index',
            'icon' => 'fa-solid fa-building',
            'active' => 'admin/oficinas*',
            'can' => ['Oficinas: Listar'],
        ],
        [
            'title' => 'TRÁMITES',
            'can' => ['Todos los Trámites: Listar', 'Trámites de mi Oficina: Listar'],
        ],
        [
            'text' => 'Todos los trámites',
            'route' => 'admin.all_procedures.index',
            'icon' => 'fa-solid fa-folder-open',
            'active' => 'admin/todos-los-tramites*',
            'can' => ['Todos los Trámites: Listar'],
        ],
        [
            'text' => 'Trámites oficina',
            'route' => 'admin.procedures_office.index',
            'icon' => 'fa-solid fa-building-circle-arrow-right',
            'active' => 'admin/tramites-mi-oficina*',
            'can' => ['Trámites de mi Oficina: Listar'],
        ],
        [
            'title' => 'RESOLUCIONES',
            'can' => ['Tipos de Resolución: Listar', 'Estados de Resolución: Listar', 'Resoluciones: Listar'],
        ],
        [
            'text' => 'Tipos de resolución',
            'route' => 'admin.resolution_types.index',
            'icon' => 'fa-solid fa-layer-group',
            'active' => 'admin/tipos-de-resolucion*',
            'can' => ['Tipos de Resolución: Listar'],
        ],
        [
            'text' => 'Estados de resolución',
            'route' => 'admin.resolution_states.index',
            'icon' => 'fa-solid fa-file-circle-question',
            'active' => 'admin/estados-de-resolucion*',
            'can' => ['Estados de Resolución: Listar'],
        ],
        [
            'text' => 'Resoluciones',
            'route' => 'admin.resolutions.index',
            'icon' => 'fa-solid fa-file-contract',
            'active' => 'admin/resoluciones*',
            'can' => ['Resoluciones: Listar'],
        ],
        [
            'title' => 'USUARIOS',
            'can' => ['Usuarios: Listar'],
        ],
        [
            'text' => 'Usuarios administrativos',
            'route' => 'admin.administrative_users.index',
            'icon' => 'fa-solid fa-user-tie',
            'active' => 'admin/usuarios-administrativos*',
            'can' => ['Usuarios: Listar'],
        ],
        [
            'text' => 'Usuarios públicos',
            'route' => 'admin.public_users.index',
            'icon' => 'fa-solid fa-user-tag',
            'active' => 'admin/usuarios-publicos*',
            'can' => ['Usuarios: Listar'],
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
