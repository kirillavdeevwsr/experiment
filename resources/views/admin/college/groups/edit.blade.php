@extends('layouts.admin')
@section('title') Изменение отделения @endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('college.group.update', $item->id)}}" class="form" method="post">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="">Наименование</label>
                                <input type="text" class="form-control" name="name" value="{{$item->name}}">
                            </div>

                            <div class="form-group">
                                <label for="">Отделение</label>
                                <select name="department_id" class="form-control">
                                    @foreach($departments as $itm)
                                        <option value="{{$itm->id}}" @if($item->department_id == $itm->id) selected @endif>{{$itm->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Специальность</label>
                                <select name="specialty_id" class="form-control">
                                    @foreach($specialties as $itm)
                                        <option value="{{$itm->id}}" @if($item->specialty_id == $itm->id) selected @endif>{{$itm->name}}</option>
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