<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingChild extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'dob',
    ];

    protected $dates = [
        'dob'
    ];

    public $timestamps = false;

    public function details()
    {
        return $this->hasOne('App\Models\FamilyChild', 'id', 'child_id')->withTrashed();
    }
}
