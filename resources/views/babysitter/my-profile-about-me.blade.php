@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/pages/profile-about-me.js') }}"></script>
    <script src="{{ mix('js/helpers.js') }}"></script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">My profile @if($user->babysitter->reg_form_submitted == 0) <span class="has-tooltip-bottom" data-tooltip="Please complete the registration process to gain full access."><i class="fas fa-exclamation-circle has-text-warning"></i></span> @endif</h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('babysitter.partials.menu')
                </div>
                <div class="column is-8">
                    <form method="post" enctype="multipart/form-data">
                        <h2 class="title is-4 has-text-primary">Reasons for joining & About me</h2>
                        @if (session('status'))
                            <div class="notification @if(session('status')['type'] == 'success') is-success @else is-danger @endif">
                                {{ session('status')['message'] }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="notification is-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{$error}}</p>
                                @endforeach
                            </div>
                        @endif

                        @if(!$user->babysitter->isActive())
                            {{-- Registration only --}}
                            <div class="field">
                                <div class="control">
                                    <label class="label">What are your main reasons for joining Tripsitta? *</label>
                                    @foreach(config('tripsitta.join_reasons') as $reason)
                                        <p>
                                            <label class="checkbox">
                                                <input type="checkbox" name="reasons[]" value="{{$reason['value']}}"
                                                   @if( (is_array(old('reasons')) && in_array($reason['value'], old('reasons'))) || ($user->babysitter->joinReasons->where('reason', $reason['value'])->first() !== null) )
                                                        checked=checked"
                                                   @endif
                                                >
                                                {{$reason['label']}}
                                            </label>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                            <p class="has-margin-bottom-lg has-margin-top-lg is-size-5">At Tripsitta we pride ourselves on our network of talented childcare providers.</p>
                            <div class="field">
                                <div class="control">
                                    <label class="label">Why do you think you would be a great babysitter / holiday nanny for families ? *</label>
                                    <textarea class="textarea" name="join_reason_text" rows="6">{{ old('join_reason_text', $user->babysitter->join_reason_text ? $user->babysitter->join_reason_text : '') }}</textarea>
                                </div>
                            </div>

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Please upload your recent CV</label>
                                    <div id="file-js-example" class="file has-name">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="cv"/>
                                            <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                            @if($user->babysitter->fileObject('cv') !== null)
                                                <span class="file-name">{{$user->babysitter->fileObject('cv')->filename}}</span>
                                            @else
                                                <span class="file-name">No file uploaded</span>
                                            @endif
                                        </label>
                                    </div>
                                    <p class="help">Note: This is not mandatory but it will help with your application</p>
                                </div>
                            </div>
                        @else
                            {{-- Profile edit only --}}

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Profile picture</label>
                                    <div id="file-js-picture" class="file has-name">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="profile_image"/>
                                            <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                            @if($user->babysitter->fileObject('profile_image') !== null)
                                                <span class="file-name">{{$user->babysitter->fileObject('profile_image')->filename}}</span>
                                            @else
                                                <span class="file-name">No file uploaded</span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <label class="label">Profile content</label>
                                    <textarea class="textarea" name="profile_content" rows="6">{{ old('profile_content', $user->babysitter->profile_content ? $user->babysitter->profile_content : '') }}</textarea>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <label class="label">Profile background</label>
                                    <div class="select is-fullwidth is-hidden">{{-- hide this. We use graphical image picker --}}
                                        <select name="profile_background">
                                            <option value="">Select your profile background</option>
                                            @foreach(config('tripsitta.babysitter_backgrounds') as $background)
                                                <option value="{{$background['value']}}"
                                                   @if($background['value'] == $user->babysitter->profile_background)
                                                       selected="selected"
                                                    @endif
                                                >
                                                    {{$background['label']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div id="available_background_images" class="columns is-multiline">
                                    @foreach(config('tripsitta.babysitter_backgrounds') as $background)
                                        <div class="column is-3">
                                            <a data-img_value="{{$background['value']}}">
                                                @if($background['value'] == $user->babysitter->profile_background)
                                                    <figure class="image is_highlighted"><img src="{{route('home')}}/images\background_babysitter/{{$background['value']}}"/></figure>
                                                @else
                                                    <figure class="image"><img src="{{route('home')}}/images\background_babysitter/{{$background['value']}}"/></figure>
                                                @endif
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Skills</label>
                                    <p class="help has-margin-bottom-md">These will be visible for  customers as bullet points on your profile page</p>
                                    @foreach(config('tripsitta.babysitter_skills') as $skill)
                                        <p>
                                            <label class="checkbox">
                                                <input type="checkbox" name="babysitter_skills[]" value="{{$skill['value']}}"
                                                       @foreach($user->babysitter->skills as $babysitter_skill)
                                                        @if($skill['value'] == $babysitter_skill->skill_code)
                                                            checked=checked"
                                                         @endif
                                                    @endforeach
                                                >
                                                {{$skill['label']}}
                                            </label>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @csrf
                        <button type="submit" class="button is-block is-medium is-fullwidth has-margin-top-xl is-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
