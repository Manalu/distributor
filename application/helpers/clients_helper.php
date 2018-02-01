<?php

/**
 * Description of clients_helper
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
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

?>
