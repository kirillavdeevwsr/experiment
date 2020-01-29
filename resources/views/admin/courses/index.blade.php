@extends('layouts/admin')
@section('content')
    <div class="container">
        <h1>Управление курсами</h1>
        <div>
            <a href="{{route('courses.create')}}">
                <button class="btn btn-success">Добавить новый</button>
            </a>
        </div>
        <br>
        <br>
        <table class="table">
                <thead>
                <th><b>Дата начала</b></th>
                <th><b>Название</b></th>
                <th><b>Описание</b></th>
                <th><b>Действия</b></th>
                </thead>
            <tbody>
            @foreach($courses as $course)
            <tr>
                <th>{{$course->start}}</th>
                <th><a href="{{route('courses.show', $course->id)}}">{{$course->title}}</a></th>
                <th>{{$course->description}}</th>
                <th>
                    <a href="{{route('courses.edit', $course->id)}}">
                        <button class="btn btn-info">Редактировать</button>
                    </a>
                    <br>
                    <form action="{{route ('courses.destroy', $course->id)}}" method="post">
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