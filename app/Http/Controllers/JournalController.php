<?php

namespace App\Http\Controllers;


use App\Exports\UsersExport;
use App\Models\College\Journal\Concept;
use App\Models\College\Journal\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_IOFactory;

class JournalController extends Controller
{
    public function wadadwa()
    {
        
}
    public function send()
    {
        return view('send');
    }

    public function callName()
    {
        return Concept::all();
    }

    public function save(Request $request)
    {
        $link = new Event();
        $link->concept_id = $request->concept_id;
        $link->participants = $request->participants;
        $link->responsible = $request->responsible;
        $link->place = $request->place;
        $link->date = $request->date;
        $link->description = $request->description;
        $link->title = $request->title;
        $link->save();
        return 'true';
    }

    public function bringOut()
    {
        return view('bring_out');
    }

    public function bringOutSend()
    {

        $data = Event::with('concept')->get();
        return $data;
    }

    public function export()
    {
        $file=new UsersExport;
        $path=Excel::download($file,'test.xlsx');
        return $path;
    }
}
