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
            'icon' => 'cil-speedometer',
            'active' => 'admin/dashboard*',
            // 'can' => ['view-colors'],
        ],
        [
            'text' => 'Tipos de documentos',
            'route' => 'admin.document_types.index',
            'icon' => 'cil-speedometer',
            'active' => 'admin/tipos-de-documentos*',
            // 'can' => ['view-colors'],
        ],
        [
            'text' => 'Buttons',
            'icon' => 'cil-cursor',
            // 'can' => ['view-buttons'],
            'submenu' => [
                [
                    'text' => 'Buttons',
                    'route' => 'dashboard',
                    'active' => 'buttons/index*',
                    // 'can' => ['view-buttons-simple'],
                    'badge' => null,
                ],
                [
                    'text' => 'Dropdowns',
                    'url' => 'https://example.com/dropdowns',
                    'active' => 'buttons/dropdowns.html',
                    // 'can' => ['view-dropdowns', 'manage-dropdowns'],
                    'badge' => [
                        'text' => 'PRO',
                        'class' => 'badge-sm bg-danger ms-auto',
                    ],
                ],
            ],
        ],
    ]
];
