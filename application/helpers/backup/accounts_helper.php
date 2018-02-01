<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getCashOutPurpose')){
    function getCashOutPurpose($purposeid){
        $CI =& get_instance();
        return $CI->accountsmodel->getCashOutPurpose($purposeid);
    }
}

if ( ! function_exists('getActiveLedgerList')){
    function getActiveLedgerList($type){
        $CI =& get_instance();
        $list = $CI->accountsmodel->getActiveLedgerListByType($type);
        if($list != FALSE){
            $num = count($list); $i = 1; $str = "";
            foreach ($list->result() as $list){
                $str .= '{
                    id: "' . $list->id . '",
                    value: "' . $list->ledger . '"},';
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
