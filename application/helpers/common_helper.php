<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getUserName')){
    function getUserName($userid){
        $CI =& get_instance();
        return $CI->usermodel->getUserNameByUserId($userid);
    }
}

if ( ! function_exists('get_branch_name')){
    function get_branch_name($branch){
        $CI =& get_instance();
        return $CI->settingsmodel->get_branch_name($branch);
    }
}

if ( ! function_exists('get_order_received_stock_cartoon')){
    function get_order_received_stock_cartoon($orderid, $product){
        $CI =& get_instance();
        return $CI->ordermodel->get_order_received_stock_cartoon($orderid, $product);
    }
}

if ( ! function_exists('get_order_received_stock_piece')){
    function get_order_received_stock_piece($orderid, $product){
        $CI =& get_instance();
        return $CI->ordermodel->get_order_received_stock_piece($orderid, $product);
    }
}

if ( ! function_exists('get_order_received_stock_bonus')){
    function get_order_received_stock_bonus($orderid, $product){
        $CI =& get_instance();
        return $CI->ordermodel->get_order_received_stock_bonus($orderid, $product);
    }
}

if ( ! function_exists('get_order_received_stock_quantity')){
    function get_order_received_stock_quantity($orderid, $product){
        $CI =& get_instance();
        return $CI->ordermodel->get_order_received_stock_quantity($orderid, $product);
    }
}

if ( ! function_exists('get_transfer_quantity')){
    function get_transfer_quantity($product, $start, $end, $source, $destination){
        $CI =& get_instance();
        return $CI->ordermodel->get_transfer_quantity($product, $start, $end, $source, $destination);
    }
}

if ( ! function_exists('calculateHowLongAgo')){
    function calculateHowLongAgo($date){
        $now = time();
        $SoldAt = strtotime($date);
        $datediff = $now - $SoldAt;
        if(floor($datediff/(60*60*24)) == 0) {
            return 'Today'; 
        } else {
            return floor($datediff/(60*60*24)) . ' Days ago';
        }
    }
}

if( ! function_exists('errormessage')){
    function errormessage($sms = FALSE){
        if($sms === FALSE){
            return '<div class="alert alert-block alert-error fade in"> <button data-dismiss="alert" class="close" type="button"> × </button> <h4 class="alert-heading"> Sorry! </h4> <p> Some Problem Occured in the Database </p> </div>';
        } else {
            return '<div class="alert alert-block alert-error fade in"> <button data-dismiss="alert" class="close" type="button"> × </button> <h4 class="alert-heading"> Sorry! </h4> <p> ' . $sms . ' </p> </div>';
        }
    }
}

if( ! function_exists('greensignal')){
    function greensignal($sms){
        return '<div class="alert alert-block alert-success fade in"> <button data-dismiss="alert" class="close" type="button"> × </button> <h4 class="alert-heading"> Success! </h4> <p> ' . $sms . ' </p> </div>';
    }
}

//if( ! function_exists('cartalert')){
//    function cartalert($sms, $item_temp_data){
//        return '<div class="alert alert-block alert-success fade in" onclick="remove_from_cart(' . $item_temp_data . ')"> <button data-dismiss="alert" class="close" type="button"> × </button> <p> ' . $sms . ' </p> </div>';
//    }
//}

if( ! function_exists('cartalert')){
    function cartalert($sms, $tble_id, $product){
        return '<div class="cart_alert alert-block alert-success fade in"> <button data-dismiss="alert" style="margin-bottom: 0px;" class="close" type="button" onclick="remove_cart_item(' . $tble_id . ', ' . $product . ')"> × </button> <p> ' . $sms . ' </p> </div>';
    }
}

if( ! function_exists('cartalertremove')){
    function cartalertremove($sms){
        return '<div class="alert alert-block alert-success fade in"> <button data-dismiss="alert" class="close" type="button"> × </button> <p> ' . $sms . ' </p> </div>';
    }
}

if( ! function_exists('warning')){
    function warning($sms){
        return '<div class="alert alert-block alert-warning fade in"> <button data-dismiss="alert" class="close" type="button"> × </button> <h4 class="alert-heading"> Notice! </h4> <p> ' . $sms . '. </p> </div>';
    }
}

if( ! function_exists('widgetHeader')){
    function widgetHeader(){
        echo '<span class="fs1" aria-hidden="true" data-icon="&#xe14a;"></span>';
    }
}

if( ! function_exists('agedata')){
    function agedata(){
        $CI =& get_instance();
        echo $CI->session->flashdata('agedata');
    }
}

if( ! function_exists('notification')){
    function notification(){
        $CI =& get_instance();
        echo $CI->session->flashdata('notification');
    }
}

if( ! function_exists('bdt')){
    function bdt(){
        echo '&#2547; ';
    }
}
?>
