@extends('layouts.app')

@section('scripts')
    <script>
        var status_update_url = '{{route('babysitter.booking-update-status', [$booking->id])}}';
    </script>

    <script src="{{ mix('js/pages/babysitter-booking.js') }}"></script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Booking information</h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('babysitter.partials.menu')
                 </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Booking {{$booking->idPadded}}</h2>

                    <div class="buttons">
                        @if(in_array('up', $status_options))
                            <a class="button" id="booking_status_up"><span class="icon"><i class="fas fa-check"></i></span><span>Accept booking</span></a>
                        @endif
                        @if(in_array('down', $status_options))
                                <a class="button" id="booking_status_down"><span class="icon"><i class="fas fa-times"></i></span><span>Cancel booking</span></a>
                        @endif
                        @if(in_array('done', $status_options))
                            <a class="button" id="booking_status_done"><span class="icon"><i class="fas fa-check-double"></i></span><span>Mark as completed</span></a>
                        @endif
                        @if(in_array('confirm', $status_options))
                            <a class="button" id="booking_status_confirm"><span class="icon"><i class="fas fa-check"></i></span><span>Confirm cancellation</span></a>
                        @endif
                        <a href="{{route('babysitter.booking-chat', $booking->id)}}" class="button"><span class="icon"><i class="far fa-comments"></i></span><span>Chat with customer</span></a>
                        <a href="{{route('babysitter.invoices', [$booking->id])}}" class="button"><span class="icon"><i class="fas fa-file-invoice"></i></span><span>View invoices</span></a>
                        @if($booking->status_id == 4)
                        <a href="{{route('babysitter.invoice-create', [$booking->id])}}" class="button"><span class="icon"><i class="fas fa-plus-square"></i></span><span>Raise additional invoice</span></a>
                        @endif
                    </div>

                    <div id="message_container"></div>
                    @if($booking_amounts->get('to_pay') < 0)
                        <div class="notification is-warning">
                            Still awaiting customer's payment of £{{number_format($booking_amounts->get('to_pay'), 2)}}. Please make sure to contact the customer before commencing the work.
                        </div>
                    @endif

                    <dl>
                        <dt>Booking ID:</dt>
                        <dd>{{$booking->idPadded}}</dd>
                    </dl>
                    <dl>
                        <dt>Type:</dt>
                        <dd class="is-capitalized">@if($booking->type === 'babysitter') <i class="fas fa-baby has-text-secondary"></i>  @else <i class="fas fa-suitcase-rolling has-text-primary"></i> @endif {{$booking->bookingTypeHumanReadable}}</dd>
                    </dl>
                    <dl>
                        <dt>Created:</dt>
                        <dd>{{$booking->createdDate}}</dd>
                    </dl>
                    <dl>
                        <dt>Status:</dt>
                        <dd id="booking-status-container">{{$booking->bookingStatus->name}} @if($booking->completed) (Closed booking) @endif</dd>
                    </dl>

                    <dl class="has-padding-top-md">
                        <dt>Start:</dt>
                        @if($booking->type === 'babysitter')
                            <dd>{{$booking->startDateFull}}</dd>
                        @else
                            <dd>{{$booking->startDateFull}} in {{Countries::getOne($booking->start_location)}}</dd>
                        @endif
                    </dl>
                    @if($booking->start_location_airport != '')
                    <dl>
                        <dt>Start airport:</dt>
                        <dd>{{$booking->start_location_airport}}</dd>
                    </dl>
                    @endif
                    @if($user->babysitter->mainAddress->country === $booking->end_location)
                        @if($booking->babysitter_meet == 1)
                            <dl>
                                <dt>First meeting:</dt>
                                <dd>Customers accommodation in {{Countries::getOne($booking->end_location)}}</dd>
                            </dl>
                        @else
                            <dl>
                                <dt>First meeting:</dt>
                                <dd>{{$booking->babysitter_meet_details}}</dd>
                            </dl>
                        @endif
                    @endif
                    <dl>
                        <dt>End:</dt>
                        @if($booking->type === 'babysitter')
                            <dd>{{$booking->endDateFull}}</dd>
                        @else
                            <dd>{{$booking->endDateFull}} in {{Countries::getOne($booking->end_location)}}</dd>
                        @endif
                    </dl>
                    @if($booking->destination_town != '')
                        <dl>
                            <dt>Destination town:</dt>
                            <dd>{{$booking->destination_town}}</dd>
                        </dl>
                    @endif
                    @if($booking->travel_trip == 1)
                    <dl>
                        <dt>Travel locations: <span data-tooltip="Customer selected that they plan to travel to multiple places during their trip"><i class="fas fa-question"></i></span></dt>
                        <dd>{{$booking->travel_trip_details}}</dd>
                    </dl>
                    @endif
                    <dl>
                        <dt>Booking duration:</dt>
                        <dd>{{$booking->duration}}</dd>
                    </dl>
                    @if($booking->accommodation_booked == 1)
                        <dl>
                            <dt>Accommodation already booked:</dt>
                            <dd>Yes</dd>
                        </dl>
                        <dl>
                            <dt>Details:</dt>
                            <dd>{{$booking->accommodation_details}}</dd>
                        </dl>
                    @endif

                    <dl class="has-padding-top-md">
                        <dt>Booking total:</dt>
                        <dd>&euro; {{number_format($booking_amounts->get('total'), 2)}}</dd>
                    </dl>
                    <dl>
                        <dt>Balance:</dt>
                        @if($booking_amounts->get('to_pay') < 0)
                            <dd class="has-text-danger">&euro; {{number_format($booking_amounts->get('to_pay'), 2)}} ({{$booking->invoices->count()}} {{\Illuminate\Support\Str::plural('invoice', $booking->invoices->count())}})</dd>
                        @else
                            <dd>&euro; {{number_format($booking_amounts->get('to_pay'), 2)}} ({{$booking->invoices->count()}} {{\Illuminate\Support\Str::plural('invoice', $booking->invoices->count())}})</dd>
                        @endif
                    </dl>
                    <dl>
                        <dt>Earnings:</dt>
                        @if($booking_amounts->get('to_pay') < 0)
                            <dd>&euro; {{number_format($booking_amounts->get('babysitter_earnings'), 2)}} <span data-tooltip="There are still some unpaid invoices. Once cleared, this amount will update to: &euro;{{number_format($booking_amounts->get('babysitter_earnings_full'), 2)}}"><i class="fas fa-exclamation-triangle"></i></span></dd>
                        @else
                            <dd>&euro; {{number_format($booking_amounts->get('babysitter_earnings'), 2)}}</dd>
                        @endif
                    </dl>
                    <dl>
                        <dt>Withdrawals received:</dt>
                        <dd>&euro; {{$booking->receivedPayouts}}</dd>
                    </dl>

                    <dl>
                        <dt>Customer notes:</dt>
                        <dd>{{$booking->booking_notes}}</dd>
                    </dl>


                    <h2 class="title is-5 is-marginless has-padding-bottom-sm has-padding-top-lg">Customer details</h2>
                    <dl>
                        <dt>Name:</dt>
                        <dd>{{$booking->family->user->fullName}}</dd>
                    </dl>
                    <dl>
                        <dt>E-mail:</dt>
                        <dd><a href="mailto:{{$booking->family->user->email}}">{{$booking->family->user->email}}</a></dd>
                    </dl>
                    <dl>
                        <dt>Phone no:</dt>
                        <dd><a href="tel:{{$booking->family->user->phone_number}}">{{$booking->family->user->phone_number}}</a></dd>
                        @if($booking->contactable_main_phone_number == 0)
                            <dd data-tooltip="Customer marked this number as NOT available during booking duration" class="has-padding-left-md"><i class="fas fa-exclamation-triangle"></i></dd>
                        @endif
                    </dl>
                    @if($booking->family->user->home_phone_number != '')
                    <dl>
                        <dt>Home phone no:</dt>
                        <dd><a href="tel:{{$booking->family->user->home_phone_number}}">{{$booking->family->user->home_phone_number}}</a></dd>
                    </dl>
                    @endif
                    @if($booking->alternative_phone_number != '')
                    <dl>
                        <dt>Alternative phone number:</dt>
                        <dd><a href="tel:{{$booking->alternative_phone_number}}">{{$booking->alternative_phone_number}}</a></dd>
                    </dl>
                    @endif
                    <p class="has-padding-top-md"><a href="{{route('babysitter.booking-chat', $booking->id)}}" class="button is-primary is-outlined">Chat with customer</a></p>

                    <h2 class="title is-5 is-marginless has-padding-bottom-sm has-padding-top-lg">Children details ( {{$booking->bookingChildren->count()}} )</h2>
                    @foreach($booking->bookingChildren as $child)
                        <dl>
                            <dt>Name:</dt>
                            <dd>{{$child->name}}</dd>
                        </dl>
                        <dl class="has-padding-bottom-md">
                            <dt>DOB:</dt>
                            <dd>{{$child->dob->format('d M Y')}}</dd>
                        </dl>
                    @endforeach
                    <dl>
                        <dt>Children notes:</dt>
                        <dd>{{$booking->children_notes}}</dd>
                    </dl>

                    <h2 class="title is-5 is-marginless has-padding-bottom-sm has-padding-top-lg">Emergency contact details</h2>
                    <dl>
                        <dt>Name:</dt>
                        <dd>{{$booking->family->user->emergency_name}}</dd>
                    </dl>
                    <dl>
                        <dt>Relationship:</dt>
                        <dd>{{$booking->family->user->emergency_relationship}}</dd>
                    </dl>
                    <dl>
                        <dt>Phone no:</dt>
                        <dd><a href="tel:{{$booking->family->user->emergency_phone_number}}">{{$booking->family->user->emergency_phone_number}}</a></dd>
                        @if($booking->contactable_emergency_phone_number == 0)
                            <dd data-tooltip="Customer marked this number as NOT available during booking duration" class="has-padding-left-md"><i class="fas fa-exclamation-triangle"></i></dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>
    </div>
@endsection
