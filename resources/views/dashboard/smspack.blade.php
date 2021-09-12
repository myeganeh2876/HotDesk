@php
    $smsdata = \TCG\Voyager\Models\Sms::first();
@endphp
<div class="smspack">
    <h3>{{__('voyager::hotdesk.smspack')}}</h3>
    <div class="box">
        <ul>
            @if($smsdata)
                <li>{{__('voyager::hotdesk.smspack_qu')}}
                    <span>{{Auth::user()->locale == 'fa' ? fa_number($smsdata->stock) : $smsdata->stock}} {{__('voyager::hotdesk.smspack_sms')}}</span>
                </li>
                <li>{{__('voyager::hotdesk.smspack_sends')}}
                    <span>{{Auth::user()->locale == 'fa' ? fa_number($smsdata->sends) : $smsdata->sends}} {{__('voyager::hotdesk.smspack_sms')}}</span>
                </li>
                <li>{{__('voyager::hotdesk.smspack_totalsends')}}
                    <span>{{Auth::user()->locale == 'fa' ? fa_number($smsdata->totalsend) : $smsdata->totalsend}} {{__('voyager::hotdesk.smspack_sms')}}</span>
                </li>
            @endif
        </ul>
        <div class="actions">
            <button type="button" name="button" class="btn btn-blue" data-p="10000">
                <div class="loading">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                {{Auth::user()->locale == 'fa' ? '۱۰۰۰' : '1000'}}
            </button>
            <button type="button" name="button" class="btn btn-blue" data-p="50000">
                <div class="loading">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                {{Auth::user()->locale == 'fa' ? '۵۰۰۰' : '5000'}}</button>
            <input type="number" data-per="10" placeholder="{{__('voyager::hotdesk.smspack_manual')}}"/>
            <button type="button" name="button" class="btn btn-yellow pay">
                <div class="loading">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <span>{{__('voyager::hotdesk.smspack_pay')}}</span></button>
        </div>
    </div>
</div>
