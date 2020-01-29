<?php

namespace App\Http\Controllers\Admin\Assessment;

use App\Models\Assessment\AssessmentCriterionPoints;
use App\Models\Assessment\AssessmentList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AssessmentCriterionPointsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AssessmentCriterionPoints::all()->sortBy('assessment_id');
        return view('admin.assessment.points.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $criterions = AssessmentList::all();
        return view('admin.assessment.points.create', compact('criterions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'required', 'point' => 'required|numeric', 'assessment_id' => 'required']);
        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors());
        AssessmentCriterionPoints::create($request->only('name', 'point', 'assessment_id'));
        return redirect()->back()->with('success', 'Успешно добавлено!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = AssessmentCriterionPoints::find($id);
        $criterions = AssessmentList::all();
        return view('admin.assessment.points.edit', ['item' => $item, 'criterions' => $criterions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ['name' => 'required', 'point' => 'required|numeric', 'assessment_id' => 'required']);
        if ($validator->fails()) return redirect()->back()->withErrors($validator->errors())->withInput(Input::all());
        AssessmentCriterionPoints::find($id)->update($request->only('name', 'point', 'assessment_id'));
        return redirect()->route('assessment.evalution.index')->with('success', 'Успешно обновалено!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AssessmentCriterionPoints::find($id)->delete();
        return redirect()->back()->with('success', 'Удалено!');
    }
}
