<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class accounts extends CI_Controller {
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
        redirect('accounts/acclist');
    }
    
    public function acclist(){
        $this->Merged_Vars['source']                = $this->settingsmodel->get_branch_list();
        $this->Merged_Vars['orderz']                = $this->accountsmodel->get_voucher_statement(2, 200);
        $this->Merged_Vars['purpoz']                = $this->accountsmodel->getActiveLedgerListByType(2);
        $this->Merged_Vars['printer']               = 'Expense Statement List ';
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function inlist(){
        $this->Merged_Vars['source']                = $this->settingsmodel->get_branch_list();
        $this->Merged_Vars['orderz']                = $this->accountsmodel->get_voucher_statement(1, 200);
        $this->Merged_Vars['purpoz']                = $this->accountsmodel->getActiveLedgerListByType(1);
        $this->Merged_Vars['printer']               = 'Income Statement List ';
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function voucher(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == 'voucher')){
            $current_balance        = $this->accountsmodel->get_branch_balance($this->Merged_Vars['b_id']);
            $voucher_amount         = $this->input->post('v_amount');
            $voucher_type           = $this->input->post('voucher');
            if($voucher_type == 2 && ($voucher_amount > $current_balance)){
                $this->session->set_flashdata('notification', errormessage('Expense voucher can not be more then cash in hand'));
                redirect('accounts/voucher', 'refresh');
            }
            if($voucher_type == 2){
                $current_balance = $current_balance - $voucher_amount;
            } else if($voucher_type == 1){
                $current_balance = $current_balance + $voucher_amount;
            }
            $voucher_data           = array('branch_id' => $this->Merged_Vars['b_id'], 'method' => $this->input->post('method'), 'v_head' => $this->input->post('v_head'), 'v_type' => $voucher_type, 'v_amount' => $voucher_amount, 'v_note' => $this->input->post('v_note'), 'v_date' => $this->input->post('v_date'), 'v_posting_date' => date("Y-m-d"), 'v_posting_by' => $this->Merged_Vars['memb']);
            $cash_in_hand           = array('branch_id' => $this->Merged_Vars['b_id'], 'balance' => $current_balance);
            
            $score = $this->accountsmodel->add_new_voucher($voucher_data, $cash_in_hand);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Voucher Posting successful.'));
                redirect(__CLASS__ . '/' . __FUNCTION__, 'refresh');
            }
            else{
                $this->session->set_flashdata('agedata', errormessage('Please Try Again Later.'));
                redirect(__CLASS__ . '/' . __FUNCTION__, 'refresh');
            }
        } else {
            $this->Merged_Vars['method']        = $this->accountsmodel->get_payment_method();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function get_ledger_head_for_voucher(){
        $this->Merged_Vars['v_type']                = $this->input->post('headtype');
        $this->Merged_Vars['purpoz']                = $this->accountsmodel->getLedgerListForVoucherEntry($this->input->post('headtype'), 0);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }

    public function search(){
        $FilterKey = array( "branch_id" => "", "starting" => "",  "endngday" => "", "status"  => "", "v_type" => "");
        if($this->input->post('starting')){ $FilterKey['starting'] = $this->input->post('starting'); }
        if($this->input->post('endingday')){ $FilterKey['endngday'] = $this->input->post('endingday'); }
        if($this->input->post('status')){ $FilterKey['status'] = $this->input->post('status'); }
        if($this->input->post('v_type')){ $FilterKey['v_type'] = $this->input->post('v_type'); }
        if($this->input->post('source')){ $FilterKey['branch_id'] = $this->input->post('source'); }
        $Score = $this->accountsmodel->get_filtered_voucher_statement($FilterKey);
        if($Score != FALSE){
            $this->Merged_Vars['orderz']  = $Score;
            $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
        }
        else{
            $this->Merged_Vars['orderz']  = FALSE;
            $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
        }
    }

    public function ledgerhead(){
        $this->Merged_Vars['ledger']                = $this->accountsmodel->get_editable_ledger_list();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function createledger($ledgerid = FALSE){
        if($ledgerid === FALSE && $this->input->post('trigger') && ($this->input->post('trigger') == 'createledger')){
            //Create Ledger
            $this->Merged_Vars['view'] = 'create';
            $CreateLedgerData = array('ledger' => $this->input->post('ledgername'), 'type' => $this->input->post('type'), 'status' => '1');
            $BabaMa = $this->accountsmodel->createNewLedgerHeadInDb($CreateLedgerData);
            if($BabaMa == TRUE){
                $this->session->set_flashdata('agedata','<div class="alert alert-block alert-success fade in"><button data-dismiss="alert" class="close" type="button">×</button><h4 class="alert-heading">Success!</h4><p>Data processing successful.</p></div>');
                redirect(__CLASS__ . '/ledgerhead');
            }
            else{
                $this->session->set_flashdata('agedata','<div class="alert alert-block alert-error fade in"><button data-dismiss="alert" class="close" type="button">×</button><h4 class="alert-heading">Error!</h4><p>Sorry Ledger Head could not be created now. Try again Later or call system admin.</p></div>');
                redirect(__CLASS__ . '/ledgerhead');
            }
        }
        elseif($ledgerid === FALSE && $this->input->post('trigger') && ($this->input->post('trigger') == 'editledger')){
            $UpdateLedgerData = array('id' => $this->input->post('ledgerid'), 'ledger' => $this->input->post('ledgername'), 'type' => $this->input->post('type'), 'status' => $this->input->post('ledgerstat'));
            $BabaMa = $this->accountsmodel->updateNewLedgerHeadInDb($UpdateLedgerData);
            if($BabaMa == TRUE){
                $this->session->set_flashdata('agedata','<div class="alert alert-block alert-success fade in"><button data-dismiss="alert" class="close" type="button">×</button><h4 class="alert-heading">Success!</h4><p>Data processing successful.</p></div>');
                redirect(__CLASS__ . '/ledgerhead');
            }
            else{
                $this->session->set_flashdata('agedata','<div class="alert alert-block alert-error fade in"><button data-dismiss="alert" class="close" type="button">×</button><h4 class="alert-heading">Error!</h4><p>Sorry Ledger Head could not be created now. Try again Later or call system admin.</p></div>');
                redirect(__CLASS__ . '/ledgerhead');
            }
        }
        else{
            //Edit Ledger
            $param = explode("&", $ledgerid);
            $this->Merged_Vars['ledger'] = $this->accountsmodel->getActiveLedgerList($param[0]);
            $this->Merged_Vars['ledgid'] = $param[0];
            $this->Merged_Vars['view'] = 'modify';
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function orderpayment(){
        //Method Called from order controller details method with order id, called by jQuery.
        $CashoutData = array('co_purpose' => $this->input->post('orderid'), 'co_amount' => number_format($this->input->post('amountp'), 2, '.', ''), 'co_date' => date("Y-m-d"), 'co_time' => date("h:i:s A"), 'u_id' => $this->Merged_Vars['memb'], 'co_identifier' => 1, 'co_status' => 0);
        $Score = $this->accountsmodel->updateOrderCashout($CashoutData);
        if($Score == TRUE){
            $this->session->set_flashdata('agedata','<div class="alert alert-success"><button class="close" data-dismiss="alert">&times;</button><strong>Payments Recieved.</strong></div>');
            redirect('order/details/' . $this->input->post('orderid'));
        }
        else{
            $this->session->set_flashdata('agedata','<div class="alert alert-error"><button class="close" data-dismiss="alert">&times;</button><strong>Error Occured!!</strong></div>');
            redirect('order/details/' . $this->input->post('orderid'));
        }        
    }
    
    public function balance_transfer(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "transfer")){
            $source = $this->Merged_Vars['b_id'];
            $destin = $this->input->post('destination');
            $amount = $this->input->post('balance');
            
            $source_balance = $this->accountsmodel->get_branch_balance($source);
            $destin_balance = $this->accountsmodel->get_branch_balance($destin);
            
            if($source == $destin){
                $this->session->set_flashdata('notification', errormessage('Source & Destination can not be same.'));
                redirect('accounts/transfer', 'refresh');
            }
            
            if($amount > $source_balance){
                $this->session->set_flashdata('notification', errormessage('Please provide a valid amount to be transferred.'));
                redirect('accounts/transfer', 'refresh');
            }
            
            $source_data = array('branch_id' => $source, 'balance' => ($source_balance - $amount));
            $destin_data = array('branch_id' => $destin, 'balance' => ($destin_balance + $amount));
            
            $voucher     = array('branch_id' => $this->Merged_Vars['b_id'], 'v_head' => 4, 'v_type' => 2, 'v_amount' => $amount, 'v_note' => 'Balance transfer from ' . $this->settingsmodel->get_branch_name($source) . ' to ' . $this->settingsmodel->get_branch_name($destin) . '', 'v_date' => date('Y-m-d'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => $this->Merged_Vars['memb']);
            
            $score = $this->accountsmodel->transfer_branch_balance($source_data, $destin_data, $voucher);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Balance has been transferred'));
                redirect('accounts/transfer', 'refresh');
            }
            else{
                $this->session->set_flashdata('notification', errormessage('Please try again later'));
                redirect('accounts/transfer', 'refresh');
            }
            
        } else {
            $this->Merged_Vars['source']                = $this->settingsmodel->get_branch_list();
            $this->Merged_Vars['destin']                = $this->settingsmodel->get_branch_list();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function branch_balance_transfer(){
        $b_id                                   = $this->input->post('b_id');
        $this->Merged_Vars['balance']           = $this->accountsmodel->branch_balance_transfer($b_id);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }

    public function supplier_credit(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "company_credit")){
            $company_credit = array('company' => $this->input->post('company'), 'ledger' => $this->input->post('ledger'), 'amount' => $this->input->post('amount'), 'notes' => $this->input->post('notes'), 'adjust_date' => $this->input->post('adjust_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            $current_credit = $this->suppliermodel->get_supplier_credit($this->input->post('company'));
            $current_blance = $this->accountsmodel->get_branch_balance(1);
            if($company_credit['amount'] > $current_blance){
                $this->session->set_flashdata('notification', errormessage('Amount can not be greater then curren cash in hand'));
                redirect('accounts/suppliercredit', 'refresh');
            }            
            $company_info   = array('c_id' => $this->input->post('company'), 'c_credit' => ($current_credit + $this->input->post('amount')));
            $voucher        = array('branch_id' => 1, 'method' => $this->input->post('method'), 'v_head' => 5, 'v_type' => 2, 'v_amount' => $this->input->post('amount'), 'v_note' => 'Supplier Credit Deposit', 'v_date' => $this->input->post('adjust_date'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => date('h:i:s A'));
            //$cashinhand     = array('branch_id' => 1, 'balance' => ($current_blance - $this->input->post('amount')));
            $cashinhand     = array('branch_id' => 1, 'balance' => ($current_blance));
            
            $score = $this->accountsmodel->post_supplier_credit($company_credit, $company_info, $voucher, $cashinhand);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Supplier Credit posted & cash in hand adjusted'));
                redirect('accounts/suppliercredit', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later'));
                redirect('accounts/suppliercredit', 'refresh');
            }
        } else {
            $this->Merged_Vars['method']                = $this->settingsmodel->get_payment_method();
            $this->Merged_Vars['ledger']                = $this->accountsmodel->get_supplier_credit_ledger();
            $this->Merged_Vars['sups']                  = $this->suppliermodel->get_supplier_list();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function cash_in_hand(){
        $this->Merged_Vars['balance']                   = $this->accountsmodel->get_brachwise_cashinhand();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function voucher_update(){
        $this->Merged_Vars['method']                    = $this->accountsmodel->get_payment_method();
        $this->Merged_Vars['voucher']                   = $this->accountsmodel->get_voucher_info($this->input->get('v_id'));
        $this->Merged_Vars['purpoz']                    = $this->accountsmodel->getActiveLedgerListByType($this->input->get('type'));
        $this->Merged_Vars['v_type']                    = $this->input->get('type');
        if($this->Merged_Vars['voucher'] != FALSE){
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        } else {
            $this->session->set_flashdata('notification', errormessage('Please try again later'));
            redirect('accounts/voucher', 'refresh');
        }
    }
    
    public function loan_opening(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "loandeposit")){
            $user_loan              = array('user_id' => $this->input->post('user_id'), 'balance' => $this->input->post('amount'));
            $loan_deposit           = array('user_id' => $this->input->post('user_id'), 'trans_type' => 0, 'method' => $this->input->post('method'), 'amount' => $this->input->post('amount'), 'notes' => 'Opening Balance - ' . $this->input->post('notes'), 'trans_date' => $this->input->post('trans_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb'] );
            $score_check            = $this->accountsmodel->check_existing_loan($this->input->post('user_id'));
            if($score_check){
                $score                  = $this->accountsmodel->loan_opening_balance($loan_deposit, $user_loan);
                if($score){
                    $this->session->set_flashdata('notification', greensignal('Opening Balance Posted for this user'));
                    redirect('accounts/loanopening', 'refresh');
                } else {
                    $this->session->set_flashdata('notification', errormessage('Please try again later'));
                    redirect('accounts/loanopening', 'refresh');
                }
            } else {
                $this->session->set_flashdata('notification', errormessage('Opening Balance already set for this user'));
                redirect('accounts/loanopening', 'refresh');
            }
        } else {
            $this->Merged_Vars['method']                 = $this->accountsmodel->get_payment_method();
            $this->Merged_Vars['user_list']              = $this->settingsmodel->get_loan_investment_user();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function investment_opening(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "investmentdeposit")){
            $user_loan              = array('user_id' => $this->input->post('user_id'), 'balance' => $this->input->post('amount'));
            $loan_deposit           = array('user_id' => $this->input->post('user_id'), 'trans_type' => 0, 'method' => $this->input->post('method'), 'amount' => $this->input->post('amount'), 'notes' => 'Opening Balance - ' . $this->input->post('notes'), 'trans_date' => $this->input->post('trans_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb'] );
            $score_check            = $this->accountsmodel->check_existing_investment($this->input->post('user_id'));
            if($score_check){
                $score                  = $this->accountsmodel->investment_opening_balance($loan_deposit, $user_loan);
                if($score){
                    $this->session->set_flashdata('notification', greensignal('Opening Balance Posted for this user'));
                    redirect('accounts/investmentopening', 'refresh');
                } else {
                    $this->session->set_flashdata('notification', errormessage('Please try again later'));
                    redirect('accounts/investmentopening', 'refresh');
                }
            } else {
                $this->session->set_flashdata('notification', errormessage('Opening Balance already set for this user'));
                redirect('accounts/investmentopening', 'refresh');
            }
        } else {
            $this->Merged_Vars['method']                 = $this->accountsmodel->get_payment_method();
            $this->Merged_Vars['user_list']              = $this->settingsmodel->get_loan_investment_user();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function loan_voucher(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "loandeposit")){
            $trans_type             = $this->input->post('trans_type');
            $current_cash           = $this->accountsmodel->get_branch_balance(1);
            $current_loan           = $this->accountsmodel->get_user_current_loan($this->input->post('user_id'));
            $amount                 = $this->input->post('amount');
            if($amount < 0){
                $this->session->set_flashdata('notification', errormessage('Amount can not less then Zero'));
                redirect('accounts/loanvoucher', 'refresh');
            }
            if($trans_type == 1){   //In case of deposit
                $balance                = $current_cash + $this->input->post('amount');
                $balance_               = abs($current_loan) + $amount;
                if($current_loan > 0) {
                    $balance__              = $balance_;
                } else {
                    $balance__              = 0 - $balance_;
                }
                $user_loan              = array('user_id' => $this->input->post('user_id'), 'balance' => $balance__);
                $v_type = 1;
            } else if($trans_type == 2){    //In case of refund
                $balance                = $current_cash - $this->input->post('amount');
                if($amount > abs($current_loan)){
                    $this->session->set_flashdata('notification', errormessage('Refund amount can not be more then current loan'));
                    redirect('accounts/loanvoucher', 'refresh');
                }
                if($amount > $current_cash){
                    $this->session->set_flashdata('notification', errormessage('Refund amount can not be more then current cash in central'));
                    redirect('accounts/loanvoucher', 'refresh');
                }
                $balance_               = abs($current_loan) - $amount;
                if($current_loan > 0) {
                    $balance__              = $balance_;
                } else {
                    $balance__              = 0 - $balance_;
                }
                $user_loan              = array('user_id' => $this->input->post('user_id'), 'balance' => $balance__);
                $v_type = 2;
            }
            $loan_deposit           = array( 'user_id' => $this->input->post('user_id'), 'trans_type' => $trans_type, 'method' => $this->input->post('method'), 'amount' => $this->input->post('amount'), 'notes' => $this->input->post('notes'), 'trans_date' => $this->input->post('trans_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb'] );
            $cash_in_hand           = array('branch_id' => 1, 'balance' => $balance);
            $voucher_data           = array('branch_id' => 1, 'method' => $this->input->post('method'), 'v_head' => 11, 'v_type' => $v_type, 'v_amount' => abs($this->input->post('amount')), 'v_note' => $this->input->post('notes'), 'v_date' => $this->input->post('trans_date'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => $this->Merged_Vars['memb']);
            $score                  = $this->accountsmodel->loan_deposit_from_user($voucher_data, $cash_in_hand, $loan_deposit, $user_loan);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Loan deposited from user.'));
                redirect('accounts/loanvoucher', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later'));
                redirect('accounts/loanvoucher', 'refresh');
            }
        } else {
            $this->Merged_Vars['method']                 = $this->accountsmodel->get_payment_method();
            $this->Merged_Vars['user_list']              = $this->settingsmodel->get_loan_investment_user();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function investment_voucher(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "investmentdeposit")){
            $trans_type             = $this->input->post('trans_type');
            $current_balance        = $this->accountsmodel->get_branch_balance(1);
            $current_investment     = $this->accountsmodel->get_user_current_investment($this->input->post('user_id'));
            //echo $current_loan;
            if($trans_type == 1){   //In case of deposit
                $balance                = $current_balance + $this->input->post('amount');
                if($current_investment > 0){
                    $user_investment              = array('user_id' => $this->input->post('user_id'), 'balance' => ($current_investment + $this->input->post('amount')));
                } else {
                    $user_investment              = array('user_id' => $this->input->post('user_id'), 'balance' => ($current_investment - $this->input->post('amount')));
                }
                $v_type = 1;
                $v_head = 55;
            } else if($trans_type == 2){    //In case of refund
                $amount                 = $this->input->post('amount');
                $balance                = $current_balance - $this->input->post('amount');
                if($current_investment > 0){
                    $user_investment              = array('user_id' => $this->input->post('user_id'), 'balance' => ($current_investment - $this->input->post('amount')));
                } else {
                    $user_investment              = array('user_id' => $this->input->post('user_id'), 'balance' => ($current_investment + $this->input->post('amount')));
                }
                if($amount > $current_balance || $amount > $current_investment)
                {
                    $this->session->set_flashdata('notification', errormessage('Wrong Amount Posted!! Can no be more then current Investment or cash in hand (Central)'));
                    redirect('accounts/investmentvoucher', 'refresh');
                }
                $v_type = 2;
                $v_head = 56;
            }
            $investment_deposit         = array( 'user_id' => $this->input->post('user_id'), 'trans_type' => $trans_type, 'method' => $this->input->post('method'), 'amount' => $this->input->post('amount'), 'notes' => $this->input->post('notes'), 'trans_date' => $this->input->post('trans_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb'] );
            $cash_in_hand               = array('branch_id' => 1, 'balance' => $balance);
            $voucher_data               = array('branch_id' => 1, 'method' => $this->input->post('method'), 'v_head' => $v_head, 'v_type' => $v_type, 'v_amount' => abs($this->input->post('amount')), 'v_note' => $this->input->post('notes'), 'v_date' => $this->input->post('trans_date'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => $this->Merged_Vars['memb']);
            $score                      = $this->accountsmodel->investment_deposit_from_user($voucher_data, $cash_in_hand, $investment_deposit, $user_investment);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Investment deposited from user.'));
                redirect('accounts/investmentvoucher', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later'));
                redirect('accounts/investmentvoucher', 'refresh');
            }
        } else {
            $this->Merged_Vars['method']                 = $this->accountsmodel->get_payment_method();
            $this->Merged_Vars['user_list']              = $this->settingsmodel->get_loan_investment_user();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function loan_statement(){
        $this->Merged_Vars['loan_balance']           = $this->accountsmodel->get_loan_balance();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function investment_statement(){
        $this->Merged_Vars['loan_balance']           = $this->accountsmodel->get_investment_balance();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function loan_ledger(){
        $this->Merged_Vars['u_name']                = getUserName($this->input->get('user'));
        $this->Merged_Vars['printer']               = 'Loan Ledger for ' . $this->Merged_Vars['u_name'];
        $this->Merged_Vars['statement']             = $this->accountsmodel->get_loan_statement($this->input->get('user'));
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function investment_ledger(){
        $this->Merged_Vars['u_name']                = getUserName($this->input->get('user'));
        $this->Merged_Vars['printer']               = 'Investment Ledger for ' . $this->Merged_Vars['u_name'];
        $this->Merged_Vars['statement']             = $this->accountsmodel->get_investment_statement($this->input->get('user'));
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function loan_refund(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "loanrefund")){
            $current_balance        = $this->accountsmodel->get_branch_balance(1);
            $current_loan           = $this->accountsmodel->get_user_current_loan($this->input->post('user_id'));
            $loan_deposit           = array('user_id' => $this->input->post('user_id'), 'trans_type' => 2, 'method' => $this->input->post('method'), 'amount' => $this->input->post('amount'), 'notes' => $this->input->post('notes'), 'trans_date' => $this->input->post('trans_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            if($current_balance < $loan_deposit['amount']){
                $this->session->set_flashdata('notification', errormessage('You do not have sufficient amount in your central depot to refund the loan.'));
                redirect('accounts/loanstatement', 'refresh');
            }
            $balance                = $current_balance - $this->input->post('amount');
            $cash_in_hand           = array('branch_id' => 1, 'balance' => $balance);
            $voucher_data           = array('branch_id' => 1, 'method' => $this->input->post('method'), 'v_head' => 14, 'v_type' => 2, 'v_amount' => $this->input->post('amount'), 'v_note' => $this->input->post('notes'), 'v_date' => $this->input->post('trans_date'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => $this->Merged_Vars['memb']);
            $user_loan              = array('user_id' => $this->input->post('user_id'), 'balance' => ($current_loan - $this->input->post('amount')));
            $score                  = $this->accountsmodel->loan_deposit_from_user($voucher_data, $cash_in_hand, $loan_deposit, $user_loan);
            //$score = true;
            if($score){
                $this->session->set_flashdata('notification', greensignal('Loan refunded from user.'));
                redirect('accounts/loanbalance', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later'));
                redirect('accounts/loanbalance', 'refresh');
            }
        } else {
            $this->Merged_Vars['method']            = $this->accountsmodel->get_payment_method();
            $this->Merged_Vars['u_name']            = getUserName($this->input->get('user'));
            $this->Merged_Vars['userid']            = $this->input->get('user');
            $this->Merged_Vars['balance']           = $this->accountsmodel->get_loan_opening_balance($this->input->get('user'));
            if($this->Merged_Vars['balance']){
                $this->Merged_Vars['balance']           = $this->accountsmodel->get_loan_opening_balance($this->input->get('user'));
            } else {
                $this->Merged_Vars['balance']           = 0;
            }
            $this->Merged_Vars['transtype']         = $this->input->get('trans_type');
            $this->Merged_Vars['cash_hand']         = $this->accountsmodel->get_branch_balance(1);
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function daily_closing(){
        if($this->input->post('trigger') == "close_the_day"){
            $closing_data = array(
                'closing_date' => $this->input->post('closing_date'),
                'company_balance' => $this->input->post('company_balance'),
                'stock_balance' => $this->input->post('stock_balance'),
                'cash_in_hand' => $this->input->post('cash_in_hand'),
                'damage_balance' => $this->input->post('damage_balance'),
                'total_due_balance' => $this->input->post('total_due_balance'),
                'loan_balance' => $this->input->post('loan_balance'),
                'invest_balance' => $this->input->post('invest_balance'),
                'posting_date' => date('Y-m-d'),
                'posting_time' => date('h:i:s A'),
                'posting_by' => $this->Merged_Vars['memb']
            );
            $score = $this->accountsmodel->daily_business_closing($closing_data);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Daily Business Closed.'));
                redirect('accounts/dailyclosing', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later'));
                redirect('accounts/dailyclosing', 'refresh');
            }
        } else {
            $closing                                    = array();
            $closing['Profit']                          = 0;
            $closing['Company']                         = $this->accountsmodel->daily_closing_company();
            $closing['Damage']                          = $this->accountsmodel->cash_amount_in_damage();
            $closing['Stock']                           = $this->accountsmodel->cash_amount_in_stock();
            $closing['TotalSale']                       = $this->accountsmodel->daily_sale_for_closing();
            $closing['Collection']                      = $this->accountsmodel->daily_collection_for_closing();
            $closing['TotalDue']                        = $this->accountsmodel->total_due_for_closing();
            $closing['Liability']                       = $this->accountsmodel->total_loan_for_closing();
            $closing['CashInHand']                      = $this->accountsmodel->total_cash_in_hand_for_closing();
            $closing['Investment']                      = $this->accountsmodel->total_investment_for_closing();
            $this->Merged_Vars['last_closing']          = $this->accountsmodel->last_closing_date();
            if($this->Merged_Vars['last_closing'] == FALSE){
                $closing['closing_date']                = date('Y-m-d');
            } else {
                $last_date                              = new DateTime($this->Merged_Vars['last_closing']);
                $last_date->modify('+1 day');
                $closing['closing_date']                = $last_date->format('Y-m-d');
            }
            $this->Merged_Vars['flag']                  = $this->accountsmodel->closing_permission_flag();
            $this->Merged_Vars['printer']               = 'Datewise Daily Closing Record';
            $this->Merged_Vars['closing_value']         = $closing;
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function get_closing_record(){
        $closing_data   = array('from' => '', 'to' => '');
        if($this->input->post('from')){
            $closing_data['from'] = $this->input->post('from');
        }
        if($this->input->post('to')){
            $closing_data['to'] = $this->input->post('to');
        }
        
        $this->Merged_Vars['records']                   = $this->accountsmodel->search_closing_record($closing_data);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function cash_book_opening(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "cash_book_deposit")){
            $user_cash_book         = array('user_id' => $this->input->post('user_id'), 'balance' => $this->input->post('amount'));
            $cash_book_deposit      = array('user_id' => $this->input->post('user_id'), 'trans_type' => 0, 'method' => $this->input->post('method'), 'amount' => $this->input->post('amount'), 'balance' => $this->input->post('amount'), 'notes' => 'Cash Book Opening Balance - ' . $this->input->post('notes'), 'trans_date' => $this->input->post('trans_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            $score_check            = $this->accountsmodel->check_existing_cash_book($this->input->post('user_id'));
            if($score_check){
                $score                  = $this->accountsmodel->cash_book_opening_balance($cash_book_deposit, $user_cash_book);
                if($score){
                    $this->session->set_flashdata('notification', greensignal('Opening Balance Posted for this user'));
                    redirect('accounts/cashbookopening', 'refresh');
                } else {
                    $this->session->set_flashdata('notification', errormessage('Please try again later'));
                    redirect('accounts/cashbookopening', 'refresh');
                }
            } else {
                $this->session->set_flashdata('notification', errormessage('Opening Balance already set for this user'));
                redirect('accounts/cashbookopening', 'refresh');
            }
        } else {
            $this->Merged_Vars['method']                 = $this->accountsmodel->get_payment_method();
            $this->Merged_Vars['user_list']              = $this->settingsmodel->get_loan_investment_user();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function cash_book_voucher(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "cash_book_voucher")){
            $trans_type             = $this->input->post('trans_type');
            $cash_in_hand           = $this->accountsmodel->get_branch_balance(1);
            $cash_balance           = $this->accountsmodel->get_user_current_cash_balance($this->input->post('user_id'));
            $voucher_amnt           = $this->input->post('amount');
            if($voucher_amnt < 0){
                $this->session->set_flashdata('notification', errormessage('Amount can not less then Zero'));
                redirect('accounts/cashbookvoucher', 'refresh');
            }
            if($trans_type == 2 && $voucher_amnt > $cash_in_hand){
                $this->session->set_flashdata('notification', errormessage('Amount can not more then cash in hand in central.'));
                redirect('accounts/cashbookvoucher', 'refresh');
            }
            if($trans_type == 1){   //In case of deposit
                $cash_in_hand       = $cash_in_hand + $voucher_amnt;
                $cash_balance       = $cash_balance + $voucher_amnt;
                $v_ledger           = 72;
            } else if($trans_type == 2){
                $cash_in_hand       = $cash_in_hand - $voucher_amnt;
                $cash_balance       = $cash_balance - $voucher_amnt;
                $v_ledger           = 73;
            }
            $voucher_data           = array('branch_id' => 1, 'method' => $this->input->post('method'), 'v_head' => $v_ledger, 'v_type' => $trans_type, 'v_amount' => $voucher_amnt, 'v_note' => $this->input->post('notes'), 'v_date' => $this->input->post('trans_date'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => $this->Merged_Vars['memb']);
            $cashinhand             = array('branch_id' => 1, 'balance' => $cash_in_hand);
            $cash_book_deposit      = array('user_id' => $this->input->post('user_id'), 'trans_type' => $trans_type, 'method' => $this->input->post('method'), 'amount' => $voucher_amnt, 'balance' => $cash_balance, 'notes' => $this->input->post('notes'), 'trans_date' => $this->input->post('trans_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            $user_cash_book         = array('user_id' => $this->input->post('user_id'), 'balance' => $cash_balance);
            $score                  = $this->accountsmodel->cash_book_ledger($voucher_data, $cashinhand, $cash_book_deposit, $user_cash_book);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Voucher posted from user.'));
                redirect('accounts/cashbookvoucher', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later'));
                redirect('accounts/cashbookvoucher', 'refresh');
            }
        } else {
            $this->Merged_Vars['method']                 = $this->accountsmodel->get_payment_method();
            $this->Merged_Vars['user_list']              = $this->settingsmodel->get_loan_investment_user();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function cash_book_statement(){
        $this->Merged_Vars['loan_balance']           = $this->accountsmodel->get_cash_book_balance();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function cash_book_ledger(){
        $this->Merged_Vars['u_name']                = getUserName($this->input->get('user'));
        $this->Merged_Vars['printer']               = 'Cash Book Ledger for ' . $this->Merged_Vars['u_name'];
        $this->Merged_Vars['statement']             = $this->accountsmodel->get_cash_book_statement($this->input->get('user'));
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
}
?>