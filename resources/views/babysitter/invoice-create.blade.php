@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/pages/babysitter-invoice-create.js') }}"></script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Create invoice</h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('babysitter.partials.menu')
                 </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">New invoice for booking {{$booking->idPadded}}</h2>
                    @if (session('status'))
                        <div class="notification @if(session('status')['type'] == 'success') is-success @else is-danger @endif">
                            {{ session('status')['message'] }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="notification is-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{$error}}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="post" action="{{route('babysitter.invoice-create', $booking->id)}}">
                        <div class="field">
                            <div class="control">
                                <label class="label">Invoice type *</label>
                                <div class="select is-fullwidth">
                                    <select name="type" required>
                                        <option value="">Select invoice type</option>
                                        @foreach(['balance' => 'Additional work time', 'extras' => 'Extras'] as $key => $invoice_type)
                                            <option value="{{$key}}">{{$invoice_type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label">Description *</label>
                                <textarea name="description" class="textarea" placeholder="Please describe what the invoice include..." required></textarea>
                            </div>
                            <p class="help">This information is going to be visible to customer when they make payment</p>
                        </div>

                        <div class="field">
                            <label class="label">Amount to be paid *</label>
                            <div class="field has-addons">
                                <p class="control">
                                    <a class="button is-static">
                                        &euro;
                                    </a>
                                </p>
                                <p class="control is-expanded">
                                    <input class="input" type="text" name="amount_due" value="" required>
                                </p>
                            </div>
                        </div>

                        @csrf
                        <button type="submit" class="button is-block is-medium is-fullwidth has-margin-top-xl is-primary">Add invoice</button>

                        <div class="notification is-info has-margin-top-lg">
                            When you click "Add Invoice", a new payment request will be sent to customer by email. Please make sure you agreed all details with customer before sending the invoice.
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
