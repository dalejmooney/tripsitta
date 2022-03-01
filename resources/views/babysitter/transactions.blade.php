@extends('layouts.app')

@section('scripts')

@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Payouts</h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('babysitter.partials.menu')
                 </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Payouts list</h2>

                    <div class="columns">
                        <div class="column is-4 has-text-centered">
                            <div class="box">
                                <p>Completed</p>
                                <p class="has-text-weight-bold">{{$completed_payouts}}</p>
                            </div>
                        </div>

                        <div class="column is-4 has-text-centered">
                            <div class="box">
                                <p>Awaiting</p>
                                <p class="has-text-weight-bold">{{$pending_payouts}}</p>
                            </div>
                        </div>

                        <div class="column is-4 has-text-centered">
                            <div class="box">
                                <p>Total transferred</p>
                                <p class="has-text-weight-bold">&euro; {{$payouts_transferred_total}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="tripsitta-table is-expandable">
                        <table id="invoices-table" class="table is-fullwidth is-hoverable">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Booking</th>
                                    <th>Status</th>
                                    <th>Received</th>
                                    <th>Expected</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payouts as $payout)
                                    <tr>
                                        <td>{{$payout->created_at->format('d/m/Y H:i')}}</td>
                                        <td><a href="{{route('babysitter.invoice', $payout->invoice->reference)}}">{{$payout->invoice->reference}}</a></td>
                                        <td><a href="{{route('babysitter.booking', $payout->invoice->booking->id)}}">{{$payout->invoice->booking->idPadded}}</a></td>
                                        <td>{{$payout->status}}</td>
                                        <td>{!! $payout->amountFormatted !!}</td>
                                        <td>&euro; {{number_format($payout->invoice->BabysitterEarningsInPounds,2 ,'.', '')}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Nothing to show yet !</td>
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
