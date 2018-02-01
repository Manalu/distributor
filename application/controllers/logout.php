<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class logout extends CI_Controller {
    
    public $Public_Vars     = array();
    public $Sesson_Vars     = array();
    public $Merged_Data     = array();
            
    public function __construct(){
        parent::__construct();
        $this->Public_Vars = $this->property();
        if($this->session->userdata('auth')){
            $this->Sesson_Vars   = $this->session->userdata('auth');
        }
        $this->Merged_Vars = array_merge($this->Public_Vars, $this->Sesson_Vars);
    }
    
    public function index(){
        $log_data = array(
            'lg_id' => $this->session->userdata('session_id'),//$this->Sesson_Vars['session'],
            'lo_date' => date("Y-m-d"),
            'lo_time' => date("h:i:s A"),
            'lg_ip' => $this->input->ip_address(), //$this->Sesson_Vars['remote'],
            'u_id' => $this->Sesson_Vars['memb']
                );
        $this->loginmodel->updateUserLogData($log_data);
        $this->session->unset_userdata('auth');
        $this->session->sess_destroy();
        redirect(base_url(), 'refresh');
    }
}
?>
