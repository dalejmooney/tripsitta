@extends('layouts.app')

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
                    <form method="post">
                        <h2 class="title is-4 has-text-primary">Contact & addresses</h2>
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
                                <label class="label">Mobile number (primary) *</label>
                                <input class="input @error('phone_number') is-danger @enderror" type="text" name="phone_number" placeholder="Phone number" value="{{ old('phone_number', $user->phone_number) }}" required>
                                <p class="help">Note: Please include country code</p>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Home number *</label>
                                <input class="input @error('home_phone_number') is-danger @enderror" type="text" name="home_phone_number" placeholder="Home phone number" value="{{ old('home_phone_number', $user->home_phone_number) }}" required>
                                <p class="help">Note: Please include country code</p>
                            </div>
                        </div>


                        <h3 class="title is-5 has-margin-top-xl has-text-primary">Home address</h3>
                        <div class="field">
                            <div class="control">
                                <label class="label">House number and street name *</label>
                                <input class="input @error('mainAddress.address1') is-danger @enderror" type="text" name="mainAddress[address1]" placeholder="" value="{{ old('mainAddress.address1', $user->babysitter->mainAddress ? $user->babysitter->mainAddress->address1 : '') }}" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Extra address line </label>
                                <input class="input @error('mainAddress.address2') is-danger @enderror" type="text" name="mainAddress[address2]" placeholder="" value="{{ old('mainAddress.address2', $user->babysitter->mainAddress ? $user->babysitter->mainAddress->address2 : '') }}">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Town *</label>
                                <input class="input @error('mainAddress.town') is-danger @enderror" type="text" name="mainAddress[town]" placeholder="" value="{{ old('mainAddress.town', $user->babysitter->mainAddress ? $user->babysitter->mainAddress->town : '') }}" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Postcode *</label>
                                <input class="input @error('mainAddress.postcode') is-danger @enderror" type="text" name="mainAddress[postcode]" placeholder="" value="{{ old('mainAddress.postcode', $user->babysitter->mainAddress ? $user->babysitter->mainAddress->postcode : '') }}" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Country *</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                      <select class="is-country-selector" name="mainAddress[country]">
                                          <option data-code="EMPTY" value="">Select your country</option>
                                          <option disabled>──────────</option>
                                          @foreach($countries as $code => $country)
                                              @if((old('mainAddress.country', $user->babysitter->mainAddress ? $user->babysitter->mainAddress->country : '')) == strtolower($code))
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

                        <h3 class="title is-5 has-margin-top-xl has-text-primary">Temporary address</h3>
                        <p class="subtitle is-6">Please enter your temporary address if you are living / studying or travelling abroad</p>
                        <div class="field">
                            <div class="control">
                                <label class="label">House number and street name</label>
                                <input class="input @error('temporaryAddress.address1') is-danger @enderror" type="text" name="temporaryAddress[address1]" placeholder="" value="{{ old('temporaryAddress.address1', $user->babysitter->temporaryAddress ? $user->babysitter->temporaryAddress->address1 : '') }}">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Extra address line</label>
                                <input class="input @error('temporaryAddress.address2') is-danger @enderror" type="text" name="temporaryAddress[address2]" placeholder="" value="{{ old('mainAddress.address2', $user->babysitter->temporaryAddress ? $user->babysitter->temporaryAddress->address2 : '') }}">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Town</label>
                                <input class="input @error('temporaryAddress.town') is-danger @enderror" type="text" name="temporaryAddress[town]" placeholder="" value="{{ old('temporaryAddress.town', $user->babysitter->temporaryAddress ? $user->babysitter->temporaryAddress->town : '') }}">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Postcode</label>
                                <input class="input @error('temporaryAddress.postcode') is-danger @enderror" type="text" name="temporaryAddress[postcode]" placeholder="" value="{{ old('temporaryAddress.postcode', $user->babysitter->temporaryAddress ? $user->babysitter->temporaryAddress->postcode : '') }}">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Country</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select class="is-country-selector" name="temporaryAddress[country]">
                                            <option data-code="EMPTY" selected="selected" value="">Select your country</option>
                                            <option disabled>──────────</option>
                                            @foreach($countries as $code => $country)
                                                @if((old('temporaryAddress.country', $user->babysitter->temporaryAddress ? $user->babysitter->temporaryAddress->country : '')) == strtolower($code))
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


                        <h3 class="title is-5 has-margin-top-xl has-text-primary">Emergency contact details</h3>
                        <div class="field">
                            <div class="control">
                                <label class="label">Contact name *</label>
                                <input class="input @error('emergency_name') is-danger @enderror" type="text" name="emergency_name" placeholder="Emergency contact name" value="{{ old('emergency_name', $user->emergency_name) }}" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Your relationship *</label>
                                <input class="input @error('emergency_relationship') is-danger @enderror" type="text" name="emergency_relationship" placeholder="Your relationship" value="{{ old('emergency_relationship', $user->emergency_relationship) }}" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">Mobile number (emergency) *</label>
                                <input class="input @error('emergency_phone_number') is-danger @enderror" type="text" name="emergency_phone_number" placeholder="Phone number" value="{{ old('emergency_phone_number', $user->phone_number) }}" required>
                                <p class="help">Note: Please include country code</p>
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
