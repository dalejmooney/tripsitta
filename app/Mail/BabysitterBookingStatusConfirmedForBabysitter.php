<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BabysitterBookingStatusConfirmedForBabysitter extends Mailable
{
    use SerializesModels;

    private $name, $start_date, $end_date, $address;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $start_date, $end_date, $address)
    {
        $this->name = $name;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->address = $address;
    }

    public function subject($subject)
    {
        return 'You Have Received A New Babysitting Booking – Urgent Action Required!';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.babysitter_booking_status_confirmed_for_babysitter')->with([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'address' => $this->address,
        ]);
    }
}
