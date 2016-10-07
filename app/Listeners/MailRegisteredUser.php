<?php

namespace App\Listeners;

use App\Mail\WelcomeNewUserMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class MailRegisteredUser implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        Mail::to($event->user)->queue(new WelcomeNewUserMail($event->user));
    }
}
