<?php

namespace App\Http\Requests\Babysitter;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class storeNewBookingInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('viewBabysitterBookingDetails', [$this->route('booking')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => ['required', 'string', Rule::in(['extras', 'balance'])],
            'description' => ['required', 'string' ],
            'amount_due' => ['required', 'string', 'numeric', 'between:0,9999.99'],
        ];
    }
}
