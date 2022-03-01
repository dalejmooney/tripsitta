@extends('layouts.app_full_hero')

@section('meta_title') Reset password - Tripsitta @endsection
@section('meta_desc') Forgot your password ? Reset in here to access your account again @endsection

@section('content')
    <div class="hero-body">
        <div class="container">
            <h1 class="title">Reset your password</h1>

            @if (session('status'))
                <div class="notification is-success">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="field">
                    <div class="control">
                        <label class="label">E-mail *</label>
                        <input class="input @error('email') is-danger @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                </div>

                @error('email')
                    <div class="notification is-danger">
                        <p>{{ $message }}</p>
                    </div>
                @enderror

                <button type="submit" class="button is-block is-medium is-fullwidth is-primary">Send Password Reset Link</button>

            </form>
        </div>
    </div>
@endsection
