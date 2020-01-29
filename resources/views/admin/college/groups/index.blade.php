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
                        <a href="{{route('college.group.create')}}" class="btn btn-success mb-2">Добавить</a>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Наименование</th>
                                <th scope="col">Специальность</th>
{{--                                <th scope="col">Куратор</th>--}}
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!$groups->isEmpty())
                                @foreach($groups as $key => $value)
                                    <tr>
                                        <td colspan="4" class="text-center font-weight-bold">
                                            {{$key}}
                                        </td>
                                    </tr>
                                    @foreach($value as $item)
                                        <tr>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{{$item->name}}</td>
                                            <td>{{$item->specialty->name}}</td>
                                            <td>
                                                <div class="d-flex border-0">
                                                    <a href="{{route('college.group.edit', $item->id)}}"
                                                       class="btn"><i
                                                                class="fas fa-edit text-warning"></i></a>
                                                    <form action="{{route('college.group.destroy', $item->id)}}"
                                                          method="post" class="form form-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn" type="submit"><i
                                                                    class="fas fa-trash text-danger"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">Нет данных</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection