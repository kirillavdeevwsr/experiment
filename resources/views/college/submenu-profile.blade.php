<div class="profile-menu">

    <p class="dobro">Добро пожаловать в личный кабинет!</p>
    <div class="lk-items">
        <a class="action-profile" href="{{route('profile')}}">Мой аккаунт</a>
        @if(Session::get('user')['isStudent']===true)
        <a  href="{{route('assessments')}}">Оценки</a>
        {{--<a href="{{route('logout')}}">Выйти</a>--}}
        @endif
    </div>
</div>
