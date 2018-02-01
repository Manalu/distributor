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
class clientsmodel extends CI_Model {
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    
    public function add_new_client($customer, $ledger){
        $this->db->trans_begin();
        $this->db->insert('client', $customer);
        $client_id = $this->db->insert_id();
        $ledger['client_id'] = $client_id;
        $this->db->insert('client_ledger', $ledger);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function updateClientInfo($customer_array){
        $this->db->trans_begin();
        $this->db->where('client.cl_id', $customer_array['cl_id']);
        $this->db->update('client', $customer_array);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_client_list($type = FALSE){
        $this->db->select('client.cl_id AS cl_id, client.cl_name, client.cl_phone_no, client.cl_mobile_no, client.cl_national_id, client.cl_email, client.cl_status, client.cl_balance');
        $this->db->from('client');
        if($type != FALSE){
            $this->db->where('client.cl_type', $type);
        }
        $this->db->order_by('client.cl_name','ASC');
        $Clients = $this->db->get();
        if($Clients->num_rows() > 0){
            return $Clients;
        }
        else{
            return FALSE;
        }
    }
    
    public function search_clients($FilterKeys){
        $this->db->select('client.cl_id AS cl_id, client.cl_name, client.cl_phone_no, client.cl_mobile_no, client.cl_national_id, client.cl_email, client.cl_status, client.cl_balance');
        $this->db->from('client');
        if(strlen($FilterKeys['cl_name']) > 0){
            $this->db->like('client.cl_name', $FilterKeys['cl_name']);
        }
        if(strlen($FilterKeys['cl_phone_no']) > 0){
            $this->db->like('client.cl_phone_no', $FilterKeys['cl_phone_no']);
        }
        if(strlen($FilterKeys['cl_mobile_no']) > 0){
            $this->db->like('client.cl_mobile_no', $FilterKeys['cl_mobile_no']);
        }
        if(strlen($FilterKeys['natid']) > 0){
            $this->db->like('client.cl_national_id', $FilterKeys['natid']);
        }
        $this->db->order_by('client.cl_name','ASC');
        $Clients = $this->db->get();
        if($Clients->num_rows() > 0){
            return $Clients;
        }
        else{
            return FALSE;
        }
    }
    
    public function get_client_ledger($client){
        $this->db->select('client_ledger.tble_id, client_ledger.amount, client_ledger.ledger_id, client_ledger.ledger_type, client_ledger.invoice_id, client_ledger.notes, client_ledger.ledger_date, client_ledger_head.ledger');
        $this->db->from('client_ledger');
        $this->db->where('client_ledger.client_id', $client);
        $this->db->join('client_ledger_head', 'client_ledger_head.tble_id = client_ledger.ledger_id', 'LEFT');
        $this->db->order_by('client_ledger.ledger_date', 'DESC');
        $this->db->order_by('client_ledger.tble_id', 'DESC');
        $ledger = $this->db->get();
        if($ledger->num_rows() > 0){
            return $ledger;
        } else {
            return FALSE;
        }
    }
    
    public function get_customer_name($clid){
        $this->db->select('client.cl_name');
        $this->db->from('client');
        $this->db->where('client.cl_id', $clid);
        $Phone = $this->db->get();
        if($Phone->num_rows() == 1){
            foreach ($Phone->result() as $Phone){
                return $Phone->cl_name;
            }
        }
        else{
            return 'None';
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
            return 'None';
        }
    }

    public function getClientDetails($clid){
        $this->db->select('*');
        $this->db->from('client');
        $this->db->where('client.cl_id',$clid);
        $Client = $this->db->get();
        if($Client->num_rows() == 1){
            return $Client->row();
        }
        else{
            return FALSE;
        }
    }
    
    public function client_list_for_sales_search(){
        $this->db->select('client.cl_id, client.cl_name, client.cl_present_a, client.cl_phone_no, client.cl_father, client.cl_occupation');
        $this->db->from('client');
        $this->db->where('client.cl_status', 1);
        $this->db->order_by('client.cl_name', 'ASC');
        return $this->db->get()->result_array();
    }
    
    //public function getAllInvoicesOfTheClient($clid){
    public function get_client_invoices($clid){
        $this->db->select('
            invoice.tble_id as InvoiceId,
            invoice.sale_date as Date,
            user_info.u_name as Salesman,
            (SELECT COUNT(`dist_invoice_item`.`tble_id`) FROM `dist_invoice_item` WHERE `dist_invoice_item`.`invoice_id`= InvoiceId) AS Item,
            invoice.total_bill as Amount,
            (SELECT SUM(`dist_invoice_payment`.`amount`) FROM `dist_invoice_payment` WHERE `dist_invoice_payment`.`invoice_id`= InvoiceId) AS Paid,
            invoice.posting_by as SoldBy,
            client.cl_name AS Customer');
        $this->db->from('invoice');
        $this->db->where('invoice.client_id', $clid);
        $this->db->join('user_info', 'user_info.u_id = invoice.posting_by', 'LEFT');
        $this->db->join('client', 'client.cl_id = invoice.client_id', 'LEFT');
        $this->db->order_by('invoice.tble_id','DESC');
        $ClientProfile = $this->db->get();
        if($ClientProfile->num_rows() > 0){
            return $ClientProfile;
        }
        else{
            return $ClientProfile;
        }
    }
    
    public function getTotalAmountSoldToClientByClientIdModelFunc($clid){
        $this->db->select_sum('invoice.total_bill');
        $this->db->from('invoice');
        $this->db->where('invoice.client_id', $clid);
        $Phone = $this->db->get();
        if($Phone->num_rows() == 1){
            foreach ($Phone->result() as $Phone){
                return $Phone->total_bill;
            }
        }
        else{
            return 0;
        }
    }
    
    public function getTotalNumberOfInvoiceSoldToClientByClientIdModelFunc($clid){
        $this->db->select('invoice.tble_id');
        $this->db->from('invoice');
        $this->db->where('invoice.client_id', $clid);
        $Phone = $this->db->get();
        return $Phone->num_rows();
    }
    
    public function get_customer_opening_balance($clid){
        $this->db->select('client_ledger.amount');
        $this->db->from('client_ledger');
        $this->db->where('client_ledger.client_id', $clid);
        $this->db->where('client_ledger.ledger_id', 1);
        $balance = $this->db->get();
        if($balance->num_rows() > 0){
            $balance = $balance->row();
            return $balance->amount;
        } else {
            return 0;
        }
    }
    
    public function get_customer_opening_balance_paid_amount($clid){
        $this->db->select('client_opening_balance_adjust.amount');
        $this->db->from('client_opening_balance_adjust');
        $this->db->where('client_opening_balance_adjust.client_id', $clid);
        $balance = $this->db->get();
        if($balance->num_rows() > 0){
            $balance = $balance->row();
            return $balance->amount;
        } else {
            return 0;
        }
    }
    
    public function opening_balance_adjustment($opening_adjustment_data, $client_ledger, $customer_data, $voucher_data, $cash_in_hand){
        $this->db->trans_begin();
        
        $this->db->insert('voucher', $voucher_data);
        $opening_adjustment_data['voucher_id'] = $this->db->insert_id();
        
        $this->db->insert('client_ledger', $client_ledger);
        $opening_adjustment_data['client_ledger_id'] = $this->db->insert_id();
        
        $this->db->insert('client_opening_balance_adjust', $opening_adjustment_data);
        
        $this->db->where('client.cl_id', $customer_data['cl_id']);
        $this->db->update('client', $customer_data);
        
        $this->db->where('store_cash_in_hand.branch_id', $cash_in_hand['branch_id']);
        $this->db->update('store_cash_in_hand', $cash_in_hand);
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    































































































































































































































































































































































































































































    public function getInvoiceDetailedInformationByInvoiceId($invid){
        $this->db->select('invoice_item.i_med_id as MedId, invoice_item.i_qty as Quantity, invoice_item.i_med_prce as Price');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_inv_id', $invid);
        $Result = $this->db->get();
        if($Result->num_rows() > 0){
            return $Result;
        }
        else{
            return FALSE;
        }
    }
    
    public function getInvoiceInformationByInvoiceId($invid){
        $this->db->select('invoice.inv_id AS InvID, invoice.inv_discount, invoice.inv_dis_type, invoice.inv_all_total, invoice.inv_sub_total, (SELECT SUM(`glf_invoice_payment`.`payment_amount`) FROM `glf_invoice_payment` WHERE `glf_invoice_payment`.`invoice_id`= InvID) AS Paid');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $invid);
        $this->db->join('invoice_payment', 'invoice_payment.invoice_id = invoice.inv_id', 'LEFT');
        $invoice = $this->db->get();
        if($invoice->num_rows() > 0){
            return $invoice->row();
        } else {
            return 0;
        }
    }
    
    public function getNumberOfSalesForEachClientFromModel($clid){
        $this->db->select('inv_id');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_cl', $clid);
        $Counter = $this->db->get();
        return $Counter->num_rows();
    }
    
    public function getClientPhoneNumberByClientIdModelFunc($clid){
        $this->db->select('client.cl_phone_no');
        $this->db->from('client');
        $this->db->where('client.cl_id', $clid);
        $Phone = $this->db->get();
        if($Phone->num_rows() == 1){
            foreach ($Phone->result() as $Phone){
                return $Phone->cl_phone_no;
            }
        }
        else{
            return 'None';
        }
    }
    
    public function get_customer_present_a($clid){
        $this->db->select('client.cl_present_a');
        $this->db->from('client');
        $this->db->where('client.cl_id', $clid);
        $Phone = $this->db->get();
        if($Phone->num_rows() == 1){
            foreach ($Phone->result() as $Phone){
                return $Phone->cl_present_a;
            }
        }
        else{
            return 'None';
        }
    }
    
    public function getClientsOutstandingByClientId($clid){
        $this->db->select('invoice.inv_id, invoice.inv_all_total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_cl', $clid);
        $InvoiceTotal = $this->db->get();
        if($InvoiceTotal->num_rows() > 0){
            $OutStanding = 0;
            foreach ($InvoiceTotal->result() as $InvoiceTotal){
                $OutStanding = $OutStanding + ($InvoiceTotal->inv_all_total - $this->getOutstandingBalance($InvoiceTotal->inv_id));
            }
            return $OutStanding;
        } else {
            return 0;
        }
    }
    
    public function getOutstandingBalance($InvoiceData){
        $this->db->select_sum('invoice_payment.payment_amount');
        $this->db->from('invoice_payment');
        $this->db->where('invoice_payment.invoice_id', $InvoiceData);
//        $this->db->where('invoice_payment.ci_identifier', $InvoiceData['ci_identifier']);
        $TotalBilled = $this->db->get()->row();
        return $TotalBilled->payment_amount;
    }
    
    public function partial_sales_payment($invoice_payment, $voucher_data){
        $this->db->trans_begin();
        $this->db->insert('voucher', $voucher_data);
        $v_id = $this->db->insert_id();
        $invoice_payment['voucher_id'] = $v_id;
        $this->db->insert('invoice_payment', $invoice_payment);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
}

?>
