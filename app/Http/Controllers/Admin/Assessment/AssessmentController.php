<?php

namespace App\Http\Controllers\Admin;

use App\Models\Assessment\AssessmentFrequencyOfPayment;
use App\Models\Assessment\AssessmentPeriodicity;
use App\Models\Assessment\AssessmentList;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = AssessmentList::with(['periodicity', 'frequencyPayment'])->get();
        return view('admin.assessment.index', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $periodicity = AssessmentPeriodicity::all();
        $payment = AssessmentFrequencyOfPayment::all();
        return view('admin.assessment.create', compact(['users', 'periodicity', 'payment']));
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
            'criterion' => 'required',
            'unit_of_measure' => 'required',
            'data_source' => 'required',
            'responsible_id' => 'required',
        ]);
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors())->withInput(Input::all());
        $item = AssessmentList::create($request->all());
        $item->update([
            'multi_add' => !!$request->multi_add,
            'multiple_select' => !!$request->multiple_select
        ]);
        return redirect()->back()->with('success', 'Критерий успешно добавлен!');

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
        $users = User::all();
        $list = AssessmentList::find($id);
        $periodicity = AssessmentPeriodicity::all();
        $payment = AssessmentFrequencyOfPayment::all();
        return view('admin.assessment.edit', compact('list', 'users', 'periodicity', 'payment'));
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
        $validator = Validator::make($request->all(), [
            'criterion' => 'required',
            'unit_of_measure' => 'required',
            'data_source' => 'required',
            'responsible_id' => 'required',
            'summary_periodicity' => 'required',
            'frequency_of_payment' => 'required'
        ]);
        if($validator->fails()) return redirect()->back()->withErrors($validator->errors())->withInput($request->input());
        $item = AssessmentList::find($id);
        $item->update($request->all());
        $item->update([
            'multi_add' => !!$request->multi_add,
            'multiple_select' => !!$request->multiple_select
            ]);
        return redirect()->route('assessment.index')->with('success', 'Успешно обнавлено!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AssessmentList::destroy($id);
        return redirect()->back()->with('success', 'Удалено!');
    }
}
