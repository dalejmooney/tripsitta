@formField('input', [
    'name' => 'small_title',
    'label' => 'Small title',
])

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
])

@formField('input', [
    'name' => 'bullet_1',
    'label' => 'Bullet 1',
])
@formField('input', [
    'name' => 'bullet_2',
    'label' => 'Bullet 2',
])
@formField('input', [
    'name' => 'bullet_3',
    'label' => 'Bullet 3',
])
@formField('input', [
    'name' => 'bullet_4',
    'label' => 'Bullet 4',
])

@formField('medias', [
    'name' => 'cover',
    'label' => 'Image',
])

@formField('wysiwyg', [
    'name' => 'content',
    'label' => 'Content',
    'maxlength' => 750,
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


