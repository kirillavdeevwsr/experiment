@extends('layouts/admin')
@section('content')
    <div>
        <h1>{{$event->title}}</h1>


            <p >Начало:
            <span class="text-info">{{$event->start}}</span></p>

            <p>Длительность:
            <span class="text-info">{{$event->duration}}</span></p>
        <div>
            {!! $event->text !!}
        </div>
    </div>
    @endsection