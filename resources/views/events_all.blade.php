@extends('layouts.index')
@section('title')События колледжа @endsection
@section('content')
    <section id="news-page">
        <div class="container">
            <div class="news-items">
                @foreach($events as $event)
                    <div class="news-item">

                        <div class="news-item-right">
                            <h2>{{$event->title}}</h2>
                            <p class="date">Старт: <b> {{$event->raw_date->format('j F')}}</b></p>
                            <p class="date">Событие будет длиться: <b>{{$event->duration}}</b></p>
                            <p class="news-item-text"> {{$event->preview}}</p>
                            <a href="{{route('show_event', $event->id)}}" class="about-btn">Подробнее</a>
                        </div>
                    </div>
                @endforeach

            </div>
            @if(isset($event->links))
            <div class="pagination">
                {{$event->links()}}
            </div>
                @endif
        </div>
    </section>

@endsection