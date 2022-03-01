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
        <div id="home-hero" class="hero is-fullheight has-carousel">
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
                                    <a class="navbar-item">
                                        Contact Tripsitta
                                    </a>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </nav>

            <div id="carousel" class="hero-carousel">
                @yield('carousel-items', '')
            </div>

            <div class="hero-body">
                <div id="book-box">
                    <p class="title is-size-6 is-size-5-fullhd is-marginless">Book your holiday nanny or babysitter </p>
                    <div class="columns is-gapless">
                        <div class="column is-2-tablet is-1-desktop is-flex-desktop is-flex-column">
                            <div class="option is-active" id="option_h">
                                <a href="#" data-form_option="holiday"><p><i class="fas fa-suitcase-rolling fa-2x"></i></p><p>Holiday Nanny</p></a>
                            </div>
                            <div class="option" id="option_l">
                                <a href="#" data-form_option="local"><p><i class="fas fa-baby fa-2x"></i></p><p>Local Babysitter</p></a>
                            </div>
                        </div>
                        <div class="column is-10-tablet is-11-desktop is-flex-desktop">
                            <form id="holiday_form" method="post" action="search-holiday-nanny">
                                <div class="columns is-multiline">
                                    <div class="column is-6-tablet is-3-widescreen">
                                        <div class="field">
                                            <label class="label">Your location</label>
                                            <p class="control has-icons-left">
                                            <span class="select is-fullwidth">
                                              <select class="is-country-selector" name="travel_from" data-countryfield_id="from">
                                                  <option data-code="GB" selected="selected">United Kingdom</option>
                                                  <option disabled>──────────</option>
                                                  @foreach($countries as $code => $country)
                                                      <option data-code="{{$code}}">{{$country}}</option>
                                                  @endforeach
                                              </select>
                                            </span>
                                            <span class="icon is-small is-left">
                                                <span class="flag-icon flag-icon-squared is-country" data-countryfield="from"></span>
                                            </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="column is-6-tablet is-3-widescreen">
                                        <div class="field">
                                            <label class="label">Travelling to</label>
                                            <p class="control has-icons-left">
                                            <span class="select is-fullwidth">
                                              <select class="is-country-selector" name="travel_to" data-countryfield_id="to">
                                                  <option data-code="EMPTY" selected="selected" value="">Select your destination</option>
                                                  <option disabled>──────────</option>
                                                  @foreach($countries as $code => $country)
                                                      <option data-code="{{$code}}">{{$country}}</option>
                                                  @endforeach
                                              </select>
                                            </span>
                                                <span class="icon is-small is-left">
                                                <span class="flag-icon flag-icon-squared is-country" data-countryfield="to"></span>
                                            </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="column is-12-tablet is-3-widescreen">
                                        <div class="field">
                                            <div class="columns is-marginless is-gapless is-mobile">
                                                <div class="column">
                                                    <label class="label">Departure</label>
                                                </div>
                                                <div class="column">
                                                    <label class="label">Return</label>
                                                </div>
                                            </div>
                                            <p class="control">
                                                <input id="range-input" class="input" type="date">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="column is-12-tablet is-3-widescreen">
                                        <div class="control">
                                            <button class="button is-primary is-fullwidth"><span class="icon"><i class="fas fa-search"></i></span> <span>Search your holiday nanny</span></button>
                                        </div>
                                        @csrf
                                    </div>
                                </div>
                            </form>
                            <form id="local_form" method="post" style="display: none" action="search-local-babysitter">
                                <div class="columns is-multiline">
                                    <div class="column is-6-tablet is-3-widescreen">
                                        <div class="field">
                                            <label class="label">Your location</label>
                                            <p class="control has-icons-left">
                                                <span class="select is-fullwidth">
                                                  <select class="is-country-selector" name="location" data-countryfield_id="location">
                                                      <option data-code="EMPTY" selected="selected" value="">Select your location</option>
                                                      @foreach($countries_towns as $location)
                                                          <option data-code="{{$location->country}}" value="{{$location->country}} - {{$location->town}}">{{$location->town}}, {{Countries::getOne($location->country)}}</option>
                                                      @endforeach
                                                  </select>
                                                </span>
                                                <span class="icon is-small is-left">
                                                    <span class="flag-icon flag-icon-squared is-country" data-countryfield="location"></span>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="column is-6-tablet is-2-widescreen">
                                    <div class="field">
                                        <label class="label">Start</label>
                                        <p class="control">
                                            <input id="single_input" class="input" type="date">
                                        </p>
                                    </div>
                                    </div>
                                    <div class="column is-6-tablet is-2-widescreen">
                                        <div class="field">
                                            <label class="label">Start time</label>
                                            <p class="control">
                                                <div class="select is-fullwidth">
                                                    <select name="time" class="is-paddingless">
                                                        @php $start_timer = new \DateTime('00:00'); @endphp
                                                        @for($i = 0; $i < 48; $i++)
                                                            <option>{{$start_timer->add(new \DateInterval('PT30M'))->format('H:i')}}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="column is-6-tablet is-2-widescreen">
                                        <div class="field">
                                            <label class="label">Duration</label>
                                            <p class="control">
                                                <div class="select is-fullwidth">
                                                  <select name="duration" class="is-paddingless">
                                                      <option value="2">2 hrs</option>
                                                      <option value="2.5">2.5 hrs</option>
                                                      <option value="3">3hrs</option>
                                                      <option value="3.5">3.5 hrs</option>
                                                      <option value="4">4.5 hrs</option>
                                                      <option value="5">5 hrs</option>
                                                      <option value="6">6 hrs</option>
                                                      <option value="7">7 hrs</option>
                                                      <option value="8">8 hrs</option>
                                                      <option value="9">9 hrs</option>
                                                      <option value="10">10 hrs</option>
                                                      <option value="12">12 hrs</option>
                                                      <option value="24">all day</option>
                                                      <option value="48">2 days</option>
                                                  </select>
                                                </div>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="column is-12-tablet is-3-widescreen">
                                    <div class="control">
                                        <button class="button is-secondary has-text-white is-fullwidth"><span class="icon"><i class="fas fa-search"></i></span> <span>Search your local babysitter</span></button>
                                    </div>
                                    @csrf
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
