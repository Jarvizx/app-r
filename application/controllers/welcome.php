<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public $user;

	function __construct() {  
		

	    parent::__construct();
		$this->load->library('ion_auth');
	    $this->load->helper(array('form', 'url'));
	
	    if (!$this->ion_auth->logged_in()) {
	       	// redirect to login view
			$this->session->set_flashdata('message', 'yuka');	
			redirect('auth/login', 'refresh');

	    }
	    $this->user = $this->ion_auth->user()->row();
	}
	public function index()
	{
		echo "<pre>";
	    	print_r($this->user->user_id);
		echo "</pre>";
		$this->load->view('welcome_message');
	}

	public function holamundo()
	{
		echo "string";
		$this->load->view('welcome_message');
	}

	public function formulariofile(){
		$this->load->view('upload_form', array('error' => ' ' ));
	}

	public function folder()
	{
		//ellislab.com/codeigniter/user-guide/libraries/file_uploading.html
		if (isset($_FILES['userfile'])) {
			$org_name = $_FILES['userfile']['name'];
		}else{
			$org_name = null;
		}

		$config['file_name'] = date("Y-m-d_H-i-s").'_'.$org_name;
		$config['upload_path'] = './assets/uploads/csv/';
		//$config['allowed_types'] = 'text/plain|text/anytext|csv|.csv|text/x-comma-separated-values|text/comma-separated-values|application/octet-stream|application/vnd.ms-excel|application/x-csv|text/x-csv|text/csv|application/csv|application/excel|application/vnd.msexcel';
		$config['allowed_types'] = 'csv|txt';
		$config['overwrite'] = TRUE;
		//aprox 5~6 MB
		$config['max_size']	= '6144';

		$this->load->library('upload', $config);


		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload);

			$this->load->view('upload_form', $error);
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			echo "<pre>";
			print_r($this->upload->data());
			echo "</pre>";
			exit();

			$nombre_db = (isset($this->input->post('nombre-db', true))) ? $this->input->post('nombre-db', true) : date("Y-m-d H:i:s");

			$primer_insert = array(
								"id" => null,
								"nombre_db" => $nombre_db,
								"nombre_archivo_original" => "",
								"nombre_archivo_actual" => "",
								"fecha_registro" => "",
								"habilitado" => "",
								"usuario" => ""
								);

			$this->load->view('upload_success', $data);
		}

/*
1, subo el archivo + renombrarlo
2, procesar el archivo en su primera version con un while o foreach, despues podemos utilizar (http://stackoverflow.com/a/11449458/2268240)
3, realizar los 2 insert

*/


		# en futuras versiones, seria bueno que  exista la  carpeta padre (ej: 2014-07-29)
		# y el archivo que se sube, deberia alojarse en una nueva carpeta hija (ej: 2014-07-29/06.19.56/fileUpload.txt)
		# ----
		# el nombre de este archivo + el sha1_file + current time_stamp se deben almacenar en la base de datos
		//$date = date('Y-m-d H.i.s');
		//define('PATH_FILE_UPLOAD', './uploadf/'.$date);
		//mkdir(PATH_FILE_UPLOAD, 0777, true);
		
		//$file = PATH_FILE_UPLOAD.'/'.$filename;
//text/x-comma-separated-values|text/comma-separated-values|application/octet-stream|application/vnd.ms-excel|application/x-csv|text/x-csv|text/csv|application/csv|application/excel|application/vnd.msexcel
		//echo "se creo la carpeta con exito!";
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

/*
Fuente http://www.infotuts.com/import-csv-file-data-in-mysql-php/
######la vista

<form action="">
	<textarea name="example" wrap="off"></textarea>
	<input type="submit">
</form>
<?php
echo "<pre>";
print_r($_GET);
echo "</pre>";
$i=0;
foreach(preg_split("/((\r?\n)|(\r\n?))/", $_GET['example']) as $line){
 print_r($line);
 echo "<br>here->".$i;
 print_r(explode(";", $line));
 $i++;   
} 
/*
$connect = mysql_connect('localhost','root','1q2w3e');
if (!$connect) {
die('Could not connect to MySQL: ' . mysql_error());
}

$cid =mysql_select_db('test',$connect);
// supply your database name

$showc = 'SHOW COLUMNS FROM csvdata';
$n=mysql_query($query, $connect );
print_r($n);
exit();

define('CSV_PATH','/var/www/html/');
// path where your CSV file is located

$csv_file = CSV_PATH . "infotuts.csv"; // Name of your CSV file
$csvfile = fopen($csv_file, 'r');
$theData = fgets($csvfile);
$i = 0;
while (!feof($csvfile)) {
$csv_data[] = fgets($csvfile, 1024);
$csv_array = explode(";", $csv_data[$i]);
$insert_csv = array();
//$insert_csv['ID'] = $csv_array[0];
//$insert_csv['name'] = $csv_array[1];
//$insert_csv['email'] = $csv_array[2];
//$query = "INSERT INTO csvdata(ID,name,email)
//VALUES('','".$insert_csv['name']."','".$insert_csv['email']."')";
//$n=mysql_query($query, $connect );
//$i++;
}
fclose($csvfile);

echo "File data successfully imported to database!!";
mysql_close($connect);*/

?>