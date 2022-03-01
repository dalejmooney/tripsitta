@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/pages/parent-profile-children.js') }}"></script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">My profile @if($user->family->reg_form_submitted == 0) <span class="has-tooltip-bottom" data-tooltip="Please complete the registration process to gain full access."><i class="fas fa-exclamation-circle has-text-warning"></i></span> @endif</h1>
            <p class="subtitle">Parent panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('parent.partials.menu')
                </div>
                <div class="column is-8">
                    <form method="post">
                        <h2 class="title is-4 has-text-primary">Complete your registration</h2>
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
                            <label class="label">How did you hear about us? *</label>
                            <p class="control">
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="found_source">
                                        <option value="">-</option>
                                        @foreach(config('tripsitta.found_source') as $reason)
                                            @if((old('found_source', '')) == $reason['value'])
                                                <option selected="selected" value="{{$reason['value']}}">{{$reason['label']}}</option>
                                            @else
                                                <option value="{{$reason['value']}}">{{$reason['label']}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            </p>
                        </div>

                        <p class="has-margin-top-lg">Once you confirm your registration, you'll automatically gain full access to Tripsitta parent portal. You'll be able to book and contact babysitters through our website.</p>

                        @csrf

                        @can('doFinalRegistrationForFamily')
                            <button type="submit" class="button is-block is-medium is-fullwidth has-margin-top-xl is-primary">Confirm registration</button>
                        @else
                            <div class="notification is-warning has-margin-top-xl">
                                <p>Please complete all required steps before saving.</p>
                            </div>
                            <button type="submit" class="button is-block is-medium is-fullwidth is-primary" disabled="disabled">Confirm registration</button>
                        @endcan


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
