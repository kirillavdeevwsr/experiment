<?php

namespace App\Http\Controllers\Admin\Assessment;

use App\Models\Assessment\AssessmentPeriodicity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AssessmentPeriodicityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AssessmentPeriodicity::all();
        return view('admin.assessment.periodicity.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.assessment.periodicity.create');
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
        AssessmentPeriodicity::create($request->all());
        return redirect()->back()->with('success', 'Успешно добавлено!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = AssessmentPeriodicity::find($id);
        return view('admin.assessment.periodicity.edit', ['item' => $item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ['name' => 'required']);
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors())->withInput(Input::all());
        AssessmentPeriodicity::find($id)->update($request->all());
        return redirect()->route('assessment.summary-periodicity.index')->with('success', 'Успешно обновалено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AssessmentPeriodicity::find($id)->delete();
        return redirect()->back()->with('success', 'Удалено!');
    }
}
