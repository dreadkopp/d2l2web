<ul class="nav navbar-nav">
    @foreach($items as $menu_item)
        <li>
            <a href="{{ $menu_item->url }}"><i class="{{$menu_item->icon_class}}"></i>  {{ $menu_item->title }}</a>
        </li>
    @endforeach
</ul>