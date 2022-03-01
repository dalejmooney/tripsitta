<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'building',
        'address1',
        'address2',
        'town',
        'postcode',
        'country',
    ];

    public $timestamps = FALSE;
}
