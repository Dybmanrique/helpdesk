<?php

return [
    'sidebar' => [
        [
            'title' => 'DASHBOARD',
            // 'can' => ['manage-theme', 'view-dashboard'],
        ],
        [
            'text' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'cil-speedometer',
            'active' => 'ejemplo-dashboard*',
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
