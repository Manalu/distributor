<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of clientsmodel
 *
 * @author tarek
 */
class employeemodel extends CI_Model {
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function add_new_employee($employee, $employee_ledgr){
        $this->db->trans_begin();
        $this->db->insert('employee', $employee);
        $employee_ledgr['emp_id']   = $this->db->insert_id();
        $this->db->insert('employee_ledger', $employee_ledgr);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_employee_list($stat = FALSE){
        $this->db->select('employee.tble_id AS tble_id, employee.emp_name, employee.emp_opening_balance, employee.emp_father, employee.emp_address, employee.emp_national_id, employee.emp_phone_no, employee.emp_mobile_no, employee.emp_monthly_salary, employee.emp_monthly_working, employee.emp_daily_salary, employee.emp_joining_date, employee.emp_status, employee.emp_balance_type');
        $this->db->from('employee');
        $this->db->order_by('employee.emp_name','ASC');
        if($stat !== FALSE){
            $this->db->where('employee.emp_status', $stat);
        }
        $employee = $this->db->get();
        if($employee->num_rows() > 0){
            return $employee;
        }
        else{
            return FALSE;
        }
    }
    
    public function calculate_employee_attendance($emp, $start, $end){
        $this->db->select('tble_id');
        $this->db->from('dist_employee_attendance');
        $this->db->where('dist_employee_attendance.emp_id', $emp);
        $this->db->where('dist_employee_attendance.attendance >=', $start);
        $this->db->where('dist_employee_attendance.attendance <=', $end);
        $count = $this->db->get();
        return $count->num_rows();
    }
    
    public function employee_attendance($attendance_data){
        $this->db->select('*');
        $this->db->from('dist_employee_attendance');
        $this->db->where('dist_employee_attendance.emp_id', $attendance_data['emp_id']);
        $this->db->where('dist_employee_attendance.attendance >=', $attendance_data['start']);
        $this->db->where('dist_employee_attendance.attendance <=', $attendance_data['finish']);
        $this->db->order_by('dist_employee_attendance.attendance', 'ASC');
        $count = $this->db->get();
        if($count->num_rows() > 0) {
            return $count;
        } else {
            return FALSE;
        }
    }

    public function search_employee($FilterKeys){
        $this->db->select('employee.tble_id AS tble_id, employee.emp_name, employee.emp_opening_balance, employee.emp_father, employee.emp_address, employee.emp_national_id, employee.emp_phone_no, employee.emp_mobile_no, employee.emp_monthly_salary, employee.emp_monthly_working, employee.emp_daily_salary, employee.emp_joining_date, employee.emp_status, employee.emp_balance_type');
        $this->db->from('employee');
        if(strlen($FilterKeys['cl_name']) > 0){
            $this->db->like('employee.emp_name', $FilterKeys['cl_name']);
        }
        if(strlen($FilterKeys['cl_phone_no']) > 0){
            $this->db->like('employee.emp_phone_no', $FilterKeys['cl_phone_no']);
        }
        if(strlen($FilterKeys['cl_mobile_no']) > 0){
            $this->db->like('employee.emp_mobile_no', $FilterKeys['cl_mobile_no']);
        }
        if(strlen($FilterKeys['natid']) > 0){
            $this->db->like('employee.emp_national_id', $FilterKeys['natid']);
        }
        $this->db->order_by('employee.emp_name','ASC');
        $employee = $this->db->get();
        if($employee->num_rows() > 0){
            return $employee;
        }
        else{
            return FALSE;
        }
    }
    
    public function get_employee_details($clid){
        $this->db->select('*');
        $this->db->from('employee');
        $this->db->where('employee.tble_id',$clid);
        $Client = $this->db->get();
        if($Client->num_rows() == 1){
            return $Client->row();
        }
        else{
            return FALSE;
        }
    }
    
    public function remove_employee_attendance($attendance_data){
        $this->db->trans_begin();
        $this->db->where('employee_attendance.emp_id', $attendance_data['emp_id']);
        $this->db->where('employee_attendance.attendance', $attendance_data['remove']);
        $this->db->delete('employee_attendance');
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function insert_employee_attendance($emp, $atn, $day, $amt, $bal, $usr){
        $this->db->trans_begin();
        for($i = 0; $i < count($emp); $i++){
            $this->db->select('employee_attendance.tble_id');
            $this->db->from('employee_attendance');
            $this->db->where('employee_attendance.emp_id', $emp[$i]);
            $this->db->where('employee_attendance.attendance', $atn);
            $attend = $this->db->get();
            if($attend->num_rows() < 1 && $attend->num_rows() === 0){
                $this->db->select('employee_attendance.tble_id');
                $this->db->from('employee_attendance');
                $this->db->where('employee_attendance.emp_id', $emp[$i]);
                $this->db->where('employee_attendance.attendance >=', date('Y-m-01', strtotime($atn)));
                $this->db->where('employee_attendance.attendance <=', date('Y-m-t', strtotime($atn)));
                $work = $this->db->get();
                if($day[$i] < $work){
                    $array = array('emp_id' => $emp[$i], 'attendance' => $atn, 'shift' => 1);
                    $this->db->insert('employee_attendance', $array);
                    
//                    $ledger = array('emp_id' => $emp[$i], 'ledger_id' => 2, 'ledger_type' => 1, 'amount' => $amt[$i], 'balance' => $bal[$i], 'notes' => 'Daily Attendance for : ' . $atn, 'ledger_date' => $atn, 'posting_date' => date('Y-m-d'), 'posting_by' => $usr);
//                    $this->db->insert('employee_ledger', $ledger);
//                    
//                    $emp_data   = array('tble_id' => $emp[$i], 'emp_opening_balance' => $bal[$i]);
//                    $this->db->where('employee.tble_id', $emp_data['tble_id']);
//                    $this->db->update('employee', $emp_data);
                }
            }
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function set_employee_ledger($_ledger_, $emp_data){
        $this->db->trans_begin();
        $this->db->insert('employee_ledger', $_ledger_);
        $this->db->where('employee.tble_id', $emp_data['tble_id']);
        $this->db->update('employee', $emp_data);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function get_employee_paid_salary($emp, $month, $year){
        $paid = 0;
        $this->db->select('employee_salary.amount');
        $this->db->from('employee_salary');
        $this->db->where('employee_salary.emp_id', $emp);
        $this->db->where('employee_salary.month', $month);
        $this->db->where('employee_salary.year', $year);
        $Amount = $this->db->get();
        if($Amount->num_rows() > 0){
            foreach($Amount->result() as $Salary){
                $paid = $paid + $Salary->amount;
            }
            return $paid;
        } else {
            return $paid;
        }
    }
    
    public function pay_employee_salary($cash_in_hand, $employee_salary, $voucher_data, $employee_ledgr, $emp_data){
        $this->db->trans_begin();
        $this->db->where('employee.tble_id', $emp_data['tble_id']);
        $this->db->update('employee', $emp_data);
        $this->db->where('store_cash_in_hand.branch_id', $cash_in_hand['branch_id']);
        $this->db->update('store_cash_in_hand', $cash_in_hand);
        $this->db->insert('voucher', $voucher_data);
        $employee_salary['voucher_id'] = $this->db->insert_id();
        $this->db->insert('employee_salary', $employee_salary);
        $this->db->insert('employee_ledger', $employee_ledgr);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function update_employee_info($customer_array){
        $this->db->where('employee.tble_id', $customer_array['tble_id']);
        if($this->db->update('employee', $customer_array)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function total_paid_adjustment($emp_id, $ledger_balance_type){
        $this->db->select_sum('employee_ledger.amount');
        $this->db->from('employee_ledger');
        $this->db->where('employee_ledger.emp_id', $emp_id);
        $this->db->where('employee_ledger.ledger_id', $ledger_balance_type);
        $Company = $this->db->get()->row();
        if($Company->amount == NULL){
            return 0;
        } else {
            return $Company->amount;
        }
    }
    
    public function get_employee_balance($emp_id){
        $this->db->select_sum('employee.emp_opening_balance');
        $this->db->from('employee');
        $this->db->where('employee.tble_id', $emp_id);
        $Employee = $this->db->get()->row();
        if($Employee->emp_opening_balance == NULL){
            return 0;
        } else {
            return $Employee->emp_opening_balance;
        }
    }
    
    public function get_employee_balance_type($emp_id){
        $this->db->select('employee.emp_balance_type');
        $this->db->from('employee');
        $this->db->where('employee.tble_id', $emp_id);
        $Employee = $this->db->get()->row();
        if($Employee->emp_balance_type == NULL){
            return 'None';
        } else {
            return $Employee->emp_balance_type;
        }
    }
    
    public function get_employee_name($emp_id){
        $this->db->select('employee.emp_name');
        $this->db->from('employee');
        $this->db->where('employee.tble_id', $emp_id);
        $Employee = $this->db->get()->row();
        if($Employee->emp_name == NULL){
            return 'None';
        } else {
            return $Employee->emp_name;
        }
    }
    
    public function get_employee_salary($emp_id){
        $this->db->select('employee.emp_monthly_salary');
        $this->db->from('employee');
        $this->db->where('employee.tble_id', $emp_id);
        $Employee = $this->db->get()->row();
        if($Employee->emp_monthly_salary == NULL){
            return 0;
        } else {
            return $Employee->emp_monthly_salary;
        }
    }
    
    public function opening_balance_adjustment($employee_ledger, $voucher_data, $cash_in_hand){
        $this->db->trans_begin();
        $this->db->where('store_cash_in_hand.branch_id', $cash_in_hand['branch_id']);
        $this->db->update('store_cash_in_hand', $cash_in_hand);
        $this->db->insert('voucher', $voucher_data);
        $this->db->insert('employee_ledger', $employee_ledger);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function get_employee_ledger($employee){
        $this->db->select('employee_ledger.tble_id, employee_ledger.ledger_type, employee_ledger.amount, employee_ledger.balance, employee_ledger.ledger_id, employee_ledger.notes, employee_ledger.ledger_date, employee_ledger_head.ledger');
        $this->db->from('employee_ledger');
        $this->db->where('employee_ledger.emp_id', $employee);
        $this->db->join('employee_ledger_head', 'employee_ledger_head.tble_id = employee_ledger.ledger_id', 'LEFT');
        $this->db->order_by('employee_ledger.ledger_date', 'DESC');
        $this->db->order_by('employee_ledger.tble_id', 'DESC');
        $ledger = $this->db->get();
        if($ledger->num_rows() > 0){
            return $ledger;
        } else {
            return FALSE;
        }
    }
}

?>
