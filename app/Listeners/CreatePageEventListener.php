<?php

namespace App\Listeners;

use App\Events\CreatePageEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;

class CreatePageEventListener implements ShouldQueue
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
     * @param  CreatePageEvent  $event
     * @return void
     */
    public function handle(CreatePageEvent $event)
    {
        $history = new History();
        $history->datetime = time();
        $history->operation = 'Создание страницы';
        $history->object_type = 'pages';
        $history->object_id = $event->page->id;
        $history->user = $event->user->id;
        $history->save();
    }
}
