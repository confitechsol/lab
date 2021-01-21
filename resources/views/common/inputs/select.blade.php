@php

$id = $id ?? 'sel-' . uniqid();
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

$options = $options ?? [];
$options = is_array( $options ) ? $options : ( is_string( $options ) ? json_decode( $options ) : [] );

$placeholder = $placeholder ?? null;
if( $placeholder ){
    $options = [ '' => $placeholder ] +  $options;
}


$value = $value ?? ( $name ? app('request')->input( $name_dotted ) : '' );

@endphp

<select class="{{ $class }} @isinvalid( $name_dotted )"
        id="{{ $id }}"
        name="{{ $name }}"
        @foreach($data as $dataKey => $dataValue)
            data-{{$dataKey}}="{{$dataValue}}"
        @endforeach
        @foreach($attrs as $attrKey => $attrValue)
            @continue( $attrValue === false )
            @php( $attrValue = $attrValue === true ? $attrKey : $attrValue )
            {{$attrKey}}="{{$attrValue}}"
        @endforeach
        {{ $multiple ? 'multiple' : '' }}>
    @foreach( $options as $optionValue => $optionTitle )
        <option value="{{ $optionValue }}" @selected($name_dotted, $optionValue, $value) >{{ $optionTitle }}</option>
    @endforeach
</select>
@error( $name_dotted )
