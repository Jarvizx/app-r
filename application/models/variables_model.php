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
            
            foreach ($fuentes_array as $key => $value) {
                $this->db->insert('fuentes', $value);
                $id_returns[] = $this->db->insert_id();

            }


            // voo
            $sql2 = $this->db->query('SELECT id from medicamentos order by id asc')->result_array();
                
            foreach ($id_returns as $key => $if_f) {

                foreach ($sql2 as $key2 => $value2) {

                    $sqlhk = $this->db->query('SELECT usuario_asignado, estado, max(orden) as orden from precio_reff where estado regexp "Medicamentos asignado|sin asignar" and id_medicamento = '.$value2['id'].'')->result_array();
            
                    if ($sqlhk[0]['estado'] == 'Guardado') {
                        $sqlhk[0]['estado'] = 'Medicamentos asignado';
                    }

                    $fxm = array(
                            'id' => null,
                            'id_medicamento' => $value2['id'],
                            'id_fuente' => $if_f,
                            'precio_referencia' => null,
                            'cantidad' => null,
                            'precio_por_unidad' => null,
                            'casual_no_precio' => null,
                            'link' => null,
                            'nombre_archivo' => null,
                            'nombre_archivo_original' => null,
                            'estado' => $sqlhk[0]['estado'],
                            'habilitado' => 1,
                            'fecha_registro' => date("Y-m-d H:i:s"),
                            'comentario' => null,
                            'usuario_asignado' => $sqlhk[0]['usuario_asignado'],
                            'orden' => ($sqlhk[0]['orden']+1),
                            'codigo_de_referencia' => null,
                    );
                    $this->db->insert('precio_reff', $fxm);
                }
            }
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