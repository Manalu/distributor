<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ordermodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function get_short_product_list_by_supplier($filter){
        if($filter['branch_id'] != ""){
            $this->db->select('products_name.p_id AS p_id, products_name.p_name, products_group.mg_name, products_name.p_min_qty AS p_min_qty, products_name.p_box_qty,
                (SELECT ' . $this->db->dbprefix . 'product_stock.stock FROM '. $this->db->dbprefix . 'product_stock WHERE branch_id = '.$filter['branch_id'].' AND product_id = p_id) as p_stok');
        } 
        else {
            $this->db->select('products_name.p_id AS p_id, products_name.p_name, products_group.mg_name, products_name.p_min_qty, products_name.p_box_qty,
                (SELECT SUM(' . $this->db->dbprefix . 'product_stock.stock) FROM ' . $this->db->dbprefix . 'product_stock WHERE product_id = p_id) as p_stok');
        }
        $this->db->from('products_name');
        $this->db->where('products_name.p_cid', $filter['p_cid']);
        $this->db->where('products_name.p_status', 1);
        $this->db->order_by('products_name.p_name', 'ASC');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid', 'LEFT');
        $products = $this->db->get();
        if($products->num_rows() > 0){
            return $products;
        } else {
            return FALSE;
        }
    }
    
    public function get_product_list_by_supplier($filter){
        if($filter['branch_id'] != ""){
            $this->db->select('products_name.p_id AS p_id, products_name.p_name, products_name.p_cid, products_name.p_gid, products_group.mg_name,
                products_name.p_min_qty, products_name.p_u_price, products_name.p_purchse_price, products_name.p_stock_price, products_name.p_box_qty AS bxqty,
                (SELECT ' . $this->db->dbprefix . 'product_stock.stock FROM '. $this->db->dbprefix . 'product_stock WHERE branch_id = '.$filter['branch_id'].' AND product_id = p_id) as p_stok,
                products_name.p_box_qty, products_name.p_box_bonus');
        } 
        else {
            $this->db->select('products_name.p_id AS p_id, products_name.p_name, products_name.p_cid, products_name.p_gid, products_group.mg_name,
                products_name.p_min_qty, products_name.p_u_price, products_name.p_purchse_price, products_name.p_stock_price, products_name.p_box_qty AS bxqty,
                (SELECT SUM(' . $this->db->dbprefix . 'product_stock.stock) FROM ' . $this->db->dbprefix . 'product_stock WHERE product_id = p_id) as p_stok,
                products_name.p_box_qty, products_name.p_box_bonus');
        }
        $this->db->from('products_name');
        $this->db->where('products_name.p_cid', $filter['p_cid']);
        $this->db->where('products_name.p_status', 1);
        $this->db->order_by('products_name.p_name', 'ASC');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid', 'LEFT');
        $products = $this->db->get();
        if($products->num_rows() > 0){
            return $products;
        } else {
            return FALSE;
        }
    }
    
    public function get_product_list_for_damage($filter){
        if($filter['branch_id'] != ""){
            $this->db->select('products_name.p_id AS p_id, products_name.p_name, products_name.p_cid, products_name.p_gid, products_group.mg_name,
                products_name.p_min_qty, products_name.p_u_price, products_name.p_purchse_price, products_name.p_box_qty AS bxqty,
                (SELECT ' . $this->db->dbprefix . 'product_stock.stock FROM '. $this->db->dbprefix . 'product_stock WHERE branch_id = '.$filter['branch_id'].' AND product_id = p_id) as p_stok,
                products_name.p_box_qty, products_name.p_box_bonus');
        } 
        else {
            $this->db->select('products_name.p_id AS p_id, products_name.p_name, products_name.p_cid, products_name.p_gid, products_group.mg_name,
                products_name.p_min_qty, products_name.p_u_price, products_name.p_purchse_price, products_name.p_box_qty AS bxqty,
                (SELECT SUM(' . $this->db->dbprefix . 'product_stock.stock) FROM ' . $this->db->dbprefix . 'product_stock WHERE product_id = p_id) as p_stok,
                products_name.p_box_qty, products_name.p_box_bonus');
        }
        $this->db->from('products_name');
        $this->db->where('products_name.p_cid', $filter['p_cid']);
        $this->db->where('products_name.p_status', 1);
        $this->db->order_by('products_name.p_name', 'ASC');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid', 'LEFT');
        $products = $this->db->get();
        if($products->num_rows() > 0){
            return $products;
        } else {
            return FALSE;
        }
    }
    
    public function add_order_queue($p_id){
        $this->db->trans_begin();
        for($i = 0; $i < count($p_id); $i++){
            $QData = array('oq_pid' => $p_id[$i], 'oq_status' => 0);
            $this->db->insert('order_queue', $QData);
        }
        $comp = $this->db->select('c_id as id')->from('company_info')->get()->result();
        foreach ($comp as $c) {
            $this->db->select('order_queue.oq_pid as id, products_name.p_name as name, company_info.c_name as company, products_group.mg_name as grp, products_type.mt_name as type');
            $this->db->from('order_queue');
            $this->db->join('products_name', 'order_queue.oq_pid = products_name.p_id','left');
            $this->db->join('company_info', 'company_info.c_id = products_name.p_cid','left');
            $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid');
            $this->db->join('products_type', 'products_type.mt_id = products_name.p_tid');
            $this->db->where('products_name.p_cid', $c->id);
            $qmed =  $this->db->get()->result();
            if($qmed != FALSE){
                $orData = array('or_company' => $c->id, 'or_comp_memo' => "", 'or_notes' => "", 'or_date' => date('Y-m-d'), 'or_time' => date('h:i:s A'), 'or_rcv_date' => '0000-00-00', 'or_rcv_time' => '00:00:00 AM', 'or_sub_total' => 0, 'or_discount' => 0, 'or_total' =>  0, 'or_uid' => $this->Merged_Vars['memb'], 'or_post_date' => date('Y-m-d'), 'or_status' => 1);
                $this->db->insert('order', $orData);
                $orid = $this->db->insert_id();
                foreach($qmed as $m){
                    $order_item = array('oi_comp_id' => $c->id, 'oi_pid' => $m->id, 'oi_orid' => $orid, 'oi_entry_date' => date('Y-m-d'), 'oi_qty' => 0, 'oi_bonus' => 0, 'oi_total_price' => 0);
                    $this->db->insert('order_item', $order_item);
                    $this->db->delete('order_queue', array('oq_pid' => $m->id));
                }
            }
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $orid;
        } 
    }
    
    public function get_order_info($orid){
        $this->db->select('order.or_id as id, order.or_pending, order.or_status, order.or_company as cid, order.or_comp_memo as or_comp_memo, order.or_notes as or_notes, order.or_date as date, order.or_time as time, order.or_rcv_date as rcvd, order.or_rcv_time as rcvt, order.or_total as total, order.or_discount as dis, order.or_sub_total as net, order.or_status as status, user_info.u_name as user, company_info.c_name as company, company_info.c_contact as contact, company_info.c_address as c_address, company_info.c_phone as c_phone, company_info.c_mobile as c_mobile, company_info.c_credit as balance, (SELECT SUM(`op_amount`) FROM ' . $this->db->dbprefix . 'order_payment WHERE `op_orid` = id) as paid');
        $this->db->from('order');
        $this->db->join('user_info', 'order.or_uid = user_info.u_id');
        $this->db->join('company_info','company_info.c_id = order.or_company','left');
        $this->db->where('order.or_id', $orid);
        $order = $this->db->get();
        if($order->num_rows() == 1){
            return $order->row();
        } else {
            return FALSE;
        }
        
    }
    
    public function get_order_items($orid){
        $this->db->select('order_item.oi_id as id,
            products_name.p_id as p_id,
            products_name.p_cid as p_cid,
            products_name.p_gid as p_gid,
            products_name.p_name as name,
            products_name.p_box_qty as bxqty,
            products_name.p_min_qty as minimum,
            products_name.p_purchse_price as purchse,
            products_name.p_box_bonus as p_box_bonus,
            company_info.c_name as company,
            products_group.mg_name as grp,
            products_type.mt_name as type,
            order_item.oi_pid as p_id,
            order_item.oi_comp_id as oi_comp_id,
            order_item.oi_cartoon as cartoon,
            order_item.oi_piece as piece,
            order_item.oi_bonus as bonus,
            order_item.oi_qty as qty,
            order_item.oi_pid as pid,
            order_item.received_status as Received,
            order_item.oi_total_price as t_rate,
            (SELECT SUM('.$this->db->dbprefix.'product_stock.stock) FROM '.$this->db->dbprefix.'product_stock WHERE product_id=p_id) AS stok');
        $this->db->from('order_item');
        $this->db->join('products_name', 'products_name.p_id = order_item.oi_pid','left');
        $this->db->join('company_info', 'company_info.c_id = products_name.p_cid','left');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid');
        $this->db->join('products_type', 'products_type.mt_id = products_name.p_tid');
        $this->db->where('order_item.oi_orid', $orid);
        $this->db->order_by('products_name.p_name', 'ASC');
        return $this->db->get()->result();
    }
    
    public function get_order_items_for_receive($orid){
        $this->db->select('order_item.oi_id as id,
            products_name.p_id as p_id,
            products_name.p_cid as p_cid,
            products_name.p_gid as p_gid,
            products_name.p_name as name,
            products_name.p_box_qty as bxqty,
            products_name.p_min_qty as minimum,
            products_name.p_purchse_price as purchse,
            products_name.p_box_bonus as p_box_bonus,
            company_info.c_name as company,
            products_group.mg_name as grp,
            products_type.mt_name as type,
            order_item.oi_pid as p_id,
            order_item.oi_comp_id as oi_comp_id,
            order_item.oi_cartoon as cartoon,
            order_item.oi_piece as piece,
            order_item.oi_bonus as bonus,
            order_item.oi_qty as qty,
            order_item.oi_pid as pid,
            order_item.received_status as Received,
            order_item.oi_total_price as t_rate,
            (SELECT SUM('.$this->db->dbprefix.'product_stock.stock) FROM '.$this->db->dbprefix.'product_stock WHERE product_id=p_id) AS stok');
        $this->db->from('order_item');
        $this->db->join('products_name', 'products_name.p_id = order_item.oi_pid','left');
        $this->db->join('company_info', 'company_info.c_id = products_name.p_cid','left');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid');
        $this->db->join('products_type', 'products_type.mt_id = products_name.p_tid');
        //$this->db->join('order_stock', 'order_stock.oi_pid = order_item.oi_pid', 'LEFT');
        $this->db->where('order_item.oi_orid', $orid);
        $this->db->where('order_item.received_status', 0);
        $this->db->order_by('products_name.p_name', 'ASC');
        return $this->db->get()->result();
    }
    
    public function get_order_received_stock_cartoon($orderid, $productid){
	$this->db->select_sum('order_stock.oi_cartoon');
	$this->db->from('order_stock');
	$this->db->where('order_stock.oi_orid', $orderid);
	$this->db->where('order_stock.oi_pid', $productid);
	$cartoon = $this->db->get()->row();
        return (int)$cartoon->oi_cartoon;
    }

    public function get_order_received_stock_piece($orderid, $productid){
        $this->db->select_sum('order_stock.oi_piece');
        $this->db->from('order_stock');
        $this->db->where('order_stock.oi_orid', $orderid);
        $this->db->where('order_stock.oi_pid', $productid);
        $piece = $this->db->get()->row();
        return (int)$piece->oi_piece;
    }

    public function get_order_received_stock_bonus($orderid, $productid){
        $this->db->select_sum('order_stock.oi_bonus');
        $this->db->from('order_stock');
        $this->db->where('order_stock.oi_orid', $orderid);
        $this->db->where('order_stock.oi_pid', $productid);
        $bonus = $this->db->get()->row();
        return (int)$bonus->oi_bonus;
    }

    public function get_order_received_stock_quantity($orderid, $productid){
        $this->db->select_sum('order_stock.oi_qty');
        $this->db->from('order_stock');
        $this->db->where('order_stock.oi_orid', $orderid);
        $this->db->where('order_stock.oi_pid', $productid);
        $quantity = $this->db->get()->row();
        return (int)$quantity->oi_qty;
    }
    
    public function get_order_items_for_payment($orid){
        $this->db->select('order_item.oi_id as id, products_name.p_name as name, products_name.p_box_qty as bxqty, products_name.p_min_qty as minimum, products_name.p_purchse_price as purchse, company_info.c_name as company, products_group.mg_name as grp, products_type.mt_name as type, order_item.oi_pid as p_id, order_item.oi_qty as qty, order_item.oi_bonus as bonus, order_item.oi_pid as pid, order_item.oi_total_price as t_rate, (SELECT SUM('.$this->db->dbprefix.'product_stock.stock) FROM '.$this->db->dbprefix.'product_stock WHERE product_id=p_id) AS stok');
        $this->db->from('order_item');
        $this->db->join('products_name', 'products_name.p_id = order_item.oi_pid','left');
        $this->db->join('company_info', 'company_info.c_id = products_name.p_cid','left');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid');
        $this->db->join('products_type', 'products_type.mt_id = products_name.p_tid');
        $this->db->where('order_item.oi_orid', $orid);
        $this->db->order_by('products_name.p_name', 'ASC');
        $items = $this->db->get();
        if($items->num_rows() > 0){
            return $items;
        } else {
            return FALSE;
        }
    }
    
    public function get_order_payments($orid){
        $this->db->select('*');
        $this->db->from('order_payment');
        $this->db->where('order_payment.op_orid', $orid);
        $payments = $this->db->get();
        if($payments->num_rows() > 0){
            return $payments;
        } else {
            return FALSE;
        }
    }
    
    public function delete_order_details($orid, $comp, $paid, $blnc, $adjs){
        $this->db->trans_begin();
        
//        $this->db->where('company_info.c_id', $comp);
//        $array = array('c_credit' => $blnc + $paid);
//        $this->db->update('company_info', $array);
        
//        $this->db->insert('company_credit_adjustment', $adjs);
        
        $this->db->where('order.or_id', $orid);
        $this->db->delete('order');
        
        $this->db->where('order_item.oi_orid', $orid);
        $this->db->delete('order_item');
        
        $this->db->where('order_stock.oi_orid', $orid);
        $this->db->delete('order_stock');
        
        $this->db->select('order_payment.op_vchr_id, order_payment.op_id');
        $this->db->from('order_payment');
        $this->db->where('order_payment.op_orid', $orid);
        $v_list = $this->db->get();
        if($v_list->num_rows() > 0){
            foreach($v_list->result() as $list){
                $this->db->where('voucher.tble_id', $list->op_vchr_id);
                $this->db->delete('voucher');
                
                $this->db->where('order_payment.op_id', $list->op_id);
                $this->db->delete('order_payment');
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
    
    public function update_order($order_data, $items, $cartoon, $piece, $quantity, $price, $credit_adjust, $c_credit, $order_payment){
        $this->db->trans_begin();
        $this->db->where('order.or_id', $order_data['or_id']);
        $this->db->update('order', $order_data);
//        $or_id = $order_data['or_id'];
        for($i = 0; $i < count($items); $i++){
            $this->db->where('order_item.oi_orid', $order_data['or_id']);
            $this->db->where('order_item.oi_id', $items[$i]);
            $array = array('oi_cartoon' => $cartoon[$i], 'oi_piece' => $piece[$i],'oi_qty' => $quantity[$i], 'oi_total_price' => $price[$i]);
            $this->db->update('order_item', $array);
        }
//        $string = 'Purchase Adjustment for : <a href="' . site_url('order/details/' . $or_id) . '">' . $or_id . '</a>';
//        $credit_adjust['notes'] = $string;
//        $this->db->insert('company_credit_adjustment', $credit_adjust);
//        $v_id = $this->db->insert_id();
//        $order_payment['op_vchr_id'] = $v_id;
//        $this->db->insert('order_payment', $order_payment);
//        
//        $this->db->where('company_info.c_id', $c_credit['c_id']);
//        $this->db->update('company_info', $c_credit);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $order_data['or_id'];
        }
    }
    
    public function update_order_stock($order_data, $items, $comps, $prods, $cartoon, $piece, $bonus, $quantity, $price, $credit_adjust, $c_credit, $order_payment, $received, $status){
        $this->db->trans_begin();
        if($status == 1){
            $this->db->where('order.or_id', $order_data['or_id']);
            //$this->db->update('order', $order_data);
            $this->db->update('order', array('or_status' => 2));
        }
        for($i = 0; $i < count($items); $i++){
            if($quantity[$i] > 0){
                $recd_stat = 0;
                if(in_array($items[$i], $received)){
                    $recd_stat = 1;
                }
                //$array = array('oi_orid' => $order_data['or_id'], 'oi_comp_id' => $comps[$i], 'oi_pid' => $prods[$i], 'oi_cartoon' => $cartoon[$i], 'oi_piece' => $piece[$i], 'oi_bonus' => $bonus[$i], 'oi_qty' => $quantity[$i], 'received_status' => $recd_stat, 'oi_total_price' => $price[$i], 'oi_entry_date' => $order_data['or_rcv_date']);
                $array = array('received_status' => $recd_stat);
                $this->db->where('order_item.oi_id', $items[$i]);
                $this->db->update('order_item', $array);

                $oi_stock = array('oi_orid' => $order_data['or_id'], 'oi_comp_id' => $comps[$i], 'oi_pid' => $prods[$i], 'oi_cartoon' => $cartoon[$i], 'oi_piece' => $piece[$i], 'oi_bonus' => $bonus[$i], 'oi_qty' => $quantity[$i], 'oi_total_price' => $price[$i], 'oi_entry_date' => $order_data['or_rcv_date']);
                $this->db->insert('order_stock', $oi_stock);

                $transfer_log = array('product_id' => $prods[$i], 'quantity' => $quantity[$i], 'source' => 100, 'destination' => 1, 'transfer_date' => $order_data['or_rcv_date'], 'transfer_by' => $credit_adjust['posting_by']);
                $this->db->insert('product_transfer', $transfer_log);

                $this->db->select('*');
                $this->db->from('product_stock');
                $this->db->where('product_stock.product_id', $prods[$i]);
                $this->db->where('product_stock.branch_id', 1);
                $stock = $this->db->get();
                if($stock->num_rows() == 1){
                    $stock = $stock->row();
                    //$new_stok = array('product_stock.stock' => ($quantity[$i] + $bonus[$i] + $stock->stock));
                    $new_stok = array('product_stock.stock' => ($quantity[$i] + $stock->stock));
                    $this->db->where('product_stock.tble_id', $stock->tble_id);
                    $this->db->update('product_stock', $new_stok);
                } else {
                    //$stock = array('product_id' => $prods[$i], 'branch_id' => 1, 'stock' => ($quantity[$i] + $bonus[$i]));
                    $stock = array('product_id' => $prods[$i], 'branch_id' => 1, 'stock' => $quantity[$i]);
                    $this->db->insert('product_stock', $stock);
                }
            }
        }
        $this->db->insert('company_credit_adjustment', $credit_adjust);
        $v_id = $this->db->insert_id();
        $order_payment['op_vchr_id'] = $v_id;
        $this->db->insert('order_payment', $order_payment);
        
        $this->db->where('company_info.c_id', $c_credit['c_id']);
        $this->db->update('company_info', $c_credit);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $order_data['or_id'];
        }
    }
    
    public function receive_pending_stock($order, $items, $comps, $prods, $cartoon, $piece, $bonus, $quantity, $price, $entry_date, $user){
        $this->db->trans_begin();        
        for($i = 0; $i < count($items); $i++){
            if($quantity[$i] > 0){
                $array = array('oi_orid' => $order, 'oi_comp_id' => $comps[$i], 'oi_pid' => $prods[$i], 'oi_cartoon' => $cartoon[$i], 'oi_piece' => $piece[$i], 'oi_bonus' => $bonus[$i], 'oi_qty' => $quantity[$i], 'received_status' => 1, 'oi_total_price' => $price[$i], 'oi_entry_date' => $entry_date);
                $this->db->where('order_item.oi_id', $items[$i]);
                $this->db->update('order_item', $array);

                $oi_stock = array('oi_orid' => $order, 'oi_comp_id' => $comps[$i], 'oi_pid' => $prods[$i], 'oi_cartoon' => $cartoon[$i], 'oi_piece' => $piece[$i], 'oi_bonus' => $bonus[$i], 'oi_qty' => $quantity[$i], 'oi_total_price' => $price[$i], 'oi_entry_date' => $entry_date);
                $this->db->insert('order_stock', $oi_stock);

                $transfer_log = array('product_id' => $prods[$i], 'quantity' => $quantity[$i], 'source' => 100, 'destination' => 1, 'transfer_date' => $entry_date, 'transfer_by' => $user);
                $this->db->insert('product_transfer', $transfer_log);

                $this->db->select('*');
                $this->db->from('product_stock');
                $this->db->where('product_stock.product_id', $prods[$i]);
                $this->db->where('product_stock.branch_id', 1);
                $stock = $this->db->get();
                if($stock->num_rows() == 1){
                    $stock = $stock->row();
                    $new_stok = array('product_stock.stock' => ($quantity[$i] + $stock->stock));
                    $this->db->where('product_stock.tble_id', $stock->tble_id);
                    $this->db->update('product_stock', $new_stok);
                } else {
                    $stock = array('product_id' => $prods[$i], 'branch_id' => 1, 'stock' => $quantity[$i]);
                    $this->db->insert('product_stock', $stock);
                }
            }
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return $order;
        }
    }
    
    public function receive_company_order($order_data, $oi_id, $qenty, $bonus, $price, $prdct, $compa){
        $this->db->trans_begin();
        $this->db->where('order.or_id', $order_data['or_id']);
        $this->db->update('order', $order_data);
        for($i = 0; $i < count($oi_id); $i++){
            $order_item = array('oi_entry_date' => $order_data['or_rcv_date'], 'oi_qty' => $qenty[$i], 'oi_bonus' => $bonus[$i], 'oi_total_price' => $price[$i] );
            $this->db->where('order_item.oi_id', $oi_id[$i]);
            $this->db->where('order_item.oi_orid', $order_data['or_id']);
            $this->db->update('order_item', $order_item);
            
            $order_stock = array('oi_orid' => $order_data['or_id'], 'oi_comp_id' => $compa, 'oi_pid' => $prdct[$i], 'oi_entry_date' => $order_data['or_rcv_date'], 'oi_qty' => $qenty[$i], 'oi_bonus' => $bonus[$i], 'oi_total_price' => $price[$i] );
            $this->db->insert('order_stock', $order_stock);
            
            $this->db->select('*');
            $this->db->from('product_stock');
            $this->db->where('product_stock.product_id', $prdct[$i]);
            $this->db->where('product_stock.branch_id', 1);
            $stock = $this->db->get();
            if($stock->num_rows() == 1){
                $stock = $stock->row();
                $new_stok = array('product_stock.stock' => ($qenty[$i] + $bonus[$i] + $stock->stock));
                $this->db->where('product_stock.tble_id', $stock->tble_id);
                $this->db->update('product_stock', $new_stok);
            } else {
                $stock = array('product_id' => $prdct[$i], 'branch_id' => 1, 'stock' => ($qenty[$i] + $bonus[$i]));
                $this->db->insert('product_stock', $stock);
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
    
    public function get_order_information($order){
        $this->db->select('order.or_id as or_id, order.or_company as or_company, order.or_date as or_date, (SELECT COUNT(`oi_pid`) FROM `dist_order_item` WHERE `dist_order_item`.`oi_orid`= or_id) AS Item, order.or_sub_total as SubTotal, order.or_discount as Discount, order.or_total as Total, (SELECT SUM(`op_amount`) FROM `dist_order_payment` WHERE `dist_order_payment`.`op_orid`= or_id) AS Paid, company_info.c_name as Supplier, company_info.c_address as SupplierAddress, company_info.c_phone as SupplierPhone, company_info.c_mobile as SupplierMobile, user_info.u_name as PurchasedBy');
        $this->db->from('order');
        $this->db->where('order.or_id', $order);
        $this->db->join('company_info', 'company_info.c_id = order.or_company', 'LEFT');
        $this->db->join('user_info', 'user_info.u_id = order.or_uid', 'LEFT');
        $order = $this->db->get();
        if($order->num_rows() == 1){
            return $order->row();
        } else {
            return FALSE;
        }
    }
    
    public function get_order_list($FilterData){
        $this->db->select('order.or_id as or_id, order.or_date as or_date, order.or_company as Company, order.or_status as Status, (SELECT COUNT(`oi_pid`) FROM `dist_order_item` WHERE `dist_order_item`.`oi_orid`= or_id) AS Item, order.or_total as Billed, (SELECT SUM(`op_amount`) FROM `dist_order_payment` WHERE `dist_order_payment`.`op_orid`= or_id) AS Paid, company_info.c_name as Supplier');
        $this->db->from('order');
        if(strlen($FilterData['supplier']) > 0) { $this->db->where('order.or_company', $FilterData['supplier']); }
        if(strlen($FilterData['or_comp_memo']) > 0) { $this->db->where('order.or_comp_memo', $FilterData['or_comp_memo']); }
        if(strlen($FilterData['start']) == 10) { $this->db->where('order.or_date >=', $FilterData['start']); }
        if(strlen($FilterData['finish']) == 10) { $this->db->where('order.or_date <=', $FilterData['finish']); }
        if(strlen($FilterData['status']) != "") { $this->db->where('order.or_status', $FilterData['status']); }
        $this->db->order_by('order.or_date', 'DESC');
        $this->db->order_by('order.or_id', 'DESC');
        $this->db->join('company_info', 'company_info.c_id = order.or_company', 'LEFT');
        $order_list = $this->db->get();
        if($order_list->num_rows() > 0){
            return $order_list;
        } else {
            return FALSE;
        }
    }
    
    public function get_pending_order_list(){
        $this->db->select('order.or_id as or_id, order.or_date as or_date, order.or_company as Company, order.or_status as Status, (SELECT COUNT(`oi_pid`) FROM `dist_order_item` WHERE `dist_order_item`.`oi_orid`= or_id) AS Item, order.or_total as Billed, (SELECT SUM(`op_amount`) FROM `dist_order_payment` WHERE `dist_order_payment`.`op_orid`= or_id) AS Paid, company_info.c_name as Supplier');
        $this->db->from('order');
        $this->db->where('order.or_pending', 1);
        $this->db->order_by('order.or_date', 'DESC');
        $this->db->order_by('order.or_id', 'DESC');
        $this->db->join('company_info', 'company_info.c_id = order.or_company', 'LEFT');
        $order_list = $this->db->get();
        $this->db->limit(15);
        if($order_list->num_rows() > 0){
            return $order_list;
        } else {
            return FALSE;
        }
    }
    
    public function set_payment_adjustment($order_payment_update, $voucher_update, $order_payment, $voucher_data){
        $this->db->trans_begin();
        $this->db->where('order_payment.op_id', $order_payment_update['op_id']);
        $this->db->update('order_payment', $order_payment_update);
        
        $this->db->where('voucher.tble_id', $voucher_update['tble_id']);
        $this->db->update('voucher', $voucher_update);
        
        $this->db->insert('voucher', $voucher_data);
        $v_id = $this->db->insert_id();
        
        $order_payment['op_vchr_id'] = $v_id;
        $this->db->insert('order_payment', $order_payment);
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function adjust_damage_credit($company_adjust, $batch){
        $this->db->trans_begin();
        $this->db->select('company_info.c_credit');
        $this->db->from('company_info');
        $this->db->where('company_info.c_id', $company_adjust['company']);
        $credit = $this->db->get();
        if($credit->num_rows() == 1){
            $credit = $credit->row();
            $c_credit = array('c_id' => $company_adjust['company'], 'c_credit' => ($credit->c_credit + $company_adjust['amount']));
            $this->db->where('company_info.c_id', $company_adjust['company']);
            $this->db->update('company_info', $c_credit);
            $this->db->insert('company_credit_adjustment', $company_adjust);
            
            $this->db->where('damage_batch.tble_id', $batch);
            $this->db->update('damage_batch', array('status' => 3));
            
            $this->db->where('damage_batch_item.batch_id', $batch);
            $this->db->update('damage_batch_item', array('received' => 2));
            
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                return FALSE;
            } else {
                $this->db->trans_commit();
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }


    public function get_return_batch_list($Filter_Data){
        $this->db->select('damage_batch.tble_id AS batch, damage_batch.batch_no AS batch_no, damage_batch.supplier_id AS Company, damage_batch.status,
            damage_batch.store_date AS Stored, damage_batch.submission_date AS Submitted, damage_batch.received_date AS Received,
            damage_batch.status AS Status, company_info.c_name AS Supplier, damage_batch.branch_id AS branch,
            (SELECT COUNT('. $this->db->dbprefix .'damage_batch_item.tble_id) FROM '. $this->db->dbprefix .'damage_batch_item WHERE '. $this->db->dbprefix .'damage_batch_item.batch_id=batch) AS Item,
            (SELECT SUM('. $this->db->dbprefix .'damage_batch_item.quantity * '. $this->db->dbprefix .'damage_batch_item.rates) FROM '. $this->db->dbprefix .'damage_batch_item WHERE '. $this->db->dbprefix .'damage_batch_item.batch_id=batch) AS TotalPrice');
        $this->db->from('damage_batch');
        if(strlen($Filter_Data['batch_no']) > 0 ){
            $this->db->where('damage_batch.batch_no', $Filter_Data['batch_no']);
        }
        if(strlen($Filter_Data['supplier_id']) > 0 ){
            $this->db->where('damage_batch.supplier_id', $Filter_Data['supplier_id']);
        }
        if(strlen($Filter_Data['status']) > 0 ){
            $this->db->where('damage_batch.status', $Filter_Data['status']);
        }
        if(strlen($Filter_Data['branch_id']) > 0 ){
            $this->db->where('damage_batch.branch_id', $Filter_Data['branch_id']);
        }
        $this->db->order_by('damage_batch.store_date', 'DESC');
        $this->db->join('company_info', 'company_info.c_id = damage_batch.supplier_id', 'LEFT');
        $batch = $this->db->get();
        if($batch->num_rows() > 0){
            return $batch;
        } else {
            return FALSE;
        }
    }

    public function create_new_return_batch($batch_data){
        if($this->db->insert('damage_batch', $batch_data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function enter_new_return_item($damage, $product_id, $supplier_id, $quantity, $rates, $notes, $branch_id, $current_stock){
        $this->db->trans_begin();
        for($i = 0; $i < count($product_id); $i++){
            if($quantity[$i] > 0){
                $item = array('batch_id' => $damage, 'product_id' => $product_id[$i], 'supplier_id' => $supplier_id, 'quantity' => $quantity[$i], 'rates' => $rates[$i], 'notes' => $notes[$i], 'received' => 1, 'added' => date('Y-m-d'));
                $this->db->insert('damage_batch_item', $item);
                
                $up = $current_stock[$i] - $quantity[$i];
                
                $this->db->where('product_stock.product_id', $product_id[$i]);
                $this->db->where('product_stock.branch_id', $branch_id);
                $this->db->update('product_stock', array('stock' => $up));
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
    
    public function return_details($damage){
        $this->db->select('*');
        $this->db->from('damage_batch');
        $this->db->where('damage_batch.tble_id', $damage);
        $batch = $this->db->get();
        if($batch->num_rows() == 1){
            return $batch->row();
        } else {
            return FALSE;
        }
    }
    
    public function return_items($damage){
        $this->db->select('damage_batch_item.tble_id, damage_batch_item.batch_id, damage_batch_item.product_id AS p_id, damage_batch_item.rates, damage_batch_item.supplier_id, damage_batch_item.quantity, damage_batch_item.notes, damage_batch_item.received, damage_batch_item.added, products_name.p_name AS Product, products_name.p_purchse_price AS Purchase, products_name.p_stock_price AS StockPrice, products_name.p_box_qty AS Cartoon, (SELECT SUM(' . $this->db->dbprefix . 'product_stock.stock) FROM ' . $this->db->dbprefix . 'product_stock WHERE ' . $this->db->dbprefix . 'product_stock.product_id=p_id AND ' . $this->db->dbprefix . 'product_stock.branch_id=1) AS Central');
        $this->db->from('damage_batch_item');
        $this->db->where('damage_batch_item.batch_id', $damage);
        $this->db->join('products_name', 'products_name.p_id = damage_batch_item.product_id', 'LEFT');
        $items = $this->db->get();
        if($items->num_rows() > 0){
            return $items;
        } else {
            return FALSE;
        }
    }
    
    public function return_to_stock($Damage_Item, $product_stock){
        $this->db->trans_begin();
        $this->db->where('damage_batch_item.tble_id', $Damage_Item['tble_id']);
        $this->db->update('damage_batch_item', $Damage_Item);
        
        $this->db->where('product_stock.product_id', $product_stock['product_id']);
        $this->db->where('product_stock.branch_id', $product_stock['branch_id']);
        $this->db->update('product_stock', $product_stock);
        
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function filter_products_stock($FilterData){
        if(strlen($FilterData['branch']) > 0) {
            $this->db->select('products_name.p_id, products_name.p_name, products_group.mg_name, company_info.c_name,
                products_name.p_box_qty, products_name.p_box_bonus, products_name.p_stock_price,
                (SELECT SUM(dist_product_stock.stock) FROM dist_product_stock WHERE dist_product_stock.product_id=p_id AND dist_product_stock.branch_id=' . $FilterData['branch'] . ') AS p_stok');
        } else {
            $this->db->select('products_name.p_id, products_name.p_name, products_group.mg_name, company_info.c_name,
                products_name.p_box_qty, products_name.p_box_bonus, products_name.p_stock_price,
                (SELECT SUM(dist_product_stock.stock) FROM dist_product_stock WHERE dist_product_stock.product_id=p_id) AS p_stok');
        }
        $this->db->from('products_name');
        if(strlen($FilterData['p_sku']) > 0){
            $this->db->like('products_name.p_name', $FilterData['p_sku']);
        }
        if(strlen($FilterData['p_cid']) > 0){
            $this->db->where('products_name.p_cid', $FilterData['p_cid']);
        }
        $this->db->order_by('products_name.p_name', 'ASC');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid', 'LEFT');
        $this->db->join('company_info', 'company_info.c_id = products_name.p_cid', 'LEFT');
        $products = $this->db->get();
        if($products->num_rows() > 0){
            return $products;
        } else {
            return FALSE;
        }
    }
    
    public function filter_stock_closing($FilterData){
            $this->db->select('products_name.p_id, products_name.p_name, products_group.mg_name, company_info.c_name,
                products_name.p_box_qty, products_name.p_box_bonus, product_stock_closing.*');
        $this->db->from('product_stock_closing');
        $this->db->where('product_stock_closing.branch_id', $FilterData['branch']);
        if($FilterData['supplier'] != ""){
            $this->db->where('product_stock_closing.supplier_id', $FilterData['supplier']);
        }
        $this->db->where('product_stock_closing.closedon', $FilterData['cldate']);
        $this->db->order_by('products_name.p_name', 'ASC');
        $this->db->join('products_name', 'products_name.p_id = product_stock_closing.product_id', 'LEFT');
        $this->db->join('products_group', 'products_group.mg_id = product_stock_closing.group_id', 'LEFT');
        $this->db->join('company_info', 'company_info.c_id = product_stock_closing.supplier_id', 'LEFT');
        $this->db->group_by('product_stock_closing.product_id');
        $products = $this->db->get();
        if($products->num_rows() > 0){
            return $products;
        } else {
            return FALSE;
        }
    }
    
    public function delete_return_batch($batch){
        $this->db->trans_begin();
        $this->db->where('damage_batch.tble_id', $batch);
        $this->db->delete('damage_batch');
        $this->db->where('damage_batch_item.batch_id', $batch);
        $this->db->delete('damage_batch_item');
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        } 
    }
    
    public function update_return_batch_status($batch_info){
        $this->db->trans_begin();
        $this->db->where('damage_batch.tble_id', $batch_info['tble_id']);
        $this->db->update('damage_batch', $batch_info);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        } 
    }
    
    public function get_supplier_balance($comp){
        $this->db->select('company_info.c_credit');
        $this->db->from('company_info');
        $this->db->where('company_info.c_id', $comp);
        $total = $this->db->get();
        if($total->num_rows() == 1){
            $total = $total->row();
            return $total->c_credit;
        } else {
            return 0;
        }
    }
    
    public function get_order_total($orid){
        $this->db->select('order.or_total');
        $this->db->from('order');
        $this->db->where('order.or_id', $orid);
        $total = $this->db->get();
        if($total->num_rows() == 1){
            $total = $total->row();
            return $total->or_total;
        } else {
            return 0;
        }
    }
    
    public function update_emergency_stock($supplier, $branch_id, $product_id, $cartoon, $piece, $total, $user){
        $this->db->trans_begin();
        
        for($i = 0; $i < count($product_id); $i++){
            if($total[$i] != 0){
                $emergency = array('supplier_id' => $supplier, 'branch_id' => $branch_id, 'product_id' => $product_id[$i], 'cartoon' => $cartoon[$i], 'piece' => $piece[$i], 'total' => $total[$i], 'posting_date' => date('Y-m-d'), 'posting_by' => $user);
                $this->db->insert('emergency_stok', $emergency);
                
                $transfer_log = array('product_id' => $product_id[$i], 'quantity' => $total[$i], 'source' => 200, 'destination' => $branch_id, 'transfer_date' => date('Y-m-d'), 'transfer_by' => $user);
                $this->db->insert('product_transfer', $transfer_log);
            }
            
            $this->db->select('*');
            $this->db->from('product_stock');
            $this->db->where('product_stock.product_id', $product_id[$i]);
            $this->db->where('product_stock.branch_id', $branch_id);
            $stock = $this->db->get();
            if($stock->num_rows() == 1 && $total[$i] != 0){
                $stock = $stock->row();
                $new_stok = array('product_stock.stock' => ($total[$i] + $stock->stock));
                $this->db->where('product_stock.product_id', $product_id[$i]);
                $this->db->where('product_stock.branch_id', $branch_id);
                $this->db->update('product_stock', $new_stok);
            } else {
                //$stock = array('product_id' => $product_id[$i], 'branch_id' => $branch_id, 'stock' => ($total[$i]));
                //$this->db->insert('product_stock', $stock);
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
    
    public function get_product_history($FilterData){
        $this->db->select('SUM(`dist_order_item`.`oi_qty`) AS Quantity, SUM(`dist_invoice_item`.`it_qty`) AS Soldqty,
            company_info.c_name,
            products_name.p_sku,
            products_name.p_name,
            products_name.p_stok,
            products_group.mg_name');
        $this->db->from('order_item');
        if(strlen($FilterData['start']) == 10){
            $this->db->where('order_item.oi_entry_date >=', $FilterData['start']);
        }
        if(strlen($FilterData['finish']) == 10){
            $this->db->where('order_item.oi_entry_date <=', $FilterData['finish']);
        }
        if(strlen($FilterData['supplier']) > 0){
            $this->db->where('order_item.oi_comp_id', $FilterData['supplier']);
        }
        $this->db->order_by('products_name.p_name', 'ASC');
        $this->db->group_by('order_item.oi_pid');
        $this->db->join('company_info', 'company_info.c_id = order_item.oi_comp_id', 'LEFT');
        $this->db->join('products_name', 'products_name.p_id = order_item.oi_pid', 'LEFT');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid', 'LEFT');
        $this->db->join('invoice_item', 'invoice_item.it_pro_id = order_item.oi_pid', 'LEFT');
        $history = $this->db->get();
        if($history->num_rows() > 0){
            return $history;
        } else {
            return FALSE;
        }
    }
    
    public function get_supplier_purchase_history($FilterData){
        $this->db->select(
                'order.or_id as or_id,                
                SUM(dist_order.or_total) as Billed,
                (SELECT SUM(`op_amount`) FROM `dist_order_payment` WHERE `dist_order_payment`.`op_orid`= or_id) AS Paid,
                company_info.c_name as Supplier');
        $this->db->from('order');
        if(strlen($FilterData['supplier'] > 0)) { $this->db->where('order.or_company', $FilterData['supplier']); }
        if(strlen($FilterData['start'] == 10)) { $this->db->where('order.or_date >=', $FilterData['start']); }
        if(strlen($FilterData['finish'] == 10)) { $this->db->where('order.or_date <=', $FilterData['finish']); }
        $this->db->order_by('company_info.c_name', 'ASC');
        $this->db->join('company_info', 'company_info.c_id = order.or_company', 'LEFT');
        $this->db->group_by('order.or_company');
        $order_list = $this->db->get();
        if($order_list->num_rows() > 0){
            return $order_list;
        } else {
            return FALSE;
        }
    }
    
    public function get_paid_amount_purchase_history($comp, $start, $finish){
        $score = $this->db->query('SELECT SUM(`dist_order_payment`.`op_amount`) FROM `dist_order_payment` WHERE `dist_order_payment`.`op_or_company`=' . $comp . ' AND `dist_order_payment`.`op_date` >= ' . $start . ' AND `dist_order_payment`.`op_date` <= ' . $finish . '');
        $score = $score->row();
        return $score->op_amount;
        
    }

    public function add_new_purchase_order($order_data, $oi_pid, $oi_psku, $oi_qty, $oi_stok, $oi_u_price, $oi_price){
        $this->db->trans_begin();
        $this->db->insert('order', $order_data);
        $or_id  = $this->db->insert_id();
        for($i = 0; $i < count($oi_pid); $i++){
            $items = array('oi_orid' => $or_id, 'oi_comp_id' => $order_data['or_company'], 'or_item_type' => $order_data['or_item_type'], 'oi_pid' => $oi_pid[$i], 'oi_psku' => $oi_psku[$i], 'oi_entry_date' => $order_data['or_date'], 'oi_qty' => $oi_qty[$i], 'oi_u_price' => $oi_u_price[$i], 'oi_price' => $oi_price[$i]);
            $this->db->insert('order_item', $items);
            $this->db->where('products_name.p_id', $oi_pid[$i]);
            $this->db->where('products_name.p_sku', $oi_psku[$i]);
            $this->db->update('products_name', array('p_stok' => ($oi_stok[$i] + $oi_qty[$i])));
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
//    public function get_order_items($order){
//        $this->db->select('products_name.p_name, order_item.oi_psku, order_item.oi_qty, order_item.oi_price');
//        $this->db->from('order_item');
//        $this->db->where('order_item.oi_orid', $order);
//        $this->db->join('products_name', 'products_name.p_id = order_item.oi_pid', 'LEFT');
//        $items = $this->db->get();
//        if($items->num_rows() > 0){
//            return $items;
//        } else {
//            return FALSE;
//        }
//    }
//    
//    public function get_order_items_details($order){
//        $this->db->select('order_item.oi_id, order_item.oi_psku, order_item.oi_pid, order_item.oi_u_price, company_info.c_name, products_name.p_name, products_name.p_stok, products_group.mg_name, order_item.oi_qty, order_item.oi_price');
//        $this->db->from('order_item');
//        $this->db->where('order_item.oi_orid', $order);
//        $this->db->join('products_name', 'products_name.p_id = order_item.oi_pid', 'LEFT');
//        $this->db->join('products_group', 'products_group.mg_id = products_name.p_id', 'LEFT'); 
//        $this->db->join('company_info', 'company_info.c_id = order_item.oi_comp_id', 'LEFT'); 
//        $items = $this->db->get();
//        if($items->num_rows() > 0){
//            return $items;
//        } else {
//            return FALSE;
//        }
//    }
    
    public function get_order_payment_details($order){
        $this->db->select('order_payment.op_id, order_payment.op_orid, order_payment.op_vchr_id, order_payment.op_bank_vchr_id, order_payment.op_date, order_payment.op_payment_method, user_info.u_name, order_payment.op_amount');
        $this->db->from('order_payment');
        $this->db->where('order_payment.op_orid', $order);
        $this->db->join('user_info', 'user_info.u_id = order_payment.op_post_by', 'LEFT');
        $payment = $this->db->get();
        if($payment->num_rows() > 0){
            return $payment;
        } else {
            return FALSE;
        }
    }
    
    public function order_payment($order_data, $order_payment, $voucher_data, $bank_voucher, $bank_account){
        $order_payment['op_bank_vchr_id']   = 0;
        $this->db->trans_begin();
        $this->db->where('order.or_id', $order_data['or_id']);
        $this->db->update('order', $order_data);
        $this->db->insert('voucher', $voucher_data);
        $op_vchr_id = $this->db->insert_id();
        $order_payment['op_vchr_id']    = $op_vchr_id;
        if($bank_voucher != NULL && $bank_account != NULL){ 
            $bank_voucher['voucher_tble_id'] = $op_vchr_id;
            $this->db->insert('bank_voucher', $bank_voucher);
            $order_payment['op_bank_vchr_id']   = $this->db->insert_id();
            $this->db->where('bank_account.tble_id', $bank_account['tble_id']);
            $this->db->update('bank_account', $bank_account);
        }
        $this->db->insert('order_payment', $order_payment);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function update_order_payment($order_update, $order_payment, $order_payment_update, $voucher_data, $voucher_update, $bank_voucher, $bank_voucher_update, $first_bank, $bank_account){
        $this->db->trans_begin();
        $this->db->insert('order_update', $order_update);
        $this->db->where('order_payment.op_id', $order_payment['op_id']);
        $this->db->update('order_payment', $order_payment);
        $this->db->insert('order_payment_update', $order_payment_update);
        $this->db->where('voucher.tble_id', $voucher_data['tble_id']);
        $this->db->update('voucher', $voucher_data);
        $this->db->insert('voucher_update', $voucher_update);
        $this->db->where('bank_account.tble_id', $first_bank['tble_id']);
        $this->db->update('bank_account', array('account_balance' => $first_bank['account_balance']) );
        $this->db->where('bank_voucher.tble_id', $bank_voucher['tble_id']);
        $this->db->update('bank_voucher', $bank_voucher);
        $this->db->insert('bank_voucher_update', $bank_voucher_update);
        $this->db->where('bank_account.tble_id', $bank_account['tble_id']);
        $this->db->update('bank_account', array('account_balance' => $bank_account['account_balance'] ) );
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function update_order_payment_with_bank($order_update, $order_payment, $order_payment_update, $voucher_data, $voucher_update, $bank_voucher, $bank_account){
        $this->db->trans_begin();
        $this->db->insert('bank_voucher', $bank_voucher);
        $op_bank_vchr_id = $this->db->insert_id();
        $order_payment['op_bank_vchr_id']   = $op_bank_vchr_id;
        
        $this->db->where('bank_account.tble_id', $bank_account['tble_id']);
        $this->db->update('bank_account', array('account_balance' => $bank_account['account_balance']));
        
        $this->db->where('order_payment.op_id', $order_payment['op_id']);
        $this->db->update('order_payment', $order_payment);
        
        $this->db->insert('order_payment_update', $order_payment_update);
        
        $this->db->insert('order_update', $order_update);
        
        $this->db->where('voucher.tble_id', $voucher_data['tble_id']);
        $this->db->update('voucher', $voucher_data);
        
        $this->db->insert('voucher_update', $voucher_update);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function update_order_payment_without_bank($order_update, $order_payment, $order_payment_update, $voucher_data, $voucher_update, $bank_voucher, $bank_voucher_update, $bank_account){
        $this->db->trans_begin();
        $this->db->where('bank_voucher.tble_id', $bank_voucher['tble_id']);
        $this->db->update('bank_voucher', $bank_voucher);
        $order_payment['op_bank_vchr_id']   = 0;
        
        $this->db->insert('bank_voucher_update', $bank_voucher_update);
        
        $this->db->where('bank_account.tble_id', $bank_account['tble_id']);
        $this->db->update('bank_account', array('account_balance' => $bank_account['account_balance']));
        
        $this->db->where('order_payment.op_id', $order_payment['op_id']);
        $this->db->update('order_payment', $order_payment);
        
        $this->db->insert('order_payment_update', $order_payment_update);
        
        $this->db->insert('order_update', $order_update);
        
        $this->db->where('voucher.tble_id', $voucher_data['tble_id']);
        $this->db->update('voucher', $voucher_data);
        
        $this->db->insert('voucher_update', $voucher_update);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function update_purchase_order_info($order_data, $order_update, $oi_id, $oi_qty, $oi_u_price, $oi_price, $item_update, $oi_pid, $oi_current){
        $this->db->trans_begin();
        $this->db->where('order.or_id', $order_data['or_id']);
        $this->db->update('order', $order_data);
        $this->db->insert('order_update', $order_update);
        for($i = 0; $i < count($oi_id); $i++){
            $items = array('oi_qty' => $oi_qty[$i], 'oi_u_price' => $oi_u_price[$i], 'oi_price' => $oi_price[$i]);
            $this->db->where('order_item.oi_id', $oi_id[$i]);
            $this->db->update('order_item', $items);
            $item_update['order_item_id'] = $oi_id[$i];
            $this->db->insert('order_item_update', $item_update);
            $this->db->where('products_name.p_id', $oi_pid[$i]);
            $this->db->update('products_name', array('p_stok' => $oi_current[$i]));
        }
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function get_stok_list($supplier = FALSE){
        $this->db->select('products_name.p_sku, products_name.p_name, products_group.mg_name, products_name.p_stok');
        $this->db->from('products_name');
        if($supplier != FALSE) { $this->db->where('products_name.p_cid', $supplier); }
        $this->db->order_by('products_name.p_name', 'ASC');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid', 'LEFT');
        $stok = $this->db->get();
        if($stok->num_rows() > 0){
            return $stok;
        } else {
            return FALSE;
        }
    }
    
    public function get_pro_stock_transfer($b_id, $s_id = FALSE){
        $this->db->select('product_stock.product_id AS p_id, products_name.p_name, products_name.p_box_qty, products_name.p_box_bonus, company_info.c_name, product_stock.stock, products_group.mg_name');
        $this->db->from('product_stock');
        $this->db->where('product_stock.branch_id', $b_id);
        if($s_id != FALSE){
            $this->db->where('products_name.p_cid', $s_id);
        }
        $this->db->order_by('products_name.p_name', 'ASC');
        $this->db->join('products_name', 'products_name.p_id = product_stock.product_id', 'LEFT');
        $this->db->join('company_info', 'company_info.c_id = products_name.p_cid', 'LEFT');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid', 'LEFT');
        $stok = $this->db->get();
        if($stok->num_rows() > 0){
            return $stok;
        } else {
            return FALSE;
        }
    }
    
    public function transfer_stock($source, $products, $quantity, $p_stock, $destination, $user){
        $this->db->trans_begin();
        for($i = 0; $i < count($products); $i++){
            $this->db->select('product_stock.tble_id, product_stock.stock');
            $this->db->from('product_stock');
            $this->db->where('product_stock.branch_id', $destination);
            $this->db->where('product_stock.product_id', $products[$i]);
            $stock = $this->db->get();
            if($stock->num_rows() > 0){
                $current = $stock->row();
                $value = $quantity[$i] + $current->stock;
                $this->db->where('product_stock.branch_id', $destination);
                $this->db->where('product_stock.product_id', $products[$i]);
                $this->db->update('product_stock', array('stock' => $value));
                $uvalue = $p_stock[$i] - $quantity[$i];
                $this->db->where('product_stock.branch_id', $source);
                $this->db->where('product_stock.product_id', $products[$i]);
                $this->db->update('product_stock', array('stock' => $uvalue));
                
                if($quantity[$i] > 0){
                    $transfer_log = array('product_id' => $products[$i], 'quantity' => $quantity[$i], 'source' => $source, 'destination' => $destination, 'transfer_date' => date('Y-m-d'), 'transfer_by' => $user);
                    $this->db->insert('product_transfer', $transfer_log);
                }
            } else {
                $data   = array('product_id' => $products[$i], 'branch_id' => $destination, 'stock' => $quantity[$i]);
                $this->db->insert('product_stock', $data);
                $uvalue = $p_stock[$i] - $quantity[$i];
                $this->db->where('product_stock.branch_id', $source);
                $this->db->where('product_stock.product_id', $products[$i]);
                $this->db->update('product_stock', array('stock' => $uvalue));
                
                if($quantity[$i] > 0){
                    $transfer_log = array('product_id' => $products[$i], 'quantity' => $quantity[$i], 'source' => $source, 'destination' => $destination, 'transfer_date' => date('Y-m-d'), 'transfer_by' => $user);
                    $this->db->insert('product_transfer', $transfer_log);
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
    
    public function get_stock_transfer_report($Filter_Data){
        $this->db->trans_begin();
//        $this->db->select('dist_product_transfer.product_id AS product, products_name.p_name AS Name, company_info.c_name AS Supplier,
//            products_name.p_box_qty AS Cartoon, (SELECT SUM(`dist_product_transfer`.`quantity`) FROM `dist_product_transfer` WHERE `dist_product_transfer`.`product_id` = product_id) AS Amount');
        $this->db->select('products_name.p_id AS Product, products_name.p_name AS Name, products_name.p_box_qty AS Cartoon, company_info.c_name AS Supplier');
//        if(strlen($Filter_Data['destination']) > 0){
//            $this->db->where('product_transfer.destination', $Filter_Data['destination']);
//        }
        $this->db->from('products_name');
        $this->db->order_by('products_name.p_name', 'ASC');
        //$this->db->join('products_name', 'products_name.p_id = product_transfer.product_id', 'LEFT');
        $this->db->join('company_info', 'company_info.c_id = products_name.p_cid', 'LEFT');
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows() > 0){
            return $query;
        } else {
            return FALSE;
        }
    }
    
    public function get_transfer_quantity($product, $start, $end, $source, $destination)
    {
        $this->db->select('SUM(dist_product_transfer.quantity) AS Amount');
        $this->db->from('product_transfer');
        $this->db->where('product_transfer.product_id', $product);
        $this->db->where('product_transfer.transfer_date >=', $start);
        $this->db->where('product_transfer.transfer_date <=', $end);
        $this->db->where('product_transfer.source', $source);
        $this->db->where('product_transfer.destination', $destination);
        $amount = $this->db->get();
        if($amount->num_rows() > 0){
            $amount = $amount->row();
            return $amount->Amount;
        }else {
            return 0;
        }
    }
    
    public function get_stock_transaction($FilterData){
        $this->db->select('product_stock_closing.product_id AS Product, products_name.p_name AS Name, products_name.p_box_qty AS Quantity, company_info.c_name AS Supplier, product_stock_closing.stock AS OpeningStock, product_stock_closing.boxqty AS OpeningBox,
            (SELECT ' . $this->db->dbprefix . 'product_stock.stock FROM ' . $this->db->dbprefix . 'product_stock WHERE ' . $this->db->dbprefix . 'product_stock.product_id = Product AND ' . $this->db->dbprefix . 'product_stock.branch_id = "' . $FilterData['p_sku'] . '") AS Balance');
            //(SELECT SUM(`dist_order_stock`.`oi_qty`) FROM `dist_order_stock` WHERE `dist_order_stock`.`oi_pid` = Product AND `dist_order_stock`.`oi_entry_date` >= '. $FilterData['start'] .' AND `dist_order_stock`.`oi_entry_date` <= '. $FilterData['finish'] .') AS Stockin,
            //(SELECT SUM(`dist_invoice_item`.`quantity`) FROM `dist_invoice_item` WHERE `dist_invoice_item`.`product_id` = Product AND `dist_invoice_item`.`sale_date` >= '. $FilterData['start'] .' AND `dist_invoice_item`.`sale_date` <= '. $FilterData['finish'] .') AS Stockout');
//        $this->db->select('products_name.p_id AS p_id, products_name.p_name AS p_name, company_info.c_name AS supplier, (SELECT )
//            (SELECT SUM(' . $this->db->dbprefix . 'order_stock.oi_qty + ' . $this->db->dbprefix . 'order_stock.oi_bonus)  FROM ' . $this->db->dbprefix . 'order_stock WHERE ' . $this->db->dbprefix . 'order_stock.oi_pid = p_id AND ' . $this->db->dbprefix . 'order_stock.oi_entry_date>="' . $FilterData['start'] . '" AND ' . $this->db->dbprefix . 'order_stock.oi_entry_date<="' . $FilterData['finish'] . '") AS Stockin,
//            (SELECT SUM(' . $this->db->dbprefix . 'invoice_item.quantity) FROM ' . $this->db->dbprefix . 'invoice_item WHERE ' . $this->db->dbprefix . 'invoice_item.product_id = p_id AND ' . $this->db->dbprefix . 'invoice_item.sale_date>="' . $FilterData['start'] . '" AND ' . $this->db->dbprefix . 'invoice_item.sale_date<="' . $FilterData['finish'] . '") AS Stockout,
//            (SELECT SUM(' . $this->db->dbprefix . 'product_stock.stock)  FROM ' . $this->db->dbprefix . 'product_stock WHERE ' . $this->db->dbprefix . 'product_stock.product_id = p_id) AS Balance');
        $this->db->from('product_stock_closing');
        //if($FilterData['p_sku'] > 0) {
        $this->db->where('product_stock_closing.branch_id', $FilterData['p_sku']);
        //}
        if($FilterData['p_cid'] > 0) {
            $this->db->where('product_stock_closing.supplier_id', $FilterData['p_cid']);
        }
        $this->db->where('product_stock_closing.closedon', $FilterData['opening']);
//        if(strlen($FilterData['p_sku']) > 1) {
//            $this->db->where('products_name.p_sku', $FilterData['p_sku']);
//        }
        $this->db->join('products_name', 'products_name.p_id = product_stock_closing.product_id', 'LEFT');
        $this->db->join('company_info', 'company_info.c_id = product_stock_closing.supplier_id', 'LEFT');
        $this->db->order_by('products_name.p_name', 'ASC');
        $stock = $this->db->get();
        //echo $this->db->last_query();
        if($stock->num_rows() > 0){
            return $stock;
        } else {
            return FALSE;
        }
    }
    
    public function get_product_stockin($start, $finish, $product, $branch){
        $this->db->select_sum('product_transfer.quantity');
        $this->db->from('product_transfer');
        $this->db->where('product_transfer.product_id', $product);
        $this->db->where('product_transfer.destination', $branch);
        $this->db->where('product_transfer.transfer_date >=', $start);
        $this->db->where('product_transfer.transfer_date <=', $finish);
        $StockIn = $this->db->get()->row();
        return (int)$StockIn->quantity;
    }
    
    public function get_product_soldout($start, $finish, $product, $branch){
        $this->db->select_sum('invoice_item.quantity');
        $this->db->from('invoice_item');
        $this->db->where('invoice_item.product_id', $product);
        $this->db->where('invoice_item.branch_id', $branch);
        $this->db->where('invoice_item.sale_date >=', $start);
        $this->db->where('invoice_item.sale_date <=', $finish);
        $StockIn = $this->db->get()->row();
        return (int)$StockIn->quantity;
    }
    
    public function get_product_trnsout($start, $finish, $product, $branch){
        //Branch to Branch transfer
        $this->db->select_sum('product_transfer.quantity');
        $this->db->from('product_transfer');
        $this->db->where('product_transfer.product_id', $product);
        $this->db->where('product_transfer.source', $branch);
        $this->db->where('product_transfer.transfer_date >=', $start);
        $this->db->where('product_transfer.transfer_date <=', $finish);
        $StockIn = $this->db->get()->row();
        return (int)$StockIn->quantity;
    }
    
    public function daily_stock_closing($user, $date, $branch){
        $score = $this->check_existing_closing($date, $branch);
        if($score){
            $this->db->trans_begin();
            $this->db->select('product_stock.product_id, product_stock.branch_id, product_stock.stock, products_name.p_stock_price, products_name.p_cid, products_name.p_gid, products_name.p_box_qty as boxqty');
            $this->db->from('product_stock');
            $this->db->where('product_stock.branch_id', $branch);
            $this->db->join('products_name', 'products_name.p_id = product_stock.product_id', 'LEFT');
            $stock = $this->db->get();
            if($stock->num_rows() > 0){
                foreach($stock->result() as $stock){
                    $array = array('product_id' => $stock->product_id, 'group_id' => $stock->p_gid, 'supplier_id' => $stock->p_cid, 'branch_id' => $branch, 'stock' => $stock->stock, 'price' => $stock->p_stock_price, 'boxqty' => $stock->boxqty, 'closedby' => $user, 'closedon' => $date);
                    $this->db->insert('product_stock_closing', $array);   
                }
                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    return FALSE;
                } else {
                    $this->db->trans_commit();
                    return TRUE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }
    
    public function check_existing_closing($date, $branch){
        $this->db->select('*');
        $this->db->from('product_stock_closing');
        $this->db->where('product_stock_closing.branch_id', $branch);
        $this->db->where('product_stock_closing.closedon', $date);
        $stock = $this->db->get();
        if($stock->num_rows() > 0){
            return FALSE;
        } else {
            return TRUE;
        }
    }




















































































































//    public function getOrderListOfTodayAndYesterday($stat, $limit = FALSE){
//        $this->db->select('order.or_id as id, order.or_date as date, order.or_time as time, order.or_total as total, order.or_discount as dis, order.or_sub as net, order.or_status as status, company_info.c_name as company, user_info.u_name as salesman, (SELECT SUM(`op_amount`) FROM `dist_order_payment` WHERE `op_orid` = id) as paid, (SELECT COUNT(`oi_mid`) FROM `dist_order_item` WHERE `oi_orid` = id) as totalitem');
//        $this->db->from('order');
//        $this->db->join('company_info', 'company_info.c_id = order.or_company', 'left');
//        $this->db->join('user_info', 'user_info.u_id = order.or_uid', 'left');
//        $this->db->where('order.or_status', $stat);
//        if($limit != FALSE) { $this->db->limit($limit); }
//        $this->db->order_by('order.or_date', 'DESC');
//        $this->db->order_by('order.or_id', 'ASC');
//        $this->db->order_by('company_info.c_name', 'ASC');
//        $comp = $this->db->get();
//        if($comp->num_rows() > 0){
//            return $comp;
//        }
//        else{
//            return FALSE;
//        }
//    }
//    
//    public function getFilteredOrderListToDisplay($FilterKey){
//        $this->db->select('order.or_id as id, user_info.u_name as user, company_agent.ca_name as agent, company_info.c_name as company, order.or_date as date, order.or_time as time, order.or_total as total, order.or_discount as dis, order.or_sub as net, order.or_status as status, user_info.u_name as salesman, (SELECT SUM(`op_amount`) FROM `dist_order_payment` WHERE `op_orid` = id) as paid, (SELECT COUNT(`oi_mid`) FROM `dist_order_item` WHERE `oi_orid` = id) as totalitem');
//        $this->db->from('order');
//        $this->db->join('user_info', 'order.or_uid = user_info.u_id');
//        $this->db->join('company_info','company_info.c_id= order.or_company','left');
//        $this->db->join('company_agent','company_agent.ca_id= order.or_agent','left');
//        if(strlen($FilterKey['fromDate']) > 0){
//            $this->db->where('order.or_date >=', $FilterKey['fromDate']);
//        }
//        if(strlen($FilterKey['toDate']) > 0){
//            $this->db->where('order.or_date <=', $FilterKey['toDate']);
//        }
//        if(strlen($FilterKey['company']) > 0){
//            $this->db->where('order.or_company', $FilterKey['company']);
//        }
//        if(strlen($FilterKey['status']) > 0){
//            $this->db->where('order.or_status', $FilterKey['status']);
//        }
//        $this->db->order_by('order.or_date','asc');
//        $comp = $this->db->get();
//        if($comp->num_rows() > 0){
//            return $comp;
//        }
//        else{
//            return FALSE;
//        }
//    }
//    
//    public function GetCompMed($CompId){
//        $this->db->select('m_id as id, m_name as name');
//        $this->db->from("medicine_name");
//        $this->db->where('m_cid', $CompId);
//        return $this->db->get()->result();
//    }
//    
//    public function GetCompAgents($CompId=FALSE){
//        $this->db->select('ca_id as id, ca_name as name ');
//        $this->db->from("company_agent");
//        if($CompId!=FALSE){
//             $this->db->where('ca_cid',$CompId);
//        }
//       
//        return $this->db->get()->result();
//    }   
//
//    public function GetMedDetails($medId){
//         $this->db->select('medicine_name.m_id as id,medicine_name.m_name as name,company_info.c_name as company,medicine_group.mg_name as grp,
//         medicine_type.mt_name as type ');
//        $this->db->from('medicine_name');
//        $this->db->join('company_info', 'company_info.c_id = medicine_name`.m_cid','left');
//        $this->db->join('medicine_group', 'medicine_group.mg_id = medicine_name.m_gid');
//        $this->db->join('medicine_type', 'medicine_type.mt_id = medicine_name.m_tid');
//        $this->db->where("medicine_name.m_id",$medId);
//        return $this->db->get()->result();
//    }
//    
//    
//    
//    public function DeleteQueue($mid){
//        $this->db->delete('order_queue', array('oq_mid'=>$mid));
//    }
//
//    public function SetOrderPayment($orderpayment){
//        $this->db->insert('order_payment', $orderpayment);
//    }
//    
//    public function order_payment_from_details($orderpayment, $cashout_table_data){
//        $this->db->trans_begin();
//        $this->db->insert('order_payment', $orderpayment);
//        $this->db->insert('voucher', $cashout_table_data);
//        if($this->db->trans_status() === FALSE){
//            $this->db->trans_rollback();
//            return FALSE;
//        } else {
//            $this->db->trans_commit();
//            return TRUE;
//        }
//    }
//
//    
//    
//    public function CountAllOrder(){
//         return $this->db->count_all_results('order');
//    }
//    
//    public function getSupplierListForOrderController(){
//        $this->db->select('*');
//        $this->db->from('company_info');
//        $this->db->order_by('c_name','asc');
//        $comp = $this->db->get();
//        return $comp;
//    }
//    
//    public function OrSearch($start=FALSE ,$end = FALSE ,$user=FALSE ,$comp=FALSE,$agent=FALSE,$status=FALSE){
//        $this->db->select('order.or_id as id , user.u_name as user ,company_agent.ca_name as agent ,company_info.c_name as company,order.or_date as date,order.or_time as time ,order.or_total as total,order.or_discount as dis,order.or_sub as net ,order.or_status as status');
//        $this->db->from('order');
//        $this->db->join('user', 'order.or_uid = user.u_id');
//        $this->db->join('company_info','company_info.c_id= order.or_company','left');
//        $this->db->join('company_agent','company_agent.ca_id= order.or_agent','left');
//         if($start !=FALSE && $end!=FALSE){
//            $this->db->where('order.or_date >="'.date('d-m-Y', strtotime($start)).'"');
//            $this->db->where('order.or_date <="'.date('d-m-Y', strtotime($end)).'"');
//         }
//        if($user !=FALSE){
//             $this->db->where('order.or_uid',$user);
//        }
//        if($comp !=FALSE){
//             $this->db->where('order.or_company',$comp);
//        }
//        if($agent !=FALSE){
//             $this->db->where('order.or_agent',$agent);
//        }
//        if($status !=FALSE){
//             $this->db->where('order.or_status ',$status);
//        }
//        $this->db->order_by("order.or_id","desc");
//          $comp = $this->db->get();
//        if($comp->num_rows()>0){
//            return $comp;
//        }
//        else{
//            return FALSE;
//        }
//    }
//    
//    public function ConfirmOrder($orid){
//        $this->db->where('or_id', $orid);
//        $this->db->update('order',array('or_status'=>3));
//    }
//    
//    public function addOrderBillingDetails($OrderBillingData){
//        $data = array('or_sub' => $OrderBillingData['or_sub'], 'or_discount' => $OrderBillingData['or_discount'], 'or_total' => $OrderBillingData['or_total'], 'or_honor' => $OrderBillingData['or_honor'], 'or_vat' => $OrderBillingData['or_vat'], 'or_rcv_date' => $OrderBillingData['or_rcv_date'], 'or_rcv_time' => $OrderBillingData['or_rcv_time']);
//        $this->db->where('or_id', $OrderBillingData['or_id']);
//        if($this->db->update('order', $data)){
//            return TRUE;
//        }
//        else{
//            return $this->db->_error_number() . ': ' . $this->db->_error_message();
//        }
//    }
//    
//    public function CancelOrder($orid, $stat){
//        $this->db->where('or_id', $orid);
//        if($this->db->update('order', array('or_status' => $stat))){
//            return TRUE;
//        }
//        else{
//            return FALSE;
//        }
//    }
//    
//    public function GetOrderItemsList($orid){
//        $this->db->select("*");
//        $this->db->from('order_item');
//        $this->db->where('oi_orid',$orid);
//        return $this->db->get()->result();
//    }
//    
//    public function TransferOrderToStore($storeData){
//        $this->db->insert('store', $storeData);
//    }
//    
//    public function GetRunningLow(){
//        $sql = "SELECT  `m_id` AS id,  `m_name` AS name,`m_cid` as comp,  `m_min_qty` AS minqty, (SELECT SUM(  `dist_store`.`str_qty` ) FROM  `dist_store` WHERE  `dist_store`.`str_mid` = id GROUP BY  `dist_store`.`str_mid`
//                ) AS Instr, (SELECT  `dist_medicine_mrp`.`mrp_id` FROM  `dist_medicine_mrp` WHERE  `dist_medicine_mrp`.`mrp_mid` = id) AS mrp, (SELECT SUM(  `dist_invoice_item`.`i_qty` ) FROM  `dist_invoice_item` 
//                WHERE  `dist_invoice_item`.`i_mrp_id` = mrp GROUP BY  `dist_invoice_item`.`i_mrp_id`) AS sold FROM  `dist_medicine_name` ";
//        return $this->db->query($sql)->result();
//    }
//    
//    
//    
//    public function GetComp(){
//        return $this->db->select('c_id as id')->from('company_info')->get()->result();
//    }
//    
//    
//    
//    public function test($status){
//        $this->db->select('order.or_id as id , user.u_name as user ,company_agent.ca_name as agent ,company_info.c_name as company,order.or_date as date,order.or_time as time ,order.or_total as total,order.or_discount as dis,order.or_sub as net ,order.or_status as status');
//        $this->db->from('order');
//        $this->db->join('user', 'order.or_uid = user.u_id');
//        $this->db->join('company_info','company_info.c_id= order.or_company','left');
//        $this->db->join('company_agent','company_agent.ca_id= order.or_agent','left');
//        $this->db->where('order.or_status ',$status-1);
//        $this->db->order_by("order.or_id","desc");
//          $comp = $this->db->get();
//        if($comp->num_rows()>0){
//            return $comp;
//        }
//        else{
//            return FALSE;
//        }
//        
//    }
//    
//    public function addNewOrderItemAndRate($dist_store){
//        $data = array('str_mid' => $dist_store['str_mid'], 'str_orid' => $dist_store['str_orid'], 'str_uid' => $dist_store['str_uid'], 'str_date' => $dist_store['str_date'], 'str_time' => $dist_store['str_time'], 'str_qty' => $dist_store['str_qty'], 'str_rate' => $dist_store['str_rate']);
//        if($this->db->insert('order_stock', $data)){
//            return TRUE;
//        }
//        else{
//            return FALSE;
//        }
//    }
//    
//    public function updateOrderHistoryAfterReceive($ord_itm ){
//        $data = array('oi_qty' => $ord_itm['oi_qty'], 'oi_rate' => $ord_itm['oi_rate']);
//        $this->db->where('order_item.oi_orid',$ord_itm['oi_orid']);
//        $this->db->where('order_item.oi_mid',$ord_itm['oi_mid']);
//        if($this->db->update('order_item',$data)){
//            return TRUE;
//        }
//        else{
//            return FALSE;
//        }
//    }
//    
//    public function getTotalItemOrderedInAnOrderByOrderId($orid){
//        $this->db->select('order_item.oi_id as Item');
//        $this->db->from('order_item');
//        $this->db->where('order_item.oi_orid', $orid);
//        $Item = $this->db->get();
//        return $Item->num_rows();
//    }
//    
//    public function getTotalCostOfTheOrderByOrderId($orid){
//        $Cost = 0;
//        $this->db->select('str_qty * str_rate as Cost');
//        $this->db->from('order_stock');
//        $this->db->where('order_stock.str_orid', $orid);
//        $CostTotal = $this->db->get();
//        foreach ($CostTotal->result() as $CostTotal){
//            $Cost = $Cost + $CostTotal->Cost;
//        }
//        return $Cost;
//    }
//    
//    public function getEmployeeNameWhoPaidForThisInvoice($orid){
//        $this->db->select('order_stock.str_uid');
//        $this->db->from('order_stock');
//        $this->db->where('order_stock.str_orid', $orid);
//        $this->db->limit(1);
//        $Employee = $this->db->get();
//        foreach ($Employee->result() as $Employee){
//            return $Employee->str_uid;
//        }
//    }
//    
//    
//    
//    public function get_filtered_item_wise_list($FilterKeys){
//        $this->db->select('order_item.oi_mid AS Item, medicine_name.m_name AS ItemName, medicine_name.med_u_price AS ItemPrice,
//            medicine_name.m_stok AS Available,
//            (SELECT SUM(`dist_order_item`.`oi_qty`) FROM `dist_order_item` WHERE `dist_order_item`.`oi_mid` = Item) AS Quantity,
//            (SELECT SUM(`dist_order_item`.`oi_rate`) FROM `dist_order_item` WHERE `dist_order_item`.`oi_mid` = Item) AS NetPrice');
//        $this->db->from('order_item');
//        if(strlen($FilterKeys['from']) > 1){
//            $this->db->where('order_item.oi_rcv_date >=', $FilterKeys['from']);
//        }
//        if(strlen($FilterKeys['tod8']) > 1){
//            $this->db->where('order_item.oi_rcv_date <=', $FilterKeys['tod8']);
//        }
//        if(strlen($FilterKeys['company']) > 0){
//            $this->db->where('order_item.oi_comp_id', $FilterKeys['company']);
//        }
//        $this->db->join('medicine_name', 'medicine_name.m_id = order_item.oi_mid', 'LEFT');
//        $this->db->order_by('medicine_name.m_name', 'ASC');
//        $this->db->group_by('order_item.oi_mid');
//        $item_list = $this->db->get();
//        if($item_list->num_rows() > 0){
//            return $item_list;
//        } else {
//            return FALSE;
//        }
//    }
//    
//    public function updateEmergencyStock($comp, $Medz, $Quan, $e_remarks, $date, $time){
//        $this->db->trans_begin();
//        for($i = 0; $i < count($comp); $i++){
//            $this->db->insert('emergency_stok', array('e_comp_id' => $comp[$i], 'e_med_id' => $Medz[$i], 'e_amount' => $Quan[$i], 'e_remarks' => $e_remarks, 'posting_date' => $date, 'posting_by' => $time ));
//            $variable = (getInStock($Medz[$i]) + $Quan[$i]);
//            $this->db->update('medicine_name', array('m_stok' => $variable ), array('m_id' => $Medz[$i]));
//        }
//        if($this->db->trans_status() === FALSE){
//            $this->db->trans_rollback();
//            return FALSE;
//        } else {
//            $this->db->trans_commit();
//            return TRUE;
//        }
//    }
//    
//    public function updateDamageStock($comp, $Medz, $Quan, $e_remarks, $date, $time){
//        $this->db->trans_begin();
//        for($i = 0; $i < count($comp); $i++){
//            $this->db->insert('damage_stock', array('e_comp_id' => $comp[$i], 'e_med_id' => $Medz[$i], 'e_amount' => $Quan[$i], 'e_remarks' => $e_remarks, 'posting_date' => $date, 'posting_by' => $time ));
//            $variable = (getInStock($Medz[$i]) - $Quan[$i]);
//            $this->db->update('medicine_name', array('m_stok' => $variable ), array('m_id' => $Medz[$i]));
//        }
//        if($this->db->trans_status() === FALSE){
//            $this->db->trans_rollback();
//            return FALSE;
//        } else {
//            $this->db->trans_commit();
//            return TRUE;
//        }
//    }
//    
//    public function get_filtered_emergecny_stock_list($FilterKeys){
//        if(strlen($FilterKeys['tod8']) > 1){
//            $Quantity = '(SELECT SUM(`dist_emergency_stok`.`e_amount`) FROM `dist_emergency_stok` WHERE `dist_emergency_stok`.`e_med_id` = Item 
//            AND `dist_emergency_stok`.`posting_date` >= "' . $FilterKeys['from'] . '" AND `dist_emergency_stok`.`posting_date` <= "' . $FilterKeys['tod8'] . '") AS Quantity';
//        } else {
//            $Quantity = '(SELECT SUM(`dist_emergency_stok`.`e_amount`) FROM `dist_emergency_stok` WHERE `dist_emergency_stok`.`e_med_id` = Item 
//            AND `dist_emergency_stok`.`posting_date` >= ' . $FilterKeys['from'] . ') AS Quantity';
//        }
//        $this->db->select('emergency_stok.e_med_id AS Item, medicine_name.m_name AS ItemName, medicine_type.mt_name AS MedType, medicine_name.med_u_price AS ItemPrice,
//            medicine_name.m_stok AS Available, ' . $Quantity . '');
//        $this->db->from('emergency_stok');
//        if(strlen($FilterKeys['from']) > 1){
//            $this->db->where('emergency_stok.posting_date >=', $FilterKeys['from']);
//        }
//        if(strlen($FilterKeys['tod8']) > 1){
//            $this->db->where('emergency_stok.posting_date <=', $FilterKeys['tod8']);
//        }
//        if(strlen($FilterKeys['company']) > 0){
//            $this->db->where('emergency_stok.e_comp_id', $FilterKeys['company']);
//        }
//        $this->db->join('medicine_name', 'medicine_name.m_id = emergency_stok.e_med_id', 'LEFT');
//        $this->db->join('medicine_type', 'medicine_type.mt_id = medicine_name.m_tid', 'LEFT');
//        $this->db->order_by('medicine_name.m_name', 'ASC');
//        $this->db->group_by('emergency_stok.e_med_id');
//        $item_list = $this->db->get();        //return $this->db->last_query();
//        if($item_list->num_rows() > 0){
//            return $item_list;
//        } else {
//            return FALSE;
//        }
//    }
//    
//    public function get_filtered_full_emergecny_stock_list($FilterKeys){
//        $this->db->select(' emergency_stok.e_med_id AS Item, medicine_name.m_name AS ItemName, medicine_type.mt_name AS MedType, medicine_name.med_u_price AS ItemPrice, medicine_name.m_stok AS Available, emergency_stok.e_amount AS Quantity, emergency_stok.posting_date AS RawDate');
//        $this->db->from('emergency_stok');
//        if(strlen($FilterKeys['from']) > 1){
//            $this->db->where('emergency_stok.posting_date >=', $FilterKeys['from']);
//        }
//        if(strlen($FilterKeys['tod8']) > 1){
//            $this->db->where('emergency_stok.posting_date <=', $FilterKeys['tod8']);
//        }
//        if(strlen($FilterKeys['company']) > 0){
//            $this->db->where('emergency_stok.e_comp_id', $FilterKeys['company']);
//        }
//        $this->db->join('medicine_name', 'medicine_name.m_id = emergency_stok.e_med_id', 'LEFT');
//        $this->db->join('medicine_type', 'medicine_type.mt_id = medicine_name.m_tid', 'LEFT');
//        $this->db->order_by('medicine_name.m_name', 'ASC');
//        $item_list = $this->db->get();
//        if($item_list->num_rows() > 0){
//            return $item_list;
//        } else {
//            return FALSE;
//        }
//    }
}
?>
