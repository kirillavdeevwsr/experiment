@extends('layouts.admin')
@section ('content')
    <div class="">
        <h1>{{$news->title}}</h1>
        <div class="row">
            <div class="col-lg-6">
                <div class="row" style="margin-left: 20px">
                <a href="{{route ('news.edit', $news->id)}}" style="margin-right:  50px ">
                    <button class="btn btn-info">Редактировать</button>
                </a>

                <form action="{{route ('news.destroy', $news->id)}}" method="post">
                    {{csrf_field()}}
                    {{method_field('DELETE')}}
                    <input type="submit" class="btn btn-danger" value=" Удалить">
                </form>
                </div>

            </div>

            <div class="text-right col-lg-6">
                <span>{{$news->raw_date}}</span>
                <br>
                <span>Автор:</span>
                <em class="text-success">{{$news->user->full_name}}</em>
            </div>
        </div>
        <br>
        <br>
        <div class="news-text ">
            <a style = 'display: block; text-align: center;'href="{{$news->img}}">

                <img src="{{$news->img}}" alt="{{$news->img}}"></a>
            {{ $news->preview }}


            @if ($news->text!=null)
                <hr>
                {!! $news->text !!}
            @endif
            @foreach($news->files as $file)
                @if ($file->type =='image')
                    <a href="{{$file->link}}"><img src="{{$file->link}}" alt="{{$file->alt}}"></a>
                @elseif ($file->type =='video')
                    <div style="width: 100%">
                        {!! $file->link !!}
                    </div>

                @else
                    <a href="{{$file->link}}">{{$file->alt}}</a>
                @endif
                @endforeach

        </div>

    </div>

@endsection