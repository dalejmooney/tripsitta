<?php

namespace App\Http\Requests;

use App\Rules\CountryName;
use Illuminate\Foundation\Http\FormRequest;

class holidayNannySearchRequest extends FormRequest
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
            'travel_from' => ['required','string', new CountryName],
            'travel_to' => ['required','string', new CountryName],
            'start_date' => 'required|date_format:d/m/Y',
            'return_date' => 'required|date_format:d/m/Y',
        ];
    }
}
