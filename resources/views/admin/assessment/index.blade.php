@extends('layouts.admin')
@section('title') Лист самооценки @endsection
@section('content1')
    <div class="container-fluid">
            <div class="card w-100">
{{--        <div class="card-header">Лист самооценки</div>--}}
            <div class="card-body">
                <a href="{{route('assessment.create')}}" class="btn btn-outline-success mb-3 text-dark">Добавить критерий</a>
                <a href="{{route('assessment.evalution.index')}}" class="btn btn-outline-success mb-3 text-dark">Критерии оценки</a>
                <a href="{{route('assessment.summary-periodicity.index')}}" class="btn btn-outline-success mb-3 text-dark">Периодичность подведения итогов</a>
                <a href="{{route('assessment.frequency-of-payment.index')}}" class="btn btn-outline-success mb-3 text-dark">Периодичность выплат</a>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">№</th>
                            <th scope="col">Показатель</th>
                            <th scope="col">Единица измерения, уровни мероприятия</th>
                            <th scope="col">Критерии оценки</th>
                            <th scope="col">Источник данных</th>
                            <th scope="col">Периодичность подведения итогов</th>
                            <th scope="col">Периодичность выплат</th>
                            <th scope="col">Множественное заполнение критериев за месяц</th>
                            <th scope="col">Множественный выбор критериев оценки</th>
                            <th scope="col">Ответственный за оценку</th>
                            <th scope="col">Действие</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(!$list->isEmpty())
                        @foreach($list as $item)
                            <tr>
                                <th scope="row">{{$loop->index+1}}</th>
                                <td>{!! $item->criterion!!}</td>
                                <td>{!!$item->unit_of_measure!!}</td>
                                <td>
                                    @foreach($item->criterions as $crit)
                                        {!! $crit->name !!} - {{$crit->point}} балла (ов); <br>
                                    @endforeach
                                </td>
                                <td>{!!$item->data_source!!}</td>
                                <td>{!! $item->periodicity->name !!}</td>
                                <td>{!! $item->frequencyPayment->name !!}</td>
                                <td>{{$item->multi_add ? 'Да' : 'Нет'}}</td>
                                <td>{{$item->multiple_select ? 'Да' : 'Нет'}}</td>
                                <td>{!!$item->user->full_name!!}</td>
                                <td class="d-flex border-0 center">
                                    <a href="{{route('assessment.edit', $item->id)}}" class="btn btn-default"> <span class="fas fa-edit text-warning"></span></a>
                                    <form action="{{route('assessment.destroy', $item->id)}}" class="d-inline" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-default text-danger"><span class="fas fa-trash"></span></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center"><h4 class="text-danger">Ничего нет</h4></td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection