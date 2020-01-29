@extends('layouts.admin')
@section('title') Отделения @endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        Отделения
                    </div>
                    <div class="card-body">
                        <a href="{{route('college.department.create')}}" class="btn btn-success mb-2">Добавить</a>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Наименование</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!$departments->isEmpty())
                                @foreach($departments as $item)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            <div class="d-flex border-0">
                                                <a href="{{route('college.department.edit', $item->id)}}" class="btn"><i class="fas fa-edit text-warning"></i></a>
                                                <form action="{{route('college.department.destroy', $item->id)}}" method="post" class="form form-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn" type="submit"><i class="fas fa-trash text-danger"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">Нет данных</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection