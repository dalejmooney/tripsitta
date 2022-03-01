<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class contactFormRequest extends FormRequest
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
            'contact_name' => ['required', 'min:2'],
            'contact_email' => ['required', 'email'],
            'contact_message' => ['required', 'min:3', 'max:1000'],
        ];
    }
}
