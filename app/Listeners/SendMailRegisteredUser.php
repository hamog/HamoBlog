<?php

namespace App\Listeners;

use App\Mail\WelcomeToNewUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendMailRegisteredUser implements ShouldQueue
{
    /**
     * Create the event listener.
     *
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
        Mail::send($event->user)->queue(new WelcomeToNewUser($event->user));
    }
}
