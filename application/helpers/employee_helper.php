<?php

/**
 * Description of employee_helper
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */

if ( ! function_exists('calculate_employee_attendance')){
    function calculate_employee_attendance($emp, $start, $end){
        $CI =& get_instance();
        return $CI->employeemodel->calculate_employee_attendance($emp, $start, $end);
    }
}
?>