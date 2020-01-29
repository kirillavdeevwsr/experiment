<?php

namespace App\Listeners;

use App\Events\CreateNewsEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;

class CreateNewsEventListener implements ShouldQueue
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
     * @param  CreateNewsEvent  $event
     * @return void
     */
    public function handle(CreateNewsEvent $event)
    {
        $history = new History();
        $history->datetime = time();
        $history->operation = 'Создание новости';
        $history->object_type = 'news';
        $history->object_id = $event->news->id;
        $history->user = $event->user->id;
        $history->save();
    }
}
