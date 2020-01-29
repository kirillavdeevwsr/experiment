@extends('layouts.index')
@section('title'){{$event->title}}@endsection
@section('content')

    <section id="new-page">
        <div class="container">
            <div class="new-page-content">
                <h2>{{$event->title}}</h2>
                <div>
                    <p>Начало события: <b>{{$event->raw_date->diffForHumans()}}</b></p>
                    <br>
                    <p>Продолжительность события: <b>{{$event->duration}}</b></p>
                </div>
                <div class="new-page-text">
                    {!! $event->text !!}
                </div>
            </div>
        </div>
    </section>
@endsection

