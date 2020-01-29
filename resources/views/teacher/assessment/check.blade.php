@extends('layouts.index')
@section('title') проверка критериев @endsection

@section('content')

    <div class="container mt-3 mb-3">
        <div class="row justify-content-center">
            <div class="card w-100">
                <div class="card-header">
                    Проверка критериев
                </div>
                <div class="card-body">
                    @if(!empty($assessments))
                        @foreach($assessments as $item)
                            <div class="card mb-3">
                                <div class="card-header text-center">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6">
                                            <b>{!!$item->users->full_name!!}</b>
                                        </div>
                                        <div class="col-md-6 col-sm-6">
                                            <div class="badge badge-secondary" style="font-size: 100%">{!! $item['forPeriod'] !!}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p><b>Критерий: </b> {!!$item->assessment->criterion!!}</p>
                                    <p><b>Единица показателя,уровни мероприятия: </b>{!!$item->assessment->unit_of_measure!!}</p>
                                    <p><b>Критерии оценки: </b>@foreach($item->assessment->criterions as $crit){!!$crit->name!!} <br> @endforeach</p>
                                    <p><b>Источник данных: </b>{!!$item->assessment->data_source!!}</p>
                                    <p><b>Периодичность подведения итогов: </b>{!!$item->assessment->periodicity->name!!}</p>
                                    <p><b>Периодичность выплат: </b>{!!$item->assessment->frequencyPayment->name!!}</p>
                                    <p><b>Вложенные файлы: </b><a href="{{asset($item->attachment)}}">Вложенный файл</a></p>
                                    <p><b>Баллов: </b>{!!$item->point!!}</p>
                                </div>
                                <div class="card-footer">
                                    <form action="{{route('teacher.assessment.change-status',[$item->id, 'success'])}}" method="POST" class="form d-inline">
                                        @csrf
                                        <button class="btn btn-outline-success mb-2" type="submit">Подтвердить</button>
                                    </form>
                                    <a href="{{route('teacher.assessment.change', [$item->id, 'danger'])}}" class="btn btn-outline-danger mb-2">Отказать</a>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection