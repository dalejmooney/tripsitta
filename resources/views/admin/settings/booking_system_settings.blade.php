@extends('twill::layouts.settings')

@section('contentFields')
    <p>All prices in € (EUR)</p>
    @formField('input', [
        'label' => 'Babysitter base price',
        'name' => 'babysitter_base_price',
        'textLimit' => '20',
        'type' => 'number',
    ])

    @formField('input', [
        'label' => 'Babysitter extra per child',
        'name' => 'babysitter_extra_per_child',
        'textLimit' => '20',
        'type' => 'number',
    ])

    @formField('input', [
        'label' => 'Holiday nanny base price',
        'name' => 'holiday_nanny_base_price',
        'textLimit' => '20',
        'type' => 'number',
    ])

    @formField('input', [
        'label' => 'Holiday nanny extra per child',
        'name' => 'holiday_nanny_extra_per_child',
        'textLimit' => '20',
        'type' => 'number',
    ])

    @formField('input', [
        'label' => 'Commission - Babysitter jobs (%)',
        'name' => 'babysitter_commission_percentage',
        'textLimit' => '3',
        'type' => 'number',
        'note' => 'Percentage that you earn of each booking',
    ])

    @formField('input', [
        'label' => 'Commission - Holiday nanny jobs (%)',
        'name' => 'holiday_nanny_commission_percentage',
        'textLimit' => '3',
        'type' => 'number',
        'note' => 'Percentage that you earn of each booking',
    ])
@stop
