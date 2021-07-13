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
    <div class="post">
        @include('voyager::alerts')
        <div class="block">
                    <!-- form start -->
                    <form class="form-edit-add" role="form"
                          action="@if(isset($dataTypeContent->id)){{ route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route('voyager.'.$dataType->slug.'.store') }}@endif"
                          method="POST" enctype="multipart/form-data">

                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @foreach($dataType->addRows as $row)
                                <div class="form-group gray">
                                    <label for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                    {!! Voyager::formField($row, $dataType, $dataTypeContent) !!}
                                </div>
                            @endforeach
                            <label for="permission">{{ __('voyager::generic.permissions') }}</label><br><br>
                            <a href="#" class="permission-select-all">{{ __('voyager::generic.select_all') }}</a> / <a href="#"  class="permission-deselect-all">{{ __('voyager::generic.deselect_all') }}</a>
                            <ul class="permissions checkbox">
                                <?php
                                    $role_permissions = (isset($dataTypeContent)) ? $dataTypeContent->permissions->pluck('key')->toArray() : [];
                                ?>
                                @foreach(Voyager::model('Permission')->all()->groupBy('table_name') as $table => $permission)
                                @if(Auth::user()->role->type == 1 && !empty($table) && !Auth::user()->hasPermission("read_".$table) && !Auth::user()->hasPermission("browse_".$table))
                                  @php continue; @endphp
                                @endif
                                    <li>
                                        <div class="select">
                                          <input id="r_{{$table}}" class="permission-group checkbox select" type="checkbox" />
                                          <label for="r_{{$table}}"></label>
                                        </div>
                                        <label for="r_{{$table}}"><strong>{{\Illuminate\Support\Str::title(str_replace('_',' ', $table))}}</strong></label>
                                        <ul>
                                            @foreach($permission as $perm)
                                                @if(Auth::user()->role->type == 1 && !Auth::user()->hasPermission($perm->key))
                                                  @php continue; @endphp
                                                @endif
                                                <li>
                                                    <div class="select">
                                                      <input id="permission-{{$perm->id}}" name="permissions[]" class="the-permission checkbox select select_all" type="checkbox" value="{{$perm->id}}" @if(count($role_permissions) && in_array($perm->key, $role_permissions)) checked @endif />
                                                      <label for="permission-{{$perm->id}}"></label>
                                                    </div>
                                                    <label for="permission-{{$perm->id}}">{{\Illuminate\Support\Str::title(str_replace('_', ' ', $perm->key))}}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                          <div class="button-group left">
                            <button type="submit" class="btn btn-blue arrow">{{ __('voyager::generic.submit') }}</button>
                          </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        {{ csrf_field() }}
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                    </form>

                </div>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
            var inittype = $('select[name=type] option:selected').val();
            @if(!isset($dataTypeContent->id))
            if(inittype==0){
              $(".permissions input[type='checkbox']").prop('checked', true);
            }
            @endif
            @if(Auth::user()->role->type == 1)
              $('select[name=type] option[value=0]').remove().change();
            @endif
            $('select[name=type]').on('change', function(){
                var type = $(this).val();
                if(type==0){
                  $(".permissions input[type='checkbox']").prop('checked', true);
                }else if(type==1){
                  $(".permissions input[value=1]").prop('checked', true);
                  $(".permissions input[value=2]").prop('checked', false);
                  $(".permissions input[value=3]").prop('checked', false);
                  $(".permissions input[value=4]").prop('checked', false);
                  $(".permissions input[value=5]").prop('checked', false);
                  $(".permissions input[value=26]").prop('checked', false);
                  $(".permissions #r_menus").prop('checked', false).change();
                  $(".permissions #r_roles").prop('checked', true).change();
                  $(".permissions #r_settings").prop('checked', false).change();
                  $(".permissions #r_users").prop('checked', true).change();
                }else if(type==2){
                  $(".permissions input[value=1]").prop('checked', true);
                  $(".permissions input[value=2]").prop('checked', false);
                  $(".permissions input[value=3]").prop('checked', false);
                  $(".permissions input[value=4]").prop('checked', false);
                  $(".permissions input[value=5]").prop('checked', false);
                  $(".permissions input[value=26]").prop('checked', false);
                  $(".permissions #r_menus").prop('checked', false).change();
                  $(".permissions #r_roles").prop('checked', false).change();
                  $(".permissions #r_settings").prop('checked', false).change();
                  $(".permissions #r_users").prop('checked', false).change();
                }
            });

            $('.permission-group').on('change', function(){
                $(this).parent().siblings('ul').find("input[type='checkbox']").prop('checked', this.checked);
            });

            $('.permission-select-all').on('click', function(){
                $('ul.permissions').find("input[type='checkbox']").prop('checked', true);
                return false;
            });

            $('.permission-deselect-all').on('click', function(){
                $('ul.permissions').find("input[type='checkbox']").prop('checked', false);
                return false;
            });

            function parentChecked(){
                $('.permission-group').each(function(){
                    var allChecked = true;
                    $(this).parent().siblings('ul').find("input[type='checkbox']").each(function(){
                        if(!this.checked) allChecked = false;
                    });
                    $(this).prop('checked', allChecked);
                });
            }

            parentChecked();

            $('.the-permission').on('change', function(){
                parentChecked();
            });
        });
    </script>
@stop
