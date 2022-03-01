<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewRegistrationBabysitter extends Mailable
{
    use SerializesModels;

    private $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $date, $time)
    {
        $this->name = $name;
        $this->interview_date = $date;
        $this->interview_time = $time;
    }

    public function subject($subject)
    {
        return 'Your Tripsitta Interview Details';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.new_registration_babysitter')->with([
            'name' => $this->name,
            'interview_date' => $this->interview_date,
            'interview_time' => $this->interview_time,
        ]);
    }
}
