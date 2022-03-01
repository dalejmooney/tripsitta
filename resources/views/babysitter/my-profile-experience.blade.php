@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/helpers.js') }}"></script>
    <script src="{{ mix('js/pages/profile-experience.js') }}"></script>
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
                        <h2 class="title is-4 has-text-primary">Experience & Qualifications</h2>
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

                        <div class="field">
                            <div class="control">
                                <label class="label">How many years of experience do you have ? *</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select name="experience_years">
                                            <option value="">Select number of years</option>
                                            <option disabled>──────────</option>
                                            @foreach(config('tripsitta.experience_years') as $exp)
                                                @if((old('experience_years', $user->babysitter->experience_years != '' ? $user->babysitter->experience_years : '')) == $exp['value'])
                                                    <option selected="selected" value="{{$exp['value']}}">{{$exp['label']}}</option>
                                                @else
                                                    <option value="{{$exp['value']}}">{{$exp['label']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field has-margin-top-lg">
                            <div class="control">
                                <label class="label">What age groups of children have you had experience caring for ? *</label>
                                @foreach(config('tripsitta.experience_age_groups') as $age_groups)
                                    <p>
                                        <label class="checkbox">
                                            <input type="checkbox" name="experience_age_groups[]" value="{{$age_groups['value']}}"
                                                   @foreach($user->babysitter->experienceAgeGroups as $babysitter_age_group)
                                                       @if($age_groups['value'] == $babysitter_age_group->age_group)
                                                            checked=checked"
                                                       @endif
                                                   @endforeach
                                            >
                                            {{$age_groups['label']}}
                                        </label>
                                    </p>
                                @endforeach
                            </div>
                        </div>

                        <div class="field has-margin-top-lg">
                            <div class="control">
                                <label class="label">Do you have any childcare qualification? If yes, please upload certificates below.</label>
                                <div id="file-js-example" class="file has-name">
                                    <label class="file-label">
                                        <input class="file-input" type="file" name="qualifications[]" multiple/>
                                        <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                        @if($user->babysitter->fileObject('qualifications') !== null)
                                            <span class="file-name">{{count($user->babysitter->filesList('qualifications'))}} uploaded</span>
                                        @else
                                            <span class="file-name">No file uploaded</span>
                                        @endif
                                    </label>
                                </div>
                                <p class="help">Note: Maximum 5 files can be uploaded. Accepted file formats: pdf, doc, docx, jpg, png. Maximum size of each file: 250kb</p>
                            </div>
                        </div>

                        <h3 class="title is-5 has-text-primary has-margin-top-lg">Languages</h3>
                        <div class="field">
                            <div class="control">
                                <label class="label">What languages can you speak ? *</label>
                                <table class="table is-fullwidth">
                                    <thead>
                                    <tr>
                                        <th>Language</th>
                                        <th>Proficiency</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($user->babysitter->languages as $i => $selected_language)
                                        <tr>
                                            <td>
                                                <div class="select @error('languages.'.$i.'.lang') is-danger @enderror">
                                                    <select name="languages[{{$i}}][lang]">
                                                        <option value="">Select language</option>
                                                        @foreach($languages as $language)
                                                            @if((old('languages['.$i.'][lang]', $selected_language->language_name ?? '')) == $language['value'])
                                                                <option selected="selected" value="{{$language['value']}}">{{$language['label']}}</option>
                                                            @else
                                                                <option value="{{$language['value']}}">{{$language['label']}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="select @error('languages.'.$i.'.lang') is-danger @enderror">
                                                    <select name="languages[{{$i}}][level]">
                                                        <option value="">Select level</option>
                                                        @foreach(config('tripsitta.language_levels') as $level)
                                                            @if((old('languages['.$i.'][level]', $selected_language->language_level ?? '')) == $level['value'])
                                                                <option selected="selected" value="{{$level['value']}}">{{$level['label']}}</option>
                                                            @else
                                                                <option value="{{$level['value']}}">{{$level['label']}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </td>
                                            <td class="has-text-centered">
                                                <a class="has-text-danger delete-one-row"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="add-one-more">
                                        <td colspan="3">
                                            <a class="is-fullwidth button is-primary is-outlined"><i class="fas fa-plus has-margin-right-sm"></i> Add new row</a>
                                        </td>
                                    </tr>
                                    <tr class="hidden-template is-hidden">
                                        <td>
                                            <div class="select">
                                                <select name="languages[tmp][lang]" disabled>
                                                    <option value="">Select language</option>
                                                    @foreach($languages as $language)
                                                        <option value="{{$language['value']}}">{{$language['label']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="select">
                                                <select name="languages[tmp][level]" disabled>
                                                    <option value="">Select level</option>
                                                    @foreach(config('tripsitta.language_levels') as $level)
                                                        <option value="{{$level['value']}}">{{$level['label']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td class="has-text-centered">
                                            <a class="has-text-danger delete-one-row"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($user->babysitter->hasCompletedRegistration())
                            <h3 class="title is-5 has-text-primary has-margin-top-lg">First Aid Training</h3>
                            <div class="field">
                                <div class="control">
                                    <label class="label">When did you complete first aid training?</label>
                                    <input class="input @error('first_aid_passed') is-danger @enderror" type="date" name="first_aid_passed" value="{{ old('first_aid_passed', (!empty($user->babysitter->first_aid_passed)) ? $user->babysitter->first_aid_passed->format('Y-m-d') : '') }}">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <label class="label">When does your first aid training expire?</label>
                                    <input class="input @error('first_aid_expiry') is-danger @enderror" type="date" name="first_aid_expiry" value="{{ old('first_aid_expiry', (!empty($user->babysitter->first_aid_expiry)) ? $user->babysitter->first_aid_expiry->format('Y-m-d') : '') }}">
                                </div>
                            </div>

                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Upload a scan or photograph of your first aid certificate</label>
                                    <div id="file-js-picture" class="file has-name">
                                        <label class="file-label @error('first_aid_certificate') has-text-danger @enderror">
                                            <input class="file-input" type="file" name="first_aid_certificate"/>
                                            <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                            @if($user->babysitter->fileObject('first_aid_certificate') !== null)
                                                <span class="file-name">{{$user->babysitter->fileObject('first_aid_certificate')->filename}}</span>
                                            @else
                                                <span class="file-name">No file uploaded</span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h3 class="title is-5 has-text-primary has-margin-top-lg">Criminal Record Check</h3>
                            <div class="field">
                                <div class="control">
                                    <label class="label">When does your criminal record check expire?</label>
                                    <input class="input @error('criminal_record_check_expiry') is-danger @enderror" type="date" name="criminal_record_check_expiry" value="{{ old('criminal_record_check_expiry', (!empty($user->babysitter->criminal_record_check_expiry)) ? $user->babysitter->criminal_record_check_expiry->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="field has-margin-top-lg">
                                <div class="control">
                                    <label class="label">Upload a scan or photograph of your criminal record check</label>
                                    <div id="file-js-picture" class="file has-name">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="criminal_record_check"/>
                                            <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                            @if($user->babysitter->fileObject('criminal_record_check') !== null)
                                                <span class="file-name">{{$user->babysitter->fileObject('criminal_record_check')->filename}}</span>
                                            @else
                                                <span class="file-name">No file uploaded</span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <h3 class="title is-5 has-text-primary has-margin-top-lg">Identity verification</h3>
                            <div class="field">
                                <div class="control">
                                    <label class="label">Upload a photograph of your ID (passports or national identity cards only) *</label>
                                    <div id="file-js-picture" class="file has-name">
                                        <label class="file-label">
                                            <input class="file-input" type="file" name="identity_verification" @if($user->babysitter->fileObject('identity_verification') === null) required @endif />
                                            <span class="file-cta">
                                            <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                            </span>
                                            <span class="file-label">Choose a file…</span>
                                        </span>
                                            @if($user->babysitter->fileObject('identity_verification') !== null)
                                                <span class="file-name">{{$user->babysitter->fileObject('identity_verification')->filename}}</span>
                                            @else
                                                <span class="file-name">No file uploaded</span>
                                            @endif
                                        </label>
                                    </div>
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
