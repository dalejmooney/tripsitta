@extends('twill::layouts.form', [
    'contentFieldsetLabel' => 'Booking Overview',
])

@php
    $customTitle = 'Booking '. 'T'.str_pad($form_fields['id'], 5, '0', STR_PAD_LEFT);
    $countries = \App\Extensions\ExtCountries::getSelectList();
@endphp

@section('contentFields')
    @formField('select', [
        'name' => 'status_id',
        'label' => 'Status',
        'options' => $form_fields['statusList']
    ])

    @formField('date_picker', [
        'name' => 'completed_at',
        'label' => 'Booking marked as completed by both parties at',
    ])

    @formField('date_picker', [
        'name' => 'parent_completed_at',
        'label' => 'Parent marked booking as completed at',
    ])

    @formField('date_picker', [
        'name' => 'babysitter_completed_at',
        'label' => 'Babysitter marked booking as completed at',
    ])

    <p style="background: rgb(229, 229, 229); padding:15px;">"Completed booking" means it reached one of it's final statuses (cancelled or completed) and both babysitter and parent are happy with the outcome <br />
        When you mark booking as cancelled or completed, system assumes you already confirmed it with both parties and marks it for you. </p>

    <div class="row has-margin-top">
        <div class="column">
            <p class="is-bold">Booking ID:</p>
            <p>{{$form_fields['id']}}</p>
        </div>
        <div class="column">
            <p class="is-bold">Booking type:</p>
            <p>{{$form_fields['type']}}</p>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <p class="is-bold">Start date</p>
            <p>{{ (new \Illuminate\Support\Carbon($form_fields['start']))->format('d/m/y H:i')}}</p>
        </div>
        <div class="column">
            <p class="is-bold">End date</p>
            <p>{{ (new \Illuminate\Support\Carbon($form_fields['end']))->format('d/m/y H:i')}}</p>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <p class="is-bold">Booking duration</p>
            <p>{{$form_fields['booking_duration']}}</p>
        </div>
        @if($form_fields['type'] === 'babysitter')
            <div class="column">
                <p class="is-bold">Booking address</p>
                @if(!$form_fields['booking_address_id'])
                    <p>Not provided by customer</p>
                @else
                    <p>{{$form_fields['booking_address']['building'] ?: '' }}</p>
                    <p>{{$form_fields['booking_address']['address1'] ?: '' }}</p>
                    <p>{{$form_fields['booking_address']['address2'] ?: '' }}</p>
                    <p>{{$form_fields['booking_address']['town'] ?: '' }}</p>
                    <p>{{$form_fields['booking_address']['postcode'] ?: '' }}</p>
                    <p>{{$form_fields['booking_address']['country'] ? Countries::getOne($form_fields['booking_address']['country']) : '' }}</p>
                @endif
            </div>
        @endif
    </div>

    @if($form_fields['type'] === 'holiday_nanny')
        <div class="row">
            <div class="column">
                <p class="is-bold">Start location</p>
                <p><span class="small-inline-label">Country:</span> {{$form_fields['start_location'] ? Countries::getOne($form_fields['start_location']) : '' }}</p>
                <p><span class="small-inline-label">Airport:</span> {{$form_fields['start_location_airport'] ?: ''}}</p>
            </div>
            <div class="column">
                <p class="is-bold">End location</p>
                <p><span class="small-inline-label">Country:</span> {{$form_fields['end_location'] ? Countries::getOne($form_fields['end_location']) : '' }}</p>
                <p><span class="small-inline-label">Town:</span> {{$form_fields['destination_town'] ?: ''}}</p>
            </div>
        </div>

        <div class="row">
            <div class="column">
                <p class="is-bold">Accommodation details</p>
                <p>{{$form_fields['accommodation_details'] ?: 'Details not provided' }}</p>
            </div>
            @if($form_fields['babysitter_meet'] === 1)
            <div class="column">
                <p class="is-bold">Parent requested to meet babysitter in destination country</p>
                <p>{{$form_fields['babysitter_meet_details'] ?: 'Details not provided' }}</p>
            </div>
            @endif
        </div>

        @if($form_fields['travel_trip'] === 1)
        <div class="row">
            <div class="column">
                <p class="is-bold">Parent marked this booking as "Travel trip"</p>
                <p>{{$form_fields['travel_trip_details'] ?: 'Details not provided' }}</p>
            </div>
        </div>
        @endif
    @endif

    <div class="row">
        <div class="column">
            <p class="is-bold">Customer notes</p>
            <p>{{$form_fields['booking_notes'] ?? 'N/A'}}</p>
        </div>
    </div>
@stop

