<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BabysitterJoinReason extends Model
{
    protected $fillable = [
        'user_id',
        'reason'
    ];

    public $timestamps = false;

    public function babysitter()
    {
        return $this->belongsTo(Babysitter::class);
    }
}
