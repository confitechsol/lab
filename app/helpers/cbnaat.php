<?php


if( !function_exists('print_cbnaat_report_td_string') ){
    function print_cbnaat_report_td_string( $string ){
        echo "<td style='border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000' align='left' valign='bottom' sdnum='16393;0;0'>
            <font face='Bookman Old Style' size='3' color='#000000'><br>$string</font>
        </td>";
    }
}

if( !function_exists('print_cbnaat_report_td') ){
    function print_cbnaat_report_td($value, $item ){
        $value = $value->$item ? $value->$item : 0;
        print_cbnaat_report_td_string( $value );
    }
}


if( !function_exists('print_cbnaat_report_line') ){
    function print_cbnaat_report_line($data, $key ){
        $value = $data[ $key ];
        for( $i = 1; $i <= 12; $i++ ){
            $item = $key . '_' . str_pad( $i, 2, '0', STR_PAD_LEFT );
            print_cbnaat_report_td( $value, $item );
        }
    }
}