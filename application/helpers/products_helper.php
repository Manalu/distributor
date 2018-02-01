<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_group_name_group_id')){
    function get_group_name_group_id($comid){
        $CI =& get_instance();
        return $CI->productsmodel->pro_group_name($comid);
    }
}

if ( ! function_exists('get_product_stockin')){
    function get_product_stockin($start, $finish, $product, $branch){
        $CI =& get_instance();
        return $CI->ordermodel->get_product_stockin($start, $finish, $product, $branch);
    }
}

if ( ! function_exists('get_product_soldout')){
    function get_product_soldout($start, $finish, $product, $branch){
        $CI =& get_instance();
        return $CI->ordermodel->get_product_soldout($start, $finish, $product, $branch);
    }
}

if ( ! function_exists('get_product_trnsout')){
    function get_product_trnsout($start, $finish, $product, $branch){
        $CI =& get_instance();
        return $CI->ordermodel->get_product_trnsout($start, $finish, $product, $branch);
    }
}
?>
