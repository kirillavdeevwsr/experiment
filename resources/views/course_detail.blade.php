@extends('layouts.index')
@section('title'){{$course->title}}@endsection
@section('content')

    <section id="new-page">
        <div class="container">
            <div class="new-page-content">
                <h2>{{$course->title}}</h2>
                <div>
                    <p>Начало курса: <b>{{$course->raw_date->diffForHumans()}}</b></p>
                    <br>
                    <p>Продолжительность курса: <b>{{$course->duration}}</b></p>
                </div>
                <div class="new-page-img">
                    <img src="{{$course->image}}" alt="image">
                </div>
                <div class="new-page-text">
                    {!! $course->info !!}
                </div>
                <div class="form">
                    <h2>Записаться на курс</h2>
                    <form action="{{route('send_mail')}}" method="post" id="courses_sing_up">
                        {{csrf_field()}}
                        <fieldset>
                            <input type="hidden" value="{{$course->title}}" name="course"  >
                        </fieldset>
                        <fieldset>
                            <label for="">Полное имя:</label>
                            <input type="text" name="name" placeholder="ФИО">
                        </fieldset>
                        <fieldset>
                            <label for="">Телефон:</label>
                            <input type="text" name="phone" placeholder="+7(999)9999-999">
                        </fieldset>
                        <fieldset>
                            <p class="comment-label">Комментарий:</p>
                            <textarea style="width: 100%" id='comment' type="text" rows="10" name="comment"></textarea>
                        </fieldset>
                        <input type="submit" value="Отправить заявку" class="about-btn">
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

