<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class login extends CI_Controller {
    
    public $Public_Vars = array();
    public $Sesson_Vars = array();
    public $Merged_Data = array();


    public function __construct() {
        parent::__construct();
        $this->Public_Vars = $this->property();
        $this->Merged_Data = $this->Public_Vars;
        $this->Merged_Data['warning'] = FALSE;
        $this->Merged_Data['locked']  = FALSE;
        if($this->session->userdata('auth')){
            $this->Sesson_Vars   = $this->session->userdata('auth');
            if($this->Sesson_Vars['role'] == 2){
               redirect('sales','refresh');
            }
            elseif($this->Sesson_Vars['role'] == 3){
                redirect('dashboard','refresh');
            }
            elseif($this->Sesson_Vars['role'] == 1){
                redirect('dashboard','refresh');
            }
        }
    }

    
    public function index(){
        if($this->input->post('trigger')){
            $this->form_validation->set_rules('password', 'Password', 'required|xss_clean');
            if($this->form_validation->run() === FALSE){
                $this->session->set_flashdata('errorData',  '<div class="alert alert-error"><strong>' . validation_errors() . '</strong></div>');
                redirect('login');
            } else {
                $Score = $this->loginmodel->login($this->input->post('uid'), $this->input->post('password'));
                if($Score != FALSE){
                    $now = time();
                    foreach ($Score->result() as $Score){
                        $this->session->set_userdata('auth', array('memb' => $Score->u_id, 'name' => $Score->u_name, 'pass' => $Score->u_pass, 'fone' => $Score->u_phone, 'fone1' => $Score->u_phone1, 'address'=>$Score->u_address, 'role' => $Score->r_id, 'b_id' => $Score->b_id, 'email' => $Score->u_email, 'time' => date('h:i:s A'), 'session' => $this->session->userdata('session_id'), 'remote' => $this->input->ip_address()));
                        $log_sess = $this->session->userdata('auth');
                        $log_data = array('lg_id' => $log_sess['session'], 'lg_date' => date("Y-m-d"), 'lg_time' => $log_sess['time'], 'lg_ip' => $this->input->ip_address(), 'u_id' => $log_sess['memb']);
                        $this->loginmodel->userlogdata($log_data);
                        $this->loginmodel->remove_temp_item($Score->u_id);
                        switch ($log_sess['role']){
                            case 2:
                            {
                                redirect('dashboard','refresh');
                                break;
                            }
                            case 3:
                            {
                                redirect('dashboard','refresh');
                                break;                                
                            }
                        }
                    }
                  
                }
                else{
                    $now = time();
                    $this->session->set_flashdata('errorData',  '<div class="alert alert-error"><strong>Incorrect Username or Password</strong></div>');
                    redirect('login');
                }
            }
        }
        else{
            $this->session->unset_userdata('auth');
            $this->load->view('login/index', $this->Merged_Data);
        }
    }
}