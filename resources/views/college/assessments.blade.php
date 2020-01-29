@extends('layouts.index')
@section('title')Успеваемость@endsection
@section ('content')
    <section id="profile">
        <div class="container">
            @include ('college.submenu-profile')
             <section id="ocenki">
                    <rates/>
            </section>
        </div>
@endsection