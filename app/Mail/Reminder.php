<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Reminder extends Mailable
{

    use Queueable, SerializesModels;

    public $data1;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data1)
    {
        return $this->data1 = $data1;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Reminder Mail from Shikkha")
        ->markdown('reminder_mail')
        ->with($this->data1);
    }
}
