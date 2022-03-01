<?php

namespace App\Models;

use A17\Twill\Models\Model;

class BookingInvoice extends Model
{
    protected $fillable = [
        'booking_id',
        'type',
        'amount_due',
        'amount_paid',
        'reference',
        'description',
        'paid_at',
        'babysitter_address',
        'family_address',
    ];

    protected $dates = [
        'paid_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'babysitter_address' => 'array',
        'family_address' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking');
    }

    public function babysitter()
    {
        return $this->hasOneThrough('App\Models\Babysitter', 'App\Models\Booking', 'id', 'id', 'booking_id', 'babysitter_id');
    }

    public function family()
    {
        return $this->hasOneThrough('App\Models\Family', 'App\Models\Booking', 'id', 'id', 'booking_id', 'family_id');
    }

    public function payout()
    {
        return $this->hasOne('App\Models\BabysitterPayout', 'invoice_id');
    }

    // scopes

    // methods

    public static function getGrandTotalForBooking($booking, $convertToPounds=false)
    {
        $sum = BookingInvoice::where('booking_id', $booking->id)->sum('amount_due');
        if($convertToPounds) $sum = $sum / 100;
        return $sum;
    }

    public static function getPaidAmountForBooking($booking, $convertToPounds=false)
    {
        $sum = BookingInvoice::where('booking_id', $booking->id)->sum('amount_paid');
        if($convertToPounds) $sum = $sum / 100;
        return $sum;
    }

    // Attributes

    public function getAmountDueInPoundsAttribute()
    {
        return $this->amount_due / 100;
    }
    public function getAmountDueFormattedAttribute()
    {
        return $this->formatMoney($this->getAmountDueInPoundsAttribute());
    }

    public function getAmountPaidInPoundsAttribute()
    {
        return $this->amount_paid / 100;
    }
    public function getAmountPaidFormattedAttribute()
    {
        return $this->formatMoney($this->getAmountPaidInPoundsAttribute());
    }

    public function getBalanceAttribute()
    {
        return $this->amount_paid - $this->amount_due;
    }
    public function getBalanceStatusAttribute(){
        return ($this->balance === 0) ? '<img src="/assets/admin/icons/t.png"/>' : '<img src="/assets/admin/icons/c.png"/>';
    }
    public function getBalanceInPoundsAttribute()
    {
        return $this->balance / 100;
    }
    public function getBalanceFormattedAttribute()
    {
        $balance = $this->getBalanceInPoundsAttribute();
        if($balance < 0)
        {
            return '<span style="color:red">'.$this->formatMoney($this->getBalanceInPoundsAttribute()).'</span>';
        }
        return $this->formatMoney($this->getBalanceInPoundsAttribute());
    }

    public function getBabysitterEarningsForBookingAttribute()
    {
        if(!$this->relationLoaded('booking')) $this->load('booking');

        return (new \App\Service\BookingCommission())->calculateForBooking($this->booking)['for_babysitter'];
    }
    public function getBabysitterEarningsForBookingInPoundsAttribute()
    {
        return $this->babysitterEarningsForBooking / 100;
    }

    public function getAdminEarningsForBookingAttribute()
    {
        if(!$this->relationLoaded('booking')) $this->load('booking');

        return (new \App\Service\BookingCommission())->calculateForBooking($this->booking)['for_admin'];
    }
    public function getAdminEarningsForBookingInPoundsAttribute()
    {
        return $this->adminEarningsForBooking / 100;
    }

    public function getBabysitterEarningsAttribute()
    {
        if(!$this->relationLoaded('booking')) $this->load('booking');

        return (new \App\Service\BookingCommission())->estimate($this->booking->type, $this->amount_due)['for_babysitter'];
    }
    public function getBabysitterEarningsInPoundsAttribute()
    {
        return $this->babysitterEarnings / 100;
    }
    public function getBabysitterEarningFormattedAttribute()
    {
        return $this->formatMoney($this->getBabysitterEarningsInPoundsAttribute());
    }

    public function getAdminEarningsAttribute()
    {
        if(!$this->relationLoaded('booking')) $this->load('booking');

        return (new \App\Service\BookingCommission())->estimate($this->booking->type, $this->amount_due)['for_admin'];
    }
    public function getAdminEarningsInPoundsAttribute()
    {
        return $this->adminEarnings / 100;
    }
    public function getAdminEarningFormattedAttribute()
    {
        return $this->formatMoney($this->getAdminEarningsInPoundsAttribute());
    }

    public function getAdminEarningsCurrentAttribute()
    {
        if(!$this->relationLoaded('booking')) $this->load('booking');

        return (new \App\Service\BookingCommission())->estimate($this->booking->type, $this->amount_paid)['for_admin'];
    }
    public function getAdminEarningsCurrentInPoundsAttribute()
    {
        return $this->adminEarningsCurrent / 100;
    }
    public function getAdminEarningCurrentFormattedAttribute()
    {
        $earn = $this->getAdminEarningsCurrentInPoundsAttribute();
        if($earn == 0)
        {
            return '<span style="color:red">'.$this->formatMoney($earn).'</span>';
        }
        return $this->formatMoney($earn);
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    // helpers

    private function formatMoney($amount) :string
    {
        return '&euro; '.number_format($amount, 2);
    }
}
