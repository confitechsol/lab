@if( $errors->has( $name ) )
<div class="error-line my-2">{{ $errors->first( $name ) }}</div>
@endif
