<?php
return [
    'enabled' => [
        'buckets' => true,
        'search' => true,
    ],
    'media_library' => [
        'disk' => 'public',
        'endpoint_type' => env('MEDIA_LIBRARY_ENDPOINT_TYPE', 's3'),
        'cascade_delete' => env('MEDIA_LIBRARY_CASCADE_DELETE', false),
        'local_path' => env('MEDIA_LIBRARY_LOCAL_PATH'),
        'image_service' => env('MEDIA_LIBRARY_IMAGE_SERVICE', 'A17\Twill\Services\MediaLibrary\Imgix'),
        'acl' => env('MEDIA_LIBRARY_ACL', 'private'),
        'filesize_limit' => env('MEDIA_LIBRARY_FILESIZE_LIMIT', 50),
        'allowed_extensions' => ['svg', 'jpg', 'gif', 'png', 'jpeg'],
        'init_alt_text_from_filename' => true,
        'translated_form_fields' => false,
    ],
    'block_editor' => [
        'block_single_layout' => 'layouts.block',
        'block_views_path' => 'layouts/blocks',
        'blocks' => [
            'text' => [
                'title' => 'Body text',
                'icon' => 'text',
                'component' => 'a17-block-text',
            ],
            'image' => [
                'title' => 'Image',
                'icon' => 'image',
                'component' => 'a17-block-image',
            ],
            'large_2_column' => [
                'title' => '2 columns (img+txt)',
                'icon' => 'text-2col',
                'component' => 'a17-block-large_2_column',
            ],
            'text_2_column' => [
                'title' => '2 columns (txt)',
                'icon' => 'text-2col',
                'component' => 'a17-block-text_2_column',
            ],
            'asymmetric_2_columns' => [
                'title' => 'Asymmetric 2 columns (img+txt)',
                'icon' => 'text-2col',
                'component' => 'a17-block-asymmetric_2_columns',
            ],
            'text_3_column' => [
                'title' => '3 columns (txt)',
                'icon' => 'text-2col',
                'component' => 'a17-block-text_3_column',
            ],
            'special_3_columns' => [
                'title' => '3 columns special',
                'icon' => 'text-2col',
                'component' => 'a17-block-special_3_columns',
            ],
            'tripsitta_slogan' => [
                'title' => 'Tripsitta slogan',
                'icon' => 'text',
                'component' => 'a17-block-tripsitta_slogan',
            ],
            'divider' => [
                'title' => 'Divider',
                'icon' => 'image',
                'component' => 'a17-block-divider',
            ],
            'featured_elements' => [
                'title' => 'Featured element',
                'icon' => 'text-2col',
                'component' => 'a17-block-featured_elements',
            ],
            'featured_places' => [
                'title' => 'Featured places',
                'icon' => 'text-2col',
                'component' => 'a17-block-featured_places',
            ],
            'how_tripsitta_works' => [
                'title' => 'How Tripsitta Works',
                'icon' => 'text-2col',
                'component' => 'a17-block-how_tripsitta_works',
            ],
            'quote' => [
                'title' => 'Quote',
                'icon' => 'quote',
                'component' => 'a17-block-quote',
            ],
            'contact_form' => [
                'title' => 'Contact form',
                'icon' => 'text',
                'component' => 'a17-block-contact_form',
            ],
        ],
        'crops' => [
            'cover' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => 0,
                        'minValues' => [
                            'width' => 100,
                            'height' => 100,
                        ],
                    ],
                ],
            ],
            'left_column_image' => [ // role name
                'default' => [ // crop name
                    [
                        'name' => 'default', // ratio name, same as crop name if single
                        'ratio' => 1 / 1, // ratio as a fraction or number
                    ],
                ],
            ],
            'middle_column_image' => [ // role name
                'default' => [ // crop name
                    [
                        'name' => 'default', // ratio name, same as crop name if single
                        'ratio' => 1 / 1, // ratio as a fraction or number
                    ],
                ],
            ],
            'right_column_image' => [ // role name
                'default' => [ // crop name
                    [
                        'name' => 'default', // ratio name, same as crop name if single
                        'ratio' => 1 / 1, // ratio as a fraction or number
                    ],
                ],
            ],
            'place_1_image' => [ // role name
                'default' => [ // crop name
                    [
                        'name' => 'default', // ratio name, same as crop name if single
                        'ratio' => 1, // ratio as a fraction or number
                    ],
                ],
            ],
            'place_2_image' => [ // role name
                'default' => [ // crop name
                    [
                        'name' => 'default', // ratio name, same as crop name if single
                        'ratio' => 1, // ratio as a fraction or number
                    ],
                ],
            ],
            'place_3_image' => [ // role name
                'default' => [ // crop name
                    [
                        'name' => 'default', // ratio name, same as crop name if single
                        'ratio' => 1, // ratio as a fraction or number
                    ],
                ],
            ],
            'place_4_image' => [ // role name
                'default' => [ // crop name
                    [
                        'name' => 'default', // ratio name, same as crop name if single
                        'ratio' => 1, // ratio as a fraction or number
                    ],
                ],
            ],
        ],
        'browser_route_prefixes' => [
            'pages' => 'cms',
        ],
        'repeaters' => [
            'language' => [
                'title' => 'Language',
                'trigger' => 'Add language',
                'component' => 'a17-block-language'
            ],
            'child' => [
                'title' => 'Child',
                'trigger' => 'Add child',
                'component' => 'a17-block-child'
            ],
        ],
    ],
    'buckets' => [
        'menu' => [
            'name' => 'Menu',
            'buckets' => [
                'primary_menu' => [
                    'name' => 'Primary navigation',
                    'bucketables' => [
                        [
                            'module' => 'pages',
                            'name' => 'Pages',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 10,
                ],
            ],
        ],
        'explore_menu' => [
            'name' => 'Submenu - Explore',
            'buckets' => [
                'ex_1' => [
                    'name' => 'Booking process',
                    'bucketables' => [
                        [
                            'module' => 'pages',
                            'name' => 'Pages',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 5,
                ],
                'ex_2' => [
                    'name' => 'Guidelines',
                    'bucketables' => [
                        [
                            'module' => 'pages',
                            'name' => 'Pages',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 5,
                ],
                'ex_3' => [
                    'name' => 'About us',
                    'bucketables' => [
                        [
                            'module' => 'pages',
                            'name' => 'Pages',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 5,
                ],
            ],
        ],
    ],
    'bucketsRoutes' => [
        'menu' => 'cms.menus',
        'explore_menu' => 'cms.menus',
    ],
];
