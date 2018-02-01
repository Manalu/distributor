<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of loginmodel
 *
 * @author  I AM CODY
 * @name    Tarek Showkot
 * @contact priom2000@gmail.com, tarek@exploriasolution.com
 *
 */
class sales extends CI_Controller {
    //put your code here
    
    public $Public_Vars = array();
    public $Sesson_Vars = array();
    public $Merged_Vars = array();
    public $CartData    = array();

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
                $this->Merged_Vars['controller'] = "Sales";
            }
        }
    }
    
    public function index(){
        redirect(__CLASS__ . '/invoice');
    }
    
    public function invoice(){
        $this->Merged_Vars['sups']              = $this->suppliermodel->get_supplier_list();
        $this->Merged_Vars['customer']          = $this->clientsmodel->get_client_list();
        $this->loginmodel->remove_temp_item($this->Merged_Vars['memb']);
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function get_invoice_customer(){
        $this->Merged_Vars['customer']          = $this->clientsmodel->get_client_list($this->input->post('type'));
        $this->load->view(__CLASS__. '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function stocksearch(){
        $fileter_options                                = array('p_cid' => "", 'branch_id' => "");
        if($this->input->post('sup')){
            $fileter_options['p_cid']                   = $this->input->post('sup');
        }
        if($this->input->post('branchs')){
            $fileter_options['branch_id']               = $this->input->post('branchs');
        }
        $this->Merged_Vars['prods']                     = $this->ordermodel->get_product_list_by_supplier($fileter_options);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function add_to_cart(){
        $normal_array                             = array();
        $another_array                            = array('SomeName' => getUserName($this->Merged_Vars['memb']));
        $normal_array['branch_id']                = $this->input->post('branch');
        $normal_array['client_id']                = $this->input->post('customer');
        $normal_array['company_id']               = $this->input->post('company');
        $normal_array['product_id']               = $this->input->post('product');
        $normal_array['group_id']                 = $this->input->post('group'); 
        $normal_array['cartoon']                  = $this->input->post('cartoon');
        $normal_array['piece']                    = $this->input->post('piece');
        $normal_array['bonus']                    = $this->input->post('bonusqty');
        $normal_array['quantity']                 = $this->input->post('quantity');
        $normal_array['u_rate']                   = $this->input->post('unitrate');
        $normal_array['price']                    = $this->input->post('itemprice');
        $normal_array['post_date']                = date('Y-m-d');
        $normal_array['post_time']                = date('h:i:s A');
        $normal_array['post_by']                  = $this->Merged_Vars['memb'];
        $score = $this->salesmodel->add_temp_cart_item($normal_array);
        if($score){
            $normal_array['stok']                 = $this->salesmodel->product_stock_remove($this->input->post('product'), $this->input->post('branch'));
            $normal_array['perbox']               = $this->salesmodel->product_box_quantity($this->input->post('product'));
            $normal_array['cart_id']              = $this->db->insert_id();
            $normal_array['sms']                  = "Added";
            if($normal_array['stok'] == NULL){
                $normal_array['box'] = 0;
            } else {
                $normal_array['box'] = get_number_of_boxes($normal_array['stok'], $normal_array['perbox']);
            }
            $this->load->view(strtolower(__CLASS__) . '/' . __FUNCTION__, $normal_array);
        } else {
            echo errormessage();
        }
    }
    
    public function remove_from_cart(){
        $score                                    = $this->salesmodel->remove_from_cart($this->input->post('cart_id'));
        $normal_array                             = array();
        $another_array                            = array('SomeName' => getUserName($this->Merged_Vars['memb']));
        $normal_array['branch_id']                = $this->input->post('branch');
        $normal_array['company_id']               = $this->input->post('company');
        $normal_array['product_id']               = $this->input->post('product');
        $normal_array['group_id']                 = $this->input->post('group'); 
        $normal_array['cartoon']                  = $this->input->post('cartoon');
        $normal_array['piece']                    = $this->input->post('piece');
        $normal_array['bonus']                    = $this->input->post('bonusqty');
        $normal_array['quantity']                 = $this->input->post('quantity');
        $normal_array['u_rate']                   = $this->input->post('price');
        $normal_array['stok']                     = $this->salesmodel->product_stock_remove($this->input->post('product'), $this->input->post('branch'));
        $normal_array['perbox']                   = $this->salesmodel->product_box_quantity($this->input->post('product'));
        $normal_array['sms']                      = "Added";
        if($normal_array['stok'] == NULL){
            $normal_array['box'] = 0;
        } else {
            $normal_array['box'] = get_number_of_boxes($normal_array['stok'], $normal_array['perbox']);
        }
        if($score){
            $this->load->view(strtolower(__CLASS__) . '/cart_button', $normal_array);
        } else {
            echo errormessage();
        }
    }

    public function queue(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "sales/invoice")){
            $this->Merged_Vars['info']          = $this->clientsmodel->getClientDetails($this->input->post('customer'));
            $this->Merged_Vars['items']         = $this->salesmodel->get_cart_items($this->Merged_Vars['memb'], $this->Merged_Vars['b_id'], $this->input->post('customer'), date('Y-m-d'));
            if($this->Merged_Vars['items'] == FALSE){
                $this->session->set_flashdata('notification', errormessage('There is no item in the cart'));
                redirect('sales/invoice', 'refresh');
            }
            $this->Merged_Vars['total_item']    = $this->Merged_Vars['items']->num_rows();
            $this->Merged_Vars['method']        = $this->accountsmodel->get_payment_method();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        } else {
            $this->session->set_flashdata('notification', errormessage(''));
            redirect('sales/invoice', 'refresh');
        }
    }
    
    public function invoice_details(){
        $this->Merged_Vars['info']              = $this->clientsmodel->getClientDetails($this->input->get('customer'));
        $this->Merged_Vars['items']             = $this->salesmodel->get_invoice_items($this->input->get('invoice'));
        $this->Merged_Vars['total_item']        = $this->Merged_Vars['items']->num_rows();
        $this->Merged_Vars['method']            = $this->accountsmodel->get_payment_method();
        $this->Merged_Vars['invoice_info']      = $this->salesmodel->get_invoice_details($this->input->get('invoice'));
        $this->Merged_Vars['balance']           = $this->salesmodel->get_customer_balance($this->input->get('customer'));
        $this->Merged_Vars['printer']           = '';
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function invoice_update(){
        $this->Merged_Vars['info']              = $this->clientsmodel->getClientDetails($this->input->get('customer'));
        $this->Merged_Vars['items']             = $this->salesmodel->get_invoice_items_for_update($this->input->get('invoice'), $this->Merged_Vars['b_id']);
        $this->Merged_Vars['total_item']        = $this->Merged_Vars['items']->num_rows();
        $this->Merged_Vars['method']            = $this->accountsmodel->get_payment_method();
        $this->Merged_Vars['invoice_info']      = $this->salesmodel->get_invoice_details($this->input->get('invoice'));
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function confirm(){
        if($this->input->post('trigger')){
            $status         = 1;
            $total_bil      = $this->input->post('total_bill');
            $payment        = $this->input->post('payment');
            if($payment == $total_bil) { $status = 2; }
            $invoice_data   = array('inv_route' => $this->input->post('inv_route'), 'client_id' => $this->input->post('client_id'), 'branch_id' => $this->input->post('branch_id'), 'total_item' => $this->input->post('total_item'), 'sale_date' => date('Y-m-d'), 'sub_total' => $this->input->post('sub_total'), 'discount' => $this->input->post('discount'), 'total_bill' => $this->input->post('total_bill'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb'], 'status' => $status);
            $tble_id        = $this->input->post('tble_id');
            $company_id     = $this->input->post('company_id');
            $product_id     = $this->input->post('product_id');
            $group_id       = $this->input->post('group_id');
            $cartoon        = $this->input->post('cartoon');
            $piece          = $this->input->post('piece');
            $bonus          = $this->input->post('bonus');
            $quantity       = $this->input->post('quantity');
            $u_rate         = $this->input->post('u_rate');
            $price          = $this->input->post('price');
            $voucher        = array('branch_id' => $this->input->post('branch_id'), 'method' => $this->input->post('method'), 'v_head' => 15, 'v_type' => 1, 'v_amount' => $payment, 'v_note' => '', 'v_date' => date('Y-m-d'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => $this->Merged_Vars['memb']);
            $payment_tble   = array('invoice_id' => 0, 'branch_id' => $this->input->post('branch_id'), 'client_id' => $this->input->post('client_id'), 'voucher_id' => 0, 'client_voucher' => 0, 'amount' => $payment, 'payment_date' => date('Y-m-d'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            $cl_inv_ledger  = array('client_id' => $this->input->post('client_id'), 'ledger_id' => 2, 'ledger_type' => 1, 'amount' => $this->input->post('total_bill'), 'invoice_id' => 0, 'notes' => '', 'ledger_date' => date('Y-m-d'), 'posting_date' => date('Y-m-d H:i:s'), 'posting_by' => $this->Merged_Vars['memb']);
            $client_table   = array('cl_id' => $this->input->post('client_id'), 'cl_balance' => ($this->clientsmodel->get_customer_balance($this->input->post('client_id')) + $this->input->post('total_bill')));
            $score          = $this->salesmodel->create_new_invoice($invoice_data, $tble_id, $company_id, $product_id, $group_id, $cartoon, $piece, $bonus, $quantity, $u_rate, $price, $voucher, $payment_tble, $cl_inv_ledger, $client_table);
            if($score){
                $this->loginmodel->remove_temp_item($this->Merged_Vars['memb']);
                $this->session->set_flashdata('notification', greensignal('Invoice Created.'));
                redirect('sales/invoice', 'refresh');
            }
            else{
                $this->loginmodel->remove_temp_item($this->Merged_Vars['memb']);
                $this->session->set_flashdata('notification', errormessage('Please Try Again Later.'));
                redirect('sales/invoice', 'refresh');
            }
        } else {
            $this->loginmodel->remove_temp_item($this->Merged_Vars['memb']);
            $this->session->set_flashdata('notification', errormessage('Try setting up the invoice first'));
            redirect('sales/invoice', 'refresh');
        }
    }
    
    public function exchange(){
        //if($this->input->post()){
        if($this->input->post('trigger') && $this->input->post('trigger') == 'update'){
            $status         = 1;
            $billed = $this->input->post('earlier_total_bill');
            $paid   = $this->salesmodel->get_invoice_total_paid_amount($this->input->post('invoice_id'));
            $due    = $billed - $paid;
            $adjust = $this->input->post('adjustment_value');
            $paymnt = $this->input->post('invoice_payment');
            
            if($paymnt > $adjust){
                $this->session->set_flashdata('notification', errormessage('Total return amount can not be greater then paid amount.'));
                redirect('sales/update?func=update&cat=sales&mod=admin&sess_auth=4feaece77bf64082dfe5ce990d331d13&remote=c9e1074f5b3f9fc8ea15d152add07294&invoice=' . $this->input->post('invoice_id') . '&customer=' . $this->input->post('client_id') . '', 'refresh');
            }
            if($paymnt < 0){
                $this->session->set_flashdata('notification', errormessage('Payment can not be less then Zero.'));
                redirect('sales/update?func=update&cat=sales&mod=admin&sess_auth=4feaece77bf64082dfe5ce990d331d13&remote=c9e1074f5b3f9fc8ea15d152add07294&invoice=' . $this->input->post('invoice_id') . '&customer=' . $this->input->post('client_id') . '', 'refresh');
            }
            
            if($adjust == $paymnt || $paymnt == $due){
                $status = 2;
            }
            $cl_id  = $this->input->post('client_id');
            $invid  = $this->input->post('invoice_id');
            $branc  = $this->input->post('branch_id');
            $prevs  = $this->input->post('previous_due');
            $ppaid  = $this->input->post('previous_paid');
            
            $invoice_table  = array('tble_id' => $this->input->post('invoice_id'), 'sub_total' => $this->input->post('earlier_sub_total'), 'discount' => $this->input->post('invoice_discount'), 'total_bill' => $this->input->post('earlier_total_bill'), 'status' => $status);
            if($ppaid > $billed){
                $this->session->set_flashdata('notification', errormessage('Total return amount can not be greater then paid amount.'));
                redirect('sales/update?func=update&cat=sales&mod=admin&sess_auth=4feaece77bf64082dfe5ce990d331d13&remote=c9e1074f5b3f9fc8ea15d152add07294&invoice=' . $this->input->post('invoice_id') . '&customer=' . $this->input->post('client_id') . '', 'refresh');
            }
            if(($paymnt + $ppaid) > $billed){
                $this->session->set_flashdata('notification', errormessage('Total return amount can not be greater then paid amount.'));
                redirect('sales/update?func=update&cat=sales&mod=admin&sess_auth=4feaece77bf64082dfe5ce990d331d13&remote=c9e1074f5b3f9fc8ea15d152add07294&invoice=' . $this->input->post('invoice_id') . '&customer=' . $this->input->post('client_id') . '', 'refresh');
            }
            $current_blnce  = ($this->clientsmodel->get_customer_balance($cl_id) + $ppaid - $prevs + $this->input->post('earlier_total_bill') - $paymnt - $ppaid);
            
            $client_table   = array('cl_id' => $cl_id, 'cl_balance' => $current_blnce);
            $cl_inv_ledger  = array('client_id' => $cl_id, 'ledger_id' => 3, 'ledger_type' => 2, 'amount' => $paymnt, 'invoice_id' => $invid, 'notes' => 'Sales Update/Return Invoice: ' . $invid, 'ledger_date' => date('Y-m-d'), 'posting_date' => date('Y-m-d H:i:s'), 'posting_by' => $this->Merged_Vars['memb']);
            $cl_sec_ledger  = array('client_id' => $cl_id, 'ledger_id' => 3, 'ledger_type' => 2, 'amount' => ($prevs - $this->input->post('earlier_total_bill')), 'invoice_id' => $invid, 'notes' => 'Sales Update/Return Invoice: ' . $invid, 'ledger_date' => date('Y-m-d'), 'posting_date' => date('Y-m-d H:i:s'), 'posting_by' => $this->Merged_Vars['memb']);
            
            $item_id        = $this->input->post('tble_id');
            $product_id     = $this->input->post('product_id');
            $group_id       = $this->input->post('group_id');
            $cartoon        = $this->input->post('cartoon');
            $cartoon_new    = $this->input->post('cartoon_new');
            $piece          = $this->input->post('piece');
            $piece_new      = $this->input->post('piece_new');
            $bonus          = $this->input->post('bonus');
            $bonus_new      = $this->input->post('bonus_new');
            $quantity       = $this->input->post('quantity');
            $quantity_new   = $this->input->post('quantity_new');
            $u_rate         = $this->input->post('u_rate');
            $price          = $this->input->post('price');
            $price_new      = $this->input->post('cart_price');
            $company_id     = $this->input->post('company_id');
            $stock          = $this->input->post('stock');
            
            $payment_tble   = array('invoice_id' => $invid, 'branch_id' => $branc, 'client_id' => $cl_id, 'voucher_id' => 0, 'amount' => $paymnt, 'payment_date' => date('Y-m-d'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            $invoice_update = array('invoice_id' => $invid, 'update_date' => date('Y-m-d H:i:s'), 'update_user' => $this->Merged_Vars['memb']);
            $voucher        = array('branch_id' => $branc, 'method' => 2, 'v_head' => 16, 'v_type' => 1, 'v_amount' => $paymnt, 'v_note' => 'Sales Return/Update Invoice: ' . $invid, 'v_date' => date('Y-m-d'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => $this->Merged_Vars['memb']);
            $current        = $this->accountsmodel->get_branch_balance($branc);
            $cash_in_Hand   = array('branch_id' => $branc, 'balance' => ($current + $paymnt));
            for($i = 0; $i < count($stock); $i++){
                $rtqty = $quantity[$i] - $quantity_new[$i];
                $stock[$i] = $stock[$i] + $rtqty;
            }
            $score          = $this->salesmodel->update_existing_invoice($invoice_table, $client_table, $cl_inv_ledger, $cl_sec_ledger, $branc, $invid, $cl_id, $item_id, $product_id, $group_id, $cartoon, $cartoon_new, $piece, $piece_new, $bonus, $bonus_new, $quantity, $quantity_new, $u_rate, $price, $price_new, $company_id, $stock, $payment_tble, $invoice_update, $voucher, $cash_in_Hand, $this->Merged_Vars['memb']);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Invoice Updated.'));
                redirect('sales/list', 'refresh');
            }
            else{
                $this->session->set_flashdata('notification', errormessage('Please Try Again Later.'));
                redirect('sales/list', 'refresh');
            }
        } else {
            $this->session->set_flashdata('notification', errormessage());
            redirect('sales/list', 'refresh');
        }
    }

    public function invoice_list(){
        $filter_data                                = array('starting' => date('Y-m-01'), 'ending' => date('Y-m-t'), 'client_id' => '');
        $this->Merged_Vars['customer']              = $this->clientsmodel->get_client_list();
        $this->Merged_Vars['invoices']              = $this->salesmodel->get_invoice_list($filter_data);
        $this->Merged_Vars['method']                = $this->accountsmodel->get_payment_method();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function search_by_data(){
        $filter_data                                = array('starting' => date('Y-m-01'), 'ending' => date('Y-m-t'), 'client_id' => '');
        if($this->input->post('starting')){
            $filter_data['starting'] = $this->input->post('starting');
        }
        if($this->input->post('ending')){
            $filter_data['ending'] = $this->input->post('ending');
        }
        if($this->input->post('client_id')){
            $filter_data['client_id'] = $this->input->post('client_id');
        }
        
        $this->Merged_Vars['invoices']              = $this->salesmodel->get_invoice_list($filter_data);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function search_by_invoice(){
        $this->Merged_Vars['invoices']              = $this->salesmodel->get_invoice_list_by_tble_id($this->input->post('invoice'));
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function payment(){
        $status         = 1;
        $billed         = $this->input->post('bill_amount');
        $paidam         = $this->input->post('paid_amount');
        $paidmn         = $this->input->post('payment_amount');
        $totalp         = $paidam + $paidmn;
        
        if($totalp > $billed){
            $this->session->set_flashdata('notification', errormessage('Total paid amount can not be greater then billed amount'));
            redirect($this->input->post('redirect'), 'refresh');
        }
        
        if($totalp == $billed){
            $status = 2;
        }
        
        $invoice        = array('tble_id'   => $this->input->post('invoice_id'), 'status'    => $status);
        $inv_payment    = array('invoice_id' => $this->input->post('invoice_id'), 'branch_id' => $this->Merged_Vars['b_id'], 'client_id' => $this->input->post('client_id'), 'voucher_id' => 0, 'amount' => $this->input->post('payment_amount'), 'payment_date' => $this->input->post('payment_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
        $cl_inv_ledger  = array('client_id' => $this->input->post('client_id'), 'ledger_id' => 4, 'ledger_type' => 2, 'amount' => $this->input->post('payment_amount'), 'invoice_id' => $this->input->post('invoice_id'), 'notes' => 'Sales Collection Invoice: ' . $this->input->post('invoice_id'), 'ledger_date' => $this->input->post('payment_date'), 'posting_date' => date('Y-m-d H:i:s'), 'posting_by' => $this->Merged_Vars['memb']);
        $client_table   = array('cl_id' => $this->input->post('client_id'), 'cl_balance' => ($this->clientsmodel->get_customer_balance($this->input->post('client_id')) - $this->input->post('payment_amount')));
        $voucher        = array('branch_id' => $this->Merged_Vars['b_id'], 'method' => $this->input->post('method'), 'v_head' => 16, 'v_type' => 1, 'v_amount' => $this->input->post('payment_amount'), 'v_note' => 'Partial Payment for Invoice: ' . $this->input->post('invoice_id'), 'v_date' => $this->input->post('payment_date'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => $this->Merged_Vars['memb']);
        $score          = $this->salesmodel->partial_invoice_payment($invoice, $voucher, $inv_payment, $cl_inv_ledger, $client_table);
        if($score){
            $this->session->set_flashdata('notification', greensignal('Payment Made.'));
            redirect($this->input->post('redirect'), 'refresh');
        }
        else{
            $this->session->set_flashdata('notification', errormessage('Please Try Again Later.'));
            redirect($this->input->post('redirect'), 'refresh');
        }
    }
    
    public function cancel_sales(){
        $this->session->set_flashdata('notification', greensignal('Invoice has been cancelled!!'));
        redirect('sales/invoice', 'refresh');
    }
    
    public function invoice_transfer(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "invtrans")){
            
        } else {
            //$this->Merged_Vars['']
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function invoice_transfer_details(){
        $this->Merged_Vars['invoice_info']      = $this->salesmodel->get_invoice_details($this->input->post('invoice'));
        if($this->Merged_Vars['invoice_info'] != FALSE) {
            //if($this->Merged_Vars['invoice_info']->branch_id == $this->Merged_Vars['b_id']){
                $this->Merged_Vars['info']              = $this->clientsmodel->getClientDetails($this->Merged_Vars['invoice_info']->client_id);
                $this->Merged_Vars['items']             = $this->salesmodel->get_invoice_items($this->input->post('invoice'));
                $this->Merged_Vars['total_item']        = $this->Merged_Vars['items']->num_rows();
                $this->Merged_Vars['method']            = $this->accountsmodel->get_payment_method();
                $this->Merged_Vars['balance']           = $this->salesmodel->get_customer_balance($this->Merged_Vars['invoice_info']->client_id);
                $this->Merged_Vars['printer']           = '';
                $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
            //} else {
                //echo errormessage('This invoice is not of your branch to be transferred.');
            //}
        } else {
            echo errormessage('Wrong Invoice Number.');
        }
    }
}
?>