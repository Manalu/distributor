<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of dashboardmodel
 *
 * @author  tarek
 * @contact priom2000@gmail.com
 */
class dashboardmodel extends CI_Model {
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getTotalNumberOfProductsByCompany($comid){
        $this->db->select('medicine_name.m_id');
        $this->db->from('medicine_name');
        $this->db->where('medicine_name.m_cid', $comid);
        $Product = $this->db->get();
        return $Product->num_rows();
    }
    
    public function getAllMedicineIdByCompany($comid){
        $total = 0;
        $this->db->select('medicine_name.m_id, medicine_name.med_u_price, medicine_name.m_stok');
        $this->db->from('medicine_name');
        $this->db->where('medicine_name.m_cid', $comid);
        $Product = $this->db->get();
        if($Product->num_rows() > 0){
            foreach ($Product->result() as $Product){
                //$total = $total + ((getInStock($Product->m_id) - getSoldAmountFromStock($Product->m_id)) * $Product->med_u_price);
                $total = $total + ($Product->m_stok * $Product->med_u_price);
            }
            return $total;
        }
        else{
            return 0;
        }
    }
    
    public function getTodaysAllCashout($today){
        $this->db->select_sum('voucher.v_amount');
        $this->db->from('voucher');
        $this->db->where('voucher.v_date', $today);
        $this->db->where('voucher.v_type', 2);
        $CashOutToday = $this->db->get()->row();
        return $CashOutToday->v_amount;
    }
    
    public function getTodaysAllCashin($today){
        $this->db->select_sum('voucher.v_amount');
        $this->db->from('voucher');
        $this->db->where('voucher.v_date', $today);
        $this->db->where('voucher.v_type', 1);
        $CashOutToday = $this->db->get()->row();
        return $CashOutToday->v_amount;
    }
    
    public function getAllUserListOnlyId(){
        $this->db->select('u_id');
        $this->db->from('user_info');
        $this->db->order_by('user_info.u_name','ASC');
        $LogData = $this->db->get();
        if($LogData->num_rows() > 0){
            return $LogData;
        }
        else{
            return FALSE;
        }
    }
    
    public function getTodaysSaleForEachUserByUserId($usrid){
        $this->db->select_sum('invoice.inv_all_total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_date', date("Y-m-d"));
        $this->db->where('invoice.inv_uid', $usrid);
        $TotalSales = $this->db->get()->row();
        return $TotalSales->inv_all_total;
    }
    
    public function getLastLoginTimeByUserId($uid){
        $this->db->select('user_log.lg_date, user_log.lg_time');
        $this->db->from('user_log');
        $this->db->where('user_log.u_id', $uid);
        $this->db->order_by('user_log.lg_date', 'DESC');
        $this->db->limit(1);
        $LogData = $this->db->get()->row();
        if($LogData != NULL){
            return $LogData->lg_date . ' ' . $LogData->lg_time;
        }
        else{
            return 'No Data!!';
        }
    }
    
    public function getLastLogoutTimeByUserId($uid){
        $this->db->select('user_log.lo_date, user_log.lo_time');
        $this->db->from('user_log');
        $this->db->where('user_log.u_id', $uid);
        $this->db->order_by('user_log.lg_date', 'DESC');
        $this->db->limit(1);
        $LogData = $this->db->get()->row();
        if($LogData != NULL){
            return $LogData->lo_date . ' ' . $LogData->lo_time;
        }
        else{
            return 'No Data!!';
        }
    }
    
    public function cashValueForTotalMedicine(){
        $this->db->select('medicine_name.med_u_price as UnitPrice, medicine_name.m_stok StokValue');
        $this->db->from('medicine_name');
        $IndividualCost = $this->db->get();
        if($IndividualCost->num_rows() > 0){
            return $IndividualCost;
        } else {
            return FALSE;
        }
    }
}

?>
