<?php

namespace App\Models;

use A17\Twill\Models\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'message',
        'added_by',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function addedBy()
    {
        return $this->belongsTo('App\User', 'added_by')->withDefault(
            [
                'id' => 0,
                'name' => 'Tripsitta',
                'surname' => 'Admin',
            ]
        );
    }
}
