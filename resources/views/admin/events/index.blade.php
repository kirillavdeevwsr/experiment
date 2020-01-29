@extends('layouts/admin')
@section('content')
    <div class="container">
        <h1>Управление событиями</h1>
        <div>
            <a href="{{route('events.create')}}">
                <button class="btn btn-success">Добавить событие</button>
            </a>
        </div>
        <br>
        <br>
        <table class="table">
                <thead>
                <td><b>Дата добавления</b></td>
                <th><b>Название</b></th>
                <th><b>Описание</b></th>
                <th><b>Действия</b></th>
                <th><b>Аудитория</b></th>

                </thead>
            <tbody>
            @foreach($events as $event)
            <tr>
                <th>{{$event->start}}</th>

                <th><a href="{{route('events.show', $event->id)}}">{{$event->title}}</a></th>

                <th>{{$event->preview}}</th>

                <th>
                    <a href="{{route('events.edit', $event->id)}}">
                        <button class="btn btn-info">Редактировать</button>
                    </a>
                    <br>
                    <form action="{{route ('events.destroy', $event->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input  type="submit" class="btn btn-danger" value=" Удалить">
                    </form>
                </th>
                <th>{{$event->lecture}}</th>
            </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endsection