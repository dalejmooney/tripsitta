<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateBookingStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $booking = $this->route()->parameter('booking');

        return in_array(
            $this->input('new_status'), $booking->getPossibleBookingStatuses()
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'new_status' => ['required', 'string', Rule::in(['up', 'down', 'done', 'cancel', 'confirm'])],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $this->request->add([
                'new_status_int' => $this->convertNewStatusStringToInt($this->request->get('new_status')),
            ]);
        });
    }

    private function convertNewStatusStringToInt($string_status)
    {
        $new_status = 4; // confirmed (new_status === up)
        if($string_status === 'down') $new_status = 2; // cancelled by babysitter
        if($string_status === 'done') $new_status = 5; // completed
        if($string_status === 'cancel') $new_status = 3; // cancelled by parent
        if($string_status === 'confirm') $new_status = 0; // just confirm current status

        return $new_status;
    }
}
