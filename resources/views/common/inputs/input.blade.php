<?php

$name = $name ?? '';
$name_dotted = input_array_name_to_dot_notation( $name );

$class = $class ?? 'form-control';
$multiple = $multiple ?? false;
$multiple = boolval( $multiple );

$type = $type ?? 'text';

$data = $data ?? [];
$data = is_array( $data ) ? $data : ( is_string( $data ) ? json_decode( $data ) : [] );
$data = $data ?? [];

$attrs = $attrs ?? [];
$attrs = is_array( $attrs ) ? $attrs : ( is_string( $attrs ) ? json_decode( $attrs ) : [] );
$attrs = $attrs ?? [];

$placeholder = $placeholder ?? null;
$attrs['placeholder'] = $placeholder ?? $attrs['placeholder'] ?? '';

$value = $value ?? ( $name ? app('request')->input( $name_dotted ) : '' );

?>

<input class="{{ $class }} @isinvalid( $name_dotted )"
    id="{{ $id ?? '' }}"
    name="{{ $name }}"
    type="{{ $type }}"
    {{ $multiple ? 'multiple' : '' }}
    @foreach($data as $dataKey => $dataValue)
        data-{{$dataKey}}="{{$dataValue}}"
    @endforeach
    @foreach($attrs as $attrKey => $attrValue)
        @if(is_int($attrKey)) {{ $attrValue }} @elseif ($attrValue) {{$attrKey}}="{{$attrValue}}" @endif
    @endforeach
    value='@valueof($name_dotted, $value )'>
@error( $name_dotted )
