<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Support\Facades\Redirect;


class EventController extends Controller
{
    public function index(){
//        $now=Carbon::now()->format('Y-m-d');
        $events=Events::orderBy('start', 'desc')->paginate(5);
//        $events=Events::where('start', '>', $now)->paginate(5);
        return view('events_all', compact('events'));
    }

    public function show($slug){
        if(is_numeric($slug)){
            $event=Events::findOrFail($slug);
            return Redirect::to(route('show_event', $event->slug), 301);
        }
        $event= Events::whereSlug($slug)->firstOrFail();
        return view('events_detail', compact('event'));
    }
}
