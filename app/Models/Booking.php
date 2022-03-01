<?php

namespace App\Models;

use A17\Twill\Models\Model;
use App\Events\BookingCompletedSuccessfully;
use App\Events\BookingConfirmed;

class Booking extends Model
{
    protected $fillable = [
        'family_id',
        'babysitter_id',
        'status_id',
        'start',
        'end',
        'completed_at',
        'parent_completed_at',
        'babysitter_completed_at',
    ];

    protected $dates = [
        'start',
        'end',
        'created_at',
        'completed_at',
        'parent_completed_at',
        'babysitter_completed_at',
    ];

    public function babysitter()
    {
        return $this->belongsTo('App\Models\Babysitter', 'babysitter_id');
    }

    public function review()
    {
        return $this->hasOne('App\Models\BabysitterReview', 'booking_id', 'id');
    }

    public function family()
    {
        return $this->belongsTo('App\Models\Family', 'family_id');
    }

    public function bookingChildren()
    {
        return $this->hasMany('App\Models\BookingChild', 'booking_id', 'id');
    }

    public function bookingStatus()
    {
        return $this->hasOne('App\Models\BookingStatus', 'id', 'status_id');
    }

    public function bookingAddress()
    {
        return $this->hasOne('App\Models\BookingAddress', 'id', 'booking_address_id');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\BookingInvoice', 'booking_id', 'id');
    }

    // Scopes

    /**
     * Get current, ongoing bookings or the ones that are in the past and still need resolving
     *
     * @param $query
     * @return mixed
     */
    public function scopeCurrentBookings($query)
    {
        return $query->where(function($q){
            $q->whereDate('start', '<=', date('Y-m-d H:i:s'))->whereDate('end', '>=', date('Y-m-d H:i:s'));
        })->orWhere(function($q){
            $q->whereDate('end', '<=', date('Y-m-d H:i:s'))->where('status_id', 4);
        });
    }

    /**
     * Get upcoming bookings
     *
     * @param $query
     * @return mixed
     */
    public function scopeUpcomingBookings($query)
    {
        return $query->whereDate('start', '>', date('Y-m-d H:i:s'))->where('completed_at', null);
    }

    /**
     * Get historic bookings except "confirmed". Those should be resolved before considered historic
     *
     * @param $query
     * @return mixed
     */
    public function scopePastBookings($query)
    {
        return $query->where(function($q) {
            $q->whereDate('end', '<', date('Y-m-d H:i:s'))->where('status_id', '<>', 4);
        })->orWhere(function($q){
            $q->whereDate('end', '>=', date('Y-m-d H:i:s'))->where('status_id', '<>', 4)->where('completed_at', '<>', null);
        });
    }

    /**
     * Get only confirmed bookings. Ignore canceled and pending for payment
     *
     * @param $query
     * @return mixed
     */
    public function scopeConfirmedOnly($query){
        return $query->where('status_id', 4);
    }

    public function scopeCancelledOnly($query){
        return $query->whereIn('status_id', [2,3]);
    }

    public function scopeConfirmedOrCompletedOnly($query)
    {
        return $query->whereIn('status_id', [4,5]);
    }

    /**
     * @param $query
     * @param int|Babysitter $babysitter
     * @return mixed
     */
    public function scopeForBabysitter($query, $babysitter)
    {
        $id = $babysitter;
        if($babysitter instanceof Babysitter)
        {
            $id = $babysitter->id;
        }

        return $query->where('babysitter_id', $id);
    }

    /**
     * @param $query
     * @param int|Family $family
     * @return mixed
     */
    public function scopeForFamily($query, $family)
    {
        $id = $family;
        if($family instanceof Family)
        {
            $id = $family->id;
        }

        return $query->where('family_id', $id);
    }

    public function scopeBookingNeedBabysitterAction($query, $babysitter_id)
    {
        $bookings_need_action = $query
            ->where(function($q){
                return $q->whereDate('start', '>', date('Y-m-d H:i:s'))->orWhere(function($q){
                    $q->where(function($q){
                        return $q->whereDate('start', '<=', date('Y-m-d H:i:s'))->whereDate('end', '>=', date('Y-m-d H:i:s'));
                    })->orWhere(function($q){
                        return$q->whereDate('end', '<=', date('Y-m-d H:i:s'))->where('status_id', 4);
                    });
                });
            })
            ->where(function ($q) use($babysitter_id){
                return $q->where(function($q) use($babysitter_id){
                    return $q->forBabysitter($babysitter_id)->whereNull('babysitter_completed_at')->whereNotNull('parent_completed_at');
                })->orWhere(function($q) use($babysitter_id){
                    return $q->forBabysitter($babysitter_id)->where('status_id', 6);
                });
            });

        return $bookings_need_action;
    }


    // Functions

