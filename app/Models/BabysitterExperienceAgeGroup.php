<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BabysitterExperienceAgeGroup extends Model
{
    protected $fillable = [
        'user_id',
        'age_group'
    ];

    public $timestamps = false;
}
