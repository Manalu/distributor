<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getLedgerHeadName')){
    function getLedgerHeadName($headid){
        $CI =& get_instance();
        return $CI->settingsmodel->getLedgerHeadName($headid);
    }
}
?>
