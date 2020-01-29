@extends('layouts.admin')
@section ('content')
    <div>
        <h1>Управления страницами</h1>
        <div class="form_button">
            <a href="{{route('page.create')}}"><button class="btn btn-success">Добавить</button></a>
        </div>
        <table class="table">
            <th><h3>Заголовок страницы</h3></th>
            <th><h3>Статус</h3></th>
            <th><h3>Действия</h3></th>


        @foreach($pages as $page)
           <tr>
               @if($page->parent == 0)
                <td>{{$page->title}}</td>
               @else
                   <td><a class="" href="{{route('page.show', $page->id)}}">{{$page->title}}</a></td>

               @endif
                   <td>{{$page->getStatus->name}}</td>
                <td>
                    <a href="{{route ('page.edit', $page->id)}}">
                        <button class="btn btn-info">Редактировать</button>
                    </a>
                    <br>
                    <form action="{{route ('page.destroy', $page->id)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                        <input  type="submit" class="btn btn-danger" value=" Удалить">
                    </form>

                </td>
                {{--@foreach($page->childrens as $child)--}}
                    {{--<li>--}}
                        {{--<a href="{{route('page.show', $child->id)}}">{{$child->title}}</a>--}}
                    {{--</li>--}}
                {{--@endforeach--}}
           </tr>
            @endforeach
        </table>

    </div>
@endsection