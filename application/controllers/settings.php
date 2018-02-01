<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of loginmodel
 *
 * @author  Invictus Cody 
 * @name    Mousum Nandy
 * @contact mousumaiub10@gmail.com
 *
 */
class settings extends CI_Controller {
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
            if($this->Sesson_Vars['role'] != 3 && $this->Sesson_Vars['role'] != 1){
                redirect('login','refresh');
            }
            else{
                $this->Merged_Vars = array_merge($this->Public_Vars, $this->Sesson_Vars);
            }
        }
    }
    
    public function index(){
        redirect('settings/shopinfo');
    }
    
    public function branch(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "add_branch")){
            $branch_data        = array('b_name' => $this->input->post('b_name'), 'b_address' => $this->input->post('b_address'), 'b_manager' => $this->input->post('b_manager'), 'b_phone' => $this->input->post('b_phone'), 'b_status' => 1);
            $balance            = $this->input->post('balance');
            $score = $this->settingsmodel->add_new_branch($branch_data, $balance);
            if($score){
                $this->session->set_flashdata('notification', greensignal('New Branch Added!!'));
                redirect('settings/branch', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later!'));
                redirect('settings/branch', 'refresh');
            }
        } else if($this->input->post('trigger') && ($this->input->post('trigger') == "update_branch")){
            $status         = 1;
            if($this->input->post('b_status')) { $status = 0; }
            $branch_data    = array('tble_id' => $this->input->post('tble_id'), 'b_name' => $this->input->post('b_name_edit'), 'b_address' => $this->input->post('b_address_edit'), 'b_manager' => $this->input->post('b_manager_edit'), 'b_phone' => $this->input->post('b_phone_edit'), 'b_status' => $status);
            $score = $this->settingsmodel->update_branch_info($branch_data);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Branch Information Updated!!'));
                redirect('settings/branch', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later!'));
                redirect('settings/branch', 'refresh');
            }
        }
        else {
            $this->Merged_Vars['branch']            = $this->settingsmodel->get_branch_list();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }

    public function shopinfo($action = FALSE){
        if(!$this->input->post() && $action == FALSE){
            //$this->Merged_Vars['company']       = $this->medicinemodel->getSupplierListForMedicineController();
            $this->Merged_Vars['info']          = $this->settingsmodel->getStoreInformationForSettingsController();
            $this->Merged_Vars['closing']       = $this->settingsmodel->getPreviousClosingData();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
        else{
            $shopdata = array('shp_name' => $this->input->post('name'), 'shp_adrs' => $this->input->post('address'), 'shp_phn1' => $this->input->post('phn1'), 'shp_phn2' => $this->input->post('phn2'), 'shp_hr' => $this->input->post('hr'));
            $this->settingsmodel->editStoreInformationForSettingsController($shopdata);
            $this->session->set_flashdata('agedata','<div class="alert alert-success"><button class="close" data-dismiss="alert">&times;</button><strong>Updated! </strong>Store information updated...</div>');
            redirect(__CLASS__ . '/' . __FUNCTION__);
        }
    }
    
    public function shoplogo(){
        $upconfig = array( 'upload_path' => 'img/shop/', 'allowed_types' => 'jpg|jpeg|png', 'file_name' => "logo", 'overwrite' => FALSE, 'max_size' => 20480, 'max_width' => 1024, 'max_height' => 768, 'max_filename' => 15, 'remove_spaces' => TRUE );
        $this->upload->initialize($upconfig);
        if($this->upload->do_upload('logo')){
            $uploadData = $this->upload->data();
            $shopdata = array('shp_logo' => $uploadData['file_name']);
            $this->settingsmodel->editStoreInformationForSettingsController($shopdata);
            $this->session->set_flashdata('agedata','<div class="alert alert-success"><button class="close" data-dismiss="alert">&times;</button><strong>Updated! </strong>Store information updated...</div>');
            redirect(__CLASS__ . '/' . __FUNCTION__);
        }
        else{
            $this->session->set_flashdata('agedata','<div class="alert alert-block alert-error fade in"><button data-dismiss="alert" class="close" type="button">×</button><strong>Error!</strong><p>'.$this->upload->display_errors().'</p></div>');
            redirect(__CLASS__ . '/shopinfo');
        }
    }
    
    public function software_user(){
        $this->Merged_Vars['usrlist']                   = $this->settingsmodel->get_software_user_list();
        $this->loadView(__CLASS__, __FUNCTION__,  $this->Merged_Vars);
    }
    
    public function new_software_user(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "new_software_user")){
            $user_info_data = array('u_name' => $this->input->post('u_name'), 'u_pass' => md5($this->input->post('u_pass')), 'u_address' => $this->input->post('u_address'), 'u_phone' => $this->input->post('u_phone'), 'u_phone1' => $this->input->post('u_phone1'), 'r_id' => $this->input->post('r_id'), 'b_id' => $this->input->post('b_id'), 'u_status' => 1, 'u_email' => $this->input->post('u_email'), 'u_registrd' => date("Y-m-d"));
            $score = $this->settingsmodel->create_new_software_user($user_info_data);
            if($score){
                $this->session->set_flashdata('notification', greensignal('New Software User Created!!'));
                redirect('settings/usrlst', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later!'));
                redirect('settings/newsoftusr', 'refresh');
            }
            $this->session->set_flashdata('agedata','<div class="alert alert-success"><button class="close" data-dismiss="alert">&times;</button><strong>User Created!! </strong>User ID: ' . $UserId . '</div>');
            redirect('settings/usrlst');
        } else {
            $this->Merged_Vars['source']            = $this->settingsmodel->get_branch_list();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function update_soft_user(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "updateinfo")){
            $UserData = array( 'u_id' => $this->input->post('usrid'), 'u_name' => $this->input->post('u_name'), 'u_email' => $this->input->post('u_email'), 'u_phone' => $this->input->post('u_phone'), 'u_phone1' => $this->input->post('u_phone1'), 'r_id' => $this->input->post('u_role'), 'b_id' => $this->input->post('b_id'), 'u_address' => $this->input->post('u_address'), 'u_status' => $this->input->post('u_status') );
            $this->settingsmodel->updateUserInfoFromSettings($UserData);
            $this->session->set_flashdata('notification', greensignal('Software User Information Updated'));
            redirect('settings/usrlst');
        }
        elseif($this->input->post('trigger') && ($this->input->post('trigger') == "updatepass")){
            $userdata = array('u_id' => $this->input->post('usrid'), 'u_pass' =>  md5($this->input->post('password')));
            $this->usermodel->Edit($userdata);
            $this->session->set_flashdata('notification', greensignal('Software User Password Changed'));
            redirect('settings/usrlst');
        }
        else{
            $this->Merged_Vars['usrid']     = $this->input->get('user');
            $this->Merged_Vars['usrinfo']   = $this->settingsmodel->getUserInfoByUserId($this->Merged_Vars['usrid']);
            $this->Merged_Vars['branch']    = $this->settingsmodel->get_branch_list();
            $this->loadView(__CLASS__, __FUNCTION__,  $this->Merged_Vars);
        }
    }
    
    public function databackup(){
        $prefs = array(
            'tables'      => array(),                       // Array of tables to backup.
            'ignore'      => array(),                       // List of tables to omit from the backup
            'format'      => 'zip',                         // gzip, zip, txt
            'filename'    => date("d-m-Y-h-i-s-A") . '.sql',// File name - NEEDED ONLY WITH ZIP FILES
            'add_drop'    => TRUE,                          // Whether to add DROP TABLE statements to backup file
            'add_insert'  => TRUE,                          // Whether to add INSERT data to backup file
            'newline'     => "\n"                           // Newline character used in backup file
        );
        //Backing up the Database!!
        $this->load->dbutil();
        $backup =& $this->dbutil->backup($prefs);
        write_file('sql/' . $prefs['filename'] . '.' . $prefs['format'], $backup);
        
        //Sending the database backup in email...
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        
        $this->email->from('no-reply@exploriasolution.com', 'Exploria Solution');
        $this->email->to('sales@exploriasolution.com');

        $this->email->subject('E-Pharma Database Backup - ' . date("Y-m-d"));
        $this->email->message('Please find the database backup of e-pharma in the attachment.');
        $this->email->attach('sql/' . $prefs['filename'] . '.' . $prefs['format']);
        $this->email->send();
        
        //Writing New Entry in the Database...
        $shp_backup = date("l, dS F, Y");
        $this->settingsmodel->updateDbBackUpTime($shp_backup);
        
        //Returning the Database....
        echo $prefs['filename'];
    }
    
    public function dayclosing(){
        $this->Merged_Vars['cashinofday'] = $this->settingsmodel->getAllCashinForTheDay(date("Y-m-d"));
        $this->Merged_Vars['cashoutofday'] = $this->settingsmodel->getAllCashoutForTheDay(date("Y-m-d"));
        $this->Merged_Vars['cashinhand'] = $this->settingsmodel->getPreviousCashinHandForTheDay(date("Y-m-d"));
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function finalclosing(){
        $ClosingTableData = array(
            'cl_balance' => $this->input->post('amount'),
            'cl_date' => date("Y-m-d"),
            'cl_time' => date("h:m:i A"),
            'cl_usr' => $this->Sesson_Vars['memb']
        );
        $Score = $this->settingsmodel->updateClosingRecord($ClosingTableData);
        if($Score == true){
            echo '<div class="alert alert-block alert-success fade in"><button data-dismiss="alert" class="close" type="button">×</button><h4 class="alert-heading">Success!</h4><p>Day is closed. Please do not make any sales till tomorrow.</p></div>';
        }
        else{
            echo '<div class="alert alert-block alert-error fade in"><button data-dismiss="alert" class="close" type="button">×</button><h4 class="alert-heading">Error!</h4><p>Sales closing option wrong!! Please call the customer support</p></div>';
        }
    }
    
    public function reports(){
        $this->Merged_Vars['totalsale']  = $this->settingsmodel->getAllSaleOfTheDay();
        $this->Merged_Vars['cashsale']   = $this->settingsmodel->getAllCashSaleOfTheDay();
        $this->Merged_Vars['cardsale']   = $this->settingsmodel->getAllCardSaleOfTheDay();
        $this->Merged_Vars['dueblnce']   = $this->settingsmodel->getTodaysDueBalance();
        $this->Merged_Vars['collectn']   = $this->settingsmodel->getAllCashCollectionOfTheDay();
        $this->Merged_Vars['cashinha']   = $this->settingsmodel->getPreviousCashinHandForTheDay(date("Y-m-d"));
        if(!is_object($this->Merged_Vars['cashinha'])){
            $this->Merged_Vars['cashinhas'] = $this->Merged_Vars['cashinha'];
        }
        else{
            foreach ($this->Merged_Vars['cashinha']->result() as $cashinha){
                $this->Merged_Vars['cashinhas']   = $cashinha->cl_balance;
                $this->Merged_Vars['cashinhast']  = $cashinha->cl_date;
            }
        }
        $this->Merged_Vars['cashoutofday'] = $this->settingsmodel->getPreviousCashOutForTheDay();
        $this->Merged_Vars['totalDay']     = (($this->Merged_Vars['collectn'] + $this->Merged_Vars['cashinhas']) - $this->Merged_Vars['cashoutofday']);
        $this->Merged_Vars['cashoutlist']  = $this->settingsmodel->getAllCashOutList();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function filterreport(){
        $start = explode("/", $this->input->post('starting'));
        $starting = $start[2] . '-' . $start[0] . '-' . $start[1];
        if($this->input->post('endingday') != "") {
            $end   = explode("/", $this->input->post('endingday'));
            $endingda = $end[2] . '-' . $end[0] . '-' . $end[1];
        }
        else{
            $endingda = date("Y-m-d");
        }
        $range = array('starting' => $starting, 'endngday' => $endingda);
        $this->Merged_Vars['totalsale']  = $this->settingsmodel->getAllSaleOfTheDay($range);
        $this->Merged_Vars['cashsale']   = $this->settingsmodel->getAllCashSaleOfTheDay($range);
        $this->Merged_Vars['cardsale']   = $this->settingsmodel->getAllCardSaleOfTheDay($range);
        $this->Merged_Vars['dueblnce']   = $this->settingsmodel->getTodaysDueBalance($range);
        $this->Merged_Vars['collectn']   = $this->settingsmodel->getAllCashCollectionOfTheDay($range);
        $this->Merged_Vars['cashinha']   = $this->settingsmodel->getPreviousCashinHandForTheDay(date("Y-m-d"));
        if(!is_object($this->Merged_Vars['cashinha'])){
            $this->Merged_Vars['cashinhas'] = $this->Merged_Vars['cashinha'];
        }
        else{
            foreach ($this->Merged_Vars['cashinha']->result() as $cashinha){
                $this->Merged_Vars['cashinhas']   = $cashinha->cl_balance;
                $this->Merged_Vars['cashinhast']  = $cashinha->cl_date;
            }
        }
        $this->Merged_Vars['cashoutofday']  = $this->settingsmodel->getPreviousCashOutForTheDay($range);
        $this->Merged_Vars['totalDay']     = (($this->Merged_Vars['collectn'] + $this->Merged_Vars['cashinhas']) - $this->Merged_Vars['cashoutofday']);
        $this->Merged_Vars['cashoutlist']  = $this->settingsmodel->getAllCashOutList();
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
}
?>
