<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class salesmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function add_temp_cart_item($temp_item_data){
        if($this->db->insert('invoice_item_temp', $temp_item_data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function remove_from_cart($cart_id){
        $this->db->where('invoice_item_temp.tble_id', $cart_id);
        if($this->db->delete('invoice_item_temp')){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function product_stock_remove($pro_id, $brnch_id){
        $this->db->select('product_stock.stock AS stock');
        $this->db->from('product_stock');
        $this->db->where('product_stock.product_id', $pro_id);
        $this->db->where('product_stock.branch_id', $brnch_id);
        $stock = $this->db->get();
        if($stock->num_rows() == 1){
            $stock = $stock->row();
            return $stock->stock;
        } else {
            return 0;
        }
    }
    
    public function product_box_quantity($pro_id){
        $this->db->select('products_name.p_box_qty AS p_box_qty');
        $this->db->from('products_name');
        $this->db->where('products_name.p_id', $pro_id);
        $stock = $this->db->get();
        if($stock->num_rows() == 1){
            $stock = $stock->row();
            return $stock->p_box_qty;
        } else {
            return 0;
        }
    }

    public function get_cart_items($memb, $b_id, $customer, $date){
        $this->db->select('invoice_item_temp.*, products_name.p_name, company_info.c_name, products_group.mg_name');
        $this->db->from('invoice_item_temp');
        $this->db->where('invoice_item_temp.post_by', $memb);
        $this->db->where('invoice_item_temp.branch_id', $b_id);
        $this->db->where('invoice_item_temp.client_id', $customer);
        $this->db->where('invoice_item_temp.post_date', $date);
        $this->db->join('products_name', 'products_name.p_id = invoice_item_temp.product_id', 'LEFT');
        $this->db->join('company_info', 'company_info.c_id = invoice_item_temp.company_id', 'LEFT');
        $this->db->join('products_group', 'products_group.mg_id = invoice_item_temp.group_id', 'LEFT');
        $items = $this->db->get();
        if($items->num_rows() > 0){
            return $items;
        } else {
            return FALSE;
        }
    }
    
    public function get_invoice_items($invoice){
        $this->db->select('invoice_item.tble_id AS tble_id,
            invoice_item.invoice_id AS inv_id,
            invoice_item.branch_id,
            invoice_item.product_id AS prodid, 
            invoice_item.client_id, 
            invoice_item.sale_date, 
            invoice_item.company_id, 
            invoice_item.group_id, 
            invoice_item.cartoon, 
            invoice_item.piece, 
            invoice_item.bonus, 
            invoice_item.quantity, 
            invoice_item.u_rate, 
            invoice_item.price, 
            invoice_item.post_date, 
            invoice_item.post_time, 
            invoice_item.post_by, products_name.p_name, company_info.c_name, products_group.mg_name,
            (SELECT SUM(' . $this->db->dbprefix . 'invoice_return.return_qty) FROM ' . $this->db->dbprefix . 'invoice_return WHERE ' . $this->db->dbprefix . 'invoice_return.invoice_id=inv_id AND ' . $this->db->dbprefix . 'invoice_return.product_id=prodid) AS return_item');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.invoice_id', $invoice);
        $this->db->join('products_name', 'products_name.p_id = invoice_item.product_id', 'LEFT');
        $this->db->join('company_info', 'company_info.c_id = invoice_item.company_id', 'LEFT');
        $this->db->join('products_group', 'products_group.mg_id = invoice_item.group_id', 'LEFT');
        $items = $this->db->get();
        if($items->num_rows() > 0){
            return $items;
        } else {
            return FALSE;
        }
    }
    
    public function get_invoice_items_for_update($invoice, $b_id){
        $this->db->select('
                invoice_item.tble_id AS itm_id,
                invoice_item.invoice_id,
                invoice_item.branch_id,
                invoice_item.client_id,
                invoice_item.sale_date,
                invoice_item.company_id,
                invoice_item.product_id,
                invoice_item.group_id,
                invoice_item.cartoon,
                invoice_item.piece,
                invoice_item.bonus,
                invoice_item.quantity,
                invoice_item.u_rate,
                invoice_item.price,
                products_name.p_name,
                products_name.p_u_price,
                products_name.p_box_qty,
                products_name.p_box_bonus,
                company_info.c_name,
                products_group.mg_name,
                product_stock.stock,
                (SELECT SUM(' . $this->db->dbprefix . 'invoice_return.return_qty) FROM ' . $this->db->dbprefix . 'invoice_return WHERE ' . $this->db->dbprefix . 'invoice_return.invoice_id=itm_id) AS return_qty');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.invoice_id', $invoice);
        $this->db->where('product_stock.branch_id', $b_id);
        $this->db->join('product_stock', 'product_stock.product_id = invoice_item.product_id', 'LEFT');
        $this->db->join('products_name', 'products_name.p_id = invoice_item.product_id', 'LEFT');
        $this->db->join('company_info', 'company_info.c_id = invoice_item.company_id', 'LEFT');
        $this->db->join('products_group', 'products_group.mg_id = invoice_item.group_id', 'LEFT');
        $items = $this->db->get();
        if($items->num_rows() > 0){
            return $items;
        } else {
            return FALSE;
        }
    }
    
    public function delete_cart_items($memb, $b_id, $customer, $date){
        $this->db->where('invoice_item_temp.post_by', $memb);
        $this->db->where('invoice_item_temp.branch_id', $b_id);
        $this->db->where('invoice_item_temp.client_id', $customer);
        $this->db->where('invoice_item_temp.post_date', $date);
        $this->db->delete('invoice_item_temp');
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
    
    public function get_product_stock($pid, $bid){
        $this->db->select('product_stock.stock');
        $this->db->from('product_stock');
        $this->db->where('product_stock.product_id', $pid);
        $this->db->where('product_stock.branch_id', $bid);
        $stock = $this->db->get();
        if($stock->num_rows() == 1){
            $row = $stock->row();
            return $row->stock;
        } else {
            return FALSE;
        }
    }
    
    public function create_new_invoice($invoice_data, $tble_id, $company_id, $product_id, $group_id, $cartoon, $piece, $bonus, $quantity, $u_rate, $price, $voucher, $payment_tble, $client_ledger, $client_table){
        $this->db->trans_begin();
        $this->db->insert('invoice', $invoice_data);
        $invoice    = $this->db->insert_id();
        $client_ledger['invoice_id'] = $invoice;
        $client_ledger['notes'] = 'Sales Invoice No: ' . $invoice;
        $this->db->insert('client_ledger', $client_ledger);
        $this->db->where('client.cl_id', $client_table['cl_id']);
        $this->db->update('client', $client_table);
        
        for($i = 0; $i < count($tble_id); $i++){
            $current_stock      = $this->get_product_stock($product_id[$i], $invoice_data['branch_id']);
            $deducted_stock     = ($current_stock - $quantity[$i]);
            $stock_matter       = array('stock' => $deducted_stock);
            $this->db->where('product_stock.product_id', $product_id[$i]);
            $this->db->where('product_stock.branch_id', $invoice_data['branch_id']);
            $this->db->update('product_stock', $stock_matter);
            $this->db->insert('invoice_item', array('invoice_id' => $invoice, 'branch_id' => $invoice_data['branch_id'], 'client_id' => $invoice_data['client_id'], 'sale_date' => $invoice_data['sale_date'], 'company_id' => $company_id[$i], 'product_id' => $product_id[$i], 'group_id' => $group_id[$i], 'cartoon' => $cartoon[$i], 'piece' => $piece[$i], 'bonus' => $bonus[$i], 'quantity' => $quantity[$i], 'u_rate' => $u_rate[$i], 'price' => $price[$i], 'post_date' => date('Y-m-d'), 'post_time' => date('h:i:s A'), 'post_by' => $invoice_data['posting_by']));
            $this->db->where('invoice_item_temp.tble_id', $tble_id[$i]);
            $this->db->delete('invoice_item_temp');
        }
        if($voucher['v_amount'] > 0){
            $voucher['v_note']      = 'Sales Collection for Invoice: ' . $invoice;
            $this->db->insert('voucher', $voucher);
            $voucher_id     = $this->db->insert_id();
            
            $client_ledger['ledger_id'] = 4;
            $client_ledger['ledger_type'] = 2;
            $client_ledger['amount'] = $payment_tble['amount'];
            $client_ledger['invoice_id'] = $invoice;
            $client_ledger['notes'] = 'Invoice Payment : ' . $invoice;
            $this->db->insert('client_ledger', $client_ledger);
            $cl_ledgr = $this->db->insert_id();
            
            $payment_tble['invoice_id'] = $invoice;
            $payment_tble['voucher_id'] = $voucher_id;
            $payment_tble['client_voucher'] = $cl_ledgr;
            $this->db->insert('invoice_payment', $payment_tble);
        }
        
        $customer_balance   = array('cl_id' => $client_table['cl_id'], 'cl_balance' => ($this->get_customer_balance($client_table['cl_id']) - $payment_tble['amount']));
        $this->db->where('client.cl_id', $customer_balance['cl_id']);
        $this->db->update('client', $customer_balance);
        
        $current_balance = $this->get_branch_balance($invoice_data['branch_id']);
        $balance         = $current_balance + $payment_tble['amount'];
        $this->db->where('store_cash_in_hand.branch_id', $invoice_data['branch_id']);
        $this->db->update('store_cash_in_hand', array('balance' => $balance));
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function get_customer_balance($clid){
        $this->db->select('client.cl_balance');
        $this->db->from('client');
        $this->db->where('client.cl_id', $clid);
        $Phone = $this->db->get();
        if($Phone->num_rows() == 1){
            foreach ($Phone->result() as $Phone){
                return $Phone->cl_balance;
            }
        }
        else{
            return 0;
        }
    }
    
    public function update_existing_invoice($invoice_table, $client_table, $cl_inv_ledger, $cl_sec_ledger, $branc, $invid, $cl_id, $item_id, $product_id, $group_id, $cartoon, $cartoon_new, $piece, $piece_new, $bonus, $bonus_new, $quantity, $quantity_new, $u_rate, $price, $price_new, $company_id, $stock, $payment_tble, $invoice_update, $voucher, $cash_in_Hand, $user){
        $this->db->trans_begin();
        $this->db->where('invoice.tble_id', $invoice_table['tble_id']);
        $this->db->update('invoice', $invoice_table);
        
        $this->db->where('client.cl_id', $client_table['cl_id']);
        $this->db->update('client', $client_table);
        
        for($i = 0; $i < count($product_id); $i++){
            $this->db->where('product_stock.product_id', $product_id[$i]);
            $this->db->where('product_stock.branch_id', $branc);
            $stock_array  = array('stock' => ($stock[$i]));
            $this->db->update('product_stock', $stock_array);
            
            $return     = array(
                'item_id' => $item_id[$i],
                'invoice_id' => $invoice_table['tble_id'],
                'branch_id' => $branc,
                'client_id' => $client_table['cl_id'],
                'return_date' => date('Y-m-d'),
                'company_id' => $company_id[$i],
                'product_id' => $product_id[$i],
                'group_id' => $group_id[$i],
                'return_qty' => $quantity[$i] - $quantity_new[$i],
                'price' => $price[$i] - $price_new[$i],
                'post_date' => date('Y-m-d'),
                'post_time' => date('H:i:s'),
                'post_by' => $user
            );
            $this->db->insert('invoice_return', $return);
            
            $invoice_item = array(
                'cartoon' => $cartoon_new[$i],
                'piece' => $piece_new[$i],
                'bonus' => $bonus_new[$i],
                'quantity' => $quantity_new[$i],
                'u_rate' => $u_rate[$i],
                'price' => $price_new[$i]
            );
            $this->db->where('invoice_item.tble_id', $item_id[$i]);
            $this->db->update('invoice_item', $invoice_item);
        }
        $this->db->insert('client_ledger', $cl_sec_ledger);
        if($voucher['v_amount'] > 0) {
            $this->db->insert('client_ledger', $cl_inv_ledger);
            $cl_ledgr = $this->db->insert_id();
            
            $this->db->insert('voucher', $voucher);
            $v_id   = $this->db->insert_id();
            $payment_tble['voucher_id'] = $v_id;
            
            $payment_tble['client_voucher'] = $cl_ledgr;
            $this->db->insert('invoice_payment', $payment_tble);
            
        }      
        
        
        $this->db->insert('invoice_update', $invoice_update);
        
        $this->db->where('store_cash_in_hand.branch_id', $cash_in_Hand['branch_id']);
        $this->db->update('store_cash_in_hand', $cash_in_Hand);
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_invoice_list($filter_data){
        $this->db->select('invoice.tble_id AS inv_id, invoice.client_id, invoice.inv_route AS Market, invoice.inv_route AS Market, invoice.status, invoice.sale_date, invoice.total_bill AS Billed,
            client.cl_name AS Customer, branch.b_name AS Branch, invoice.branch_id,
            (SELECT SUM(' . $this->db->dbprefix . 'invoice_payment.amount) from ' . $this->db->dbprefix . 'invoice_payment WHERE ' . $this->db->dbprefix . 'invoice_payment.invoice_id=inv_id) AS Paid');
        $this->db->from('invoice');
        if(strlen($filter_data['starting']) == 10){
            $this->db->where('invoice.sale_date >=', $filter_data['starting']);
        }
        if(strlen($filter_data['ending']) == 10){
            $this->db->where('invoice.sale_date <=', $filter_data['ending']);
        }
        if(strlen($filter_data['client_id']) > 0){
            $this->db->where('invoice.client_id', $filter_data['client_id']);
        }
        $this->db->join('client', 'client.cl_id = invoice.client_id', 'LEFT');
        $this->db->join('branch', 'branch.tble_id = invoice.branch_id', 'LEFT');
        $this->db->order_by('invoice.sale_date', 'DESC');
        $this->db->order_by('invoice.tble_id', 'DESC');
        $invoices = $this->db->get(); //echo $this->db->last_query();
        if($invoices->num_rows() > 0){
            return $invoices;
        } else {
            return FALSE;
        }
    }
    
    public function get_due_invoice_list($filter_data){
        $this->db->select('invoice.tble_id AS inv_id, invoice.client_id, invoice.status, invoice.sale_date, invoice.total_bill AS Billed,
            client.cl_name AS Customer, branch.b_name AS Branch, invoice.branch_id,
            (SELECT SUM(' . $this->db->dbprefix . 'invoice_payment.amount) from ' . $this->db->dbprefix . 'invoice_payment WHERE ' . $this->db->dbprefix . 'invoice_payment.invoice_id=inv_id) AS Paid');
        $this->db->from('invoice');
        $this->db->where('invoice.status', $filter_data);
        $this->db->join('client', 'client.cl_id = invoice.client_id', 'LEFT');
        $this->db->join('branch', 'branch.tble_id = invoice.branch_id', 'LEFT');
        $this->db->order_by('invoice.sale_date', 'DESC');
        $this->db->order_by('invoice.tble_id', 'DESC');
        $invoices = $this->db->get();
        if($invoices->num_rows() > 0){
            return $invoices;
        } else {
            return FALSE;
        }
    }
    
    public function get_invoice_list_by_tble_id($tble_id){
        $this->db->select('invoice.tble_id AS inv_id,  invoice.client_id, invoice.inv_route AS Market, invoice.branch_id, invoice.status, invoice.sale_date, invoice.total_bill AS Billed, client.cl_name AS Customer, branch.b_name AS Branch,
            (SELECT SUM(' . $this->db->dbprefix . 'invoice_payment.amount) from ' . $this->db->dbprefix . 'invoice_payment WHERE invoice_id=inv_id) AS Paid');
        $this->db->from('invoice');
        $this->db->where('invoice.tble_id', $tble_id);
        $this->db->join('client', 'client.cl_id = invoice.client_id', 'LEFT');
        $this->db->join('branch', 'branch.tble_id = invoice.branch_id', 'LEFT');
        $this->db->order_by('invoice.sale_date', 'DESC');
        $this->db->order_by('invoice.tble_id', 'DESC');
        $invoices = $this->db->get();
        if($invoices->num_rows() > 0){
            return $invoices;
        } else {
            return FALSE;
        }
    }
    
    public function get_invoice_details($invoice){
        $this->db->select('
            invoice.tble_id AS inv_id,
            invoice.inv_route AS inv_route,
            invoice.client_id,
            invoice.branch_id,
            branch.b_name AS Branch,
            invoice.total_item,
            invoice.sale_date,
            invoice.sub_total,
            invoice.discount,
            invoice.total_bill,
            invoice.status,
            (SELECT SUM(' . $this->db->dbprefix . 'invoice_payment.amount) from ' . $this->db->dbprefix . 'invoice_payment WHERE invoice_id=inv_id) AS Paid,
            (SELECT SUM(' . $this->db->dbprefix . 'invoice_return.price) from ' . $this->db->dbprefix . 'invoice_return WHERE invoice_id=inv_id) AS Adjust');
        $this->db->from('invoice');
        $this->db->where('invoice.tble_id', $invoice);
        $this->db->join('branch', 'branch.tble_id = invoice.branch_id', 'LEFT');
        $invoices = $this->db->get();
        if($invoices->num_rows() == 1){
            return $invoices->row();
        } else {
            return FALSE;
        }
    }
    
    public function partial_invoice_payment($invoice, $voucher, $inv_payment, $cl_inv_ledger, $client_table){
        $this->db->trans_begin();
        $this->db->where('invoice.tble_id', $invoice['tble_id']);
        $this->db->update('invoice', $invoice);
        
        $this->db->insert('voucher', $voucher);
        $voucher_id     = $this->db->insert_id();
        
        $this->db->insert('client_ledger', $cl_inv_ledger);
        $cl_ledgr = $this->db->insert_id();
        
        $inv_payment['voucher_id'] = $voucher_id;
        $inv_payment['client_voucher'] = $cl_ledgr;
        $this->db->insert('invoice_payment', $inv_payment);
        
        $this->db->where('client.cl_id', $client_table['cl_id']);
        $this->db->update('client', $client_table);
        
        $current_balance = $this->get_branch_balance($voucher['branch_id']);
        $balance         = $current_balance + $inv_payment['amount'];
        $this->db->where('store_cash_in_hand.branch_id', $voucher['branch_id']);
        $this->db->update('store_cash_in_hand', array('balance' => $balance));
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function get_invoice_total_paid_amount($invid){
        $this->db->select('SUM(' . $this->db->dbprefix . 'invoice_payment.amount) AS Payment');
        $this->db->from('invoice_payment');
        $this->db->where('invoice_payment.invoice_id', $invid);
        $payment = $this->db->get();
        if($payment->num_rows() == 1) {
            $payment = $payment->row();
            return $payment->Payment;
        } else {
            return 0;
        }
    }
}
?>
