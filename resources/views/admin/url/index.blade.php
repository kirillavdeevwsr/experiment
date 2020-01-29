@extends('layouts/admin')
@section('content')
    <div class="container">
        <h1>Управление ссылками</h1>
        <div>
            <a href="{{route('url.create')}}">
                <button class="btn btn-success">Добавить ссылку</button>
            </a>
        </div>
        <br>
        <br>
        <table class="table">
                <thead>
                <th><b>Название</b></th>
                <th><b>Ссылка</b></th>
                </thead>
            <tbody>
            @foreach($url as $item)
            <tr>
                <th><a href="{{route('url.show', $item->id)}}">{{$item->title}}</a></th>
                <th>
                    <a href="{{route('url.edit', $item->id)}}">
                        <button class="btn btn-info">Редактировать</button>
                    </a>
                    <br>
                    <form action="{{route ('url.destroy', $item->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input  type="submit" class="btn btn-danger" value=" Удалить">
                    </form>
                </th>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection