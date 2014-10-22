<?php
class VAriables_Model  extends CI_Model  {

	function __construct()
    {
        parent::__construct();
		$this->load->database();

    }

    function find_tipo_precio()
    {
    	$query = 'SELECT * FROM tipo_precio WHERE habilitado=1';
    	$data = $this->db->query($query);
    	return $data->result_array();
    }

    function find_pais()
    {
        $sql = "SELECT * FROM pais where habilitado = 1";
        $data = $this->db->query($sql);
        return $data->result_array();
    }

    function guardar_pais($pais_array = null)
    {
    	if(!empty($pais_array)){
            $this->db->insert('pais', $pais_array);
            return $this->db->insert_id();
        }
    }

    function guardar_fuentes($fuentes_array = null)
    {
    	if(!empty($fuentes_array)){
            $this->db->insert_batch('fuentes', $fuentes_array);
            return $this->db->insert_id();
        }
    }

    function find_pais_fuente()
    {
        $sql = "SELECT 
                t1.id, t1.nombre as nombre_pais, t1.moneda, 
                GROUP_CONCAT(distinct t2.nombre SEPARATOR ' - ') as nombre_fuente,
                GROUP_CONCAT(t2.tipo_precio SEPARATOR ' - ') as tipo_precio
                from pais as t1
                inner join fuentes as t2
                on t1.id = t2.id_pais
                group by t1.id";
        return $this->db->query($sql);
    }

    function find_pais_fuente_id($id = null)
    {
        $sql = "SELECT 
                t1.id, t2.id as id_fuente, t1.nombre as nombre_pais, t1.moneda, t2.nombre, t2.tipo_precio, t2.link, t2.nombre_archivo_original, t2.habilitado
                from pais as t1
                inner join fuentes as t2
                on t1.id = t2.id_pais
                and t1.id = ".$id."";
        return $this->db->query($sql);
    }


}
?>