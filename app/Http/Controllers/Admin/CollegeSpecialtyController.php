<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollegeSpecialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollegeSpecialtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $specialties = CollegeSpecialty::all();
        return view('admin.college.specialties.index', compact('specialties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.college.specialties.create');
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
        CollegeSpecialty::create($request->all());
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors());
        return redirect()->route('college.specialty.index')->with('success', 'Успешно сохранено!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollegeSpecialty  $collegeSpecialty
     * @return \Illuminate\Http\Response
     */
    public function show(CollegeSpecialty $collegeSpecialty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CollegeSpecialty  $collegeSpecialty
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = CollegeSpecialty::find($id);
        return view('admin.college.specialties.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollegeSpecialty  $collegeSpecialty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ['name' => 'required']);
        CollegeSpecialty::find($id)->update($request->all());
        return redirect()->route('college.specialty.index')->with('success', 'Успешно обновлено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollegeSpecialty  $collegeSpecialty
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CollegeSpecialty::find($id)->delete();
        return redirect()->back()->with('success', 'Успешно удалено!');
    }
}
