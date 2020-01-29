@extends('layouts.admin')
@section('content')
    
    <div class="row">
    <div class="col-md-6 center-block" style="margin-bottom:50px">
        <img src="{{$banner->img}}" alt="">
    </div>
        <table class="table">
           
            <tr>
                <th>
                <b>Полный адрес ссылки баннера</b>
                </th>
                <th>{{$banner->url}}</th>
            </tr>
            <tr>
            <th><b>Адрес на картинку</b></th>
            <th>{{$banner->img}}</th>
            </tr>
            <tr>
                <th><b>Краткое описание картинки</b></th>
                <th>{{$banner->alt}}</th>
            </tr>
            <tr>
                <th><b>Позиция на главной странице</b></th>
                <th>{{$banner->text_sort}}</th>
            </tr>

        </table>
        <div class="row">
            <a style="margin:  auto 30px" href="{{route('banners.edit', $banner->id)}}">
                <button class="btn btn-info">Редактировать</button>
            </a>
            <form action="{{ route ('banners.destroy', $banner->id) }}" method="post">
                {{  csrf_field()}}
                {{ method_field ('DELETE') }}
                <input type="submit" class="btn btn-danger" value="Удалить">
            </form></div>
    </div>

    @endsection