<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Events;
use Carbon\Carbon;
use App\Models\Page;
use App\Models\News;
use App\Models\Banner;
use App\Models\Slider;
use App\Models\UserCounter;
use Illuminate\Support\Facades\Redirect;


class MainController extends Controller
{

    public function showMain()
    {
        $news=News::orderBy('datetime', 'desc')->take(5)->get();
        $bannersMiddle= Banner::where('sort', 0)->get();
        $bannersFooter= Banner::where('sort', 1)->get();
        $slider=Slider::where('status', 1)->get();
        $courses=Course::where('start','>', Carbon::now())->get();
        $events=Events::orderBy('created_at', 'desc')->get();   

        // users count
        $clientIP = \Request::ip() ;
        $newuser = UserCounter::where('ip', $clientIP)->where('timestamp', ">" ,strtotime(date('d.m.Y 00:00:00')))->get();

        if($newuser->count() < 1){
         $timestamp = time();
             $model = new UserCounter();
             $model->ip = $clientIP;
             $model->timestamp = $timestamp;
             $model->save();
            }
        
        return view('main', compact(['news', 'bannersMiddle', 'bannersFooter', 'slider', 'courses','events']));
    }

    public function view($slug){
        if (is_numeric($slug)) {
            $page = Page::findOrFail($slug);
            return Redirect::to(route('show_page', $page->slug), 301);
        }
        $page = Page::whereSlug($slug)->firstOrFail();
        return view ('page_view', compact('page'));
    }
}



