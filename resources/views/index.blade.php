@extends('voyager::master')

@section('content')
    @if (session('status'))
        <div class="alert dashboardalert @if(session('success')==true) success @else error @endif">
            {{ session('status') }}
        </div>
    @endif
    @if (@\TCG\Voyager\Models\Sms::first()->stock<=30)
        <div class="alert dashboardalert">
            {{__('voyager::hotdesk.lowsms')}}
        </div>
    @endif
    <div class="dashboard">
        <div class="notifications">
            <h3>{{__('voyager::hotdesk.notifications')}}</h3>
            @if(Auth::user()->unreadsupport()->exists())
                <a href="{{route('voyager::voyager.supports.index')}}" title=""
                   class="messages">{{Auth::user()->unreadsupport()->count()}} {{__('voyager::hotdesk.notifications_unreadmessage')}}</a>
            @endif

        </div>
        <div class="chart">
            <h3>{{__('voyager::hotdesk.chart')}}</h3>
            <div class="box">
                <ul>
                    <li class="active" data-id="users"
                        data-info="{{Auth::user()->locale=='fa' ? fa_number(App\Models\User::count()) : App\Models\User::count()}} {{__('voyager::hotdesk.user')}}">{{__('voyager::hotdesk.users')}}</li>
                    <li data-id="orders"
                        data-info="{{Auth::user()->locale=='fa' ? fa_number(\TCG\Voyager\Models\Transaction::where([['product_id','!=','0'],['status','=','success']])->count()) : \TCG\Voyager\Models\Transaction::where([['product_id','!=','0'],['status','=','success']])->count()}} {{__('voyager::hotdesk.sells')}}">{{__('voyager::hotdesk.sells')}}</li>
                </ul>
                <span>{{Auth::user()->locale=='fa' ? fa_number(App\Models\User::count()) : App\Models\User::count()}} {{__('voyager::hotdesk.user')}}</span>
                <canvas id="userchart" width="100%" height="160px"></canvas>
            </div>
        </div>
        <div class="clear"></div>
        <div class="tools">
            @include('voyager::dashboard.smspack')
            @include('voyager::dashboard.personalizemenus')
        </div>
    </div>
@endsection
