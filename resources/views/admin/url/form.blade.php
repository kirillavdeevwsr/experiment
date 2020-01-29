@extends('layouts/admin')
@section('content')
    <div class="container">
        @if (isset($url))
        <h1>Редактирование ссылки: {{$url->title}}</h1>
            @else
        <h1>Создание ссылки</h1>
        @endif
            @if(session('message'))
                    <p class="text-danger">{{session('message')}}</p>
            @endif
            <div>
                <form enctype="multipart/form-data" id="url" action="@if (isset($url)){{route('url.update', $url->id)}} @else {{route('url.store')}}@endif" method="post">
                    {{csrf_field()}}
                    @if (isset($url))
                    {{method_field('PATCH')}}
                    @endif
                    <fieldset class="form-group">
                        <label for="title">Название ссылки:</label>
                        <input type="text" name="title" id="title" required class="form-control" value="{{ isset($url)  ? $url->title : '' }}">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="url">Ссылка:</label>
                        <textarea type="text" name="url" id="url"  class="form-control" >{{ isset($url)  ? $url->url : '' }}</textarea>
                    </fieldset>
                </form>
                <div class="row form_button">
                    <input form="url" type="submit" class="btn btn-success" value="{{ isset($url) ? 'Изменить' : 'Сохранить'}}">
                </div>
            </div>
    </div>
    @endsection