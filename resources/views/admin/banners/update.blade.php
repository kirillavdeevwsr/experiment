@extends('layouts.admin')
@section('content')
    <div class="rw">
        <h1 class="center-block ">Редактирование баннера: {{$banner->alt}}</h1>
        <div class=" center-block">

            <form enctype="multipart/form-data" action="{{route('banners.update', $banner->id)}}" class="form   center-block" method="post" id="banner_update">
                {{csrf_field()}}
                {{ method_field('PATCH') }}
                <fieldset class="form-group">
                    <label for="url">Полный адрес ссылки баннера</label>
                <input class="form-control" id='url' name='url' type="text" value="{{$banner->url}}">
                </fieldset>
                <img style = 'width: 50%' src="{{$banner->img}}" alt="">
                <p class="text-danger">Изменить картинку:</p>

                <fieldset class="form-group">
                    <label for="img">Введитре адрес на картинку, желательно, полный</label>
                        <input class="form-control" name='img' id="img" type="text" value="{{$banner->img}}">
                </fieldset>
                <fieldset class="form-group" >
                    <label for="file">Или сохраните картинку на сайте </label>
                    <br>
                    <span class="btn btn-default btn-file text-dark">
                    <input  id = 'file' name = 'file' type="file" >

                    </span>

                </fieldset>

                <fieldset class="form-group">
                    <label for="alt">Краткое описание картинки</label>
                        <input class="form-control" name='alt' id="alt" type="text" value="{{$banner->alt}}">
                </fieldset>
                <div class="form-group">
                    <fieldset>Расположение баннера</fieldset>
                    <select name="sort" id="sort">
                        <option value="0">Середина страницы</option>
                        <option value="1">Низ страницы</option>
                    </select>
                </div>
            </form>
            <img src="#" alt="">
        <br>
        <div class="row ">
            <input form='banner_update' type="submit" class="btn btn-success" value="Изменить" style="margin: auto 40px">
            <form action="{{route('banners.destroy', $banner->id)}}" method="post">
                {{  csrf_field()}}
                {{ method_field ('DELETE') }}
                <input type="submit" class="btn btn-danger" value="Удалить">
            </form>

        </div>
        </div>
    </div>




@endsection