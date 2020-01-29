@extends('layouts.admin')

@section('content')

    <div class="row justify-content-center">
        <div class="card w-50">
            <div class="card-header">
                <h4>Панель управления</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">

                    <div class="col-3">ФИО</div>
                    <div class="col-9">{{$user->surname}} {{$user->name}} {{$user->patronymic}}</div>
                    <div class="col-3">E-mail</div>
                    <div class="col-9">{{$user->email}}</div>
                    <div class="col-3">Роли</div>
                    <div class="col-9">
                        @foreach($user->roles as $role)
                            <span class="badge badge-info">{{$role->name}}</span>
                        @endforeach
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="collapse w-100 ml-3 mr-3 mt-3" id="changePassword">
                        <div class="card w-100 border-danger">
                            <div class="card-header bg-white">Изменение пароля</div>
                            <div class="card-body">
                                <form action="{{route('users.change_password', $user->id)}}" class="form" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Пароль</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Повторите пароль</label>
                                        <input type="password" name="password_confirmation" class="form-control">
                                    </div>
                                    <button class="btn btn-danger">Изменить пароль</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @can('is-admin', $user)
                <div class="row">
                    <div class="card border-info ml-3 mr-3 w-100 pt-3 pb-3">
                        <div class="row pl-3 pr-3">
                            <div class="col-6">
                                <a href="{{route('users.index')}}" class="btn btn-outline-info btn-block">Список пользователей <span class="ml-3 badge badge-warning"> {{$usersCount}}</span></a>
                                <a href="{{route('users.create')}}" class="btn btn-outline-success btn-block">Добавить пользователя</a>
                                <a href="{{route('sync.teachers')}}" class="btn btn-outline-info btn-block">Синхронизировать пользователей</a>
                                <a href="{{route('sync.groups')}}" class="btn btn-outline-info btn-block">Синхронизировать группы (отделения и специальности)</a>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-outline-info btn-block" type="button" data-toggle="collapse" data-target="#changePassword" aria-expanded="false" aria-controls="changePassword">Изменение пароля</button>
                                <a href="{{route ('semester')}}" class="btn btn-outline-info btn-block disabled" disabled="true">Обновить расписание на полугодие</a>
                                <a href="{{route('assessment.index')}}" class="btn btn-outline-info btn-block">Лист самооценки</a>
                                <a href="{{route('college.department.index')}}" class="btn btn-outline-info btn-block">Отделения</a>
                                <a href="{{route('college.specialty.index')}}" class="btn btn-outline-info btn-block">Специальности</a>
                                <a href="{{route('college.group.index')}}" class="btn btn-outline-info btn-block">Группы</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endcan
            </div>
        </div>
    </div>

@endsection