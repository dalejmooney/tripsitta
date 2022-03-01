<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class BookingInvoiceRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'reference' => ['required'],
            'booking_id' => [
                'required',
                'exists:bookings,id'
            ],
        ];
    }

    public function rulesForUpdate()
    {
        return [];
    }
}
