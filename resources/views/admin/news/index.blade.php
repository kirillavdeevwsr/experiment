@extends('layouts.admin')
@section ('content')
    <div class="">
        <h1>Управление новостями</h1>
        <br>
        <a href="{{route('news.create')}}">
            <button class="btn btn-success">Создать </button>
        </a>
        <br>
        <br>
        <table class="table ">
            <td><b>Заголовок</b></td>
            <td><b>Дата добавления</b></td>
            <td><b>Автор</b></td>
            <td>Действия</td>
            @foreach ($news as $article)
                <tr>
                    <th><a href="{{route('news.show', $article->id)}}">{{$article->title}}</a></th>
                    <th>{{$article->raw_date}}</th>
                    <th>{{$article->user->full_name}}</th>
                    <th><a href="{{route ('news.edit', $article->id)}}">
                            <button class="btn btn-info">Редактировать</button>
                        </a>
                        <br>
                        <form action="{{route ('news.destroy', $article->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                            <input  type="submit" class="btn btn-danger" value=" Удалить">
                        </form>
                        </th>
                </tr>
                @endforeach
        </table>
    </div>
@endsection