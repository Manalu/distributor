<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_supplier_name_by_supplier_id')){
    function get_supplier_name_by_supplier_id($supplier){
        $CI =& get_instance();
        return $CI->suppliermodel->get_supplier_name_by_supplier_id($supplier);
    }
}

if ( ! function_exists('get_supplier_acheivement')){
    function get_supplier_acheivement($supplier, $starting, $finishg, $policy, $type){
        $CI =& get_instance();
        if($type === "Fixed"){
            if($policy === "Sales"){
                return $CI->suppliermodel->calculate_supplier_incentive_sales_fixed($supplier, $starting, $finishg);
            } else if($policy === "Payment") {
                return $CI->suppliermodel->calculate_supplier_incentive_payment_fixed($supplier, $starting, $finishg);
            }
        } else if($type === "Percentage"){
            if($policy === "Sales"){
                return $CI->suppliermodel->calculate_supplier_incentive_sales_percentage($supplier, $starting, $finishg);
            } else if($policy === "Payment"){
                return $CI->suppliermodel->calculate_supplier_incentive_payment_percentage($supplier, $starting, $finishg);
            }
        }
    }
}

if ( ! function_exists('get_supplier_incentive')){
    function get_supplier_incentive($supplier, $starting, $finishg, $policy, $target, $incentive, $type){
        $CI =& get_instance();
        if($type === "Fixed"){
            if($policy === "Sales"){
                $sales = $CI->suppliermodel->calculate_supplier_incentive_sales_fixed($supplier, $starting, $finishg);
                if($sales >= $target){
                    return $incentive; //return bdt() . number_format($incentive, 2, ".", ",");
                } else {
                    return 0; //return bdt() . number_format(0, 2, ".", ",");
                }
            } else if($policy === "Payment") {
                $payment = $CI->suppliermodel->calculate_supplier_incentive_payment_fixed($supplier, $starting, $finishg);
                if($payment >= $target){
                    return $incentive;//return bdt() . number_format($incentive, 2, ".", ",");
                } else {
                    return 0;//return bdt() . number_format(0, 2, ".", ",");
                }
            }
            
        } else if($type === "Percentage"){
            if($policy === "Sales"){
                $sales = $CI->suppliermodel->calculate_supplier_incentive_sales_percentage($supplier, $starting, $finishg);
                if($sales >= $target){
                    return round((($sales * $incentive) / 100)); //return bdt() . number_format(round((($sales * $incentive) / 100)), 2, ".", ",");
                } else {
                    return 0;//return bdt() . number_format(0, 2, ".", ",");
                }
            } else if($policy === "Payment"){
                $payment = $CI->suppliermodel->calculate_supplier_incentive_payment_percentage($supplier, $starting, $finishg);
                if($payment >= $target){
                    return round((($payment * $incentive) / 100));//return bdt() . number_format(round((($payment * $incentive) / 100)), 2, ".", ",");
                } else {
                    return 0;//return bdt() . number_format(0, 2, ".", ",");
                }
            }
        }
    }
}
?>
