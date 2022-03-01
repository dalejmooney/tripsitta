@extends('layouts.app_full_hero')

@section('meta_title') Reset password - Tripsitta @endsection
@section('meta_desc') Forgot your password ? Reset in here to access your account again @endsection

@section('content')
    <div class="hero-body">
        <div class="container">
            <h1 class="title">Reset your password</h1>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="field">
                    <div class="control">
                        <label class="label">E-mail *</label>
                        <input class="input @error('email') is-danger @enderror" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    </div>
                </div>
                @error('email')
                    <div class="notification is-danger">
                        <p>{{ $message }}</p>
                    </div>
                @enderror

                <div class="field">
                    <div class="control">
                        <label class="label">New password *</label>
                        <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="new-password">
                    </div>
                </div>
                @error('password')
                    <div class="notification is-danger">
                        <p>{{ $message }}</p>
                    </div>
                @enderror

                <div class="field">
                    <div class="control">
                        <label class="label">Repeat password *</label>
                        <input id="password-confirm" type="password" class="input" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <button type="submit" class="button is-block is-medium is-fullwidth is-primary">Reset password</button>

            </form>
        </div>
    </div>
@endsection
