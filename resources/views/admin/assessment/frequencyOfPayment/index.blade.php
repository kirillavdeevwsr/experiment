@extends('layouts.admin')

@section('title') периодичность подведения итогов @endsection

@section ('content')

    <div class="container">

        <div class="row justify-content-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('assessment.index')}}">Лист самооценки</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Периодичность выплат</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="card w-100">
                <div class="card-body">
                    <a href="{{route('assessment.frequency-of-payment.create')}}" class="btn btn-outline-success mb-3">Добавить</a>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Наименование</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!$data->isEmpty())
                                @foreach($data as $item)
                                    <tr>
                                        <th scope="row">{{$loop->iteration}}</th>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            <div class="d-flex border-0 flex-row">
                                                <a href="{{route('assessment.frequency-of-payment.edit', $item->id)}}" class="btn btn-default"><i class="fas fa-edit text-warning"></i></a>
                                                <form action="{{route('assessment.frequency-of-payment.destroy', $item->id)}}" class="form-inline" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-default"> <i class="fas fa-trash text-danger"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="text-center">
                                        <b>Ничего нет!</b>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection