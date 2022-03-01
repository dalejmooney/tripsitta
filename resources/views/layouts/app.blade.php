<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title',  config('app.name', 'Laravel'))</title>
    <meta name="description" content="@yield('meta_desc')">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js"></script>
    @yield('scripts', '')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">


    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
            <nav id="navbar-primary-wrapper" class="navbar" role="navigation" aria-label="main navigation">
                <div class="navbar-brand">
                    <a class="navbar-item" href="{{ route('home') }}">
                        <img src="{{ route('home') }}/images/tripsitta-logo-2x.png" srcset="{{ route('home') }}/images/tripsitta-logo.png, {{ route('home') }}/images/tripsitta-logo-2x.png 2x" alt="Tripsitta logo"/>
                    </a>

                    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>

                <div id="navbar-primary" class="navbar-menu">
                    <div class="navbar-end">
                        <a href="/" class="navbar-item is-hidden-tablet">
                            Home
                        </a>
                        @foreach($primary_navigation as $link)
                            <a href="{{ route('home') }}/{{$link['slug']}}" class="navbar-item">
                                {{$link['title']}}
                            </a>
                        @endforeach
                        <div class="navbar-item has-dropdown is-mega">
                            <div class="navbar-link">
                                Explore
                            </div>
                            <div class="navbar-dropdown">
                                <div class="navbar-dropdown-content">
                                    <p class="title is-4">Information & Guidelines</p>
                                    <div class="columns">
                                        <div class="column is-one-fifth">
                                            <p class="subtitle is-6">Booking process</p>
                                            <ul>
                                                @foreach($mega_menu->where('bucket', 'ex_1') as $link)
                                                    <li><a href="{{ route('home') }}/{{$link['slug']}}">{{$link['title']}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="column is-one-fifth">
                                            <p class="subtitle is-6">Guidelines</p>
                                            <ul>
                                                @foreach($mega_menu->where('bucket', 'ex_2') as $link)
                                                    <li><a href="{{ route('home') }}/{{$link['slug']}}">{{$link['title']}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="column is-one-fifth">
                                            <p class="subtitle is-6">About Us</p>
                                            <ul>
                                                @foreach($mega_menu->where('bucket', 'ex_3') as $link)
                                                    <li><a href="{{ route('home') }}/{{$link['slug']}}">{{$link['title']}}</a></li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="column is-two-fifths">
                                            <p class="subtitle is-6">Latest from our blog</p>
                                            @if($recent_post)
                                            <div class="blog_latest_wrapper">
                                                <p class="is-size-6"><a href="{{route('blog')}}/{{$recent_post->slug}}">{{$recent_post->title}}</a></p>
                                                <div class="content has-text-grey">
                                                    {!! $recent_post->description !!}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @guest
                        <div class="navbar-item navbar-mobile-inline">
                            <a id="register-button" href="{{ route('register-specific', 'babysitter') }}" class="button is-dark">
                                Become a Tripsitta nanny
                            </a>
                        </div>
                        <div class="navbar-item navbar-mobile-inline">
                            <a id="signin-button" href="{{ route('login') }}" class="button is-light">
                                Sign in
                            </a>
                        </div>
                        @else
                            <div class="navbar-item has-dropdown">
                                <a href="" class="navbar-link">
                                    Logged in as {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="navbar-dropdown is-right">
                                    @if(Auth::user()->role === 'babysitter')
                                        <a href="{{ route('babysitter.overview') }}" class="navbar-item">
                                            My profile
                                        </a>
                                        <a href="{{ route('babysitter-profile-show', [Auth::user()->slug]) }}" class="navbar-item">
                                            View public profile
                                        </a>
                                    @else
                                        <a href="{{ route('parent.overview') }}" class="navbar-item">
                                            My profile
                                        </a>
                                    @endif
                                    <a class="navbar-item has-text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Log out
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <hr class="navbar-divider">
                                    @if(Auth::user()->role === 'babysitter')
                                        <a class="navbar-item" href="{{route('babysitter.admin-chat')}}">
                                            Contact Tripsitta
                                        </a>
                                    @else
                                        <a class="navbar-item" href="{{route('parent.admin-chat')}}">
                                            Contact Tripsitta
                                        </a
                                    @endif
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </nav>
        </div>
        <main>
            @yield('content')
        </main>
        <footer>
            <div class="container">
                <div class="columns is-mobile is-multiline">
                    <div class="column is-2 is-hidden-mobile">
                        <figure class="image is-128x128">
                            <img src="{{ route('home') }}/images/tripsitta-logo-large.png" alt="tripsitta logo"/>
                        </figure>
                    </div>
                    <div class="column is-6-mobile is-2-tablet">
                        <p class="subtitle is-tripsitta is-size-7">Tripsitta</p>
                        <ul>
                            <li><a href="/" class="navbar-item">Home</a></li>
                            @foreach($primary_navigation as $link)
                                <li><a href="{{$link['slug']}}" class="navbar-item">
                                    {{$link['title']}}
                                </a></li>
                            @endforeach
                            <li><a href="/contact-us" class="navbar-item">Contact us</a></li>
                        </ul>
                    </div>
                    <div class="column is-6-mobile is-2-tablet">
                        <p class="subtitle is-tripsitta is-size-7">Booking process</p>
                        <ul>
                            @foreach($mega_menu->where('bucket', 'ex_1') as $link)
                                <li><a href="{{$link['slug']}}">{{$link['title']}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="column is-6-mobile is-2-tablet">
                        <p class="subtitle is-tripsitta is-size-7">Guidelines</p>
                        <ul>
                            @foreach($mega_menu->where('bucket', 'ex_2') as $link)
                                <li><a href="{{$link['slug']}}">{{$link['title']}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="column is-6-mobile is-2-tablet">
                        <p class="subtitle is-tripsitta is-size-7">About Us</p>
                        <ul>
                            @foreach($mega_menu->where('bucket', 'ex_3') as $link)
                                <li><a href="{{$link['slug']}}">{{$link['title']}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="column is-6-mobile is-2-tablet">
                        <p class="subtitle is-tripsitta is-size-7">Social</p>
                        <ul>
                            <li><a href=""><span class="icon"><i class="fab fa-facebook"></i></span>  Facebook</a></li>
                            <li><a href=""><span class="icon"><i class="fab fa-twitter"></i></span>  Twitter</a></li>
                            <li><a href=""><span class="icon"><i class="fab fa-pinterest"></i></span>  Pinterest</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <p id="copyright" class="has-text-right is-size-7 has-text-grey">2020 © Copyright Tripsitta</p>
    </div>
</body>
</html>
