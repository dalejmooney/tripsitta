@extends('twill::layouts.form')

@php
    $countries = \App\Extensions\ExtCountries::getSelectList();
@endphp

@section('contentFields')

    <div class="tripsitta-content">
        <p class="is-bold row-title">Invoice Reference</p>
        <p>{{ $form_fields['reference']}}</p>

        <p class="is-bold row-title">Invoice type</p>
        <p>{{ $form_fields['type']}}</p>

        <p class="is-bold row-title">Created at</p>
        <p>{{ $form_fields['created_at']}}</p>

        <p class="is-bold row-title">Booking ID</p>
        <p><a href="{{route('admin.bookings.show', $form_fields['booking_id'])}}">{{ $form_fields['booking']['idPadded']}}</a></p>

        @formField('input', [
            'name' => 'description',
            'label' => 'Description',
            'maxlength' => 1500,
            'type' => 'textarea',
            'rows' => 3
        ])

        @formField('input', [
            'name' => 'invoice.amountDueInPounds',
            'label' => 'Amount due',
        ])

        @formField('input', [
            'name' => 'invoice.amountPaidInPounds',
            'label' => 'Amount paid',
        ])

        @formField('date_picker', [
            'name' => 'paid_at',
            'label' => 'Paid at',
            'note' => "This field will default to current date and time if you mark invoice as fully paid above",
        ])
    </div>

    <p class="has-margin-top-xl"><a href="{{route('admin.invoice.showInvoice', [$form_fields['id'], 'parent'])}}" class="button-admin-tripsitta">View customer invoice</a>
        <a href="{{route('admin.invoice.showInvoice', [$form_fields['id'], 'babysitter'])}}" class="button-admin-tripsitta">View babysitter invoice</a>
        <a href="{{route('admin.invoice.showInvoice', [$form_fields['id'], 'admin'])}}" class="button-admin-tripsitta">View admin invoice</a></p>
@stop

@section('fieldsets')
    <a17-fieldset title="Parent - invoice address" id="parent" :open="false">
        @formField('input', [
            'name' => 'invoice.family_address.address1',
            'label' => 'Address 1',
            'required' => true,
        ])
        @formField('input', [
            'name' => 'invoice.family_address.address2',
            'label' => 'Address 2',
        ])
        @formField('input', [
            'name' => 'invoice.family_address.town',
            'label' => 'Town',
            'required' => true,
        ])
        @formField('input', [
            'name' => 'invoice.family_address.postcode',
            'label' => 'Postcode',
            'required' => true,
        ])
        @formField('select', [
            'name' => 'invoice.family_address_country',
            'label' => 'Country',
            'options' => $countries,
            'searchable' => true,
            'required' => true,
        ])
    </a17-fieldset>

    <a17-fieldset title="Babysitter - invoice address" id="babysitter" :open="false">
        @formField('input', [
        'name' => 'invoice.babysitter_address.address1',
        'label' => 'Address 1',
        'required' => true,
        ])
        @formField('input', [
        'name' => 'invoice.babysitter_address.address2',
        'label' => 'Address 2',
        ])
        @formField('input', [
        'name' => 'invoice.babysitter_address.town',
        'label' => 'Town',
        'required' => true,
        ])
        @formField('input', [
        'name' => 'invoice.babysitter_address.postcode',
        'label' => 'Postcode',
        'required' => true,
        ])
        @formField('select', [
        'name' => 'invoice.babysitter_address_country',
        'label' => 'Country',
        'options' => $countries,
        'searchable' => true,
        'required' => true,
        ])
    </a17-fieldset>
@endsection
