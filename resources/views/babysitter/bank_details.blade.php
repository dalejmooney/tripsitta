@extends('layouts.app')

@section('scripts')
    <script src="{{ mix('js/pages/babysitter-bank-details.js') }}"></script>
@endsection

@section('content')
    <div id="app-content">
        <div class="container">
            <h1 class="title">Payouts</h1>
            <p class="subtitle">Babysitter panel</p>

            <div class="columns">
                <div class="column is-4">
                    @include('babysitter.partials.menu')
                 </div>
                <div class="column is-8">
                    <h2 class="title is-4 has-text-primary">Bank details</h2>

                    @if(!$user->babysitter->bank)
                        <div class="notification is-info">
                            <p>We currently don't have your bank details. Please make sure to provide them below so your payouts can be processed automatically without ay delays. </p>
                        </div>
                    @endif

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

                    <form method="post">
                        <div class="field">
                            <div class="control">
                                <label class="label">Full name *</label>
                                <input class="input @error('name') is-danger @enderror" type="text" name="name" placeholder="" value="{{ old('name', $user->babysitter->bank->name ?? '') }}" required>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="label">In what currency would you like to receive payouts ? *</label>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select name="currency" required>
                                            <option value="">Select currency</option>
                                            <option disabled>──────────</option>
                                            @foreach($transferwise_payout_currencies as $currency => $details)
                                                @if(old('currency', $user->babysitter->bank->currency ?? '') ==  $currency)
                                                    <option selected="selected" value="{{$currency}}">{{$details['currency']}}</option>
                                                @else
                                                    <option value="{{$currency}}">{{$details['currency']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <p class="notification has-margin-top-md">If your live in a country which uses different currency, please contact us. We may be able to process payments for you manually</p>
                            </div>
                        </div>
                        <div id="per_currency_fields">
                            <div class="per_currency_field_group is-hidden has-hidden-fields" data-currency="iban_only">
                                <div class="field">
                                    <div class="control">
                                        <label class="label">IBAN *</label>
                                        <input class="input @error('iban') is-danger @enderror" type="text" name="iban" placeholder="" value="{{ old('iban', $user->babysitter->bank->iban ?? '') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="per_currency_field_group is-hidden has-hidden-fields" data-currency="gbp">
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Sort code *</label>
                                        <input class="input @error('sort_code') is-danger @enderror" type="text" name="sort_code" placeholder="" value="{{ old('sort_code', $user->babysitter->bank->sort_code ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Account number *</label>
                                        <input class="input @error('account_number') is-danger @enderror" type="text" name="account_number" placeholder="" value="{{ old('account_number', $user->babysitter->bank->account_number ?? '') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="per_currency_field_group is-hidden has-hidden-fields" data-currency="chf">
                                <div class="field">
                                    <div class="control">
                                        <label class="label">IBAN *</label>
                                        <input class="input @error('iban') is-danger @enderror" type="text" name="iban" placeholder="" value="{{ old('iban', $user->babysitter->bank->iban ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Town *</label>
                                        <input class="input @error('town') is-danger @enderror" type="text" name="postcode" placeholder="" value="{{ old('town', $user->babysitter->bank->town ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Postcode *</label>
                                        <input class="input @error('postcode') is-danger @enderror" type="text" name="postcode" placeholder="" value="{{ old('postcode', $user->babysitter->bank->postcode ?? '') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="per_currency_field_group is-hidden has-hidden-fields" data-currency="usd">
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Account type *</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select name="account_type" required>
                                                    <option value="">Select account type</option>
                                                    <option disabled>──────────</option>
                                                    @foreach(['checking', 'savings'] as $acc_type)
                                                        @if(old('account_type', $user->babysitter->bank->account_type ?? '') == $acc_type)
                                                            <option selected="selected" value="{{$acc_type}}">{{ucfirst($acc_type)}} account</option>
                                                        @else
                                                            <option value="{{$acc_type}}">{{ucfirst($acc_type)}} account</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <label class="label">Routing number *</label>
                                        <input class="input @error('sort_code') is-danger @enderror" type="text" name="sort_code" placeholder="" value="{{ old('sort_code', $user->babysitter->bank->sort_code ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Account number *</label>
                                        <input class="input @error('account_number') is-danger @enderror" type="text" name="account_number" placeholder="" value="{{ old('account_number', $user->babysitter->bank->account_number ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Address line 1 *</label>
                                        <input class="input @error('address1') is-danger @enderror" type="text" name="address1" placeholder="" value="{{ old('address1', $user->babysitter->bank->address1 ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Address line 2 </label>
                                        <input class="input @error('address2') is-danger @enderror" type="text" name="address2" placeholder="" value="{{ old('address2', $user->babysitter->bank->address2 ?? '') }}">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Town *</label>
                                        <input class="input @error('town') is-danger @enderror" type="text" name="town" placeholder="" value="{{ old('town', $user->babysitter->bank->town ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <label class="label">Post code *</label>
                                        <input class="input @error('postcode') is-danger @enderror" type="text" name="postcode" placeholder="" value="{{ old('town', $user->babysitter->bank->postcode ?? '') }}" required>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <label class="label">State *</label>
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select name="state" required>
                                                    <option value="">Select state</option>
                                                    <option disabled>──────────</option>
                                                    @foreach(config('tripsitta.us_states') as $code => $name)
                                                        @if(old('state', $user->babysitter->bank->state ?? '') == $code)
                                                            <option selected="selected" value="{{$code}}">{{$name}}</option>
                                                        @else
                                                            <option value="{{$code}}">{{$name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <label class="label">Country *</label>
                                        <input class="input" type="text" name="country" placeholder="" value="US" readonly="readonly" required>
                                    </div>
                                </div>
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