    public function createInvoice(string $type, int $amount_due, int $amount_paid = 0, $reference = null, string $description = '')
    {
        $count = $this->invoices()->count() + 1;

        return $this->invoices()->create([
            'type' => $type,
            'amount_due' => $amount_due,
            'amount_paid' => $amount_paid,
            'reference' => (is_null($reference)) ? 'T'.str_pad($this->id, 5, '0', STR_PAD_LEFT).'-'.$count : $reference,
            'description' => $description,
            'babysitter_address' => $this->babysitter->mainAddress->first(['address1', 'address2', 'town', 'postcode', 'country']),
            'family_address' => $this->family->address->first(['address1', 'address2', 'town', 'postcode', 'country']),
        ]);
    }

    /**
     * Set booking status and call events
     *
     * @param int $new_status
     * @return $this
     */
    public function setStatus(int $new_status){
        $this->status_id = $new_status;
        $this->save();

        if($new_status === 4)
        {
            // Started the event, not sure if needed any more. Check
            //event( new BookingConfirmed($this));
        }
        elseif($new_status === 2 || $new_status === 3)
        {
            //event(new BookingCancelled($booking));
        }
        elseif($new_status === 5)
        {
            //event(new BookingCompleted($booking));
        }

        $final_statuses = [2,3,5];
        if(in_array($new_status, $final_statuses))
        {
            if(auth()->user()->role === 'babysitter')
            {
                $this->babysitter_completed_at = new \DateTime();
                $this->save();
                return;
            }

            $this->parent_completed_at = new \DateTime();
            $this->save();
        }

        return $this;
    }

    public function confirmStatus()
    {
        if(auth()->user()->role === 'babysitter')
        {
            $this->babysitter_completed_at = new \DateTime();
            $this->completed_at = new \DateTime();
            $this->save();
            return;
        }

        $this->parent_completed_at = new \DateTime();
        $this->completed_at = new \DateTime();
        $this->save();

        if($this->status_id === 5) //completed booking
        {
            event(new BookingCompletedSuccessfully($this->invoices));
        }

        return $this;
    }

    public function getPossibleBookingStatuses()
    {
        if(auth()->user()->role === 'parent')
        {
            if($this->parentMarkedAsCompleted) return [];

            if($this->status_id === 2) return ['confirm'];
            elseif($this->status_id === 4)
            {
                if($this->start > new \DateTime()) return ['cancel'];
            }
            elseif($this->status_id === 5) return ['confirm'];
            elseif($this->status_id === 6) return ['cancel'];
        }
        else
        {
            if($this->babysitter_completed_at) return [];

            if($this->status_id === 3) return ['confirm'];
            elseif($this->status_id === 4)
            {
                if($this->end < new \DateTime()) return ['done'];
                if($this->start > new \DateTime()) return ['down'];
            }
            elseif($this->status_id === 6){
                if($this->start > new \DateTime()) return ['up', 'down'];
            }
        }

        return [];
    }

    // Attributes

    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function getStartDateAttribute()
    {
        if($this->type == 'holiday_nanny') return $this->start->format('d/m/Y');
        return $this->start->format('d/m/Y H:i');
    }
    public function getStartDateFullAttribute()
    {
        if($this->type == 'holiday_nanny') return $this->start->format('d M Y');
        return $this->start->format('d M Y H:i');
    }

    public function getEndDateAttribute()
    {
        if($this->type == 'holiday_nanny') return $this->end->format('d/m/Y');
        return $this->end->format('d/m/Y H:i');
    }
    public function getEndDateFullAttribute()
    {
        if($this->type == 'holiday_nanny') return $this->end->format('d M Y');
        return $this->end->format('d M Y H:i');
    }

    public function getBookingTypeHumanReadableAttribute()
    {
        return ($this->type === 'babysitter') ? 'babysitter' : 'holiday nanny';
    }

    public function getDurationAttribute()
    {
        if($this->type == 'holiday_nanny'){
            return $this->start->diffInDays($this->end).' days';
        }
        return $this->start->diffInHours($this->end).' hours';
    }

    public function getIdPaddedAttribute()
    {
        return 'T'.str_pad($this->id, 5, '0', STR_PAD_LEFT);
    }

    public function getCompletedAttribute()
    {
        return $this->completed_at !== null;
    }

    public function getBabysitterMarkedAsCompletedAttribute()
    {
        return $this->babysitter_completed_at !== null;
    }

    public function getParentMarkedAsCompletedAttribute()
    {
        return $this->parent_completed_at !== null;
    }

    public function getIdPaddedWithLinkAttribute()
    {
        return '<a href="'.route('admin.bookings.show', $this->id).'">'.$this->idPadded.'</a>';
    }

    public function getReceivedPayoutsAttribute()
    {
        $sum = 0;
        foreach($this->invoices as $invoice)
        {
            if($invoice->amount_paid !== 0 && $invoice->amount_paid === $invoice->amount_due && $invoice->payout && $invoice->payout->amount > 0)
            {
                $sum += $invoice->payout->amount;
            }
        }
        return number_format($sum / 100,2, '.', '');
    }
}
