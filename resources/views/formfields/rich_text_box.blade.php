<textarea class="rte" name="{{ $row->field }}" id="richtext{{ $row->field }}" style="direction: ltr!important; height: 500px!important;">
    {{ old($row->field, $dataTypeContent->{$row->field} ?? '') }}
</textarea>
