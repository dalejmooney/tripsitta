@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/rater.js') }}"></script>
    <script src="{{ mix('js/pages/booking-review.js') }}"></script>
    <script>
        var storeReviewUrl = '{{route('parent.booking-review', [$booking->id])}}';
    </script>
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
                    <h2 class="title is-4 has-text-primary">Leave feedback for booking {{$booking->idPadded}}</h2>
                    <p class="notification">This form allows you to leave a publicly visible review for your babysitter.</p>
                    <form method="post" id="review_form" class="has-margin-bottom-xl">
                        <div class="field">
                            <div class="control is-expanded">
                                <label class="label">Rating</label>
                                <div class="is-size-4 has-text-primary"><div class="rating"></div></div>
                                <input type="hidden" value="1" name="rating"/>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Title</label>
                                <input class="input" name="title"/>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control is-expanded">
                                <label class="label">Your message</label>
                                <textarea class="textarea" placeholder="Enter your feedback here..." rows="5" name="message"></textarea>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-info" id="add_review" type="submit">
                                    Add review
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
