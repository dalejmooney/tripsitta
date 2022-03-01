@extends('layouts.app_full_hero')

@section('scripts')

@endsection

@section('content')
    <div class="notification is-secondary has-text-white has-text-centered">
        <span class="icon is-large>"><i class="far fa-plus-square"></i></span> <a href="{{route('register')}}">If you don't have an account yet - click here to register</a>
    </div>
    <div class="hero-body">
        <div class="container has-text-centered">
            <div class="column is-6 is-offset-3">
                @if (\Session::has('error-msg'))
                    <div class="notification is-danger">
                        {{Session::get('error-msg')}}
                    </div>
                @endif
                <h1 class="title has-text-left">Sign in </h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="login_buttons">
                        <p>
                            <a href="{{route('facebook_login')}}" class="facebook-button button is-fullwidth is-medium"><span class="icon"><i class="fab fa-facebook-f"></i></span> <span>Log in with Facebook</span></a>
                        </p>
                        <p>
                            <a href="{{route('google_login')}}" class="google-button button is-fullwidth is-medium"><span class="icon"><i class="fab fa-google"></i></span> <span>Log in with Google</span></a>
                        </p>
                        <div class="or_line"><span>or</span></div>
                    </div>
                    <div class="field">
                        <p class="control has-icons-left has-icons-right">
                            <input class="input @error('email') is-danger @enderror" type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <span class="icon is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                        </p>
                        @error('email')
                        <p class="help is-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                    <div class="field">
                        <p class="control has-icons-left">
                            <input class="input @error('password') is-danger @enderror" type="password" placeholder="Password"  name="password" required autocomplete="current-password">
                            <span class="icon is-left">
                                <i class="fas fa-lock"></i>
                            </span>
                        </p>
                        @error('password')
                        <p class="help is-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </p>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="checkbox">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            Remember me
                        </label>
                    </div><br />
                    <button type="submit" class="button is-block is-primary is-medium is-fullwidth">Login</button><br /><br />
                    <p>
                        <a href="{{route('register')}}">Sign Up</a> &nbsp;·&nbsp;
                        <a href="{{route('password.request')}}">Forgot Password</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
