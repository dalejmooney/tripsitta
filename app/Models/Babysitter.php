<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Babysitter extends Model
{
    use HasMedias, HasFiles;

    /** @var string[] n */
    protected $fillable = [
        'id',
        'join_reason_text',
        'experience_years',
        'interview_date',
        'interview_time',
        'first_aid_passed',
        'first_aid_expiry',
        'criminal_record_check_expiry',
        'jobs_babysitter',
        'jobs_holiday_nanny',
        'holiday_nanny_travel_countries',
        'profile_content',
        'found_source',
        'profile_background',
        'published',
        'has_valid_qualifications',
        'has_valid_id',
        'has_valid_references',
        'interview_successful',
        'video_url'
    ];
    /** @var string[]  */
    public $checkboxes = ['published'];
    /** @var \array[][][]  */
    public $mediasParams = [
        'profile_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],

    ];
    /** @var string[]  */
    public $filesParams = ['first_aid_certificate', 'criminal_record_check', 'qualifications', 'references', 'cv', 'identity_verification'];
    /** @var string[]  */
    protected $dates = ['interview_date', 'first_aid_passed', 'first_aid_expiry', 'criminal_record_check_expiry'];

    /**
     * @return string
     */
    public function getTitleInBrowserAttribute()
    {
        return $this->user->full_name;
    }

    /**
     * @return HasOne
     */
    public function user()
    {
        return $this->hasOne('App\User', 'id', 'id')->where('role', 'babysitter');
    }

    public function joinReasons()
    {
        return $this->hasMany('App\Models\BabysitterJoinReason');
    }

    public function experienceAgeGroups()
    {
        return $this->hasMany('App\Models\BabysitterExperienceAgeGroup');
    }

    public function languages()
    {
        return $this->hasMany('App\Models\BabysitterLanguage');
    }

    /**
     * All addresses. Use mainAddress or temporaryAddress to get more specific results
     */
    public function addresses()
    {
        return $this->hasMany('App\Models\BabysitterAddress');
    }

    public function mainAddress()
    {
        return $this->hasOne('App\Models\BabysitterAddress')->where('home_address', 1)->withDefault();
    }

    public function temporaryAddress()
    {
        return $this->hasOne('App\Models\BabysitterAddress')->where('home_address', 0)->withDefault();
    }

    public function skills()
    {
        return $this->hasMany('App\Models\BabysitterSkill');
    }

    public function bookedAvailability()
    {
        return $this->hasMany('App\Models\BabysitterBookedAvailability');
    }

    /**
     * Generic get all avaialbility for babysitter. Use availabilityBabysitterOnly or availabilityHolidayNannyOnly for more accurate data
     */
    public function availability()
    {
        return $this->hasMany('App\Models\BabysitterAvailability');
    }

    public function availabilityBabysitterOnly()
    {
        return $this->hasMany('App\Models\BabysitterAvailability')->babysitterOnly();
    }

    public function availabilityHolidayNannyOnly()
    {
        return $this->hasMany('App\Models\BabysitterAvailability')->holidayNannyOnly();
    }

    public function bookings()
    {
        return $this->hasMany('App\Models\Booking');
    }

    public function invoices()
    {
        return $this->hasManyThrough('App\Models\BookingInvoice', 'App\Models\Booking', 'babysitter_id', 'booking_id', 'id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\BabysitterReview');
    }

    public function bank()
    {
        return $this->hasOne('App\Models\BabysitterBankDetail');
    }


    // scopes

    public function scopeActive($query)
    {
        return $query->wherePublished(true);
    }

    public function scopeDisabled($query)
    {
        return $query->wherePublished(false);
    }

    public function scopeAcceptsNannyJobs($query)
    {
        return $query->where('jobs_holiday_nanny', 1);
    }

    public function scopeAcceptsBabysitterJobs($query)
    {
        return $query->where('jobs_babysitter', 1);
    }

    // attributes

    /**
     * This relation is under attributes section for a clarity reasons. it's only used internally to get review number and averages for babysitters.
     *
     * @return mixed
     */
    public function reviewsAverage()
    {
        return $this->hasMany('App\Models\BabysitterReview')->selectRaw('babysitter_id, AVG(score) AS rating')->published()->groupBy('babysitter_id');
    }

    /**
     * Get average review score for babysitter. Published only.
     *
     * @return float|int
     */
    public function getReviewsAverageAttribute()
    {
        if (!$this->relationLoaded('reviewsAverage')) $this->load('reviewsAverage');

        $related = $this->getRelation('reviewsAverage');
        return ($related && $related->first()) ? round($related->first()->rating, 1) : 0;
    }

    /**
     * Get count of reviews for babysitter. Published only
     *
     * @return int
     */
    public function getReviewsNumberAttribute()
    {
        if (!$this->relationLoaded('reviews')) $this->load('reviews');

        $related = $this->getRelation('reviews');
        return ($related) ? $related->where('published', 1)->count() : 0;
    }

    public function getInterviewTimeAttribute($value)
    {
        if (empty($value)) return '';

        $time = \DateTime::createFromFormat('H:i:s', $value);
        return $time->format('H:i');
    }

    public function getValidIdAsIconAttribute()
    {
        return ($this->has_valid_id == 1) ? '<img src="/assets/admin/icons/t.png"/>' : '<img src="/assets/admin/icons/c.png"/>';
    }

    public function getValidQualificationsAsIconAttribute()
    {
        return ($this->has_valid_qualifications == 1) ? '<img src="/assets/admin/icons/t.png"/>' : '<img src="/assets/admin/icons/c.png"/>';
    }

    public function getValidReferencesAsIconAttribute()
    {
        return ($this->has_valid_references == 1) ? '<img src="/assets/admin/icons/t.png"/>' : '<img src="/assets/admin/icons/c.png"/>';
    }

    public function getSuccessfulInterviewAsIconAttribute()
    {
        return ($this->interview_successful == 1) ? '<img src="/assets/admin/icons/t.png"/>' : '<img src="/assets/admin/icons/c.png"/>';
    }

    public function getCompletedRegistrationAsIconAttribute()
    {
        return ($this->hasCompletedRegistration()) ? '<img src="/assets/admin/icons/t.png"/>' : '<img src="/assets/admin/icons/c.png"/>';
    }

    // Methods

    /**
     * Check if babysitter is active and completed the registration
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->published == 1 && $this->reg_form_submitted == 1;
    }

    /**
     * Check if babysitter completed registration process fully
     *
     * @return bool
     */
    public function hasCompletedRegistration()
    {
        return $this->reg_form_submitted == 1;
    }

    /**
     * Check if training is valid. Used tos how icons etc.
     *
     * @return bool
     * @throws \Exception
     */
    public function hasValidFirstAidTraining()
    {
        return $this->first_aid_passed && $this->first_aid_expiry && new \DateTime($this->first_aid_expiry) > new \DateTime();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($babysitter) { // before delete() method call this
            if ($babysitter->isForceDeleting()) {
                $babysitter->user->forceDelete();
            }
        });
    }
}
