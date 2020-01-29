@extends('layouts/admin')
@section('content')
    <div >
        <h1>{{$course->title}}</h1>


            <p >Начало:
            <span class="text-info">{{$course->start}}</span></p>

            <p>Длительность:
            <span class="text-info">{{$course->duration}}</span></p></div>
        <img src="{{$course->image}}" alt="">
        <div>
            {!! $course->info !!}
        </div>
    </div>
    @endsection