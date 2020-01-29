@extends('layouts.index')
@section('title')Новости колледжа @endsection
@section('content')
<section id="news-page">
    <div class="container">
        <div class="news-items">
            @foreach($news as $article)
            <div class="news-item">
                <div class="news-item-left">
                    <img src="{{$article->img}}" alt="new">
                </div>
                <div class="news-item-right">
                    <h2>{{$article->title}}</h2>
                    <p class="date">{{$article->raw_date}}</p>
                    <p class="news-item-text"> {!! $article->preview !!}</p>
                    <a href="{{route('show_news', $article->slug)}}" class="about-btn">Подробнее</a>
                </div>
            </div>
            @endforeach

        </div>
        <div class="pagination">
            {{$news->links()}}
        </div>
    </div>
</section>

    @endsection