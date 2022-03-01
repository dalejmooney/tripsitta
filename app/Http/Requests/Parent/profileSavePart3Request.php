<?php

namespace App\Http\Requests\Parent;

use App\Rules\CountryCode;
use Illuminate\Foundation\Http\FormRequest;

class profileSavePart3Request extends FormRequest
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
            'address1' => ['required', 'string', 'max:500'],
            'address2' => ['present', 'string', 'max:500', 'nullable'],
            'town' => ['required', 'string', 'max:500'],
            'postcode' => ['required', 'string', 'max:500'],
            'country' => ['required', 'string', 'max:5', new CountryCode()],
        ];
    }
}
