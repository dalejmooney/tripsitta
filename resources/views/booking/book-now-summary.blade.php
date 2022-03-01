@extends('layouts.app')

@section('meta_title') @endsection
@section('meta_desc') @endsection

@section('scripts')

@endsection

@php
   $booking_type_text_class = ($type === 'babysitter') ? 'has-text-secondary' : 'has-text-primary';
   $booking_type_el_class = ($type === 'babysitter') ? 'is-secondary' : 'is-primary';
@endphp

@section('content')
    <div id="app-content">
        <div class="container">
            <div class="is-pulled-right is-hidden-mobile has-margin-top-md" data-tooltip="Current step: 3 / 3">
                <i class="icon-number is-small is-inline-block {{$booking_type_el_class}}">1</i> <i class="icon-number is-small is-inline-block {{$booking_type_el_class}}">2</i> <i class="icon-number is-small is-inline-block {{$booking_type_el_class}} is-active">3</i>
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

                        <h2 class="title is-4 {{$booking_type_text_class}}">Booking summary</h2>

                        <div class="notification is-success">
                            <p class="subtitle is-4"><span class="icon is-green"><i class="fa fa-check"></i></span> Booking process successful</p>
                            <p>Thank you for your booking. Reference number of your booking with Tripsitta is <span class="has-text-weight-bold">T{{str_pad($booking_id, 6, '0', STR_PAD_LEFT)}}</span></p>
                            <p class="has-margin-top-md">Booking confirmation will be sent to your e-mail address. If you have any questions please contact us or the babysitter directly using details below.</p>
                        </div>

                        <div class="notification">
                            <p class="subtitle is-5">Your babysitter contact details</p>
                            <div class="content">
                                <p>Your babysitter will now review the booking and contact you to confirm details. If you want you can introduce yourself first and provide more information. We recommend using our
                                website to communicate with babysitter so we can assist you in case of problems.</p>
                                <p class="semibold"><span class="icon"><i class="fas fa-comments"></i></span> <a href="{{route('parent.booking-chat', $booking_id)}}">Message your babysitter (recommended)</a></p>
                                <p class="semibold"><span class="icon"><i class="fas fa-phone"></i></span> <a href="tel:{{$babysitter->phone_number}}">{{$babysitter->phone_number}}</a></p>
                            </div>
                        </div>

                        <div class="columns has-padding has-margin-top-lg">
                            <div class="column">
                                <h2 class="subtitle is-5">What to do now?</h2>
                                <div class="content">
                                    <p>Booking process is completed. You can safely close our website however we have few things you may want to check first:</p>
                                    <ul>
                                        <li><a href="{{ route('babysitter-profile-show', [$babysitter->slug]) }}">See profile of your babysitter</a></li>
                                        <li><a href="">Read our guide for parents</a></li>
                                        <li><a href="">Contact your babysitter to provide more information</a></li>
                                    </ul>
                                    <p>Also remember to check our Facebook page for latest news and promotions!</p>
                                    <p><a href=""><span class="icon"><i class="fab fa-facebook"></i></span> Our Facebook page</a></p>
                                </div>
                            </div>
                            <div class="column">
                                <h2 class="subtitle is-5">Need to contact us?</h2>
                                <div class="content">
                                    <p class="semibold"><span class="icon"><i class="fas fa-comments"></i></span> <a href="">Message us on website</a></p>
                                    <p class="semibold"><span class="icon"><i class="fas fa-phone"></i></span> <a href="tel:">Call us:</a></p>
                                    <p class="semibold"><span class="icon"><i class="fas fa-envelope"></i></span> <a href="mail:">Email us:</a></p>
                                    <p>We aim to reply to any e-mail within 4 hours during office hours. If you don't hear from us make sure to call us. See our office hours below:</p>
                                    <table class="table is-narrow">
                                        <tr>
                                            <td>Monday-Friday</td>
                                            <td>08:00 - 15:00</td>
                                        </tr>
                                        <tr>
                                            <td>Saturday</td>
                                            <td>09:00 - 12:00</td>
                                        </tr>
                                        <tr>
                                            <td>Sunday</td>
                                            <td>Closed</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
