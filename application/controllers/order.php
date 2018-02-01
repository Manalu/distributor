<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of loginmodel
 *
 * @author  I AM CODY 
 * @name    Tarek Showkot
 * @contact tarek@exploriasolution.com, priom2000@gmail.com
 *
 */
/**
 * Order Status. There are three status of an order.
 *
 * 1: Order is Placed, in this case, stock is not yet updated. and no cashout is made.
 * 2: Order is Received and thus stock is updated and also cashout is made too.
 * 3: Order is Cancelled, Received orders can not be cancelled. When an order is cancelled, stock is not updated, neither cashout is made.
 * 4: Order is Paid, fully
 *
 */
class order extends CI_Controller {
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
            if($this->Sesson_Vars['role'] != 2 && $this->Sesson_Vars['role'] != 3 && $this->Sesson_Vars['role'] != 1){
                redirect('login','refresh');
            }
            else{
                $this->Merged_Vars = array_merge($this->Public_Vars, $this->Sesson_Vars);
            }
        }
    }
    
    public function index(){
        redirect(__CLASS__ . '/orderlist');
    }
    
    public function purchase(){
        $this->Merged_Vars['sups']                      = $this->suppliermodel->get_supplier_list();
        $this->Merged_Vars['destin']                    = $this->settingsmodel->get_branch_list();
        $this->loadView(__CLASS__, __FUNCTION__,  $this->Merged_Vars);
    }
    
    public function shortsearch(){
        $fileter_options                                = array('p_cid' => "", 'branch_id' => "");
        if($this->input->post('sup')){
            $fileter_options['p_cid']                   = $this->input->post('sup');
        }
        if($this->input->post('branchs')){
            $fileter_options['branch_id']               = $this->input->post('branchs');
        }
        $this->Merged_Vars['prods']                     = $this->ordermodel->get_short_product_list_by_supplier($fileter_options);
        $this->load->View(__CLASS__.'/'.__FUNCTION__, $this->Merged_Vars);
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
        $this->load->View(__CLASS__.'/'.__FUNCTION__, $this->Merged_Vars);
    }
    
    public function queue(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "order/purchase")){
           $p_id    = $this->input->post('product_id');
           if(count($p_id) > 200){
               $this->session->set_flashdata('agedata', 'Can not order more then 200 items at a time');
               redirect(__CLASS__. '/purchase');
           }
           $score = $this->ordermodel->add_order_queue($p_id);  
           if($score != FALSE){
               redirect(__CLASS__. '/submit/' . $score);
           }
           else {
               redirect(__CLASS__. '/purchase');
           }
        }
    }
    
    public function submit($orid){
        $this->Merged_Vars['info']                      = $this->ordermodel->get_order_info($orid);
        $this->Merged_Vars['shopinfo']                  = $this->settingsmodel->getStoreInformationForOrderController();
        $this->Merged_Vars['items']                     = $this->ordermodel->get_order_items($orid);
        $this->Merged_Vars['disorid']                   = $orid;
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function delete(){
        $orid   = $this->input->get('order');
        $comp   = $this->input->get('company');
        $paid   = $this->ordermodel->get_order_total($orid);
        $blnc   = $this->ordermodel->get_supplier_balance($comp);
        $adjs   = array('company' => $comp, 'ledger' => 8, 'amount' => $paid, 'notes' => 'Order Cancelling by ' . getUserName($this->Merged_Vars['memb']), 'adjust_date' => date('Y-m-d'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
        $score = $this->ordermodel->delete_order_details($orid, $comp, $paid, $blnc, $adjs);
        if($score){
            $this->session->set_flashdata('notification', greensignal('Order Cancelled'));
            redirect(__CLASS__. '/purchase');
        } else {
            $this->session->set_flashdata('notification', errormessage('Order Could not be Cancelled'));
            redirect(__CLASS__. '/purchase');
        }
    }
    
    public function finalize(){
        if($this->input->post()){
            //The final step to place an order object
            $total  = $this->input->post('or_total');
            $paid   = $this->input->post('op_amount');
            if($paid > $total){
                $this->session->set_flashdata('notification', errormessage('Paid amount can not be bigger then total amount'));
                redirect(__CLASS__. '/submit/' . $this->input->post('orid'));
            }
            $order_data     = array('or_id' => $this->input->post('orid'), 'or_comp_memo' => $this->input->post('or_comp_memo'), 'or_notes' => $this->input->post('or_notes'), 'or_date' => $this->input->post('or_date'), 'or_time' => date('h:i:s A'), 'or_sub_total' => $this->input->post('or_sub_total'), 'or_discount' => $this->input->post('or_discount'), 'or_total' => $this->input->post('or_total'), 'or_uid' => $this->Merged_Vars['memb'] );
            $items          = $this->input->post('itid');
            $cartoon        = $this->input->post('cartoon');
            $piece          = $this->input->post('piece');
            $quantity       = $this->input->post('quantity');
            $price          = $this->input->post('cart_price');
            $credit_adjust  = array('company' => $this->input->post('op_or_company'), 'ledger' => 1, 'amount' => $this->input->post('op_amount'), 'notes' => "", 'adjust_date' => $this->input->post('or_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            $order_payment  = array('op_orid' => $this->input->post('orid'), 'op_or_company' => $this->input->post('op_or_company'), 'op_vchr_id' => 0, 'op_bank_vchr_id' => 0, 'op_amount' => $this->input->post('op_amount'), 'op_payment_method' => 1, 'op_date' => $this->input->post('or_date'), 'op_post_date' => date('Y-m-d'), 'op_post_time' => date('h:i:s A'), 'op_post_by' => $this->Merged_Vars['memb'] );
            //$balance        = $this->input->post('balance');
            $c_credit       = array('c_id' => $this->input->post('op_or_company'), 'c_credit' => ($this->ordermodel->get_supplier_balance($this->input->post('op_or_company')) - $order_payment['op_amount']));
            $score          = $this->ordermodel->update_order($order_data, $items, $cartoon, $piece, $quantity, $price, $credit_adjust, $c_credit, $order_payment);
            if($score != FALSE){
                $this->session->set_flashdata('notification', greensignal('Order submitted'));
                redirect(__CLASS__. '/details/' . $this->input->post('orid'));
            } else {
                $this->session->set_flashdata('notification', errormessage('Order Could not be submitted now'));
                redirect(__CLASS__. '/submit/' . $this->input->post('orid'));
            }
        } else {
            $this->session->set_flashdata('notification', errormessage('Place an order first'));
            redirect(__CLASS__. '/purchase');
        }
    }
    
    public function details($orid){
        $distributed_cloud_management                   = $this->ordermodel->get_order_info($orid);
        $this->Merged_Vars['info']                      = $distributed_cloud_management;
        if($distributed_cloud_management != FALSE){
            $this->Merged_Vars['printer']               = 'Order Details';
            $this->Merged_Vars['items']                 = $this->ordermodel->get_order_items($orid);
            $this->Merged_Vars['shopinfo']              = $this->settingsmodel->get_shop_info_by_shpid(2);
            $this->loadView(__CLASS__,__FUNCTION__ , $this->Merged_Vars);
        } else {
            $this->session->set_flashdata('There is no order with this data');
            redirect('order/purchase', 'refresh');
        }
    }
    
    public function receive($orid){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "order_receive")){
//            if($this->input->post('status') == 2){
//                $order          = $this->input->post('orid');
//                $items          = $this->input->post('itid');
//                $comps          = $this->input->post('oi_comp_id');
//                $prods          = $this->input->post('oi_pid');
//                $cartoon        = $this->input->post('cartoon');
//                $piece          = $this->input->post('piece');
//                $bonus          = $this->input->post('bonus');
//                $quantity       = $this->input->post('oi_qty');
//                $price          = $this->input->post('cart_price');
//                $entry_date     = $this->input->post('or_rcv_date');
//                $score          = $this->ordermodel->receive_pending_stock($order, $items, $comps, $prods, $cartoon, $piece, $bonus, $quantity, $price, $entry_date, $this->Merged_Vars['memb']);
//                if($score != FALSE){
//                    $this->session->set_flashdata('notification', greensignal('Pending Items Received!!'));
//                    redirect(__CLASS__. '/details/' . $this->input->post('orid'));
//                } else {
//                    $this->session->set_flashdata('notification', errormessage());
//                    redirect(__CLASS__. '/submit/' . $this->input->post('orid'));
//                }
//            }
//            if($this->input->post('status') == 1){
                $total  = $this->input->post('or_total');
                $paid   = $this->input->post('op_amount');
                if($paid > $total){
                    $this->session->set_flashdata('notification', errormessage('Paid amount can not be bigger then total amount'));
                    redirect(__CLASS__. '/submit/' . $this->input->post('orid'));
                }
                $status         = $this->input->post('status');
                $order_data     = array('or_id' => $this->input->post('orid'), 'or_comp_memo' => $this->input->post('or_comp_memo'), 'or_notes' => $this->input->post('or_notes'), 'or_rcv_date' => $this->input->post('or_rcv_date'), 'or_rcv_time' => date('h:i:s A'), 'or_sub_total' => $this->input->post('or_sub_total'), 'or_discount' => $this->input->post('or_discount'), 'or_total' => $this->input->post('or_total'), 'or_status' => 2);
                //$order_data     = array('or_id' => $this->input->post('orid'), 'or_status' => 2);
                $items          = $this->input->post('itid');
                $comps          = $this->input->post('oi_comp_id');
                $prods          = $this->input->post('oi_pid');
                $cartoon        = $this->input->post('cartoon');
                $piece          = $this->input->post('piece');
                $bonus          = $this->input->post('bonus');
                $quantity       = $this->input->post('oi_qty');
                $price          = $this->input->post('cart_price');
                $received       = $this->input->post('received_status');
                $credit_adjust  = array('company' => $this->input->post('op_or_company'), 'ledger' => 1, 'amount' => $this->input->post('or_total'), 'notes' => 'Purchase Adjustment for : <a href="' . site_url('order/details/' . $this->input->post('orid')) . '">' . $this->input->post('orid') . '</a>', 'adjust_date' => $this->input->post('or_rcv_date'), 'posting_date' => date('Y-m-d'),'posting_by' => $this->Merged_Vars['memb']);
                $order_payment  = array('op_orid' => $this->input->post('orid'), 'op_or_company' => $this->input->post('op_or_company'), 'op_vchr_id' => 0, 'op_bank_vchr_id' => 0, 'op_amount' => $this->input->post('or_total'), 'op_payment_method' => 1, 'op_date' => $this->input->post('or_rcv_date'), 'op_post_date' => date('Y-m-d'), 'op_post_time' => date('h:i:s A'), 'op_post_by' => $this->Merged_Vars['memb'] );
                //$balance        = $this->input->post('balance');
                $c_credit       = array('c_id' => $this->input->post('op_or_company'), 'c_credit' => ($this->ordermodel->get_supplier_balance($this->input->post('op_or_company')) - $order_data['or_total']));
                $score          = $this->ordermodel->update_order_stock($order_data, $items, $comps, $prods, $cartoon, $piece, $bonus, $quantity, $price, $credit_adjust, $c_credit, $order_payment, $received, $status);
                if($score != FALSE){
                    $this->session->set_flashdata('notification', greensignal('Order submitted'));
                    redirect(__CLASS__. '/details/' . $this->input->post('orid'));
                } else {
                    $this->session->set_flashdata('notification', errormessage('Order Could not be submitted now'));
                    redirect(__CLASS__. '/submit/' . $this->input->post('orid'));
                }
            //}
        }
        else{
            $this->Merged_Vars['info']                  = $this->ordermodel->get_order_info($orid);
            $this->Merged_Vars['shopinfo']              = $this->settingsmodel->getStoreInformationForOrderController();
            $this->Merged_Vars['items']                 = $this->ordermodel->get_order_items_for_receive($orid);
            $this->Merged_Vars['disorid']               = $orid;
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function order_list(){
        $this->Merged_Vars['sups']                      = $this->suppliermodel->get_supplier_list();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function search_order_list(){
        $FilterData                                     = array('supplier' => "", 'or_comp_memo' => "", 'start' => "", 'finish' => "", 'status' => "");
        if($this->input->post('supplier')) {
            $FilterData['supplier'] = $this->input->post('supplier');
        }
        if($this->input->post('memono')) {
            $FilterData['or_comp_memo'] = $this->input->post('memono');
        }
        if($this->input->post('start')) {
            $FilterData['start'] = $this->input->post('start');
        }
        if($this->input->post('finish')) {
            $FilterData['finish'] = $this->input->post('finish');
        }
        if($this->input->post('status')) {
            $FilterData['status'] = $this->input->post('status');
        }
        $this->Merged_Vars['supplier']                  = $FilterData['supplier'];
        $this->Merged_Vars['start']                     = $FilterData['start'];
        $this->Merged_Vars['finish']                    = $FilterData['finish'];
        $this->Merged_Vars['status']                    = $FilterData['status'];
        $this->Merged_Vars['order_list']                = $this->ordermodel->get_order_list($FilterData);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function payment($order = FALSE){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "purchase_payment")){
            $status = 1;
            $paid = $this->input->post('total_paid') + $this->input->post('op_amount');
            $bill = $this->input->post('total_billed');
            
            if($paid == $bill){
                $status = 1;
            }
            if($paid < $bill) {
                $status = 1;
            }
            if($paid > $bill){
                $this->session->set_flashdata('notification', errormessage('Paid amount can not be more then billed amount!!'));
                redirect(__CLASS__ . '/payment?order=' . $this->input->post('op_orid'), 'refresh');
            }
            
            $bank_voucher   = NULL;
            $bank_account   = NULL;
            $order_data     = array('or_id' => $this->input->post('op_orid'), 'or_status' => $status);
            $order_payment  = array( 'op_orid' => $this->input->post('op_orid'), 'op_amount' => $this->input->post('op_amount'), 'op_payment_method' => $this->input->post('payment_method'), 'op_date' => $this->input->post('op_date'), 'op_post_date' => date("Y-m-d"), 'op_post_time' => date("h:i:s A"), 'op_post_by' => $this->Merged_Vars['memb'] );
            $voucher_data   = array( 'v_head' => 2, 'v_type' => 2, 'v_amount' => $order_payment['op_amount'], 'v_note' => 'Purchase Order Payment', 'v_date' => $order_payment['op_date'], 'v_posting_date' => $order_payment['op_post_date'], 'v_posting_by' => $order_payment['op_post_by'] );
            if($order_payment['op_payment_method'] == 2 && $this->input->post('bank_accounts')){
                $balance = $this->bankmodel->get_account_balance($this->input->post('bank_accounts'));
                if($balance < $order_payment['op_amount']){
                    $this->session->set_flashdata('notification', errormessage('You do not have sufficient balance in the chosen account.'));
                    redirect(__CLASS__ . '/payment?order=' . $order_payment['op_orid'], 'refresh');
                } else {
                    $balance = $balance - $order_payment['op_amount'];
                    $bank_voucher = array('bank_account_tble_id' => $this->input->post('bank_accounts'), 'voucher_tble_id' => "", 'voucher_amount' => $order_payment['op_amount'], 'voucher_balance' => $balance, 'voucher_notes' => 'Purchase Order Payment', 'voucher_head' => 3, 'voucher_type' => 2, 'voucher_date' => $order_payment['op_date'], 'posting_date' => $order_payment['op_post_date'], 'posting_by' => $order_payment['op_post_by'], 'voucher_status' => 1 );
                    $bank_account = array('tble_id' => $this->input->post('bank_accounts'), 'account_balance' => ($balance));
                }
            }
            $score = $this->ordermodel->order_payment($order_data, $order_payment, $voucher_data, $bank_voucher, $bank_account);
            if($score) {
                $this->session->set_flashdata('notification', greensignal('Order Payment Made!!'));
                redirect(__CLASS__ . '/orderlist', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage());
                redirect(__CLASS__ . '/payment?order=' . $order_payment['op_orid'], 'refresh');
            }
        } else {
            if($order == FALSE){
                redirect('order/orderlist', 'refresh');
            }
            $this->Merged_Vars['order_info']                = $this->ordermodel->get_order_information($order);
            $this->Merged_Vars['order_item']                = $this->ordermodel->get_order_items_for_payment($order);
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function adjust($orid = FALSE, $amount = FALSE, $suppler = FALSE){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "purchase_payment")){
            $adjusted = ($this->input->post('order_payment_value') - $this->input->post('order_payment_adjust'));
            $order_payment_update   = array('op_id' => $this->input->post('order_payment_id'), 'op_amount' => $adjusted );
            $voucher_update         = array('tble_id' => $this->input->post('order_payment_voucher'), 'v_amount' => $adjusted);
            $order_payment          = array('op_orid' => $this->input->post('new_order_id'), 'op_or_company' => $this->input->post('new_comp_id'), 'op_vchr_id' => 0, 'op_bank_vchr_id' => 0, 'op_amount' => $this->input->post('order_payment_adjust'), 'op_payment_method' => $this->input->post('payment_method'), 'op_date' => $this->input->post('op_date'), 'op_post_date' => date('Y-m-d'), 'op_post_time' => date('h:i:s A'), 'op_post_by' => $this->Merged_Vars['memb']);
            $voucher_data           = array('v_head' => 2, 'v_type' => 2, 'v_amount' => $this->input->post('order_payment_adjust'), 'v_note' => 'Payment adjusted to order: ' . $this->input->post('new_order_id') . ' From: ' . $this->input->post('old_order_id'), 'v_date' => $this->input->post('op_date'), 'v_posting_date' => date('Y-m-d'), 'v_posting_by' => $this->Merged_Vars['memb']);
            
            $score = $this->ordermodel->set_payment_adjustment($order_payment_update, $voucher_update, $order_payment, $voucher_data);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Payment adjusted to order'));
                redirect('order/details/' . $this->input->post('new_order_id'), 'refresh');
            }
            else {
                $this->session->set_flashdata('notification', errormessage('Could not process data now'));
                redirect('order/orderlist', 'refresh');
            }
        } else {
            $this->Merged_Vars['info']                      = $this->ordermodel->get_order_info($orid);
            $this->Merged_Vars['shopinfo']                  = $this->settingsmodel->getStoreInformationForOrderController();
            $this->Merged_Vars['items']                     = $this->ordermodel->get_order_items($orid);
            $this->Merged_Vars['payments']                  = $this->ordermodel->get_order_payments($orid);
            $this->Merged_Vars['disorid']                   = $orid;
            $this->Merged_Vars['amount']                    = $amount;

            $FilterData                                     = array('supplier' => $suppler, 'or_comp_memo' => "", 'start' => "", 'finish' => "", 'status' => "");
            $this->Merged_Vars['order_list']                = $this->ordermodel->get_order_list($FilterData);

            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function stock_position(){
        $this->Merged_Vars['printer']                   = 'Product Stock Position ';
        $this->Merged_Vars['products']                  = $this->productsmodel->get_products_list();
        $this->Merged_Vars['sups']                      = $this->suppliermodel->get_supplier_list();
        $this->Merged_Vars['groups']                    = $this->productsmodel->pro_group();
        $this->Merged_Vars['source']                    = $this->settingsmodel->get_branch_list();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function filter_pro_stock(){
        $FilterData                         = array('p_sku' => '', 'p_cid' => '', 'branch' => '');
        if($this->input->post('sku')){
            $FilterData['p_sku']    = $this->input->post('sku');
        }
        if($this->input->post('cid')){
            $FilterData['p_cid']    = $this->input->post('cid');
        }
        if($this->input->post('brn')){
            $FilterData['branch']   = $this->input->post('brn');
        }
        $this->Merged_Vars['printer']       = 'Product List ';
        $this->Merged_Vars['products']      = $this->ordermodel->filter_products_stock($FilterData);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function stock_transaction(){
        $this->Merged_Vars['source']                    = $this->settingsmodel->get_branch_list();
        $this->Merged_Vars['sups']                      = $this->suppliermodel->get_supplier_list();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function filter_stock_transaction(){
        $FilterData                                     = array('p_cid' => '', 'start' => '', 'finish' => '', 'p_sku' => '', 'opening' => '');
        if($this->input->post('p_cid')){
            $FilterData['p_cid'] = $this->input->post('p_cid');
        }
        if($this->input->post('start')){
            $FilterData['start'] = $this->input->post('start');
        }
        $FilterData['opening']  = date('Y-m-d', strtotime('-1 day', strtotime($FilterData['start'])));
        if($this->input->post('finish')){
            $FilterData['finish'] = $this->input->post('finish');
        }
        if($this->input->post('p_sku')){
            $FilterData['p_sku'] = $this->input->post('p_sku');
        }
        $this->Merged_Vars['printer']                   = "Product Stock Transaction";
        $this->Merged_Vars['dateline']                  = "From: " . $FilterData['start'] . ' To: ' . $FilterData['finish'];
        $this->Merged_Vars['stock']                     = $this->ordermodel->get_stock_transaction($FilterData);
        $this->Merged_Vars['start']                     = $FilterData['start'];
        $this->Merged_Vars['finish']                    = $FilterData['finish'];
        $this->Merged_Vars['branch']                    = $FilterData['p_sku'];
        //$this->Merged_Vars['records']                   = $this->Merged_Vars['stock']->num_rows() . " Records Found";
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function stock_transfer(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "transfer")){
            $source                                     = $this->input->post('source');
            $products                                   = $this->input->post('p_id');
            $quantity                                   = $this->input->post('qty');
            $destination                                = $this->input->post('destination');
            $p_stock                                    = $this->input->post('p_stok');
            $score = $this->ordermodel->transfer_stock($source, $products, $quantity, $p_stock, $destination, $this->Merged_Vars['memb']);
            if($score) {
                $this->session->set_flashdata('notification', greensignal('Stock Transferred!!'));
                redirect(__CLASS__ . '/transfer', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage('Please try again later!!'));
                redirect(__CLASS__ . '/transfer', 'refresh');
            }
        } else {
            $this->Merged_Vars['sups']                  = $this->suppliermodel->get_supplier_list();
            $this->Merged_Vars['source']                = $this->settingsmodel->get_source_list($this->Merged_Vars['b_id']);
            $this->Merged_Vars['destin']                = $this->settingsmodel->get_source_list($this->Merged_Vars['b_id']);
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function pro_stock_transfer(){
        $s_id                                           = $this->input->post('s_id');
        $b_id                                           = $this->input->post('b_id');
        $this->Merged_Vars['pro_list']                  = $this->ordermodel->get_pro_stock_transfer($b_id, $s_id);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function stock_transfer_report(){
        $this->Merged_Vars['branch']                    = $this->settingsmodel->get_branch_list();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function get_stock_transfer_report(){
        $Filter_Data                                    = array('from' => "", 'to' => "", 'source' => 0, 'destination' => 0);
        if($this->input->post('from')){
            $Filter_Data['from']                        = $this->input->post('from');
        }
        if($this->input->post('to')){
            $Filter_Data['to']                          = $this->input->post('to');
        }
        if($this->input->post('source')){
            $Filter_Data['source']                      = $this->input->post('source');
        }
        if($this->input->post('destination')){
            $Filter_Data['destination']                 = $this->input->post('destination');
        }
        //$this->ordermodel->get_stock_transfer_report($Filter_Data);
        $this->Merged_Vars['transfer_report']           = $this->ordermodel->get_stock_transfer_report($Filter_Data);
        $this->Merged_Vars['filter_data']               = $Filter_Data;
        $this->load->view(__CLASS__. '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function return_batch_list(){
        $this->Merged_Vars['branch']                    = $this->settingsmodel->get_branch_list();
        $this->Merged_Vars['sups']                      = $this->suppliermodel->get_supplier_list();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function search_return_batch(){
        $Filter_Data                                    = array('batch_no' => "", 'supplier_id' => "", 'status' => "", 'branch_id' => "");
        if($this->input->post('batchno')){
            $Filter_Data['batch_no']                    = $this->input->post('batchno');
        }
        if($this->input->post('supplier')){
            $Filter_Data['supplier_id']                 = $this->input->post('supplier');
        }
        if($this->input->post('b_status')){
            $Filter_Data['status']                      = $this->input->post('b_status');
        }
        if($this->input->post('branch')){
            $Filter_Data['branch_id']                   = $this->input->post('branch');
        }
        
        $this->Merged_Vars['return_list']               = $this->ordermodel->get_return_batch_list($Filter_Data);
        $this->Merged_Vars['method']                    = $this->accountsmodel->get_payment_method();
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function damage_adjust(){
        if($this->input->post('trigger')){
            $company_adjust                             = array('company' => $this->input->post('company'), 'ledger' => 6, 'amount' => $this->input->post('amount'),
                    'notes' => $this->input->post('notes'), 'adjust_date' => $this->input->post('adjust_date'), 'posting_date' => date('Y-m-d'), 'posting_by' => $this->Merged_Vars['memb']);
            //$this->ordermodel->adjust_damage_credit($company_adjust, $this->input->post('batch'));
            $score = $this->ordermodel->adjust_damage_credit($company_adjust, $this->input->post('batch'));
            if($score){
                $this->session->set_flashdata('notification', greensignal('Damage Adjusted to Supplier'));
                redirect('order/batchlist', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage());
                redirect('order/batchlist', 'refresh');
            }
        } else {
            $this->Merged_Vars['company']               = $this->input->get('company');
            $this->Merged_Vars['batch']                 = $this->input->get('batch');
            $this->Merged_Vars['amount']                = $this->input->get('amount');
            $this->Merged_Vars['method']                = $this->accountsmodel->get_payment_method();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function new_return_batch(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "new_damage_batch")){
            $this->form_validation->set_rules('batch_no', 'Batch No.', 'required|is_unique[damage_batch.batch_no]');
            if($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('notification', errormessage(validation_errors()));
                redirect('order/newbatch');
            } else {
                $batch_data = array('batch_no' => $this->input->post('batch_no'), 'branch_id' => $this->Merged_Vars['b_id'], 'supplier_id' => $this->input->post('supplier_id'), 'store_date' => $this->input->post('store_date'), 'submission_date' => NULL, 'received_date' => NULL, 'posting_date' => date('Y-m-d'), 'posting_time' => date('h:i:s A'), 'posting_by' => $this->Merged_Vars['memb'], 'status' => 1);
                $score = $this->ordermodel->create_new_return_batch($batch_data);
                if($score) {
                    $this->session->set_flashdata('notification', greensignal('New Batch created!!'));
                    redirect(__CLASS__ . '/batchlist', 'refresh');
                } else {
                    $this->session->set_flashdata('notification', errormessage('Please try again later!!'));
                    redirect(__CLASS__ . '/newbatch', 'refresh');
                }
            }
        } else {
            $this->Merged_Vars['sups']                      = $this->suppliermodel->get_supplier_list();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function add_return_item($return = FALSE, $company = FALSE, $branch = FALSE){
        $this->Merged_Vars['return']                    = $return;
        $this->Merged_Vars['sups']                      = $this->suppliermodel->get_supplier_list();
        $this->Merged_Vars['destin']                    = $this->settingsmodel->get_branch_list();
        $this->Merged_Vars['filter_company']            = $company;
        $this->Merged_Vars['filter_branch']             = $branch;
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function return_pro_search(){
        $fileter_options                                = array('p_cid' => "", 'branch_id' => "");
        if($this->input->post('sup')){
            $fileter_options['p_cid']                   = $this->input->post('sup');
        }
        if($this->input->post('branchs')){
            $fileter_options['branch_id']               = $this->input->post('branchs');
        }
        $this->Merged_Vars['prods']                     = $this->ordermodel->get_product_list_by_supplier($fileter_options);
        $this->load->View(__CLASS__.'/'.__FUNCTION__, $this->Merged_Vars);
    }
    
    public function return_items_entry(){
        $product_id         = $this->input->post('product_id');
        $supplier_id        = $this->input->post('supplier_id');
        $quantity           = $this->input->post('quantity');
        $rates              = $this->input->post('rates');
        $notes              = $this->input->post('notes');
        $branch_id          = 1;
        $current_stock      = $this->input->post('stock');
        if($this->input->post('destination')){
            $branch_id      = $this->input->post('destination');
        }
        if(count($product_id) < 1){
            $this->session->set_flashdata('notification', errormessage('Please select minimum one product!!'));
            redirect(__CLASS__ . '/returnit/' . $this->input->post('return_id'), 'refresh');
        }

        $score = $this->ordermodel->enter_new_return_item($this->input->post('return_id'), $product_id, $supplier_id, $quantity, $rates, $notes, $branch_id, $current_stock);
        if($score) {
            $this->session->set_flashdata('notification', greensignal('New Batch created!!'));
            redirect(__CLASS__ . '/batchlist', 'refresh');
        } else {
            $this->session->set_flashdata('notification', errormessage('Please try again later!!'));
            redirect(__CLASS__ . '/returnit/' . $this->input->post('return_id'), 'refresh');
        }
    }
    
    public function return_details($return){
        $this->Merged_Vars['printer']                           = "Return Batch Details";
        $this->Merged_Vars['return_info']                       = $this->ordermodel->return_details($return);
        $this->Merged_Vars['return_itms']                       = $this->ordermodel->return_items($return);
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function delete_return_batch(){
        $score = $this->ordermodel->delete_return_batch($this->input->get('batch'));
        if($score) {
            $this->session->set_flashdata('notification', greensignal('Batch Deleted!!'));
            redirect(__CLASS__ . '/batchlist', 'refresh');
        } else {
            $this->session->set_flashdata('notification', errormessage('Please try again later!!'));
            redirect(__CLASS__ . '/returnit/' . $this->input->get('batch'), 'refresh');
        }
    }
    
    public function add_return_item_to_stock(){
        $Damage_Item = array('tble_id' => $this->input->post('table'), 'received' => 2);
        $product_stock = array('product_id' => $this->input->post('product'), 'branch_id' => 1, 'stock' => $this->input->post('stock'));
        $score = $this->ordermodel->return_to_stock($Damage_Item, $product_stock);
        if($score){
            $this->session->set_flashdata('notification', greensignal('Product received & stock updated to central depot'));
            $this->Merged_Vars['return_info']                       = $this->ordermodel->return_details($this->input->post('return'));
            $this->Merged_Vars['return_itms']                       = $this->ordermodel->return_items($this->input->post('return'));
            $this->load->View(__CLASS__.'/'.__FUNCTION__, $this->Merged_Vars);
        } else {
            $this->session->set_flashdata('notification', errormessage('Please try again later!!'));
            $this->Merged_Vars['return_info']                       = $this->ordermodel->return_details($this->input->post('return'));
            $this->Merged_Vars['return_itms']                       = $this->ordermodel->return_items($this->input->post('return'));
            $this->load->View(__CLASS__.'/'.__FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function batch_status_update(){
        $batch_info         = array('tble_id' => $this->input->get('batch'), 'status' => $this->input->get('status'));
        $score              = $this->ordermodel->update_return_batch_status($batch_info);
        if($score) {
            $this->session->set_flashdata('notification', greensignal('Batch Marked as Submitted!!'));
            redirect(__CLASS__ . '/batchlist', 'refresh');
        } else {
            $this->session->set_flashdata('notification', errormessage('Please try again later!!'));
            redirect(__CLASS__ . '/returnit/' . $this->input->get('batch'), 'refresh');
        }
    }
    
    public function emergency_stock_entry(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "emergency")){
            $this->form_validation->set_rules('branch_id', 'Branch', 'required');
            if($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('notification', errormessage(validation_errors()));
                redirect(__CLASS__ . '/emergency', 'refresh');
            } else {
                $supplier   = $this->input->post('p_cid');
                $branch_id  = $this->input->post('branch_id');
                $product_id = $this->input->post('product_id');
                $cartoon    = $this->input->post('cartoon');
                $piece      = $this->input->post('piece');
                $total      = $this->input->post('total');
                
                $score              = $this->ordermodel->update_emergency_stock($supplier, $branch_id, $product_id, $cartoon, $piece, $total, $this->Merged_Vars['memb']);
                if($score) {
                    $this->session->set_flashdata('notification', greensignal('Product Opening Balance Update!!'));
                    redirect(__CLASS__ . '/emergency', 'refresh');
                } else {
                    $this->session->set_flashdata('notification', errormessage('Please try again later!!'));
                    redirect(__CLASS__ . '/emergency', 'refresh');
                }
            }
        } else {
            $this->Merged_Vars['sups']                      = $this->suppliermodel->get_supplier_list();
            $this->Merged_Vars['destin']                    = $this->settingsmodel->get_branch_list();
            $this->loadView(__CLASS__, __FUNCTION__,  $this->Merged_Vars);
        }
    }
    
    public function emergency_stocksearch(){
        $fileter_options                                = array('p_cid' => "", 'branch_id' => "");
        if($this->input->post('sup')){
            $fileter_options['p_cid']                   = $this->input->post('sup');
        }
        $this->Merged_Vars['prods']                     = $this->ordermodel->get_product_list_by_supplier($fileter_options);
        $this->load->View(__CLASS__.'/'.__FUNCTION__, $this->Merged_Vars);
    }
    
    public function daily_stock_closing(){
        $score = $this->ordermodel->daily_stock_closing($this->Merged_Vars['memb'], date('Y-m-d'), $this->Merged_Vars['b_id']);
        if($score) {
            $this->session->set_flashdata('notification', greensignal('Stock Closing Done.'));
            redirect(__CLASS__ . '/position', 'refresh');
        } else {
            $this->session->set_flashdata('notification', errormessage('Please try again later!!'));
            redirect(__CLASS__ . '/position', 'refresh');
        }
    }
    
    public function filter_daily_closing(){
        $FilterData                         = array('branch' => '', 'cldate' => '', 'supplier' => '');
        if($this->input->post('brn')){
            $FilterData['branch']   = $this->input->post('brn');
        }
        if($this->input->post('cldate')){
            $FilterData['cldate']   = $this->input->post('cldate');
        }
        if($this->input->post('supplier')){
            $FilterData['supplier'] = $this->input->post('supplier');
        }
        //print_r($FilterData);
        $this->Merged_Vars['printer']       = 'Stock CLosing: ' . $FilterData['cldate'];
        $this->Merged_Vars['products']      = $this->ordermodel->filter_stock_closing($FilterData);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function mark_as_pending_and_complete(){
        $status_loc = intval($this->input->get('current'));
        $or_id_loc = intval($this->input->get('pending'));
        if($status_loc == 0){
            $this->db->where('order.or_id', $or_id_loc);
            $this->db->update('order', array('or_pending' => 1));
            $this->session->set_flashdata('notification', greensignal(''));
            redirect(__CLASS__. '/details/' . $or_id_loc);
        }
        else if($status_loc == 1){
            $this->db->where('order.or_id', $or_id_loc);
            $this->db->update('order', array('or_pending' => 0));
            $this->session->set_flashdata('notification', greensignal(''));
            redirect(__CLASS__. '/details/' . $or_id_loc);
        }
        else {
            $this->session->set_flashdata('notification', errormessage('Please try again later!!'));
            redirect('order/orderlist', 'refresh');
        }
    }
}
?>
