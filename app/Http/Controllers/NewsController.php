<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\File;

class NewsController extends Controller
{
    public function index(){
        $news=News::orderBy('datetime', 'desc')->paginate(5);
        return view ('news_all', compact('news'));
    }

    public function show($slug){
        $article=News::whereSlug($slug)->firstOrFail();
        $images=File::where('news_id', $article->id)->where('type', 'image')->get();
        $video=File::where('news_id', $article->id)->where('type', 'video')->get();
        $docs=File::where('news_id', $article->id)->where('type', 'document')->get();
        return view('article', compact(['article','images', 'video', 'docs']));

    }
}
