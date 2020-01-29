<?php

namespace App\Listeners;

use App\Events\UpdatePageEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;

class UpdatePageEventListener implements ShouldQueue
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
     * @param  UpdatePageEvent  $event
     * @return void
     */
    public function handle(UpdatePageEvent $event)
    {
        $history = new History();
        $history->datetime = time();
        $history->operation = 'Изменение страницы';
        $history->object_type = 'pages';
        $history->object_id = $event->page->id;
        $history->user = $event->user->id;
        $history->save();
    }
}
