<?php

namespace App\Http\Requests\Babysitter;

use Illuminate\Foundation\Http\FormRequest;

class profileSavePart5Request extends FormRequest
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
            'interview_date' => 'required|date_format:Y-m-d',
            'interview_time' => 'required|date_format:G:i',
            'found_source' => 'required|string',
        ];
    }
}