@section('fieldsets')
    <a17-fieldset title="Parent" id="parent" :open="false">
        <div class="tripsitta-content">
            <p class="is-bold row-title">Name</p>
            <p><a href="{{route('admin.families.show', $form_fields['family_id'])}}">{{ $form_fields['family']['user']['name'] }} {{ $form_fields['family']['user']['surname'] }}</a></p>

            <p class="is-bold row-title">No of previous bookings</p>
            <p>{{ $form_fields['family']['count_prev_bookings']}}</p>

            <p class="is-bold row-title">Main phone number</p>
            <p>{{ $form_fields['family']['user']['phone_number'] ?: 'N/A' }} @if($form_fields['contactable_main_phone_number'] == 0) (May be unavailable during this booking) @endif</p>

            <p class="is-bold row-title">Alternative phone number</p>
            <p>{{ $form_fields['alternative_phone_number'] ?: 'N/A' }}</p>

            <p class="is-bold row-title">Parent location during booking period</p>
            <p>{{ $form_fields['parent_location_during_booking'] ?: 'N/A' }}</p>
        </div>
    </a17-fieldset>

    <a17-fieldset title="Children" id="children" :open="false">
        <div class="tripsitta-content">
            <p class="is-bold row-title">Children</p>
            @foreach($form_fields['booking_children'] as $child)
                <p>{{ucwords($child['name'])}} (dob {{ (new \Illuminate\Support\Carbon($child['dob']))->format('d/m/y')}})</p>
            @endforeach

            <p class="is-bold row-title">Children allergies / health conditions</p>
            <p>{{$form_fields['family']['children_health_problems'] ?? 'N/A'}}</p>
        </div>
    </a17-fieldset>

    <a17-fieldset title="Emergency contact" id="emergency" :open="false">
        <div class="tripsitta-content">
            <p class="is-bold row-title">Name</p>
            <p>{{ $form_fields['family']['user']['emergency_name'] ?: 'N/A' }}</p>

            <p class="is-bold row-title">Relationship</p>
            <p>{{ $form_fields['family']['user']['emergency_relationship'] ?: 'N/A'  }}</p>

            <p class="is-bold row-title">Phone number</p>
            <p>{{ $form_fields['family']['user']['emergency_phone_number'] ?: 'N/A' }} @if($form_fields['contactable_emergency_phone_number'] == 0) (May be unavailable during this booking) @endif</p>
        </div>
    </a17-fieldset>

    <a17-fieldset title="Babysitter" id="babysitter" :open="false">
        <div class="tripsitta-content">
            <p class="is-bold row-title">Name</p>
            <p><a href="{{route('admin.b.babysitters.show', $form_fields['babysitter_id'])}}">{{ $form_fields['babysitter']['user']['name'] }} {{ $form_fields['babysitter']['user']['surname'] }}</a></p>

            <p class="is-bold row-title">No of previous bookings</p>
            <p>{{ $form_fields['babysitter']['count_prev_bookings']}}</p>

            <p class="is-bold row-title">Rating</p>
            <p><a href="{{route('admin.b.babysitterReviews.index') . '?filter={"status":"all","search":"id:'.$form_fields['babysitter']['id'].'"}'}}">{{ $form_fields['babysitter']['reviews'] }} / 5 ( {{ $form_fields['babysitter']['reviews_count'] }} reviews)</a></p>
        </div>
    </a17-fieldset>


    <a17-fieldset title="Invoices ({{$form_fields['invoices']->count()}} invoices raised)" id="invoices" :open="false">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Invoice reference</th>
                    <th>Type</th>
                    <th>Invoice Total</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Earnings (B|A)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($form_fields['invoices'] as $invoice)
                <tr>
                    <td>{{$invoice->reference}}</td>
                    <td>{{$invoice->type}}</td>
                    <td>&euro; {{number_format($invoice->amountDueInPounds, 2)}}</td>
                    <td>&euro; {{number_format($invoice->amountPaidInPounds, 2)}}</td>
                    @if($invoice->balanceInPounds <> 0)
                        <td style="color:red;">&euro; {{number_format($invoice->balanceInPounds, 2)}}</td>
                    @else
                        <td>&euro; {{number_format($invoice->balanceInPounds, 2)}}</td>
                    @endif
                    <td>&euro; {{number_format($invoice->babysitterEarningsInPounds, 2)}} | &euro; {{number_format($invoice->adminEarningsInPounds, 2)}}</td>
                    <td><a href="{{route('admin.invoices.show', [$invoice->id])}}">View</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No invoices raised yet</td>
                </tr>
            @endforelse
            </tbody>
            @if($form_fields['invoices']->count() > 0)
            <tfoot>
                <tr>
                    <td colspan="2">Total</td>
                    <td>&euro; {{number_format($form_fields['invoices']->sum('amount_due') / 100, 2)}}</td>
                    <td>&euro; {{number_format($form_fields['invoices']->sum('amount_paid') / 100, 2)}}</td>
                    @if($invoice->balanceInPounds <> 0)
                        <td style="color:red">&euro; {{number_format(($form_fields['invoices']->sum('amount_paid') - $form_fields['invoices']->sum('amount_due')) / 100, 2)}}</td>
                    @else
                        <td>&euro; {{number_format(($form_fields['invoices']->sum('amount_paid') - $form_fields['invoices']->sum('amount_due')) / 100, 2)}}</td>
                    @endif
                    <td>&euro; {{number_format($invoice->babysitterEarningsForBookingInPounds, 2)}} | &euro; {{number_format($invoice->adminEarningsForBookingInPounds, 2)}}</td>
                    <td>&nbsp;</td>
                </tr>
            </tfoot>
            @endif
        </table>
        <a href="" class="button button-admin-tripsitta has-margin-top-lg" style="display: block">Add/Edit invoices for this booking</a>
    </a17-fieldset>
@stop

@prepend('extra_css')

@endprepend
