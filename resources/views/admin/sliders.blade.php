@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Управление слайдером</h1>
        <br>
        @if (isset($slider))
        @foreach($slider as $img)
            <br>
            <div class="">

                <a href="{{$img->link}}">
                <img src="{{$img->link}}" alt="Уксивт {{$img->id}}">
                </a>
                <br>
                <br>
                <div>
                <form method="post" action="{{route('remove_slider', $img->id)}}">
                    {{csrf_field()}}
                    <input type="hidden" name="link" value="{{$img->link}}">
                    <input type="submit" value="Удалить" class="btn btn-danger">
                </form>
                </div>

            </div>
            <br>
        @endforeach
        @endif

        <hr>
        <h2 class="text-center">Добавление нового изображения</h2>
            <form action="{{route('add_slider')}}" method="post"  enctype="multipart/form-data">
                {{csrf_field()}}
                <fieldset class="form-group">
                    <label for="link">Ссылка на изображение:</label>
                <input id="link" name="link" type="text" class="form-control">
                    <br>
                    <fieldset class="form-group" >
                        <label for="file_img">Или сохраните картинку на сайте </label>
                        <br>
                        <span class="btn btn-default btn-file text-dark">
                    <input multiple="multiple"  id = 'addFile' name = 'addFile' type="file" >
                    </span>
                    </fieldset>

                </fieldset>
                <input class="btn btn-success" value=" Добавить изображение" type="submit">

        </form>

    </div>

    @endsection