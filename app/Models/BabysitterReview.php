<?php

namespace App\Models;

use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BabysitterReview extends Model
{
    /** @var string[] */
    protected $fillable = [
        'published',
        'title',
        'description',
        'babysitter_id',
        'booking_id',
        'score'
    ];
    /** @var string[] */
    public $checkboxes = [
        'published'
    ];

    /**
     * @return BelongsTo
     */
    public function babysitter()
    {
        return $this->belongsTo(Babysitter::class);
    }

    /**
     * @return BelongsTo
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
