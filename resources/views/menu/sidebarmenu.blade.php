@php

    if (Voyager::translatable($items)) {
        $items = $items->load('translations');
    }

@endphp
@foreach($items as $menu_item)
    @php
        if (Voyager::translatable($menu_item)) {
            $menu_item = $menu_item->translate($options->locale);
        }
        if($menu_item->route!="" && !Auth::user()->hasPermission(str_replace('-','_',"browse_".str_replace(['voyager.','.index'],'',$menu_item->route))) && $menu_item->route!="voyager.dashboard")
          continue;
        $links = [url($menu_item->link())];
        $permission = 0;
    @endphp

    @foreach($menu_item->children as $item)
        @php
            if($item->route!="" && !Auth::user()->hasPermission(str_replace('-','_',"browse_".str_replace(['voyager.','.index'],'',$item->route))) && $item->route!="voyager.dashboard")
              continue;
            $links[] = url($item->link());
            $permission++;
        @endphp
    @endforeach

    @if($permission==0 && count($menu_item->children))
        @php continue; @endphp
    @endif
    <li @if(in_array(url()->current(),$links)) class="active" @endif>


        <button type="button" title="{{$menu_item->title}}">
            @if(preg_match('/<svg/', $menu_item->icon_class, $output_array))
                {!!$menu_item->icon_class!!}
            @elseif($menu_item->icon_class)
                <i class="{{$menu_item->icon_class}}"></i>
            @else
                <i class="voyager-helm"></i>
            @endif
        </button>


        <div class="submenu">
            <button type="button" class="closemenu"></button>
            <ul>
                @if(!count($menu_item->children))<li><a href="{{$menu_item->link()}}" target="{{$menu_item->target}}">{{$menu_item->title}}</a></li>@endif
                @foreach($menu_item->children as $item)
                    @php
                        if($item->route!="" && !Auth::user()->hasPermission(str_replace('-','_',"browse_".str_replace(['voyager.','.index'],'',$item->route))) && $item->route!="voyager.dashboard")
                          continue;
                        if (Voyager::translatable($item)) {
                            $item = $item->translate($options->locale);
                        }
                    @endphp
                    <li><a href="{{ $item->link()}}" target="{{$item->target}}">{{$item->title}}</a></li>
                @endforeach
            </ul>
        </div>


    </li>
@endforeach
