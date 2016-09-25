<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('UserLoggedInWithSocial', function () {
            $dateTime = Carbon::now()->format('d F Y, H:i:s');
            $userName = auth()->user()->name;
            \Log::info("The user {$userName} logged in on {$dateTime} with social networks.");
        });
    }
}
