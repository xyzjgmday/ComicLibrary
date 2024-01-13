<?php

namespace App\Providers;

use App\Events\LastLoginEvent;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \App\Events\ExampleEvent::class => [
            \App\Listeners\ExampleListener::class,
        ],
        LastLoginEvent::class => [
            LastLoginEvent::class,
        ],
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */

    public function boot()
    {
        parent::boot();
    }


    public function shouldDiscoverEvents()
    {
        return false;
    }
}
