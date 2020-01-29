<?php

namespace App\Providers;

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
        'App\Events\CreatePageEvent' => [
            'App\Listeners\CreatePageEventListener',
        ],
        'App\Events\UpdatePageEvent' => [
            'App\Listeners\UpdatePageEventListener',
        ],
        'App\Events\CreateNewsEvent' => [
            'App\Listeners\CreateNewsEventListener',
        ],
        'App\Events\UpdateNewsEvent' => [
            'App\Listeners\UpdateNewsEventListener',
        ],
        'App\Events\DeleteNewsEvent' => [
            'App\Listeners\DeleteNewsEventListener',
        ],
        'App\Events\CreateBannersEvent' => [
            'App\Listeners\CreateBannersEventListener',
        ],
        'App\Events\UpdateBannersEvent' => [
            'App\Listeners\UpdateBannersEventListener',
        ],
        'App\Events\DeleteBannersEvent' => [
            'App\Listeners\DeleteBannersEventListener',
        ],
        'App\Events\CreateCoursesEvent' => [
            'App\Listeners\CreateCoursesEventListener',
        ],
        'App\Events\UpdateCoursesEvent' => [
            'App\Listeners\UpdateCoursesEventListener',
        ],
        'App\Events\DeleteCoursesEvent' => [
            'App\Listeners\DeleteCoursesEventListener',
        ],

        'App\Events\CreateEventsEvent' => [
            'App\Listeners\CreateEventsEventListener',
        ],
        'App\Events\UpdateEventsEvent' => [
            'App\Listeners\UpdateEventsEventListener',
        ],
        'App\Events\DeleteEventsEvent' => [
            'App\Listeners\DeleteEventsEventListener',
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

        //
    }
}
