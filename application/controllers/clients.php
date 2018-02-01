<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 * @author  Invictus Cody 
 * @name    Tarek Showkot
 * @contact priom2000@gmail.com
 *
 */
class clients extends CI_Controller {
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
            if($this->Sesson_Vars['role'] != 3 && $this->Sesson_Vars['role'] != 2){
                redirect('login','refresh');
            }
            else{
                $this->Merged_Vars = array_merge($this->Public_Vars, $this->Sesson_Vars);
            }
        }
    }
    
    public function index(){
        redirect(__CLASS__ . '/lstclnt');
    }
    
    public function lstclnt(){
        $this->Merged_Vars['printer']   = 'Client List Database ';
        $this->Merged_Vars['clnts']     = $this->clientsmodel->get_client_list(1);
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function search_customer_list(){
        $FilterData         = array('cl_name' => "", 'cl_phone_no' => "", 'cl_mobile_no' => "", 'natid' => "");
        if($this->input->post('clname')) {
            $FilterData['cl_name'] = $this->input->post('clname');
        }
        if($this->input->post('clphone')) {
            $FilterData['cl_phone_no'] = $this->input->post('clphone');
        }
        if($this->input->post('clmobile')) {
            $FilterData['cl_mobile_no'] = $this->input->post('clmobile');
        }
        if($this->input->post('natid')) {
            $FilterData['natid'] = $this->input->post('natid');
        }
        $this->Merged_Vars['clnts'] = $this->clientsmodel->search_clients($FilterData);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function newclnt(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "createclient")){
            $this->form_validation->set_rules('cl_national_id', 'Customer National ID', 'required|xss_clean');
            if($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('notification', errormessage(validation_errors()));
                redirect(__CLASS__ . '/new', 'refresh');
            } else {
                $customer_array = array('cl_name' => $this->input->post('cl_name'), 'cl_phone_no' => $this->input->post('cl_phone_no'), 'cl_mobile_no' => $this->input->post('cl_mobile_no'), 'cl_national_id' => $this->input->post('cl_national_id'), 'cl_email' => $this->input->post('cl_email'), 'cl_balance' => $this->input->post('cl_balance'), 'cl_type' => $this->input->post('cl_type'));
                $client_ledger  = array('client_id' => 0, 'ledger_id' => 1, 'ledger_type' => 1, 'amount' => $this->input->post('cl_balance'), 'invoice_id' => 0, 'notes' => 'Opening Balance - New Client Creation', 'ledger_date' => date('Y-m-d'), 'posting_date' => date('Y-m-d H:i:s'), 'posting_by' => $this->Merged_Vars['memb']);
                $score = $this->clientsmodel->add_new_client($customer_array, $client_ledger);
                if($score){
                    $this->session->set_flashdata('notification', greensignal('New Customer Created!!'));
                    redirect(__CLASS__ . '/list', 'refresh');
                } else {
                    $this->session->set_flashdata('notification', errormessage());
                    redirect(__CLASS__ . '/new', 'refresh');
                }
            }
        }
        else{
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function editclnt(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "updateclient")){
            $customer_array = array('cl_id' => $this->input->post('clid'), 'cl_name' => $this->input->post('cl_name'), 'cl_phone_no' => $this->input->post('cl_phone_no'), 'cl_mobile_no' => $this->input->post('cl_mobile_no'), 'cl_national_id' => $this->input->post('cl_national_id'), 'cl_email' => $this->input->post('cl_email'), 'cl_type' => $this->input->post('cl_type'));
            $score = $this->clientsmodel->updateClientInfo($customer_array);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Customer Information Updated!!'));
                redirect('clients/list', 'refresh');
            }
            else{
                $this->session->set_flashdata('notification', errormessage());
                redirect('clients/update?cl_id=' . $this->input->post('clid'), 'refresh');
            }
        }
        else{
            $this->Merged_Vars['detls'] = $this->clientsmodel->getClientDetails($this->input->get('cl_id'));
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function client_ledger(){
        $this->Merged_Vars['printer']       = 'DSR/Customer Ledger List';
        $this->Merged_Vars['back_link']     = 'clients/list';
        $this->Merged_Vars['c_name']        = $this->clientsmodel->get_customer_name($this->input->get('cl_id'));
        $this->Merged_Vars['ledger']        = $this->clientsmodel->get_client_ledger($this->input->get('cl_id'));
        $this->Merged_Vars['cl_id']         = $this->input->get('cl_id');
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function rprtclnt(){
        $this->Merged_Vars[__FUNCTION__] = $this->clientsmodel->listAllClients();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function viewclnt(){
        $clid                                       = $this->input->get('cl_id');
        $this->Merged_Vars['cl_name']               = $this->clientsmodel->getClientNameByClientIdModelFunc($clid);
        $this->Merged_Vars['cl_phone']              = $this->clientsmodel->getClientPhoneNumberByClientIdModelFunc($clid);
        $this->Merged_Vars['cl_addrs']              = $this->clientsmodel->get_customer_present_a($clid);
        $this->Merged_Vars['clid']                  = $clid;
        $this->Merged_Vars['invoices']              = $this->clientsmodel->get_client_invoices($clid);
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function invoicedetails(){
        if($this->input->post('invtype') == 1){
            $this->Merged_Vars['sale_type']         = 'Cash Sale';
            $this->Merged_Vars['inv_id']            = $this->input->post('invid');
            $this->Merged_Vars['client_id']         = $this->input->post('cl_id');
            $this->Merged_Vars['inv_items']         = $this->salesmodel->get_sales_items($this->Merged_Vars['inv_id']);
            $this->Merged_Vars['sale_info']         = $this->salesmodel->sales_details($this->Merged_Vars['inv_id']);
            $this->load->view(__CLASS__ . '/' . __FUNCTION__ . '_' . $this->input->post('invtype'), $this->Merged_Vars);
        } else if($this->input->post('invtype') == 2){
            $this->Merged_Vars['sale_type']         = 'Installment Sale';
            $this->loadView(__CLASS__ . '/' . __FUNCTION__ . '_' . $this->input->post('invtype'), $this->Merged_Vars);
        }
    }
    
    public function opening_balance_adjust(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "opening_balance_adjust")){
            $opening_adjustment_data        = array('client_id' => $this->input->post('client_id'), 'voucher_id' => 0, 'client_ledger_id' => 0, 'amount' => $this->input->post('amount'), 'notes' => $this->input->post('notes'), 'ledger_date' => $this->input->post('ledger_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            $client_ledger                  = array('client_id' => $this->input->post('client_id'), 'ledger_id' => 5, 'ledger_type' => 2, 'amount' => $this->input->post('amount'), 'invoice_id' => 0, 'notes' => $this->input->post('notes'), 'ledger_date' => $this->input->post('ledger_date'), 'posting_date' => date('Y-m-d H:i:s'), 'posting_by' => $this->Merged_Vars['memb']);
            $customer_data                  = array('cl_id' => $this->input->post('client_id'), 'cl_balance' => $this->clientsmodel->get_customer_balance($this->input->post('client_id')) - $this->input->post('amount'));
            $current_balance                = ($this->accountsmodel->get_branch_balance($this->Merged_Vars['b_id']) + $this->input->post('amount'));
            $voucher_data                   = array('branch_id' => $this->Merged_Vars['b_id'], 'method' => 2, 'v_head' => 27, 'v_type' => 1, 'v_amount' => $this->input->post('amount'), 'v_note' => $this->input->post('notes'), 'v_date' => $this->input->post('ledger_date'), 'v_posting_date' => date("Y-m-d"), 'v_posting_by' => $this->Merged_Vars['memb']);
            $cash_in_hand                   = array('branch_id' => $this->Merged_Vars['b_id'], 'balance' => $current_balance);
            $score                          = $this->clientsmodel->opening_balance_adjustment($opening_adjustment_data, $client_ledger, $customer_data, $voucher_data, $cash_in_hand);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Opening Balance Adjusted!!'));
                redirect(__CLASS__ . '/list', 'refresh');
            }
            else{
                $this->session->set_flashdata('notification', errormessage());
                redirect(__CLASS__ . '/list', 'refresh');
            }
            
        } else {
            $this->Merged_Vars['balance']               = $this->clientsmodel->get_customer_opening_balance($this->input->get('cl_id'));
            $this->Merged_Vars['paidmny']               = $this->clientsmodel->get_customer_opening_balance_paid_amount($this->input->get('cl_id'));
            $this->Merged_Vars['customer']              = $this->clientsmodel->get_customer_name($this->input->get('cl_id'));
            $this->Merged_Vars['client_id']             = $this->input->get('cl_id');
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }        
    }
}
?>