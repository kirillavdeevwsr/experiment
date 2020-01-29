<?php

namespace App\Listeners;

use App\Events\UpdateNewsEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;

class UpdateNewsEventListener implements ShouldQueue
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
     * @param  UpdateNewsEvent  $event
     * @return void
     */
    public function handle(UpdateNewsEvent $event)
    {
        $history = new History();
        $history->datetime = time();
        $history->operation = 'Изменение новости';
        $history->object_type = 'news';
        $history->object_id = $event->news->id;
        $history->user = $event->user->id;
        $history->save();
    }
}
