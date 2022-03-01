@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/pages/parent-profile-children.js') }}"></script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">My profile @if($user->family->reg_form_submitted == 0) <span class="has-tooltip-bottom" data-tooltip="Please complete the registration process to gain full access."><i class="fas fa-exclamation-circle has-text-warning"></i></span> @endif</h1>
            <p class="subtitle">Parent panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('parent.partials.menu')
                </div>
                <div class="column is-8">
                    <form method="post">
                        <h2 class="title is-4 has-text-primary">Children details</h2>
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
                                <label class="label">Children information *</label>
                                <p class="help">Please provide the details below. It'll speed up booking process for you</p>
                                <table id="table_children" class="table has-margin-top-md is-fullwidth">
                                    <thead>
                                        <tr>
                                            <th style="width:60%">Name</th>
                                            <th>DOB</th>
                                            <th style="width:65px" class="has-text-centered"><a class="delete-all-rows"><i class="fas fa-trash-alt"></i></a></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($user->family->children as $i => $child)
                                            <tr>
                                                <td><input class="input is-fullwidth" type="text" value="{{$child->name}}" name="child[{{$i}}][name]" placeholder="First name and surname"/></td>
                                                <td><input class="input is-fullwidth" type="date" value="{{$child->dob->format('Y-m-d')}}" name="child[{{$i}}][dob]"/></td>
                                                <td class="has-text-centered"><a class="button is-outlined delete-one-row"><i class="fas fa-user-minus"></i></a></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td><input class="input is-fullwidth" type="text" value="" name="child[0][name]" placeholder="First name and surname"/></td>
                                                <td><input class="input is-fullwidth" type="date" value="" name="child[0][dob]"/></td>
                                                <td class="has-text-centered"><a class="button is-outlined delete-one-row"><i class="fas fa-user-minus"></i></a></td>
                                            </tr>
                                        @endforelse
                                        <tr class="add_more">
                                            <td colspan="3"><a class="button is-fullwidth is-danger is-outlined">Add another child</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <label class="label">Do any of your children have allergies / health issues or medication?<br />Anything else important for our team to know about them? *</label>
                                <textarea class="textarea" name="children_health_problems" rows="6">{{ old('children_health_problems', $user->family->children_health_problems ? $user->family->children_health_problems : '') }}</textarea>
                            </div>
                        </div>

                        @csrf
                        <button type="submit" class="button is-block is-medium is-fullwidth has-margin-top-xl is-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
