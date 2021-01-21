<?php

$name = $name ?? '';
$name_dotted = input_array_name_to_dot_notation( $name );

$class = $class ?? 'form-control';
$multiple = $multiple ?? false;
$multiple = boolval( $multiple );

$data = $data ?? [];
$data = is_array( $data ) ? $data : ( is_string( $data ) ? json_decode( $data ) : [] );
$data = $data ?? [];

$attrs = $attrs ?? [];
$attrs = is_array( $attrs ) ? $attrs : ( is_string( $attrs ) ? json_decode( $attrs ) : [] );
$attrs = $attrs ?? [];

$placeholder = $placeholder ?? '';
$attrs['placeholder'] = $placeholder;

$options = $options ?? [];
$options = is_array( $options ) ? $options : ( is_string( $options ) ? json_decode( $options ) : [] );


$value = $value ?? ( $name ? app('request')->input( $name_dotted ) : '' );

?>

<textarea class="{{ $class }} @isinvalid( $name )"
        id="{{ $id ?? '' }}"
        name="{{ $name }}"
        {{ $multiple ? 'multiple' : '' }}
        @foreach($data as $dataKey => $dataValue)
            data-{{$dataKey}}="{{$dataValue}}"
        @endforeach
        @foreach($attrs as $attrKey => $attrValue)
            @if(is_int($attrKey)) {{ $attrValue }} @else {{$attrKey}}="{{$attrValue}}" @endif
        @endforeach>@valueof($name_dotted, $value )</textarea>
@error( $name_dotted )
