@extends('layouts/index')
@section('title')Вход в личный кабинет@endsection
@section('content')
    <login-component :csrf="{{ json_encode(csrf_token()) }}" :url="{{json_encode(route('login_post'))}}"></login-component>
@endsection