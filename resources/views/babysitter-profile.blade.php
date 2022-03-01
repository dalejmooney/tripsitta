@extends('layouts.app')

@section('meta_title') {{$user->name}} - Babysitter profile - Tripsitta @endsection
@section('meta_desc')@endsection

@section('scripts')

@endsection

@section('content')
    @if($user->babysitter->profile_background != '')
        <div id="babysitter-profile-hero" class="hero is-medium is-light has-background" style="background-image: url('{{ route('home') }}/images/background_babysitter/{{$user->babysitter->profile_background}}')">
    @else
        <div id="babysitter-profile-hero" class="hero is-medium is-light has-background" style="background-image: url('{{ route('home') }}/images/background_babysitter/default.jpg')">
    @endif
        <div class="hero-body"></div>
        <div class="hero-footer">
            <div class="container has-text-centered">
                <div class="babysitter-img-container">
                    <figure class="image is-square">
                        <img class="is-rounded" src="{{$user->babysitter->image('profile_image')}}" alt="Tripsitta - photo of babysitter - {{$user->name}}"/>
                    </figure>
                </div>

                <h1 class="title is-1 has-margin-sm">@if($user->babysitter->experience_years) <span class="experience_years" data-tooltip="{{$user->babysitter->experience_years}} years of experience">{{$user->babysitter->experience_years}}</span> @endif {{$user->name}}</h1>
                <p class="subtitle has-padding-top-sm">
                    @if($user->babysitter->jobs_babysitter == 1)
                        <span class="tag is-small is-secondary"><span class="icon"><i class="fas fa-suitcase-rolling"></i></span><span>Accepts babysitter jobs</span></span>
                    @endif
                    @if($user->babysitter->jobs_holiday_nanny == 1)
                        <span class="tag is-small is-primary"><span class="icon"><i class="fas fa-baby"></i></span><span>Accepts holiday nanny jobs</span></span>
                    @endif
                </p>

                @if($user->babysitter->jobs_babysitter == 1)
                    @if($user->babysitter->temporaryAddress && $user->babysitter->temporaryAddress->town != '' && $user->babysitter->temporaryAddress->country != '')
                        <p class="has-padding-top-sm">Based in
                                <span class="icon is-medium is-vcentered">
                                    <span class="flag-icon flag-icon-squared is-country flag-icon-{{$user->babysitter->temporaryAddress->country}}"></span>
                                </span>
                            {{$user->babysitter->temporaryAddress->town}}, {{Countries::getOne($user->babysitter->temporaryAddress->country)}}
                        </p>
                    @else
                        <p class="has-padding-top-sm">Based in
                                <span class="icon is-medium is-vcentered">
                                    <span class="flag-icon flag-icon-squared is-country flag-icon-{{$user->babysitter->mainAddress->country}}"></span>
                                </span>
                            {{$user->babysitter->mainAddress->town}}, {{Countries::getOne($user->babysitter->mainAddress->country)}}
                        </p>

                    @endif
                @endif

                <p class="">Tripsitta nanny since <strong class="has-text-weight-bold">{{ (new \Carbon\Carbon($user->created_at))->format('M Y') }}</strong></p>
            </div>
        </div>
    </div>

    <div id="babysitter-profile" class="has-margin-top-lg">
        <div class="container">
            <h2 class="title is-hidden">Babysitter profile</h2>
                <div class="columns">
                    <div class="column is-8">
                        @if($last_searched !== [])
                            <div class="has-margin-bottom-lg has-padded-border">
                            @if($last_searched['type'] === 'holiday_nanny')
                                <h3 class="title is-5 has-text-primary has-text-weight-bold ">Book this holiday nanny now !</h3>
                                <p class="has-margin-bottom-md">You previously searched for holiday nanny to travel from: <br /> <span class="has-text-weight-bold">{{$last_searched['travel_from']}} to {{$last_searched['travel_to']}}</span> <br />for following dates:<br /> <span class="has-text-weight-bold">{{$last_searched['start_date']}} - {{$last_searched['return_date']}} </span></p>
                                <a href="{{ route('book-holiday-nanny', [$user->slug, $last_searched['travel_from'], $last_searched['travel_to'], (\Illuminate\Support\Carbon::createFromFormat('d/m/Y', $last_searched['start_date']))->format('Y-m-d'), (\Illuminate\Support\Carbon::createFromFormat('d/m/Y', $last_searched['return_date']))->format('Y-m-d')]) }}" class="button is-primary is-tripsitta"><span class="icon"><i class="fas fa-suitcase-rolling"></i></span><span>Book your holiday nanny</span></a>
                                <a class="button is-secondary is-outlined" href="{{ route('search-holiday-nanny') }}">
                                    <span>Go back to search</span>
                                </a>
                            @else
                                <h3 class="title is-5 has-text-primary has-text-weight-bold ">Book this babysitter now !</h3>
                                <p class="has-margin-bottom-md">You previously searched for a babysitter in {{$last_searched['search_address'][1]}} for following dates:<br /> <span class="has-text-weight-bold">{{$last_searched['start_date']->format('Y-m-d H:i')}} - {{$last_searched['return_date']->format('Y-m-d H:i')}} </span></p>
                                <a href="{{ route('book-babysitter', [$user->slug, $last_searched['location'],  $last_searched['start_date']->format('Y-m-d\TH:i'), $last_searched['return_date']->format('Y-m-d\TH:i')]) }}" class="button is-secondary is-tripsitta"><span class="icon"><i class="fas fa-suitcase-rolling"></i></span><span>Book your babysitter</span></a>
                                <a class="button is-secondary is-outlined" href="{{ route('search-local-babysitter') }}">
                                    <span>Go back to search</span>
                                </a>
                            @endif
                            </div>
                        @endif

                        <h3 class="title is-5 has-text-primary has-text-weight-bold ">About me</h3>
                        <div class="content">
                            {!! html_entity_decode(nl2br(e($user->babysitter->profile_content))) !!}
                        </div>

                        @if(!empty($user->babysitter->video_url) && !empty($video_id))
                            <h3 class="title is-5 has-text-primary has-text-weight-bold ">Video about me</h3>
                            <object data='https://www.youtube.com/embed/{{$video_id}}?autoplay=0' style="width:100%; height:400px">
                            </object>
                        @endif

                        <h3 id="babysitter-reviews-anchor" class="title is-5 has-margin-top-xl has-text-primary has-text-weight-bold">Rating & Reviews</h3>
                        @if($user->babysitter->reviewsNumber == 0)
                            <p class="notification is-light">This babysitter has no reviews at the moment.</p>
                        @else
                            <div class="reviews-container">
                                <div class="columns">
                                    <div class="column is-4 has-text-centered">
                                        <p class="is-size-7"><span class="has-text-weight-bold is-size-3 has-text-primary">{{$user->babysitter->reviewsAverage}} / 5</span><br/>Current overall rating</p>
                                    </div>
                                    <div class="column is-4 has-text-centered">
                                        <p class="is-size-7"><span class="has-text-weight-bold is-size-3">{{$user->babysitter->reviewsNumber}}</span><br/>number of ratings</p>
                                    </div>
                                    <div class="column is-4 has-text-centered">
                                        <p class="is-size-7"><span class="has-text-weight-bold is-size-3">{{$user->babysitter->reviews->sortBy('created_at')->first()->score}} / 5</span><br/>most recent rating</p>
                                    </div>
                                </div>
                                @foreach($user->babysitter->reviews->sortBy('created_at') as $review)
                                    <div class="review-container">
                                        <p class="title is-5 has-text-centered-mobile">{{$review->title}}</p>
                                        <div class="columns">
                                            <div class="column is-2 has-text-primary has-text-centered review-score-column">
                                                <p>
                                                    @for($i=1; $i<=5; $i++)
                                                        @if($i <= $review->score)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </p>
                                                <div class="is-size-7">{{(new \DateTime($review->created_at))->format('d M Y')}}</div>
                                            </div>
                                            <div class="column is-10">
                                                <div class="content has-text-centered-mobile">{{$review->description}}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                    </div>
                    <div class="column is-4">
                        <h3 class="title is-5 has-text-primary has-text-weight-bold">Experience & qualifications</h3>
                        <table class="table is-fullwidth">
                            <tr>
                                <td>
                                    <i class="fas fa-globe-europe"></i> Languages<br />
                                    <ul class="has-margin-left-md has-margin-top-md">
                                        @foreach($user->babysitter->languages as $language)
                                            <li class="has-margin-bottom-sm">
                                                <span class="language-icon"><i class="flag-icon flag-icon-squared is-country flag-icon-lang-{{strtolower($language->language_name)}}"></i></span> {{\App\Extensions\ExtCountries::getOneLanguage($language->language_name, 'label')}} - {{$language->levelName}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fas fa-baby-carriage"></i> Experience as babysitter / nanny:<br />
                                    <strong class="has-text-weight-bold has-margin-md">{{$user->babysitter->experience_years}} years</strong></td>
                            </tr>
                            <tr>
                                <td>Age groups:<br />
                                    <ul class="has-margin-left-md has-margin-top-md ul-list">
                                        <li>0-1 years</li>
                                        <li>1-3 years</li>
                                    </ul>
                                </td>
                            </tr>
                            @if($user->babysitter->first_aid_passed && $user->babysitter->first_aid_expiry && new \DateTime($user->babysitter->first_aid_expiry) > new \DateTime())
                                <tr>
                                    <td colspan="2" class="has-text-weight-bold"><i class="fas fa-first-aid"></i> First Aid Training Passed</td>
                                </tr>
                            @endif
                            @if($user->babysitter->criminal_record_check_expiry && new \DateTime($user->babysitter->criminal_record_check_expiry) > new \DateTime())
                                <tr>
                                    <td colspan="2" class="has-text-weight-bold"><i class="fas fa-user-circle"></i> Criminal Record Check Passed</td>
                                </tr>
                            @endif
                        </table>

                        @if(count($user->babysitter->skills) > 0)
                            <h3 class="title is-5 has-margin-top-xl has-text-primary has-text-weight-bold">Skills</h3>
                            <div class="columns is-multiline has-padding-left-md">
                                @foreach($user->babysitter->skills as $skill)
                                    @foreach(config('tripsitta.babysitter_skills') as $skill_base)
                                        @if($skill_base['value'] == $skill->skill_code)
                                            @if($skill->skill_code == 'own_car')
                                                <div class="column is-12"><i class="fas fa-car"></i> {{$skill_base['label']}}</div>
                                            @elseif($skill->skill_code == 'flight_travel_babysitting')
                                                <div class="column is-12"><i class="fas fa-plane"></i> {{$skill_base['label']}}</div>
                                            @elseif($skill->skill_code == 'weekend_babysitter')
                                                <div class="column is-12"><i class="fas fa-calendar-week"></i> {{$skill_base['label']}}</div>
                                            @elseif($skill->skill_code == 'flexible_hours')
                                                <div class="column is-12"><i class="fas fa-calendar-day"></i> {{$skill_base['label']}}</div>
                                            @elseif($skill->skill_code == 'language_or_special_tutoring')
                                                <div class="column is-12"><i class="fas fa-language"></i> {{$skill_base['label']}}</div>
                                            @elseif($skill->skill_code == 'event_babysitter')
                                                <div class="column is-12"><i class="fas fa-glass-cheers"></i> {{$skill_base['label']}}</div>
                                            @elseif($skill->skill_code == 'holiday_nanny')
                                                <div class="column is-12"><i class="fas fa-baby-carriage"></i> {{$skill_base['label']}}</div>
                                            @else
                                                <div class="column is-12">{{$skill_base['label']}}</div>
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                        @endif

                        <h3 class="title is-5 has-margin-top-xl has-text-primary has-text-weight-bold">Share this page</h3>
                        <p>
                            <a href=""><i class="fab fa-lg fa-facebook"></i></a> &nbsp; <a href=""><i class="fab fa-lg fa-twitter"></i></a> &nbsp; <a href=""><i class="fab fa-lg fa-instagram"></i></a>
                        </p>
                    </div>
                </div>
        </div>
    </div>
@endsection
