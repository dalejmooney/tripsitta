@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/pages/parent-invoices.js') }}"></script>
    <script src="{{ mix('js/helpers.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var filter_booking_id = "{{$filter_booking_id}}";
        var select_invoice_url = "{{ route('parent.invoice.pay', [''])}}";
        var stripe = Stripe('{{config('tripsitta.stripe.publishable')}}');
    </script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Invoices</h1>
            <p class="subtitle">Parent panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('parent.partials.menu')
                 </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Invoices</h2>

                    <div id="errors-container" class="is-hidden"></div>
                    @if($stripe_checkout_session_id !== null)
                        <div class="notification is-success">
                            <p>Thank you. We have received your payment. Please note our systems can take few minutes to update.</p>
                        </div>
                    @endif

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
                                        <td data-label="Invoice date">{{$invoice->created_at->format('d M Y')}}</td>
                                    </tr>
                                    <tr class="table-actions" style="display: none;">
                                        <td colspan="8">
                                            @if($invoice->balanceInPounds < 0)
                                                <a class="button is-primary pay-invoice" data-invoice="{{$invoice->reference}}">Pay invoice</a>
                                            @endif
                                            <a href="{{route('parent.invoice', [$invoice->reference])}}" class="button">View invoice</a>
                                            <a href="{{route('parent.booking', [$invoice->booking_id])}}" class="button">View booking details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
                                            No invoices to show!
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
