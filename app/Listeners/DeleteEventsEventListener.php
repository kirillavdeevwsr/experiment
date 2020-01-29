<?php

namespace App\Listeners;

use App\Events\DeleteEventsEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\Admin;
use App\Models\History;
use App\Models\Events;

class DeleteEventsEventListener
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
     * @param  DeleteEventsEvent  $event
     * @return void
     */
    public function handle(DeleteEventsEvent $event)
    {
        if (is_null(Events::find($event->event))){
            $history = new History();
            $history->datetime = time();
            $history->operation = 'Удаление события';
            $history->object_type = 'events';
            $history->object_id = $event->event;
            $history->user = $event->user->id;
            $history->save();
        }
    }
}
