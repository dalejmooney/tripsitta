@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Parent',
])

@php
    $customTitle = $form_fields['fullname'];
    $countries = \App\Extensions\ExtCountries::getSelectList();
@endphp

@section('contentFields')
    @formField('input', [
    'name' => 'user.name',
    'label' => 'Name',
    'maxlength' => 250,
    ])

    @formField('input', [
    'name' => 'user.surname',
    'label' => 'Surname',
    'maxlength' => 250
    ])

    <div style="display:none; visibility: hidden">
        @formField('input', [
        'name' => 'user.dob',
        'label' => 'DOB',
        'withTime' => false
        ])
    </div>

    @formField('date_picker', [
    'name' => 'user.dob',
    'label' => 'DOB',
    'withTime' => false
    ])

    @formField('input', [
    'name' => 'user.email',
    'label' => 'E-mail',
    ])

    @formField('input', [
    'name' => 'user.phone_number',
    'label' => 'Phone number',
    ])

    @formField('input', [
    'name' => 'user.emergency_phone_number',
    'label' => 'Emergency phone number',
    ])

    @formField('select', [
        'name' => 'found_source',
        'label' => 'How did you hear about Tripsitta?',
        'options' => config('tripsitta.found_source')
    ])
@stop

@section('fieldsets')
    <a17-fieldset title="Children" id="children">
        <div style="margin-top:10px;">
            @formField('repeater', ['type' => 'child'])
        </div>

        @formField('input', [
            'name' => 'children_health_problems',
            'label' => 'Children allergies / health conditions',
            'type' => 'textarea'
        ])
    </a17-fieldset>
@endsection
