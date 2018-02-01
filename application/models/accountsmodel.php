<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of accountsmodel
 *
 * @author tarek
 */
class accountsmodel extends CI_Model {
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_voucher_statement($v_type = FALSE, $limit = FALSE){
        $this->db->select('voucher.tble_id, voucher.v_amount, voucher.v_note, voucher.v_date, voucher.v_type, voucher.method, payment_method.method AS Through, branch.b_name AS Branch, user_info.u_name, ledger_head.ledger, ledger_head.edit');
        $this->db->from('voucher');
        if($v_type !== FALSE) { $this->db->where('voucher.v_type', $v_type); }
        if($limit !== FALSE) { $this->db->limit($limit); }
        $this->db->order_by('voucher.v_date', 'DESC');
        $this->db->order_by('voucher.tble_id', 'DESC');
        $this->db->join('ledger_head', 'ledger_head.id = voucher.v_head', 'LEFT');
        $this->db->join('payment_method', 'payment_method.tble_id = voucher.method', 'LEFT');
        $this->db->join('branch', 'branch.tble_id = voucher.branch_id', 'LEFT');
        $this->db->join('user_info', 'user_info.u_id = voucher.v_posting_by', 'LEFT');
        $Orders = $this->db->get();
        if($Orders->num_rows() > 0){
            return $Orders;
        }
        else{
            return FALSE;
        }
    }
    
    public function get_filtered_voucher_statement($FilterKey){
        $this->db->select('voucher.tble_id, voucher.v_amount, voucher.v_note, voucher.v_date, voucher.v_type, voucher.method, payment_method.method AS Through, branch.b_name AS Branch, user_info.u_name, ledger_head.ledger, ledger_head.edit');
        $this->db->from('voucher');
        if($FilterKey['branch_id'] != "" ){ $this->db->where('voucher.branch_id', $FilterKey['branch_id']); }
        if(strlen($FilterKey['starting']) == 10 ){ $this->db->where('voucher.v_date >=', $FilterKey['starting']); }
        if(strlen($FilterKey['endngday']) == 10 ){ $this->db->where('voucher.v_date <=', $FilterKey['endngday']); }
        if(strlen($FilterKey['status']) > 0){ $this->db->where('voucher.v_head', $FilterKey['status']); }
        if(strlen($FilterKey['v_type']) > 0){ $this->db->where('voucher.v_type', $FilterKey['v_type']); }
        $this->db->order_by('voucher.v_date', 'DESC');
        $this->db->order_by('voucher.tble_id', 'ASC');
        $this->db->join('ledger_head', 'ledger_head.id = voucher.v_head', 'LEFT');
        $this->db->join('payment_method', 'payment_method.tble_id = voucher.method', 'LEFT');
        $this->db->join('branch', 'branch.tble_id = voucher.branch_id', 'LEFT');
        $this->db->join('user_info', 'user_info.u_id = voucher.v_posting_by', 'LEFT');
        $Orders = $this->db->get();
        if($Orders->num_rows() > 0){
            return $Orders;
        } else{
            return FALSE;
        }
    }
    
    public function get_editable_ledger_list(){
        $this->db->select('*');
        $this->db->from('ledger_head');
        $this->db->where('ledger_head.edit', 1);
        $this->db->order_by('ledger_head.ledger', 'ASC');
        $ledger = $this->db->get();
        if($ledger->num_rows() > 0){
            return $ledger;
        } else {
            return  FALSE;
        }
    }
    
    public function getActiveLedgerListByType($type){
        $this->db->select('*');
        $this->db->from('ledger_head');
        $this->db->where('ledger_head.type', $type);
        $this->db->order_by('ledger_head.id','DESC');
        $LedgerList = $this->db->get();
        if($LedgerList->num_rows() > 0){
            return $LedgerList;
        }
        else{
            return FALSE;
        }
    }
    
