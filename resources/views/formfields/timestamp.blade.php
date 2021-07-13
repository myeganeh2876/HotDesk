@php
$traits = class_uses($dataTypeContent);
$isjalali = in_array("App\Http\Traits\JalaliDate",$traits);
@endphp
@if(!$isjalali)
<input @if($row->required == 1) required @endif type="datetime" class="form-control datepicker" name="{{ $row->field }}"
       value="@if(isset($dataTypeContent->{$row->field})){{ \Carbon\Carbon::parse(old($row->field, $dataTypeContent->{$row->field}))->format('m/d/Y g:i A') }}@else{{old($row->field)}}@endif">
@else

<input @if($row->required == 1) required @endif type="text" class="form-control date" name="{{ $row->field }}"
       value="@if(isset($dataTypeContent->{$row->field})){{ $dataTypeContent->geodate }}@else{{old($row->geodate)}}@endif">
@endif
