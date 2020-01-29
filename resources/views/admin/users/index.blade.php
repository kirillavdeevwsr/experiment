@extends('layouts.admin')

@section('content')

    <div class="row justify-content-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('admin')}}">Главная страница</a></li>
                <li class="breadcrumb-item active" aria-current="page">Пользователи</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-header text-center"><h4><b>Пользователи</b></h4></div>
                <div class="card-body">
                    <a href="{{route('users.create')}}" class="btn btn-outline-success mb-3">Добавить нового
                        пользователя</a>
                    <form action="{{route('users.index')}}" method="GET">
                        <div class="input-group mb-3 mt-3">
                            <input type="text" class="form-control" placeholder="Поиск по ФИО" name="q">
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" type="submit">Искать</button>
                            </div>
                        </div>
                    </form>

                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col" class="text-center font-weight-bold">#</th>
                            <th scope="col" class="font-weight-bold">ФИО</th>
                            <th scope="col" class="font-weight-bold">E-mail</th>
                            <th scope="col" class="font-weight-bold">Логин</th>
                            <th scope="col" class="font-weight-bold">Создан</th>
                            <th scope="col" class="font-weight-bold">Обновлен</th>
                            <th scope="col" class="font-weight-bold">Группы доступа</th>
                            <th scope="col" class="font-weight-bold">Действие</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $item)
                            <tr>
                                <th scope="row"
                                    class="text-center">{{$loop->iteration + $users->perPage() * ($users->currentPage()- 1)}}</th>
                                <td>{{$item->surname}} {{$item->name}} {{$item->patronymic}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->login}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->updated_at}}</td>
                                <td>
                                    @if($item->roles)
                                        @foreach($item->roles as $role)
                                            <span class="badge badge-success">{{$role->name}}</span> <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-row">
                                        <a href="{{route('users.edit', $item->id)}}" class="btn btn-default mr-3"><i
                                                    class="far fa-edit text-warning"></i></a>
                                        <form class="d-inline" method="post"
                                              action="{{route('users.destroy', $item->id)}}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn" onclick="return confirm('Удалить пользователя?')"><i
                                                        class="fas fa-trash text-danger"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            {{$users->links()}}
        </div>
    </div>

@endsection