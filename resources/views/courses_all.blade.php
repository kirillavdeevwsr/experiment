@extends('layouts.index')
@section('title')Курсы колледжа @endsection
@section('content')
    <section id="news-page">
        <div class="container">
            <div class="news-items">
                @foreach($courses as $course)
                    <div class="news-item">
                        <div class="news-item-left">
                            <img src="{{$course->image}}" alt="course">
                        </div>
                        <div class="news-item-right">
                            <h2>{{$course->title}}</h2>
                            <p class="date">Старт: <b> {{$course->raw_date->format('j F')}}</b></p>
                            <p class="date">Курс будет длиться: <b>{{$course->duration}}</b></p>
                            <p class="news-item-text"> {{$course->description}}</p>
                            <a href="{{route('show_course', $course->id)}}" class="about-btn">Подробнее</a>
                        </div>
                    </div>
                @endforeach

            </div>
            @if(isset($course->links))
            <div class="pagination">
                {{$course->links()}}
            </div>
                @endif
        </div>
    </section>

@endsection