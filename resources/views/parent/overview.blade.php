@extends('layouts.app')

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Overview</h1>
            <p class="subtitle">Parent panel</p>

            @if (session('status'))
                <div class="notification @if(session('status')['type'] == 'success') is-success @else is-danger @endif">
                    {{ session('status')['message'] }}
                </div>
            @endif

            <div class="columns">
                <div class="column is-4">
                    @include('parent.partials.menu')
                </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Overview</h2>
                    @if($user->family->reg_form_submitted == 0 )
                        <div class="notification is-warning">
                            <p class="subtitle is-5">Registration not completed!</p>
                            <p>Please complete your registration form. Once your account is active you'll be able to book and contact babysitters.</p>
                        </div>
                    @elseif($user->family->reg_form_submitted == 1 && $user->family->published == 0)
                        <div class="notification is-info">
                            <p class="subtitle is-5">Your account is currently disabled</p>
                            <p>Please contact us if you want to re-enable it or if it's an error. Thank you</p>
                        </div>
                    @endif

                    @if($bookings_need_action > 0)
                    <div class="notification is-warning">
                        <p class="subtitle is-5">Bookings require your confirmation</p>
                        <p>We can see that a booking period for some of your bookings has already passed. Please remember to confirm the booking completion. You'll have a chance to leave your feedback later</p>
                        <p class="has-margin-top-md"><a href="{{route('parent.bookings')}}" class="button is-warning is-light">See bookings</a></p>
                    </div>
                    @endif

                    @if($invoices_need_payment > 0)
                        <div class="notification is-danger">
                            <p class="subtitle is-5">Some invoices require your payment</p>
                            <p>Please make sure you pay the due invoices as soon as possible. Thank you</p>
                            <p class="has-margin-top-md"><a href="{{route('parent.invoices')}}" class="button is-danger is-light">See invoices</a></p>
                        </div>
                    @endif

                    <h2 class="title">Upcoming booking</h2>
                    @if(!$upcoming_booking)
                        <p>You don't have any future bookings yet. </p>
                    @else
                        <dl>
                            <dt>Booking ID:</dt>
                            <dd>{{$upcoming_booking->idPadded}}</dd>
                        </dl>
                        <dl>
                            <dt>Type:</dt>
                            <dd class="is-capitalized">@if($upcoming_booking->type === 'babysitter') <i class="fas fa-baby has-text-secondary"></i>  @else <i class="fas fa-suitcase-rolling has-text-primary"></i> @endif {{$upcoming_booking->bookingTypeHumanReadable}}</dd>
                        </dl>
                        <dl>
                            <dt>Status:</dt>
                            <dd id="booking-status-container">{{$upcoming_booking->bookingStatus->name}} @if($upcoming_booking->completed) (Closed booking) @endif</dd>
                        </dl>
                        <dl class="has-padding-top-md">
                            <dt>Start:</dt>
                            @if($upcoming_booking->type === 'babysitter')
                                <dd>{{$upcoming_booking->startDateFull}}</dd>
                            @else
                                <dd>{{$upcoming_booking->startDateFull}} in {{Countries::getOne($upcoming_booking->start_location)}}</dd>
                            @endif
                        </dl>
                        <dl>
                            <dt>End:</dt>
                            @if($upcoming_booking->type === 'babysitter')
                                <dd>{{$upcoming_booking->endDateFull}}</dd>
                            @else
                                <dd>{{$upcoming_booking->endDateFull}} in {{Countries::getOne($upcoming_booking->end_location)}}</dd>
                            @endif
                        </dl>
                        <p class="has-margin-top-md"><a href="{{route('parent.booking', [$upcoming_booking->id])}}" class="button is-danger">View booking details</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
