<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>УКСИВТ - @yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/slick.css')}}">
    <link rel="stylesheet" href="{{ asset ("button-visually-impaired/css/bvi.min.css")}}" type="text/css">
    <link rel="stylesheet" href="{{ asset("css/app.css")}}">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css"
    integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">

    <title>УКСИВТ</title>
    <script src="https://www.google.com/recaptcha/api.js?hl=ru" async defer></script>
</head>
<body id='app'>
<div id="modal">
    <div>
        <span id="modal_close"><i class="far fa-times-circle"></i></span>
        <h4><b>Ваша заявка успешно отправлена!</b></h4>
        <p>Номер заявки: <span class="enrolleeNumber"></span></p>
        <p>Для подтверждения заявки требуется подъехать с документами в приемную комиссию по адресу Кирова 65 и сообщить
            номер заявки</p>
    </div>
</div>
<div id="overlay"></div>

@php
    $pages=App\Models\Page::where('parent', 0)->where('status', 1)->orderBy('sort')->get();
@endphp
<section id="header">
    <div class="header-top">
        <div class="container">
            <div class="hello-div">
                Добро пожаловать!
            </div>
            <div class="header-top-menu">
                <ul>
                    <li class="eye-problems">
                        <a href="#" class="bvi-panel-open-menu">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 version="1.1" x="0px" y="0px" viewBox="0 0 561 561"
                                 style="enable-background:new 0 0 561 561;" xml:space="preserve">
                                    <g>
                                        <g id="visibility">
                                            <path d="M280.5,89.25C153,89.25,43.35,168.3,0,280.5c43.35,112.2,153,191.25,280.5,191.25S517.65,392.7,561,280.5    C517.65,168.3,408,89.25,280.5,89.25z M280.5,408C209.1,408,153,351.9,153,280.5c0-71.4,56.1-127.5,127.5-127.5    c71.4,0,127.5,56.1,127.5,127.5C408,351.9,351.9,408,280.5,408z M280.5,204c-43.35,0-76.5,33.15-76.5,76.5    c0,43.35,33.15,76.5,76.5,76.5c43.35,0,76.5-33.15,76.5-76.5C357,237.15,323.85,204,280.5,204z"/>
                                        </g>
                                    </g>
                                </svg>
                            Версия для слабовидящих
                        </a>
                    </li>
                    @auth {{--Для преподавателей--}}
                    <li class="dropdown-menu-header" id="header-person">
                        <a href="{{route('teacher.profile')}}" id="header-person-profile">
                            <div class="header-person">
                                <div class="header-person-avatar">
                                    <img src="{!! auth()->user()->image ?: asset('images/user.png')!!}" alt="">
                                </div>
                                <div class="header-person-fio">{{auth()->user()->name}} {{auth()->user()->patronymic}}
                                </div>
                            </div>
                        </a>
                        @can('is-student', auth()->user())
                            <div class="dropdown-menu-header-content">
                                <a href="/" class="d-md-block d-lg-none dropdown-menu-header-item">Главная</a>
                                <a href="{{route('profile')}}" class="dropdown-menu-header-item">Профиль</a>
                            </div>
                        @else
                            <div class="dropdown-menu-header-content">
                                <a href="/" class="d-md-block d-lg-none dropdown-menu-header-item">Главная</a>
                                <a href="{{route('teacher.profile')}}" class="d-md-block d-lg-none dropdown-menu-header-item">Профиль</a>
                                <a href="{{route('teacher.assessment.index')}}" class="dropdown-menu-header-item">Лист
                                    самооценки</a>
                                @if(\Illuminate\Support\Facades\Gate::check('is-admin', auth()->user()) || \Illuminate\Support\Facades\Gate::check('is-accountant', auth()->user()) || \Illuminate\Support\Facades\Gate::check('is-assessment-manager', auth()->user()))
                                    <a href="{{route('teacher.assessment.report')}}" class="dropdown-menu-header-item">Отчет по листу самооценки</a>
                                @endif
                                @can('is-admin', auth()->user())<a href="{{url('admin')}}"
                                                                   class="dropdown-menu-header-item">
                                    Панель администратора</a>
                                @endcan
                            </div>
                        @endcan
                    </li>

                    <a href="{{route('logout')}}">
                        <li>
                            <div class="header-person">
                                <div>
                                    Выход
                                </div>
                            </div>
                        </li>
                    </a>
                    @endauth
                    @guest
                        <a href="{{ route('1c_login') }}">
                            <li class="enter">
                                Вход
                            </li>
                        </a>
                        <a href="{{route('register_1')}}">
                            <li class="reg">
                                Регистрация
                            </li>
                        </a>
                    @endguest
                    <li class="burger-block">
                        <div class="burger-menu">
                            <div class="burger"></div>
                        </div>
                    </li>
                    <li class="soc-icons">
                        @php
                            $url=App\Models\Url::where(['title' => 'VK'])->get();
                        @endphp
                        @foreach ($url as $item)
                            <a href="{{"http://" . $item->url}}">
                                @endforeach
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     version="1.1" id="Capa_1" x="0px" y="0px"
                                     viewBox="0 0 548.358 548.358" style="enable-background:new 0 0 548.358 548.358;"
                                     xml:space="preserve">
                                        <g>
                                            <path d="M545.451,400.298c-0.664-1.431-1.283-2.618-1.858-3.569c-9.514-17.135-27.695-38.167-54.532-63.102l-0.567-0.571   l-0.284-0.28l-0.287-0.287h-0.288c-12.18-11.611-19.893-19.418-23.123-23.415c-5.91-7.614-7.234-15.321-4.004-23.13   c2.282-5.9,10.854-18.36,25.696-37.397c7.807-10.089,13.99-18.175,18.556-24.267c32.931-43.78,47.208-71.756,42.828-83.939   l-1.701-2.847c-1.143-1.714-4.093-3.282-8.846-4.712c-4.764-1.427-10.853-1.663-18.278-0.712l-82.224,0.568   c-1.332-0.472-3.234-0.428-5.712,0.144c-2.475,0.572-3.713,0.859-3.713,0.859l-1.431,0.715l-1.136,0.859   c-0.952,0.568-1.999,1.567-3.142,2.995c-1.137,1.423-2.088,3.093-2.848,4.996c-8.952,23.031-19.13,44.444-30.553,64.238   c-7.043,11.803-13.511,22.032-19.418,30.693c-5.899,8.658-10.848,15.037-14.842,19.126c-4,4.093-7.61,7.372-10.852,9.849   c-3.237,2.478-5.708,3.525-7.419,3.142c-1.715-0.383-3.33-0.763-4.859-1.143c-2.663-1.714-4.805-4.045-6.42-6.995   c-1.622-2.95-2.714-6.663-3.285-11.136c-0.568-4.476-0.904-8.326-1-11.563c-0.089-3.233-0.048-7.806,0.145-13.706   c0.198-5.903,0.287-9.897,0.287-11.991c0-7.234,0.141-15.085,0.424-23.555c0.288-8.47,0.521-15.181,0.716-20.125   c0.194-4.949,0.284-10.185,0.284-15.705s-0.336-9.849-1-12.991c-0.656-3.138-1.663-6.184-2.99-9.137   c-1.335-2.95-3.289-5.232-5.853-6.852c-2.569-1.618-5.763-2.902-9.564-3.856c-10.089-2.283-22.936-3.518-38.547-3.71   c-35.401-0.38-58.148,1.906-68.236,6.855c-3.997,2.091-7.614,4.948-10.848,8.562c-3.427,4.189-3.905,6.475-1.431,6.851   c11.422,1.711,19.508,5.804,24.267,12.275l1.715,3.429c1.334,2.474,2.666,6.854,3.999,13.134c1.331,6.28,2.19,13.227,2.568,20.837   c0.95,13.897,0.95,25.793,0,35.689c-0.953,9.9-1.853,17.607-2.712,23.127c-0.859,5.52-2.143,9.993-3.855,13.418   c-1.715,3.426-2.856,5.52-3.428,6.28c-0.571,0.76-1.047,1.239-1.425,1.427c-2.474,0.948-5.047,1.431-7.71,1.431   c-2.667,0-5.901-1.334-9.707-4c-3.805-2.666-7.754-6.328-11.847-10.992c-4.093-4.665-8.709-11.184-13.85-19.558   c-5.137-8.374-10.467-18.271-15.987-29.691l-4.567-8.282c-2.855-5.328-6.755-13.086-11.704-23.267   c-4.952-10.185-9.329-20.037-13.134-29.554c-1.521-3.997-3.806-7.04-6.851-9.134l-1.429-0.859c-0.95-0.76-2.475-1.567-4.567-2.427   c-2.095-0.859-4.281-1.475-6.567-1.854l-78.229,0.568c-7.994,0-13.418,1.811-16.274,5.428l-1.143,1.711   C0.288,140.146,0,141.668,0,143.763c0,2.094,0.571,4.664,1.714,7.707c11.42,26.84,23.839,52.725,37.257,77.659   c13.418,24.934,25.078,45.019,34.973,60.237c9.897,15.229,19.985,29.602,30.264,43.112c10.279,13.515,17.083,22.176,20.412,25.981   c3.333,3.812,5.951,6.662,7.854,8.565l7.139,6.851c4.568,4.569,11.276,10.041,20.127,16.416   c8.853,6.379,18.654,12.659,29.408,18.85c10.756,6.181,23.269,11.225,37.546,15.126c14.275,3.905,28.169,5.472,41.684,4.716h32.834   c6.659-0.575,11.704-2.669,15.133-6.283l1.136-1.431c0.764-1.136,1.479-2.901,2.139-5.276c0.668-2.379,1-5,1-7.851   c-0.195-8.183,0.428-15.558,1.852-22.124c1.423-6.564,3.045-11.513,4.859-14.846c1.813-3.33,3.859-6.14,6.136-8.418   c2.282-2.283,3.908-3.666,4.862-4.142c0.948-0.479,1.705-0.804,2.276-0.999c4.568-1.522,9.944-0.048,16.136,4.429   c6.187,4.473,11.99,9.996,17.418,16.56c5.425,6.57,11.943,13.941,19.555,22.124c7.617,8.186,14.277,14.271,19.985,18.274   l5.708,3.426c3.812,2.286,8.761,4.38,14.853,6.283c6.081,1.902,11.409,2.378,15.984,1.427l73.087-1.14   c7.229,0,12.854-1.197,16.844-3.572c3.998-2.379,6.373-5,7.139-7.851c0.764-2.854,0.805-6.092,0.145-9.712   C546.782,404.25,546.115,401.725,545.451,400.298z"
                                            />
                                        </g>
                                    </svg>
                            </a>
                            @php
                                $url=App\Models\Url::where(['title' => 'Facebook'])->get();
                            @endphp
                            @foreach ($url as $item)
                                <a href="{{"http://" . $item->url}}">
                                    @endforeach
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         version="1.1" id="Capa_1" x="0px" y="0px"
                                         viewBox="0 0 96.124 96.123" style="enable-background:new 0 0 96.124 96.123;"
                                         xml:space="preserve">
                                        <g>
                                            <path d="M72.089,0.02L59.624,0C45.62,0,36.57,9.285,36.57,23.656v10.907H24.037c-1.083,0-1.96,0.878-1.96,1.961v15.803   c0,1.083,0.878,1.96,1.96,1.96h12.533v39.876c0,1.083,0.877,1.96,1.96,1.96h16.352c1.083,0,1.96-0.878,1.96-1.96V54.287h14.654   c1.083,0,1.96-0.877,1.96-1.96l0.006-15.803c0-0.52-0.207-1.018-0.574-1.386c-0.367-0.368-0.867-0.575-1.387-0.575H56.842v-9.246   c0-4.444,1.059-6.7,6.848-6.7l8.397-0.003c1.082,0,1.959-0.878,1.959-1.96V1.98C74.046,0.899,73.17,0.022,72.089,0.02z"
                                            />
                                        </g>
                                    </svg>
                                </a>
                                @php
                                    $url=App\Models\Url::where(['title' => 'Instagram'])->get();
                                @endphp
                                @foreach ($url as $item)
                                    <a href="{{"http://" . $item->url}}">
                                        @endforeach
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                             version="1.1" id="Capa_1" x="0px" y="0px"
                                             viewBox="0 0 97.395 97.395"
                                             style="enable-background:new 0 0 97.395 97.395;"
                                             xml:space="preserve">
                                        <g>
                                            <path d="M12.501,0h72.393c6.875,0,12.5,5.09,12.5,12.5v72.395c0,7.41-5.625,12.5-12.5,12.5H12.501C5.624,97.395,0,92.305,0,84.895   V12.5C0,5.09,5.624,0,12.501,0L12.501,0z M70.948,10.821c-2.412,0-4.383,1.972-4.383,4.385v10.495c0,2.412,1.971,4.385,4.383,4.385   h11.008c2.412,0,4.385-1.973,4.385-4.385V15.206c0-2.413-1.973-4.385-4.385-4.385H70.948L70.948,10.821z M86.387,41.188h-8.572   c0.811,2.648,1.25,5.453,1.25,8.355c0,16.2-13.556,29.332-30.275,29.332c-16.718,0-30.272-13.132-30.272-29.332   c0-2.904,0.438-5.708,1.25-8.355h-8.945v41.141c0,2.129,1.742,3.872,3.872,3.872h67.822c2.13,0,3.872-1.742,3.872-3.872V41.188   H86.387z M48.789,29.533c-10.802,0-19.56,8.485-19.56,18.953c0,10.468,8.758,18.953,19.56,18.953   c10.803,0,19.562-8.485,19.562-18.953C68.351,38.018,59.593,29.533,48.789,29.533z"/>
                                        </g>
                                        </svg>
                                    </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <nav id="burger-menu-items">
        <ul class="main-burger-menu-items clearfix">
            @each('burger-submenu', $pages, 'page')
        </ul>

    </nav>

    <div class="header-main">
        <div class="container">
            <p>Государственное бюджетное профессиональное образовательное учреждение</p>
            <div class="header-main-sitename">
                <a class="link-main" href="/">
                    <img src="/img/logo.png" alt="logo">
                </a>
                <h1>Уфимский колледж статистики, информатики и вычислительной техники</h1>
            </div>
        </div>
    </div>

    <div class="header-bottom">
{{--        <i class="fas fa-arrow-left fa-2x" id="header-bottom-left-arrow"></i>--}}
        <div class="container">
            <div class="header-bottom-items d-flex">
                <ul>
                    @each('submenu', $pages, 'page')
                </ul>
            </div>
        </div>
{{--        <i class="fas fa-arrow-right fa-2x" id="header-bottom-right-arrow"></i>--}}
    </div>
