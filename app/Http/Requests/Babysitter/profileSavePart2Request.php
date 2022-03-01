<?php

namespace App\Http\Requests\Babysitter;

use App\Rules\CountryCode;
use Illuminate\Foundation\Http\FormRequest;

class profileSavePart2Request extends FormRequest
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
        return [
            'phone_number' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'home_phone_number' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:8'],
            'emergency_name' => ['required', 'string', 'max:500'],
            'emergency_relationship' => ['required', 'string', 'max:250'],
            'emergency_phone_number' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'mainAddress.address1' => ['required', 'string', 'max:500'],
            'mainAddress.address2' => ['present', 'string', 'max:500', 'nullable'],
            'mainAddress.town' => ['required', 'string', 'max:500'],
            'mainAddress.postcode' => ['required', 'string', 'max:500'],
            'mainAddress.country' => ['required', 'string', 'max:5', new CountryCode()],
            'temporaryAddress.address1' => ['nullable', 'required_with:temporaryAddress.town,', 'string', 'max:500'],
            'temporaryAddress.address2' => ['nullable', 'present', 'string', 'max:500'],
            'temporaryAddress.town' => ['nullable', 'required_with:temporaryAddress.address1,', 'string', 'max:500'],
            'temporaryAddress.postcode' => ['nullable', 'required_with:temporaryAddress.address1,', 'string', 'max:500'],
            'temporaryAddress.country' => ['nullable', 'required_with:temporaryAddress.address1,', 'string', 'max:5', new CountryCode()],

        ];
    }
}
