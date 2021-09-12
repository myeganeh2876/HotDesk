
<div class="layout">
    {{--    @include('voyager::dashboard.sidebar')--}}

    <div class="main">
        <div class="inside">
            <div class="header">
                <button type="button" class="opennotes"></button>
                <a href="" title="" class="logo">HotDesk</a>
                <button type="button" class="openmenu"></button>
                @include('voyager::dashboard.navbar')
                @yield('page_header')
            </div>
            <div class="clear"></div>
            <div class="content">
                @yield('content')
                @include('voyager::dashboard.notes')
            </div>
        </div>
        <div class="itemdrag">
            <ul></ul>
        </div>
    </div>
