<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class dashboard extends CI_Controller {
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
            if($this->Sesson_Vars['role'] != 3 && $this->Sesson_Vars['role'] != 1 && $this->Sesson_Vars['role'] != 2){
                redirect('login','refresh');
            }
            else{
                $this->Merged_Vars = array_merge($this->Public_Vars, $this->Sesson_Vars);
            }
        }
    }
    
    public function index(){
        $this->Merged_Vars['pending_list']              = $this->ordermodel->get_pending_order_list();
        $FilterData                                     = array('supplier' => "", 'or_comp_memo' => "", 'start' => "", 'finish' => "", 'status' => 1);
        $this->Merged_Vars['order_list']                = $this->ordermodel->get_order_list($FilterData);
        $this->Merged_Vars['invoices']                  = $this->salesmodel->get_due_invoice_list(1);
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
}
?>