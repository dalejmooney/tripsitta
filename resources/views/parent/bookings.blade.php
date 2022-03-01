@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/pages/parent-bookings.js') }}"></script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Bookings</h1>
            <p class="subtitle">Parent panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('parent.partials.menu')
                 </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Bookings</h2>
                    <div class="tripsitta-table is-expandable">
                        <table class="table is-fullwidth is-hoverable">
                            <thead>
                                <tr>
                                    <th style="width:15%;">ID</th>
                                    <th style="width:20%;">Babysitter</th>
                                    <th style="width:15%;">Start</th>
                                    <th style="width:15%;">End</th>
                                    <th style="width:15%;">To pay</th>
                                    <th style="width:20%;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($bookings as $booking)
                                @if($booking->completed_at)
                                    <tr class="has-text-grey">
                                @else
                                    <tr>
                                @endif
                                    <td data-label="ID">@if($booking->type === 'babysitter') <i class="fas fa-baby has-text-secondary"></i>  @else <i class="fas fa-suitcase-rolling has-text-primary"></i> @endif {{$booking->idPadded}}</td>
                                    <td data-label="Babysitter">{{$booking->babysitter->user->fullName}}</td>
                                    <td data-label="Start">{{$booking->startDateFull}}</td>
                                    @if($booking->end < new \DateTime() && $booking->status_id === 4)
                                        <td data-label="End" class="has-text-danger">{{$booking->endDateFull}}</td>
                                    @else
                                        <td data-label="End">{{$booking->endDateFull}}</td>
                                    @endif

                                    @if($booking->invoices->sum('BalanceInPounds') < 0)
                                        <td data-label="To pay" class="has-text-danger"><span data-tooltip="Please clear the outstanding balance as soon as possible">&euro; {{number_format(abs($booking->invoices->sum('BalanceInPounds')), 2)}}</span></td>
                                    @else
                                        <td data-label="To pay">&euro; {{number_format(abs($booking->invoices->sum('BalanceInPounds')), 2)}}</td>
                                    @endif

                                    @if($booking->babysitterMarkedAsCompleted && !$booking->parentMarkedAsCompleted)
                                        <td data-label="Status" class="has-text-danger"><span data-tooltip="Your action is required">{{$booking->bookingStatus->name}} <i class="fas fa-exclamation-triangle"></i></span></td>
                                    @elseif(!$booking->babysitterMarkedAsCompleted && $booking->parentMarkedAsCompleted)
                                        <td data-label="Status" class="has-text-danger"><span data-tooltip="Awaiting babysitters confirmation">{{$booking->bookingStatus->name}} <i class="fas fa-exclamation-triangle"></i></span></td>
                                    @else
                                        <td data-label="Status">{{$booking->bookingStatus->name}}</td>
                                    @endif
                                </tr>
                                <tr class="table-actions" style="display: none;">
                                    <td colspan="6">
                                        <a href="{{route('parent.booking', $booking->id)}}" title="View booking details" class="button">View booking details</a>
                                        <a href="{{route('parent.booking-chat', $booking->id)}}" class="button" title="Chat with your babysitter now!">Contact babysitter</a></td>
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
