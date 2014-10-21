<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sistema extends CI_Controller {

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
			redirect('auth/login', 'refresh');

	    }

	    $this->user = $this->ion_auth->user()->row();

	}

	function index()
	{
		$data['content_for_layout'] = $this->user;
		$this->layout->view('sistema/home', $data);
	}
}