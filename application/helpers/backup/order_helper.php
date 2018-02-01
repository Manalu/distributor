<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getAllReceivedOrdersByCompanyName')){
    function getAllReceivedOrdersByCompanyName(){
        $CI =& get_instance();
        $list = $CI->accountsmodel->getAllReceivedOrdersByCompanyNameFromModel();
        if($list != FALSE){
            $num = count($list); $i = 1; $str = "";
            foreach ($list as $list){
                $str .= '{
                    id: "'.$list['OrderId'].'",
                    value: "' . $list['OrderId'] . ' - ' . $list['CompanyName'] . ' - ' . $list['AgentName'] . ' - Total: ' . $list['OrderSubTotal'] . ' - Discount: ' . $list['OrderDiscount'] . '% - SubTotal: ' . $list['OrderTotal'] . '"},';
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
?>
