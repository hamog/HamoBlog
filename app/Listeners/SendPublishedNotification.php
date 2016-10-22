<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Notifications\PublishedPost;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;

class SendPublishedNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PostPublished  $event
     * @return void
     */
    public function handle(PostPublished $event)
    {
        //auth()->user()->notify(new PublishedPost($event->post));
        $users = User::all();
        Notification::send($users, new PublishedPost($event->post));
    }
}
