@if (count($menu->children))
    <li class="jstree-checked" aria-selected="true" data-id="{{$menu->id}}">
        {{$menu->title}}
        <small>(Alias: {{ $menu->present()->url }})</small>
        <ul>
            @foreach($menu->children as $child)
                @include('administrator.widgets.partials.menu-item', ['menu' => $child])
            @endforeach
        </ul>
    </li>
@else
    <li class="jstree-checked" aria-selected="true" data-id="{{$menu->id}}">
        {{$menu->title}}
        <small>(Alias: {{ $menu->present()->url }})</small>
    </li>
@endif
