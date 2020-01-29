<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;


class UsersExport implements FromCollection
{
    public function collection()
    {
        $dataEvent=DB::table('event')->get()->toArray();
        $dataName=DB::table('concept')->get()->toArray();
        $data[0]=[
            'name',
            'participants',
            'responsible',
            'place',
            'date',
            'title',
        ];

        for ($i=0;$i<count($dataEvent);$i++){
            for($r=0;$r<count($dataName);$r++){
                if($dataName[$r]->concept_id==$dataEvent[$i]->concept_id){
                    $name=$dataName[$r]->name;
                }
            }
            $data[$i+1]=[
                $name,
                $dataEvent[$i]->participants,
                $dataEvent[$i]->responsible,
                $dataEvent[$i]->place,
                $dataEvent[$i]->date,
                $dataEvent[$i]->title,
            ];
        }

        return new Collection([
            $data
        ]);
    }
}
