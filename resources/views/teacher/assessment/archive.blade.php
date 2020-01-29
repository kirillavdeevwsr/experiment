@extends('layouts.index')

@section('title') Архив критериев @endsection

@section('content')

<assessment-archive :url="{{json_encode(route('teacher.assessment.archive.data'))}}"></assessment-archive>

@endsection