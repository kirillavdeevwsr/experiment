@extends('layouts/admin')
@section('content')
    <div class="container">
        @if (isset($event))
        <h1>Редактирование события: {{$event->title}}</h1>
            @else
        <h1>Создание события</h1>
            @endif
            @if(session('message'))
                <div>
                    <p class="text-danger">{{session('message')}}</p>
                    @endif
            <div>
                <form enctype="multipart/form-data" id="events" action="@if (isset($event)){{route('events.update', $event->id)}} @else {{route('events.store')}}@endif" method="post">
                    {{csrf_field()}}
                    @if (isset($event))
                    {{method_field('PATCH')}}
                    @endif
                    <fieldset class="form-group">
                        <label for="title">Название события:</label>
                        <input type="text" name="title" id="title" required class="form-control" value="{{ isset($event)  ? $event->title : '' }}">
                    </fieldset>

                    <fieldset class="form-group">
                        <label for="start">Дата начала события:</label>
                        <input type="date" name="start" id="start" required class="form-control" value="{{ isset($event)  ? $event->start : '' }}">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="finish">Дата окончания события:</label>
                        <input type="date" name="finish" id="finish" required class="form-control" value="{{ isset($event)  ? $event->finish : '' }}">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="lecture">Аудитория:</label>
                        <input type="text" name="lecture" id="lecture" required class="form-control" value="{{ isset($event)  ? $event->lecture : '' }}">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="preview">Краткое описание для главной страницы:</label>
                        <p style="font-size: 12px" class="text-danger">Не больше 330 символов!</p>
                        <textarea type="text" rows=10 maxlength="330" name="preview" required id="preview" class="form-control">{{ isset($event)  ? $event->preview : '' }}</textarea>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="text">Основная информация:</label>
                        <textarea type="text" name="text" id="text"  class="form-control" >{{ isset($event)  ? $event->text : '' }}</textarea>
                    </fieldset>
                    <br>
                    <br>

                </form>
                <div class="row form_button">
                    <input form="events" type="submit" class="btn btn-success" value="{{ isset($event) ? 'Изменить' : 'Сохранить'}}">
                    @if (isset($event))
                    <form action="{{route('events.destroy', $event->id)}}}">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input type="submit"  class="btn btn-danger" value="Удалить">
                    </form>
                        @endif
                </div>
            </div>

    </div>
    <script>
        $(document).ready(function () {
            tinymce.init({
                selector: '#text',
                height: 500,
                theme: 'modern',
                language:'ru',
                toolbar: 'code',
                plugins: 'code preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools  contextmenu colorpicker textpattern help',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code',
            });
        });

    </script>
    @endsection