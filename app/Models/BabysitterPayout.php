<?php

namespace App\Models;

use A17\Twill\Models\Model;

class BabysitterPayout extends Model
{
    public $fillable = ['amount', 'invoice_id', 'bank_details_id', 'transferwise_payment_id'];
    protected $dates = ['created_at', 'updated_at'];

    public function invoice()
    {
        return $this->belongsTo('App\Models\BookingInvoice');
    }

    public function bank_details()
    {
        return $this->belongsTo('App\Models\BabysitterBankDetail');
    }



    public function getAmountInPoundsAttribute(){
        return $this->amount / 100;
    }

    public function getAmountFormattedAttribute(){
        return $this->formatMoney($this->getAmountInPoundsAttribute());
    }

    public function getAmountFormattedColouredAttribute(){
        if($this->invoice_id !== null)
        {
            if($this->amount != $this->invoice->babysitterEarnings)
            {
                return '<span style="color:red">'.$this->getAmountFormattedAttribute().'</span>';
            }
            return $this->getAmountFormattedAttribute();
        }
        else
        {
            return 'Not available';
        }
    }

    public function getInvoiceIdWithLinkAttribute()
    {
        if($this->invoice_id !== null)
        {
            return '<a href="'.route('admin.invoices.show', $this->invoice_id).'">'.$this->invoice->reference.'</a>';
        }
        return 'Not assigned';
    }

    public function getStatusAttribute()
    {
        if($this->invoice->balance !== 0)
        {
            return 'Awaiting customer payment';
        }
        if($this->amount === 0)
        {
            return 'Pending authorization';
        }
        if($this->invoice->babysitterEarnings !== $this->amount)
        {
            return 'Partially authorized';
        }

        return 'Withdrawal successful';
    }

    // helpers

    private function formatMoney($amount) :string
    {
        return '&euro; '.number_format($amount, 2);
    }
}
