<?php

namespace App\Http\Requests\Babysitter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        // Rules for profile editing
        if($this->user()->babysitter->hasCompletedRegistration())
        {
            return [
                'profile_content' => ['sometimes', 'string', 'nullable', 'max:2000'],
                'profile_background' => ['sometimes', 'max:100', Rule::in( array_column( config('tripsitta.babysitter_backgrounds'), 'value' ) ) ],
                'profile_image' => ['sometimes', 'file', 'mimes:jpeg,png', 'max:2500'],
                'babysitter_skills' => ['array'],
                'babysitter_skills.*' => ['required', 'string', Rule::in( array_column( config('tripsitta.babysitter_skills'), 'value' ) ) ],
            ];
        }

        // Rules for account registration.
        return [
            'reasons' => ['required'],
            'join_reason_text' => ['required', 'string', 'max:2000'],
            'cv' => ['sometimes', 'file', 'mimes:jpeg,png,pdf,doc,docx', 'max:2500'],
        ];
    }
}
