<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BabysitterLanguage extends Model
{
    use HasMedias, HasFiles, SoftDeletes;

    protected $fillable = [
        'babysitter_id',
        'language_name',
        'language_level'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(Babysitter::class);
    }

    public function getLevelNameAttribute()
    {
        $levels = config('tripsitta.language_levels');
        $found = '';

        foreach($levels as $level)
        {
            if($level['value'] == $this->language_level)
            {
                $found = $level['label'];
            }
        }

        return $found;
    }
}
