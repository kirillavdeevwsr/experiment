<?php

namespace App\Listeners;

use App\Events\CreateCoursesEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\History;

class CreateCoursesEventListener
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
     * @param  CreateCoursesEvent  $event
     * @return void
     */
    public function handle(CreateCoursesEvent $event)
    {
        $history = new History();
        $history->datetime = time();
        $history->operation = 'Создание курса';
        $history->object_type = 'courses';
        $history->object_id = $event->course->id;
        $history->user = $event->user->id;
        $history->save();
    }
}
