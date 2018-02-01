<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getClientPhoneNumberByClientId')){
    function getClientPhoneNumberByClientId($clid){
        $CI =& get_instance();
        return $CI->clientsmodel->getClientPhoneNumberByClientIdModelFunc($clid);
    }
}

if ( ! function_exists('getClientNameByClientId')){
    function getClientNameByClientId($clid){
        $CI =& get_instance();
        return $CI->clientsmodel->getClientNameByClientIdModelFunc($clid);
    }
}

if ( ! function_exists('getTotalAmountSoldToClientByClientId')){
    function getTotalAmountSoldToClientByClientId($clid){
        $CI =& get_instance();
        return $CI->clientsmodel->getTotalAmountSoldToClientByClientIdModelFunc($clid);
    }
}

if ( ! function_exists('getTotalNumberOfInvoiceSoldToClientByClientId')){
    function getTotalNumberOfInvoiceSoldToClientByClientId($clid){
        $CI =& get_instance();
        return $CI->clientsmodel->getTotalNumberOfInvoiceSoldToClientByClientIdModelFunc($clid);
    }
}

if ( ! function_exists('getClientsOutstandingByClientId')){
    function getClientsOutstandingByClientId($clid){
        $CI =& get_instance();
        return $CI->clientsmodel->getClientsOutstandingByClientId($clid);
    }
}

?>
