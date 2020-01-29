@if($page->status != 2)
    <li class={{($page->parent==0) ? "menu-list": "" }}>
        <a href="{{route ('show_page', $page->slug)}}">{{$page->title}}</a>
        @if(count($page['children'])>0)
            <ul class={{($page->parent ==0) ? "menu-drop":"menu-left"}}>
                @foreach($page['children'] as $page)
                    @include('submenu', $page)
                    @endforeach
            </ul>
        @endif
    </li>
@endif