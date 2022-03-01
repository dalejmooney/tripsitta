<?php

namespace App\Http\Requests\Babysitter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class profileSavePart4Request extends FormRequest
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
        $shared_rules = [
            'experience_years' => ['required'],
            'experience_age_groups' => ['required', 'array'],
            'experience_age_groups.*' => ['required', 'integer'],
            'languages' => ['required', 'array', 'min:1'],
            'languages.*.lang' => ['required', 'string', 'distinct'],
            'languages.*.level' => ['required', 'string', 'min:0', 'max:3'],
            'qualifications.*' => ['file', 'mimes:jpeg,png,pdf,doc,docx', 'max:500'],
        ];

        // Rules for profile editing + shared
        if($this->user()->babysitter->hasCompletedRegistration())
        {
            return $shared_rules + [
                'first_aid_passed' => ['sometimes', 'required_with:first_aid_expiry,first_aid_certificate', 'nullable', 'string', 'date_format:Y-m-d'],
                'first_aid_expiry' => ['sometimes', 'required_with:first_aid_passed,first_aid_certificate', 'nullable', 'string', 'date_format:Y-m-d'],
                'first_aid_certificate' => [
                    Rule::requiredIf( function (){
                        return
                            ((!empty($this->input('first_aid_passed')) || !empty($this->input('first_aid_expiry'))) && $this->user()->babysitter->fileObject('first_aid_certificate') === null);
                    }),
                    'file', 'mimes:jpeg,png,pdf,doc,docx', 'max:2500'],
                'criminal_record_check_expiry' => ['sometimes', 'required_with:criminal_record_check', 'nullable', 'string', 'date_format:Y-m-d'],
                'criminal_record_check' => [Rule::requiredIf( function (){
                    return !empty($this->input('criminal_record_check_expiry')) && $this->user()->babysitter->fileObject('criminal_record_check') === null;
                }), 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:2500'],
            ];
        }

        // Rules for registration only + shared
        return $shared_rules + [
            'identity_verification' => [Rule::requiredIf( function (){
                return !empty($this->input('criminal_record_check_expiry')) && $this->user()->babysitter->fileObject('identity_verification') === null;
            }), 'file', 'mimes:jpeg,png,pdf,doc,docx', 'max:2500'],
        ];
    }

    public function messages()
    {
        return [
            'first_aid_certificate.required' => 'Please upload your proof of First Aid Training',
            'criminal_record_check.required' => 'Please upload your proof of Criminal Record Check',
            'languages.*.lang.required' => 'Please choose a language from dropdown list',
            'languages.*.level.required' => 'Please choose a proficiency level from dropdown list',
            'identity_verification.max' => 'Identity verification - Please upload a file that\'s smaller than 2.5mb.',
        ];
    }
}
