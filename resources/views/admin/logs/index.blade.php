@extends ('layouts/admin')
@section('content')
    <div>
        <h1>Журнал сайта</h1>
        <table class="table">
            <th>Дата</th>
            <th>Операция</th>
            <th>Объект</th>
            <th>Пользователь</th>
            @foreach($logs as $log)
            <tr>
                <td><b>{{$log->raw_date}}</b></td>
                    <td class="text-info">{{$log->operation}}</td>
                    @if (isset($log->object))
                        <td>{{ ($log->object_type=='banners') ? $log->object->alt : $log->object->title}}</td>
                    @else
                        <td style="font-size: 10px"><p class="text-warning" >(объект удален)</p><p>Идентификатор: <span class="text-dark">{{$log->object_id}}</span></p> </td>
                    @endif
                 <td>{{isset ($log->getUser) ? $log->getUser->full_name : $log->user}}</td>
            </tr>
            @endforeach
        </table>
        {{$logs->links()}}
    </div>
    @endsection