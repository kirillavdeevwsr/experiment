<?php

namespace App\Http\Controllers;

use App\Mail\StudentData;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



class CourseController extends Controller
{
    public function index(){
        $now=Carbon::now()->format('Y-m-d');
        $courses=Course::where('start', '>', $now)->paginate(5);
        return view('courses_all', compact('courses'));
    }

    public function show($slug){
        if(is_numeric($slug)){
            $course=Course::findOrFail($slug);
            return Redirect::to(route('show_course', $course->slug), 301);
        }
        $course= Course::whereSlug($slug)->firstOrFail();
        return view('course_detail', compact('course'));
    }

    public function sendEmail(Request $request){
        $mail='sales@ufaga.ru';
        Mail::to($mail)->send(new StudentData ($request->name, $request->phone, $request->course));
        return redirect()->back()->with('status','Ваша заявка успешно отправлена!');
    }
}
