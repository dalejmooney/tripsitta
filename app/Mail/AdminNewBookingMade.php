<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNewBookingMade extends Mailable
{
    use SerializesModels;

    private $booking_id, $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking_id, $link)
    {
        $this->booking_id = $booking_id;
        $this->link = $link;
    }

    public function subject($subject)
    {
        return 'Tripsitta Admin - New Booking';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.admin_new_booking_made')->with([
            'booking_id' => $this->booking_id,
            'link' => $this->link
        ]);
    }
}
