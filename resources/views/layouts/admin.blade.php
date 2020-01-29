<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset("css/app.css")}}">
    <link rel="stylesheet" href="{{ asset("cs/app.css")}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <script rel="stylesheet" src="{{ asset("js/app.js")}}"></script>
    <title>УКСИВТ</title>
</head>
<body>
<div id="admin">
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid justify-content-center">
        <a class="navbar-brand" href="/"><img src="/img/logo.png" alt="Уксивт" style="height: 60px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
        @auth
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav"><ul class="navbar-nav">
            <li class="nav-item ">
                <a class="nav-link" href={{url('admin')}}>Главная</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href={{route('banners.index')}}>Баннеры</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route ('news.index')}}">Новости</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('page.index')}}">Страницы</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('logs')}}">Журнал</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('sliders')}}">Слайдер</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('courses.index')}}">Курсы</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('events.index')}}">События</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href={{route('url.index')}}>Ссылки</a>
            </li>
            <li class="nav-item">
                <a href="{{url('logout')}}" class="btn btn-danger">Выйти</a>
            </li>
        </ul>
    </div>
        @endauth
        @guest
            <div>
                <p class="text-info">Добро пожаловать на страницу администратора!</p>
            </div>
        @endguest
    </div>
</nav>

<div class="container admin-content">
    @include('partials.alerts')

    @yield('content')
</div>

    @yield('content1')
</div>

</body>