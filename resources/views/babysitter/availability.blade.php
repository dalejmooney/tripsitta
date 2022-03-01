@extends('layouts.app')

@section('scripts')
    <script>
        $(document).ready(function() {
            availability_babysitter = '{!! json_encode($availability['babysitter'])!!}';
            availability_holiday_nanny = '{!!json_encode($availability['holiday_nanny'])!!}';
        });
    </script>
    <script src="{{ mix('js/pages/babysitter-availability.js') }}"></script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Booking Availability</h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('babysitter.partials.menu')
                 </div>
                <div class="column is-8">
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

                    <form method="post">
                        <h2 class="title is-4 has-text-primary">Babysitting</h2>
                        <div class="field">
                            <label class="label">Are you looking for babysitting jobs?</label>
                            <div class="control">
                                <label class="radio">
                                    <input type="radio" name="jobs_babysitter" value="1" {!! (old('jobs_babysitter', $user->babysitter->jobs_babysitter) == 1) ? 'checked="checked"' : '' !!}>
                                    Yes
                                </label>
                                <label class="radio">
                                    <input type="radio" name="jobs_babysitter" value="0" {!! (old('jobs_babysitter', $user->babysitter->jobs_babysitter) == 0) ? 'checked="checked"' : '' !!}>
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="is-hidden" id="babysitting_availability">
                            <p class="label">Availability</p>

                            <div id="calendar"></div>
                            <div class="calendar-legend has-margin-top-lg">
                                <p class="legend-babysitter-day"><span></span> Available for babysitting during the day</p>
                                <p class="legend-babysitter-night"><span></span> Available for babysitting during the night</p>
                            </div>
                        </div>

                        <h2 class="title is-4 has-text-primary has-margin-top-xl">Holiday nanny</h2>
                        <div class="field">
                            <label class="label">Are you looking for holiday nanny jobs?</label>
                            <div class="control">
                                <label class="radio">
                                    <input type="radio" name="jobs_holiday_nanny" value="1" {!! (old('jobs_holiday_nanny', $user->babysitter->jobs_holiday_nanny) == 1) ? 'checked="checked"' : '' !!}>
                                    Yes
                                </label>
                                <label class="radio">
                                    <input type="radio" name="jobs_holiday_nanny" value="0" {!! (old('jobs_holiday_nanny', $user->babysitter->jobs_holiday_nanny) == 0) ? 'checked="checked"' : '' !!}>
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="is-hidden" id="holiday_nanny_availability">
                            <p class="label">Availability</p>

                            <div id="calendar2"></div>
                            <div class="calendar-legend has-margin-top-lg">
                                <p class="legend-holiday-nanny"><span></span> Available as holiday nanny</p>
                            </div>
                        </div>

                        @csrf
                        <button type="submit" class="button is-block is-medium is-fullwidth has-margin-top-xl is-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
