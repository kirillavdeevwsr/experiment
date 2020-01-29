<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreatePageEvent;
use App\Events\UpdatePageEvent;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pages=Page::all();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {
        $parents=Page::all();
        return view('admin.pages.form', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->filled(['title', 'text', 'sort'])){
            $page=new Page();
            $page->fill($request->all());
            $page->status=1;
            $page->save();
            event(new CreatePageEvent($page, $request->user()));
            return redirect('admin/page');
        }else{
            return redirect()->back()->with('mes', 'Нужно заполнить все поля');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $parents=Page::all();
        return view('admin.pages.form', compact(['page', 'parents']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        Page::where('id', $page->id)->update([
            'title'=>$request->title,
            'text'=>$request->text,
            'status'=>$request->status,
            'parent'=>$request->parent,
            'sort'=>$request->sort,
        ]);
        event(new UpdatePageEvent($page, $request->user()));
        return redirect ('admin/page');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
//        return $page;
        Page::where('id', $page->id)->update(['status'=> 2]);
        return redirect('admin/page');
    }

}