</section>
@include('partials.alerts')
<section id="app">
    @yield('content')
</section>
<section id="footer">
    <div class="container">
        <div class="footer-wrapper">
            <div class="div-menu-link">
                <div class="logoFooter">
                    <img src="/img/uksivt_logo white.png" alt="Логотип">
                    <p>ГБПОУ Уфимский колледж статистики, информатики и вычислительной техники</p>
                </div>
                <a href="{{route('main')}}">Главная</a>
                @foreach($pages as $page)
                    <a href="{{route('show_page', $page->slug)}}">{{$page->title}}</a>
                @endforeach
            </div>
            <div class="contacts-footer">
                <p>Контакты</p>
                <ul>
                    <li>Адрес: г. Уфа, ул. Кирова, 65</li>
                    <li>Телефоны:</li>
                    <li>Приемная директора <a href="tel:+7(347) 228-67-72">(347) 228-67-72</a></li>
                    <li>Бухгалтерия <a href="tel:+7(347) 252-40-84">(347) 252-40-84</a></li>
                    <li>Отделение заочного и дистанционного отделения <a href="tel:+7 (347) 291-22-54">(347)
                            291-22-54</a></li>
                    <li>Учебный центр дополнительного профессионального образования <a href="tel:+7 (347) 292-58-29">(347)
                            292-58-29</a></li>
                    <li>Приёмная комиссия <a href="tel:+7 (347)252-40-40">(347)252-40-40</a></li>
                    <li>Отдел кадров <a href="tel:+7 (347) 291-22-53">(347) 291-22-53</a></li>
                    <li>Библиотека <a href="tel:+7(347) 252-41-63 ">(347) 252-41-63</a></li>
                    <li>Отдел закупок <a href="tel:+7(347) 252-40-40">(347) 252-40-40</a></li>
                </ul>
            </div>
            <div class="join-us">
                <p>Присоединяйтесь</p>
                <div class="soc-icons">
                    @php
                        $url=App\Models\Url::where(['title' => 'VK'])->get();
                    @endphp
                    @foreach ($url as $item)
                        <a href="{{"http://" . $item->url}}">
                            @endforeach
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                 version="1.1"
                                 id="Capa_1" x="0px" y="0px"
                                 viewBox="0 0 548.358 548.358" style="enable-background:new 0 0 548.358 548.358;"
                                 xml:space="preserve">
                                    <g>
                                        <path d="M545.451,400.298c-0.664-1.431-1.283-2.618-1.858-3.569c-9.514-17.135-27.695-38.167-54.532-63.102l-0.567-0.571   l-0.284-0.28l-0.287-0.287h-0.288c-12.18-11.611-19.893-19.418-23.123-23.415c-5.91-7.614-7.234-15.321-4.004-23.13   c2.282-5.9,10.854-18.36,25.696-37.397c7.807-10.089,13.99-18.175,18.556-24.267c32.931-43.78,47.208-71.756,42.828-83.939   l-1.701-2.847c-1.143-1.714-4.093-3.282-8.846-4.712c-4.764-1.427-10.853-1.663-18.278-0.712l-82.224,0.568   c-1.332-0.472-3.234-0.428-5.712,0.144c-2.475,0.572-3.713,0.859-3.713,0.859l-1.431,0.715l-1.136,0.859   c-0.952,0.568-1.999,1.567-3.142,2.995c-1.137,1.423-2.088,3.093-2.848,4.996c-8.952,23.031-19.13,44.444-30.553,64.238   c-7.043,11.803-13.511,22.032-19.418,30.693c-5.899,8.658-10.848,15.037-14.842,19.126c-4,4.093-7.61,7.372-10.852,9.849   c-3.237,2.478-5.708,3.525-7.419,3.142c-1.715-0.383-3.33-0.763-4.859-1.143c-2.663-1.714-4.805-4.045-6.42-6.995   c-1.622-2.95-2.714-6.663-3.285-11.136c-0.568-4.476-0.904-8.326-1-11.563c-0.089-3.233-0.048-7.806,0.145-13.706   c0.198-5.903,0.287-9.897,0.287-11.991c0-7.234,0.141-15.085,0.424-23.555c0.288-8.47,0.521-15.181,0.716-20.125   c0.194-4.949,0.284-10.185,0.284-15.705s-0.336-9.849-1-12.991c-0.656-3.138-1.663-6.184-2.99-9.137   c-1.335-2.95-3.289-5.232-5.853-6.852c-2.569-1.618-5.763-2.902-9.564-3.856c-10.089-2.283-22.936-3.518-38.547-3.71   c-35.401-0.38-58.148,1.906-68.236,6.855c-3.997,2.091-7.614,4.948-10.848,8.562c-3.427,4.189-3.905,6.475-1.431,6.851   c11.422,1.711,19.508,5.804,24.267,12.275l1.715,3.429c1.334,2.474,2.666,6.854,3.999,13.134c1.331,6.28,2.19,13.227,2.568,20.837   c0.95,13.897,0.95,25.793,0,35.689c-0.953,9.9-1.853,17.607-2.712,23.127c-0.859,5.52-2.143,9.993-3.855,13.418   c-1.715,3.426-2.856,5.52-3.428,6.28c-0.571,0.76-1.047,1.239-1.425,1.427c-2.474,0.948-5.047,1.431-7.71,1.431   c-2.667,0-5.901-1.334-9.707-4c-3.805-2.666-7.754-6.328-11.847-10.992c-4.093-4.665-8.709-11.184-13.85-19.558   c-5.137-8.374-10.467-18.271-15.987-29.691l-4.567-8.282c-2.855-5.328-6.755-13.086-11.704-23.267   c-4.952-10.185-9.329-20.037-13.134-29.554c-1.521-3.997-3.806-7.04-6.851-9.134l-1.429-0.859c-0.95-0.76-2.475-1.567-4.567-2.427   c-2.095-0.859-4.281-1.475-6.567-1.854l-78.229,0.568c-7.994,0-13.418,1.811-16.274,5.428l-1.143,1.711   C0.288,140.146,0,141.668,0,143.763c0,2.094,0.571,4.664,1.714,7.707c11.42,26.84,23.839,52.725,37.257,77.659   c13.418,24.934,25.078,45.019,34.973,60.237c9.897,15.229,19.985,29.602,30.264,43.112c10.279,13.515,17.083,22.176,20.412,25.981   c3.333,3.812,5.951,6.662,7.854,8.565l7.139,6.851c4.568,4.569,11.276,10.041,20.127,16.416   c8.853,6.379,18.654,12.659,29.408,18.85c10.756,6.181,23.269,11.225,37.546,15.126c14.275,3.905,28.169,5.472,41.684,4.716h32.834   c6.659-0.575,11.704-2.669,15.133-6.283l1.136-1.431c0.764-1.136,1.479-2.901,2.139-5.276c0.668-2.379,1-5,1-7.851   c-0.195-8.183,0.428-15.558,1.852-22.124c1.423-6.564,3.045-11.513,4.859-14.846c1.813-3.33,3.859-6.14,6.136-8.418   c2.282-2.283,3.908-3.666,4.862-4.142c0.948-0.479,1.705-0.804,2.276-0.999c4.568-1.522,9.944-0.048,16.136,4.429   c6.187,4.473,11.99,9.996,17.418,16.56c5.425,6.57,11.943,13.941,19.555,22.124c7.617,8.186,14.277,14.271,19.985,18.274   l5.708,3.426c3.812,2.286,8.761,4.38,14.853,6.283c6.081,1.902,11.409,2.378,15.984,1.427l73.087-1.14   c7.229,0,12.854-1.197,16.844-3.572c3.998-2.379,6.373-5,7.139-7.851c0.764-2.854,0.805-6.092,0.145-9.712   C546.782,404.25,546.115,401.725,545.451,400.298z"
                                        />
                                    </g>
                                </svg>
                        </a>
                        @php
                            $url=App\Models\Url::where(['title' => 'Facebook'])->get();
                        @endphp
                        @foreach ($url as $item)
                            <a href="{{"http://" . $item->url}}">
                                @endforeach
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     version="1.1"
                                     id="Capa_1" x="0px" y="0px"
                                     viewBox="0 0 96.124 96.123" style="enable-background:new 0 0 96.124 96.123;"
                                     xml:space="preserve">
                                    <g>
                                        <path d="M72.089,0.02L59.624,0C45.62,0,36.57,9.285,36.57,23.656v10.907H24.037c-1.083,0-1.96,0.878-1.96,1.961v15.803   c0,1.083,0.878,1.96,1.96,1.96h12.533v39.876c0,1.083,0.877,1.96,1.96,1.96h16.352c1.083,0,1.96-0.878,1.96-1.96V54.287h14.654   c1.083,0,1.96-0.877,1.96-1.96l0.006-15.803c0-0.52-0.207-1.018-0.574-1.386c-0.367-0.368-0.867-0.575-1.387-0.575H56.842v-9.246   c0-4.444,1.059-6.7,6.848-6.7l8.397-0.003c1.082,0,1.959-0.878,1.959-1.96V1.98C74.046,0.899,73.17,0.022,72.089,0.02z"/>
                                    </g>
                                </svg>
                            </a>
                            @php
                                $url=App\Models\Url::where(['title' => 'Instagram'])->get();
                            @endphp
                            @foreach ($url as $item)
                                <a href="{{"http://" . $item->url}}">
                                    @endforeach
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                         version="1.1"
                                         id="Capa_1" x="0px" y="0px"
                                         viewBox="0 0 97.395 97.395" style="enable-background:new 0 0 97.395 97.395;"
                                         xml:space="preserve">
                                    <g>
                                        <path d="M12.501,0h72.393c6.875,0,12.5,5.09,12.5,12.5v72.395c0,7.41-5.625,12.5-12.5,12.5H12.501C5.624,97.395,0,92.305,0,84.895   V12.5C0,5.09,5.624,0,12.501,0L12.501,0z M70.948,10.821c-2.412,0-4.383,1.972-4.383,4.385v10.495c0,2.412,1.971,4.385,4.383,4.385   h11.008c2.412,0,4.385-1.973,4.385-4.385V15.206c0-2.413-1.973-4.385-4.385-4.385H70.948L70.948,10.821z M86.387,41.188h-8.572   c0.811,2.648,1.25,5.453,1.25,8.355c0,16.2-13.556,29.332-30.275,29.332c-16.718,0-30.272-13.132-30.272-29.332   c0-2.904,0.438-5.708,1.25-8.355h-8.945v41.141c0,2.129,1.742,3.872,3.872,3.872h67.822c2.13,0,3.872-1.742,3.872-3.872V41.188   H86.387z M48.789,29.533c-10.802,0-19.56,8.485-19.56,18.953c0,10.468,8.758,18.953,19.56,18.953   c10.803,0,19.562-8.485,19.562-18.953C68.351,38.018,59.593,29.533,48.789,29.533z"
                                        />
                                    </g>
                                </svg>
                                </a>

                </div>
                <div>
                    просмотров :
                    @php
                        $counters = App\Models\UserCounter::orderBy('timestamp')->count();
                     echo $counters;
                    @endphp
                </div>
                <br>
                <div>
                    просмотров за месяц:
                    @php
                        $lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
                        $counters_month = App\Models\UserCounter::where('timestamp', '>' ,$lastmonth)->count();
                        echo $counters_month;
                    @endphp
                </div>
            </div>
        </div>
    </div>
