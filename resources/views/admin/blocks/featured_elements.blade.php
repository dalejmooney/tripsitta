@formField('input', [
    'name' => 'small_title',
    'label' => 'Small title',
])

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
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

@formField('browser', [
    'label' => 'Babysitters',
    'max' => 4,
    'name' => 'babysitter',
    'moduleName' => 'babysitters'
])
