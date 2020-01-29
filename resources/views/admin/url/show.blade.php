@extends('layouts/admin')
@section('content')
    <div>
        {{--<h1>{{$url->title}}</h1>--}}
        <div>
            {!! $url->title !!} - {!! $url->url !!}

        </div>
    </div>
    @endsection