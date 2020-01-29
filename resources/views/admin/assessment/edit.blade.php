@extends('layouts.admin')
@section('title') Лист самооценки @endsection
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('admin')}}">Главная</a></li>
            <li class="breadcrumb-item"><a href="{{route('assessment.index')}}">Критерии листа самооценки</a></li>
            <li class="breadcrumb-item active" aria-current="page">Изменение критерия</li>
        </ol>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="card w-100">
                <div class="card-body">
                    <form action="{{route('assessment.update', $list->id)}}" class="form" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="">Показатель</label>
                            <textarea name="criterion" cols="30" rows="5" class="form-control">{{$list->criterion}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Единица показателя, уровни мероприятия</label>
                            <textarea name="unit_of_measure" cols="30" rows="5" class="form-control">{{$list->unit_of_measure}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Источник данных</label>
                            <textarea name="data_source" cols="30" rows="5" class="form-control">{{$list->data_source}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Периодичность подведения итогов</label>
                            <select name="summary_periodicity" class="form-control">
                                @foreach($periodicity as $item)
                                    <option value="{{$item->id}}" @if($item->id == $list->summary_periodicity) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Периодичность выплат</label>
                            <select name="frequency_of_payment" class="form-control">
                                @foreach($payment as $item)
                                    <option value="{{$item->id}}" @if($item->id == $list->frequency_of_payment) selected @endif>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="multi_add" id="multiAdd" @if($list->multi_add) checked @endif>
                            <label class="form-check-label" for="multiAdd">
                                Множественное создание критерия в течении отчетного периода
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" name="multiple_select" id="multipleSelect" @if($list->multiple_select) checked @endif>
                            <label class="form-check-label" for="multipleSelect">
                                Множественный выбор критериев оценки
                            </label>
                        </div>

                        <div class="form-group">
                            <label for="">Ответственный за критерий</label>
                            <select name="responsible_id" class="form-control">
                                @foreach($users->sortBy('full_name') as $user)
                                    <option value="{{$user->id}}" @if($user->id == $list->responsible_id) selected @endif>{{$user->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-success btn-block">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection