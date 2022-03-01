@extends('layouts.app')

@section('scripts')

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
                        <h2 class="title is-4 has-text-primary">Home address *</h2>
                        <p class="subtitle is-7">Please enter your home address below. You'll be able to use it to speed up booking process. It's also used for invoicing. </p>

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
                            <div class="control">
                                <label class="label">House number and street name *</label>
                                <input class="input @error('address1') is-danger @enderror" type="text" name="address1" placeholder="" value="{{ old('address1', $user->family->address ? $user->family->address->address1 : '') }}" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Extra address line </label>
                                <input class="input @error('address2') is-danger @enderror" type="text" name="address2" placeholder="" value="{{ old('address2', !empty($user->family->address) ? $user->family->address->address2 : '') }}">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Town *</label>
                                <input class="input @error('town') is-danger @enderror" type="text" name="town" placeholder="" value="{{ old('town', !empty($user->family->address) ? $user->family->address->town : '') }}" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Postcode *</label>
                                <input class="input @error('postcode') is-danger @enderror" type="text" name="postcode" placeholder="" value="{{ old('postcode', !empty($user->family->address) ? $user->family->address->postcode : '') }}" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Country *</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select class="is-country-selector" name="country">
                                            <option data-code="EMPTY" value="">Select your country</option>
                                            <option disabled>──────────</option>
                                            @foreach($countries as $code => $country)
                                                @if((old('country', $user->family->address ? $user->family->address->country : '')) == strtolower($code))
                                                    <option selected="selected" value="{{strtolower($code)}}">{{$country}}</option>
                                                @else
                                                    <option value="{{strtolower($code)}}">{{$country}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
