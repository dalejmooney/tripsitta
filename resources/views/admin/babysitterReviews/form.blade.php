@extends('twill::layouts.form')

@section('contentFields')
    @formField('browser', [
        'label' => 'Babysitter name',
        'max' => 1,
        'name' => 'babysitter',
        'moduleName' => 'babysitters'
    ])

    @formField('input', [
        'name' => 'description',
        'label' => 'Content',
        'maxlength' => 500,
        'type' => 'textarea'
    ])

    @formField('select', [
        'name' => 'score',
        'label' => 'Score',
        'placeholder' => 'Select the review score',
        'options' => [
            [
                'value' => 1,
                'label' => '1'
            ],
            [
                'value' => 2,
                'label' => '2'
            ],
            [
                'value' => 3,
                'label' => '3'
            ],
            [
                'value' => 4,
                'label' => '4'
            ],
            [
                'value' => 5,
                'label' => '5'
            ]
        ]
    ])

    @formField('browser', [
        'label' => 'Booking',
        'max' => 1,
        'name' => 'booking',
        'moduleName' => 'bookings',
        'routePrefix' => '',
    ])
@stop
