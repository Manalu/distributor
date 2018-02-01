<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getTotalNumberOfProductsByCompany')){
    function getTotalNumberOfProductsByCompany($comid){
        $CI =& get_instance();
        return $CI->dashboardmodel->getTotalNumberOfProductsByCompany($comid);
    }
}

if ( ! function_exists('getAllMedicineIdByCompany')){
    function getAllMedicineIdByCompany($comid){
        $CI =& get_instance();
        return $CI->dashboardmodel->getAllMedicineIdByCompany($comid);
    }
}

if ( ! function_exists('getTodaysSaleForEachUserByUserId')){
    function getTodaysSaleForEachUserByUserId($usrid){
        $CI =& get_instance();
        $Amount = $CI->dashboardmodel->getTodaysSaleForEachUserByUserId($usrid);
        if($Amount != NULL){
//            return number_format($Amount, 2) . ' BDT';
            return $Amount;
        }
        else{
            return 0;
        }
    }
}

if ( ! function_exists('getLastLoginTimeByUserId')){
    function getLastLoginTimeByUserId($uid){
        $CI =& get_instance();
        return $CI->dashboardmodel->getLastLoginTimeByUserId($uid);
    }
}

if ( ! function_exists('getLastLogoutTimeByUserId')){
    function getLastLogoutTimeByUserId($uid){
        $CI =& get_instance();
        return $CI->dashboardmodel->getLastLogoutTimeByUserId($uid);
    }
}
?>
