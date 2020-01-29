@extends('layouts.admin')
@section('content')

    <div class="rw">
        <h1 class="center-block ">Добавление нового баннера на гланую страницу</h1>
        <div class=" center-block">
            @if(session('message'))
                <div>
                    <p class="text-danger">{{session('message')}}</p>
                @endif
            <form action="{{route('banners.store')}}" class="form center-block" method="post" enctype="multipart/form-data" id="banner_update">
                {{csrf_field()}}

                <fieldset class="form-group">
                    <label for="url">Полный адрес ссылки баннера(куда перенаправить)</label>
                    <input required class="form-control" id='url' name='url' type="text" >
                </fieldset>
                <fieldset class="form-group">
                    <label for="img">Введите адрес на картинку на стороннем ресурсе</label>
                    <input class="form-control" name='img' id="img" type="text" >
                </fieldset>
                <fieldset class="form-group" >
                    <label for="file">Или сохраните картинку на сайте </label>
                    <br>
                    <span class="btn btn-default btn-file text-dark">
                    <input    id = 'file' name = 'file' type="file" >
                    </span>
                </fieldset>
                <br>
                <fieldset class="form-group">
                    <label for="alt">Краткое описание картинки</label>
                    <input required class="form-control" name='alt' id="alt" type="text" >

                </fieldset>
                <div class="form-group">
                    <fieldset>Расположение баннера</fieldset>
                    <select name="sort" id="sort">
                        <option value="0">Середина страницы</option>
                        <option value="1">Низ страницы</option>
                    </select>
                </div>
                <input form='banner_update' type="submit" class="btn btn-success" value="Создать" >
            </form>
        </div>
        <br>

    </div>
    </div>



@endsection


