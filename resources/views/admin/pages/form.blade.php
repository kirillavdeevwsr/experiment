@extends('layouts.admin')
@section ('content')

    <div class="center-block">

        @if (session('mes'))
            <div class="container"> <p class="text-danger" style="font-size: 35px">{{ session ('mes')}}</p></div>
        @endif
        @if (isset($page))
            <h1>Редактирование страницы: {{$page->title}} </h1>
        @else
            <h1>Создание страницы</h1>
            <p>Заполните все поля</p>
        @endif

        <form method='post'
              action="@if (isset($page)) {{route ('page.update', $page->id)}} @else {{route ('page.store')}} @endif"
              class="form center-block" id="page_form">
            {{csrf_field()}}

            @if (isset($page))
                {{method_field("PATCH")}}
            @endif

            <fieldset class="form-group">
                <label for="title">Заголовок</label>
                <input class="form-control" name="title" id="title" type="text"
                       value="{{isset ($page) ? $page->title: ''}}">
            </fieldset>

            <fieldset class="form-group"><label for="text">Текст</label>
                <textarea id="text" name="text" class="form-control">{{isset ($page) ? $page->text: ''}}</textarea>
            </fieldset>
            <br><br>


            @if(isset($page))
            <p><input type="radio" checked name="status" value="1">Показать на сайте</p>
            <p><input type="radio" name="status" value="2">Скрыть</p>
            @endif

            <br>
            <br>
            <p style="color: #595BD4 ;">Выберите раздел к которому относиться страница:</p>
            <p class="text-dark" >Если не нашли подходящий, то сначала <a href="{{route('page.create')}}">создайте его</a></p>

            <select name="parent" id="parent" style="width: 100%">
                <option value="0">Корневая страница</option>
                @foreach($parents as $parent)
                <option @if(isset($page))@if($page->parent ===$parent->id) selected @endif @endif value="{{$parent->id}}">{{$parent->title }}</option>
                    @endforeach
                </select>
            <br>

            <br>
            <fieldset class="form-group">
            <label for="sort">Выберите порядок расположения станицы:</label>
            <input type="number" id="sort" name="sort" value="{{isset($page) ? $page->sort : ''}}">
            <p class="text-dark">Порядок сортировки идет от 0. Чем больше цифра, тем страница правее или ниже в меню. </p>
            </fieldset>
        </form>
    </div>
    @if(isset($page))
        <p>В адрессной строке: <span class="text-warning">/{{$page->slug}}</span></p>
    @endif
    <div class="row form_button">
        @if (isset($page))
            <input form='page_form' type="submit" class="btn btn-success" value="Изменить">
            <form action="{{route('page.destroy', $page->id)}}" method="post">
                {{  csrf_field()}}
                {{ method_field ('DELETE') }}
                <input type="submit" class="btn btn-danger" value="Удалить">
            </form>
        @else
            <input form='page_form' type="submit" class="btn btn-success" value="Сохранить">
        @endif
    </div>

    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: 'textarea',
                height: 500,
                theme: 'modern',
                plugins: 'preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools  contextmenu colorpicker textpattern help code',
                toolbar: 'code',
                language:'ru',
                // menubar: 'tools',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code'
            });
        });
    </script>

    @endsection