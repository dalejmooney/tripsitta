<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyAddress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'family_id',
        'address1',
        'address2',
        'town',
        'postcode',
        'country',
    ];

    public function family()
    {
        return $this->belongsTo('App\Models\Family', 'id', 'family_id');
    }
}
