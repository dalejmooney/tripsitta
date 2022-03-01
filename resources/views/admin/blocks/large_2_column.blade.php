@formField('select', [
    'name' => 'column_setup',
    'label' => 'Column setup',
    'placeholder' => 'Select column setup',
    'options' => [
        [
            'value' => 1,
            'label' => 'Left text, right image'
        ],
        [
            'value' => 2,
                'label' => 'Left image, right text'
        ]
    ]
])

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
])
@formField('select', [
    'name' => 'title_font_size',
    'label' => 'Title font size',
    'options' => [
        [
            'value' => 1,
            'label' => 'Large'
        ],
        [
            'value' => 2,
            'label' => 'Medium'
        ],
        [
            'value' => 3,
            'label' => 'Small'
        ],
    ]
])
@formField('color', [
    'name' => 'title_font_colour',
    'label' => 'Title font colour',
])
@formField('color', [
    'name' => 'title_line_colour',
    'label' => 'Title line colour',
])

@formField('wysiwyg', [
    'name' => 'content',
    'label' => 'Content',
    'maxlength' => 500,
    'toolbarOptions' => [
        'bold',
        'italic',
        'underline',
        'strike',
        ["color" => []],
        ["script" => "super"],
        ["script" => "sub"],
        'link',
        "clean",
    ],
])

@formField('medias', [
    'name' => 'cover',
    'label' => 'Image',
])

@formField('input', [
    'name' => 'button_text',
    'label' => 'Button text',
])
@formField('select', [
    'name' => 'button_style',
    'label' => 'Button style',
    'options' => [
        [
            'value' => 'primary',
            'label' => 'Primary'
        ],
        [
            'value' => 'secondary',
            'label' => 'Secondary'
        ],
        [
            'value' => 'dark',
            'label' => 'Dark'
        ],
        [
            'value' => 'primary_outlined',
            'label' => 'Primary outlined'
        ],
        [
            'value' => 'secondary_outlined',
            'label' => 'Secondary outlined'
        ],
        [
            'value' => 'dark_outlined',
            'label' => 'Dark outlined'
        ],
    ]
])


@formField('browser', [
    'routePrefix' => 'cms',
    'moduleName' => 'pages',
    'name' => 'page_url',
    'label' => 'Button page url',
    'max' => 1
])
