<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Model;

class Family extends Model
{
    use HasFiles;

    protected $fillable = [
        'id',
        'children_health_problems',
        'published',
    ];

    // add checkbox fields names here (published toggle is itself a checkbox)
    public $checkboxes = [
        'published'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'id')->where('role', 'parent');
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\Booking', 'family_id', 'id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\FamilyChild', 'family_id', 'id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\FamilyAddress', 'family_id', 'id');
    }

    public function invoices()
    {
        return $this->hasManyThrough('App\Models\BookingInvoice', 'App\Models\Booking', 'family_id', 'booking_id', 'id', 'id');
    }
}
