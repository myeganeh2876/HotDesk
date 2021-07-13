<div class="quickaccess">
    <div class="head">
        <h3>{{__('voyager::hotdesk.quickaccess')}}</h3>
        <span><b>{{__('voyager::hotdesk.quickaccess_delete')}}</b></span>
    </div>
    <div class="list mCustomScrollbar" data-mcs-theme="dark">
        <ul>
            @if(Auth::user()->personalizemenu()->exists() && count(Auth::user()->personalizemenu->data))
                @foreach(Auth::user()->personalizemenu->data as $menu)
                    <li><a href="{{$menu['link']}}" target="{{$menu['target']}}">{{$menu['title']}}</a></li>
                @endforeach
            @endif

        </ul>
    </div>
</div>

