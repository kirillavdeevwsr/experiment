<?php

namespace App\Listeners;

use App\Events\DeleteCoursesEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Controllers\Admin;
use App\Models\History;
use App\Models\Course;

class DeleteCoursesEventListener
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
     * @param  DeleteCoursesEvent  $event
     * @return void
     */
    public function handle(DeleteCoursesEvent $event)
    {
        if (is_null(Course::find($event->course))){
            $history = new History();
            $history->datetime = time();
            $history->operation = 'Удаление курса';
            $history->object_type = 'courses';
            $history->object_id = $event->course;
            $history->user = $event->user->id;
            $history->save();
        }
    }
}
