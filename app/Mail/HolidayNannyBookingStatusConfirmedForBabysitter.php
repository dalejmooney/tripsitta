<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HolidayNannyBookingStatusConfirmedForBabysitter extends Mailable
{
    use SerializesModels;

    private $name, $start_date, $end_date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $start_date, $end_date)
    {
        $this->name = $name;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function subject($subject)
    {
        return 'You Have Received A New Holiday Nanny Booking – Urgent Action Required!';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.holiday_nanny_booking_status_confirmed_for_babysitter')->with([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);
    }
}
