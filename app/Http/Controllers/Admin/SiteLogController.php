<?php

namespace App\Http\Controllers\Admin;

use App\Models\History;
use App\Http\Controllers\Controller;

class SiteLogController extends Controller
{
    public function index(){
        $logs=History::orderBy('datetime', 'desc')->paginate(50);
        return view('admin.logs.index', compact('logs'));
    }
}
