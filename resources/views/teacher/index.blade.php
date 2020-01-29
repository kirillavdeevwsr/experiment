@extends('layouts.index')
@section('title') Личный кабинет @endsection
@section('content')

    <div class="container mt-3 mb-3">
        <div class="row justify-content-center">
            <div class="card ">
                <div class="card-header text-center">
                    <div class="row">
                        <div class="col-6 text-left">Профиль</div>
                        <div class="col-6 text-right">Сегодня {{\Jenssegers\Date\Date::now()->format('d F Y г.')}}</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <img src="{{asset('images/user.png')}}" alt="" class="profile-image">
                        </div>
                        <div class="col-4">
                            <table class="table no-border-table">
                                <tbody>
                                    <tr>
                                        <td>Фамилия</td>
                                        <td>{{$user->surname}}</td>
                                    </tr>
                                    <tr>
                                        <td>Имя</td>
                                        <td>{{$user->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Отчество</td>
                                        <td>{{$user->patronymic}}</td>
                                    </tr>
                                    <tr>
                                        <td>Группы доступа</td>
                                        <td>@foreach($user->roles as $role) <span>{{$role->name}}</span> @endforeach</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(\Illuminate\Support\Facades\Gate::check('is-admin', auth()->user()) || \Illuminate\Support\Facades\Gate::check('is-accountant', auth()->user()) || \Illuminate\Support\Facades\Gate::check('is-assessment-manager', auth()->user()))
                        <a href="{{route('teacher.assessment.report')}}" class="btn btn-outline-primary">Отчет по листу самооценки</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection