<div class="sidebar">
    <a href="{{ route('voyager.profile') }}" title="profile" class="avatar">
        <img src="{{ $user_avatar }}" class="avatar"
             alt="{{ Auth::user()->name }} avatar"
             data-s="{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}">
    </a>
    <ul>
        {!! menu('admin', 'voyager::menu.sidebarmenu') !!}
        <li>
            <form action="{{ route('voyager.logout') }}" method="POST">
                {{ csrf_field() }}
                <button type="submit" title="{{__('voyager::hotdesk.sidebar_logout')}}">
                    <i class="voyager-power"></i>
                </button>
            </form>
        </li>
    </ul>
</div>
