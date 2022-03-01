<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingNewInvoiceRaised extends Mailable
{
    use SerializesModels;

    private $name, $babysitter_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $babysitter_name)
    {
        $this->name = $name;
        $this->babysitter_name = $babysitter_name;
    }

    public function subject($subject)
    {
        return 'Invoice For Extra Time - Please Log In To View';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.booking_new_invoice_raised')->with([
            'name' => $this->name,
            'babysitter_name' => $this->babysitter_name,
        ]);
    }
}
