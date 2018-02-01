<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class productsmodel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function pro_group(){
        $this->db->select('*');
        $this->db->from('products_group');
        $this->db->order_by('products_group.mg_name', 'ASC');
        $groups = $this->db->get();
        if($groups->num_rows() > 0){
            return $groups;
        } else {
            return FALSE;
        }
    }
    
    public function pro_group_name($group){
        $this->db->select('*');
        $this->db->from('products_group');
        $this->db->where('products_group.mg_id', $group);
        $groups = $this->db->get();
        if($groups->num_rows() == 1){
            $group = $groups->row();
            return $group->mg_name;
        } else {
            return 'No Group';
        }
    }
    
    public function pro_types(){
        $this->db->select('*');
        $this->db->from('products_type');
        $this->db->order_by('products_type.mt_name', 'ASC');
        $types = $this->db->get();
        if($types->num_rows() > 0){
            return $types;
        } else {
            return FALSE;
        }
    }
    
    public function add_new_product($product, $stock){
        $this->db->trans_begin();
        $this->db->insert('products_name', $product);
        $pid = $this->db->insert_id();
        $stock['product_id'] = $pid;
        $this->db->insert('product_stock', $stock);
        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }        
    }
    
    public function get_products_list(){
        $this->db->select('products_name.p_id, products_name.p_name, products_group.mg_name, company_info.c_name, products_name.p_stock_price,
            products_name.p_u_price, products_name.p_box_qty, products_name.p_box_bonus, products_name.p_min_qty, products_name.p_purchse_price,
            (SELECT SUM(dist_product_stock.stock) FROM dist_product_stock WHERE dist_product_stock.product_id=p_id) AS p_stok');
        $this->db->from('products_name');
        $this->db->where('products_name.p_status', 1);
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
    
    public function filter_products_list($FilterData){
        $this->db->select('products_name.p_id, products_name.p_name, products_group.mg_name, company_info.c_name,
            products_name.p_u_price, products_name.p_box_qty, products_name.p_box_bonus, products_name.p_min_qty, products_name.p_purchse_price,
            (SELECT SUM(dist_product_stock.stock) FROM dist_product_stock WHERE dist_product_stock.product_id=p_id) AS p_stok');
        $this->db->from('products_name');
        if(strlen($FilterData['p_name']) > 0){
            $this->db->like('products_name.p_name', $FilterData['p_name']);
        }
        if(strlen($FilterData['p_cid']) > 0){
            $this->db->where('products_name.p_cid', $FilterData['p_cid']);
        }
        if(strlen($FilterData['p_gid']) > 0){
            $this->db->where('products_name.p_gid', $FilterData['p_gid']);
        }
        if(strlen($FilterData['p_status']) > 0){
            $this->db->where('products_name.p_status', $FilterData['p_status']);
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
    
    public function pro_name($pid){
        $this->db->select('products_name.p_name');
        $this->db->from('products_name');
        $this->db->where('products_name.p_id', $pid);
        $name = $this->db->get()->row();
        return $name->p_name;
    }
    
    public function get_branchwise_stock($pid){
        $this->db->select('products_name.p_name, branch.b_name, product_stock.stock');
        $this->db->from('product_stock');
        $this->db->where('product_stock.product_id', $pid);
        $this->db->join('products_name', 'products_name.p_id = product_stock.product_id', 'LEFT');
        $this->db->join('branch', 'branch.tble_id = product_stock.branch_id', 'LEFT');
        $this->db->order_by('branch.b_name', 'ASC');
        $stock = $this->db->get();
        if($stock->num_rows() > 0){
            return $stock;
        } else {
            return FALSE;
        }
    }
    
    public function get_product_info_for_update($product){
        $this->db->select('products_name.p_id, products_name.p_name, products_group.mg_name, company_info.c_name, products_name.p_purchse_price,
            products_name.p_u_price, products_name.p_gid, products_name.p_cid, products_name.p_tid, products_name.p_min_qty, products_name.p_box_qty,
            products_name.p_box_bonus, products_name.p_stock_price');
        $this->db->from('products_name');
        $this->db->where('products_name.p_id', $product);
        $this->db->order_by('products_name.p_name', 'ASC');
        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid', 'LEFT');
        $this->db->join('company_info', 'company_info.c_id = products_name.p_cid', 'LEFT');
        $products = $this->db->get();
        if($products->num_rows() == 1){
            return $products->row();
        } else {
            return FALSE;
        }
    }
    
    public function update_product_info($product_info){
        $this->db->where('products_name.p_id', $product_info['p_id']);
        if($this->db->update('products_name', $product_info)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function add_pro_group($group_data){
        if($this->db->insert('products_group', $group_data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function edit_pro_group($group_data){
        $this->db->where('products_group.mg_id', $group_data['mg_id']);
        if($this->db->update('products_group', $group_data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
//    public function get_product_info($supid = FALSE, $p_sku){
//        $this->db->select('products_name.p_id, products_name.p_sku, products_name.p_name, products_group.mg_name, company_info.c_name,
//            products_name.p_u_price, products_name.p_min_qty, products_name.p_stok');
//        $this->db->from('products_name');
//        if($supid != FALSE) { $this->db->where('products_name.p_cid', $supid); }
//        $this->db->where('products_name.p_sku', $p_sku);
//        $this->db->where('products_name.p_status', 1);
//        $this->db->order_by('products_name.p_name', 'ASC');
//        $this->db->join('products_group', 'products_group.mg_id = products_name.p_gid', 'LEFT');
//        $this->db->join('company_info', 'company_info.c_id = products_name.p_cid', 'LEFT');
//        $products = $this->db->get();
//        if($products->num_rows() == 1){
//            return $products->row();
//        } else {
//            return FALSE;
//        }
//    }
}  
?>
