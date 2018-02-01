<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class settingsmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_branch_list(){
        $this->db->select('*');
        $this->db->from('branch');
        $this->db->where('branch.b_status', 1);
        $this->db->order_by('branch.b_name', 'ASC');
        $broker = $this->db->get();
        if($broker->num_rows() > 0){
            return $broker;
        } else {
            return FALSE;
        }
    }
    
    public function get_source_list($bid){
        $this->db->select('*');
        $this->db->from('branch');
        $this->db->where('branch.b_status', 1);
        $this->db->where('branch.tble_id !=', $bid);
        $this->db->order_by('branch.b_name', 'ASC');
        $broker = $this->db->get();
        if($broker->num_rows() > 0){
            return $broker;
        } else {
            return FALSE;
        }
    }
    
    public function add_new_branch($branch_data, $balance){
        $this->db->trans_begin();
        $this->db->insert('branch', $branch_data);
        $branch_id = $this->db->insert_id();
        $cash_in_hand = array('branch_id' => $branch_id, 'balance' => $balance);
        $this->db->insert('store_cash_in_hand', $cash_in_hand);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function update_branch_info($branch_data){
        $this->db->where('branch.tble_id', $branch_data['tble_id']);
        if($this->db->update('branch', $branch_data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function get_branch_name($branch){
        $this->db->select('branch.b_name');
        $this->db->from('branch');
        $this->db->where('branch.tble_id', $branch);
        $broker = $this->db->get();
        if($broker->num_rows() == 1){
            $broker = $broker->row();
            return $broker->b_name;
        } else {
            return "No Branch";
        }
    }
    
    public function get_payment_method(){
        $this->db->select('*');
        $this->db->from('payment_method');
        $this->db->where('payment_method.status', 1);
        $methods = $this->db->get();
        if($methods->num_rows() > 0){
            return $methods;
        } else {
            return FALSE;
        }
    }
    
    public function getStoreInformationForSettingsController(){
        $this->db->select('*');
        $this->db->from('store_info');
        $shp = $this->db->get();
        return $shp->row();
    }
    
    public function getStoreInformationForOrderController(){
        $this->db->select('*');
        $this->db->from('store_info');
        $this->db->where('shp_id', 2);
        $shp = $this->db->get();
        return $shp->result();
    }
    
    public function getShopInfo(){
        $this->db->select('*');
        $this->db->from('store_info');
        $this->db->where('shp_id', 1);
        $shp = $this->db->get();
        if($shp->num_rows() == 1){
            return $shp->row();
        }
        else{
            return FALSE;
        }
    }
    
    public function get_shop_info_by_shpid($shpid){
        $this->db->select('*');
        $this->db->from('store_info');
        $this->db->where('shp_id', $shpid);
        $shp = $this->db->get();
        if($shp->num_rows() == 1){
            return $shp->row();
        }
        else{
            return FALSE;
        }
    }
    
    public function editStoreInformationForSettingsController($shopdata){
        $this->db->where('shp_id',1);
        $this->db->update('store_info', $shopdata);
    }
    
    public function CountAllLog(){
         return $this->db->count_all_results('log');
    }
    
    //public function GetAllLog($limit,$start){
    public function GetAllLog(){
        $this->db->select('log.lg_date as date,log.lg_time as time , user.u_name as user , role.r_name as dept,log.lg_ip as ip');
        $this->db->from('log');
        $this->db->join('user','user.u_id = log.u_id');
        $this->db->join('role','role.r_id = log.r_id');
        $this->db->order_by("lg_id","ASC");
        //$this->db->limit($limit, $start);
        $comp = $this->db->get();
        if($comp->num_rows() > 0){
            return $comp;
        }
        else{
            return FALSE;
        }
    }
    
    public function logSearch($start,$end,$user=FALSE){
        $this->db->select('log.lg_date as date,log.lg_time as time , user.u_name as user , role.r_name as dept,log.lg_ip as ip');
        $this->db->from('log');
        $this->db->join('user','user.u_id = log.u_id');
        $this->db->join('role','role.r_id = log.r_id');
        $this->db->where('log.lg_date >="'.$start.'"');
        $this->db->where('log.lg_date <="'.$end.'"');
        if($user !=FALSE){
             $this->db->where('log.u_id',$user);
        }
        $this->db->order_by("lg_id","desc");
         $comp = $this->db->get();
        if($comp->num_rows()>0){
            return $comp;
        }
        else{
            return FALSE;
        }
    }
    
    //public function getAllUserListForSettingsController(){
    public function get_software_user_list(){
        $this->db->select('user_info.*, branch.b_name AS Branch');
        $this->db->from('user_info');
        $this->db->where('user_info.r_id !=', 4);
        $this->db->join('branch', 'branch.tble_id = user_info.b_id', 'LEFT');
        $this->db->order_by('user_info.u_name','asc');
        $Users = $this->db->get();
        if($Users->num_rows() > 0){
            return $Users;
        }
        else{
            return FALSE;
        }
    }
    
    public function get_loan_investment_user(){
        $this->db->select('user_info.*, branch.b_name AS Branch');
        $this->db->from('user_info');
        $this->db->where('user_info.r_id', 4);
        $this->db->join('branch', 'branch.tble_id = user_info.b_id', 'LEFT');
        $this->db->order_by('user_info.u_name','asc');
        $Users = $this->db->get();
        if($Users->num_rows() > 0){
            return $Users;
        }
        else{
            return FALSE;
        }
    }
    
    public function getUserInfoByUserId($usrid){
        $this->db->select('user_info.u_name as name, user_info.u_address as address, user_info.u_phone as fone, user_info.u_phone1 as fone1, user_info.u_email as email, user_info.u_status as status, user_info.r_id as role, user_info.b_id as b_id, user_info.u_registrd as registered, user_info.u_id as UserId, user_info.u_status as u_status');
        $this->db->from('user_info');
        $this->db->where('user_info.u_id', $usrid);
        $UserInfo = $this->db->get()->row();
        return $UserInfo;
    }
    
    public function updateUserInfoFromSettings($UserData){
        $this->db->where('user_info.u_id', $UserData['u_id']);
        $this->db->update('user_info', $UserData);
    }
    
    public function updateDbBackUpTime($shp_backup){
        $array = array(
            'shp_id' => '1',
            'shp_backup' => $shp_backup
        );
        $this->db->where('store_info.shp_id', $array['shp_id']);
        $this->db->update('store_info', $array);
    }
    
    public function create_new_software_user($user_info_data){
        if($this->db->insert('user_info', $user_info_data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function getPreviousClosingData(){
        $this->db->select('*');
        $this->db->from('closing');
        $this->db->where('closing.closing_date <', date("Y-m-d"));
        $this->db->order_by('closing.tble_id','DESC');
        $this->db->limit(7);
        $Result = $this->db->get();
        if($Result->num_rows() > 0){
            return $Result;
        }
        else{
            return 0;
        }
    }
    
    public function getAllCashinForTheDay($today){
        $this->db->select_sum('cashin.ci_amount');
        $this->db->from('cashin');
        $this->db->where('cashin.ci_date', $today);
        $Result = $this->db->get()->row();
        return $Result->ci_amount;
    }
    
    public function getAllCashoutForTheDay($today){
        $this->db->select_sum('cashout.co_amount');
        $this->db->from('cashout');
        $this->db->where('cashout.co_date', $today);
        $Result = $this->db->get()->row();
        return $Result->co_amount;
    }
    
    public function getPreviousCashinHandForTheDay($today){
        $this->db->select('closing.cl_balance');
        $this->db->from('closing');
        $this->db->where('closing.cl_date', date("Y-m-d", strtotime('-1 days')));
        $Result = $this->db->get();
        if($Result->num_rows() > 0){
            foreach ($Result->result() as $Result){
                return $Result->cl_balance;
            }
        }
        else{
            $this->db->select('closing.cl_balance, closing.cl_date');
            $this->db->from('closing');
            $this->db->where('closing.cl_date <', date("Y-m-d"));
            $this->db->order_by('closing.cl_id','DESC');
            $this->db->limit(1);
            $Result = $this->db->get();
            if($Result->num_rows() > 0){
                return $Result;
            }
        }
    }
    
    public function updateClosingRecord($ClosingTableData){
        $data = array(
            'cl_balance' => $ClosingTableData['cl_balance'],
            'cl_date' => $ClosingTableData['cl_date'],
            'cl_time' => $ClosingTableData['cl_time'],
            'cl_usr' => $ClosingTableData['cl_usr']
        );
        if($this->db->insert('closing', $data)){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function getAllSaleOfTheDay($range = FALSE){
        $this->db->select_sum('invoice.inv_all_total');
        $this->db->from('invoice');
        if($range === FALSE){
            $this->db->where('invoice.inv_date', date("Y-m-d"));
        }
        else{
            //Search by date range
            $this->db->where('invoice.inv_date >=', $range['starting']);
            $this->db->where('invoice.inv_date <=', $range['endngday']);
        }
        $TotalSale = $this->db->get()->row();
        if($TotalSale){
            return $TotalSale->inv_all_total;
        } else {
            return FALSE;
        }
    }
    
    public function getAllCashSaleOfTheDay($range = FALSE){
        $this->db->select_sum('invoice.inv_all_total');
        $this->db->from('invoice');
        if($range === FALSE){
            $this->db->where('invoice.inv_status', 1);
            $this->db->where('invoice.inv_date', date("Y-m-d"));
        }
        else{
            //Search by date range
            $this->db->where('invoice.inv_status', 1);
            $this->db->where('invoice.inv_date >=', $range['starting']);
            $this->db->where('invoice.inv_date <=', $range['endngday']);
        }
        $TotalSale = $this->db->get()->row();
        if($TotalSale){
            return $TotalSale->inv_all_total;
        } else {
            return FALSE;
        }
    }
    
    public function getAllCardSaleOfTheDay($range = FALSE){
        $this->db->select_sum('invoice.inv_all_total');
        $this->db->from('invoice');
        if($range === FALSE){
            $this->db->where('invoice.inv_status', 3);
            $this->db->where('invoice.inv_date', date("Y-m-d"));
        }
        else{
            //Search by date range
            $this->db->where('invoice.inv_status', 3);
            $this->db->where('invoice.inv_date >=', $range['starting']);
            $this->db->where('invoice.inv_date <=', $range['endngday']);
        }
        $TotalSale = $this->db->get()->row();
        if($TotalSale){
            return $TotalSale->inv_all_total;
        } else {
            return FALSE;
        }
    }
    
    public function getTodaysDueBalance($range = FALSE){
        $this->db->select_sum('invoice.inv_all_total');
        $this->db->from('invoice');
        if($range === FALSE){
            $this->db->where('invoice.inv_status', 0);
            $this->db->where('invoice.inv_date', date("Y-m-d"));
        }
        else{
            //Search by date range
            $this->db->where('invoice.inv_status', 0);
            $this->db->where('invoice.inv_date >=', $range['starting']);
            $this->db->where('invoice.inv_date <=', $range['endngday']);
        }
        $TotalSale = $this->db->get()->row();
        if($TotalSale){
            return $TotalSale->inv_all_total;
        } else {
            return FALSE;
        }
    }
    
    public function getAllCashCollectionOfTheDay($range = FALSE){
        $this->db->select_sum('cashin.ci_amount');
        $this->db->from('cashin');
        if($range === FALSE){
            $this->db->where('cashin.ci_date', date("Y-m-d"));
        }
        else{
            $this->db->where('cashin.ci_date >=', $range['starting']);
            $this->db->where('cashin.ci_date <=', $range['endngday']);
        }
        $CashIn = $this->db->get()->row();
        if($CashIn){
            return $CashIn->ci_amount;
        }
        else{
            return FALSE;
        }
    }
    
    public function getPreviousCashOutForTheDay($range = FALSE){
        $this->db->select_sum('cashout.co_amount');
        $this->db->from('cashout');
        if($range === FALSE){
            $this->db->where('cashout.co_date', date("Y-m-d"));
        }
        else{
            $this->db->where('cashout.co_date >=', $range['starting']);
            $this->db->where('cashout.co_date <=', $range['endngday']);
        }
        $CashoutTotal = $this->db->get()->row();
        if($CashoutTotal){
            return $CashoutTotal->co_amount;
        }
        else{
            return FALSE;
        }
    }
    
    public function getAllCashOutList($range = FALSE){
        $this->db->select('*');
        $this->db->from('cashout');
        if($range === FALSE){
            $this->db->where('cashout.co_date', date("Y-m-d"));
        }
        else{
            $this->db->where('cashout.co_date >=', $range['starting']);
            $this->db->where('cashout.co_date <=', $range['endngday']);
        }
        $this->db->order_by('cashout.co_id', 'desc');
        $Orders = $this->db->get();
        if($Orders->num_rows() > 0){
            return $Orders;
        }
        else{
            return 0;
        }
    }
    
    public function getLedgerHeadName($headid){
        $this->db->select('ledger_head.ledger');
        $this->db->from('ledger_head');
        $this->db->where('ledger_head.id', $headid);
        $LedgerHead = $this->db->get()->row();
        return $LedgerHead->ledger;
    }
}
?>
