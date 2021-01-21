<?php



if( !function_exists('input_array_name_to_dot_notation') ){

    function input_array_name_to_dot_notation( $name ){
        return str_replace(['[', ']'], ['.', ''], $name);
    }

}


if( !function_exists('selected') ){
    /**
     * @param string $name
     * @param string|array $value
     * @param string $selected
     */
    function selected( $name, $value, $selected = '' ){
        if( is_array( $value ) ){
            echo in_array( ( old( $name ) ?? $selected ), $value ) ? ' selected ' : '';
        }else{
            echo ( old( $name ) ?? $selected ) == $value ? ' selected ' : '';
        }
    }
}

if( !function_exists('financial_year') ){
    /**
     * @return string
     */
    function financial_year(){
        if (date('m') <= 6) {//Upto June 2014-2015
            $financial_year = (date('y')-1) . '-' . date('y');
        } else {//After June 2015-2016
            $financial_year = date('y') . '-' . (date('y') + 1);
        }
        return $financial_year;
    }
}



if( !function_exists('is_route') ){
    function is_route( $route_name ){
        return \Illuminate\Support\Facades\Route::currentRouteName() === $route_name;
    }
}

if( !function_exists('is_sub_route') ){
    function is_sub_route( $route_name ){
        $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName();
        return strpos( $current_route_name, $route_name ) === 0;
    }
}



if( !function_exists('name_to_color') ){
    function name_to_color( $name ){
        return '#' . substr(md5($name), -6, 6);
    }
}
