<?php

namespace App\Listeners;

use App\Events\CreateEventsEvent;
use DemeterChain\C;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;

class CreateEventsEventListener
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
     * @param  CreateEventsEvent  $event
     * @return void
     */
    public function handle(CreateEventsEvent $event)
    {
        $history = new History();
        $history->datetime = time();
        $history->operation = 'Создание события';
        $history->object_type = 'events';
        $history->object_id = $event->event->id;
        $history->user = $event->user->id;
        $history->save();
    }
}
