<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BabysitterAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'babysitter_id',
        'home_address',
        'address1',
        'address2',
        'town',
        'postcode',
        'country'
    ];

    public function user()
    {
        return $this->belongsTo(Babysitter::class);
    }
}
