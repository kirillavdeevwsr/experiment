@extends('layouts.admin')

@section('content')

    <div class="row justify-content-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('users.index')}}">Пользователи</a></li>
                <li class="breadcrumb-item active" aria-current="page">Редактирование пользователя</li>
            </ol>
        </nav>
    </div>

    <div class="row justify-content-center">
        <div class="card w-50">
            <div class="card-header">
                <h4 class="text-center font-weight-bold">Редактирование пользователя</h4>
            </div>
            <div class="card-body">
                <form action="{{route('users.update', $user->id)}}" class="form" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Фамилия</label>
                        <input type="text" class="form-control" name="surname" value="{{$user->surname}}">
                    </div>

                    <div class="form-group">
                        <label>Имя</label>
                        <input type="text" class="form-control" name="peopleName" value="{{$user->name}}">
                    </div>

                    <div class="form-group">
                        <label>Отчество</label>
                        <input type="text" class="form-control" name="patronymic" value="{{$user->patronymic}}">
                    </div>

                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control" name="email" value="{{$user->email}}">
                    </div>

                    <div class="form-group">
                        <label>Логин</label>
                        <input type="text" class="form-control" name="login" value="{{$user->login}}">
                    </div>

                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" class="form-control" name="password">
                        <small class="form-text text-danger">Если не хотите изменять пароль, оставьте это поле
                            пустым</small>
                    </div>

                    <div class="form-group">
                        <label>Роль</label>
                        <select name="role[]" class="form-control" multiple="multiple">
                            @foreach($roles as $role)
                                <option value="{{$role->id}}"
                                        @if($user->roles->contains($role)) selected @endif>{{$role->name}}</option>
                            @endforeach
                        </select>
                        <small class="small">Для выборка нескольких ролей удерживайте клавишу CTRL и выбирайте</small>
                    </div>
                    <button class="btn btn-outline-success btn-block">Сохранить</button>
                </form>
            </div>
        </div>
    </div>

@endsection