<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreateUrlEvent;
use App\Events\DeleteUrlEvent;
use App\Events\UpdateUrlEvent;
use App\Models\Url;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = Url::orderBy('created_at', 'desc')->get();
        return view('admin.url.index', compact('url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.url.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->filled(['title', 'url'])) {
            $url = new Url();
            $url->fill($request->all());
            $url->save();
            event(new CreateUrlEvent($url, $request->user()));
            return view('admin.url.show', compact('url'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Url $url
     * @return \Illuminate\Http\Response
     */
    public function show(Url $url)
    {
        return view('admin.url.show', compact('url'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Url $url
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $url)
    {
        return view('admin.url.form', compact('url'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Url $url
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Url $url)
    {
        Url::where('id', $url->id)->update([
            'title' => $request->title,
            'url' => $request->url,

        ]);
        event(new UpdateUrlEvent($url, $request->user()));
        return redirect('admin/url');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Url $url
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $url, Request $request)
    {
        Url::destroy($url->id);
        event(new DeleteUrlEvent($url->id, $request->user()));
        return redirect('/admin/url');
    }
}
