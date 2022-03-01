<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BabysitterSkill extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'babysitter_id',
        'skill_code'
    ];

    public $timestamps = FALSE;
}
