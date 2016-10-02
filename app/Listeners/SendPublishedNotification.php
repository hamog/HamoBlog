<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Notifications\PublishedPost;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPublishedNotification implements ShouldQueue
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
     * @param  PostPublished  $event
     * @return void
     */
    public function handle(PostPublished $event)
    {
        auth()->user()->notify(new PublishedPost($event->post));
    }
}
