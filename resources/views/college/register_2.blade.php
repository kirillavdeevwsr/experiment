@extends('layouts.index')
@section('title') Регистрация @endsection
@section('content')
    <register-component :action="{{json_encode(route('register_2_post'))}}" :csrf="{{json_encode(csrf_token())}}"></register-component>
@endsection
