<?php

namespace App\Listeners;

use App\Events\UpdateBannersEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;

class UpdateBannersEventListener implements ShouldQueue
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
     * @param  UpdateBannersEvent  $event
     * @return void
     */
    public function handle(UpdateBannersEvent $event)
    {
        $history = new History();
        $history->datetime = time();
        $history->operation = 'Изменение баннера';
        $history->object_type = 'banners';
        $history->object_id = $event->banner->id;
        $history->user = $event->user->id;
        $history->save();
    }
}
