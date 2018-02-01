<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class loginmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function login($uid, $pass){
        $this->db->select('*');
        $this->db->from('user_info');
        $this->db->where('u_email = "'.$uid.'"');
        $this->db->where('u_pass = "'. md5($pass) .'"');
        $this->db->where('u_status', 1);
        $result = $this->db->get();
        if($result->num_rows() == 1){
            return $result; 
        }
        else {
            return false;
        }
    }
    
    public function userlogdata($log_data){
        //$this->db->insert('user_log', $log_data); 
        return NULL;
    }
    
    public function updateUserLogData($log_data){
//        $data = array('lo_date' => $log_data['lo_date'], 'lo_time' => $log_data['lo_time']);
//        $this->db->where('user_log.lg_id', $log_data['lg_id']);
//        $this->db->where('user_log.u_id', $log_data['u_id']);
//        $this->db->where('user_log.lg_ip', $log_data['lg_ip']);
//        $this->db->update('user_log', $data);
        return NULL;
    }
    
    public function remove_temp_item($user){
        $this->db->where('invoice_item_temp.post_by', $user);
        $this->db->delete('invoice_item_temp');
    }


    public function lockState($activator){
        if($activator == "0"){
            $data = array('shp_web' => $activator, 'shp_backup' => date("Y-m-d"));
        }
        else{
            $data = array('shp_web' => $activator);
        }
        if($this->db->update('store_info', $data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
}

?>
