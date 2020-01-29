@extends('layouts.index')
@section('title') изменение статуса @endsection
@section('content')

    <div class="container mb-3 mt-3">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">{{$assessment->users->full_name}}</div>
                <div class="card-body">
                    <p><b>Критерий: </b> {!!$assessment->assessment->criterion!!}</p>
                    <p><b>Единица показателя,уровни мероприятия: </b>{!!$assessment->assessment->unit_of_measure!!}</p>
                    <p><b>Критерии оценки: </b>{!!$assessment->assessment->criterion_assessment!!}</p>
                    <p><b>Источник данных: </b>{!!$assessment->assessment->data_source!!}</p>
                    <p><b>Периодичность подведения итогов: </b>{!!$assessment->assessment->summary_periodicity!!}</p>
                    <p><b>Периодичность выплат: </b>{!!$assessment->assessment->frequency_of_payment!!}</p>
                    <p><b>Вложенные файлы: </b><a href="{{asset($assessment->attachment)}}">Вложенный файл</a></p>
                    <p><b>Баллов: </b>{!!$assessment->point!!}</p>
                    <form action="{{route('teacher.assessment.change-status',[$assessment->id, $status])}}" method="POST" class="mt-3">
                        @csrf
                        <label for="">Вы собираетесь @if($status === 'warning') <b>отправить на доработку</b>@elseif($status === 'danger') <b>отказать</b> @endif. Введите замечание в поле ниже</label>
                        <textarea name="description"  cols="30" rows="3" class="form-control"></textarea>
                        <button class="btn btn-success mt-3">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection