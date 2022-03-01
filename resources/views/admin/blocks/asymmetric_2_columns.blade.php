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
    'name' => 'small_title',
    'label' => 'Small title',
])

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
])

@formField('medias', [
    'name' => 'cover',
    'label' => 'Image',
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

@formField('input', [
    'name' => 'button_text',
    'label' => 'Button text',
])

@formField('browser', [
    'routePrefix' => 'cms',
    'moduleName' => 'pages',
    'name' => 'pages',
    'label' => 'Button url',
    'max' => 1
])
