<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyChild extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'family_id',
        'name',
        'dob'
    ];

    public $dates = ['dob'];

    public $timestamps = false;

    public function family()
    {
        return $this->belongsTo('App\Models\Family', 'id', 'family_id');
    }
}
