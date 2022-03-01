<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
    use SerializesModels;

    private $contact_details;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact_details)
    {
        $this->contact_details = $contact_details;
    }

    public function subject($subject)
    {
        return 'Tripsitta Contact Form - new message';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.contact_form')->with([
            'name' => strip_tags($this->contact_details['contact_name']),
            'email' => $this->contact_details['contact_email'],
            'email_message' => strip_tags($this->contact_details['contact_message']),
            'contacted_at' => (new Carbon())->format('d M Y H:i:s'),
        ]);
    }
}
