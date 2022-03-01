@php
    $countries = \App\Extensions\ExtCountries::getSelectList();
@endphp

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

<p style="font-weight:bold; margin-bottom:-25px;">Place 1</p>
@formField('input', [
    'name' => 'place_1_name',
    'label' => 'Name',
])
@formField('select', [
    'name' => 'place_1_country',
    'label' => 'Country',
    'options' => $countries,
    'searchable' => true,
])
@formField('medias', [
    'name' => 'place_1_image',
    'label' => 'Image',
])

<p style="font-weight:bold; margin-bottom:-25px;">Place 2</p>
@formField('input', [
    'name' => 'place_2_name',
    'label' => 'Name',
])
@formField('select', [
    'name' => 'place_2_country',
    'label' => 'Country',
    'options' => $countries,
    'searchable' => true,
])
@formField('medias', [
    'name' => 'place_2_image',
    'label' => 'Image',
])

<p style="font-weight:bold; margin-bottom:-25px;">Place 3</p>
@formField('input', [
    'name' => 'place_3_name',
    'label' => 'Name',
])
@formField('select', [
    'name' => 'place_3_country',
    'label' => 'Country',
    'options' => $countries,
    'searchable' => true,
])
@formField('medias', [
    'name' => 'place_3_image',
    'label' => 'Image',
])

<p style="font-weight:bold; margin-bottom:-25px;">Place 4</p>
@formField('input', [
    'name' => 'place_4_name',
    'label' => 'Name',
])
@formField('select', [
    'name' => 'place_4_country',
    'label' => 'Country',
    'options' => $countries,
    'searchable' => true,
])
@formField('medias', [
    'name' => 'place_4_image',
    'label' => 'Image',
])
