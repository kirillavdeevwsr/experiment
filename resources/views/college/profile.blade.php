@extends ('layouts.index')
@section('title')Личная страница@endsection
@section('content')
    <section id="profile">
        <div class="container">
{{--            @include ('college.submenu-profile')--}}


            <div class="lk-content">
                <div class="lk-content-profile">
                    <h3>Мой профиль</h3>

                    <div class="profile-info">
{{--                        <div class="profile-info-avatar">--}}
{{--                            --}}{{--                        <img src="{!! $user['image'] !!}" alt="Фото в личном кабинете">--}}
{{--                        </div>--}}
                        <div class="profile-info-fields">
                            <table>
                                <tr>
                                    <td>Фамилия:</td>
                                    <td>{{$user->surname}}</td>
                                </tr>
                                <tr>
                                    <td>Имя:</td>
                                    <td>{{$user->name}}</td>
                                </tr>

                                <tr>
                                    <td>Отчество:</td>
                                    <td>{{$user->patronymic}}</td>
                                </tr>
                                <tr>
                                    <td>Дата рождения:</td>
                                    <td>{{\Jenssegers\Date\Date::parse($user->additionalStudent->birthday)->format('d F Y')}}</td>
                                </tr>
                                <tr>
                                    <td>Отделение:</td>
                                    <td>{{$user->additionalStudent->department ? $user->additionalStudent->department->name: ''}}</td>
                                </tr>
                                <tr>
                                    <td>Специальность:</td>
                                    <td>{{$user->additionalStudent->specialty ? $user->additionalStudent->specialty->name: ''}}</td>
                                </tr>
                                <tr>
                                    <td>Группа:</td>
                                    <td>{{$user->additionalStudent->group ? $user->additionalStudent->group->name: ''}}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>{{$user->email}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section id="raspisanie">
        <schedule/>
    </section>


@endsection

