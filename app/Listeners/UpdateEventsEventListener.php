<?php

namespace App\Listeners;

use App\Events\UpdateEventsEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;

class UpdateEventsEventListener
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
     * @param  UpdateEventsEvent  $event
     * @return void
     */
    public function handle(UpdateEventsEvent $event)
    {
        $history = new History();
        $history->datetime = time();
        $history->operation = 'Редактирование события';
        $history->object_type = 'events';
        $history->object_id = $event->event->id;
        $history->user = $event->user->id;
        $history->save();
    }
}
