<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Precios extends CI_Controller {

	public $user;

	function __construct() {  
		

	    parent::__construct();
		$this->load->library('ion_auth');
	    $this->load->library('layout');
	    $this->load->library('session');
	    $this->load->helper(array('form', 'url'));
	
	    if (!$this->ion_auth->logged_in()) {
	       	// redirect to login view
			redirect('auth/login', 'refresh');

	    }
	    $this->user = $this->ion_auth->user()->row();
	}

	function index()
	{
		$user_groups = $this->ion_auth->get_users_groups($this->user->id)->result();
		$data['a'] = reset($user_groups);

		$this->load->model('medicamentos_model');
		$data['indicadores']['num_registros'] = $this->medicamentos_model->num_registros();
		$data['indicadores']['num_registros_asignados'] = $this->medicamentos_model->num_registros_asignados();
		$data['indicadores']['num_registros_terminados'] = $this->medicamentos_model->num_registros_terminados();
		$data['indicadores']['num_registros_user'] = $this->medicamentos_model->num_registros_user();
		//$data['indicadores']['num_registros_user_referenciados'] = $this->medicamentos_model->num_registros_user_referenciados($this->user->id);
		//$data['indicadores']['num_registros_user_guardados'] = $this->medicamentos_model->num_registros_user_guardados($this->user->id);
		$data['indicadores']['num_registros_user_porcentaje'] = $this->medicamentos_model->num_registros_user_porcentaje($this->user->id);
		$this->layout->view('inicio/home', $data);
	}
}