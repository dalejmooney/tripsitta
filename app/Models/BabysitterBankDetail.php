<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;

class BabysitterBankDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'currency',
        'transferwise_type',
        'iban',
        'sort_code',
        'account_number',
        'address1',
        'address2',
        'town',
        'state',
        'postcode',
        'country',
        'account_type'
    ];

    public function babysitter()
    {
        return $this->belongsTo(Babysitter::class);
    }


    // methods

    public static function getTransferwiseTypeFromCurrency($currency)
    {
        return Arr::get(config('tripsitta.transferwise_payout_currencies'), $currency.'.recipient_type', '');
    }
}
