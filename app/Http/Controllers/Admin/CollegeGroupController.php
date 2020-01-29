<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollegeDepartment;
use App\Models\CollegeGroup;
use App\Models\CollegeSpecialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollegeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = CollegeGroup::with(['specialty', 'department'])->get()->groupBy('department.name');
//        dd($groups);
        return view('admin.college.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialties = CollegeSpecialty::all();
        $departments = CollegeDepartment::all();
        return view('admin.college.groups.create', compact('specialties', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'department_id' => 'required',
            'specialty_id' => 'required'
        ]);
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors());
        CollegeGroup::create($request->all());
        return redirect()->route('college.group.index')->with('sucess', 'Успешно сохранено!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollegeGroup  $collegeGroup
     * @return \Illuminate\Http\Response
     */
    public function show(CollegeGroup $collegeGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CollegeGroup  $collegeGroup
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $specialties = CollegeSpecialty::all();
        $departments = CollegeDepartment::all();
        $item = CollegeGroup::find($id);
        return view('admin.college.groups.edit', compact('specialties', 'departments', 'item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollegeGroup  $collegeGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'department_id' => 'required',
            'specialty_id' => 'required'
        ]);
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors());
        CollegeGroup::find($id)->update($request->all());
        return redirect()->route('college.group.index')->with('sucess', 'Успешно обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollegeGroup  $collegeGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $group = CollegeGroup::find($id);
        $group->delete();
        return redirect()->back()->with('success', 'Успешно удалено!');
    }
}
