@extends('layouts.admin')
@section ('content')
    <div>
        <h1>Название страницы сайта: {{$page->title}}</h1>
        <div>
            {!! $page->text !!}
        </div>
    </div>

@endsection