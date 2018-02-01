<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class salesmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function GetMedDetailsForMedicineSearchBar(){
        $this->db->select('medicine_name.m_id as MedicineId, medicine_name.m_name as MedicineName, medicine_name.m_gid as GroupId, medicine_name.m_cid as CompId, medicine_name.med_u_price as UnitPrice, medicine_name.mrp_box_qty as BoxQuantity, medicine_name.mrp_box_price as BoxPrice, medicine_name.mrp_u_discnt as MedDiscount, medicine_group.mg_name as MedicineGroup, company_info.c_name as MedicineCompany, medicine_type.mt_name as MedicineType');
        $this->db->from('medicine_name');
        $this->db->join('company_info', 'company_info.c_id = medicine_name`.m_cid','left');
        $this->db->join('medicine_group', 'medicine_group.mg_id = medicine_name.m_gid');
        $this->db->join('medicine_type', 'medicine_type.mt_id = medicine_name.m_tid');
        $this->db->order_by('medicine_name.m_name', 'asc');
        return $this->db->get()->result_array();
    }
    
    public function GetMedDetailsForMedicineSearchBarSortedByGroup($groupid){
        $this->db->select('medicine_name.m_id as MedicineId, medicine_name.m_name as MedicineName, medicine_name.m_gid as GroupId, medicine_group.mg_name as MedicineGroup, company_info.c_name as MedicineCompany, medicine_type.mt_name as MedicineType');
        $this->db->from('medicine_name');
        $this->db->where('medicine_name.m_gid', $groupid);
        $this->db->join('company_info', 'company_info.c_id = medicine_name`.m_cid','left');
        $this->db->join('medicine_group', 'medicine_group.mg_id = medicine_name.m_gid');
        $this->db->join('medicine_type', 'medicine_type.mt_id = medicine_name.m_tid');
        $this->db->order_by('medicine_name.m_name', 'asc');
        return $this->db->get()->result_array();
    }
    
    public function GetMedsName($str,$type=FALSE){
        $this->db->select('medicine_name.m_name as name,medicine_group.mg_name as grp');
        $this->db->from("medicine_name");
        $this->db->join('medicine_group', 'medicine_group.mg_id = medicine_name.m_gid');
        $this->db->like('m_name', $str);
        $this->db->or_like('medicine_group.mg_name', $str);
        if($type !=FALSE){
            $this->db->where("m_tid", $type);
        }
        $meds = $this->db->get();
        if($meds->num_rows()>0){
            return $meds->result();
        }
        return FALSE;
    }
    
    public function GetMedPrice($string){
        $this->db->select('m_id as id');
        $this->db->from("medicine_name");
        $this->db->where('m_name', $string);
        $med = $this->db->get();
        if($med->num_rows()>0){
            $medid = $med->result();
              return $this->price($medid[0]->id) ;
        }
        else {
            return FALSE;
        }
    }
    
    public function price($mid){
        $this->db->select("medicine_name.med_u_price as price");
        $this->db->from("medicine_name");
        $this->db->where('medicine_name.m_id', $mid);
        $price = $this->db->get()->row();
        return $price->price;
    }
    
    public function discount($mid){
        $this->db->select("medicine_name.mrp_u_discnt as discount");
        $this->db->from("medicine_name");
        $this->db->where('medicine_name.m_id', $mid);
        $price = $this->db->get()->row();
        return $price->discount;
    }
    
    public function getCustomerForSales(){
        $this->db->select('*');
        $this->db->from('client');
        $Score = $this->db->get();
        if($Score->num_rows() > 0){
            //return $Score->result_array();
            return $Score;
        }
        else{
            return FALSE;
        }
    }

    public function GetType(){
        $this->db->select('*');
        $this->db->from('medicine_type');
        return $this->db->get()->result();
    }    
    
    public function GetMrpId($mname){
        $this->db->select('medicine_mrp.mrp_id as id, medicine_name.m_name as name');
        $this->db->from("medicine_mrp");
        $this->db->join('medicine_name', 'medicine_mrp.mrp_mid = medicine_name.m_id');
        $this->db->where('medicine_name.m_name', $mname);
        $med = $this->db->get()->result();
        return $med[0]->id;
    }
    
    public function checkAndInsertACustomerIdForInvoice($CusomterInfo){
        $this->db->select('client.cl_id');
        $this->db->from('client');
        $this->db->where('client.cl_phone_no', $CusomterInfo['cl_phone_no']);
        $CustomerId = $this->db->get();
        if($CustomerId->num_rows() == 0){
            $data = array('cl_phone_no' => $CusomterInfo['cl_phone_no'], 'cl_name' => $CusomterInfo['cl_name']);
            if($this->db->insert('client', $data)){
                return $this->db->insert_id();
            }
            else{
                return 0;
            }
        }
        elseif($CustomerId->num_rows() == 1){
            foreach ($CustomerId->result() as $CustomerId){
                return $CustomerId->cl_id;
            }
        }
        else{
            return 0;
        }
    }
    
    public function createNewInvoice($InvoiceTableData, $Invoice_Item, $voucher_data, $Invoice_Payment){
        $this->db->trans_begin();
        $this->db->insert('invoice', $InvoiceTableData);
        $invId = $this->db->insert_id();
        $Rowz = count($Invoice_Item['i_med_id']);
        for($i = 0; $i < $Rowz; $i++){
            $InvoiceItemData = array( 'i_inv_id' => $invId, 'inv_comp_id' => $Invoice_Item['inv_comp_id'][$i], 'i_med_id' => $Invoice_Item['i_med_id'][$i], 'i_qty' => $Invoice_Item['i_qty'][$i], 'i_med_prce' => $Invoice_Item['i_med_prce'][$i], 'inv_item_date' => $Invoice_Item['inv_item_date']);
            $this->db->insert('invoice_item', $InvoiceItemData);
            $stock = (getMedicineStockFromMediineId($Invoice_Item['i_med_id'][$i]) - $Invoice_Item['i_qty'][$i]);
            $this->db->where('medicine_name.m_id', $Invoice_Item['i_med_id'][$i]);
            $this->db->update('medicine_name', array('medicine_name.m_stok' => $stock));
        }
        $voucher_data['v_note'] = 'Medicine Sales for: <a href="' . site_url('sales/details/' . $invId) . '">' . $invId . '</a>';
        $this->db->insert('voucher', $voucher_data);
        $v_id = $this->db->insert_id();
        $Invoice_Payment['invoice_id'] = $invId;
        $Invoice_Payment['voucher_id'] = $v_id;
        $this->db->insert('invoice_payment', $Invoice_Payment);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }    
    
    public function SetInvItem($itemData){
        if($this->db->insert('invoice_item', $itemData)){
            $this->db->select('medicine_name.m_stok');
            $this->db->from('medicine_name');
            $this->db->where('medicine_name.m_id', $itemData['i_med_id']);
            $MedicineStock = $this->db->get()->row();
            $med_stok = $MedicineStock->m_stok - $itemData['i_qty'];
            $data = array('medicine_name.m_stok' => $med_stok);
            $this->db->where('medicine_name.m_id', $itemData['i_med_id']);
            if($this->db->update('medicine_name', $data)){
                return TRUE;
            }
            else{
                return $this->db->_error_message();
            }
        }
        else{
            return $this->db->_error_message();
        }
    }
    
    public function insertNewCashinRowFromSalesList($CashinData){
        if($this->db->insert('cashin', $CashinData)){
            return TRUE;
        }
        else{
            return $this->db->_error_message();
        }
    }
    
    public function sales_partial_payment($invoice_table, $voucher_data, $invoice_payment){
        $this->db->trans_begin();
        $this->db->where('invoice.inv_id', $invoice_table['inv_id']);
        $this->db->update('invoice', $invoice_table);
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

    public function GetReport($start,$end){
        $sql = "SELECT  `inv_date` AS date, SUM(`inv_net_amount`) AS amount FROM  `dist_invoice` WHERE  `inv_date` BETWEEN  '".date('d-m-Y', strtotime($start))."' AND  '".date('d-m-Y', strtotime($end))."'
        GROUP BY  `inv_date`";
        return $this->db->query($sql)->result();
    }    
    
    public function GetAllInvoice($date){
        $this->db->select('invoice.inv_id as id ,user.u_name as user,invoice.inv_time as time,invoice.inv_date as date,invoice.inv_tot_amount as totam,invoice.inv_discount as discount, invoice.inv_net_amount as net,invoice.inv_status as status');
        $this->db->from('invoice');
        $this->db->join('user','user.u_id = invoice.inv_uid');
        $this->db->order_by("inv_id","desc");
        $this->db->where('invoice.inv_date',$date);
        $comp = $this->db->get();
        if($comp->num_rows()>0){
            return $comp;
        }
        else{
            return FALSE;
        }
    }    
    
    public function GetReportToday(){
        $sql = "SELECT  `inv_date` AS date, SUM(`inv_net_amount`) AS amount FROM  `dist_invoice` WHERE  `inv_date` = '".date('d-m-Y',time())."' 
        GROUP BY  `inv_date`";
        return $this->db->query($sql)->result();
    }
    
    public function getMrpIdByMedicineId($medid){
        $this->db->select('medicine_mrp.mrp_id as id');
        $this->db->from("medicine_mrp");
        //$this->db->join('medicine_name', 'medicine_mrp.mrp_mid = medicine_name.m_id');
        $this->db->where('medicine_mrp.mrp_mid', $medid);
        $med = $this->db->get()->result();
        return $med[0]->id;
    }
    
    public function getAllSalesSortedByIdDesc($status = FALSE){
        $this->db->select(' invoice.inv_id as SoldId,
                    user_info.u_name as SoldUser,
                    invoice.inv_date as SoldDate,
                    invoice.inv_time as SoldTime,
                    invoice.inv_all_total as Billed,
                    invoice.inv_status as Status,
                    (SELECT SUM(`dist_invoice_payment`.`payment_amount`) FROM `dist_invoice_payment` WHERE `dist_invoice_payment`.`invoice_id`=SoldId) AS Paid,
                    (SELECT COUNT(`dist_invoice_item`.`i_id`) FROM `dist_invoice_item` WHERE `dist_invoice_item`.`i_inv_id`=SoldId) AS Items');
        $this->db->from('invoice');
        if($status === FALSE){
            
        }
        else{
            $this->db->where('invoice.inv_status', $status);
        }
        $this->db->order_by('invoice.inv_id','DESC');
        $this->db->join('user_info', 'user_info.u_id = invoice.inv_uid', 'LEFT');
        $this->db->join('invoice_payment', 'invoice_payment.invoice_id = invoice.inv_id', 'LEFT');
        $this->db->join('invoice_item', 'invoice_item.i_inv_id = invoice.inv_id', 'LEFT');
        $this->db->limit(200);
        $SalesList = $this->db->get();
        if($SalesList->num_rows() > 0){
            return $SalesList;
        }
        else{
            return FALSE;
        }
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
    
    public function getPaidAmountForEachInvoiceByInvoiceIdFromModel($invid){
        $this->db->select_sum('invoice_payment.payment_amount','PaidAmount');
        $this->db->from('invoice_payment');
        $this->db->where('invoice_payment.invoice_id', $invid);
        //$this->db->where('cashin.ci_identifier', 1);
        $TotalPaid = $this->db->get();
        //return $TotalPaid->num_rows();
        if($TotalPaid->num_rows() == 1){
            foreach ($TotalPaid->result() as $TotalPaid){
                if($TotalPaid->PaidAmount == NULL){
                    return 0;
                }
                else{
                    return $TotalPaid->PaidAmount;
                }
            }
        }
        else{
            return 0;
        }
    }
    
    public function getReturnedAmountForEachInvoiceByInvoiceIdFromModel($invid){
        $this->db->select_sum('cashout.co_amount','ReturnedAmount');
        $this->db->from('cashout');
        $this->db->where('cashout.co_purpose', $invid);
        $this->db->where('cashout.co_identifier', 2);
        $TotalReturn = $this->db->get();
        if($TotalReturn->num_rows() == 1){
            foreach ($TotalReturn->result() as $TotalReturn){
                if($TotalReturn->ReturnedAmount == NULL){
                    return 0;
                }
                else{
                    return $TotalReturn->ReturnedAmount;
                }
            }
        }
        else{
            return 0;
        }
    }
    
    public function getTotalItemSoldPerInvoiceFromModel($invid){
        $this->db->select('invoice_item.i_id');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_inv_id', $invid);
        $NumbItems = $this->db->get();
        return $NumbItems->num_rows();
    }
    
    public function insertNewCashoutRowFromSalesList($CashOutTableData){
        if($this->db->insert('cashout', $CashOutTableData)){
            return TRUE;
        }
        else{
            return $this->db->_error_message();
        }
    }
    
    public function checkPreviouslyUpdatedOrNot($inv_id){
        $this->db->select('invoice_update.inv_id');
        $this->db->from('invoice_update');
        $this->db->where('invoice_update.inv_id', $inv_id);
        $NumberOfRows = $this->db->get();
        return $NumberOfRows->num_rows();
    }
    
    public function putAnewUpdateRecord($InvoiceUpdateData){
        if($this->db->insert('invoice_update', $InvoiceUpdateData)){
            return TRUE;
        }
        else{
            return $this->db->_error_message();
        }
    }
    
    public function ReRecordOfUpdateRecord($InvoiceUpdateData){
        $data = array('usr_id' => $InvoiceUpdateData['usr_id'], 'up_date' => $InvoiceUpdateData['up_date'], 'up_time' => $InvoiceUpdateData['up_time']);
        $this->db->where('invoice_update.inv_id', $InvoiceUpdateData['inv_id']);
        if($this->db->update('invoice_update', $InvoiceUpdateData)){
            return TRUE;
        }
        else{
            return $this->db->_error_message();
        }
    }

    public function updateInvoiceStatusDueToFullPayment($stats){
        $data = array('invoice.inv_status' => 1);
        $this->db->where('invoice.inv_id', $stats);
        $this->db->update('invoice', $data);
    }
    
    public function getSalesInfoFromInvoiceTable($invid){
        $this->db->select('*');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_inv_id',$invid);
        $InvItem = $this->db->get();        
        if($InvItem->num_rows() > 0){
            return $InvItem;
        }
        else{
            return FALSE;
        }
    }
    
    public function getMedicineNameByMedicineIdFromModel($medid){
        $this->db->select('medicine_name.m_name as m_name');
        $this->db->from('medicine_name');
        $this->db->where('medicine_name.m_id', $medid);
        $Name = $this->db->get()->row();
        if($Name != NULL){
            return $Name->m_name;
        }
        else{
            return 'No Medicine Name!!';
        }
    }
    
    public function MedicineCompanyFromMedicineIdForHelper($medid){
        $this->db->select('company_info.c_name');
        $this->db->from('medicine_name');
        $this->db->where('medicine_name.m_id', $medid);
        $this->db->join('company_info', 'company_info.c_id = medicine_name.m_cid', 'LEFT');
        $Company = $this->db->get()->row();
        return $Company->c_name;
    }
    
    public function getMedicineTypeNameByMedicineId($medid){
        $this->db->select('medicine_type.mt_name');
        $this->db->from('medicine_name');
        $this->db->where('medicine_name.m_id', $medid);
        $this->db->join('medicine_type', 'medicine_type.mt_id = medicine_name.m_tid', 'LEFT');
        $Company = $this->db->get()->row();
        return $Company->mt_name;
    }
    
    public function getMedicineQuantityByInvoiceIdFromModel($invid, $i_med_id){
        $this->db->select('invoice_item.i_qty');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_inv_id', $invid);
        $this->db->where('invoice_item.i_med_id', $i_med_id);
        $Quantity = $this->db->get()->row();
        return $Quantity->i_qty;
    }
    
    public function getMedPriceForUpdateFunction($invid, $i_med_id){
        $this->db->select('invoice_item.i_med_prce');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_inv_id', $invid);
        $this->db->where('invoice_item.i_med_id', $i_med_id);
        $Quantity = $this->db->get()->row();
        return $Quantity->i_med_prce;
    }
    
    //Sales Statistics
    public function getTotalNubmerOfSalesByUserId($userid, $start, $end){
        $this->db->select('inv_id');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_uid', $userid);
        $this->db->where('invoice.inv_date >=', $start);
        $this->db->where('invoice.inv_date <=', $end);
        $Sales = $this->db->get();
        if($Sales->num_rows() > 0){
            return $Sales->num_rows();
        }
        else{
            return 0;
        }
    }
    
    public function getTotalSoldAmountByUserId($userid, $start, $end){
        $this->db->select_sum('inv_sub_total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_uid', $userid);
        $this->db->where('invoice.inv_date >=', $start);
        $this->db->where('invoice.inv_date <=', $end);
        $Sales = $this->db->get()->row();
        return $Sales->inv_sub_total;
    }

    public function getTotalNumberOfSalesForLastXMonths($user, $time){
        $this->db->select('inv_id');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_uid', $user);
        $this->db->where('invoice.inv_date >=', $time);
        $Sales = $this->db->get();
        return $Sales->num_rows();
    }
    
    public function getTotalSoldAmountByUserIdForXMonth($user, $time){
        $this->db->select_sum('inv_sub_total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_uid', $user);
        $this->db->where('invoice.inv_date >=', $time);
        $Sales = $this->db->get()->row();
        return $Sales->inv_sub_total;
    }
    //Finish of Sales statistics
    
    
    public function cl_phone_no($tid){
        $this->db->select('invoice_client.cinv_id, client.cl_phone_no');
        $this->db->from('invoice_client');
        $this->db->where('invoice_client.inv_id', $tid);
        $this->db->join('client', 'client.cl_id = invoice_client.cl_id','LEFT');
        $Phone = $this->db->get();
        if($Phone->num_rows() > 0){
            foreach ($Phone->result() as $Phone){
                return $Phone->cl_phone_no;
            }
        }
    }
    
    public function getSalesManByInvoiceId($invid){
        $this->db->select('user.u_name as Name');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $invid);
        $this->db->join('user', 'user.u_id = invoice.inv_uid', 'LEFT');
        $Name = $this->db->get()->row();
        return $Name->Name;
    }
    
    public function getSalesDateByInvoiceId($invid){
        $this->db->select('invoice.inv_date');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $invid);
        $Date = $this->db->get()->row();
        return $Date->inv_date;
    }
    
    public function numberOfUpdateByInvoiceId($invid){
        $this->db->select('invoice_update.up_id');
        $this->db->from('invoice_update');
        $this->db->where('invoice_update.inv_id', $invid);
        $Date = $this->db->get();
        return $Date->num_rows();
    }
    
    public function LastUpdateOfInvoiceByInvoiceId($invid){
        $this->db->select('invoice_update.up_date');
        $this->db->from('invoice_update');
        $this->db->where('invoice_update.inv_id', $invid);
        $this->db->order_by('invoice_update.up_id', 'DESC');
        $this->db->limit(1);        
        $Date = $this->db->get();
        if($Date->num_rows() > 0){
            foreach ($Date->result() as $Date){
                return $Date->up_date;
            }
        }
        else{
            return FALSE;
        }
    }
    
    public function LastUpdatePersonOfInvoiceByInvoiceId($invid){
        $this->db->select('user.u_name as Name');
        $this->db->from('invoice_update');
        $this->db->where('invoice_update.inv_id', $invid);
        $this->db->join('user', 'user.u_id = invoice_update.usr_id', 'LEFT');
        $Date = $this->db->get();
        if($Date->num_rows() > 0){
            foreach ($Date->result() as $Date){
                return $Date->Name;
            }
        }
        else{
            return FALSE;
        }
    }
    
    public function TotalAmountPaidForThisInvoice($invid){
        $this->db->select_sum('cashin.ci_amount');
        $this->db->from('cashin');
        $this->db->where('cashin.ci_purpose', $invid);
        $this->db->where('cashin.ci_identifier', 1);
        $Date = $this->db->get()->row();
        return $Date->ci_amount;
            
    }
    
    public function getInvoiceStatusByInvoiceId($invid){
        $this->db->select('invoice.inv_status');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $invid);
        $Name = $this->db->get()->row();
        return $Name->inv_status;
    }
    
    public function getInvoiceSubtotalPayment($invid){
        $this->db->select('invoice.inv_sub_total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $invid);
        $Name = $this->db->get()->row();
        return $Name->inv_sub_total;
    }
    
    public function getDiscountPercentageByInvoiceId($invid){
        $this->db->select('invoice.inv_discount');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $invid);
        $Name = $this->db->get()->row();
        return $Name->inv_discount;
    }
    
    public function getInvoiceAllTotalPayment($invid){
        $this->db->select('invoice.inv_all_total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $invid);
        $Name = $this->db->get()->row();
        return $Name->inv_all_total;
    }
    
    public function updateInvoiceTable($dist_invoice){
        $data = array(
            'inv_sub_total' => $dist_invoice['inv_sub_total'],
            'inv_discount' => $dist_invoice['inv_discount'],
            'inv_all_total' => $dist_invoice['inv_all_total'],
            'inv_status' => $dist_invoice['inv_status'],
        );
        $this->db->where('invoice.inv_id', $dist_invoice['inv_id']);
        if($this->db->update('invoice', $data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function updateClientHistoryOfInvoice($CustomerIdData){
        $data = array('cl_id' => $CustomerIdData['cl_id']);
        $this->db->where('invoice_client.inv_id', $CustomerIdData['inv_id']);
        if($this->db->update('invoice_client', $data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
    public function getAllFilteredInvoicesByFilterKey($FilterKey){
        $this->db->select('invoice.inv_id as SoldId, user_info.u_name as SoldUser, invoice.inv_date as SoldDate, invoice.inv_time as SoldTime, invoice.inv_all_total as Billed, invoice.inv_status as Status');
        $this->db->from('invoice');
        if($FilterKey['starting'] != ""){ $this->db->where('invoice.inv_date >=', $FilterKey['starting']); }
        if($FilterKey['endngday'] != ""){ $this->db->where('invoice.inv_date <=', $FilterKey['endngday']); }
        if($FilterKey['employee'] != ""){ $this->db->where('invoice.inv_uid', $FilterKey['employee']); }
        if($FilterKey['invstats'] != ""){ $this->db->where('invoice.inv_status', $FilterKey['invstats']); }
        if($FilterKey['invnumb']  != ""){ $this->db->where('invoice.inv_id', $FilterKey['invnumb']); }
        $this->db->order_by('invoice.inv_id','DESC');
        $this->db->join('user_info', 'user_info.u_id = invoice.inv_uid', 'LEFT');
        //$this->db->join('invoice_client', 'invoice_client.inv_id = invoice.inv_id', 'LEFT');
        $this->db->limit(50000);
        $SalesList = $this->db->get();
        if($SalesList->num_rows() > 0){
            return $SalesList;
        }
        else{
            return FALSE;
        }
    }
    
    public function getInformationFromInvoiceTable($invid){
        $this->db->select('invoice.inv_id as Invoice,
            user_info.u_name as Seller,
            invoice.inv_cl as CustomerId,
            invoice.inv_time as SellTime,
            invoice.inv_date as SellDate,
            invoice.inv_sub_total as PB4Dis,
            invoice.inv_discount as Discount,
            invoice.inv_all_total as PAFDis,
            invoice.inv_status as Status,
            invoice.inv_cl as ClientId,
            invoice.inv_dis_type as DisType,
            (SELECT SUM(`dist_invoice_payment`.`payment_amount`) FROM `dist_invoice_payment` WHERE `dist_invoice_payment`.`invoice_id`=Invoice) AS PaidAmount');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $invid);
        $this->db->join('user_info','user_info.u_id = invoice.inv_uid','LEFT');
        $Invoice = $this->db->get();
        if($Invoice->num_rows() == 1){
            return $Invoice->row();
        }
        else{
            return FALSE;
        }
    }
    
    public function getClientFromInvoicClientTable($invid){
        $this->db->select('client.cl_id, client.cl_name, invoice.inv_cl, client.cl_phone_no');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $invid);
        $this->db->join('client','client.cl_id = invoice.inv_cl','LEFT');
        $Client = $this->db->get();
        if($Client->num_rows() == 1){
            return $Client->row();
        }
        else{
            return FALSE;
        }
    }
    
    public function getAllItemsFromInvoiceItemTable($invid){
        $this->db->select('*');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_inv_id', $invid);
        $Items = $this->db->get();
        if($Items->num_rows() > 0){
            return $Items;
        }
        else{
            return FALSE;
        }
    }
    
    public function getTotalPaidAmountSearchByInvoiceId($invid){
        //Also used to print invoice....
//        $this->db->select_sum('cashin.ci_amount');
//        $this->db->from('cashin');
//        $this->db->where('cashin.ci_purpose', $invid);
//        $this->db->where('cashin.ci_identifier', '1');
//        $Amount = $this->db->get()->row();
//        if($Amount != FALSE){
//            $ci = $Amount->ci_amount;
//        }
//        else { $ci = 0; }
//        $this->db->select_sum('cashout.co_amount');
//        $this->db->from('cashout');
//        $this->db->where('cashout.co_purpose', $invid);
//        $this->db->where('cashout.co_identifier', '2');
//        $AmountT = $this->db->get()->row();
//        if($AmountT != FALSE){ $co = $AmountT->co_amount; } else { $co = 0; }
//        if($co < 0){
//            return ($ci + $co);
//        }
//        else{
//            return ($ci - $co);
//        }
        return 0;
    }
    
    public function getExistingNumberOfItemsInAnInvoice($inv_id){
        $this->db->select('invoice.inv_id');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $inv_id);
        $NumberOfItems = $this->db->get();
        return $NumberOfItems->num_rows();
    }
    
    public function getAllPreviousMedicines($inv_id){
        $this->db->select('*');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_inv_id', $inv_id);
        $ListOfItems = $this->db->get();
        return $ListOfItems;
    }
    
    public function deleteExistingEntry($inv_id, $medid, $medqty){
        $this->db->select('invoice_item.i_qty');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_inv_id', $inv_id);
        $this->db->where('invoice_item.i_med_id', $medid);
        $Quantity   = $this->db->get()->row();
        $Qty        = $Quantity->i_qty;
        $this->db->where('invoice_item.i_inv_id', $inv_id);
        $this->db->where('invoice_item.i_med_id', $medid);
        if($this->db->delete('invoice_item')){
            $this->db->select('medicine_name.m_stok');
            $this->db->from('medicine_name');
            $this->db->where('medicine_name.m_id', $medid);
            $MedicineStock = $this->db->get()->row();
            $med_stok = $MedicineStock->m_stok + $Qty;
            $data = array('medicine_name.m_stok' => $med_stok);
            $this->db->where('medicine_name.m_id', $medid);
            if($this->db->update('medicine_name', $data)){
                return TRUE;
            }
            else{
                return $this->db->_error_message();
            }
        }
        else{
            return $this->db->_error_message();
        }
    }

    public function updatePreviousInvoice($InvoiceTableData){
        $data = array(
            'inv_sub_total' => $InvoiceTableData['inv_sub_total'],
            'inv_discount' => $InvoiceTableData['inv_discount'],
            'inv_all_total' => $InvoiceTableData['inv_all_total'],
            'inv_dis_type' => $InvoiceTableData['inv_dis_type'],
            'inv_status' => $InvoiceTableData['inv_status']
        );
        $this->db->where('invoice.inv_id', $InvoiceTableData['inv_id']);
        if($this->db->update('invoice', $data)){
            return TRUE;
        }
        else{
            return $this->db->_error_message();
        }
    }
    
    public function checkExistingEntry($i_med_id, $inv_id, $itemid){
        $this->db->select('invoice_item.i_id');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_med_id', $i_med_id);
        $this->db->where('invoice_item.i_inv_id', $inv_id);
        $this->db->where('invoice_item.i_id', $itemid);
        $Check = $this->db->get();
        if($Check->num_rows() == 1){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function updateExistingEntry($InvoiceItemData){
        $data = array(
            'i_qty' => $InvoiceItemData['i_qty'],
            'i_med_prce' => $InvoiceItemData['i_med_prce']
        );
        $this->db->where('invoice_item.i_med_id', $InvoiceItemData['i_med_id']);
        $this->db->where('invoice_item.i_inv_id', $InvoiceItemData['i_inv_id']);
        if($this->db->update('invoice_item', $data)){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }

    public function getTodaysTotalSales($today){
        $this->db->select_sum('invoice.inv_all_total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_date', $today);
        $this->db->where('invoice.inv_status !=', 2);
        $TotalSales = $this->db->get()->row();
        return $TotalSales->inv_all_total;
    }
    
    public function getTodaysTotalDueSales($today){
        $this->db->select_sum('invoice.inv_all_total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_date', $today);
        $this->db->where('invoice.inv_status', 0);
        $TotalSales = $this->db->get()->row();
        return $TotalSales->inv_all_total;
    }
    
    public function getTodaysTotalDueInvoices($today){
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_date', $today);
        $this->db->where('invoice.inv_status', 0);
        $TotalSales = $this->db->get();
        if($TotalSales->num_rows() > 0){
            return $TotalSales;
        } else{
            return FALSE;
        }
    }
    
    public function getTodaysTotalCardSales($today){
        $this->db->select_sum('invoice.inv_all_total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_date', $today);
        $this->db->where('invoice.inv_status', 3);
        $TotalSales = $this->db->get()->row();
        return $TotalSales->inv_all_total;
    }
    
    public function getTodaysTotalZeroSales($today){
        $this->db->select_sum('invoice.inv_all_total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_date', $today);
        $this->db->where('invoice.inv_status', 2);
        $TotalSales = $this->db->get()->row();
        return $TotalSales->inv_all_total;
    }

    public function insertNewDemandRequest($medid){
        $data = array('d_name' => $medid['d_name'], 'd_date' => $medid['d_date'], 'd_uid' => $medid['d_uid']);
        $this->db->insert('demand_request', $data);
    }
    
    public function getAllItemDataForPrinting($inv){
        $this->db->select('invoice_item.i_med_id as medid, invoice_item.i_qty as quantity, invoice_item.i_med_prce as price');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_inv_id', $inv);
        $Items = $this->db->get();
        if($Items->num_rows() > 0) {
            return $Items;
        }
        else{
            return 0;
        }
    }
    
    public function getInvoiceMoneyAmountsForPrinting($inv){
        $this->db->select('invoice.inv_sub_total as subtotal, invoice.inv_discount as discount, invoice.inv_all_total as total');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $inv);
        $Subtotal = $this->db->get();
        return $Subtotal->result();
    }
    
    public function getInvoiceDateForPrintingPurpose($inv){
        $this->db->select('invoice.inv_date, invoice.inv_time');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $inv);
        $Date = $this->db->get()->row();
        return $Date->inv_date . ' at ' . $Date->inv_time;
    }
    
    public function getInvoiceSalesmanForPrinting($inv){
        $this->db->select('invoice.inv_uid');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $inv);
        $Date = $this->db->get()->row();
        return $Date->inv_uid;
    }
    
    public function getInvocieStatusByInvoiceIdFromModel($inv){
        $this->db->select('invoice.inv_status');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_id', $inv);
        $Date = $this->db->get()->row();
        return $Date->inv_status;
    }

    public function getAllItemsSoldToday($Filter_Key = FALSE){
        $this->db->select('dist_invoice_item.i_med_id AS MedId, medicine_name.m_name, company_info.c_name, SUM(dist_invoice_item.i_qty) AS Quantity, SUM(dist_invoice_item.i_med_prce) AS Price');
        $this->db->from('invoice_item');
        if($Filter_Key == FALSE){
            $this->db->where('invoice_item.inv_item_date', date("Y-m-d"));
        } else {
            $this->db->where('invoice_item.inv_item_date >=', $Filter_Key['starting_date']);
            $this->db->where('invoice_item.inv_item_date <=', $Filter_Key['ending_date']);
        }
        $this->db->join('medicine_name', 'medicine_name.m_id = invoice_item.i_med_id', 'LEFT');
        $this->db->join('company_info', 'company_info.c_id = invoice_item.inv_comp_id', 'LEFT');
        $this->db->order_by('medicine_name.m_name', 'ASC');
        $this->db->group_by('dist_invoice_item.i_med_id');
        $Result = $this->db->get(); //echo $this->db->last_query();
        if($Result->num_rows() > 0){
            return $Result;
        }
        else{
            return FALSE;
        }
    }
    
    public function getMedicineQuantityForDailyListFromModel($medid, $Filter_Key = FALSE){
        $this->db->select_sum('i_qty');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.i_med_id', $medid);
        if($Filter_Key === FALSE) {
            $this->db->where('invoice_item.inv_item_date', date("Y-m-d"));
        } else {
            if($Filter_Key['starting_date'] != ""){
                $this->db->where('invoice_item.inv_item_date >=', $Filter_Key['starting_date']);
            }
            if($Filter_Key['ending_date'] != ""){
                $this->db->where('invoice_item.inv_item_date <=', $Filter_Key['ending_date']);
            }
        }
//        $this->db->where('invoice_item.inv_item_date', date("Y-m-d"));
        $Result = $this->db->get()->row();
        if($Result != NULL){
            return $Result->i_qty;
        }
        else{
            return 0;
        }
    }
    
    public function getCustomerPhoneByCustomerIdFromModel($CustomerId){
        $this->db->select('cl_phone_no');
        $this->db->from('client');
        $this->db->where('client.cl_id', $CustomerId);
        $Result = $this->db->get()->row();
        return $Result->cl_phone_no;
    }
    
    public function getCustomerNameByCustomerIdFromModel($CustomerId){
        $this->db->select('cl_name');
        $this->db->from('client');
        $this->db->where('client.cl_id', $CustomerId);
        $Result = $this->db->get()->row();
        return $Result->cl_name;
    }
    
    public function deleteInvoiceItem($itemid){
        $this->db->where('invoice_item.i_id', $itemid);
        if($this->db->delete('invoice_item')){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function getSaleInformationFromInvoiceUpdateTable($invid){
        $this->db->select('invoice_update.up_id');
        $this->db->from('invoice_update');
        $this->db->where('invoice_update.inv_id', $invid);
        $Score = $this->db->get();
        return $Score->num_rows();
    }
    
    public function getDueSalesWidgetData($limit){
        $this->db->select('invoice.inv_id as InvoiceID, invoice.inv_all_total as Billed, invoice.inv_date as InvocieDate, user_info.u_name as User');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_status', 0);
        $this->db->join('user_info', 'user_info.u_id = invoice.inv_uid', 'LEFT');
        $this->db->order_by('invoice.inv_id','DESC');
        $this->db->limit($limit);
        $InvoiceList = $this->db->get();
        if($InvoiceList->num_rows() > 0){
            return $InvoiceList;
        }
        else{
            return FALSE;
        }
    }
    
    public function outstandingAmountForSpecificUser($user, $start, $end){
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('invoice.inv_uid', $user);
        $this->db->where('invoice.inv_date >=', $start);
        $this->db->where('invoice.inv_date <=', $end);
        $OutStanding = $this->db->get();
        if($OutStanding->num_rows() > 0){
            return $OutStanding;
        } else {
            return FALSE;
        }
    }
}
?>
