@extends('layouts.app')

@section('meta_title') @endsection
@section('meta_desc') @endsection

@section('scripts')
    <script src="{{ mix('js/pages/book-now.js') }}"></script>
    <script src="{{ mix('js/helpers.js') }}"></script>
@endsection

@php
    $booking_type_text_class = ($type === 'babysitter') ? 'has-text-secondary' : 'has-text-primary';
    $booking_type_el_class = ($type === 'babysitter') ? 'is-secondary' : 'is-primary';
@endphp

@section('content')
    <div id="app-content">
        <div class="container">
            <div class="is-pulled-right is-hidden-mobile has-margin-top-md" data-tooltip="Current step: 1 / 3">
                <i class="icon-number is-small is-inline-block {{$booking_type_el_class}} is-active">1</i> <i class="icon-number is-small is-inline-block is-grey">2</i> <i class="icon-number is-small is-inline-block is-grey">3</i>
            </div>

            @if($type === 'babysitter')
                <h1 class="title has-text-secondary">Your new booking</h1>
                <p class="subtitle">Book your babysitter now</p>
            @else
                <h1 class="title has-text-primary">Your new booking</h1>
                <p class="subtitle">Book your holiday nanny now</p>
            @endif

            <form id="booking_details_form" name="booking_details" action="{{route('book-now')}}" method="post">
            @cannot('parentOrGuest')
                <div class="notification is-warning">
                    Only parents can book a babysitter or holiday nanny. <br /> Please login as parent to continue.
                </div>
                <div class="notification has-margin-top-lg">
                    <p>Click here to <a href="{{ url()->previous() }}" class="button is-small">Go back</a> to babysitter list</p>
                </div>
            @else
                <div class="columns has-margin-top-md">
                    @include('booking.partials.information-block')

                    <div class="column is-8-tablet is-9-widescreen">
                        @if ($errors->any())
                            <div class="notification is-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{$error}}</p>
                                @endforeach
                            </div>
                        @endif
                        <div id="booking-babysitter-info" class="@if($type === 'babysitter') is-secondary @endif">
                            @if($type === 'babysitter')
                                <h2 class="title is-4 has-padding-top-sm has-text-centered-mobile has-text-secondary">Your selected babysitter</h2>
                            @else
                                <h2 class="title is-4 has-padding-top-sm has-text-centered-mobile has-text-primary">Your selected holiday nanny</h2>
                            @endif

                            <div class="columns">
                                <div class="column is-3">
                                    <div class="babysitter-img-container @if($type === 'babysitter') is-secondary @endif">
                                        <figure class="image is-square">
                                            <img class="is-rounded" src="{{$user->babysitter->image('profile_image')}}" alt="Tripsitta - photo of babysitter - {{$user->name}}"/>
                                        </figure>
                                    </div>
                                </div>
                                <div class="column">
                                    <p class="is-size-5 has-margin-top-md has-text-centered-mobile">@if($user->babysitter->experience_years) <span class="experience_years" data-tooltip="{{$user->babysitter->experience_years}} years of experience">{{$user->babysitter->experience_years}}</span> @endif {{$user->name}} {{$user->surname}}
                                        @if($user->babysitter->hasValidFirstAidTraining())
                                            <span class="icon has-text-grey-light has-padding-left-md" data-tooltip="First Aid Training passed"><i class="fas fa-first-aid"></i></span>
                                        @endif
                                        @if($user->babysitter->has_valid_qualifications)
                                            <span class="icon has-text-grey-light has-padding-left-md" data-tooltip="Valid childcare qualifications"><i class="fas fa-certificate"></i></span>
                                        @endif
                                    </p>
                                    @if($user->reviewsNumber == 0)
                                        <p class="subtitle is-7 has-text-centered-mobile"><i class="fas fa-star"></i> No reviews yet</p>
                                    @else
                                        <p class="subtitle is-7 has-text-centered-mobile"><i class="fas fa-star"></i> {{$user->reviewsAverage}} / 5 ({{$user->reviewsNumber}} reviews)</p>
                                    @endif
                                    <div class="columns is-mobile has-text-centered-mobile">
                                        <div class="column is-6">
                                            <p class="has-text-grey">Languages:</p>
                                            @if($user->babysitter->languages && count($user->babysitter->languages) > 0)
                                                <div class="language-icons">
                                                    @foreach($user->babysitter->languages as $language)
                                                        <span class="language-icon" data-tooltip="{{\App\Extensions\ExtCountries::getOneLanguage($language->language_name, 'label')}} - {{$language->levelName}}"><i class="flag-icon flag-icon-squared is-country flag-icon-lang-{{strtolower($language->language_name)}}"></i></span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <div class="column is-6">
                                            <p class="has-text-grey">Experienced with children aged:</p>
                                            @if($user->babysitter->experienceAgeGroups->count() !== 0)
                                                <p>
                                                    @foreach($user->babysitter->experienceAgeGroups as $exp)
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
                                    </div>
                                    <p class="has-text-centered-mobile has-margin-top-md"><a href="{{route('babysitter-profile-show', $user->slug)}}" class="button is-tripsitta-small">View babysitter profile</a></p>
                                </div>
                            </div>
                        </div>



                        <h2 id="children_subtitle" class="title is-4 has-margin-top-lg {{$booking_type_text_class}}">Children details</h2>
                        <label class="label">Please provide names and dates of birth of your children *</label>

                            <table class="table table-children is-fullwidth">
                                <thead>
                                <tr>
                                    <th>Child name</th>
                                    <th>DOB</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($booking_session_children_details as $i => $child)
                                    <tr>
                                        <td>
                                            <div class="field has-addons">
                                                <div class="control is-expanded">
                                                    <input class="input" name="children[{{$i}}][name]" type="text" value="{{$child['name']}}"/>
                                                </div>
                                                <div class="control">
                                                    <a class="button child-picker" data-tooltip="Pick from your saved list of children">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="field">
                                                <div class="control">
                                                    <input class="input is-fullwidth" name="children[{{$i}}][dob]" placeholder="dd/mm/yyyy" type="text" value="{{$child['dob']}}"/>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="has-text-centered">
                                            <a class="delete-one-row button is-outlined"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            <div class="field has-addons">
                                                <div class="control is-expanded">
                                                    <input class="input" name="children[0][name]" type="text" value=""/>
                                                </div>
                                                @auth
                                                <div class="control">
                                                    <a class="button child-picker" data-tooltip="Pick from your saved list of children">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                </div>
                                                @endauth
                                            </div>
                                        </td>
                                        <td>
                                            <div class="field">
                                                <div class="control">
                                                    <input class="input is-fullwidth" name="children[0][dob]" placeholder="dd/mm/yyyy" type="text" value=""/>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="has-text-centered">
                                            <a class="delete-one-row button is-outlined"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforelse

                                <tr class="add-one-more">
                                    <td colspan="3">
                                        <a class="is-fullwidth button @if($type === 'babysitter') is-secondary @else is-primary @endif is-outlined"><i class="fas fa-plus has-margin-right-sm"></i> Add new row</a>
                                    </td>
                                </tr>
                                <tr class="hidden-template is-hidden">
                                    <td>
                                        <div class="field has-addons">
                                            <div class="control is-expanded">
                                                <input class="input" name="children[tmp][name]" type="text" value="" disabled/>
                                            </div>
                                            <div class="control">
                                                <a class="button child-picker" data-tooltip="Pick from your saved list of children">
                                                    <i class="fas fa-search"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="field">
                                            <div class="control">
                                                <input class="input is-fullwidth" name="children[tmp][dob]" placeholder="dd/mm/yyyy" type="text" value="" disabled/>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="has-text-centered">
                                        <a class="delete-one-row button is-outlined"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        @auth
                            <div id="saved_children" class="modal">
                                <div class="modal-background"></div>
                                <div class="modal-content">
                                    <div class="box">
                                        <h3 class="title is-5 has-padding-top-sm">Select from a list of previously added children</h3>
                                        <table class="table is-fullwidth">
                                            <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>DOB</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($parent_children->children as $child)
                                                <tr data-name="{{$child->name}}" data-dob="{{$child->dob->format('d/m/Y')}}">
                                                    <td>{{$child->name}}</td>
                                                    <td>{{$child->dob->format('d/m/Y')}}</td>
                                                    <td><a class="button is-primary is-small">Select child</a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <button class="modal-close is-large" aria-label="close"></button>
                            </div>
                        @endauth
                        <div class="field">
                            <div class="control">
                                <label class="label">Children allergies / health conditions *</label>
                                <textarea class="textarea" name="children_notes" rows="6" required>{{ (session()->has('booking_session') && session()->get('booking_session')['step'] >= 2) ? session()->get('booking_session')['children_notes'] : (($parent_children && $parent_children->children_health_problems) ? $parent_children->children_health_problems : '') }}</textarea>
                            </div>
                        </div>

                        <div class="notification is-light">
                            <p>Once you have finalised your booking you can chat to your Tripsitta nanny to introduce yourself and make all necessary arrangements.</p>
                            <p class="has-padding-top-sm">Your chosen Tripsitta nanny will ask for more information about your children and the location of the booking and any other details they will need to know.</p>
                        </div>
                    </div>
                </div>
                <div class="notification is-warning has-margin-top-lg">
                    @guest
                        <p>Please make sure the details above are correct. You'll be able to log in and adjust remaining details in the next step</p>
                    @else
                        <p>Please make sure the details above are correct. You'll be able to adjust remaining details in the next step</p>
                    @endguest
                </div>
                @if($type === 'babysitter')
                    <p class="has-text-centered-mobile"><a href="{{ route('search-local-babysitter') }}" class="button is-tripsitta has-margin-bottom-sm"><span class="icon"><i class="fas fa-chevron-left"></i></span><span>Go back to babysitters list</span></a> <a  id="continue_booking" class="button is-tripsitta is-secondary is-pulled-right">Continue to next step</a></p>
                @else
                    <p class="has-text-centered-mobile"><a href="{{ route('search-holiday-nanny') }}" class="button is-tripsitta has-margin-bottom-sm"><span class="icon"><i class="fas fa-chevron-left"></i></span><span>Go back to holiday nannies list</span></a> <a id="continue_booking" class="button is-tripsitta is-primary is-pulled-right">Continue to next step</a></p>
                @endif
            @endcannot
                @csrf
            </form>
        </div>
    </div>
@endsection
