@extends('layouts.app')

@section('scripts')
    <script>
        var max_date = '{{$calendar['max_date']}}';
        var blocked_dates = '{!! json_encode($calendar['blocked_dates']) !!}';
    </script>
    <script src="{{ mix('js/helpers.js') }}"></script>
    <script src="{{ mix('js/pages/profile-submit-application.js') }}"></script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">My profile @if($user->babysitter->reg_form_submitted == 0) <span class="has-tooltip-bottom" data-tooltip="Please complete the registration process to gain full access."><i class="fas fa-exclamation-circle has-text-warning"></i></span> @endif</h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('babysitter.partials.menu')
                </div>
                <div class="column is-8">
                    <form method="post" enctype="multipart/form-data">
                        <h2 class="title is-4 has-text-primary">Book an interview & submit application</h2>
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

                        <div class="field">
                            <label class="label">Interview date *</label>
                            <p class="control">
                                <input id="single_input" class="input" type="date" name="interview_date" value="{{old('interview_date', '')}}">
                            </p>
                        </div>

                        <div class="field">
                            <label class="label">Preferred time *</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="interview_time">
                                        <option value="">-</option>
                                        @foreach(config('tripsitta.interview_hours') as $hour)
                                            @if((old('interview_time', '')) == $hour['label'])
                                                <option selected="selected">{{$hour['label']}}</option>
                                            @else
                                                <option>{{$hour['label']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="notification is-info">
                            <p>Please note: We'll contact you to confirm the interview time.</p>
                        </div>

                        <div class="field">
                            <label class="label">How did you hear about us? *</label>
                            <p class="control">
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="found_source">
                                        <option value="">-</option>
                                        @foreach(config('tripsitta.found_source') as $source)
                                            @if((old('found_source', '')) == $source['value'])
                                                <option selected="selected" value="{{$source['value']}}">{{$source['label']}}</option>
                                            @else
                                                <option value="{{$source['value']}}">{{$source['label']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            </p>
                        </div>

                        @csrf
                        @can('doFinalRegistrationForBabysitter')
                            <button type="submit" class="button is-block is-medium is-fullwidth has-margin-top-xl is-primary">Book interview &amp; submit application</button>
                        @else
                            <div class="notification is-warning has-margin-top-xl">
                                <p>Please complete all required steps before booking the interview.</p>
                            </div>
                            <button type="submit" class="button is-block is-medium is-fullwidth is-primary" disabled="disabled">Book interview &amp; submit application</button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
