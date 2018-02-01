<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class testmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getAllMedicineList(){
        $this->db->select('m_id, m_name');
        $this->db->from('medicine_name');
        $this->db->where('mrp_status', 1);
        $Medicines = $this->db->get();
        if($Medicines->num_rows() > 0){
            return $Medicines;
        }
    }
    
    public function updateMedicineStock($m_id, $Stock){
        $data = array('m_stok' => $Stock);
        $this->db->where('medicine_name.m_id', $m_id);
        $this->db->update('medicine_name', $data);
    }
    
    public function getMedicineListAccordingToSupplierForShortQty(){
        //$this->db->select('medicine_name.m_id as id, company_info.c_name as Supplier, medicine_name.m_name as name, medicine_group.mg_name as grp, medicine_type.mt_name as type, medicine_name.med_u_price as rate, medicine_name.mrp_box_qty as boxqty, medicine_name.m_min_qty as minqty, medicine_name.m_stok as m_stok');
        $this->db->select('*');
        $this->db->from('medicine_name');
        $this->db->where('medicine_name.m_min_qty >', 0);
        $this->db->where('medicine_name.m_min_qty >', 'medicine_name.m_stok');
        //$this->db->join('company_info', 'company_info.c_id = medicine_name.m_cid');
        //$this->db->join('medicine_group', 'medicine_group.mg_id = medicine_name.m_gid');
        //$this->db->join('medicine_type', 'medicine_type.mt_id = medicine_name.m_tid');
        //$this->db->order_by('medicine_name.m_cid','asc');
        //return $this->db->get();
        $Query = "SELECT 
                    `dist_medicine_name`.`m_id` as id,
                    `dist_company_info`.`c_name` as Supplier,
                    `dist_medicine_name`.`m_name` as name,
                    `dist_medicine_group`.`mg_name` as grp,
                    `dist_medicine_type`.`mt_name` as type,
                    `dist_medicine_name`.`med_u_price` as rate,
                    `dist_medicine_name`.`mrp_box_qty` as boxqty,
                    `dist_medicine_name`.`m_min_qty` as minqty,
                    `dist_medicine_name`.`m_stok` as m_stok
                    FROM `dist_medicine_name` 
                    LEFT JOIN `dist_company_info` ON `dist_medicine_name`.`m_cid`=`dist_company_info`.`c_id`
                    LEFT JOIN `dist_medicine_group`  ON `dist_medicine_name`.`m_gid`=`dist_medicine_group`.`mg_id`
                    LEFT JOIN `dist_medicine_type` ON `dist_medicine_name`.`m_id`=`dist_medicine_type`.`mt_id`
                    WHERE `dist_medicine_name`.`m_min_qty`>0 AND `dist_medicine_name`.`m_stok`<`dist_medicine_name`.`m_min_qty`";
        $Score = $this->db->query($Query);
        return $Score;
    }
    
    public function dailySoldMedicinesFromModel(){
//        $this->db->distinct('invoice_item.i_med_id');
//        $this->db->from('invoice_item');
//        $this->db->join('invoice','invoice.inv_id=invoice_item.i_inv_id','LEFT');
//        $this->db->where('invoice.inv_date', date("Y-m-d"));
        //$this->db->where('invoice_item.i_inv_id', 'Invoices');
        $Score = "SELECT `inv_id` FROM `dist_invoice` WHERE `inv_date`='" . date("Y-m-d") . "'";
        $result = $this->db->query($Score);
        return $result;
    }
    
    public function getDistinctMedicineItems($invid){
        $track = "";
        for($i = 0; $i < count($invid); $i++)
        {
            if($i == count($invid) - 1){
                $track .= "'" . $invid[$i] . "'";    
            }
            else{
                $track .= "'" . $invid[$i] . "',";
            }
        }
        $Query = "SELECT DISTINCT(`i_med_id`), COUNT(`i_med_id`) as Amount FROM `dist_invoice_item` WHERE `i_inv_id` IN (".$track.")";
        $result = $this->db->query($Query);
        return $result;
    }
    
    public function getAllGroupName($gid){
        $this->db->select('*');
        //$this->db->from('medicine_name_test');
        $this->db->from('medicine_group');
        //$this->db->where();
        $this->db->where('medicine_group.mg_id >=', $gid);
        $this->db->where('medicine_group.mg_id <=', ($gid + 50));
        //$this->db->where('medicine_group.mg_id', $gid);
        //$this->db->limit(13, 14);
        $Groups = $this->db->get();
        if($Groups->num_rows() > 0){
            return $Groups;
        } else {
            return FALSE;
        }
    }
    
    public function getAllMedzsName(){
        $this->db->select('*');
        $this->db->from('medicine_name_test');
        //$this->db->from('medicine_group');
        $this->db->order_by('medicine_name_test.m_id', 'DESC');
        $Medzs = $this->db->get();
        if($Medzs->num_rows() > 0){
            return $Medzs;
        } else {
            return FALSE;
        }
    }
    
    public function updateMedicineGroupId($m_id, $mg_id){
        $Array = array('medicine_name_test.m_gid' => $mg_id);
        $this->db->where('medicine_name_test.m_id', $m_id);
        $this->db->update('medicine_name_test', $Array);
    }
 } 
?>
