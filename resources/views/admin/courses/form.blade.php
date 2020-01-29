@extends('layouts/admin')
@section('content')
    <div class="container">
        @if (isset($course))
        <h1>Редактирование круса: {{$course->title}}</h1>
            @else
        <h1>Создание курса</h1>
            @endif
            @if(session('message'))
                <div>
                    <p class="text-danger">{{session('message')}}</p>
                    @endif
            <div>
                <form enctype="multipart/form-data" id="courses" action="@if (isset($course)){{route('courses.update', $course->id)}} @else {{route('courses.store')}}@endif" method="post">
                    {{csrf_field()}}
                    @if (isset($course))
                    {{method_field('PATCH')}}
                    @endif
                    <fieldset class="form-group">
                        <label for="title">Название курса:</label>
                        <input type="text" name="title" id="title" required class="form-control" value="{{ isset($course)  ? $course->title : '' }}">
                    </fieldset>
                    @if (isset($course))
                    <img style = 'width: 50%' src="{{$course->image}}" alt="">
                    <p class="text-danger">Изменить картинку:</p>
                    @endif
                    <fieldset class="form-group">
                        <label for="image">Введите ссылку на изображение:</label>
                        <input type="text"  name="image" id="image"  class="form-control" value="{{ isset($course)  ? $course->image : '' }}" >
                    </fieldset>
                    <fieldset class="form-group" >
                        <label for="file">Или сохраните картинку на сайте </label>
                        <br>
                        <span class="btn btn-default btn-file text-dark">
                    <input    id = 'file' name = 'file' type="file" >
                    </span>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="start">Дата начала курса:</label>
                        <input type="date" name="start" id="start" required class="form-control" value="{{ isset($course)  ? $course->start : '' }}">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="finish">Дата окончания курса:</label>
                        <input type="date" name="finish" id="finish" required class="form-control" value="{{ isset($course)  ? $course->finish : '' }}">
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="description">Краткое описание для главной страницы:</label>
                        <p style="font-size: 12px" class="text-danger">Не больше 330 символов!</p>
                        <textarea type="text" rows=10 maxlength="330" name="description" required id="description" class="form-control">{{ isset($course)  ? $course->description : '' }}</textarea>
                    </fieldset>
                    <fieldset class="form-group">
                        <label for="info">Основная информация:</label>
                        <textarea type="text" name="info" id="info"  class="form-control" >{{ isset($course)  ? $course->info : '' }}</textarea>
                    </fieldset>
                    <br>
                    <br>

                </form>
                <div class="row form_button">
                    <input form="courses" type="submit" class="btn btn-success" value="{{ isset($course) ? 'Изменить' : 'Сохранить'}}">
                    @if (isset($course))
                    <form action="{{route('courses.destroy', $course->id)}}}">
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
                selector: '#info',
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