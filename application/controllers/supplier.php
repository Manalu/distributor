<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 * @author  Exploria Solution
 * @name    Tarek Showkot
 * @contact priom2000@gmail.com, tarek@exploriasolution.com
 *
 */
class supplier extends CI_Controller {
    //put your code here
    
    public $Public_Vars = array();
    public $Sesson_Vars = array();
    public $Merged_Vars = array();

    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('auth')){
            redirect('login','refresh');
        }
        else{
            $this->Public_Vars = $this->property();
            $this->Sesson_Vars = $this->session->userdata('auth');
            if($this->Sesson_Vars['role'] != 3 && $this->Sesson_Vars['role'] != 2 && $this->Sesson_Vars['role'] != 1){
                redirect('login','refresh');
            }
            else{
                $this->Merged_Vars = array_merge($this->Public_Vars, $this->Sesson_Vars);
            }
        }
    }
    
    public function index(){
        redirect(__CLASS__ . '/supplierlist');
    }
    
    public function supplierlist(){
        $this->Merged_Vars['printer']   = 'Supplier List ';
        $this->Merged_Vars['company']   = $this->suppliermodel->get_supplier_list();
        $this->loadView(__CLASS__, __FUNCTION__,  $this->Merged_Vars);
    }
    
    public function newsupplier(){
        if(!$this->input->post()){
            $this->loadView(__CLASS__,__FUNCTION__, $this->Merged_Vars);
        }
        else {
            $this->form_validation->set_rules('c_name', 'Company Name', 'required|xss_clean');
            $companyData = array('c_name' => $this->input->post('c_name'), 'c_contact' => $this->input->post('c_contact'), 'c_phone' => $this->input->post('c_phone'), 'c_mobile' => $this->input->post('c_mobile'), 'c_address' => $this->input->post('c_address'), 'c_email' => $this->input->post('c_email'), 'c_credit' => $this->input->post('c_credit'), 'c_status' => 1);
            $company_credit = array('company' => 0, 'ledger' => 7, 'amount' => $this->input->post('c_credit'), 'notes' => 'Opening Balance - New Supplier Create', 'adjust_date' => date('Y-m-d'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            $Score = $this->suppliermodel->add_new_supplier($companyData, $company_credit);
            if($Score) {
                $this->session->set_flashdata('agedata', greensignal('New Supplier Information Created!!'));
                redirect(__CLASS__ . '/supplierlist');
            } else {
                $this->session->set_flashdata('agedata', errormessage());
                redirect(__CLASS__ . '/' . __FUNCTION__);
            }
        }
    }
    
    public function updatesupplier(){
        if(!$this->input->post()){
            $this->Merged_Vars['c_id']          = $this->input->get('c_id');
            $this->Merged_Vars['company']       = $this->suppliermodel->getIndividualSupplierInformation($this->Merged_Vars['c_id']);
            $this->loadView(__CLASS__ , __FUNCTION__, $this->Merged_Vars);
        }
        else{
            $companyData = array('c_id' => $this->input->post('c_id'), 'c_name' => $this->input->post('c_name'), 'c_contact' => $this->input->post('c_contact'), 'c_phone' => $this->input->post('c_phone'), 'c_mobile' => $this->input->post('c_mobile'), 'c_address' => $this->input->post('c_address'), 'c_email' => $this->input->post('c_email'));
            $Score = $this->suppliermodel->updateIndividualSupplierInformation($companyData);
            if($Score) {
                $this->session->set_flashdata('agedata', greensignal('Supplier Information Updated!!'));
                redirect(__CLASS__ . '/' . __FUNCTION__ . '?c_id=' . $companyData['c_id']);
            } else {
                $this->session->set_flashdata('agedata', errormessage());
                redirect(__CLASS__ . '/' . __FUNCTION__ . '?c_id=' . $companyData['c_id']);
            }
        }
    }
    
    public function ledger(){
        $this->Merged_Vars['c_name']              = $this->suppliermodel->get_supplier_name_by_supplier_id($this->input->get('c_id'));
        $this->Merged_Vars['printer']             = $this->Merged_Vars['c_name'] . ' Statement for Credit Deposit & Purchase Adjustment';
        $this->Merged_Vars['credit_voucher']      = $this->suppliermodel->get_supplier_voucher($this->input->get('c_id'));
        $this->Merged_Vars['purpoz']              = $this->suppliermodel->get_supplier_ledger_head();
        $this->Merged_Vars['supplier_id']         = $this->input->get('c_id');
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function ledger_search(){
        $FilterKey = array( 'supplier' => '', 'starting' => '', 'endngday' => '', 'ledger' => '');
        if($this->input->post('supplier')){
            $FilterKey['supplier'] = $this->input->post('supplier');
        }
        if($this->input->post('starting')){
            $FilterKey['starting'] = $this->input->post('starting');
        }
        if($this->input->post('endngday')){
            $FilterKey['endngday'] = $this->input->post('endngday');
        }
        if($this->input->post('ledger')){
            $FilterKey['ledger'] = $this->input->post('ledger');
        }
        $this->Merged_Vars['credit_voucher']      = $this->suppliermodel->search_supplier_voucher($FilterKey); 
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function incentive_policy(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "incentive_policy")){
            $type = $this->input->post('type');
            if($type === "Percentage"){
                if($this->input->post('value') > 90){
                    $this->session->set_flashdata('notification', errormessage('Please provide a proper value in the amount field'));
                    redirect('supplier/incentivepolicy', 'refresh');
                }
            }
            $incentive  = array('company_id' => $this->input->post('company_id'), 'month' => $this->input->post('month'), 'year' => $this->input->post('year'), 'policy' => $this->input->post('policy'), 'target' => $this->input->post('target'), 'incentive' => $this->input->post('incentive'), 'type' => $type);
            $score      = $this->suppliermodel->add_new_incentive_policy($incentive);
            if($score){
                $this->session->set_flashdata('notification', greensignal('New Incentive Policy Setup Complete'));
                redirect('supplier/incentivepolicy', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later.'));
                redirect('supplier/incentivepolicy', 'refresh');
            }
        } else {
            $this->Merged_Vars['sups']                = $this->suppliermodel->get_supplier_list();
            $this->Merged_Vars['incentive']           = $this->suppliermodel->get_supplier_incentive();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function incentive_calculation(){
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function calculate_incentive(){
        $date = "01-" . $this->input->post('month') . '-' . $this->input->post('year');
        $this->Merged_Vars['starting']                = date_format(date_create($date), 'Y-m-d');
        $this->Merged_Vars['finishig']                = date_format(date_create($date), 'Y-m-t');
        $this->Merged_Vars['incentive']               = $this->suppliermodel->get_supplier_incentive_month_year($this->input->post('month'), $this->input->post('year'));
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function creditpost_incentive_adjust(){
        $credit_adjust  = array('company' => $this->input->get('supplier'), 'ledger' => 5, 'amount' => $this->input->get('amount'), 'notes' => 'Incentive for Month of ' . $this->input->get('month'), 'adjust_date' => date('Y-m-d'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
        $current_credt  = $this->suppliermodel->get_supplier_credit($this->input->get('supplier'));
        $balance        = $current_credt + $this->input->get('amount');
        $company_info   = array('c_id' => $this->input->get('supplier'), 'c_credit' => $balance);
        $m_incentive    = array('company_id' => $this->input->get('supplier'), 'month' => $this->input->get('month'), 'year' => $this->input->get('year'), 'amount' => $this->input->get('amount'));
        $checking       = $this->suppliermodel->check_adjusted_incentive($m_incentive);
        if($checking){
            $score          = $this->suppliermodel->incentive_credit_to_supplier_account($credit_adjust, $company_info, $m_incentive);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Incentive has been creditted to Supplier Account'));
                redirect('supplier/incentivecalculate', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later.'));
                redirect('supplier/incentivecalculate', 'refresh');
            }
        } else {
            $this->session->set_flashdata('notification', errormessage('Incentive for ' . $this->input->get('month') . ' month has been previously adjusted.'));
            redirect('supplier/incentivecalculate', 'refresh');
        }
    }
}
?>