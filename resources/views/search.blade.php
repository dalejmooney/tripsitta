@extends('layouts.app')

@section('meta_title'){{ $page->meta_title }}@endsection
@section('meta_desc'){{ $page->meta_desc }}@endsection

@section('scripts')
    <script src="{{ mix('js/pages/search.js') }}"></script>
    <script>
        @if(isset($search_params) && array_key_exists('start_date', $search_params))
            var selected_start = new Date("{{(DateTime::createFromFormat('d/m/Y', $search_params['start_date']))->format('Y-m-d')}}");
            var selected_return =  new Date("{{(DateTime::createFromFormat('d/m/Y', $search_params['return_date']))->format('Y-m-d')}}");
        @else
            var selected_start = '';
            var selected_return =  '';
        @endif
    </script>
@endsection

@section('content')
     <div class="hero is-light">
        <div class="hero-body">
            <div class="container">
                <h1 class="title">{{ $page->title }}</h1>
                @if($page->subtitle)
                    <p class="subtitle is-6">{{ $page->subtitle }}</p>
                @endif

                <div class="booking_type_selector">
                    <a href="{{ route('search-holiday-nanny')  }}" class="has-text-primary active"><span class="icon"><i class="fas fa-suitcase-rolling fa-2x"></i></span> Holiday nanny</a>
                    <a href="{{ route('search-local-babysitter')  }}" class=""><span class="icon"><i class="fas fa-baby fa-2x"></i></span> Local babysitter</a>
                </div>

                <form id="search-form" method="post" action="search-holiday-nanny">
                    <div class="columns is-marginless">
                        <div class="column">
                            <div class="field">
                                <label class="label">Your location</label>
                                    <p class="control has-icons-left">
                                        <span class="select is-fullwidth">
                                          <select class="is-country-selector" name="travel_from" data-countryfield_id="from">
                                              <option data-code="GB" selected="selected">United Kingdom</option>
                                              <option disabled>──────────</option>
                                              @foreach($countries as $code => $country)
                                                  @if(isset($search_params) && array_key_exists('travel_from', $search_params) && $country == $search_params['travel_from'])
                                                      <option data-code="{{$code}}" selected="selected">{{$country}}</option>
                                                  @else
                                                      <option data-code="{{$code}}">{{$country}}</option>
                                                  @endif
                                              @endforeach
                                          </select>
                                        </span>
                                    <span class="icon is-small is-left">
                                         <span class="flag-icon flag-icon-squared is-country" data-countryfield="from"></span>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Travelling to</label>
                                <p class="control has-icons-left">
                                <span class="select is-fullwidth">
                                  <select class="is-country-selector" name="travel_to" data-countryfield_id="to">
                                      <option data-code="EMPTY" selected="selected" value="">Select your destination</option>
                                      <option disabled>──────────</option>
                                      @foreach($countries as $code => $country)
                                          @if(isset($search_params) && array_key_exists('travel_to', $search_params) && $country == $search_params['travel_to'])
                                              <option data-code="{{$code}}" selected="selected">{{$country}}</option>
                                          @else
                                              <option data-code="{{$code}}">{{$country}}</option>
                                          @endif
                                      @endforeach
                                  </select>
                                </span>
                                <span class="icon is-small is-left">
                                    <span class="flag-icon flag-icon-squared is-country" data-countryfield="to"></span>
                                </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="field has-padding-top-md">
                        <div class="columns is-marginless is-mobile is-multiline">
                            <div class="column is-6 has-padding-bottom-none">
                                <label class="label has-padding-bottom-xs">Departure</label>
                            </div>
                            <div class="column is-6 has-padding-bottom-none">
                                <label class="label">Return</label>
                            </div>
                            <div class="column is-12 has-padding-top-none">
                                <p class="control">
                                    <input id="range-input" class="input" type="date">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="control">
                        <div class="columns">
                            <div class="column is-9-tablet is-10-desktop">
                                @csrf
                                <button class="button is-primary is-fullwidth"><span class="icon"><i class="fas fa-search"></i></span> <span>Search your holiday nanny</span></button>
                            </div>
                            <div class="column is-3-tablet is-2-desktop">
                                <a id="reset_search" class="button is-secondary is-outlined is-fullwidth" href="{{ route('holiday-nanny-show-all') }}">
                                    <span class="icon">
                                        <span class="fa-stack">
                                            <i class="fas fa-search fa-stack-1x"></i>
                                            <i class="fas fa-slash fa-stack-1x"></i>
                                        </span>
                                    </span>
                                    <span>Reset search</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
     </div>
     <div class="filters_show is-hidden-desktop has-text-centered has-padding-md">
         <a class="button is-link is-outlined is-fullwidth">Filter results</a>
     </div>

     <div class="container has-margin-top-lg babysitters-container">
     @if(count($nannies) == 0)
             @if(!$valid_booking_window)
                 <div class="hero is-info is-medium has-margin-bottom-xl">
                     <div class="hero-body has-text-centered">
                         <h3 class="title is-4">Incorrect booking dates</h3>
                         <p class="subtitle is-6">Please make sure your search is for correct dates</p>
                         <p><a href="mailto:info@tripsitta.com" class="has-text-white has-text-weight-bold">info@tripsitta.com</a> or <a href="tel:+393920397288" class="has-text-white has-text-weight-bold">+39 392 039 7288</a></p>
                     </div>
                 </div>
             @else
                 <div class="hero is-info is-medium has-margin-bottom-xl">
                     <div class="hero-body has-text-centered">
                         <h3 class="title is-4">We didn't find a match for the country and dates you provided.</h3>
                         <p class="subtitle is-6">Please try adjusting your requirements or contact us and we'll try to help you !</p>
                         <p><a href="mailto:info@tripsitta.com" class="has-text-white has-text-weight-bold">info@tripsitta.com</a> or <a href="tel:+393920397288" class="has-text-white has-text-weight-bold">+39 392 039 7288</a></p>
                     </div>
                 </div>
             @endif
     @endif

     @if(count($nannies) > 0)
         <div class="columns">
             <div class="column is-hidden-mobile is-hidden-tablet-only is-3-desktop filters-column">
                 <form class="form-filtering">
                     <div class="close has-text-danger is-hidden-desktop is-pulled-right"><a><i class="fas fa-times fa-2x"></i></a></div>
                     <div class="">
                         <figure class="image-tripsitta">
                             <img src="{{ route('home') }}/images/tripsitta-logo-large.png" alt="Tripsitta logo"/>
                         </figure>
                         <span class="image-tripsitta-text is-size-5">Filter results</span>
                     </div>

                     <div class="field">
                         <label class="label">Years of experience</label>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="experience[]" value="0"> Less than 1 year
                             </label>
                         </div>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="experience[]" value="1"> 1-2 years
                             </label>
                         </div>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="experience[]" value="2"> 2-5 years
                             </label>
                         </div>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="experience[]" value="5"> More than 5 years
                             </label>
                         </div>
                     </div>
                     <div class="field">
                         <label class="label">Experience (child age)</label>
                         @foreach(config('tripsitta.experience_age_groups') as $key => $exp)
                             <div class="control">
                                 <label class="checkbox">
                                     <input type="checkbox" name="filter_experience_age[]" value="{{$exp['value']}}"> {{$exp['label']}}
                                 </label>
                             </div>
                         @endforeach
                     </div>
                     <div class="field">
                         <label class="label">Spoken languages</label>
                         @foreach($available_languages as $key => $lang)
                             <div class="control">
                                 <label class="checkbox">
                                     <input type="checkbox" name="filter-language[]" value="{{$lang}}"> {{\App\Extensions\ExtCountries::getOneLanguage($lang)}}
                                 </label>
                             </div>
                         @endforeach
                     </div>
                     <div class="field">
                         <label class="label">First Aid Training</label>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="filter-first_aid" value="yes"> First Aid Training passed
                             </label>
                         </div>
                     </div>
                     <div class="field">
                         <label class="label">Childcare qualifications</label>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="filter-qualifications" value="yes"> Show only babysitters with childcare qualifications
                             </label>
                         </div>
                     </div>
                     <div class="field">
                         <label class="label">Review score</label>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="filter-review[]" value="1"> 1 star
                             </label>
                         </div>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="filter-review[]" value="2"> 2 stars
                             </label>
                         </div>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="filter-review[]" value="3"> 3 stars
                             </label>
                         </div>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="filter-review[]" value="4"> 4 stars
                             </label>
                         </div>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="filter-review[]" value="5"> 5 stars
                             </label>
                         </div>
                         <div class="control">
                             <label class="checkbox">
                                 <input type="checkbox" name="filter-review[]" value="0"> Unrated
                             </label>
                         </div>
                     </div>
                     <div class="field has-padding-bottom-lg">
                         <a id="filter_results" class="button is-fullwidth is-primary is-outlined">Filter results</a>
                     </div>
                 </form>
             </div>
             <div class="column is-12-tablet is-9-desktop has-text-centered-mobile">
                 <div class="tripsitta-pricing">
                     <p class="subtitle is-5 has-text-centered is-hidden-tablet has-padding-top-md">Our pricing is simple:</p>
                     <div class="columns is-multiline is-mobile">
                         <div class="column is-hidden-mobile is-4-tablet">
                             <div class="level">
                                 <div class="level-left">
                                     <div class="level-item">
                                         <p class="tag tripsitta-pricing-box is-multiline is-primary is-outlined">Same <br/> price</p>
                                     </div>
                                     <div class="level-item">
                                         <p>same price when<br /> booking any babysitter<br /> on our website</p>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="column is-6-mobile is-4-tablet">
                             <div class="level">
                                 <div class="level-left">
                                     <div class="level-item">
                                         <p class="tag tripsitta-pricing-box is-primary">€{{$price_base}}</p>
                                     </div>
                                     <div class="level-item">
                                         <p>for the first child<br /> per day</p>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="column is-6-mobile is-4-tablet">
                             <div class="level">
                                 <div class="level-left">
                                     <div class="level-item">
                                         <p class="tag tripsitta-pricing-box is-primary is-outlined">€{{$price_extra_per_child}}</p>
                                     </div>
                                     <div class="level-item">
                                         <p>extra for each<br /> additional child<br /> per day</p>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>

                 <div class="babysitter-notifications">
                     @if(session('message'))
                         <div class="notification is-danger has-margin-top-md">
                             <p>{{session('message')}}</p>
                         </div>
                     @endif
                 </div>

                 <p class="subtitle is-4 has-text-centered is-hidden-tablet has-margin-top-lg has-padding-top-md">Search results:</p>

                 @foreach($nannies as $user)
                     <div class="babysitter"
                          data-experience="{{$user->experience_years ?? 0}}"
                          data-experience_age_groups="{{json_encode($user->experienceAgeGroups->map->only('age_group')->flatten()->toArray())}}"
                          data-languages="{{json_encode($user->languages->map->only('language_name')->flatten()->toArray())}}"
                          data-review_count="{{$user->reviewsNumber}}"
                          data-review_score="{{$user->reviewsAverage}}"
                          data-first_aid="{{(int) $user->hasValidFirstAidTraining()}}"
                          data-qualifications="{{(int) $user->has_valid_qualifications }}"
                     >
                         <div class="columns is-mobile is-multiline">
                             <div class="column is-12-mobile is-4-tablet is-3-desktop">
                                 <div class="babysitter-img-container">
                                     <figure class="image is-square">
                                         <a href="{{ route('babysitter-profile-show', [$user->user->slug]) }}"><img class="is-rounded" src="{{$user->image('profile_image')}}" alt="Tripsitta - photo of babysitter - {{$user->user->name}}"/></a>
                                     </figure>
                                 </div>
                                 @if($user->experienceAgeGroups->count() !== 0)
                                     <p class="subtitle is-7 has-padding-top-md is-marginless has-text-centered">Experienced with children aged:</p>
                                     <p class="is-size-5 has-text-centered is-paddingless has-text-grey-light">
                                         @foreach($user->experienceAgeGroups as $exp)
                                             @if($exp->age_group === '0')
                                                 <span data-tooltip="0-1 years old" class="has-padding-xs"><i class="fas fa-baby-carriage"></i></span>
                                             @elseif($exp->age_group === '1')
                                                 <span data-tooltip="1-3 years old" class="has-padding-xs"><i class="fas fa-baby"></i></span>
                                             @elseif($exp->age_group === '4')
                                                 <span data-tooltip="4-7 years old" style="font-size:1.2em" class="has-padding-xs"><i class="fas fa-child"></i></span>
                                             @elseif($exp->age_group === '8')
                                                 <span data-tooltip="8-11 years old" style="font-size:1.2em" class="has-padding-xs"><i class="fas fa-male"></i></span>
                                             @elseif($exp->age_group === '12')
                                                 <span data-tooltip="12+ years old" style="font-size:1.4em" class="has-padding-xs"><i class="fas fa-male"></i></span>
                                             @endif
                                         @endforeach
                                     </p>
                                 @endif
                             </div>
                             <div class="column is-12-mobile is-8-tablet is-9-desktop">
                                 <h3 class="title is-5">@if($user->experience_years) <span class="experience_years" data-tooltip="{{$user->experience_years}} years of experience">{{$user->experience_years}}</span> @endif <a href="{{ route('babysitter-profile-show', [$user->user->slug]) }}">{{$user->user->name}}</a>
                                     @if($user->hasValidFirstAidTraining())
                                         <span class="icon has-text-grey-light has-padding-left-md" data-tooltip="First Aid Training passed"><i class="fas fa-first-aid"></i></span>
                                     @endif
                                     @if($user->has_valid_qualifications)
                                         <span class="icon has-text-grey-light has-padding-left-md" data-tooltip="Valid childcare qualifications"><i class="fas fa-certificate"></i></span>
                                     @endif
                                 </h3>
                                 @if($user->languages && count($user->languages) > 0)
                                     <div class="language-icons">
                                         <small class="is-size-7">Languages:</small>
                                         @foreach($user->languages as $language)
                                             <span class="language-icon" data-tooltip="{{\App\Extensions\ExtCountries::getOneLanguage($language->language_name, 'label')}} - {{$language->levelName}}"><i class="flag-icon flag-icon-squared is-country flag-icon-lang-{{strtolower($language->language_name)}}"></i></span>
                                         @endforeach
                                     </div>
                                 @endif
                                 @if($user->reviewsNumber == 0)
                                     <p class="subtitle is-7"><i class="fas fa-star"></i> No reviews yet</p>
                                 @else
                                     <p class="subtitle is-7"><i class="fas fa-star"></i> {{$user->reviewsAverage}} / 5 ({{$user->reviewsNumber}} reviews)</p>
                                 @endif
                                 <div class="content">
                                     {!! \Illuminate\Support\Str::limit(html_entity_decode(nl2br(e($user->profile_content))), 300) !!}
                                 </div>
                                 <div class="babysitter-action">
                                     @if(isset($search_params))
                                         <a href="{{ route('book-holiday-nanny', [$user->user->slug, $search_params['travel_from'], $search_params['travel_to'], $start_date->format('Y-m-d'), $end_date->format('Y-m-d')]) }}" class="button is-primary is-tripsitta"><span class="icon"><i class="fas fa-suitcase-rolling"></i></span><span>Book your holiday nanny</span></a>
                                     @else
                                         <a href="{{ route('babysitter-profile-show', [$user->user->slug]) }}" class="button is-primary is-tripsitta is-outlined"><span>View nanny profile</span></a>
                                     @endif
                                 </div>
                             </div>
                         </div>
                     </div>
                 @endforeach
             </div>
         </div>
         @endif

     </div>
     <div class="container">
         {!! $page->renderBlocks(false) !!}
     </div>
@endsection
