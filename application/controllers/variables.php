<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Variables extends CI_Controller {

	public $user;

	function __construct() {  
	
	    parent::__construct();
		
		$this->load->library('ion_auth');
	    $this->load->library('layout');
		$this->load->library('grocery_CRUD');
		$this->load->library('session');
	    
	    $this->load->helper(array('form', 'url'));
		$this->load->helper('url');
		
		$this->load->database();

	    if (!$this->ion_auth->logged_in()) {
	       	// redirect to login view
			//$this->session->set_flashdata('message', 'yuka');	
			redirect('auth/login', 'refresh');

	    }

	    $this->user = $this->ion_auth->user()->row();

	}

	public function _example_output($output = null)
	{
		$this->layout->view('grocery/crud_render',$output);
	}

	function index()
	{
		$this->layout->view('variables/index', null);
	}


	function tipo_precio()
	{
		$crud = new grocery_CRUD();
		$crud->set_theme('datatables');
		$crud->set_table('tipo_precio');
		$crud->columns('nombre');
		$output = $crud->render();
		$this->_example_output($output);
	}

	function pais(){
		$this->load->model('variables_model');
		$data['paisfuente'] = $this->variables_model->find_pais_fuente()->result_array();
		
		$this->layout->view('variables/pais', $data);
	}
	function editar_pais($id_pais = null){
		if ($id_pais == null) {
			redirect('variables/pais', 'refresh');
		}

		$this->load->model('variables_model');
		
		$data['paisfuente'] = $this->variables_model->find_pais_fuente_id($id_pais)->result_array();
		$data['tipo_precio'] = $this->variables_model->find_tipo_precio();
		
		$this->layout->view('variables/editar-pais', $data);
	}

	function agregar_pais(){
		
		if ($_POST) {
			// aqui es necesario validar por lado del servidor
			$this->load->model('variables_model');
			
			$dPost = $this->input->post();

			$dtaPais['id'] = null;
			$dtaPais['nombre'] = $dPost['nombre'];
			$dtaPais['moneda'] = $dPost['moneda'];
			$dtaPais['habilitado'] = 1;
			$dtaPais['fecha_registro'] = date("Y-m-d H:i:s");

			$id_pais = $this->variables_model->guardar_pais($dtaPais);
			$this->load->library('upload');

			$i = 0;
			// si no selecciona un tipo de fuente, no es posible guardar la referencia, (falta la validacion)
			foreach($dPost['tipo-precio'] as $key => $value) {
				//here file
			    if (!empty($_FILES['userfile']['name'])) {
				    $files = $_FILES;
				    $cpt = count($_FILES['userfile']['name']);

				    for($c=1; $c<=$cpt; $c++)
				    {
				    	if (!empty($files['userfile']['name'][$c])) {
					        $_FILES['userfile']['name'] = $files['userfile']['name'][$c];
					        $_FILES['userfile']['type'] = $files['userfile']['type'][$c];
					        $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'][$c];
					        $_FILES['userfile']['error'] = $files['userfile']['error'][$c];
					        $_FILES['userfile']['size'] = $files['userfile']['size'][$c];    

					    	$upload_opt = $this->set_upload_options();
					    	
					    	if (!empty($upload_opt)) {
					    		$upload_opt_d[$c] = $upload_opt;
						    	$retorno_config = $this->upload->initialize($upload_opt);
						    	$this->upload->do_upload();
					    	}
			    		}	

					}
			    }

				foreach ($value as $keytipo => $valuetipo) {

					$dta[$i]['id'] = null;
					$dta[$i]['id_pais'] = $id_pais;
					$dta[$i]['nombre'] = $dPost['nombre-fuente'][$key];
					$dta[$i]['link'] = $dPost['link-fuente'][$key];
					if (!empty($upload_opt_d[$key])) {
						$nombre_archivo = $upload_opt_d[$key]['file_name'];
						$nombre_archivo_o = $upload_opt_d[$key]['org_name'];
					}else{
						$nombre_archivo = 'Sin Archivos Registrados';
						$nombre_archivo_o = 'Sin Archivos Registrados';
					}					
					$dta[$i]['nombre_archivo'] = $nombre_archivo;
					$dta[$i]['nombre_archivo_original'] = $nombre_archivo_o;

					$dta[$i]['tipo_precio'] = $valuetipo;
					$dta[$i]['habilitado'] = 1;
					$dta[$i]['fecha_registro'] = date("Y-m-d H:i:s");
					$i++;
				}
					
			}

			$id_fuentes = $this->variables_model->guardar_fuentes($dta);

			$this->session->set_flashdata('message', 'fuentes agregadas exitosamente');	
			redirect('variables/pais', 'refresh');

		}else{

			$this->load->model('variables_model');
			$data['tipo_precio'] = $this->variables_model->find_tipo_precio();
			$this->layout->view('variables/agregar-pais', $data);
		}

	}

	function do_upload()
	{

	    $this->load->library('upload');

	    $files = $_FILES;
	    $cpt = count($_FILES['userfile']['name']);
	    for($i=0; $i<$cpt; $i++)
	    {

	        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
	        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
	        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
	        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
	        $_FILES['userfile']['size']= $files['userfile']['size'][$i];    
		    $this->upload->initialize($this->set_upload_options());
		    $this->upload->do_upload();
	    }

	}
	private function set_upload_options()
	{   
		if (!empty($_FILES['userfile']['size'])) {
			if (isset($_FILES['userfile'])) {
				$org_name = $_FILES['userfile']['name'];
			}else{
				$org_name = 'null';
			}
		    $config = array();
		    $config['file_name'] = date("Y-m-d_H-i-s").'_'.$org_name;
		    $config['upload_path'] = './assets/uploads/fuentes/';
		    $config['org_name'] = $org_name;
		    $config['allowed_types'] = 'gif|jpg|png|pdf|txt|csv';
		    $config['max_size']      = '0';
		    $config['overwrite']     = FALSE;

		    return $config;
		}
	}
	function agregar_fuentes()
	{
		$this->load->model('variables_model');
		if ($_POST) {
			$this->load->library('upload');
			$dPost = $this->input->post();

			$i = 0;
			// si no selecciona un tipo de fuente, no es posible guardar la referencia, (falta la validacion)
			foreach($dPost['tipo-precio'] as $key => $value) {
				//here file
			    if (!empty($_FILES['userfile']['name'])) {  
				    	$upload_opt = $this->set_upload_options();
				    	
				    	if (!empty($upload_opt)) {
				    		$upload_opt_d = $upload_opt;
					    	$retorno_config = $this->upload->initialize($upload_opt);
					    	$this->upload->do_upload();
				    	}
			    }

				foreach ($value as $keytipo => $valuetipo) {

					$dta[$i]['id'] = null;
					$dta[$i]['id_pais'] = $this->input->post('pais', true);
					$dta[$i]['nombre'] = $dPost['nombre-fuente']	;
					$dta[$i]['link'] = $dPost['link-fuente']	;
					if (!empty($upload_opt_d)) {
						$nombre_archivo = $upload_opt_d['file_name'];
						$nombre_archivo_o = $upload_opt_d['org_name'];
					}else{
						$nombre_archivo = 'Sin Archivos Registrados';
						$nombre_archivo_o = 'Sin Archivos Registrados';
					}					
					$dta[$i]['nombre_archivo'] = $nombre_archivo;
					$dta[$i]['nombre_archivo_original'] = $nombre_archivo_o;

					$dta[$i]['tipo_precio'] = $valuetipo;
					$dta[$i]['habilitado'] = 1;
					$dta[$i]['fecha_registro'] = date("Y-m-d H:i:s");
					$i++;
				}
					
			}

			$id_fuentes = $this->variables_model->guardar_fuentes($dta);


			$this->session->set_flashdata('message', 'fuentes agregadas exitosamente');	
			redirect('variables/pais', 'refresh');

		}
		$data['pais'] = $this->variables_model->find_pais();
		$data['tipo_precio'] = $this->variables_model->find_tipo_precio();
		$this->layout->view('variables/agregar-fuentes', $data);
	}

}