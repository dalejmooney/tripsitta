<?php

return [
    'cms' => [
        'title' => 'CMS',
        'route' => 'admin.cms.pages.index',
        'primary_navigation' => [
            'pages' => [
                'title' => 'Pages',
                'module' => true,
            ],
            'posts' => [
                'title' => 'Blog',
                'module' => true,
            ],
            'slideshows' => [
                'title' => 'Slideshows',
                'module' => true,
            ],
            'menus' => [
                'title' => 'Menus',
                'route' => 'admin.cms.menus.menu',
                'secondary_navigation' => [
                    'menu' => [
                        'title' => 'Primary',
                        'route' => 'admin.cms.menus.menu',
                    ],
                    'explore_menu' => [
                        'title' => 'Submenu - Explore',
                        'route' => 'admin.cms.menus.explore_menu',
                    ],
                ]
            ],
        ]
    ],
    'bookings' => [
        'title' => 'Bookings',
        'module' => true,
        'primary_navigation' => [
            'bookings' => [
                'title' => 'Overview',
                'route' => 'admin.bookings.index',
            ],
            'settings' => [
                'title' => 'Settings',
                'route' => 'admin.settings',
                'params' => ['section' => 'booking_system_settings']
            ],
        ],
    ],

    'invoices' => [
        'title' => 'Invoices',
        'module' => true
    ],

    'b' => [
        'title' => 'Babysitters',
        'route' => 'admin.b.babysitters.index',
        'primary_navigation' => [
            'babysitters' => [
                'title' => 'Overview',
                'module' => true,
            ],
            'babysitter_payouts' => [
                'title' => 'Payouts',
                'module' => true,
            ],
            'babysitterReviews' => [
                'title' => 'Reviews',
                'module' => true,
            ],
            'interviews-calendar' => [
                'title' => 'Interviews Calendar',
                'route' => 'admin.b.interviews-calendar'
            ],
            'payouts-profiles' => [
                'title' => 'Transferwise status',
                'route' => 'admin.b.payout.transferwise'
            ],
        ]
    ],

    'families' => [
        'title' => 'Parents',
        'module' => true,
        'primary_navigation' => [
            'families' => [
                'title' => 'Overview',
                'route' => 'admin.families.index',
            ]
        ],
    ],

    'chats' => [
        'title' => 'Chats',
        'module' => true
    ],
];
