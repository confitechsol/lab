<?php
$id = $id ?? null;
$id = $id ?? uniqid('chk');

$name = $name ?? '';
$name_dotted = input_array_name_to_dot_notation( $name );
$value = $value ?? '';

?>
<div class="custom-control custom-checkbox">
    <input type="checkbox"
           class="custom-control-input @isinvalid( $name_dotted )"
           name="{{ $name }}"
           value="{{ $value }}"
           {{ ( old( $name_dotted ) ?? $checked ?? null ) ? 'checked' : '' }}
           id="{{ $id }}">
    <label class="custom-control-label" for="{{ $id }}">{!! $title ?? '' !!}</label>
</div>
@error( $name_dotted )
