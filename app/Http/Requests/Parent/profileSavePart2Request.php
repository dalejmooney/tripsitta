<?php

namespace App\Http\Requests\Parent;

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
            'children_health_problems' => ['required', 'string', 'max:1000'],
            'child' => ['required', 'array', 'min:1'],
            'child.*.name' => ['required', 'string', 'max:255'],
            'child.*.dob' => ['required', 'string', 'date_format:Y-m-d'],
        ];
    }
}
