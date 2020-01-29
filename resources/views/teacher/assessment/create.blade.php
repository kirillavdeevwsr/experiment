@extends('layouts.index')
@section('title') добавление критерия@endsection

@section('content')
    <section id="assessmentCreate">
        <assessment-create :csrf="{{ json_encode(csrf_token()) }}" :url="{{json_encode(route('teacher.assessment.store'))}}"></assessment-create>
    </section>

@endsection