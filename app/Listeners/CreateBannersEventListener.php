<?php

namespace App\Listeners;

use App\Events\CreateBannersEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;

class CreateBannersEventListener implements ShouldQueue
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
     * @param  CreateBannersEvent  $event
     * @return void
     */
    public function handle(CreateBannersEvent $event)
    {
        $history = new History();
        $history->datetime = time();
        $history->operation = 'Создание баннера';
        $history->object_type = 'banners';
        $history->object_id = $event->banner->id;
        $history->user = $event->user->id;
        $history->save();
    }
}
