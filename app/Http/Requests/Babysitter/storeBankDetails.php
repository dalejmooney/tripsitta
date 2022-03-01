<?php

namespace App\Http\Requests\Babysitter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class storeBankDetails extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => ['required', 'string', 'min:2'],
            'currency' => ['required', 'string', 'size:3', Rule::in( array_keys( config('tripsitta.transferwise_payout_currencies') ) )],

            'iban' => ['string', 'alpha_num', 'iban', 'min:10', Rule::requiredIf( function (){
                return !in_array($this->currency, ['gbp', 'usd']);
            })],
            'account_type' => ['string', 'required_if:currency,==,usd', Rule::in(['checking', 'savings']) ],
            'sort_code' => ['string', 'min:3', Rule::requiredIf( function (){
                return in_array($this->currency, ['gbp', 'usd']);
            })],
            'account_number' => ['string', 'numeric', 'min:3', Rule::requiredIf( function (){
                return in_array($this->currency, ['gbp', 'usd']);
            })],
            'address1' => ['string', 'required_if:currency,==,usd'],
            'address2' => ['string', 'nullable'],
            'postcode' => ['string', Rule::requiredIf( function (){
                return in_array($this->currency, ['usd', 'chf']);
            })],
            'town' => ['string', Rule::requiredIf( function (){
                return in_array($this->currency, ['usd', 'chf']);
            })],
            'state' => ['string', 'required_if:currency,==,usd'],
            'country' => ['string', 'required_if:currency,==,usd'],
        ];

        if($this->currency === 'gbp')
        {
            array_push($rules['sort_code'], "regex:/^[0-9]{2}\-[0-9]{2}\-[0-9]{2}$/");
        }
        elseif($this->currency === 'usd')
        {
            array_push($rules['sort_code'], "numeric");
        }

        return $rules;
    }
}