    public function add_new_voucher($voucher_data, $cash_in_hand){
        $this->db->trans_begin();
        $this->db->where('store_cash_in_hand.branch_id', $cash_in_hand['branch_id']);
        $this->db->update('store_cash_in_hand', $cash_in_hand);
        $this->db->insert('voucher', $voucher_data);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function branch_balance_transfer($b_id){
        $this->db->select('store_cash_in_hand.balance AS Balance, branch.b_name AS Branch');
        $this->db->from('store_cash_in_hand');
        $this->db->where('store_cash_in_hand.branch_id', $b_id);
        $this->db->join('branch', 'branch.tble_id = store_cash_in_hand.branch_id', 'LEFT');
        $balance = $this->db->get();
        if($balance->num_rows() > 0){
            return $balance;
        } else {
            return FALSE;
        }
    }
    
    public function get_branch_balance($b_id){
        $this->db->select('store_cash_in_hand.balance AS Balance');
        $this->db->from('store_cash_in_hand');
        $this->db->where('store_cash_in_hand.branch_id', $b_id);
        $balance = $this->db->get();
        if($balance->num_rows() == 1){
            $balance = $balance->row();
            return $balance->Balance;
        } else {
            return 0;
        }
    }
    
    public function transfer_branch_balance($source_data, $destin_data, $voucher){
        $this->db->trans_begin();
        $this->db->where('store_cash_in_hand.branch_id', $source_data['branch_id']);
        $this->db->update('store_cash_in_hand', $source_data);
        
        $this->db->where('store_cash_in_hand.branch_id', $destin_data['branch_id']);
        $this->db->update('store_cash_in_hand', $destin_data);
        
        $this->db->insert('voucher', $voucher);
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function get_supplier_credit_ledger(){
        $this->db->select('*');
        $this->db->from('company_credit_ledger');
        $this->db->where('company_credit_ledger.tble_id !=', 1);
        $this->db->where('company_credit_ledger.tble_id !=', 3);
        $this->db->where('company_credit_ledger.tble_id !=', 5);
        $ledger = $this->db->get();
        if($ledger->num_rows() > 0){
            return $ledger;
        } else {
            return FALSE;
        }
    }
    
    public function post_supplier_credit($company_credit, $company_info, $voucher, $cashinhand){
        $this->db->trans_begin();
        $this->db->insert('company_credit_adjustment', $company_credit);
        $this->db->where('company_info.c_id', $company_info['c_id']);
        $this->db->update('company_info', $company_info);
        $this->db->insert('voucher', $voucher);
        $this->db->where('store_cash_in_hand.branch_id', $cashinhand['branch_id']);
        $this->db->update('store_cash_in_hand', $cashinhand);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function get_brachwise_cashinhand(){
        $this->db->select('store_cash_in_hand.tble_id, branch.b_name, store_cash_in_hand.balance');
        $this->db->from('store_cash_in_hand');
        $this->db->join('branch', 'branch.tble_id = store_cash_in_hand.branch_id', 'LEFT');
        $score = $this->db->get();
        if($score->num_rows() > 0){
            return $score;
        } else {
            return FALSE;
        }
    }
    
    public function get_payment_method(){
        $this->db->select('*');
        $this->db->from('payment_method');
        $this->db->where('payment_method.status', 1);
        $this->db->order_by('payment_method.method', 'ASC');
        $method = $this->db->get();
        if($method->num_rows() > 0){
            return $method;
        } else {
            return FALSE;
        }
    }
    
    public function get_voucher_info($v_id){
        $this->db->select('*');
        $this->db->from('voucher');
        $this->db->where('voucher.tble_id', $v_id);
        $voucher = $this->db->get();
        if($voucher->num_rows() == 1){
            return $voucher->row();
        } else {
            return FALSE;
        }
    }
    
    public function get_user_current_investment($userid){
        $this->db->select('user_investment.balance');
        $this->db->from('user_investment');
        $this->db->where('user_investment.user_id', $userid);
        $balance = $this->db->get();
        if($balance->num_rows() == 1){
            $balance = $balance->row();
            return $balance->balance;
        } else {
            return 0;
        }
    }
    
    public function get_user_current_loan($userid){
        $this->db->select('user_loan.balance');
        $this->db->from('user_loan');
        $this->db->where('user_loan.user_id', $userid);
        $balance = $this->db->get();
        if($balance->num_rows() == 1){
            $balance = $balance->row();
            return $balance->balance;
        } else {
            return 0;
        }
    }
    
    public function get_user_current_cash_balance($userid){
        $this->db->select('user_cash_book.balance');
        $this->db->from('user_cash_book');
        $this->db->where('user_cash_book.user_id', $userid);
        $balance = $this->db->get();
        if($balance->num_rows() == 1){
            $balance = $balance->row();
            return $balance->balance;
        } else {
            return 0;
        }
    }
    
    public function get_user_current_invest($userid){
        $this->db->select('user_investment.balance');
        $this->db->from('user_investment');
        $this->db->where('user_investment.user_id', $userid);
        $balance = $this->db->get();
        if($balance->num_rows() == 1){
            $balance = $balance->row();
            return $balance->balance;
        } else {
            return 0;
        }
    }
    
    public function check_existing_loan($user_id){
        $this->db->select('*');
        $this->db->from('user_loan');
        $this->db->where('user_loan.user_id', $user_id);
        $loan = $this->db->get();
        if($loan->num_rows() > 0){
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function check_existing_cash_book($user_id){
        $this->db->select('*');
        $this->db->from('user_cash_book');
        $this->db->where('user_cash_book.user_id', $user_id);
        $loan = $this->db->get();
        if($loan->num_rows() > 0){
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function check_existing_investment($user_id){
        $this->db->select('*');
        $this->db->from('user_investment');
        $this->db->where('user_investment.user_id', $user_id);
        $loan = $this->db->get();
        if($loan->num_rows() > 0){
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function loan_opening_balance($loan_deposit, $user_loan){
        $this->db->trans_begin();
        
        $this->db->insert('user_loan_transaction', $loan_deposit);
        $this->db->insert('user_loan', $user_loan);
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function cash_book_opening_balance($cash_book_deposit, $user_cash_book){
        $this->db->trans_begin();
        
        $this->db->insert('user_cash_book_ledger', $cash_book_deposit);
        $this->db->insert('user_cash_book', $user_cash_book);
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function investment_opening_balance($loan_deposit, $user_loan){
        $this->db->trans_begin();
        
        $this->db->insert('user_investment_transaction', $loan_deposit);
        $this->db->insert('user_investment', $user_loan);
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function loan_deposit_from_user($voucher_data, $cash_in_hand, $loan_deposit, $user_loan){
        $this->db->trans_begin();
        $this->db->insert('voucher', $voucher_data);
        $loan_deposit['voucher_id'] = $this->db->insert_id();
        $this->db->where('store_cash_in_hand.branch_id', $cash_in_hand['branch_id']);
        $this->db->update('store_cash_in_hand', $cash_in_hand);
        $this->db->insert('user_loan_transaction', $loan_deposit);
        
        $this->db->select('*');
        $this->db->from('user_loan');
        $this->db->where('user_loan.user_id', $user_loan['user_id']);
        $loan = $this->db->get();
        if($loan->num_rows() == 1){
            $this->db->where('user_loan.user_id', $user_loan['user_id']);
            $this->db->update('user_loan', $user_loan);
        } else {
            $this->db->insert('user_loan', $user_loan);
        }
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function cash_book_ledger($voucher_data, $cash_in_hand, $loan_deposit, $user_loan){
        $this->db->trans_begin();
        $this->db->insert('voucher', $voucher_data);
        $loan_deposit['voucher_id'] = $this->db->insert_id();
        $this->db->where('store_cash_in_hand.branch_id', $cash_in_hand['branch_id']);
        $this->db->update('store_cash_in_hand', $cash_in_hand);
        $this->db->insert('user_cash_book_ledger', $loan_deposit);
        
        $this->db->select('*');
        $this->db->from('user_cash_book');
        $this->db->where('user_cash_book.user_id', $user_loan['user_id']);
        $loan = $this->db->get();
        if($loan->num_rows() == 1){
            $this->db->where('user_cash_book.user_id', $user_loan['user_id']);
            $this->db->update('user_cash_book', $user_loan);
        } else {
            $this->db->insert('user_cash_book', $user_loan);
        }
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function investment_deposit_from_user($voucher_data, $cash_in_hand, $loan_deposit, $user_loan){
        $this->db->trans_begin();
        $this->db->insert('voucher', $voucher_data);
        $loan_deposit['voucher_id'] = $this->db->insert_id();
        $this->db->where('store_cash_in_hand.branch_id', $cash_in_hand['branch_id']);
        $this->db->update('store_cash_in_hand', $cash_in_hand);
        $this->db->insert('user_investment_transaction', $loan_deposit);
        
        $this->db->select('*');
        $this->db->from('user_investment');
        $this->db->where('user_investment.user_id', $user_loan['user_id']);
        $loan = $this->db->get();
        if($loan->num_rows() == 1){
            $this->db->where('user_investment.user_id', $user_loan['user_id']);
            $this->db->update('user_investment', $user_loan);
        } else {
            $this->db->insert('user_investment', $user_loan);
        }
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function invest_deposit_from_user($voucher_data, $cash_in_hand, $loan_deposit, $user_loan){
        $this->db->trans_begin();
        $this->db->insert('voucher', $voucher_data);
        $loan_deposit['voucher_id'] = $this->db->insert_id();
        $this->db->where('store_cash_in_hand.branch_id', $cash_in_hand['branch_id']);
        $this->db->update('store_cash_in_hand', $cash_in_hand);
        $this->db->insert('user_investment_transaction', $loan_deposit);
        
        $this->db->select('*');
        $this->db->from('user_loan');
        $this->db->where('user_loan.user_id', $user_loan['user_id']);
        $loan = $this->db->get();
        if($loan->num_rows() == 1){
            $this->db->where('user_investment.user_id', $user_loan['user_id']);
            $this->db->update('user_investment', $user_loan);
        } else {
            $this->db->insert('user_investment', $user_loan);
        }
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function get_loan_balance(){
        $this->db->select('user_loan.user_id, user_loan.balance, user_info.u_name, user_info.r_id, branch.b_name');
        $this->db->from('user_loan');
        $this->db->join('user_info', 'user_info.u_id = user_loan.user_id', 'LEFT');
        $this->db->join('branch', 'branch.tble_id = user_info.b_id', 'LEFT');
        $loan = $this->db->get();
        if($loan->num_rows() > 0){
            return $loan;
        } else {
            return FALSE;
        }
    }
    
    public function get_cash_book_balance(){
        $this->db->select('user_cash_book.user_id, user_cash_book.balance, user_info.u_name, user_info.r_id, branch.b_name');
        $this->db->from('user_cash_book');
        $this->db->join('user_info', 'user_info.u_id = user_cash_book.user_id', 'LEFT');
        $this->db->join('branch', 'branch.tble_id = user_info.b_id', 'LEFT');
        $loan = $this->db->get();
        if($loan->num_rows() > 0){
            return $loan;
        } else {
            return FALSE;
        }
    }
    
    public function get_investment_balance(){
        $this->db->select('user_investment.user_id, user_investment.balance, user_info.u_name, user_info.r_id, branch.b_name');
        $this->db->from('user_investment');
        $this->db->join('user_info', 'user_info.u_id = user_investment.user_id', 'LEFT');
        $this->db->join('branch', 'branch.tble_id = user_info.b_id', 'LEFT');
        $loan = $this->db->get();
        if($loan->num_rows() > 0){
            return $loan;
        } else {
            return FALSE;
        }
    }
    
    public function get_loan_statement($userid){
        $this->db->select('user_loan_transaction.*, payment_method.method AS Media');
        $this->db->from('user_loan_transaction');
        $this->db->where('user_loan_transaction.user_id', $userid);
        $this->db->join('payment_method', 'payment_method.tble_id = user_loan_transaction.method', 'LEFT');
        $this->db->order_by('user_loan_transaction.trans_date', 'DESC');
        $this->db->order_by('user_loan_transaction.tble_id', 'DESC');
        $statement = $this->db->get();
        if($statement->num_rows() > 0){
            return $statement;
        } else {
            return FALSE;
        }
    }
    
    public function get_cash_book_statement($userid){
        $this->db->select('user_cash_book_ledger.*, payment_method.method AS Media');
        $this->db->from('user_cash_book_ledger');
        $this->db->where('user_cash_book_ledger.user_id', $userid);
        $this->db->join('payment_method', 'payment_method.tble_id = user_cash_book_ledger.method', 'LEFT');
        $this->db->order_by('user_cash_book_ledger.trans_date', 'DESC');
        $this->db->order_by('user_cash_book_ledger.tble_id', 'DESC');
        $statement = $this->db->get();
        if($statement->num_rows() > 0){
            return $statement;
        } else {
            return FALSE;
        }
    }
    
    public function get_investment_statement($userid){
        $this->db->select('user_investment_transaction.*, payment_method.method AS Media');
        $this->db->from('user_investment_transaction');
        $this->db->where('user_investment_transaction.user_id', $userid);
        $this->db->join('payment_method', 'payment_method.tble_id = user_investment_transaction.method', 'LEFT');
        $this->db->order_by('user_investment_transaction.trans_date', 'DESC');
        $this->db->order_by('user_investment_transaction.tble_id', 'DESC');
        $statement = $this->db->get();
        if($statement->num_rows() > 0){
            return $statement;
        } else {
            return FALSE;
        }
    }
    
    public function get_loan_opening_balance($userid){
        $this->db->select('user_loan_transaction.amount');
        $this->db->from('user_loan_transaction');
        $this->db->where('user_loan_transaction.user_id', $userid);
        $this->db->where('user_loan_transaction.trans_type', 0);
        $statement = $this->db->get();
        if($statement->num_rows() == 1){
            $statement = $statement->row();
            return $statement->amount;
        } else {
            return FALSE;
        }
    }
    
    public function daily_closing_company(){
        $this->db->select_sum('company_info.c_credit');
        $this->db->from('company_info');
        $Company = $this->db->get()->row();
        if($Company->c_credit == NULL){
            return 0;
        } else {
            return $Company->c_credit;
        }
    }
    
    public function cash_amount_in_damage(){
        $this->db->select_sum('damage_batch_item.quantity * ' . $this->db->dbprefix . 'damage_batch_item.rates', 'cash_damage');
        $this->db->from('damage_batch_item');
        $this->db->where('damage_batch_item.received', 1);
        $cash_damage = $this->db->get()->row();
        if($cash_damage->cash_damage == NULL){
            return 0;
        } else {
            return $cash_damage->cash_damage;
        }
    }
    
    public function cash_amount_in_stock(){
        //$Query = 'SELECT `' . $this->db->dbprefix . 'products_name`.`p_id` AS Product, `' . $this->db->dbprefix . 'products_name`.`p_name` AS Name, `' . $this->db->dbprefix . 'products_name`.`p_purchse_price` AS Price, (SELECT SUM(`' . $this->db->dbprefix . 'product_stock`.`stock`) FROM `' . $this->db->dbprefix . 'product_stock` WHERE `' . $this->db->dbprefix . 'product_stock`.`product_id`=Product) AS Stock, SUM((Stock * `' . $this->db->dbprefix . 'products_name`.`p_purchse_price`)) AS Rate FROM `' . $this->db->dbprefix . 'products_name` LEFT JOIN `' . $this->db->dbprefix . 'product_stock` ON `' . $this->db->dbprefix . 'products_name`.`p_id`=`' . $this->db->dbprefix . 'product_stock`.`product_id`';
        $Query = 'SELECT `' . $this->db->dbprefix . 'products_name`.`p_id` AS Product, `' . $this->db->dbprefix . 'products_name`.`p_name` AS Name, `' . $this->db->dbprefix . 'products_name`.`p_stock_price` AS Price, (SELECT SUM(`' . $this->db->dbprefix . 'product_stock`.`stock`) FROM `' . $this->db->dbprefix . 'product_stock` WHERE `' . $this->db->dbprefix . 'product_stock`.`product_id`=Product) AS Stock, SUM((Stock * `' . $this->db->dbprefix . 'products_name`.`p_stock_price`)) AS Rate FROM `' . $this->db->dbprefix . 'products_name` LEFT JOIN `' . $this->db->dbprefix . 'product_stock` ON `' . $this->db->dbprefix . 'products_name`.`p_id`=`' . $this->db->dbprefix . 'product_stock`.`product_id`';
        $Data = $this->db->query($Query);
        $Result = $Data->row();
        if($Result->Rate != NULL){
            return $Result->Rate;
        } else {
            return 0;
        }
    }
    
    public function daily_sale_for_closing(){
        $this->db->select_sum('invoice.total_bill', 'TotalSale');
        $this->db->from('invoice');
        $this->db->where('invoice.sale_date', date('Y-m-d'));
        $TotalSales = $this->db->get()->row();
        if($TotalSales->TotalSale != NULL){
            return $TotalSales->TotalSale;
        } else {
            return 0;
        }
    }
    
    public function daily_collection_for_closing(){
        $Query = 'SELECT `' . $this->db->dbprefix . 'invoice`.`tble_id` AS InvoiceId, SUM((SELECT SUM(`' . $this->db->dbprefix . 'invoice_payment`.`amount`) FROM `' . $this->db->dbprefix . 'invoice_payment` WHERE `' . $this->db->dbprefix . 'invoice_payment`.`invoice_id`=InvoiceId)) AS Collection FROM `' . $this->db->dbprefix . 'invoice` WHERE `' . $this->db->dbprefix . 'invoice`.`sale_date` = ' . date('Y-m-d') . '';
        $exec = $this->db->query($Query);
        $Result = $exec->row();
        if($Result->Collection != NULL){
            return $Result->Collection;
        } else {
            return 0;
        }
    }
    
    public function total_due_for_closing(){
        $this->db->select_sum('client.cl_balance', 'Balance');
        $this->db->from('client');
        $TotalDue = $this->db->get()->row();
        if($TotalDue->Balance != NULL){
            return $TotalDue->Balance;
        } else {
            return 0;
        }
    }
    
    public function total_loan_for_closing(){
        $this->db->select_sum('user_loan.balance', 'Liability');
        $this->db->from('user_loan');
        $Libality = $this->db->get()->row();
        if($Libality->Liability != NULL){
            return $Libality->Liability;
        } else {
            return 0;
        }
    }
    
    public function total_investment_for_closing(){
        $this->db->select_sum('user_investment.balance', 'Investment');
        $this->db->from('user_investment');
        $Libality = $this->db->get()->row();
        if($Libality->Investment != NULL){
            return $Libality->Investment;
        } else {
            return 0;
        }
    }
    
    public function total_cash_in_hand_for_closing(){
        $this->db->select_sum('store_cash_in_hand.balance', 'CashInHand');
        $this->db->from('store_cash_in_hand');
        $CashInHand = $this->db->get()->row();
        if($CashInHand->CashInHand != NULL){
            return $CashInHand->CashInHand;
        } else {
            return 0;
        }
    }
    
    public function closing_permission_flag(){
        $this->db->select('closing.tble_id');
        $this->db->from('closing');
        $this->db->where('closing.closing_date', date('Y-m-d'));
        $closing = $this->db->get();
        if($closing->num_rows() == 1){
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function last_closing_date(){
        $this->db->select('closing.closing_date');
        $this->db->from('closing');
        $this->db->order_by('closing.closing_date', 'DESC');
        $this->db->limit(1);
        $closing = $this->db->get();
        if($closing->num_rows() == 1){
            $closing = $closing->row();
            return $closing->closing_date;
        } else {
            return FALSE;
        }
    }
    
    public function daily_business_closing($closing_data){
        if($this->db->insert('closing', $closing_data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function search_closing_record($closing_data){
        $this->db->select('*');
        $this->db->from('closing');
        if(strlen($closing_data['from']) == 10){
            $this->db->where('closing.closing_date >=', $closing_data['from']);
        }
        if(strlen($closing_data['to']) == 10){
            $this->db->where('closing.closing_date <=', $closing_data['to']);
        }
        $this->db->order_by('closing.closing_date', 'DESC');
        $closing_record = $this->db->get();
        if($closing_record->num_rows() > 0){
            return $closing_record;
        } else {
            return FALSE;
        }
    }
    
    public function getLedgerListForVoucherEntry($ltype = FALSE, $edit = FALSE){
        $this->db->select('*');
        $this->db->from('ledger_head');
        if($ltype !== FALSE) { $this->db->where('ledger_head.type', $ltype); }
        if($edit !== FALSE) { $this->db->where('ledger_head.edit', 1); }
        $this->db->order_by('ledger_head.ledger', 'ASC');
        $LedgerList = $this->db->get();
        if($LedgerList->num_rows() > 0){
            return $LedgerList;
        }
        else{
            return FALSE;
        }
    }
    
    public function createNewLedgerHeadInDb($param) {
        if($this->db->insert('ledger_head', $param)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function getActiveLedgerList($ledgerid = FALSE){
        if($ledgerid === FALSE){
            $this->db->select('*');
            $this->db->from('ledger_head');
            $this->db->order_by('ledger_head.id','DESC');
            $LedgerList = $this->db->get();
            if($LedgerList->num_rows() > 0){
                return $LedgerList;
            }
            else{
                return FALSE;
            }
        }
        else{
            $this->db->select('*');
            $this->db->from('ledger_head');
            $this->db->where('ledger_head.id',$ledgerid);
            $LedgerList = $this->db->get();
            if($LedgerList->num_rows() == 1){
                return $LedgerList->row();
            }
            else{
                return FALSE;
            }
        }
    }
    
    public function updateNewLedgerHeadInDb($UpdateLedgerData){
        $data = array('ledger' => $UpdateLedgerData['ledger'], 'type' => $UpdateLedgerData['type'], 'status' => $UpdateLedgerData['status']);
        $this->db->where('ledger_head.id',$UpdateLedgerData['id']);
        if($this->db->update('ledger_head',$data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }




















































































































































































//    public function getCashOutPurpose($purposeid){
//        $this->db->select('ledger');
//        $this->db->from('ledger_head');
//        $this->db->where('ledger_head.id', $purposeid);
//        $LedHead = $this->db->get()->row();
//        return $LedHead->ledger;
//    }
//    
//    public function getAllReceivedOrdersByCompanyNameFromModel(){
//        $this->db->select('order.or_id as OrderId, order.or_total as OrderTotal, order.or_discount as OrderDiscount, order.or_sub as OrderSubTotal, company_info.c_name as CompanyName, company_agent.ca_name as AgentName');
//        $this->db->from('order');
//        $this->db->where('order.or_status', 3);
//        $this->db->join('company_info','company_info.c_id = order.or_company', 'LEFT');
//        $this->db->join('company_agent','company_agent.ca_id = order.or_agent', 'LEFT');
//        $OrderList = $this->db->get();
//        if($OrderList->num_rows() > 0){
//            return $OrderList->result_array();
//        }
//        else{
//            return 'No Order DATA';
//        }
//    }
//    
//
//    
//    
//    public function getAllTheLedgerHead(){
//        $this->db->select('*');
//        $this->db->from('ledger_head');
//        $Ledger = $this->db->get();
//        if($Ledger->num_rows() > 0){
//            return $Ledger;
//        }
//        else{
//            return NULL;
//        }
//    }
//    
}

?>
