<?php

namespace App\Models;

use A17\Twill\Models\Model;

class BookingStatus extends Model
{
    public function scopeGetNewBookingStatus($query)
    {
        return $query->where('name', 'Awaiting babysitter confirmation');
    }
}
