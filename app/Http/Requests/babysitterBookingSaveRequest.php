<?php

namespace App\Http\Requests;

use App\Rules\CountryCode;
use App\Rules\CountryName;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class babysitterBookingSaveRequest extends FormRequest
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
        if($this->session()->get('booking_session')['type'] === 'babysitter')
        {
            return [
                'address_type' => ['required', 'string', 'in:new,home,not_sure'],
                'bookingAddress' => ['required_if:address_type,new'],
                'bookingAddress.building' => ['present', 'string', 'max:500', 'nullable'],
                'bookingAddress.address1' => ['required_if:address_type,new', 'nullable', 'string', 'max:500'],
                'bookingAddress.address2' => ['present', 'string', 'max:500', 'nullable'],
                'bookingAddress.town' => ['required_if:address_type,new', 'nullable', 'string', 'max:500'],
                'bookingAddress.postcode' => ['required_if:address_type,new', 'nullable', 'string', 'max:500'],
                'bookingAddress.country' => ['required_if:address_type,new', 'nullable', 'string', 'max:5', new CountryCode()],
                'primary_number_available' => ['present', 'boolean'],
                'emergency_phone_number_available' => ['present', 'boolean'],
                'additional_phone_number' => [
                    'present',
                    Rule::requiredIf(function (){
                        return (bool) $this->get('primary_number_available') !== true && (bool) $this->get('emergency_phone_number_available') !== true;
                    }),
                ],
                'parent_during_booking' => ['required', 'string', 'max:1000'],
                'booking_notes' => ['required', 'string', 'max:1000'],
            ];
        }

        $babysitter = User::with(['babysitter.mainAddress'])->findOrFail($this->session()->get('booking_session')['babysitter_id']);

        return [
            'primary_number_available' => ['present', 'boolean'],
            'emergency_phone_number_available' => ['present', 'boolean'],
            'additional_phone_number' => [
                'present',
                Rule::requiredIf(function (){
                    return (bool) $this->get('primary_number_available') !== true && (bool) $this->get('emergency_phone_number_available') !== true;
                }),
            ],
            'start_location_airport' => [
                Rule::requiredIf(function () use($babysitter){
                    return (bool) $this->session()->get('booking_session')['start_location']['country_code'] === $babysitter->babysitter->mainAddress->country;
                }),
                'string',
                'max:1000',
                'nullable'
            ],
            'destination_town' => ['required', 'string', 'max:1000', 'nullable'],
            'accommodation_booked' => ['required', 'boolean', 'nullable'],
            'accommodation_details' => ['required_if:accommodation_booked,1', 'nullable', 'string', 'max:500'],
            'babysitter_meet' => [
                Rule::requiredIf(function () use($babysitter){
                    return (bool) $this->session()->get('booking_session')['end_location']['country_code'] === $babysitter->babysitter->mainAddress->country;
                }),
                'boolean',
                'nullable'
            ],
            'babysitter_meet_details' => ['required_if:babysitter_meet,1', 'nullable', 'string', 'max:500'],
            'travel_trip'  => ['required', 'boolean'],
            'travel_trip_details' => ['required_if:travel_trip,1', 'nullable', 'string', 'max:500'],
            'booking_notes' => ['required', 'string', 'max:1000'],
        ];
    }
}
