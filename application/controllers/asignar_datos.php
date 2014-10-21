<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Asignar_datos extends CI_Controller {

	public $user;

	function __construct() {  
	
	    parent::__construct();
		
		$this->load->library('ion_auth');
	    $this->load->library('layout');
	    
	    $this->load->helper(array('form', 'url'));
		$this->load->helper('url');
		
		$this->load->database();

	    if (!$this->ion_auth->logged_in()) {
	       	// redirect to login view
			$this->session->set_flashdata('message', 'yuka');	
			redirect('auth/login', 'refresh');

	    }

	    $this->user = $this->ion_auth->user()->row();

	}

	function index()
	{
		$data['content_for_layout'] = 'inicio...';
		$this->layout->view('asignar_datos/home', $data);
	}
}