<?php

namespace App\Http\Controllers\Admin;

use App\Models\Events;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\CreateEventsEvent;
use App\Events\UpdateEventsEvent;
use App\Events\DeleteEventsEvent;
use App\Service\FileStorage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $filesSave;

    public function __construct(FileStorage $filesSave)
    {
        $this->filesSave = $filesSave;
    }

    public function index()
    {

        $events = Events::orderBy('created_at', 'desc')->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.events.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->filled(['title', 'start', 'finish', 'lecture', 'preview'])) {
            $event = new Events();
            $event->fill($request->all());
            $event->save();
            event(new CreateEventsEvent($event, $request->user()));
            return view('admin.events.show', compact('event'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Events  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Events $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Events  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Events $event)
    {
        return view('admin.events.form', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Events  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Events $event)
    {
        Events::where('id', $event->id)->update([
            'title' => $request->title,
            'start' => $request->start,
            'finish' => $request->finish,
            'lecture' => $request->lecture,
            'preview' => $request->preview,
            'text' => $request->text,

        ]);
        event(new UpdateEventsEvent($event, $request->user()));
        return redirect('admin/events');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Events $event
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Events $event, Request $request)
    {
        Events::destroy($event->id);
        event(new DeleteEventsEvent($event->id, $request->user()));
        return redirect('/admin/events');
    }
}
