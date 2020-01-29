@extends('layouts.admin')
@section('content')
    <div class="container">
        <h1>Упарвления баннерами</h1>
            <a href="{{route ('banners.create')}}">
                <button class="btn btn-info">Добавить новый</button>
            </a>
        <div class="row">
                @foreach($banners as $banner)
                           <div class="col-md-6 center">
                            <a style="display: block" href="{{route('banners.show', $banner->id)}}">
                                <img style="width: 100%" src="{{$banner->img}}" alt="{{$banner->alt}}">
                            </a>
                        </div>
        @endforeach
            </div>
    </div>
@endsection