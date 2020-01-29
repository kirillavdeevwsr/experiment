@if($page->status != 2)
    <li>
        @if(count($page['children'])>0)
            <div class="d-flex flex-row justify-content-between burger-item">
                <a href="{{route ('show_page', $page->slug)}}" class="d-flex justify-content-center w-100">
                    <div class="d-flex justify-content-center align-items-center">
                        {{$page->title}}
                    </div>
                </a>
                <div class="d-flex justify-content-center align-items-center burger-item-arrow">
                    <span class="drop-icon">▾</span>
                    <label class="drop-icon align-self-center" for={{$page->slug}}>▾</label>
                </div>
            </div>
        @else
            <div class="d-flex flex-row justify-content-center burger-item">
                <a href="{{route ('show_page', $page->slug)}}" class="d-flex d-block justify-content-center" style="padding-right: 50px;">
                    <div class="d-flex justify-content-center align-items-center">
                        {{$page->title}}
                    </div>
                </a>
            </div>
        @endif
        @if(count($page['children'])>0)
            <input type="checkbox" id={{$page->slug}}>
            <ul class="burger-sub-menu-items">
                @foreach($page['children'] as $page)
                    @include('burger-submenu', $page)
                @endforeach
            </ul>
        @endif
    </li>
@endif