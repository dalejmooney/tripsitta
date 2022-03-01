<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BabysitterAvailability extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'babysitter_id',
        'date',
        'type'
    ];

    public $timestamps = FALSE;

    public function user()
    {
        return $this->belongsTo(Babysitter::class);
    }

    public function scopeBabysitterOnly($qry)
    {
        return $qry->where('type', 'babysitter-day')->orWhere('type', 'babysitter-night');
    }

    public function scopeHolidayNannyOnly($qry)
    {
        return $qry->where('type', 'holiday_nanny');
    }

    public function scopeListAvailable($qry, $array){
        foreach($array as $date => $av_types)
        {
            if(is_array($av_types))
            {
                foreach($av_types as $type)
                {
                    $qry->orWhere(function($q) use($date, $type){
                        $q->where('type', $type)->where('date', $date);
                    });
                }
            }
            else
            {
                $qry->orWhere(function($q) use($date, $type){
                    $q->where('type', $type)->where('date', $date);
                });
            }
        }
        return $qry;
    }

    // ---
}
