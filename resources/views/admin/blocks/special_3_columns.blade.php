@formField('input', [
    'name' => 'small_title',
    'label' => 'Small title',
])

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
])

@formField('select', [
    'name' => 'images_shape',
    'label' => 'Shape of images',
    'placeholder' => 'Select image shape',
    'options' => [
        [
            'value' => 1,
            'label' => 'Circle'
        ],
        [
            'value' => 2,
            'label' => 'Square'
        ]
    ]
])

@formField('medias', [
    'name' => 'left_column_image',
    'label' => 'Image left column',
])

@formField('input', [
    'name' => 'left_column_subheading',
    'label' => 'Subheading left column',
])

@formField('wysiwyg', [
    'name' => 'left_column_content',
    'label' => 'Content left column',
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
    'name' => 'middle_column_image',
    'label' => 'Image middle column',
])

@formField('input', [
    'name' => 'middle_column_subheading',
    'label' => 'Subheading middle column',
])

@formField('wysiwyg', [
    'name' => 'middle_column_content',
    'label' => 'Content middle column',
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
    'name' => 'right_column_image',
    'label' => 'Image right column',
])

@formField('input', [
    'name' => 'right_column_subheading',
    'label' => 'Subheading right column',
])

@formField('wysiwyg', [
    'name' => 'right_column_content',
    'label' => 'Content right column',
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
