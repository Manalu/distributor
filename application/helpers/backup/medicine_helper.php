<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getMedicineDemandCounter')){
    function getMedicineDemandCounter($comid){
        $CI =& get_instance();
        return $CI->medicinemodel->getMedicineDemandCounterToday($comid);
    }
}

if ( ! function_exists('getMedicineDemandCounterThisMonth')){
    function getMedicineDemandCounterThisMonth($comid){
        $startting = date('01-m-Y',strtotime('this month'));
        $endingday = date('t-m-Y',strtotime('this month'));
        $CI =& get_instance();
        return $CI->medicinemodel->getMedicineDemandCounterThisMonth($comid, $startting, $endingday);
    }
}

if ( ! function_exists('getMedzNamesOnlyForAddStock')){
    function getMedzNamesOnlyForAddStock(){
        $CI =& get_instance();
        $list = $CI->salesmodel->GetMedDetailsForMedicineSearchBar();
        if($list != FALSE){
            $num = count($list); $i = 1; $str = "";
            foreach ($list as $list){
                $str .= '{
                    id: "'.$list['MedicineId'].'",
                    value: "' . $list['MedicineName'] . ' - ' . $list['MedicineType'] . ' - ' . $list['MedicineGroup'] . ' - ' . $list['MedicineCompany'] .'"},';
            }
            return $str;
        }
        else{
            $str = "";
            $str .= '{id: "#", value: "Nothing Found"},';
            return $str;
        }
    }
}

if ( ! function_exists('getMedicineStockFromMediineId')){
    function getMedicineStockFromMediineId($medid){
        $CI =& get_instance();
        return $CI->medicinemodel->getMedicineStockFromMediineIdFromModel($medid);
    }
}
?>
