@extends('layouts.index')
@section('title') Лист самооценки
@endsection

@section('content')

    <div class="container-fluid mt-3 mb-3">
        <div class="row justify-content-center">
            <div class="alert alert-warning alert-dismissible text-center" role="alert">
                Все пожелания по оформлению, найденные ошибки и неточности в работе раздела <b>листа самооценки</b>
                присылайте на
                <br>
                почту <b>nur.timur@ufaga.ru</b>
                <br>
                В заголовке письма укажите "Лист самооценки" и в содержании развернутое описание проблемы/пожелания
                <button class="close" data-dismiss="alert" aria-label="Close"><i class="fas fa-times-circle"></i>
                </button>
            </div>
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header text-center">
                        Мои критерии
                        <div class="col text-right">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 text-center">
                                <p>Сегодня {{$dates->get('now')}} г.
                                    {{$dates->get('reporting_period')}}
                                </p>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <a href="{{route('teacher.assessment.create')}}" class="btn btn-success btn-block mb-3">Добавить
                                            критерий</a>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <a href="{{route('teacher.assessment.archive')}}" class="btn btn-block btn-info">Архив критериев</a>
                                    </div>
                                </div>
                                @if(!empty($checking))
                                    <a href="{{route('teacher.assessment.check')}}" class="btn btn-info btn-block mb-3">Проверить
                                        критерии <span class="badge badge-warning">{{$checking}}</span></a>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <p><b>Подтвержденных баллов:</b> {{$assessment['assessmentsSumPoint']}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <table class="table table-responsive-sm">
                                    <thead>
                                    <tr>
                                        <th scope="col">№п/п</th>
                                        <th scope="col">Критерий</th>
                                        <th scope="col">Критерии оценки</th>
                                        <th scope="col">Балл</th>
                                        <th scope="col">Вложения</th>
                                        <th scope="col">Комментарий</th>
                                        <th scope="col">Статус</th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    @foreach($assessment['assessments'] as $item)
                                        <tbody>
                                        <tr @if($item->status_color) class="table-{{$item->status_color}}"@endif>
                                            <th scope="row">{{$loop->iteration}}</th>
                                            <td>{!! $item->assessment->criterion !!} </td>
                                            <td>
                                                @foreach($item->assessment->criterions as $criterion)
                                                    {!! $criterion->name !!} <br/>
                                                @endforeach
                                            </td>
                                            <td>{!! $item->point !!}</td>
                                            <td><a href="{{asset($item->attachment)}}">Вложенный файл</a></td>
                                            <td>{{$item->description}}</td>
                                            <td>{{$item->status->name}}</td>
                                            <td class="align-middle">
                                                @if($item->status->name == 'Новый')
                                                    <form action="{{route('teacher.assessment.delete', $item)}}" class="form-inline" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-link" onclick="return confirm('Удалить?')"><i class="fas fa-trash text-danger"></i></button>
                                                    </form>
                                                    @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="text-right"><b>Итого подтвержденных баллов:</b></td>
                                        <td>{{$assessment['assessmentsSumPoint']}}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection