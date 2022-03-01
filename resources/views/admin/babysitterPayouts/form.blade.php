@extends('twill::layouts.form')

@php
    $customTitle = 'Payout ID '.(($form_fields['id']) ?? 'New');
    $editableTitle = false;
@endphp

@section('contentFields')
    <div class="tripsitta-content">
        <p class="is-bold row-title">Invoice Reference</p>
        <p>{{ $form_fields['invo_reference']}}</p>

        <p class="is-bold row-title">Total to pay to babysitter</p>
        <p>&euro; {{ $form_fields['total_to_pay']}}</p>
    </div>

    @if($form_fields['bank_details'])
        <div class="tripsitta-content">
            <p class="is-bold row-title">Selected Bank Details</p>
            @if($form_fields['bank_details']['deleted_at'] != '')
                Status: <span style="color:red">ARCHIVED</span>
            @else
                Status: CURRENT
            @endif
            <p>Currency: {{ $form_fields['bank_details']['currency']}}</p>
            @if($form_fields['bank_details']['currency'] === 'gbp')
                <p>Sort code: {{ $form_fields['bank_details']['sort_code']}}</p>
                <p>Account number: {{ $form_fields['bank_details']['account_number']}}</p>
            @elseif($form_fields['bank_details']['currency'] === 'chf')
                <p>IBAN: {{ $form_fields['bank_details']['iban']}}</p>
                <p>Town: {{ $form_fields['bank_details']['town']}}</p>
                <p>Postcode: {{ $form_fields['bank_details']['postcode']}}</p>
            @elseif($form_fields['bank_details']['currency'] === 'usd')
                <p>Routing number: {{ $form_fields['bank_details']['sort_code']}}</p>
                <p>Account number: {{ $form_fields['bank_details']['account_number']}}</p>
                <p>Address line 1: {{ $form_fields['bank_details']['address1']}}</p>
                <p>Address line 2: {{ $form_fields['bank_details']['address2']}}</p>
                <p>Town: {{ $form_fields['bank_details']['town']}}</p>
                <p>Postcode: {{ $form_fields['bank_details']['postcode']}}</p>
                <p>State: {{ $form_fields['bank_details']['state']}}</p>
                <p>Country: {{ $form_fields['bank_details']['country']}}</p>
            @else
                <p>IBAN: {{ $form_fields['bank_details']['iban']}}</p>
            @endif
        </div>
    @else
        <div class="tripsitta-content">
            <p class="is-bold row-title">Bank details</p>
            <p>Bank details not found !</p>
        </div>
    @endif

    @if(session('error_details'))
        <div class="notification is-danger has-margin-top-md">
            @foreach(session('error_details') as $error_detail)
                <p>{{$error_detail}}</p>
            @endforeach
        </div>
    @endif

    @formField('input', [
        'name' => 'amount_pounds',
        'label' => 'Amount currently paid',
    ])

    @formField('input', [
        'name' => 'transferwise_payment_id',
        'label' => 'Transferwise transfer ID',
    ])

    <p class="notification">
        You can pay the babysitter using Transferwise integration using button below.
        If you made a payment using different system, you can change the amount above and update the records manually.
    </p>

    @if($form_fields['amount'] > 0)
        <p class="is-bold">ERROR: You cannot process Transferwise payment if there is a manual payment already recorded</p>
    @elseif($form_fields['amount'] == 0 && $form_fields['bank_details']['deleted_at'] != '')
        <p class="is-bold">ERROR: You cannot process Transferwise payment. Selected bank details are marked as "Archived" by customer. Please confirm bank details with customer and process this payment manually.</p>
    @else
        <a href="{{route('admin.payout.pay', $form_fields['id'])}}" class="button button-admin-tripsitta has-margin-top-lg" style="display: block">Pay babysitter using Transferwise</a>
    @endif
@stop
