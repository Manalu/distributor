<?php

/**
 * Description of test
 *
 * @author  imcody
 * @name    Tarek Ibne Showkot
 * @contact priom2000@gmail.com
 * @web     http://imcody.com
 */
class test extends CI_Controller {
    //put your code here
    
    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('auth')){
            redirect('login','refresh');
        }
        else{
            $this->Public_Vars = $this->property();
            $this->Sesson_Vars = $this->session->userdata('auth');
            if($this->Sesson_Vars['role'] != 2 && $this->Sesson_Vars['role'] != 3){
                redirect('login','refresh');
            }
            else{
                $this->Merged_Vars = array_merge($this->Public_Vars, $this->Sesson_Vars);
            }
        }
    }
    
    public function index(){
        $this->db->select('DISTINCT(product_id), products_name.p_name');
        $this->db->from('product_stock');
        $this->db->where('product_stock.branch_id', 2);
        $this->db->get();
    }
}

?>
