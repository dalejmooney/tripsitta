<?php

namespace App\Models;

use A17\Twill\Models\Model;
use A17\Twill\Models\User;

class Chat extends Model
{
    const TWILL_ADMIN_ID = 2;

    protected $fillable = [
        'sender_id',
        'recipient_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function sender()
    {
        return $this->belongsTo('App\User', 'sender_id')->withDefault(
            [
                'id' => 0,
                'name' => 'Tripsitta',
                'surname' => 'Admin',
            ]
        );
    }

    public function recipient()
    {
        return $this->belongsTo('App\User', 'recipient_id')->withDefault(
            [
                'id' => 0,
                'name' => 'Tripsitta',
                'surname' => 'Admin',
            ]
        );
    }

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking', 'booking_id');
    }

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function scopeForBooking($query, $booking)
    {
        if($booking instanceof Booking)
        {
            return $query->where('booking_id', $booking->id);
        }
        return $query->where('booking_id', $booking);
    }

    public function scopeForAdmin($query)
    {
        return $query->where('recipient_id', 0)->orWhere('sender_id', 0);
    }


    public function getLastMessageDateAttribute()
    {
        $date = $this->messages()->orderByDesc('created_at')->first('created_at');
        if(!$date) return 'N/A';
        return $date->created_at->format('d/m/Y H:i:s'). '('.$date->created_at->diffForHumans().')';
    }
}
