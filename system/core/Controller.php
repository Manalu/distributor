<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
        
        
        public function property($item = FALSE, $value = FALSE){
            if($item === FALSE && $value === FALSE){
                $this->load->model('settingsmodel');
                $info = $this->settingsmodel->getStoreInformationForSettingsController();
                $data = array(
                    'ShopName' => $info->shp_name,
                    'ShopAdrs' => $info->shp_adrs,
                    'ShopPhone' => $info->shp_phn1,
                    'ShopMobile' => $info->shp_phn2,
                    'Weekday' => $info->shp_weekday,
                    'Hours' => $info->shp_hr,
                    'Hours' => $info->shp_hr,
                    'ShopLogo' => $info->shp_logo,
                    'ShopWeb' => $info->shp_web,
                    'css' => base_url() . 'css/',
                    'icomoon' => base_url().'icomoon/',
                    'assets' => base_url() . 'assets/',
                    'img' => base_url() . 'img/',
                    'js' => base_url() . 'js/',
                    'error' => '',
                    'title' => 'Rafiz Distribution Agency - Distribution Business Management Software'
                );
                return $data;
            }
            else{
                $data = array(
                    'css' => base_url() . 'css/',
                    'icomoon'=>  base_url(). 'icomoon/',
                    'assets' => base_url() . 'assets/',
                    'img' => base_url() . 'img/',
                    'js' => base_url() . 'js/',
                    'error' => '',
                    'title' => 'Rafiz Distribution Agency - Distribution Business Management Software');
                $data[$item] = $value;
                return $data;
            }
        }
        
        public function loadView($class,$method,$vars){
            $this->load->view('common/header',  $vars);
            $this->load->view('common/menu',  $vars);
            $this->load->view($class . "/" . $method, $vars);
            $this->load->view('common/footer',  $vars);
        }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */