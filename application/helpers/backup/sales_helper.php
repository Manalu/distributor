<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getMedzNamesOnlyForSearchBar')){
    function getMedzNamesOnlyForSearchBar(){
        $CI =& get_instance();
        $list = $CI->salesmodel->GetMedDetailsForMedicineSearchBar();
        if($list != FALSE){
            $num = count($list); $i = 1; $str = "";
            foreach ($list as $list){
                $str .= '{
                    id: "'.$list['MedicineId'].'",
                    label: "' . $list['MedicineName'] . '",
                    desc: "' . $list['MedicineType'] . ' <br /> ' . $list['MedicineGroup'] . ' <br /> ' . $list['BoxQuantity'] . '&#8217;s Pack. BDT: ' . $list['BoxPrice'] . '<br />' . $list['MedicineCompany'] . '",
                    comp: "' . $list['MedicineCompany'] . '",
                    discount: "' . $list['MedDiscount'] . '",
                    cmid: "' . $list['CompId'] . '",
                    grup: "' . $list['MedicineGroup'] . '",
                    grpid: "' . $list['GroupId'] . '",
                    Mtype: "' . $list['MedicineType'] . '"
                        },';
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

if ( ! function_exists('getCustomerForSalesPanel')){
    function getCustomerForSalesPanel(){
        $CI =& get_instance();
        $list = $CI->salesmodel->getCustomerForSales();
        if($list != FALSE){
//            $num = count($list); $i = 1; $str = "";
            $str = "";
            foreach ($list->result() as $customers){
                $str .= '{
                    id: "' . $customers->cl_id . '",
                    value: "' . $customers->cl_phone_no. '"},';
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

if ( ! function_exists('getMedicineNamesFilteredByGroup')){
    function getMedicineNamesFilteredByGroup($groupid){
        $CI =& get_instance();
        $list = $CI->salesmodel->GetMedDetailsForMedicineSearchBarSortedByGroup($groupid);
        if($list != FALSE){
            $num = count($list); $i = 1; $str = "";
            foreach ($list as $list){
                $str .= '{
                    id: "'.$list['MedicineId'].'",
                    value: "' . $list['MedicineName'] . ' - ' . $list['MedicineGroup'] . ' - ' . $list['MedicineType'] . ' - ' . $list['MedicineCompany'] .'"},';
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

if ( ! function_exists('getTotalNubmerOfSalesByUserId')){
    function getTotalNubmerOfSalesByUserId($userid, $start, $end){
        $CI =& get_instance();
        return $CI->salesmodel->getTotalNubmerOfSalesByUserId($userid, $start, $end);
    }
}

if ( ! function_exists('getTotalSoldAmountByUserId')){
    function getTotalSoldAmountByUserId($userid, $start, $end){
        $CI =& get_instance();
        return $CI->salesmodel->getTotalSoldAmountByUserId($userid, $start, $end);
    }
}

if ( ! function_exists('outstandingAmountForSpecificUser')){
    function outstandingAmountForSpecificUser($userid, $start, $end){
        $CI =& get_instance();
        $OutStanding = $CI->salesmodel->outstandingAmountForSpecificUser($userid, $start, $end);
        if($OutStanding != FALSE){
            $TotalOutstanding = 0;
            foreach ($OutStanding->result() as $OutStanding){
                $Paid = getPaidAmountForEachInvoiceByInvoiceId($OutStanding->inv_id);
                $Baki = $OutStanding->inv_all_total - $Paid;
                $TotalOutstanding = $TotalOutstanding + $Baki;
            }
            return $TotalOutstanding;
        } else {
            return 0;
        }
    }
}

if ( ! function_exists('getTotalNumberOfSalesForLastXMonths')){
    function getTotalNumberOfSalesForLastXMonths($userid, $data){
        $CI =& get_instance();
        return $CI->salesmodel->getTotalNumberOfSalesForLastXMonths($userid, $data);
    }
}

if ( ! function_exists('getTotalSoldAmountByUserIdForXMonth')){
    function getTotalSoldAmountByUserIdForXMonth($userid, $data){
        $CI =& get_instance();
        return $CI->salesmodel->getTotalSoldAmountByUserIdForXMonth($userid, $data);
    }
}

if ( ! function_exists('getPaidAmountForEachInvoiceByInvoiceId')){
    function getPaidAmountForEachInvoiceByInvoiceId($invid){
        $CI =& get_instance();
        return $CI->salesmodel->getPaidAmountForEachInvoiceByInvoiceIdFromModel($invid);
    }
}

if ( ! function_exists('getReturnedAmountForEachInvoiceByInvoiceIdFromModel')){
    function getReturnedAmountForEachInvoiceByInvoiceIdFromModel($invid){
        $CI =& get_instance();
        return $CI->salesmodel->getReturnedAmountForEachInvoiceByInvoiceIdFromModel($invid);
    }
}

if ( ! function_exists('getMedicineQuantityForDailyList')){
    function getMedicineQuantityForDailyList($medid, $Filter_Key = FALSE){
        $CI =& get_instance();
        if($Filter_Key === FALSE) {
            return $CI->salesmodel->getMedicineQuantityForDailyListFromModel($medid);
        } else {
            return $CI->salesmodel->getMedicineQuantityForDailyListFromModel($medid, $Filter_Key);
        }
    }
}

if ( ! function_exists('getCustomerPhoneByCustomerId')){
    function getCustomerPhoneByCustomerId($CustomerId){
        $CI =& get_instance();
        return $CI->salesmodel->getCustomerPhoneByCustomerIdFromModel($CustomerId);
    }
}

if ( ! function_exists('getCustomerNameByCustomerId')){
    function getCustomerNameByCustomerId($CustomerId){
        $CI =& get_instance();
        return $CI->salesmodel->getCustomerNameByCustomerIdFromModel($CustomerId);
    }
}

if ( ! function_exists('getInvocieStatusByInvoiceId')){
    function getInvocieStatusByInvoiceId($inv){
        $CI =& get_instance();
        return $CI->salesmodel->getInvocieStatusByInvoiceIdFromModel($inv);
    }
}
?>
