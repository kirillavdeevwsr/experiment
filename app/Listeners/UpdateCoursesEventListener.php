<?php

namespace App\Listeners;

use App\Events\UpdateCoursesEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;

class UpdateCoursesEventListener
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
     * @param  UpdateCoursesEvent  $event
     * @return void
     */
    public function handle(UpdateCoursesEvent $event)
    {
        $history = new History();
        $history->datetime = time();
        $history->operation = 'Редактирование курса';
        $history->object_type = 'courses';
        $history->object_id = $event->course->id;
        $history->user = $event->user->id;
        $history->save();
    }
}
