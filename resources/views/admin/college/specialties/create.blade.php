@extends('layouts.admin')
@section('title') Создание специальности @endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('college.specialty.store')}}" class="form" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Наименование</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <button class="btn btn-outline-success btn-block">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection