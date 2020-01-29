@extends('layouts.index')
@section('title'){{$page->title}}@endsection
@section("content")
    <section id="inside-page">
        <div class="container">
            <div class="inside-content">
                <h2>{{$page->title}}</h2>
                <div class="inside-content-text">
                    {!! $page->text !!}
                </div>
            </div>
        </div>
    </section>


    @endsection