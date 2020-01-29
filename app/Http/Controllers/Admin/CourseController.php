<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\CreateCoursesEvent;
use App\Events\UpdateCoursesEvent;
use App\Events\DeleteCoursesEvent;
use App\Service\FileStorage;

class CourseController extends Controller
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
        $courses= Course::orderBy('start')->get();
        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.courses.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(empty($request->file || $request->input('image'))){
            return redirect()->back()->with('message', 'Необходимо добавить изображение!');
        }
        $course=new Course();
        $course->fill($request->all());
        if ($request->file) {
            $image = $request->file('file');
            $img = $this->filesSave->imageSave($image, 'courses');
            if ($img === 0){
                return redirect()->back()->with('message', 'Неверный формат загружаемого изображения!');
            }else {
                $course->image = $img;
            }
        }else{
            $course->image = $request->image;
        }

        $course->save();
        event(new CreateCoursesEvent($course, $request->user()));
        return view ('admin.courses.show', compact('course'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('admin.courses.form', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        if ($request->file) {
            $image = $request->file('file');
            $img = $this->filesSave->imageSave($image, 'banners');
            if ($img === 0) {
                return redirect()->back()->with('message', 'Неверный формат загружаемого изображения!');
            } else {
                Course::where('id', $course->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'finish' => $request->finish,
                    'description' => $request->description,
                    'info' => $request->info,
                    'image' => $img
                ]);
            }
        }else{
            Course::where('id', $course->id)->update([
                'title' => $request->title,
                'start' => $request->start,
                'finish' => $request->finish,
                'description' => $request->description,
                'info' => $request->info,
                'image' => $request->image
            ]);
        }
        event(new UpdateCoursesEvent($course, $request->user()));
        return redirect('admin/courses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course, Request $request)
    {
        Course::destroy($course->id);
        event(new DeleteCoursesEvent($course->id, $request->user()));
        return redirect('/admin/courses');
    }
}
