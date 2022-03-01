@extends('layouts.app')

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
                        <h2 class="title is-4 has-text-primary">General info</h2>
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
                                <label class="label">First name *</label>
                                <input class="input @error('name') is-danger @enderror" type="text" name="name" placeholder="First name" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label">Surname *</label>
                                <input class="input @error('surname') is-danger @enderror" type="text" name="surname" placeholder="Surname" value="{{ old('surname', $user->surname) }}" required>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label">E-mail *</label>
                                <p>{{$user->email}}</p>
                                <p class="help">Note: You cannot change your email address here. Please contact us if you need to change it and we'll help.</p>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label">Date of birth *</label>
                                <input class="input @error('dob') is-danger @enderror" type="date" name="dob" value="{{ old('dob', ($user->dob) ? $user->dob->format('Y-m-d') : '') }}" required >
                                <p class="help">Why do we need it? We ask parents and babysitters to provide their DOB during registration. It helps us in keeping everyone safe when using our services. </p>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label">Phone number *</label>
                                <input class="input @error('phone_number') is-danger @enderror" type="text" name="phone_number" placeholder="Phone number" value="{{ old('phone_number', $user->phone_number) }}" required>
                                <p class="help">Note: Please include country code</p>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label">Emergency phone number *</label>
                                <input class="input @error('emergency_phone_number') is-danger @enderror" type="text" name="emergency_phone_number" placeholder="Emergency phone number" value="{{ old('emergency_phone_number', $user->emergency_phone_number) }}" required>
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
