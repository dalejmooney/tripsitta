@php
$languages = ExtCountries::getSelectLanguagesList();
@endphp

@formField('select', [
    'name' => 'language_name',
    'label' => 'Language',
    'options' => $languages,
    'searchable' => true,
])

@formField('select', [
    'name' => 'language_level',
    'label' => 'Level',
    'options' => config('tripsitta.language_levels')
])
