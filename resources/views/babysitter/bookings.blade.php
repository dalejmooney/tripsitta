@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/pages/babysitter-bookings.js') }}"></script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Bookings @if($user->babysitter->reg_form_submitted == 0) <span class="has-tooltip-bottom" data-tooltip="Please complete the registration process to gain full access."><i class="fas fa-exclamation-circle has-text-warning"></i></span> @endif</h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('babysitter.partials.menu')
                 </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Current booking</h2>
                    <p class="subtitle is-6 has-padding-top-sm">List below shows bookings that have started but are not yet marked as completed</p>

                    <div class="tripsitta-table is-expandable">
                        <table class="table is-fullwidth is-hoverable">
                            <thead>
                                <tr>
                                    <th style="width:7%;">ID</th>
                                    <th style="width:18%;">Type</th>
                                    <th style="width:25%;">Customer</th>
                                    <th style="width:15%;">Start</th>
                                    <th style="width:15%;">End</th>
                                    <th style="width:20%;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($current_booking as $booking)
                                    <tr>
                                        <td data-label="ID">{{$booking->idPadded}}</td>
                                        <td data-label="Type" class="is-capitalized">@if($booking->type === 'babysitter') <i class="fas fa-baby has-text-secondary"></i>  @else <i class="fas fa-suitcase-rolling has-text-primary"></i> @endif {{$booking->bookingTypeHumanReadable}}</td>
                                        <td data-label="Customer">{{$booking->family->user->fullName}}</td>
                                        <td data-label="Start">{{$booking->startDateFull}}</td>
                                        <td data-label="End">{{$booking->endDateFull}}</td>
                                        <td data-label="Status">{{$booking->bookingStatus->name}}</td>
                                    </tr>
                                    <tr class="table-actions" style="display: none;">
                                        <td colspan="6">
                                            <a href="{{route('babysitter.booking', $booking->id)}}" title="View booking details" class="button">View booking details</a>
                                            <a href="{{route('babysitter.booking-chat', $booking->id)}}" class="button" title="Chat with your customer now!">Contact customer</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            No bookings to show!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h2 class="title is-4 has-text-primary has-margin-top-xl">Upcoming bookings ({{$upcoming_bookings->count()}})</h2>
                    <p class="subtitle is-6 has-padding-top-sm">List below shows future bookings. Please make sure you confirm bookings you are interested in</p>

                    <div class="tripsitta-table is-expandable">
                        <table class="table is-fullwidth is-hoverable">
                            <thead>
                                <tr>
                                    <th style="width:7%;">ID</th>
                                    <th style="width:18%;">Type</th>
                                    <th style="width:25%;">Customer</th>
                                    <th style="width:15%;">Start</th>
                                    <th style="width:15%;">End</th>
                                    <th style="width:20%;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($upcoming_bookings as $booking)
                                    <tr>
                                        <td data-label="ID">{{$booking->idPadded}}</td>
                                        <td data-label="Type" class="is-capitalized">@if($booking->type === 'babysitter') <i class="fas fa-baby has-text-secondary"></i>  @else <i class="fas fa-suitcase-rolling has-text-primary"></i> @endif {{$booking->bookingTypeHumanReadable}}</td>
                                        <td data-label="Customer">{{$booking->family->user->fullName}}</td>
                                        <td data-label="Start">{{$booking->startDateFull}}</td>
                                        <td data-label="End">{{$booking->endDateFull}}</td>
                                        @if($booking->status_id === 6)
                                            <td data-label="Status" class="has-text-danger"><span data-tooltip="Your action is required">{{$booking->bookingStatus->name}} <i class="fas fa-exclamation-triangle"></i></span></td>
                                        @else
                                            @if($booking->babysitterMarkedAsCompleted && !$booking->parentMarkedAsCompleted)
                                                <td data-label="Status" class="has-text-danger"><span data-tooltip="Waiting for parents confirmation">{{$booking->bookingStatus->name}} <i class="fas fa-exclamation-triangle"></i></span></td>
                                            @elseif(!$booking->babysitterMarkedAsCompleted && $booking->parentMarkedAsCompleted)
                                                <td data-label="Status" class="has-text-danger"><span data-tooltip="Your action is required">{{$booking->bookingStatus->name}} <i class="fas fa-exclamation-triangle"></i></span></td>
                                            @else
                                                <td data-label="Status">{{$booking->bookingStatus->name}}</td>
                                            @endif
                                        @endif
                                    </tr>
                                    <tr class="table-actions" style="display: none;">
                                        <td colspan="6">
                                            <a href="{{route('babysitter.booking', $booking->id)}}" title="View booking details" class="button">View booking details</a>
                                            <a href="{{route('babysitter.booking-chat', $booking->id)}}" class="button" title="Chat with your customer now!">Contact customer</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            No upcoming bookings yet!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <h2 class="title is-4 has-text-primary has-margin-top-xl">Bookings history ({{$past_bookings->count()}})</h2>
                    <p class="subtitle is-6 has-padding-top-sm">List below shows bookings that are already completed or that were cancelled by you or by the family.</p>
                    <div class="tripsitta-table is-expandable">
                        <table class="table is-fullwidth is-hoverable">
                            <thead>
                                <tr>
                                    <th style="width:7%;">ID</th>
                                    <th style="width:18%;">Type</th>
                                    <th style="width:25%;">Customer</th>
                                    <th style="width:15%;">Start</th>
                                    <th style="width:15%;">End</th>
                                    <th style="width:20%;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($past_bookings as $booking)
                                <tr>
                                    <td data-label="ID">{{$booking->idPadded}}</td>
                                    <td data-label="Type" class="is-capitalized">@if($booking->type === 'babysitter') <i class="fas fa-baby has-text-secondary"></i>  @else <i class="fas fa-suitcase-rolling has-text-primary"></i> @endif {{$booking->bookingTypeHumanReadable}}</td>
                                    <td data-label="Customer">{{$booking->family->user->fullName}}</td>
                                    <td data-label="Start">{{$booking->startDateFull}}</td>
                                    <td data-label="End">{{$booking->endDateFull}}</td>
                                    <td data-label="Status">{{$booking->bookingStatus->name}}</td>
                                </tr>
                                <tr class="table-actions" style="display: none;">
                                    <td colspan="6">
                                        <a href="{{route('babysitter.booking', $booking->id)}}" title="View booking details" class="button">View booking details</a>
                                        <a href="{{route('babysitter.booking-chat', $booking->id)}}" class="button" title="Chat with your customer now!">Contact customer</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        Your bookings history is empty!
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
