<?php

namespace App\Listeners;

use App\Models\BabysitterPayout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreatePayoutRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        foreach($event->invoices as $invoice)
        {
            $new_payout = new BabysitterPayout();
            $new_payout->amount = 0;
            $new_payout->invoice_id = $invoice->id;
            $new_payout->bank_details_id = $invoice->babysitter->bank->id;
            $new_payout->save();
        }
    }
}
