@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.$dataType->getTranslatedAttribute('display_name_plural'))

@section('page_header')
    <div class="action">
        @can('delete', app($dataType->model_name))
            @include('voyager::partials.bulk-delete')
        @endcan
        @can('edit', app($dataType->model_name))
            @if(isset($dataType->order_column) && isset($dataType->order_display_column))
                <a href="{{ route('voyager.'.$dataType->slug.'.order') }}" class="btn btn-blue">
                    <i class="voyager-list"></i> <span>{{ __('voyager::bread.order') }}</span>
                </a>
            @endif
        @endcan
        @can('delete', app($dataType->model_name))
            @if($usesSoftDeletes)
                <input type="checkbox" @if ($showSoftDeleted) checked @endif id="show_soft_deletes" data-toggle="toggle" data-on="{{ __('voyager::bread.soft_deletes_off') }}" data-off="{{ __('voyager::bread.soft_deletes_on') }}">
            @endif
        @endcan
        @foreach($actions as $action)
            @if (method_exists($action, 'massAction'))
                @include('voyager::bread.partials.actions', ['action' => $action, 'data' => null])
            @endif
        @endforeach
        @include('voyager::multilingual.language-selector')
    </div>
@stop

@section('content')
    <div class="bread">
        @include('voyager::alerts')

                        @if ($isServerSide)
                            <form method="get" class="form-search">
                              <div class="filters">
                                  <div class="form-group select">
                                    <div class="select">
                                        <select id="search_key" name="key" data-placeholder="{{__('hotdesk.content_search_key')}}">
                                            @foreach($searchNames as $key => $name)
                                                <option value="{{ $key }}" @if($search->key == $key || (empty($search->key) && $key == $defaultSearchKey)) selected @endif>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group select">
                                      <div class="select">
                                        <select id="filter" name="filter" data-placeholder="{{__('hotdesk.content_search_filter')}}" data-minimum-results-for-search="Infinity">
                                            <option value="contains" @if($search->filter == "contains") selected @endif>contains</option>
                                            <option value="equals" @if($search->filter == "equals") selected @endif>=</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="form-group search">
                                      <input type="text" class="form-control" placeholder="{{ __('voyager::generic.search') }}" name="s" value="{{ $search->value }}">
                                    </div>
                                    <div class="button-group">
                                      <button class="btn btn-blue search" name="button" type="submit">
                                        {{__('hotdesk.content_search_list')}}
                                      </button>
                                    </div>

                                @if (Request::has('sort_order') && Request::has('order_by'))
                                    <input type="hidden" name="sort_order" value="{{ Request::get('sort_order') }}">
                                    <input type="hidden" name="order_by" value="{{ Request::get('order_by') }}">
                                @endif
                                </div>
                            </form>
                        @endif
                        @php
                        $types = [
                          "replied"=> __('hotdesk.support_replied'),
                          "waiting"=>  __('hotdesk.support_waiting'),
                          "new"=>  __('hotdesk.support_new'),
                          "closed"=>  __('hotdesk.support_closed')
                        ];
                        @endphp
                        <div class="info">
                          @foreach($types as $type => $name)
                          <span>{{__('hotdesk.support_ticket')}} {{$name}} {{Auth::user()->Locale == 'fa' ? fa_number(App\Models\Support::where('status',$type)->count()) : App\Models\Support::where('status',$type)->count()}}</span>
                          @endforeach
                        </div>
                        <div class="table-responsive">
                            <table id="dataTable" class="table">
                                <thead>
                                    <tr>
                                        @if($showCheckboxColumn)
                                            <th>
                                              <div class="select">
                                                <input id="selectall" class="checkbox select select_all" type="checkbox" />
                                                <label for="selectall"></label>
                                              </div>
                                            </th>
                                        @endif
                                        @foreach($dataType->browseRows as $row)
                                        @if($row->field == "support_belongsto_user_relationship")
                                        <th>
                                          {{__('hotdesk.support_picture')}}
                                        </th>
                                        @endif
                                        <th>
                                            @if ($isServerSide)
                                                <a href="{{ $row->sortByUrl($orderBy, $sortOrder) }}">
                                            @endif
                                            {{ $row->getTranslatedAttribute('display_name') }}
                                            @if ($isServerSide)
                                                @if ($row->isCurrentSortField($orderBy))
                                                    @if ($sortOrder == 'asc')
                                                        <i class="voyager-angle-up pull-right"></i>
                                                    @else
                                                        <i class="voyager-angle-down pull-right"></i>
                                                    @endif
                                                @endif
                                                </a>
                                            @endif
                                        </th>
                                        @endforeach
                                        <th class="actions text-right">{{ __('voyager::generic.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataTypeContent as $data)
                                    <tr>
                                        @if($showCheckboxColumn)
                                            <td>
                                              <div class="select">
                                                <input id="checkbox_{{ $data->getKey() }}" class="checkbox select" type="checkbox" value="{{ $data->getKey() }}" />
                                                <label for="checkbox_{{ $data->getKey() }}"></label>
                                              </div>
                                            </td>
                                        @endif
                                        @foreach($dataType->browseRows as $row)
                                            @php
                                            if ($data->{$row->field.'_browse'}) {
                                                $data->{$row->field} = $data->{$row->field.'_browse'};
                                            }
                                            @endphp
                                            @if($row->field == "support_belongsto_user_relationship")
                                              <td>
                                                @php
                                                  $user_avatar = '';
                                                  if($data->user()->exists()){
                                                    if (\Illuminate\Support\Str::startsWith($data->user->avatar, 'http://') || \Illuminate\Support\Str::startsWith($data->user->avatar, 'https://')) {
                                                        $user_avatar = $data->user->avatar;
                                                    } else {
                                                        $user_avatar = Voyager::image($data->user->avatar);
                                                    }
                                                  }
                                                @endphp
                                                <div class="avatar">
                                                  <img src="{{$user_avatar}}" width="54px" height="54px" onerror="this.onerror=null;this.src='/assets/images/avatar_big.png';" />
                                                </div>
                                              </td>
                                            @endif
                                            <td>
                                                @if (isset($row->details->view))
                                                    @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $data->{$row->field}, 'action' => 'browse', 'view' => 'browse', 'options' => $row->details])
                                                @elseif($row->type == 'image')
                                                    <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                @elseif($row->type == 'relationship')
                                                    @include('voyager::formfields.relationship', ['view' => 'browse','options' => $row->details])
                                                @elseif($row->type == 'select_multiple')
                                                    @if(property_exists($row->details, 'relationship'))

                                                        @foreach($data->{$row->field} as $item)
                                                            {{ $item->{$row->field} }}
                                                        @endforeach

                                                    @elseif(property_exists($row->details, 'options'))
                                                        @if (!empty(json_decode($data->{$row->field})))
                                                            @foreach(json_decode($data->{$row->field}) as $item)
                                                                @if (@$row->details->options->{$item})
                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ __('voyager::generic.none') }}
                                                        @endif
                                                    @endif

                                                    @elseif($row->type == 'multiple_checkbox' && property_exists($row->details, 'options'))
                                                        @if (@count(json_decode($data->{$row->field})) > 0)
                                                            @foreach(json_decode($data->{$row->field}) as $item)
                                                                @if (@$row->details->options->{$item})
                                                                    {{ $row->details->options->{$item} . (!$loop->last ? ', ' : '') }}
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ __('voyager::generic.none') }}
                                                        @endif

                                                @elseif(($row->type == 'select_dropdown' || $row->type == 'radio_btn') && property_exists($row->details, 'options'))
                                                  @if($row->field=='status')
                                                    @php
                                                      $types = [
                                                        "replied"=> "green",
                                                        "waiting"=>  "yellow",
                                                        "new"=>  "red",
                                                        "closed"=>  "gray"
                                                      ];
                                                    @endphp
                                                  <span class="status {{$types[$data->{$row->field}]}}">
                                                    {!! $row->details->options->{$data->{$row->field}} ?? '' !!}
                                                  </span>
                                                  @else
                                                    {!! $row->details->options->{$data->{$row->field}} ?? '' !!}
                                                  @endif
                                                @elseif($row->type == 'date' || $row->type == 'timestamp')
                                                <span class="date">
                                                    @if ( property_exists($row->details, 'format') && !is_null($data->{$row->field}) )
                                                        @if(Auth::user()->Locale =='fa')
                                                          {{ \Morilog\Jalali\Jalalian::forge($data->messages()->orderby('created_at','desc')->first()->{$row->field})->ago() }}
                                                        @else
                                                          {{ \Carbon\Carbon::parse($data->messages()->orderby('created_at','desc')->first()->{$row->field})->diffForHumans() }}
                                                        @endif
                                                    @else
                                                        @if(Auth::user()->Locale =='fa')
                                                          {{ \Morilog\Jalali\Jalalian::forge($data->messages()->orderby('created_at','desc')->first()->{$row->field})->ago() }}
                                                        @else
                                                          {{ \Carbon\Carbon::parse($data->messages()->orderby('created_at','desc')->first()->{$row->field})->diffForHumans() }}
                                                        @endif

                                                    @endif
                                                </span>
                                                @elseif($row->type == 'checkbox')
                                                    @if(property_exists($row->details, 'on') && property_exists($row->details, 'off'))
                                                        @if($data->{$row->field})
                                                            <span class="label label-info">{{ $row->details->on }}</span>
                                                        @else
                                                            <span class="label label-primary">{{ $row->details->off }}</span>
                                                        @endif
                                                    @else
                                                    {{ $data->{$row->field} }}
                                                    @endif
                                                @elseif($row->type == 'color')
                                                    <span class="badge badge-lg" style="background-color: {{ $data->{$row->field} }}">{{ $data->{$row->field} }}</span>
                                                @elseif($row->type == 'text')
                                                    @if($row->field=='message_count')
                                                    <span class="message {{$data->id}} @if(Auth::user()->unreadsupport->contains($data->id)) new @endif">{{ $data->{$row->field} }} {{__('hotdesk.support_new_message')}}</span>
                                                    @else
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                    @endif
                                                @elseif($row->type == 'text_area')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( $data->{$row->field} ) > 200 ? mb_substr($data->{$row->field}, 0, 200) . ' ...' : $data->{$row->field} }}</div>
                                                @elseif($row->type == 'file' && !empty($data->{$row->field}) )
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    @if(json_decode($data->{$row->field}) !== null)
                                                        @foreach(json_decode($data->{$row->field}) as $file)
                                                            <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($file->download_link) ?: '' }}" target="_blank">
                                                                {{ $file->original_name ?: '' }}
                                                            </a>
                                                            <br/>
                                                        @endforeach
                                                    @else
                                                        <a href="{{ Storage::disk(config('voyager.storage.disk'))->url($data->{$row->field}) }}" target="_blank">
                                                            Download
                                                        </a>
                                                    @endif
                                                @elseif($row->type == 'rich_text_box')
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <div>{{ mb_strlen( strip_tags($data->{$row->field}, '<b><i><u>') ) > 200 ? mb_substr(strip_tags($data->{$row->field}, '<b><i><u>'), 0, 200) . ' ...' : strip_tags($data->{$row->field}, '<b><i><u>') }}</div>
                                                @elseif($row->type == 'coordinates')
                                                    @include('voyager::partials.coordinates-static-image')
                                                @elseif($row->type == 'multiple_images')
                                                    @php $images = json_decode($data->{$row->field}); @endphp
                                                    @if($images)
                                                        @php $images = array_slice($images, 0, 3); @endphp
                                                        @foreach($images as $image)
                                                            <img src="@if( !filter_var($image, FILTER_VALIDATE_URL)){{ Voyager::image( $image ) }}@else{{ $image }}@endif" style="width:50px">
                                                        @endforeach
                                                    @endif
                                                @elseif($row->type == 'media_picker')
                                                    @php
                                                        if (is_array($data->{$row->field})) {
                                                            $files = $data->{$row->field};
                                                        } else {
                                                            $files = json_decode($data->{$row->field});
                                                        }
                                                    @endphp
                                                    @if ($files)
                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                            <img src="@if( !filter_var($file, FILTER_VALIDATE_URL)){{ Voyager::image( $file ) }}@else{{ $file }}@endif" style="width:50px">
                                                            @endforeach
                                                        @else
                                                            <ul>
                                                            @foreach (array_slice($files, 0, 3) as $file)
                                                                <li>{{ $file }}</li>
                                                            @endforeach
                                                            </ul>
                                                        @endif
                                                        @if (count($files) > 3)
                                                            {{ __('voyager::media.files_more', ['count' => (count($files) - 3)]) }}
                                                        @endif
                                                    @elseif (is_array($files) && count($files) == 0)
                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                    @elseif ($data->{$row->field} != '')
                                                        @if (property_exists($row->details, 'show_as_images') && $row->details->show_as_images)
                                                            <img src="@if( !filter_var($data->{$row->field}, FILTER_VALIDATE_URL)){{ Voyager::image( $data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:50px">
                                                        @else
                                                            {{ $data->{$row->field} }}
                                                        @endif
                                                    @else
                                                        {{ trans_choice('voyager::media.files', 0) }}
                                                    @endif
                                                @else
                                                    @include('voyager::multilingual.input-hidden-bread-browse')
                                                    <span>{{ $data->{$row->field} }}</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        <td class="no-sort no-click" id="bread-actions">
                                          @php
                                            $class = get_class($actions[2]);
                                            $action = new $class($dataType, $data);
                                          @endphp

                                            <button class="openchat" data-id="{{$data->id}}" data-banned="{{App\Models\Banneduser::where('user_id',$data->user_id)->exists() ? 'true' : 'false'}}" data-locked="{{$data->status == 'closed' ? 'true' : 'false'}}" data-name="{{$data->client ?  $data->client->first_name : ''}}" data-editurl="{{ $action->getRoute($dataType->name) }}"></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if ($isServerSide)
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">{{ trans_choice(
                                    'voyager::generic.showing_entries', $dataTypeContent->total(), [
                                        'from' => $dataTypeContent->firstItem(),
                                        'to' => $dataTypeContent->lastItem(),
                                        'all' => $dataTypeContent->total()
                                    ]) }}</div>
                            </div>
                            <div class="pull-right">
                                {{ $dataTypeContent->appends([
                                    's' => $search->value,
                                    'filter' => $search->filter,
                                    'key' => $search->key,
                                    'order_by' => $orderBy,
                                    'sort_order' => $sortOrder,
                                    'showSoftDeleted' => $showSoftDeleted,
                                ])->links() }}
                            </div>
                        @endif
                    </div>
    </div>
    <div class="replaychat">
      <div class="chat">
        <div class="template">
          <h3>{{__('hotdesk.support_template')}}</h3>
          <div class="sendbox">
            <textarea placeholder="{{__('hotdesk.support_messagetxt')}}"></textarea>
            <button disabled><svg xmlns="http://www.w3.org/2000/svg" width="24" height="20.006" viewBox="0 0 24 20.006">
                <g transform="translate(24 -0.026) rotate(180)">
                  <path d="M-.986,1.971h-1.5A.986.986,0,0,1-3.473.986.986.986,0,0,1-2.488,0h1.5A.986.986,0,0,1,0,.986.986.986,0,0,1-.986,1.971Z" transform="translate(0 -1.529) rotate(-180)" fill="#52c0ef" />
                  <path d="M-3.473.986A.986.986,0,0,1-2.488,0h1.5A.986.986,0,0,1,0,.986a.986.986,0,0,1-.986.986h-1.5A.986.986,0,0,1-3.473.986Z" transform="translate(0 -11.542) rotate(-180)" fill="#52c0ef" />
                  <path
                    d="M-22.475,9.128-5.452.116A.986.986,0,0,1-4.005.987V5.008h3A1,1,0,0,1,0,5.957.986.986,0,0,1-.986,6.979h-3.02v.515A1.127,1.127,0,0,1-5,8.614l-8.113.936a.452.452,0,0,0,0,.9L-5,11.384a1.126,1.126,0,0,1,1,1.119v2.518h3A1,1,0,0,1,0,15.971a.986.986,0,0,1-.985,1.022h-3.02v2.182A.815.815,0,0,1-4.945,20c-.519-.06,1.494.942-17.53-9.129a.986.986,0,0,1,0-1.742Z"
                    transform="translate(1.001 -0.026) rotate(-180)" fill="#52c0ef" />
                </g>
              </svg></button>
          </div>
          <div class="templates">
            <h4>{{__('hotdesk.support_templates')}}</h4>
            <div class="list mCustomScrollbar" data-mcs-theme="dark">
              @foreach(Auth::user()->messagetemplate()->orderby('created_at','desc')->get() as $messagetemplate)
              <div class="item">
                <p>{{$messagetemplate->content}}</p>
                <div class="action">
                  <button type="button" class="deletetemplate" data-id="{{$messagetemplate->id}}"></button>
                </div>
              </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="chatbox">
          <div class="head">
            <div class="action">
              <button type="button" class="closechat"></button>
              <a href="#" title="" class="openchat"></a>
              <button type="button" class="lockchat"></button>
            </div>
            <span></span><i class="voyager-basket" title="{{__('hotdesk.support_banuser')}}"></i>
          </div>
          <div class="messages  mCustomScrollbar" data-mcs-theme="dark">
          </div>
          <div class="sendbox">
            <textarea placeholder="{{__('hotdesk.support_messagetxt')}}"></textarea>
            <button disabled><svg xmlns="http://www.w3.org/2000/svg" width="24" height="20.006" viewBox="0 0 24 20.006">
                <g transform="translate(24 -0.026) rotate(180)">
                  <path d="M-.986,1.971h-1.5A.986.986,0,0,1-3.473.986.986.986,0,0,1-2.488,0h1.5A.986.986,0,0,1,0,.986.986.986,0,0,1-.986,1.971Z" transform="translate(0 -1.529) rotate(-180)" fill="#52c0ef" />
                  <path d="M-3.473.986A.986.986,0,0,1-2.488,0h1.5A.986.986,0,0,1,0,.986a.986.986,0,0,1-.986.986h-1.5A.986.986,0,0,1-3.473.986Z" transform="translate(0 -11.542) rotate(-180)" fill="#52c0ef" />
                  <path
                    d="M-22.475,9.128-5.452.116A.986.986,0,0,1-4.005.987V5.008h3A1,1,0,0,1,0,5.957.986.986,0,0,1-.986,6.979h-3.02v.515A1.127,1.127,0,0,1-5,8.614l-8.113.936a.452.452,0,0,0,0,.9L-5,11.384a1.126,1.126,0,0,1,1,1.119v2.518h3A1,1,0,0,1,0,15.971a.986.986,0,0,1-.985,1.022h-3.02v2.182A.815.815,0,0,1-4.945,20c-.519-.06,1.494.942-17.53-9.129a.986.986,0,0,1,0-1.742Z"
                    transform="translate(1.001 -0.026) rotate(-180)" fill="#52c0ef" />
                </g>
              </svg></button>
          </div>
        </div>
      </div>
    </div>
    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('voyager::generic.delete_confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('css')
@if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
    <link rel="stylesheet" href="{{ voyager_asset('lib/css/responsive.dataTables.min.css') }}">
@endif
@stop

@section('javascript')
    <!-- DataTables -->
    @if(!$dataType->server_side && config('dashboard.data_tables.responsive'))
        <script src="{{ voyager_asset('lib/js/dataTables.responsive.min.js') }}"></script>
    @endif
    <script>
        $(document).ready(function () {
            @if (!$dataType->server_side)
                var table = $('#dataTable').DataTable({!! json_encode(
                    array_merge([
                        "order" => $orderColumn,
                        "language" => __('datatable'),
                        "columnDefs" => [['targets' => -1, 'searchable' =>  false, 'orderable' => false]],
                        "dom"=> '<"filters"f><"datatableserv"rt><"bottom"pli><"clear">'
                    ],
                    config('voyager.dashboard.data_tables', []))
                , true) !!});
            @else
                $('#search-input select').select2({
                    minimumResultsForSearch: Infinity
                });
            @endif

            @if ($isModelTranslatable)
                $('.layout .main .inside').multilingual();
                //Reinitialise the multilingual features when they change tab
                $('#dataTable').on('draw.dt', function(){
                    $('.layout .main .inside').data('multilingual').init();
                })
            @endif
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });
        });
        $(document).on( 'preInit.dt', function (settings, json) {
            $('div.dataTables_length select').select2();
            $('div.dataTables_length').addClass('form-group').addClass('select');
            $('div.dataTables_length label').addClass('select');
            $('.dataTables_wrapper .dataTables_filter').addClass('form-group').addClass('search');
            $('.dataTables_wrapper .dataTables_filter input[type=search]').attr('placeholder','{{__('hotdesk.bread_search')}}');
            $('.table-responsive').addClass('notserverside');
        });
        var deleteFormAction;
        $('td').on('click', '.delete', function (e) {
            $('#delete_form')[0].action = '{{ route('voyager.'.$dataType->slug.'.destroy', '__id') }}'.replace('__id', $(this).data('id'));
            $('#delete_modal').modal('show');
        });

        @if($usesSoftDeletes)
            @php
                $params = [
                    's' => $search->value,
                    'filter' => $search->filter,
                    'key' => $search->key,
                    'order_by' => $orderBy,
                    'sort_order' => $sortOrder,
                ];
            @endphp
            $(function() {
                $('#show_soft_deletes').change(function() {
                    if ($(this).prop('checked')) {
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 1]), true)) }}"></a>');
                    }else{
                        $('#dataTable').before('<a id="redir" href="{{ (route('voyager.'.$dataType->slug.'.index', array_merge($params, ['showSoftDeleted' => 0]), true)) }}"></a>');
                    }

                    $('#redir')[0].click();
                })
            })
        @endif
        $('input[name="row_id"]').on('change', function () {
            var ids = [];
            $('input[name="row_id"]').each(function() {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);
        });
    </script>
@stop
