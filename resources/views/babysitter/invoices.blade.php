@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/pages/babysitter-invoices.js') }}"></script>
    <script>
        var filter_booking_id = "{{$filter_booking_id}}";
    </script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Invoices</h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('babysitter.partials.menu')
                 </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Invoices</h2>

                    <div class="columns">
                        <div class="column is-4 has-text-centered">
                            <div class="box">
                                <p>Total Invoices</p>
                                <p class="has-text-weight-bold">{{$invoices->count()}}</p>
                            </div>
                        </div>

                        <div class="column is-4 has-text-centered">
                            <div class="box">
                                <p>Earned this month</p>
                                <p class="has-text-weight-bold">&euro; {{number_format($earned_this_month, 2)}}</p>
                            </div>
                        </div>

                        <div class="column is-4 has-text-centered">
                            <div class="box">
                                <p>Earned to date</p>
                                <p class="has-text-weight-bold">&euro; {{number_format($earned_total, 2)}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input class="input is-dark" id="search" type="text" placeholder="Search by booking id">
                        </div>
                    </div>

                    <div class="tripsitta-table is-expandable">
                        <table id="invoices-table" class="table is-fullwidth is-hoverable">
                            <thead>
                                <tr>
                                    <th>Invoice Ref</th>
                                    <th>Booking ID</th>
                                    <th>Type</th>
                                    <th>Invoice Total</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                    <th>Earnings</th>
                                    <th>Invoice date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td data-label="Invoice Ref">{{$invoice->reference}}</td>
                                        <td data-label="Booking ID" class="table-booking-id">{{$invoice->booking->idPadded}}</td>
                                        <td data-label="Type">{{$invoice->type}}</td>
                                        <td data-label="Invoice Total">&euro; {{number_format($invoice->amountDueInPounds, 2)}}</td>
                                        <td data-label="Paid" @if($invoice->paid_at) data-tooltip="Paid on {{$invoice->paid_at->format('d M Y H:i')}}" @endif>&euro; {{number_format($invoice->amountPaidInPounds, 2)}}</td>
                                        <td data-label="Balance" @if($invoice->balanceInPounds < 0) class="has-text-danger" @endif>&euro; {{number_format($invoice->balanceInPounds, 2)}}</td>
                                        @if($invoice->balanceInPounds < 0)
                                            <td data-label="Earnings"><span data-tooltip="Awaiting customer's payment. Once cleared: &euro; {{ number_format($invoice->babysitterEarningsInPounds, 2) }}">&euro; 0.00</span></td>
                                        @else
                                            <td data-label="Earnings">&euro; {{ number_format($invoice->babysitterEarningsInPounds, 2) }}</td>
                                        @endif
                                        <td data-label="Invoice date">{{$invoice->created_at->format('d M Y')}}</td>
                                    </tr>
                                    <tr class="table-actions" style="display: none;">
                                        <td colspan="8">
                                            <a href="{{route('babysitter.invoice', [$invoice->reference])}}" class="button">View invoice</a>
                                            <a href="{{route('babysitter.booking', [$invoice->booking_id])}}" class="button">View booking details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            No bookings to show!
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
