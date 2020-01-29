@extends('layouts.admin')
@section('title') Изменение отделения @endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('college.department.update', $item->id)}}" class="form" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="">Наименование</label>
                                <input type="text" class="form-control" name="name" value="{{$item->name}}">
                            </div>
                            <button class="btn btn-outline-success btn-block">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection