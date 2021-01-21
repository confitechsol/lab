<?php


if( !function_exists('escape_like') ){
    /**
     * Escape special characters for a LIKE query.
     *
     * @param string $value
     * @param string $char
     *
     * @return string
     */
    function escape_like($value, string $char = '\\'): string {
        $value = str_replace(
            [$char, '%', '_'],
            [$char.$char, $char.'%', $char.'_'],
            $value
        );
        $value = str_replace( ' ', '%', $value );
        return "%$value%";
    }
}


if( !function_exists('like_param') ){

    function like_param( $value, $wild_start = true, $wild_middle = true, $wild_end = true ): string {
        $value = trim( preg_replace('/\s/', ' ', $value) );
        $value = escape_like( $value );

        if( $wild_middle ) $value = str_replace( ' ', '%', $value );
        if( $wild_start ) $value = "%$value";
        if( $wild_end ) $value = "$value%";

        return $value;
    }
}
