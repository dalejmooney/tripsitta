@formField('wysiwyg', [
    'name' => 'html',
    'label' => 'Text',
    'maxlength' => 5000,
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
