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
                <div class="form-group">
                    <fieldset for="title">Название ссылки:</fieldset>
                    <select name="title" id="title">
                        <option value="VK">VK</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Instagram">Instagram</option>
                    </select>
                </div>
                <fieldset class="form-group">
                    <label for="url">Ссылка:</label>
                    <textarea type="text" name="url" id="url"  class="form-control" >{{ isset($url)  ? $url->url : 'www.' }}</textarea>
                </fieldset>
                <br>
                <br>

            </form>
            <div class="row form_button">
                <input form="url" type="submit" class="btn btn-success" value="{{ isset($url) ? 'Изменить' : 'Сохранить'}}">
                @if (isset($url))
                    @php
                        echo '<pre>';
                        var_dump($url) ;
                        die();
                    @endphp
                    <form action="{{route('url.destroy', $url->id)}}}">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input type="submit"  class="btn btn-danger" value="Удалить">
                    </form>
                @endif
            </div>
        </div>
    </div>

@endsection