<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BabysitterReviewRequest extends Model
{
    protected $fillable = [
        'published',
        'booking_id',
        'sent',
        'sent_date',
        'completed',
        'completed_date',
    ];

    protected $dates = [
        'sent_date',
        'completed_date'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
