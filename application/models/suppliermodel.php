<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class suppliermodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function add_new_supplier($companyData, $company_credit){
        $this->db->trans_begin();
        $this->db->insert('company_info', $companyData);
        $company = $this->db->insert_id();
        $company_credit['company'] = $company;
        $this->db->insert('company_credit_adjustment', $company_credit);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function getIndividualSupplierInformation($cid){
       $this->db->select('*');
        $this->db->from('company_info');
        $this->db->where('c_id', $cid);
        $comp = $this->db->get();
        if($comp->num_rows() == 1){
            return $comp->row();
        }
        else{
            return FALSE;
        }
    }
    
    public function get_supplier_list(){
        $this->db->select('company_info.c_id AS c_id, company_info.c_name, company_info.c_contact, company_info.c_phone,
            company_info.c_mobile, company_info.c_address, company_info.c_email, company_info.c_credit AS Balance,
            (SELECT SUM(dist_order.or_total) FROM dist_order WHERE dist_order.or_company=c_id) AS Purchased, 
            (SELECT SUM(dist_order_payment.op_amount) FROM dist_order_payment WHERE dist_order_payment.op_or_company=c_id) AS Payment');
        $this->db->from('company_info');
        $this->db->order_by('company_info.c_name', 'ASC');
        $comp = $this->db->get();
        if($comp->num_rows() > 0){
            return $comp;
        } else {
            return FALSE;
        }
    }
    
    public function updateIndividualSupplierInformation($companyData){
        $this->db->trans_begin();
        $this->db->where('c_id', $companyData['c_id']);
        $this->db->update('company_info', $companyData);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function get_supplier_name_by_supplier_id($supplier){
        $this->db->select('company_info.c_name');
        $this->db->from('company_info');
        $this->db->where('company_info.c_id', $supplier);
        $company = $this->db->get()->row();
        return $company->c_name;
    }
    
    public function get_supplier_ledger_head(){
        $this->db->select('*');
        $this->db->from('company_credit_ledger');
        $this->db->where('company_credit_ledger.edit', 1);
        $this->db->order_by('company_credit_ledger.ledger', 'ASC');
        $ledger = $this->db->get();
        if($ledger->num_rows() > 0){
            return $ledger;
        } else {
            return FALSE;
        }
    }
    
    public function get_supplier_voucher($cid){
        $this->db->select('company_credit_adjustment.*, company_credit_ledger.ledger AS LedgerText');
        $this->db->from('company_credit_adjustment');
        $this->db->where('company_credit_adjustment.company', $cid);
        $this->db->join('company_credit_ledger', 'company_credit_ledger.tble_id = company_credit_adjustment.ledger', 'LEFT');
        $this->db->order_by('company_credit_adjustment.adjust_date', 'DESC');
        $this->db->order_by('company_credit_adjustment.tble_id', 'DESC');
        //$this->db->limit(100);
        $voucher = $this->db->get();
        if($voucher->num_rows() > 0){
            return $voucher;
        } else {
            return FALSE;
        }
    }
    
    public function search_supplier_voucher($FilterKey){
        $this->db->select('company_credit_adjustment.*, company_credit_ledger.ledger AS LedgerText');
        $this->db->from('company_credit_adjustment');
        $this->db->where('company_credit_adjustment.company', $FilterKey['supplier']);
        $this->db->where('company_credit_adjustment.ledger', $FilterKey['ledger']);
        $this->db->where('company_credit_adjustment.adjust_date >=', $FilterKey['starting']);
        $this->db->where('company_credit_adjustment.adjust_date <=', $FilterKey['endngday']);
        $this->db->join('company_credit_ledger', 'company_credit_ledger.tble_id = company_credit_adjustment.ledger', 'LEFT');
        $this->db->order_by('company_credit_adjustment.adjust_date', 'DESC');
        $this->db->order_by('company_credit_adjustment.tble_id', 'DESC');
        $voucher = $this->db->get();
        if($voucher->num_rows() > 0){
            return $voucher;
        } else {
            return FALSE;
        }
    }
    
    public function add_new_incentive_policy($incentive){
        $this->db->trans_begin();
        $this->db->select('company_incentive_policy.tble_id');
        $this->db->from('company_incentive_policy');
        $this->db->where('company_incentive_policy.company_id', $incentive['company_id']);
        $this->db->where('company_incentive_policy.month', $incentive['month']);
        $this->db->where('company_incentive_policy.year', $incentive['year']);
        $exits = $this->db->get();
        if($exits->num_rows() > 0 || $exits->num_rows() == 1){
            $this->db->where('company_incentive_policy.company_id', $incentive['company_id']);
            $this->db->update('company_incentive_policy', $incentive);
        } else {
            $this->db->insert('company_incentive_policy', $incentive);
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }


    public function get_supplier_incentive(){
        $this->db->select('company_incentive_policy.tble_id AS Id, company_incentive_policy.policy AS Policy, company_incentive_policy.month AS Month,
            company_incentive_policy.year AS Year, company_incentive_policy.target AS Target, company_incentive_policy.incentive AS Incentive, company_incentive_policy.type AS Type,
            company_incentive_policy.company_id AS Supplier, company_info.c_name AS Company');
        $this->db->from('company_incentive_policy');
        $this->db->join('company_info', 'company_info.c_id = company_incentive_policy.company_id', 'LEFT');
        $this->db->order_by('company_info.c_name', 'ASC');
        $incentive = $this->db->get();
        if($incentive->num_rows() > 0){
            return $incentive;
        } else {
            return FALSE;
        }
    }
    
    public function get_supplier_incentive_month_year($month, $year){
        $this->db->select('company_incentive_policy.tble_id AS Id, company_incentive_policy.policy AS Policy, company_incentive_policy.month AS Month,
            company_incentive_policy.year AS Year, company_incentive_policy.target AS Target, company_incentive_policy.incentive AS Incentive, company_incentive_policy.type AS Type,
            company_incentive_policy.company_id AS Supplier, company_info.c_name AS Company');
        $this->db->from('company_incentive_policy');
        $this->db->where('company_incentive_policy.month', $month);
        $this->db->where('company_incentive_policy.year', $year);
        $this->db->join('company_info', 'company_info.c_id = company_incentive_policy.company_id', 'LEFT');
        $this->db->order_by('company_info.c_name', 'ASC');
        $incentive = $this->db->get();
        if($incentive->num_rows() > 0){
            return $incentive;
        } else {
            return FALSE;
        }
    }
    
    public function calculate_supplier_incentive_payment_percentage($supplier, $starting, $finishg){
        $this->db->select('SUM(' . $this->db->dbprefix . 'company_credit_adjustment.amount) AS Payment');
        $this->db->from('company_credit_adjustment');
        $this->db->where('company_credit_adjustment.company', $supplier);
        $this->db->where('company_credit_adjustment.adjust_date >=', $starting);
        $this->db->where('company_credit_adjustment.adjust_date <=', $finishg);
        $this->db->where('company_credit_adjustment.ledger', 2);
        $payment = $this->db->get();
        if($payment->num_rows() == 1) {
            $payment = $payment->row();
            return $payment->Payment;
        } else {
            return 0;
        }
    }
    
    public function calculate_supplier_incentive_payment_fixed($supplier, $starting, $finishg){
        $this->db->select('SUM(' . $this->db->dbprefix . 'company_credit_adjustment.amount) AS Payment');
        $this->db->from('company_credit_adjustment');
        $this->db->where('company_credit_adjustment.company', $supplier);
        $this->db->where('company_credit_adjustment.adjust_date >=', $starting);
        $this->db->where('company_credit_adjustment.adjust_date <=', $finishg);
        $this->db->where('company_credit_adjustment.ledger', 2);
        $payment = $this->db->get();
        if($payment->num_rows() == 1) {
            $payment = $payment->row();
            return $payment->Payment;
        } else {
            return 0;
        }
    }
    
    public function calculate_supplier_incentive_sales_percentage($supplier, $starting, $finishg){
        $this->db->select('SUM(' . $this->db->dbprefix . 'invoice_item.price) AS Sales');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.company_id', $supplier);
        $this->db->where('invoice_item.sale_date >=', $starting);
        $this->db->where('invoice_item.sale_date <=', $finishg);
        $sales = $this->db->get();
        if($sales->num_rows() == 1) {
            $sales = $sales->row();
            return $sales->Sales;
        } else {
            return 0;
        }
    }
    
    public function calculate_supplier_incentive_sales_fixed($supplier, $starting, $finishg){
        $this->db->select('SUM(' . $this->db->dbprefix . 'invoice_item.price) AS Sales');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.company_id', $supplier);
        $this->db->where('invoice_item.sale_date >=', $starting);
        $this->db->where('invoice_item.sale_date <=', $finishg);
        $sales = $this->db->get();
        if($sales->num_rows() == 1) {
            $sales = $sales->row();
            return $sales->Sales;
        } else {
            return 0;
        }
    }
    
    public function get_supplier_credit($key) {
        $this->db->select('company_info.c_credit');
        $this->db->from('company_info');
        $this->db->where('company_info.c_id', $key);
        $credit = $this->db->get();
        if($credit->num_rows() == 1){
            $credit = $credit->row();
            return $credit->c_credit;
        } else {
            return 0;
        }
    }
    
    public function check_adjusted_incentive($credit_adjust){
        $this->db->select('company_monthwise_incentive.tble_id');
        $this->db->from('company_monthwise_incentive');
        $this->db->where('company_monthwise_incentive.company_id', $credit_adjust['company_id']);
        $this->db->where('company_monthwise_incentive.month', $credit_adjust['month']);
        $this->db->where('company_monthwise_incentive.year', $credit_adjust['year']);
        $incentive = $this->db->get();
        if($incentive->num_rows() > 0){
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function incentive_credit_to_supplier_account($credit_adjust, $company_info, $m_incentive){
        $this->db->trans_begin();
        $this->db->insert('company_credit_adjustment', $credit_adjust);
        $this->db->where('company_info.c_id', $company_info['c_id']);
        $this->db->update('company_info', $company_info);
        $this->db->insert('company_monthwise_incentive', $m_incentive);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
}
?>