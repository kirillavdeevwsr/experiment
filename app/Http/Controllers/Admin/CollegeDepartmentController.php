<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollegeDepartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollegeDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = CollegeDepartment::all();
        return view('admin.college.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.college.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'required']);
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors());
        CollegeDepartment::create($request->all());
        return redirect()->route('college.department.index')->with('success', 'Успешо сохранено!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollegeDepartment  $collegeDepartment
     * @return \Illuminate\Http\Response
     */
    public function show(CollegeDepartment $collegeDepartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CollegeDepartment  $collegeDepartment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = CollegeDepartment::find($id);
        return view('admin.college.departments.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollegeDepartment  $collegeDepartment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ['name' => 'required']);
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors());
        CollegeDepartment::find($id)->update($request->all());
        return redirect()->route('college.department.index')->with('success', 'Успешо обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollegeDepartment  $collegeDepartment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CollegeDepartment::find($id)->delete();
        return redirect()->back()->with('success', 'Успешно удалено!');
    }
}
