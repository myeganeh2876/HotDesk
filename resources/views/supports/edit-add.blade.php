@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="content">
        <div class="post">
          <div class="support">
            <div class="replay">
              @if($edit)
              <span class="title">{{__('hotdesk.support_sendreplyto')}} <a href="/admin/users/{{$dataTypeContent->user_id}}/edit">{{$dataTypeContent->user->name}}</a></span>
              @else
              <span class="title">{{__('hotdesk.support_newmessage')}}</span>
              @endif
              <div class="box">
                @if(!$edit)
                @php
                        $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                        $row = $dataTypeRows[1];
                        $display_options = $row->details->display ?? NULL;
                        if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                            $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                        }
                    @endphp
                <div class="form-group gray username @if($row->type == 'select_dropdown' || $row->type == 'select_multiple' || $row->type == 'relationship') select @endif @if($row->type == 'hidden') hidden @endif  {{ $errors->has($row->field) ? 'invalid' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                    {{ $row->slugify }}
                    <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                    @if (isset($row->details->view))
                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                    @elseif ($row->type == 'relationship')
                        @include('voyager::formfields.relationship', ['options' => $row->details])
                    @else
                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                    @endif

                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                    @endforeach
                    @if ($errors->has($row->field))
                        @foreach ($errors->get($row->field) as $error)
                            <div class="invalid-feedback">{{ $error }}</div>
                        @endforeach
                    @endif
                </div>
                @endif
                <div class="form-group gray">
                  <label>{{__('hotdesk.support_messagetxt')}}</label>
                  <textarea {{($dataTypeContent->getKey() && $dataTypeContent->status == 'closed') ? 'disabled' : ''}}></textarea>
                </div>
                <div class="button-group left">
                  <button type="button" class="btn btn-blue arrow @if($dataTypeContent->getKey()) sendmessage @else newmessage @endif" data-id="{{$dataTypeContent->id}}" disabled>{{__('hotdesk.support_sendreply')}}</button>
                  @if(!$dataTypeContent->getKey())
                    <button type="button" class="btn btn-blue arrow sendmessage" style="display:none" disabled>{{__('hotdesk.support_sendreply')}}</button>
                  @endif
                </div>
                <div class="messages  mCustomScrollbar" data-mcs-theme="dark" data-page="1" data-morepage="@if($dataTypeContent->getKey() && $dataTypeContent->messages()->count()>10){{'True'}}@else{{'False'}}@endif" data-id="{{$dataTypeContent->id}}">
                  @if($dataTypeContent->messages()->exists() && $dataTypeContent->getKey())
                  @foreach($dataTypeContent->messages()->limit(10)->get() as $message)
                    <div class="message {{$message->user_id != $dataTypeContent->user_id ? 'sup' : 'me'}}">
                      <div>
                        <p>{{Illuminate\Support\Facades\Crypt::decryptString($message->message)}}
                          <button type="button" class="copymessage"></button>
                        </p>
                        <span>{{Auth::user()->Locale =='fa' ? \Morilog\Jalali\Jalalian::fromDateTime($message->created_at)->format('j F y H:i') : \Carbon\Carbon::parse($message->created_at)->format('j F y H:i')}}</span>
                      </div>
                    </div>
                    @endforeach
                  @endif

                </div>
              </div>
            </div>
            <div class="template">
              <h3>{{__('hotdesk.support_template')}}</h3>
              <div class="sendbox">
                <textarea placeholder="{{__('hotdesk.support_messagetxt')}}"></textarea>
                <button disabled><svg xmlns="http://www.w3.org/2000/svg" width="24" height="20.006" viewBox="0 0 24 20.006"><g transform="translate(24 -0.026) rotate(180)"><path d="M-.986,1.971h-1.5A.986.986,0,0,1-3.473.986.986.986,0,0,1-2.488,0h1.5A.986.986,0,0,1,0,.986.986.986,0,0,1-.986,1.971Z" transform="translate(0 -1.529) rotate(-180)" fill="#52c0ef"/><path d="M-3.473.986A.986.986,0,0,1-2.488,0h1.5A.986.986,0,0,1,0,.986a.986.986,0,0,1-.986.986h-1.5A.986.986,0,0,1-3.473.986Z" transform="translate(0 -11.542) rotate(-180)" fill="#52c0ef"/><path d="M-22.475,9.128-5.452.116A.986.986,0,0,1-4.005.987V5.008h3A1,1,0,0,1,0,5.957.986.986,0,0,1-.986,6.979h-3.02v.515A1.127,1.127,0,0,1-5,8.614l-8.113.936a.452.452,0,0,0,0,.9L-5,11.384a1.126,1.126,0,0,1,1,1.119v2.518h3A1,1,0,0,1,0,15.971a.986.986,0,0,1-.985,1.022h-3.02v2.182A.815.815,0,0,1-4.945,20c-.519-.06,1.494.942-17.53-9.129a.986.986,0,0,1,0-1.742Z" transform="translate(1.001 -0.026) rotate(-180)" fill="#52c0ef"/></g></svg></button>
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
          </div>

@stop

@section('javascript')
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.layout .main .inside').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
