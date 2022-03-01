@extends('layouts.app')

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Overview @if($user->babysitter->reg_form_submitted == 0) <span class="has-tooltip-bottom" data-tooltip="Please complete the registration process to gain full access."><i class="fas fa-exclamation-circle has-text-warning"></i></span> @endif</h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('babysitter.partials.menu')
                 </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Overview</h2>
                    @if($user->babysitter->reg_form_submitted == 0 )
                        <div class="notification is-warning">
                            <p class="subtitle is-5">Registration not completed!</p>
                            <p>Please complete your profile and then book an interview with our team to activate your account and become a Tripsitta nanny! (N.B Accounts will only be activated after a successful interview and background check process is completed.)</p>
                        </div>
                    @elseif($user->babysitter->reg_form_submitted == 1 && $user->babysitter->published == 0)
                        <div class="notification is-info">
                            <p class="subtitle is-5">Thank you for application to join Tripsitta!</p>
                            <p>We are looking forward to speaking with you soon.</p>
                        </div>
                        <div class="content">
                            <p>Your interview has been arranged for <strong>{{(new \DateTime($user->babysitter->interview_date))->format('d/m/Y')}} at {{$user->babysitter->interview_time}}</strong>.</p>
                            <p>A member of the Tripsitta team will be in touch soon to confirm the interview</p>
                            <p>Best of luck with your application!</p>
                        </div>
                    @endif

                    @if($user->babysitter->reg_form_submitted == 1 && $user->babysitter->published == 1)
                        @if($bookings_need_action > 0)
                            <div class="notification is-warning">
                                <p class="subtitle is-5">Bookings require your action</p>
                                <p>Some bookings require your confirmation. We marked those that need your attention in red. </p>
                                <p class="has-margin-top-md"><a href="{{route('babysitter.bookings')}}" class="button is-warning is-light">See bookings</a></p>
                            </div>
                        @endif

                            <div class="columns">
                                <div class="column is-4 has-text-centered">
                                    <div class="box">
                                        <p>Total bookings</p>
                                        <p class="has-text-weight-bold">{{$booking_total_count}}</p>
                                    </div>
                                </div>

                                <div class="column is-4 has-text-centered">
                                    <div class="box">
                                        <p>Future bookings</p>
                                        <p class="has-text-weight-bold">{{$booking_future_count}}</p>
                                    </div>
                                </div>

                                <div class="column is-4 has-text-centered">
                                    <div class="box">
                                        <p>Past bookings</p>
                                        <p class="has-text-weight-bold">{{$booking_past_count}}</p>
                                    </div>
                                </div>
                            </div>

                            <h2 class="title">Upcoming booking</h2>
                            @if(!$upcoming_booking)
                                <p>You don't have any future bookings yet.</p>
                                <p>Make sure to keep your calendars open so customer can see you are available!</p>
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
                                <p class="has-margin-top-md">
                                    <a href="{{route('babysitter.booking', [$upcoming_booking->id])}}" class="button is-danger">View booking details</a>
                                    <a href="{{route('babysitter.bookings')}}" class="button is-danger is-outlined">View all upcoming bookings</a>
                                </p>
                            @endif
                        @endif
                </div>
            </div>
        </div>
    </div>
@endsection
