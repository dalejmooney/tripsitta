<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChatMessageReceived extends Mailable
{
    use SerializesModels;

    private $name, $link;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $link)
    {
        $this->name = $name;
        $this->link = $link;
    }

    public function subject($subject)
    {
        return 'You Have A New Personal Message – Log In Now To View';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.chat_message_received')->with([
            'name' => $this->name,
            'link' => $this->link
        ]);
    }
}
