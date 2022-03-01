@formField('input', [
    'name' => 'title_left',
    'label' => 'Left column title',
])
@formField('wysiwyg', [
    'name' => 'content_left',
    'label' => 'Left column content',
    'maxlength' => 1000,
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
    'name' => 'title_right',
    'label' => 'Right column title',
])

@formField('wysiwyg', [
    'name' => 'content_right',
    'label' => 'Right column content',
    'maxlength' => 1000,
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
