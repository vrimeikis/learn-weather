<?php

namespace App\Listeners;

use App\Events\WindChanged;
use App\Mail\SendWindChangeMail;
use Illuminate\Support\Facades\Mail;

class SendWindChangeListener
{
    private $emailAddress;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->emailAddress = env('EMAIL_ADDRESS');
    }

    /**
     * Handle the event.
     *
     * @param WindChanged $event
     * @return void
     */
    public function handle(WindChanged $event)
    {
        Mail::to($this->emailAddress)->send(new SendWindChangeMail($event->type));
    }
}
