<?php

namespace App\Http\Requests\Babysitter;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAvailabilityRequest extends FormRequest
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

    public function validator($factory)
    {
        return $factory->make(
            $this->sanitize(), $this->container->call([$this, 'rules']), $this->messages()
        );
    }

    public function sanitize()
    {
        $availability_babysitter = json_decode($this->input('availability_babysitter'), true);
        if (json_last_error() === 0) {
            $this->merge(['availability_babysitter_array' => $availability_babysitter]);
        }

        $availability_holiday_nanny = json_decode($this->input('availability_holiday_nanny'), true);
        if (json_last_error() === 0) {
            $this->merge(['availability_holiday_nanny_array' => $availability_holiday_nanny]);
        }

        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'jobs_babysitter' => ['present', 'integer', 'min:0', 'max:1'],
            'jobs_holiday_nanny' => ['present', 'integer', 'min:0', 'max:1'],
            'availability_babysitter' => ['present'],
            'availability_holiday_nanny' => ['present'],

            'availability_babysitter_array' => ['sometimes', 'array'],
            'availability_babysitter_array.*.date' => ['required_with:availability_babysitter_array', 'date_format:Y-m-d'],
            'availability_babysitter_array.*.note' => ['required_with:availability_babysitter_array', 'array', 'min:1', 'max:2'],
            'availability_babysitter_array.*.note.*' => ['required_with:availability_babysitter_array', 'string', Rule::in(['babysitter-day', 'babysitter-night'])],

            'availability_holiday_nanny_array' => ['sometimes', 'array'],
            'availability_holiday_nanny_array.*.date' => ['required_with:availability_holiday_nanny_array', 'date_format:Y-m-d'],
            'availability_holiday_nanny_array.*.note' => ['required_with:availability_holiday_nanny_array', 'array', 'min:1', 'max:1'],
            'availability_holiday_nanny_array.*.note.*' => ['required_with:availability_holiday_nanny_array', 'string', Rule::in(['holiday_nanny'])],
        ];
    }
}
