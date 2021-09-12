@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
@stop

@section('content')
  <div class="profile">
    <div class="editprofile">
      <h3>{{__('hotdesk.user_edit')}}</h3>
      @if (count($errors) > 0)
          @foreach ($errors->all() as $error)
                  <div class="alert error">
                    {{ $error }}
                  </div>
          @endforeach
      @endif
      <form class="form-edit-add" role="form"
            action="@if(!is_null($dataTypeContent->getKey())){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
            method="POST" enctype="multipart/form-data" autocomplete="off">
          <!-- PUT Method if we are editing -->
          @if(isset($dataTypeContent->id))
              {{ method_field("PUT") }}
          @endif
          {{ csrf_field() }}
      <div class="box">
        <div class="avatar imageupload">
          <img src="@if(isset($dataTypeContent->avatar)){{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image( $dataTypeContent->avatar ) }}@endif" width="192px" height="192px" onerror="this.onerror=null;this.src='/assets/images/avatar_big.png';">
          <input type="file" data-name="avatar" name="avatar" id="avatar_upload" accept="image/*">
          <button class="uploadavatar"></button>
        </div>
        <div class="form">
          <div class="form-group gray">
            <label for="name">{{ __('voyager::generic.name') }}</label>
            <input type="text" name="name" value="{{ old('name', $dataTypeContent->name ?? '') }}"/>
          </div>
          <div class="form-group gray">
            <label for="email">{{ __('voyager::generic.email') }}</label>
            <input type="text" name="email" value="{{ old('email', $dataTypeContent->email ?? '') }}"/>
          </div>
          <div class="form-group gray onlynumber">
            <label>{{__('hotdesk.user_phone')}}</label>
            <input type="text" name="phone" value="{{ old('email', $dataTypeContent->phone ?? '') }}"/>
          </div>
              @if((!is_null($dataTypeContent->getKey()) && Auth::user()->id != $dataTypeContent->id) || is_null($dataTypeContent->getKey()) || Auth::user()->role->type==0)
              <div class="form-group select gray">
                  <label for="default_role">{{ __('voyager::profile.role_default') }}</label>
                  @php
                      $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};

                      $row     = $dataTypeRows->where('field', 'user_belongsto_role_relationship')->first();
                      $options = $row->details;
                  @endphp
                  @php $relationshipField = $row->field; @endphp
                  <div class="select">
                  <select class="form-control select2" name="{{ $options->column }}">
                      @php
                          $model = app($options->model);
                          if(Auth::user()->role->type == 1)
                            $query = $model::whereIn('type',[1,2])->get();
                          else
                            $query = $model::get();
                      @endphp
                      @if(!$row->required)
                          <option value="">{{__('voyager::generic.none')}}</option>
                      @endif

                      @foreach($query as $relationshipData)
                          <option value="{{ $relationshipData->{$options->key} }}" @if($dataTypeContent->{$options->column} == $relationshipData->{$options->key}) selected="selected" @endif>{{ $relationshipData->{$options->label} }}</option>
                      @endforeach
                  </select>
                </div>
              </div>
              @endif
              @php
              if (isset($dataTypeContent->locale)) {
                  $selected_locale = $dataTypeContent->locale;
              } else {
                  $selected_locale = config('app.locale', 'en');
              }

              @endphp
              <div class="form-group select gray">
                  <label for="locale">{{ __('voyager::generic.locale') }}</label>
                  <div class="select">
                    <select id="locale" name="locale">
                        @foreach (Voyager::getLocales() as $locale)
                        <option value="{{ $locale }}"
                        {{ ($locale == $selected_locale ? 'selected' : '') }}>{{ $locale }}</option>
                        @endforeach
                    </select>
                  </div>
              </div>
          <div class="form-group gray password">
            <label for="password">{{ __('voyager::generic.password') }}</label>
            <input type="password" id="password" name="password" value="" autocomplete="new-password" />
            <div class="checklist">
              <div class="Strength">
                <ul>
                  <li class="l1"></li>
                  <li class="l2"></li>
                  <li class="l3"></li>
                  <li class="l4"></li>
                  <li class="l5"></li>
                  <li class="l6"></li>
                  <li class="message">{{__('hotdesk.user_unacceptable')}}</li>
                </ul>
              </div>
              <ul class="list">
                <li class="bw">{{__('hotdesk.user_role1')}}</li>
                <li class="c8">{{__('hotdesk.user_role2')}}</li>
                <li class="hn">{{__('hotdesk.user_role3')}}</li>
                <li class="sc">{{__('hotdesk.user_role4')}}</li>
              </ul>
            </div>
          </div>
          <div class="form-group gray password">
            <label>{{__('hotdesk.user_repassword')}}</label>
            <input type="password" data-re="password" name="repassword"/>
            <div class="checklist">
              <div class="Strength">
                <ul>
                  <li class="l1"></li>
                  <li class="l2"></li>
                  <li class="l3"></li>
                  <li class="l4"></li>
                  <li class="l5"></li>
                  <li class="l6"></li>
                  <li class="message">{{__('hotdesk.user_unacceptable')}}</li>
                </ul>
              </div>
              <ul class="list">
                <li class="bw">{{__('hotdesk.user_role1')}}</li>
                <li class="c8">{{__('hotdesk.user_role2')}}</li>
                <li class="hn">{{__('hotdesk.user_role3')}}</li>
                <li class="sc">{{__('hotdesk.user_role4')}}</li>
                <li class="rp">{{__('hotdesk.user_role5')}}</li>
              </ul>
            </div>
          </div>
          <div class="button-group left">
            <button type="submit" class="btn btn-blue arrow">{{__('hotdesk.user_update')}}</button>
          </div>
        </div>
      </div>
      </form>
      <iframe id="form_target" name="form_target" style="display:none"></iframe>
      <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
          {{ csrf_field() }}
          <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
          <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
      </form>
    </div>
    <div class="help">
      <h3>{{__('hotdesk.user_help')}}</h3>
      <div class="list">
        <div class="item">
          لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع
        </div>
        <div class="item">
          لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع
        </div>
      </div>
    </div>
  </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
@stop
