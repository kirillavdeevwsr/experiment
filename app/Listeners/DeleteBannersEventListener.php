<?php

namespace App\Listeners;

use App\Events\DeleteBannersEvent;
use App\Models\History;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Banner;

class DeleteBannersEventListener implements ShouldQueue
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
     * @param  DeleteBannersEvent  $event
     * @return void
     */
    public function handle(DeleteBannersEvent $event)
    {
        if (is_null(Banner::find($event->banner))){
            $history = new History();
            $history->datetime = time();
            $history->operation = 'Удаление баннера';
            $history->object_type = 'banners';
            $history->object_id = $event->banner;
            $history->user = $event->user->id;
            $history->save();
        }

    }
}
