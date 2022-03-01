@extends('layouts.app_full_hero')

@section('meta_title'){{ $page->meta_title }}@endsection
@section('meta_desc'){{ $page->meta_desc }}@endsection

@section('content')
    <div class="hero-body">
        <div class="container">
            <h1 class="title">{{ $page->title }}</h1>
            @if($page->subtitle)
                <p class="subtitle is-6">{{ $page->subtitle }}</p>
            @endif

            <div class="columns has-text-centered has-margin-top-xl">
                <div class="column is-6">
                    <p><span class="icon is-large"><i class="fas fa-4x fa-baby has-text-primary"></i></span></p>
                    <p class="has-text-primary is-size-4">Babysitter / Holiday nanny</p>
                    <p><a href="{{route('register-specific', ['babysitter'])}}" class="button is-tripsitta has-margin-top-md is-primary is-outlined">Become a Tripsitta nanny</a></p>
                    <p class="has-padding-top-lg"><span class="has-text-weight-bold">Activation required</span></p><p> Babysitter profiles require approval <br /> from the Tripsitta team before they can be activated.</p>
                </div>
                <div class="column is-6">
                    <p><span class="icon is-large "><i class="fas fa-4x fa-users has-text-secondary"></i></span></p>
                    <p class="has-text-secondary is-size-4">Parent</p>
                    <p><a href="{{route('register-specific', ['parent'])}}" class="button is-tripsitta has-margin-top-md is-secondary is-outlined">Register now</a></p>
                    <p class="has-padding-top-lg"><span class="has-text-weight-bold">Instant access</span></p><p>Book your first babysitter or holiday nanny.<br /> It only takes few minutes</p>
                </div>
            </div>
            <div class="has-text-centered has-margin-top-xl">
                <div class="or_line has-margin-bottom-lg"><span>or</span></div>
                <p class="has-margin-bottom-md">To speed up the process you can register with your Facebook / Google account...</p>
                <p>
                    <a href="{{route('facebook_login')}}" class="facebook-button button is-tripsitta has-margin-bottom-sm"><span class="icon"><i class="fab fa-facebook-f"></i></span> <span>Log in with Facebook</span></a>
                    <a href="" class="google-button button is-tripsitta"><span class="icon"><i class="fab fa-google"></i></span> <span>Log in with Google</span></a>
                </p>
            </div>

        </div>
    </div>
@endsection