</section>

<script src="{{ asset('js/app.js')}}"></script>
<script src='{{ asset ("button-visually-impaired/js/responsivevoice.min.js") }}'></script>
<script src="{{ asset ("button-visually-impaired/js/bvi-init-panel.js") }}"></script>
<script src="{{ asset ("button-visually-impaired/js/bvi.min.js") }}"></script>
<script src="{{ asset ("button-visually-impaired/js/js.cookie.js") }}"></script>

@if (session('status'))
    <script>
        $(document).ready(function () {
            $('#overlay').fadeIn(400, function () {
                $('#modal')
                    .css('display', 'block')
                    .animate({opacity: 1}, 200);
            });

            $('#modal_close, #overlay').click(function () {
                $('#modal')
                    .animate({opacity: 0, top: '45%'}, 200,
                        function () {
                            $(this).css('display', 'none');
                            $('#overlay').fadeOut(400);
                        }
                    );
            });
            $("#modal .enrolleeNumber").text('{{ session('status') }}');
        });
    </script>
@endif
<script>
    $('.partners-slider').slick({
        autoplay: true,
        slidesToShow: 4,
        prevArrow: '<span class="sliderArrow partnersTop prev"><img class="sliderPrev" src="{{asset('/img/check1.png')}}"></span>',
        nextArrow: '<span class="sliderArrow partnersTop next"><img class="sliderNext" src="{{asset('/img/check2.png')}}"></span>',
        responsive: [{
            breakpoint: 980,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
                dots: false
            }
        },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: false,
                    arrows: false
                }
            }
        ]
    });
</script>
<script>
    $(document).ready(function () {
        $('.lk-items a').each(function () {
            if (location.href == $(this).attr('href')) {
                $(this).addClass('active-profile');
            } else {
                $(this).removeClass('action-profile');
            }
        })
    });


    $(document).ready(function(){
        if(window.matchMedia("(max-width: 960px)").matches) {
            $('#header-person-profile').click(function(e){
                e.preventDefault();
            })
        }
    });

</script>
</body>
</html>
