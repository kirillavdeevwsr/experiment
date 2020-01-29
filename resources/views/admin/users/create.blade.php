@extends('layouts.admin')

@section('content')

    <div class="row justify-content-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('users.index')}}">Пользователи</a></li>
                <li class="breadcrumb-item active" aria-current="page">Создание пользователя</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="card w-50">
            <div class="card-header">
                <h4 class="text-center font-weight-bold">Добавление нового пользователя</h4>
            </div>
            <div class="card-body">
                <form action="{{route('users.store')}}" class="form" method="post">
                    @csrf

                    <div class="form-group">
                        <label>Фамилия</label>
                        <input type="text" class="form-control" name="surname">
                    </div>

                    <div class="form-group">
                        <label>Имя</label>
                        <input type="text" class="form-control" name="peopleName">
                    </div>

                    <div class="form-group">
                        <label>Отчество</label>
                        <input type="text" class="form-control" name="patronymic">
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="form-group">
                        <label>Логин</label>
                        <input type="text" class="form-control" name="login">
                    </div>

                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" class="form-control" name="password">
                    </div>

                    <div class="form-group">
                        <label>Роль</label>
                        <select name="role[]" class="form-control" multiple="multiple">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}"
                                        @if($role->short_name == 'user') selected @endif>{{$role->name}}</option>
                            @endforeach
                        </select>
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <label>Куратор группы</label>--}}
{{--                        <select name="group_id" class="form-control" multiple size="20">--}}
{{--                            @foreach($groups as $group)--}}
{{--                                <option value="{{$group->id}}">{{$group->name}}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}

                    <button class="btn btn-outline-success btn-block">Сохранить</button>
                </form>
            </div>
        </div>
    </div>

@endsection