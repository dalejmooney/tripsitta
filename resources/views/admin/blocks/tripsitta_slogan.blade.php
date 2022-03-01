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
