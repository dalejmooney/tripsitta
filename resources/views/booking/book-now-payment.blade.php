@extends('layouts.app')

@section('meta_title') @endsection
@section('meta_desc') @endsection

@section('scripts')
    @if($type === 'babysitter')
        <script src="{{ mix('js/pages/book-now-payment.js') }}"></script>
    @else
        <script src="{{ mix('js/pages/book-now-payment-hn.js') }}"></script>
    @endif
    <script src="{{ mix('js/helpers.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="application/javascript">
        var stripe = Stripe('{{config('tripsitta.stripe.publishable')}}');
        var CHECKOUT_SESSION_ID = '{{$stripe_session_id}}';
    </script>
@endsection

@php
   $booking_type_text_class = ($type === 'babysitter') ? 'has-text-secondary' : 'has-text-primary';
   $booking_type_el_class = ($type === 'babysitter') ? 'is-secondary' : 'is-primary';
@endphp

@section('content')
    <div id="app-content">
        <div class="container">
            <div class="is-pulled-right is-hidden-mobile has-margin-top-md" data-tooltip="Current step: 2 / 3">
                <i class="icon-number is-small is-inline-block {{$booking_type_el_class}}">1</i> <i class="icon-number is-small is-inline-block {{$booking_type_el_class}} is-active">2</i> <i class="icon-number is-small is-inline-block is-grey">3</i>
            </div>

            @if($type === 'babysitter')
                <h1 class="title has-text-secondary">Your new booking</h1>
                <p class="subtitle">Book your babysitter now</p>
            @else
                <h1 class="title has-text-primary">Your new booking</h1>
                <p class="subtitle">Book your holiday nanny now</p>
            @endif
                <div class="columns has-margin-top-md">
                    @include('booking.partials.information-block')

                    <div class="column is-8-tablet is-9-widescreen">
                        <div id="errors-container" class="notification is-danger is-hidden"></div>

                        <h2 class="title is-4 {{$booking_type_text_class}}">Booking confirmation and payment</h2>

                        @if ($errors->any())
                            <div class="notification is-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{$error}}</p>
                                @endforeach
                            </div>
                        @endif

                        @if($stripe_session_id === null)
                            <div class="notification is-danger">
                                <p>We are sorry but we cannot process a booking at the moment due to a technical error. Please contact us if the problem persists!</p>
                            </div>
                        @endif

                        <p>Our website allows you to pay with most of credit or debit cards. We do not store any credit card details in our systems.</p>
                        <p class="has-margin-top-sm">The money are held securely by Tripsitta and released the moment both, you and babysitter, confirm that the booking was completed. <br />Please read our full guide for parents to understand how it functions and what Tripsitta does to keep you safe.  </p>

                        <form method="post" name="book-now-payment">
                            @if($type === 'babysitter')
                            <h2 class="title is-4 has-margin-top-lg {{$booking_type_text_class}}">Booking location</h2>
                            <p class="subtitle is-6 has-text-weight-bold">Please select an address where the babysitting will take place  *</p>

                            <div id="select_address" class="buttons is-option-selector">
                                @foreach(['home' => 'Home address', 'new' => 'New address', 'not_sure' => "Not sure, I'll confirm it later"] as $value => $string)
                                    <button type="button"  class="button
                                        {{ array_key_exists('address_type', session()->get('booking_session')) && session()->get('booking_session')['address_type'] == $value ? 'is-selected is-dark' : '' }}
                                    " data-value="{{$value}}">{{$string}}</button>
                                @endforeach
                                    <input type="hidden" name="address_type" value="{{ array_key_exists('booking_address', session()->get('booking_session')) ? session()->get('booking_session')['address_type'] : '' }}"/>
                            </div>

                            <div id="new_address" {!! array_key_exists('address_type', session()->get('booking_session')) && session()->get('booking_session')['address_type'] == 'new' ? '' : 'class="is-hidden"'!!}>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Building name / room number</label>
                                        <input class="input" type="text" name="bookingAddress[building]" placeholder="" value="">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">House number and street name *</label>
                                        <input class="input" type="text" name="bookingAddress[address1]" placeholder="" value="">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Extra address line </label>
                                        <input class="input" type="text" name="bookingAddress[address2]" placeholder="" value="">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Town *</label>
                                        <input class="input" type="text" name="bookingAddress[town]" placeholder="" value="">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Postcode *</label>
                                        <input class="input" type="text" name="bookingAddress[postcode]" placeholder="" value="">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Country *</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select class="is-country-selector" name="bookingAddress[country]">
                                                    <option data-code="EMPTY" value="">Select your country</option>
                                                    <option disabled>──────────</option>
                                                    @foreach($countries as $code => $country)
                                                        <option value="{{strtolower($code)}}">{{$country}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                                <h2 class="title is-4 has-margin-top-lg {{$booking_type_text_class}}">Travel information</h2>

                                @if($babysitter->babysitter->mainAddress->country === $start_location->get('country_code'))
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Which airport will you be travelling from?  *</label>
                                            <input class="input" type="text" name="start_location_airport" placeholder="" value="{{ array_key_exists('start_location_airport', session()->get('booking_session')) ? session()->get('booking_session')['start_location_airport'] : '' }}" required>
                                        </div>
                                    </div>
                                @endif

                                <label class="label">Where will your family be travelling?  *</label>
                                <div class="field has-addons">
                                    <p class="control">
                                        <a class="button is-static">
                                            <i class="flag-icon flag-icon-squared is-country flag-icon-{{strtolower($end_location->get('country_code'))}}"></i>
                                            <span class="is-inline-country-name has-padding-left-md">{{$end_location->get('country_name')}}</span>
                                        </a>
                                    </p>
                                    <div class="control is-expanded">
                                        <input class="input" type="text" name="destination_town" placeholder="Town/City name" value="{{ array_key_exists('destination_town', session()->get('booking_session')) ? session()->get('booking_session')['destination_town'] : '' }}" required>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <label class="label">Have you booked your accommodation? *</label>
                                        <label class="radio">
                                            <input type="radio" value="1" name="accommodation_booked"
                                                {{ array_key_exists('accommodation_booked', session()->get('booking_session')) && session()->get('booking_session')['accommodation_booked'] === '1' ? 'checked="checked"' : '' }}>
                                            Yes
                                        </label>
                                        <label class="radio">
                                            <input type="radio" value="0" name="accommodation_booked"
                                                {{ array_key_exists('accommodation_booked', session()->get('booking_session')) && session()->get('booking_session')['accommodation_booked'] === '0' ? 'checked="checked"' : '' }}>
                                            No
                                        </label>
                                    </div>
                                </div>

                                <div id="toggle_accommodation_details" class="field {{ array_key_exists('accommodation_booked', session()->get('booking_session')) && session()->get('booking_session')['accommodation_booked'] === '1' ? '' : 'is-hidden' }}">
                                    <div class="control">
                                        <label class="label">Please provide the accommodation name and address</label>
                                        <textarea class="textarea" name="accommodation_details" rows="2" placeholder="">{{ array_key_exists('accommodation_details', session()->get('booking_session')) ? session()->get('booking_session')['accommodation_details'] : '' }}</textarea>
                                    </div>
                                </div>

                                @if($babysitter->babysitter->mainAddress->country === $end_location->get('country_code'))
                                    <div class="field">
                                        <div class="control">
                                            <label class="label">Would you like to meet your babysitter at your accommodation in {{$end_location->get('country_name')}} ? *</label>
                                            <label class="radio">
                                                <input type="radio" value="1" name="babysitter_meet"
                                                    {{ array_key_exists('babysitter_meet', session()->get('booking_session')) && session()->get('booking_session')['babysitter_meet'] === '1' ? 'checked="checked"' : '' }}>
                                                Yes
                                            </label>
                                            <label class="radio">
                                                <input type="radio" value="0" name="babysitter_meet"
                                                    {{ array_key_exists('babysitter_meet', session()->get('booking_session')) && session()->get('booking_session')['babysitter_meet'] === '0' ? 'checked="checked"' : '' }}>
                                                No
                                            </label>
                                        </div>
                                    </div>

                                    <div id="toggle_babysitter_meet" class="field {{ array_key_exists('babysitter_meet', session()->get('booking_session')) && session()->get('booking_session')['babysitter_meet'] === '1' ? '' : 'is-hidden' }}">
                                        <div class="control">
                                            <label class="label">If not, please provide some details and address where you would like to meet</label>
                                            <textarea class="textarea" name="babysitter_meet_details" rows="2" placeholder="">{{ array_key_exists('babysitter_meet_details', session()->get('booking_session')) ? session()->get('booking_session')['babysitter_meet_details'] : '' }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                <div class="field">
                                    <div class="control">
                                        <label class="label">Will you be travelling anywhere else during the trip ? *</label>
                                        <label class="radio">
                                            <input type="radio" value="1" name="travel_trip"
                                                {{ array_key_exists('travel_trip', session()->get('booking_session')) && session()->get('booking_session')['travel_trip'] === '1' ? 'checked="checked"' : '' }}>
                                            Yes
                                        </label>
                                        <label class="radio">
                                            <input type="radio" value="0" name="travel_trip"
                                                {{ array_key_exists('travel_trip', session()->get('booking_session')) && session()->get('booking_session')['travel_trip'] === '0' ? 'checked="checked"' : '' }}>
                                            No
                                        </label>
                                    </div>
                                </div>

                                <div id="toggle_travel_trip" class="field {{ array_key_exists('travel_trip', session()->get('booking_session')) && session()->get('booking_session')['travel_trip'] === '1' ? '' : 'is-hidden' }}">
                                    <div class="control">
                                        <label class="label">Please provide full details of any accommodation or itinerary that you have</label>
                                        <textarea class="textarea" name="travel_trip_details" rows="4" placeholder="">{{ array_key_exists('travel_trip_details', session()->get('booking_session')) ? session()->get('booking_session')['travel_trip_details'] : '' }}</textarea>
                                    </div>
                                </div>


                            @endif

                            <h2 class="title is-4 has-margin-top-lg {{$booking_type_text_class}}">Contact information</h2>
                            <div class="field">
                                <div class="control">
                                    <label class="label">Primary contact number</label>
                                    <p>{{$user->phone_number ?? 'Not provided'}}</p>

                                    @if($type === 'babysitter')
                                        <label class="label has-margin-top-md">Can you be reached on this number during the babysitting? *</label>
                                    @else
                                        <label class="label has-margin-top-md">Can you be reached on this number during your vacation? *</label>
                                    @endif
                                    <label class="radio">
                                        <input type="radio" value="1" name="primary_number_available"
                                            {{ array_key_exists('primary_number_available', session()->get('booking_session')) && session()->get('booking_session')['primary_number_available'] === '1' ? 'checked="checked"' : '' }}>
                                        Yes
                                    </label>
                                    <label class="radio">
                                        <input type="radio" value="0" name="primary_number_available"
                                            {{ array_key_exists('primary_number_available', session()->get('booking_session')) && session()->get('booking_session')['primary_number_available'] === '0' ? 'checked="checked"' : '' }}>
                                        No
                                    </label>
                                </div>
                            </div>

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Emergency contact number</label>
                                    <p>{{$user->emergency_phone_number ?? 'Not provided'}}</p>

                                    @if($type === 'babysitter')
                                        <label class="label has-margin-top-md">Can you be reached on this number during the babysitting? *</label>
                                    @else
                                        <label class="label has-margin-top-md">Can you be reached on this number during your vacation? *</label>
                                    @endif
                                    <label class="radio">
                                        <input type="radio" value="1" name="emergency_phone_number_available"
                                            {{ array_key_exists('emergency_phone_number_available', session()->get('booking_session')) && session()->get('booking_session')['emergency_phone_number_available'] === '1' ? 'checked="checked"' : '' }}>
                                        Yes
                                    </label>
                                    <label class="radio">
                                        <input type="radio" value="0" name="emergency_phone_number_available"
                                            {{ array_key_exists('emergency_phone_number_available', session()->get('booking_session')) && session()->get('booking_session')['emergency_phone_number_available'] === '0' ? 'checked="checked"' : '' }}>
                                        No
                                    </label>
                                </div>
                            </div>

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Additional contact number</label>
                                    <p class="help has-margin-bottom-sm">Please use this field if you cannot be reached on any of the above numbers or if you want to provide additional number</p>
                                    <input class="input" type="text" name="additional_phone_number" placeholder="Phone number" value="{{ array_key_exists('additional_phone_number', session()->get('booking_session')) ? session()->get('booking_session')['additional_phone_number'] : '' }}">
                                </div>
                            </div>

                            <h2 class="title is-4 has-margin-top-lg {{$booking_type_text_class}}">Notes</h2>

                            @if($type === 'babysitter')
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Do you know where you'll be during the babysitting? *</label>
                                        <textarea class="textarea" name="parent_during_booking" rows="3" placeholder="Please provide some details">{{ array_key_exists('parent_during_booking', session()->get('booking_session')) ? session()->get('booking_session')['parent_during_booking'] : '' }}</textarea>
                                    </div>
                                </div>
                            @endif

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Extra notes *</label>
                                    @if($type === 'babysitter')
                                        <p class="help has-margin-bottom-sm">Please provide extra notes and description of the job for your Tripsitta nanny if applicable. <br />Please also let you nanny know if you will provide a meal for them if your booking is over 6 hours. </p>
                                    @else
                                        <p class="help has-margin-bottom-sm">Please provide extra notes and description of the job for your Tripsitta nanny.<br />This can include details about your family, your vacation, the expected daily schedule and any other info you feel will be helpful.</p>
                                    @endif
                                    <textarea class="textarea" name="booking_notes" rows="6">{{ array_key_exists('booking_notes', session()->get('booking_session')) ? session()->get('booking_session')['booking_notes'] : '' }}</textarea>
                                </div>
                            </div>

                            @csrf

                        </form>

                        <h2 class="title is-4 has-margin-top-lg {{$booking_type_text_class}}">Booking guidelines</h2>
                        <div class="content">
                            @if($type === 'babysitter')
                                <p>If you extend the time for the babysitting, please make sure to check with your Tripsitta nanny if they are able to stay later.
                                    You may be required to pay for their taxi home if they are travelling by public transport or if they finish after midnight
                                    (depending on the location of babysitting and if they have their own transportation).
                                </p>
                                <p>
                                    Any extra time will be billed to you through the website when you extend.
                                </p>
                                <p>
                                    Once you pay and complete the booking, you'll be able to discuss any further details with your Tripsitta nanny directly.
                                </p>
                                <p>
                                    Please remember to write a review after your booking so other parents can have your valuable opinion !
                                </p>
                            @else
                                <p>For holiday nanny bookings your family is also responsible for covering any travel / flights / trains
                                    / buses / accommodation. You should also provide your nanny with food that they can prepare
                                    or cook or a daily allowance for food – recommended amount of €25 per day. You can make
                                    these arrangements directly with your nanny or can ask our team for assistance with this.</p>

                                <p>The daily amount of childcare provided as a guideline should be approximately 8 hours a day.
                                    The approximate times should be agreed upon as early in advance as possible. Please ensure
                                    that your nanny does have sufficient breaks so they are full charged and able to give the best
                                    possible care to your children. When they are off duty they should be given the opportunity to
                                    have some free time.
                                    If you need extra assistance on some days then the best way to arrange this is to deduct some
                                    hours from an alternative day – for example if you need your nanny to work 10 hours on
                                    Tuesday then allow them to work 6 hours another day.</p>
                            @endif
                        </div>

                        <div class="notification is-warning">
                            <p>By clicking "Pay and confirm booking" you accept <a href="">Terms & Conditions</a> and enter into a contract between yourself and the selected babysitter.</p>
                        </div>
                    </div>
                </div>

                @if($stripe_session_id !== null)
                    @if($type === 'babysitter')
                        <p class="has-text-centered-mobile"><a href="{{ route('book-babysitter', $return_parameters) }}" class="button is-tripsitta has-margin-bottom-sm"><span class="icon"><i class="fas fa-chevron-left"></i></span><span>Go back to edit booking details</span></a> <a  id="continue_booking" class="button is-tripsitta is-secondary is-pulled-right">Pay and confirm booking</a></p>
                    @else
                        <p class="has-text-centered-mobile"><a href="{{ route('book-holiday-nanny', $return_parameters) }}" class="button is-tripsitta has-margin-bottom-sm"><span class="icon"><i class="fas fa-chevron-left"></i></span><span>Go back to edit booking details</span></a> <a id="continue_booking" class="button is-tripsitta is-primary is-pulled-right">Pay and confirm booking</a></p>
                    @endif
                @endif
        </div>
    </div>
@endsection
