<?php

namespace App\Http\Requests\Babysitter;

use App\Rules\CountryName;
use Illuminate\Foundation\Http\FormRequest;

class profileSavePart1Request extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:500'],
            'dob' => ['required', 'string', 'date_format:Y-m-d'],
        ];
    }
}
