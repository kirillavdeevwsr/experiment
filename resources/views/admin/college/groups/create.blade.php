@extends('layouts.admin')
@section('title') Создание отделения @endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('college.group.store')}}" class="form" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="">Наименование</label>
                                <input type="text" class="form-control" name="name">
                            </div>

                            <div class="form-group">
                                <label for="">Отделение</label>
                                <select name="department_id" class="form-control">
                                    @foreach($departments as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Специальность</label>
                                <select name="specialty_id" class="form-control">
                                    @foreach($specialties as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-outline-success btn-block">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection