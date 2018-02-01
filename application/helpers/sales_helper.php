<?php

/**
 * Description of sales_helper
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
if ( ! function_exists('get_number_of_boxes')){
    function get_number_of_boxes($stok, $box_qty){
        if($box_qty > 0){
            $dividend = ($stok / $box_qty);
            $split = explode(".", $dividend);
            return $split[0];
        } else {
            return 0;
        }
    }
}

if ( ! function_exists('get_number_of_remainder')){
    function get_number_of_remainder($stok, $box_qty){
        if($box_qty > 0){
            return ($stok % $box_qty);
        } else {
            return 0;
        }
    }
}
?>
