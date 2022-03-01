<?php

namespace App\Http\Requests;

use App\Rules\CountryName;
use Illuminate\Foundation\Http\FormRequest;

class babysitterSearchRequest extends FormRequest
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
            'location' => 'required|string',
            'date' => 'required|date_format:d/m/Y',
            'duration' => 'required|numeric',
            'time' => 'required|date_format:H:i',
        ];
    }
}
