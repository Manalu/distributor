<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 *
 * @author  I AM CODY 
 * @name    Tarek Showkot
 * @contact tarek@exploriasolution.com, priom2000@gmail.com
 * 
 * Product Status
 * 1 => Stock, Which means the product is avaialble at it's respective branch
 * 2 => Not active
 * 
 *
 */
class products extends CI_Controller {
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
            if($this->Sesson_Vars['role'] != 3 && $this->Sesson_Vars['role'] != 2 && $this->Sesson_Vars['role'] != 1){
                redirect('login','refresh');
            }
            else{
                $this->Merged_Vars = array_merge($this->Public_Vars, $this->Sesson_Vars);
            }
        }
    }
    
    public function newproduct(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "add_new_product")){
            $this->form_validation->set_rules('p_name', 'Product Name', 'required|is_unique[products_name.p_name]');
            $this->form_validation->set_rules('p_gid', 'Product Group', 'required|is_int');
            $this->form_validation->set_rules('p_cid', 'Product Supplier', 'required|is_int');
            $this->form_validation->set_rules('p_tid', 'Product Type', 'required|is_int');
            if($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('notification', errormessage(validation_errors()));
                redirect(__CLASS__ . '/new', 'refresh');
            } else {
                //Price Setup
                $type = $this->input->post('p_tid');
                if($type == 1){
                    $p_u_price = $this->input->post('p_u_price');
                    $p_box_qty = 1;
                    $p_box_price = $p_u_price;
                    $p_min_qty = $this->input->post('p_min_qty');
                    $p_purchse_price = $this->input->post('p_purchse_price');
                    $p_stock_price = $this->input->post('p_stock_price');
                } 
                else if($type == 2){
                    $p_box_qty = $this->input->post('p_box_qty');
                    $p_box_price = $this->input->post('p_u_price');
                    $p_u_price = ($p_box_price / $p_box_qty);
                    $p_min_qty = ($this->input->post('p_min_qty') * $p_box_qty);
                    $p_purchse_price = ($this->input->post('p_purchse_price') / $p_box_qty);
                    $p_stock_price = ($this->input->post('p_stock_price') / $p_box_qty);
                }
                $products   = array('p_name' => $this->input->post('p_name'), 'p_gid' => $this->input->post('p_gid'), 'p_cid' => $this->input->post('p_cid'), 'p_tid' => $this->input->post('p_tid'), 'p_min_qty' => $p_min_qty, 'p_u_price' => $p_u_price, 'p_box_qty' => $p_box_qty, 'p_box_bonus' => $this->input->post('p_box_bonus'), 'p_box_price' => $p_box_price, 'p_purchse_price' => $p_purchse_price, 'p_stock_price' => $p_stock_price, 'p_status' => 1 );
                $stock      = array('product_id' => 0, 'branch_id' => 1, 'stock' => $this->input->post('stock'));
                $score = $this->productsmodel->add_new_product($products, $stock);
                if($score){
                    $this->session->set_flashdata('notification', greensignal('New Product Added!!'));
                    redirect(__CLASS__ . '/new', 'refresh');
                } else {
                    $this->session->set_flashdata('notification', errormessage());
                    redirect(__CLASS__ . '/new', 'refresh');
                }
            }
        } else {
            $this->Merged_Vars['supplier']          = $this->suppliermodel->get_supplier_list();
            $this->Merged_Vars['groups']            = $this->productsmodel->pro_group();
            $this->Merged_Vars['types']             = $this->productsmodel->pro_types();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function productlist(){
        $this->Merged_Vars['printer']               = 'Product List Database ';
        $this->Merged_Vars['products']              = $this->productsmodel->get_products_list();
        $this->Merged_Vars['sups']                  = $this->suppliermodel->get_supplier_list();
        $this->Merged_Vars['groups']                = $this->productsmodel->pro_group();
        $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
    }
    
    public function filter_productlist(){
        $FilterData                         = array('p_name' => '', 'p_gid' => '', 'p_cid' => '', 'p_status' => '');
        if($this->input->post('name')){
            $FilterData['p_name'] = $this->input->post('name');
        }
        if($this->input->post('cid')){
            $FilterData['p_cid'] = $this->input->post('cid');
        }
        if($this->input->post('gid')){
            $FilterData['p_gid'] = $this->input->post('gid');
        }
        if($this->input->post('stat')){
            $FilterData['p_status'] = $this->input->post('stat');
        }
        $this->Merged_Vars['printer']               = 'Product List Database ';
        $this->Merged_Vars['products']              = $this->productsmodel->filter_products_list($FilterData);
        $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars);
    }
    
    public function stock_report(){
        //sleep(2);
        $this->Merged_Vars['p_name']                = $this->productsmodel->pro_name($this->input->post('proid'));
        $this->Merged_Vars['stock']                 = $this->productsmodel->get_branchwise_stock($this->input->post('proid'));
        $this->Merged_Vars['pro_id']                = $this->input->post('proid');
        echo $this->load->view(__CLASS__ . '/' . __FUNCTION__, $this->Merged_Vars, TRUE);
    }
    
    public function update_product(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "update_product_setup")){
            $type = $this->input->post('p_tid');
            if($type == 1){
                $p_u_price = $this->input->post('p_u_price');
                $p_box_qty = 1;
                $p_box_price = $p_u_price;
                $p_min_qty = $this->input->post('p_min_qty');
                $p_purchse_price = $this->input->post('p_purchse_price');
                $p_stock_price = $this->input->post('p_stock_price');
            } 
            else if($type == 2){
                $p_box_qty = $this->input->post('p_box_qty');
                $p_box_price = $this->input->post('p_u_price');
                $p_u_price = ($p_box_price / $p_box_qty);
                $p_min_qty = ($this->input->post('p_min_qty') * $p_box_qty);
                $p_purchse_price = ($this->input->post('p_purchse_price') / $p_box_qty);
                $p_stock_price = ($this->input->post('p_stock_price') / $p_box_qty);
            }
            $product_info   = array('p_id' => $this->input->post('p_id'), 'p_name' => $this->input->post('p_name'), 'p_gid' => $this->input->post('p_gid'), 'p_cid' => $this->input->post('p_cid'), 'p_tid' => $this->input->post('p_tid'), 'p_min_qty' => $p_min_qty, 'p_u_price' => $p_u_price, 'p_box_qty' => $p_box_qty, 'p_box_bonus' => $this->input->post('p_box_bonus'), 'p_box_price' => $p_box_price, 'p_purchse_price' => $p_purchse_price, 'p_stock_price' => $p_stock_price, 'p_status' => 1);
            $score          = $this->productsmodel->update_product_info($product_info);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Product Information Updated!!'));
                redirect(__CLASS__ . '/list', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage());
                redirect(__CLASS__ . '/list', 'refresh');
            }
        } else {
            $this->Merged_Vars['product']           = $this->productsmodel->get_product_info_for_update($this->input->get('product'));
            $this->Merged_Vars['supplier']          = $this->suppliermodel->get_supplier_list();
            $this->Merged_Vars['groups']            = $this->productsmodel->pro_group();
            $this->Merged_Vars['types']             = $this->productsmodel->pro_types();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
    
    public function delete_product(){
        $product_info   = array('p_id' => $this->input->get('product'), 'p_status' => 2);
        $score          = $this->productsmodel->update_product_info($product_info);
        if($score){
            $this->session->set_flashdata('notification', greensignal('Product Has Been Deleted From Store!!'));
            redirect(__CLASS__ . '/list', 'refresh');
        } else {
            $this->session->set_flashdata('notification', errormessage());
            redirect(__CLASS__ . '/list', 'refresh');
        }
    }
    
    public function grouplist(){
        if($this->input->post('trigger') && ($this->input->post('trigger') == "add_new_group")){
            $this->form_validation->set_rules('mg_name', 'Group Name', 'required|is_unique[products_group.mg_name]');
            if($this->form_validation->run() == FALSE){
                $this->session->set_flashdata('notification', errormessage(validation_errors()));
                redirect(__CLASS__ . '/groups', 'refresh');
            } else {
                $group_data = array( 'mg_name' => $this->input->post('mg_name') );
                $score = $this->productsmodel->add_pro_group($group_data);
                if($score){
                    $this->session->set_flashdata('notification', greensignal('New Product Group Added!!'));
                    redirect(__CLASS__ . '/groups', 'refresh');
                } else {
                    $this->session->set_flashdata('notification', errormessage());
                    redirect(__CLASS__ . '/groups', 'refresh');
                }
            }
        } else if($this->input->post('trigger') && ($this->input->post('trigger') == "update_group")){
            $group_data = array( 'mg_id' => $this->input->post('mg_id'), 'mg_name' => $this->input->post('mg_name') );
            $score = $this->productsmodel->edit_pro_group($group_data);
            if($score){
                $this->session->set_flashdata('notification', greensignal('Product Group Updated!!'));
                redirect(__CLASS__ . '/groups', 'refresh');
            } else {
                $this->session->set_flashdata('notification', errormessage());
                redirect(__CLASS__ . '/groups', 'refresh');
            }
        } else{
            $this->Merged_Vars['groups']                = $this->productsmodel->pro_group();
            $this->loadView(__CLASS__, __FUNCTION__, $this->Merged_Vars);
        }
    }
}
?>
