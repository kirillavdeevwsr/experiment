@extends('layouts.index')
@section('title'){{$article->title}}@endsection
@section('content')
    <section id="new-page">
        <div class="container">
            <div class="new-page-content">
                <h2>{{$article->title}}</h2>
                <div>
                    <p>{{$article->raw_date}}</p>
                </div>
                <div class="new-page-img">
                    <img src="{{$article->img}}" alt="image">
                </div>
                <div class="new-page-text">
                    <b>{{ $article->preview }}</b>
                    <br>
                    <p>{!! $article->text !!}</p>


                </div>
                <div class="youtube">
                @foreach($video as $clip)
                    {!!$clip->link !!}
                        @endforeach
                </div>
                <div class="slider-gallery">

                        @foreach($images as $img)
                        <div class="slider-gallery-item">
                        <img src="{{$img->link}}" alt="{{$img->alt}}">
                        </div>
                            @endforeach
                </div>
                @if (($docs->first()))
                <div class="doc">
                    <h3>Документы:</h3>
                    @foreach($docs as $doc)
                    <a href="{{$doc->link}}">{{$doc->link}}</a>
                        @endforeach
                </div>
                @endif
            </div>
        </div>
    </section>

    @endsection
