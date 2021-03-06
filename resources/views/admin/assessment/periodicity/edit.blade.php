@extends('layouts.admin')
@section('title') Изменение @endsection

@section('content')

    <div class="container">

        <div class="row justify-content-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('assessment.summary-periodicity.index')}}">Периодичность подведения итогов</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Изменение</li>
                </ol>
            </nav>
        </div>

        <div class="row justify-content-center">
            <div class="card w-50">
                <div class="card-body">
                    <form action="{{route('assessment.summary-periodicity.update',$item->id)}}" class="form" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="">Наименование</label>
                            <input type="text" class="form-control" name="name" value="{{$item->name}}">
                        </div>
                        <button class="btn btn-success btn-block">Сохранить изменения</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection