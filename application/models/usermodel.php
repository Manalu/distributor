<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class usermodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function GetDept(){
        $this->db->select("*");
        $this->db->from('role');
        $role  = $this->db->get();
        return $role->result();
    }
    
    public function add($userData){
        $this->db->insert('user', $userData);
    }
    
    public function GetUser($uid = FALSE){
        $this->db->select('user_info.u_id as id,user_info.u_name as name ,user_info.u_phone as phone1,user_info.u_phone1 as phone,user_info.u_phone1 as phone2,u_address as addr,user_info.r_id as deptid,user_info.u_status as staus');
        $this->db->from('user_info');
        //$this->db->join('role', 'user_info.r_id = role.r_id');
        $this->db->where('u_status !=1');
        if($uid != FALSE){
            $this->db->where('user_info.u_id',$uid);
        }
        $this->db->order_by('user_info.u_id','DESC');
        $user  = $this->db->get();
        return $user->result();        
    }
    
    public function Edit($userData){
        $this->db->where('u_id', $userData['u_id']);
        $this->db->update('user_info', $userData);
    }
    
    public function getForgoten(){
        $this->db->select("*");
        $this->db->from('user_info');
        $this->db->where('u_status',"2");
        $user  = $this->db->get();
        return $user->result();
    }
    
    public function changeState($uid,$set=FALSE){
          $this->db->where('u_id', $uid);
         if($uid !=FALSE && $set ==FALSE){
             $this->db->update('user_info', array('u_status'=>0));
         }
         else{
            $this->db->update('user_info', array('u_status'=>1)); 
         }
        
    }
    
    public function UpdateInfo($ProfileData){
        $Data = array('u_name' => $ProfileData['u_name'], 'u_address' => $ProfileData['u_address'], 'u_phone' => $ProfileData['u_phone'], 'u_phone1' => $ProfileData['u_phone1'], 'u_email' => $ProfileData['u_email']);
        $this->db->where('user_info.u_id',$ProfileData['u_id']);
        if($this->db->update('user_info',$Data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function getUserNameByUserId($userid){
        $this->db->select('user_info.u_name');
        $this->db->from('user_info');
        $this->db->where('user_info.u_id', $userid);
        $Name = $this->db->get()->row();
        return $Name->u_name;
    }
    
    public function getAllUserList($stat){
        $this->db->select('*');
        $this->db->from('user_info');
        $this->db->where('user_info.u_status', $stat);
        $Users = $this->db->get();
        if($Users->num_rows() > 0){
            return $Users;
        }
        else{
            return FALSE;
        }
    }
    
    public function getAllUserListForStats($stat){
        $this->db->select('u_id, u_name');
        $this->db->from('user_info');
        $this->db->where('user_info.u_status', $stat);
        $Users = $this->db->get();
        if($Users->num_rows() > 0){
            return $Users;
        }
        else{
            return FALSE;
        }
    }
    
    public function getAllStatsDetailsOfUser($user){
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_uid', $user);
        $Users = $this->db->get();
        if($Users->num_rows() > 0){
            return $Users;
        }
        else{
            return FALSE;
        }
    }
 } 
?>
