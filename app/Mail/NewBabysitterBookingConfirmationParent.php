<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewBabysitterBookingConfirmationParent extends Mailable
{
    use SerializesModels;

    private $name, $start_date_time, $end_date_time, $babysitter_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $start_date_time, $end_date_time, $babysitter_name)
    {
        $this->name = $name;
        $this->start_date_time = $start_date_time;
        $this->end_date_time = $end_date_time;
        $this->babysitter_name = $babysitter_name;
    }

    public function subject($subject)
    {
        return 'Your Tripsitta Booking Has Been Received - Important Please Read';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.new_babysitter_booking_confirmation_parent')->with([
            'name' => $this->name,
            'start_date_time' => $this->start_date_time,
            'end_date_time' => $this->end_date_time,
            'babysitter_name' => $this->babysitter_name,
        ]);
    }
}
