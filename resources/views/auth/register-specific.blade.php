@extends('layouts.app_full_hero')

@section('meta_title'){{ $page->meta_title }}@endsection
@section('meta_desc'){{ $page->meta_desc }}@endsection

@section('content')
    <div class="hero-body">
        <div class="container">
            <h1 class="title @if($account_type == 'parent') has-text-secondary @elseif($account_type == 'babysitter') has-text-primary @endif">@if($account_type == 'parent') <i class="fas fa-users has-text-secondary"></i> Parent - @elseif($account_type == 'babysitter') <i class="fas fa-baby has-text-primary"></i> Babysitter - @endif {{ $page->title }}</h1>

            <form method="POST" action="{{ route('register') }}">
                @if ($errors->any())
                    <div class="notification is-danger">
                        @foreach ($errors->all() as $error)
                            <p>{{$error}}</p>
                        @endforeach
                    </div>
                @endif

                @if($account_type == 'any')
                    <div class="field">
                        <div class="control">
                            <label class="label">Account type *</label>
                            <div class="select">
                                <select name="account_type" required>
                                    <option value="">-</option>
                                    <option value="parent">Parent</option>
                                    <option value="babysitter">Babysitter</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="field">
                    <div class="control">
                        <label class="label">First name *</label>
                        <input class="input @error('name') is-danger @enderror" type="text" name="name" placeholder="First name" value="{{ old('name') }}" required>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <label class="label">Surname *</label>
                        <input class="input @error('surname') is-danger @enderror" type="text" name="surname" placeholder="Surname" value="{{ old('surname') }}" required>
                    </div>
                </div>

                @if($account_type != 'any')
                    <div class="field">
                        <div class="control">
                            <label class="label">E-mail *</label>
                            <input class="input @error('email') is-danger @enderror" type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required >
                        </div>
                    </div>
                @else
                    <div class="field">
                        <div class="control">
                            <label class="label">E-mail *</label>
                            <p>{{ old('email') }}</p>
                        </div>
                    </div>
                @endif

                <div class="field">
                    <div class="control">
                        <label class="label">Date of birth *</label>
                        <input class="input @error('dob') is-danger @enderror" type="date" name="dob" placeholder="DOB" value="{{ old('dob') }}" required >
                        <p class="help">Why do we need it? We ask parents and babysitters to provide their DOB during registration. It helps us in keeping everyone safe when using our services. </p>
                    </div>
                </div>

                @if($account_type != 'any')
                    <div class="field">
                        <div class="control">
                            <label class="label">Password *</label>
                            <input class="input @error('email') is-danger @enderror" type="password" name="password" value="" required >
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <label class="label">Repeat password *</label>
                            <input class="input @error('password_confirmation') is-danger @enderror" type="password" name="password_confirmation" value="" required >
                        </div>
                    </div>
                @endif

                <div class="field">
                    <label class="checkbox">
                        <input type="checkbox" name="accept_tnc" value="1" id="accept_tnc" {{ old('accept_tnc') ? 'checked' : '' }} required>
                        Accept <a href="{{ route('home') }}/terms-conditions">Terms & Conditions</a>
                    </label>
                </div>

                <br />

                <button type="submit" class="button is-block is-medium is-fullwidth @if($account_type == 'parent') is-secondary @elseif($account_type == 'babysitter') is-primary @endif">Register new account</button>
                @csrf
                @if($account_type != 'any')
                    <input type="hidden" name="account_type" value="{{$account_type}}"/>
                @else
                    <input type="hidden" name="id" value="{{ old('id') }}"/>
                @endif
            </form>
        </div>
    </div>
@endsection
