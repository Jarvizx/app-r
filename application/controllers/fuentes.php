<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fuentes extends CI_Controller {

	public $user;

	function __construct() {  
	
	    parent::__construct();
		
		$this->load->library('ion_auth');
	    $this->load->library('layout');
		$this->load->library('grocery_CRUD');
	    
	    $this->load->helper(array('form', 'url'));
		$this->load->helper('url');
		
		$this->load->database();

	    if (!$this->ion_auth->logged_in()) {
	       	// redirect to login view
			redirect('auth/login', 'refresh');

	    }

	    $this->user = $this->ion_auth->user()->row();

	}

	public function _example_output($output = null)
	{
		$this->layout->view('crud_render',$output);
	}

	function index()
	{
		
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');

		$crud->set_table('fuentes_paises');
		
		$crud->columns('id','codigo_pais','pais','codigo_fuente','fuente','codigo_precio','tipo_de_precio','fecha_registro','habilitado');

		$output = $crud->render();

		$this->_example_output($output);
	}
}