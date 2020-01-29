<?php

namespace App\Listeners;

use App\Events\DeleteNewsEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;
use App\Models\News;

class DeleteNewsEventListener implements ShouldQueue
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
     * @param  DeleteNewsEvent  $event
     * @return void
     */

    public function handle(DeleteNewsEvent $event)
    {
        if (is_null(News::find($event->news))){
            $log = new History();
            $log->datetime=time();
            $log->operation = 'Удаление новости';
            $log->object_type = 'news';
            $log->object_id = $event->news;
            $log->user = $event->user->id;
            $log->save();
        }

    }
}
