<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medicamentos extends CI_Controller {

	public $user;

	function __construct() {  
	
	    parent::__construct();

		
		$this->load->library('ion_auth');
	    $this->load->library('layout');
	    $this->load->library('form_validation');
	    $this->load->library('session');
	    $this->load->library('export');
		//$this->load->library('grocery_CRUD');
	    
	    $this->load->helper(array('form', 'url'));

	    if (!$this->ion_auth->logged_in()) {
	       	// redirect to login view
			redirect('auth/login', 'refresh');

	    }

	    $this->user = $this->ion_auth->user()->row();

	}

	function index()
	{
		
		$data = null;
		//$data['indicadores']['num_registros'] = $this->medicamentos_model->num_registros();
		//$data['indicadores']['num_registros_asignados'] = $this->medicamentos_model->num_registros_asignados();
		//$data['indicadores']['num_registros_terminados'] = $this->medicamentos_model->num_registros_terminados();
		//$data['Xuser'] = $this->medicamentos_model->num_registros_terminados();

		$this->layout->view('medicamentos/home', $data);

	}

	function agregar()
	{
		#! muy pendiente, aqui falta un mysql real scape

		// donde 1 es admin y 2 es cordinador
		if(!in_array(reset($this->ion_auth->get_users_groups($this->user->id)->result())->id, array("1","2")))
		{
			$this->session->set_flashdata('message', 'no cuenta con permisos de usuario');
			redirect('/', 'refresh');
	  	}
		//ellislab.com/codeigniter/user-guide/libraries/file_uploading.html
		if (isset($_FILES['userfile'])) {
			$org_name = $_FILES['userfile']['name'];
		}else{
			$org_name = 'null';
		}

		//rename file 
		$config['file_name'] = date("Y-m-d_H-i-s").'_'.$org_name;
		$config['upload_path'] = './assets/uploads/csv/';
		//$config['allowed_types'] = 'text/plain|text/anytext|csv|.csv|text/x-comma-separated-values|text/comma-separated-values|application/octet-stream|application/vnd.ms-excel|application/x-csv|text/x-csv|text/csv|application/csv|application/excel|application/vnd.msexcel';
		$config['allowed_types'] = 'csv|txt';
		$config['overwrite'] = TRUE;
		//aprox 5~6 MB
		$config['max_size']	= '6144';

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$this->layout->view('medicamentos/agregar', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			$nombre_db = $this->input->post('nombre_db', TRUE);
			
			if (empty($nombre_db)) {
				$nombre_db = date("Y-m-d H:i:s");
			}

			$primer_insert = array(
								"id" => null,
								"nombre_db" => $nombre_db,
								"nombre_archivo_original" => str_replace(" ", "_",$org_name),
								"nombre_archivo_actual" => str_replace(" ", "_",$config['file_name']),
								"fecha_registro" => date("Y-m-d H:i:s"),
								"habilitado" => 1,
								"usuario" => $this->user->id,
								);
			$this->load->model('medicamentos_model');

			$id_registro = $this->medicamentos_model->guardar_registro_medicamento_archivo($primer_insert);

			// here read-bucle file
			ini_set('auto_detect_line_endings', true);
			$csv_file = str_replace(" ", "_", $config['upload_path'].$config['file_name']);
			
			$fila = 1;
			if (($gestor = fopen($csv_file, "r")) !== FALSE) {
			    while (($datos = fgetcsv($gestor, 1000, ";", '"', "\\")) !== FALSE) {
				   	$cadena[][] = $datos;
			    }
			    fclose($gestor);
			    $limite_for = count($cadena);

				for ($i=1; $i < $limite_for; $i++) { 
			    	foreach ($cadena[$i] as $key => $value) {
                        
                        $med[$i]['id']                  = null;
                        $med[$i]['id_registro_archivo'] = $id_registro;
                        $med[$i]['expediente_ficha']    = $value[0];
                        $med[$i]['cum']                 = $value[1];
                        $med[$i]['expediente']          = $value[2];
                        $med[$i]['consecutivo']         = $value[3];
                        $med[$i]['atc_invima']          = $value[4];
                        $med[$i]['atc_who']             = $value[5];
                        $med[$i]['descripcion_atc']     = $value[6];
                        $med[$i]['forma_farmaceutica']  = $value[7];
                        $med[$i]['producto']            = $value[8];
                        $med[$i]['cantidad_principio_activo'] = $value[9];
                        $med[$i]['cantidad_principio_activo_secundario']    = $value[10];
                        $med[$i]['unidad_base']         = $value[11];
                        $med[$i]['conversion_ui']       = $value[12];
                        $med[$i]['unidad_concentracion_ui'] = $value[13];
                        $med[$i]['volumen']             = $value[14];
                        $med[$i]['unidad_volumen']      = $value[15];
                        $med[$i]['peso']                = $value[16];
                        $med[$i]['unidad_peso']         = $value[17];
                        $med[$i]['concentracion']       = $value[18];
                        $med[$i]['unidad_concentracion'] = $value[19];
                        $med[$i]['cantidad_principio_activo_por_presentacion_comercial']    = $value[20];
                        $med[$i]['unidad_base_por_presentacion_comercial']          = $value[21];
                        $med[$i]['cantidad_por_presentacion_comercial']                 = $value[22];
                        $med[$i]['unidad_de_dispensacion_de_la_presentacion_comercial']     = $value[23];
                        $med[$i]['estado_registro_sanitario']       = $value[24];
                        $med[$i]['titular']             = $value[25];
                        $med[$i]['id_mercado']          = $value[26];
                        $med[$i]['descripcion_mercado'] = $value[27];

                        $med[$i]['forma_farmaceutica_agrupada']         = $value[28];
                        $med[$i]['precio_promedio_colombia']            = $value[29];
                        // este campo esta pendiente de definir, ya que se sube el excel o lo generamos con php
                        //$med[$i]['medicamentos']		= $value[30];
                        // es necesario revisar esto
                        $med[$i]['medicamentos'] = 	$med[$i]['producto'].' ';
                    	$med[$i]['medicamentos'] .= $med[$i]['cantidad_principio_activo'];
                    	$med[$i]['medicamentos'] .= (empty($med[$i]['cantidad_principio_activo_secundario'])) ? ' '. $med[$i]['unidad_base'] : '/'. $med[$i]['cantidad_principio_activo_secundario'];
                    	$med[$i]['medicamentos'] .= (empty($med[$i]['volumen'])) ? ' ' : $med[$i]['volumen'].' - '. $med[$i]['unidad_volumen'];
                    	$med[$i]['medicamentos'] .= (empty($med[$i]['concentracion'])) ? ' ' : $med[$i]['concentracion'].' - '. $med[$i]['unidad_concentracion'];
                    	$med[$i]['medicamentos'] .= ' '.$med[$i]['titular'];
                    	//echo "S: ". $med[$i]['medicamentos'];
                        $med[$i]['usuario_asignado']    = null;
                        $med[$i]['orden']               = null;
                        $med[$i]['estado']              = 'Nuevo registro';
                        $med[$i]['habilitado']          = 1;
                    }	
				}
				$id_meds_registros = $this->medicamentos_model->guardar_medicamento_archivo($med);
			    // 1. consultar las fuentes y crear el array deacuerdo al medicamentos
				//aqui (creamos/alimentamos) t3
	    		$variable_allinsert = $this->medicamentos_model->guardart3($id_registro);
	    	}


    	$text_msg = ($limite_for-1).' Nuevos registro(s)';
		$this->session->set_flashdata('message', $text_msg);	
		redirect('medicamentos/asignar', 'refresh');

		}//close else		
			
	}//close function

	function asignar()
	{
		$this->load->model('medicamentos_model');
		//GET if AJAX
		if($_GET){
			$id_med = $this->input->get('id');
			$id_usr = $this->input->get('id_usr');
			$this->medicamentos_model->asignar_med_usr($id_med, $id_usr);
			//$id_med = $this->input->get('');
		}else{
			$data['list_asignacion'] = $this->medicamentos_model->fing_asignar();
			// esta variable podria llamar el model de ion_auth...
			$data['usuarios'] = $this->medicamentos_model->usuarios();

			$this->layout->view('medicamentos/asignar', $data);
		}

		/*$this->load->model('medicamentos_model');
		//GET if AJAX
		if($_GET){
			$id_med = $this->input->get('id');
			$id_usr = $this->input->get('id_usr');
			$this->medicamentos_model->asignar_med_usr($id_med, $id_usr);
			//$id_med = $this->input->get('');
		}else{
			$data['list_asignacion'] = $this->medicamentos_model->fing_asignar();
			// esta variable podria llamar el model de ion_auth...
			$data['usuarios'] = $this->medicamentos_model->usuarios();

			$this->layout->view('medicamentos/asignar', $data);
		}*/

	}

	// esta es la funcion que llama los medicamentos que le fueron asignados a los usuarios
	function asignados($id_reg = null)
	{
		$this->load->model('medicamentos_model');

		if (empty($id_reg)) {
			$data['medicamentos'] = $this->medicamentos_model->asignados($this->user->id);
			$this->layout->view('medicamentos/asignados', $data);
		}else{
			// esto deberia ser un query segun la cola de trabajo
			$data['dta_reff'] = $this->medicamentos_model->find_medicamento_reff($id_reg, $this->user->id);
			$data['arrowsleft'] = $this->medicamentos_model->find_medicamento_reff($id_reg-1, $this->user->id);
			$data['arrowsright'] = $this->medicamentos_model->find_medicamento_reff($id_reg+1, $this->user->id);

			$this->layout->view('medicamentos/asignados-form', $data);
		}
	}

	function guardar_referencia($id_sig = null)
	{
		$this->load->model('medicamentos_model');
		//falta validar por lado del servidor
		if ($_POST) {

			// if $_FILES
			//ellislab.com/codeigniter/user-guide/libraries/file_uploading.html
			if (!empty($_FILES['userfile']['size'])) {	
				if (isset($_FILES['userfile'])) {
					$org_name = str_replace(" ", "_", $_FILES['userfile']['name']);
				}else{
					$org_name = 'null';
				}

				//rename file 
				$config['file_name'] = date("Y-m-d_H-i-s").'_'.$org_name;
				$config['upload_path'] = './assets/uploads/soportes/';
				//$config['allowed_types'] = 'text/plain|text/anytext|csv|.csv|text/x-comma-separated-values|text/comma-separated-values|application/octet-stream|application/vnd.ms-excel|application/x-csv|text/x-csv|text/csv|application/csv|application/excel|application/vnd.msexcel';
				$config['allowed_types'] = 'gif|jpg|png|pdf|txt|csv';
		    	//dude
		    	$config['max_size']      = '0';
				$config['overwrite'] = TRUE;
				//aprox 5~6 MB
				//$config['max_size']	= '6144';

				$this->load->library('upload', $config);
				$this->upload->do_upload();
			}

			$id_reff = $this->input->post('id_reff', true);

			$reff = array(
					"precio_referencia" => $this->input->post('precio_referencia', true),
					"cantidad" => $this->input->post('cantidad_referencia', true),
					"precio_por_unidad" => $this->input->post('precio_por_unidad', true),
					"casual_no_precio" => $this->input->post('casual_no_precio', true),
					"link" => $this->input->post('link', true),
					"nombre_archivo" =>  (isset($config['file_name'])) ? $config['file_name'] : 'Sin Archivos Registrados',
					"nombre_archivo_original" =>  (isset($org_name)) ? $org_name : 'Sin Archivos Registrados',
					"estado" => $this->input->post('estado', true),
					"fecha_registro" => date("Y-m-d H:i:s"),
					"comentario" => $this->input->post('comentario', true),
					"habilitado" => 1,
				);
			
			$this->medicamentos_model->update_reff($id_reff, $reff);
			redirect('/medicamentos/asignados/'.$id_sig, 'refresh');

		}
	}

	function consolidado(){
		$this->load->model('medicamentos_model');
		$data['consolidado'] = $this->medicamentos_model->generar_excel_model()->result_array();
		$this->layout->view('medicamentos/consolidado', $data);
	}

	function generar_excel(){
		$this->load->model('medicamentos_model');
		$sql = $this->medicamentos_model->generar_excel_model();
		$this->export->to_excel($sql, 'Base-PRI'); 
	}

	function generar_excel_all(){
		$this->load->model('medicamentos_model');
		$sql = $this->medicamentos_model->generar_excel_model_all();
		$this->export->to_excel($sql, 'Base-PRI-All'); 
	}
}