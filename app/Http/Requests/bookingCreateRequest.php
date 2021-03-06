<?php

namespace App\Http\Requests;

use App\Rules\CountryName;
use Illuminate\Foundation\Http\FormRequest;

class bookingCreateRequest extends FormRequest
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
            'children' => ['required', 'array', 'min:1'],
            'children.*.name' => ['required', 'string'],
            'children.*.dob' => ['required', 'string', 'date_format:d/m/Y'],
            'children_notes' => ['required', 'string'],
        ];
    }
}
