@extends('layouts.admin')
@section('title') Создание @endsection

@section('content')
    <style>
        .select ul {
            display: flex;
            flex-direction: column;
        }

        .select ul li.option {
            background-color: #DEDEDE;
            box-shadow: 0px 1px 0 #DEDEDE, 0px -1px 0 #DEDEDE;
            -webkit-box-shadow: 0px 1px 0 #DEDEDE, 0px -1px 0 #DEDEDE;
            -moz-box-shadow: 0px 1px 0 #DEDEDE, 0px -1px 0 #DEDEDE;
        }

        .select ul li.option:hover {
            background-color: #eaeaea;
        }

        .select ul li.option {
            z-index: 1;
            padding: 5px;
            display: none;
            list-style: none;
        }

        .select ul li:first-child {
            display: block;
        }

        .select ul li {
            cursor: pointer;
        }
    </style>

    <div class="container">

        <div class="row justify-content-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('assessment.evalution.index')}}">Критерии оценки</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Создание</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="card w-50">
                <div class="card-body">
                    <form action="{{route('assessment.evalution.store')}}" class="form" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Критерий</label>
                            <div class="select">
                                <ul>
                                    @foreach($criterions as $item)
                                        <li class="option" data-value="{{$item->id}}">
                                            {{$item->criterion}}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <input type="hidden" name="assessment_id">
                        </div>
                        <div class="form-group">
                            <label for="">Наименование</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="">Баллов</label>
                            <input type="float" class="form-control" step="0.05" name="point">
                        </div>
                        <button class="btn btn-success btn-block">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(".select ul li.option").click(function () {//dropdown select
            $(this).siblings().addBack().children().remove();
            var a = $(this).siblings().toggle();
            $(this).siblings().append('<span class="fas fa-times float-right text-danger"></span>');
            $(this).parent().prepend(this);
            $('input[name=assessment_id]').val($(this).data('value'));
        })
    </script>

@endsection