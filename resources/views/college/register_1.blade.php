@extends('layouts.index')
@section('title') Регистрация @endsection
@section('content')
{{--    <register-component></register-component>--}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="alert alert-warning alert-dismissible fade show text-center mt-3" role="alert">
                <b class="text-center">Внимание!</b>
                <p>Регистрация предназначена только для студентов. Если вы являетесь преподавателем и у вас нет учетный записи, то обратитесь в 209 кабинет</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i class="fas fa-times-circle"></i></span>
                </button>
            </div>

            <div id="login">
                <div id="register_header">
                    <div class="text-center">
                        <img id="register_logo" src="{{asset('images/logo.svg')}}"/>
                        РЕГИСТРАЦИЯ
                    </div>
                </div>

                <div class="stage d-flex flex-column justify-content-center">
                    <div class="stage_wrapper d-flex flex-row justify-content-center">
                        <p class="stage_text d-flex justify-content-center align-items-center">шаг</p>
                        <p class="stage_number d-flex justify-content-center align-items-center">1</p>
                    </div>
                    <div class="stage_info d-flex flex-column justify-content-center mt-4">
                        <p class="text-center">Заполните паспортные данные</p>
                        <p class="text-center">Ваши паспортные данные не хранятся на сайте. Они требуются только для идентификации.</p>
                    </div>
                </div>
                <div id="register_body" class="d-flex flex-column">

                    <form class="text-center" method="POST" action="{{route('register_1_post')}}">
                        @csrf
                        <div class="group-input">
                            <input type="number" class="register_input" placeholder="Серия" name="serial">
                        </div>

                        <div class="group-input">
                            <input type="number" class="register_input" placeholder="Номер" name="number">
                        </div>

                        <div class="g-recaptcha d-flex justify-content-center" data-sitekey="{{env('RECAPTCHA_KEY')}}"></div>

                        <button class="register_button" type="submit">Продолжить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
