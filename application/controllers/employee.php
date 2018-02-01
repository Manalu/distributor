<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 * @author  Invictus Cody 
 * @name    Tarek Showkot
 * @contact priom2000@gmail.com
 *
 */
class employee extends CI_Controller {
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
        redirect('employee/list');
    }
    
    public function emp_list(){
        $this->Merged_Vars['printer']   = 'Employee List Database ';
        $this->Merged_Vars['clnts']     = $this->employeemodel->get_employee_list();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function search_employee_list(){
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
        $this->Merged_Vars['clnts'] = $this->employeemodel->search_employee($FilterData);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function new_employee(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "createemployee")){
            $this->form_validation->set_rules('emp_monthly_salary', 'Monthly Salary', 'required|integer|less_than[20000]|greater_than[1500]');
            $this->form_validation->set_rules('emp_monthly_working', 'Monthly Working Day', 'required|integer|less_than[32]|greater_than[0]');
            if($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('notification', errormessage(validation_errors()));
                redirect(__CLASS__ . '/new', 'refresh');
            } else {
                $employee_array = array('emp_name' => $this->input->post('emp_name'), 'emp_father' => $this->input->post('emp_father'), 'emp_address' => $this->input->post('emp_address'), 'emp_national_id' => $this->input->post('emp_national_id'), 'emp_phone_no' => $this->input->post('emp_phone_no'), 'emp_mobile_no' => $this->input->post('emp_mobile_no'), 'emp_monthly_salary' => $this->input->post('emp_monthly_salary'), 'emp_monthly_working' => $this->input->post('emp_monthly_working'), 'emp_daily_salary' => ($this->input->post('emp_monthly_salary') / $this->input->post('emp_monthly_working')), 'emp_joining_date' => $this->input->post('emp_joining_date'), 'emp_opening_balance' => $this->input->post('emp_opening_balance'), 'emp_balance_type' => 'None', 'emp_status' => 1);
                $employee_ledgr = array('emp_id' => 0, 'ledger_id' => 1, 'ledger_type' => 1, 'amount' => $this->input->post('emp_opening_balance'), 'balance' => $this->input->post('emp_opening_balance'), 'notes' => 'Opening Balance', 'ledger_date' => date('Y-m-d'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
                $score = $this->employeemodel->add_new_employee($employee_array, $employee_ledgr);
                if($score){
                    $this->session->set_flashdata('notification', greensignal('New Employee Registered!!'));
                    redirect(__CLASS__ . '/new', 'refresh');
                } else {
                    $this->session->set_flashdata('notification', errormessage('Please try again later'));
                    redirect(__CLASS__ . '/new', 'refresh');
                }
            }
        }
        else{
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function edit_emp(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "updateemployee")){
            $salary = $this->input->post('emp_monthly_salary');
            $workdy = $this->input->post('emp_monthly_working');
            $dailyy = ($salary / $workdy);
            $customer_array = array('tble_id' => $this->input->post('tble_id'), 'emp_name' => $this->input->post('emp_name'), 'emp_father' => $this->input->post('emp_father'), 'emp_address' => $this->input->post('emp_address'), 'emp_national_id' => $this->input->post('emp_national_id'), 'emp_phone_no' => $this->input->post('emp_phone_no'), 'emp_mobile_no' => $this->input->post('emp_mobile_no'), 'emp_monthly_salary' => $salary, 'emp_monthly_working' => $workdy, 'emp_daily_salary' => $dailyy, 'emp_status' => $this->input->post('emp_status'));
            $score = $this->employeemodel->update_employee_info($customer_array);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Employee Information Updated!!'));
                redirect('employee/list', 'refresh');
            }
            else{
                $this->session->set_flashdata('notification', errormessage());
                redirect('employee/update?func=update&cat=clients&mod=admin&sess_auth=452d727e90cbb4acd9aba181d29932d1&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=' . $this->input->post('clid'), 'refresh');
            }
        }
        else{
            $this->Merged_Vars['detls']             = $this->employeemodel->get_employee_details($this->input->get('cl_id'));
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function attendance(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "employeeattendance")){
            $emp = $this->input->post('tble_id');
            $atn = $this->input->post('attendance_date');
            $day = $this->input->post('emp_monthly_working');
            $amt = $this->input->post('amount');
            $bal = $this->input->post('balance');            
            
            $score = $this->employeemodel->insert_employee_attendance($emp, $atn, $day, $amt, $bal, $this->Merged_Vars['memb']);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Employee Attendance Recorded!!'));
                redirect('employee/list', 'refresh');
            }
            else{
                $this->session->set_flashdata('notification', errormessage());
                redirect('employee/attendance', 'refresh');
            }
        } else {
            $this->Merged_Vars['empls']                 = $this->employeemodel->get_employee_list(1);
            $this->Merged_Vars['total']                 = $this->Merged_Vars['empls']->num_rows();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function attendance_sheet(){
        $attendance_data                        = array('emp_id' => $this->input->get('cl_id'), 'start' => date('Y-m-01'), 'finish' => date('Y-m-t'));
        $this->Merged_Vars['attendance']        = $this->employeemodel->employee_attendance($attendance_data);
        $this->Merged_Vars['detls']             = $this->employeemodel->get_employee_details($this->input->get('cl_id'));
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function delete_attendance(){
        $attendance_data                        = array('emp_id' => $this->input->get('emp_id'), 'remove' => $this->input->get('remove'));
        $score                                  = $this->employeemodel->remove_employee_attendance($attendance_data);
        if($score){
            $this->session->set_flashdata('notification', greensignal('Employee Attendance Deleted!!'));
            redirect('employee/list', 'refresh');
        }
        else{
            $this->session->set_flashdata('notification', errormessage());
            redirect('employee/list', 'refresh');
        }
    }
    
    public function get_attendance_sheet(){
        $date                                   = "01-" . $this->input->post('month') . '-' . $this->input->post('year');
        $attendance_data                        = array('emp_id' => $this->input->post('cl_id'), 'start' => date_format(date_create($date), 'Y-m-d'), 'finish' => date_format(date_create($date), 'Y-m-t'));
        $this->Merged_Vars['attendance']        = $this->employeemodel->employee_attendance($attendance_data);
        $this->load->view(__CLASS__ . '/' .  __FUNCTION__, $this->Merged_Vars);
    }

    public function salary_posting(){
        if($this->input->post('trigger') && ($this->input->post('trigger') === "employee/salaryposting")){
            $_balance = $this->input->post('balance');
            $_amount  = $this->input->post('amount');
            $emp_id   = $this->input->post('emp_id');
            $month    = $this->input->post('month');
            $year     = $this->input->post('year');
            $method   = $this->input->post('method');
            $notes    = $this->input->post('remarks');
            $_emp_bal = 0;
            if($_balance < 0){ $_emp_bal = $_balance + $_amount; } else if($_balance > 0 || $_balance == 0){ $_emp_bal = $_balance - $_amount; }
            $current_balance                        = $this->accountsmodel->get_branch_balance(1);
            if($_amount > $current_balance){
                $this->session->set_flashdata('notification', errormessage('Not enough cash in hand to pay the salary.'));
                redirect('employee/salaryposting?func=salary&cat=employee&mod=admin&sess_auth=7e37cdcc31d64f9731955a8f108ec152&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=' . $this->input->post('emp_id'), 'refresh');
            }
            $ledger_id                              = $this->input->post('ledger');
            $emp_data                               = array('tble_id' => $emp_id, 'emp_opening_balance' => $_emp_bal);
            $cash_in_hand                           = array('branch_id' => 1, 'balance' => ($current_balance - $_amount));
            $employee_salary                        = array('emp_id' => $emp_id, 'month' => $month, 'year' => $year, 'amount' => $_amount, 'method' => $method, 'remarks' => $notes, 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            $voucher_data                           = array('branch_id' => 1, 'method' => $method, 'v_head' => 6, 'v_type' => 2, 'v_amount' => $_amount, 'v_note' => $this->input->post('remarks'), 'v_date' => $this->input->post('ledger_date'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => $this->Merged_Vars['memb']);
            $employee_ledgr                         = array('emp_id' => $emp_id, 'ledger_id' => $ledger_id, 'ledger_type' => 2, 'amount' => $_amount, 'balance' => $_emp_bal, 'notes' => $notes, 'ledger_date' => $this->input->post('ledger_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            $score                                  = $this->employeemodel->pay_employee_salary($cash_in_hand, $employee_salary, $voucher_data, $employee_ledgr, $emp_data);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Salary Posted for Employee'));
                redirect('employee/ledger?func=salary&cat=employee&mod=admin&sess_auth=7e37cdcc31d64f9731955a8f108ec152&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=' . $this->input->post('emp_id'), 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later.'));
                redirect('employee/ledger?func=salary&cat=employee&mod=admin&sess_auth=7e37cdcc31d64f9731955a8f108ec152&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=' . $this->input->post('emp_id'), 'refresh');
            }
        } else {
            $attendance_data                        = array('emp_id' => $this->input->get('cl_id'), 'start' => date('Y-m-01'), 'finish' => date('Y-m-t'));
            $this->Merged_Vars['salary_info']       = "Salary Period : " . date_format(date_create($attendance_data['start']), 'd-M-Y') . ' To ' . date_format(date_create($attendance_data['finish']), 'd-M-Y');
            $this->Merged_Vars['attendance']        = $this->employeemodel->employee_attendance($attendance_data);
            $this->Merged_Vars['detls']             = $this->employeemodel->get_employee_details($this->input->get('cl_id'));
            $this->Merged_Vars['starting']          = $attendance_data['start'];
            $this->Merged_Vars['method']            = $this->accountsmodel->get_payment_method();
            $this->Merged_Vars['paid_salary']       = $this->employeemodel->get_employee_paid_salary($this->input->get('cl_id'), date('m'), date('Y'));
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function get_employee_salary(){
        $date                                   = "01-" . $this->input->post('month') . '-' . $this->input->post('year');
        $attendance_data                        = array('emp_id' => $this->input->post('cl_id'), 'start' => date_format(date_create($date), 'Y-m-d'), 'finish' => date_format(date_create($date), 'Y-m-t'));
        $this->Merged_Vars['salary_info']       = "Salary Period : " . date_format(date_create($attendance_data['start']), 'd-M-Y') . ' To ' . date_format(date_create($attendance_data['finish']), 'd-M-Y');
        $this->Merged_Vars['attendance']        = $this->employeemodel->employee_attendance($attendance_data);
        $this->Merged_Vars['detls']             = $this->employeemodel->get_employee_details($this->input->post('cl_id'));
        $this->Merged_Vars['starting']          = $attendance_data['start'];
        $this->Merged_Vars['paid_salary']       = $this->employeemodel->get_employee_paid_salary($this->input->post('cl_id'), $this->input->post('month'), $this->input->post('year'));
        $this->load->view(__CLASS__ . '/' .  __FUNCTION__, $this->Merged_Vars);
    }
    
    public function balance_adjust(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "opening_balance_adjust")) {
            $ledger_balance_type = 0;
            if($this->input->post('type') == "Receivable"){
                $ledger_balance_type = 2;
            }
            if($this->input->post('type') == "Payable"){
                $ledger_balance_type = 3;
            }
            
            $paid_adjust                        = $this->employeemodel->total_paid_adjustment($this->input->post('emp_id'), $ledger_balance_type);
            $paid_now                           = $this->input->post('amount');
            $current_balance                    = $this->employeemodel->get_employee_balance($this->input->post('emp_id'));
            $balance_type                       = $this->employeemodel->get_employee_balance_type($this->input->post('emp_id'));
            $ledger_id                          = 0;
            $voucher_ledger_id                  = 0;
            $voucher_ledger_type                = 0;
            $cash_in_hand                       = $this->accountsmodel->get_branch_balance(1);
            if(($paid_adjust + $paid_now) > $current_balance) {
                $this->session->set_flashdata('notification', errormessage('Please try again later.'));
                redirect('employee/adjust?func=adjust&cat=employee&mod=admin&sess_auth=7e37cdcc31d64f9731955a8f108ec152&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=' . $this->input->post('emp_id'), 'refresh');
            } else {
                if($balance_type == "Receivable"){
                    $ledger_id = 2;
                    $voucher_ledger_id = 29;
                    $voucher_ledger_type = 1;
                    $cash_in_hand = $cash_in_hand + $paid_now;
                } else if($balance_type == "Payable"){
                    $ledger_id = 3;
                    $voucher_ledger_id = 30;
                    $voucher_ledger_type = 2;
                    if($paid_now > $cash_in_hand){
                        $this->session->set_flashdata('notification', errormessage('Please try again later.'));
                        redirect('employee/adjust?func=adjust&cat=employee&mod=admin&sess_auth=7e37cdcc31d64f9731955a8f108ec152&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=' . $this->input->post('emp_id'), 'refresh');
                    } else {
                        $cash_in_hand = $cash_in_hand - $paid_now;
                    }
                }
                $employee_ledgr         = array('emp_id' => $this->input->post('emp_id'), 'ledger_id' => $ledger_id, 'amount' => $paid_now, 'notes' => $this->input->post('notes'), 'ledger_date' => $this->input->post('ledger_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
                $voucher_data           = array('branch_id' => $this->Merged_Vars['b_id'], 'method' => 2, 'v_head' => $voucher_ledger_id, 'v_type' => $voucher_ledger_type, 'v_amount' => $paid_now, 'v_note' => $this->input->post('notes'), 'v_date' => $this->input->post('ledger_date'), 'v_posting_date' => date("Y-m-d"), 'v_posting_by' => $this->Merged_Vars['memb']);
                $cash_in_hand           = array('branch_id' => 1, 'balance' => $cash_in_hand);
                
                $score                                  = $this->employeemodel->opening_balance_adjustment($employee_ledgr, $voucher_data, $cash_in_hand);
                if($score){
                    $this->session->set_flashdata('notification', greensignal('Adjustment Made for Employee'));
                    redirect('employee/adjust?func=adjust&cat=employee&mod=admin&sess_auth=7e37cdcc31d64f9731955a8f108ec152&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=' . $this->input->post('emp_id'), 'refresh');
                } else {
                    $this->session->set_flashdata('notification', errormessage('Please try again later.'));
                    redirect('employee/adjust?func=adjust&cat=employee&mod=admin&sess_auth=7e37cdcc31d64f9731955a8f108ec152&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=' . $this->input->post('emp_id'), 'refresh');
                }
            }
        } else {
            $ledger_balance_type = 0;
            if($this->input->get('type') == "Receivable"){
                $ledger_balance_type = 2;
            }
            if($this->input->get('type') == "Payable"){
                $ledger_balance_type = 3;
            }
            $this->Merged_Vars['detls']             = $this->employeemodel->get_employee_details($this->input->get('cl_id'));
            $this->Merged_Vars['paid_adjust']       = $this->employeemodel->total_paid_adjustment($this->input->get('cl_id'), $ledger_balance_type);
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function ledger(){
        $this->Merged_Vars['printer']       = 'Employee Ledger List';
        $this->Merged_Vars['back_link']     = 'employee/list';
        $this->Merged_Vars['c_name']        = $this->employeemodel->get_employee_name($this->input->get('cl_id'));
        $this->Merged_Vars['ledger']        = $this->employeemodel->get_employee_ledger($this->input->get('cl_id'));
        $this->Merged_Vars['balance_type']  = $this->employeemodel->get_employee_balance_type($this->input->get('cl_id'));
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function salary_closing(){
        $emp_id         = $this->input->post('emp_id');
        $ledger_id      = 2;
        $ledger_type    = 1;
        $_amount        = $this->input->post('amount');
        $_emp_bal       = 0;
        $_balance = $this->input->post('balance');
        
        if($_balance >= 0){
            $_emp_bal   = $_balance + $_amount;
        } else if($_balance < 0) {
            $_emp_bal   = (0 - (abs($_balance) + $_amount));
        }
        $month          = $this->input->post('month');
        $year           = $this->input->post('year');
        $dateObj        = DateTime::createFromFormat('!m', $month);
        $notes          = 'Salary Closing for: ' . $Name = $dateObj->format('F') . ' - ' . $year;
        
        $_ledger_       = array(
            'emp_id'    => $emp_id,
            'ledger_id'    => $ledger_id,
            'ledger_type'    => $ledger_type,
            'amount'    => $_amount,
            'balance'    => $_emp_bal,
            'notes'    => $notes,
            'ledger_date'    => date('Y-m-d'),
            'posting_date'    => date('Y-m-d H:i:s'),
            'posting_by'    => $this->Merged_Vars['memb']
        );
        
        $emp_data       = array('tble_id' => $emp_id, 'emp_opening_balance' => $_emp_bal);
        
        $score          = $this->employeemodel->set_employee_ledger($_ledger_, $emp_data);
        if($score){
            $this->session->set_flashdata('notification', greensignal('Adjustment Made for Employee'));
            redirect('employee/ledger?func=adjust&cat=employee&mod=admin&sess_auth=7e37cdcc31d64f9731955a8f108ec152&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=' . $this->input->post('emp_id'), 'refresh');
        } else {
            $this->session->set_flashdata('notification', errormessage('Please try again later.'));
            redirect('employee/ledger?func=adjust&cat=employee&mod=admin&sess_auth=7e37cdcc31d64f9731955a8f108ec152&remote=1c1645faaf01150a6bc32d00d261cfab&cl_id=' . $this->input->post('emp_id'), 'refresh');
        }
    }
}
?>