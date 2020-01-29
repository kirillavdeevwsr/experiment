@extends('layouts.index')
@section('title')Главная @endsection
@section('content')
    <section id="main-block">
        <div class="slider-items">
            @foreach($slider as $img)
            <div class="slider-item">
                <img src="{{$img->link}}" alt="{{$img->id}}" style="width:100%">
            </div>
            @endforeach
        </div>
    </section>
    <section id="news">
        <div class="container">
            <a  class="news-link" href="{{route('index_news')}}">
            <h2>Последние новости</h2></a>
            <div class="news-slider">
                @foreach($news as $article)
                    <div class="news-slider-items">
                        <div class="news-slider-img" style="background-image: url('{{$article->img}}');">
                        </div>
                        <div class="news-description">
                            <b class="new-name">{{$article->title}}</b>
                            <div class="date-wrapper">
                                <img src="/img/edit.png" alt="edit">
                                <p class="date">{{$article->raw_date}}</p>
                            </div>
                            <div class="new-text">
                                <div>{{$article->preview }}</div>
                            </div>
                            <div class="more">
                                <a href="{{route("show_news", $article->slug)}}" class="about-btn">Подробнее</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section id="partners-top">
        <div class="container">
            <div class="partners-slider">
                @foreach($bannersMiddle as $banner)
                <div class="partner-slider-items">
                    <a href="{{$banner->url}}"><img src="{{$banner->img}}" alt="{{$banner->alt}}"></a>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    <section id="events">
        <div class="container">
            <a href="{{route('index_events')}} " class="news-link"><h2>Предстоящие события</h2></a>
            <div class="events-slider">
                @foreach($events as $event)
                <div class="events-slider-item">
                    <div class="events-slider-day">
                        <div class="events-slider-day-number"><p class="date"> {{$event->start}}</p></div>
                    </div>
                    <div class="events-slider-about">
                        <p class="event-name">{{$event->title}}</p>
                        <div class="events-slider-info">
                            <div class="events-slider-about-time">
                                <div>
                                    <img src="img/clock.png" alt="Время"> {{$event->start}} -  {{$event->finish}}
                                </div>
                                <div>
                                    <img src="img/placeholder.png" alt="Аудитория"> {{$event->lecture}}
                                </div>
                            </div>

                            <div class="events-slider-about-text"> <div>{{$event->preview}}</div>
                            </div>
                            <div class="more">
                                <a href="{{route("show_event", $event->slug)}}" class="about-btn">Подробнее</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
        @if ($courses->first())
            @if((count($courses))<=3)
            <section id="courses-without-scroll">
                <div class="container">
                    <a href="{{route('index_courses')}} " class="news-link"><h2>Курсы</h2></a>
                    <div class="cources">
                        @foreach($courses as $course)
                            <div class="cources-item">
                                <div class="cources-day">
                                    <div class="cources-day-number">{{$course->raw_date->format('j')}}
                                        <p>{{$course->month}}</p>
                                    </div>
                                </div>
                                <div class="cources-img" style="background-image: url('{{$course->image}}');">

                                </div>

                                <div class="cources-item-about">
                                    <div style="background-image: url('{{$course->image}}')"></div>
                                    <p class="cources-item-about-name">
                                        {{$course->title}}
                                    </p>
                                    {!!  $course->description !!}
                                </div>
                                <a href="{{route('show_course', $course->slug)}}" class="about-btn">Подробнее</a>
                            </div>
                        @endforeach
                    </div>
                </div>

            </section>
            @else
                <section id="cources">
            <div class="container">
                <a href="{{route('index_courses')}} " class="news-link"><h2>Курсы</h2></a>
                <div class="cources-slider">
                    @foreach($courses as $course)
                    <div class="cources-slider-item">
                        <div class="cources-slider-day">
                            <div class="cources-slider-day-number">{{$course->raw_date->format('j')}}
                                <p>{{$course->month}}</p>
                            </div>
                        </div>
                        <div class="cources-img" style="background-image: url('{{$course->image}}');">

                        </div>

                        <div class="cources-slider-item-about">
                            <p class="cources-slider-item-about-name">
                                {{$course->title}}
                            </p>
                           {!!  $course->description !!}
                            <a href="{{route('show_course', $course->slug)}}" class="about-btn">Подробнее</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif
        @endif

    <section id="partners-bottom">
        <div class="container">
            <div class="partners-slider">
                @foreach($bannersFooter as $banner)
                <div class="partner-slider-items">
                    <a href="{{$banner->url}}"><img src="{{$banner->img}}" alt="{{$banner->alt}}"></a>
                </div>
                @endforeach

            </div>
        </div>
    </section>

@endsection
