<?php

namespace App\Http\Controllers;

class TeacherController extends Controller
{
    public function index() {
        $user = auth()->user();
        return view('teacher.index', ['user' => $user]);
    }
}
