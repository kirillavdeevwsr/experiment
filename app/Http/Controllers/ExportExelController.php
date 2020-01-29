<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportExelController extends Controller
{
    public function export()
    {
        return Excel::download(new UsersExport,'users.xlsx');
    }
}
