<?php
class Medicamentos_Model  extends CI_Model  {

	function __construct()
    {
        parent::__construct();
		$this->load->database();

    }

    function mostrar_columnas()
    {
    
    	$query = 'SHOW COLUMNS FROM medicamentos';
    	$data = $this->db->query($query);
    	return $data->result_array();

    }
    function guardar_registro_medicamento_archivo($registro_array = null)
    {
        if(!empty($registro_array)){
            $this->db->insert('registros_archivos_excel', $registro_array);
            return $this->db->insert_id();
        }

    }

    function guardar_medicamento_archivo($med_array = null)
    {
    	if(!empty($med_array)){
            // f: https://ellislab.com/codeigniter/user-guide/database/active_record.html#insert
            return $this->db->insert_batch('medicamentos', $med_array);   
    	}

    }

    function guardart3($id_registro = null)
    {
        $sql1 = $this->db->query('SELECT id from medicamentos where id_registro_archivo='.$id_registro.'')->result_array();
        $sql2 = $this->db->query('SELECT id from fuentes where habilitado=1')->result_array();
        $i = 0;
        foreach ($sql1 as $keym => $valuem) {
            foreach ($sql2 as $keyf => $valuef) {

                $t3[$i]['id'] = null;
                $t3[$i]['id_medicamento'] = $valuem['id'];
                $t3[$i]['id_fuente'] = $valuef['id'];
                $t3[$i]['precio_referencia'] = null;
                $t3[$i]['cantidad'] = null;
                $t3[$i]['precio_por_unidad'] = null;
                $t3[$i]['casual_no_precio'] = null;
                $t3[$i]['link'] = null;
                $t3[$i]['nombre_archivo'] = null;
                $t3[$i]['nombre_archivo_original'] = null;
                $t3[$i]['estado'] = 'sin asignar';
                $t3[$i]['habilitado'] = 1;
                $t3[$i]['fecha_registro'] = date("Y-m-d H:i:s");
                $t3[$i]['comentario'] = null;
                $t3[$i]['usuario_asignado'] = null;
                $t3[$i]['orden'] = $keyf+1;
                $this->db->insert('precio_reff', $t3[$i]);

                $i++;

            }
        }

        return true;

        /*echo "<pre>";
        print_r($sql1);
        echo "--<br>--";
        print_r($sql2);
        echo "</pre>";
        exit();*/
    }

    function fing_asignar()
    {
        $query = 'SELECT m.id, m.expediente_ficha, m.medicamentos, r.nombre_db, u.id as id_usr,
                     m.estado, pr.estado as estado_referencia
                    from medicamentos as m 
                    inner join registros_archivos_excel as r 
                    on m.id_registro_archivo = r.id 
                    inner join precio_reff as pr
                    on pr.id_medicamento = m.id
                    left join users as u on pr.usuario_asignado = u.id
                    group by pr.id_medicamento';
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function usuarios()
    {
        $query = 'SELECT u.id, u.username from users as u where active = 1';
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function find_medicamento_reff($id_registro = null, $id_usr = null)
    {
        $query = 'SELECT t1.id, t1.estado, t1.precio_referencia, t1.link, t1.cantidad, t1.comentario, t1.casual_no_precio, t2.medicamentos, t3.nombre as nombre_fuente, t3.link as link_fuente,
                    t3.nombre_archivo, t3.nombre_archivo_original, t4.nombre as nombre_pais, t4.moneda, t3.tipo_precio
                    from precio_reff as t1
                    inner join medicamentos as t2
                    on t1.id_medicamento = t2.id
                    inner join fuentes as t3
                    on t1.id_fuente = t3.id
                    inner join pais as t4
                    on t3.id_pais = t4.id
                    and t1.usuario_asignado = '.$id_usr.'
                    and t1.id = '.$id_registro.'';
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function asignar_med_usr($id_med = null, $id_usr = null)
    {
        if (!empty($id_med) && !empty($id_usr)) {
            $query_update = 'UPDATE precio_reff set usuario_asignado = '.$id_usr.', estado = "Medicamentos asignado" where id_medicamento = '.$id_med.' AND estado <> "Guardado"';
            //$query_update = 'UPDATE medicamentos set usuario_asignado = '.$id_usr.', estado = "Medicamentos asignado" where id = '.$id_med.'';
            return $this->db->query($query_update); 
            echo "SQL: ". $this->db->last_query();
        }

    }

    function asignados($id_usr = null)
    {
        $query = 'SELECT t1.id, t1.estado, t2.medicamentos, t3.nombre as nombre_fuente, t4.nombre as nombre_pais
                    from precio_reff as t1
                    inner join medicamentos as t2
                    on t1.id_medicamento = t2.id
                    inner join fuentes as t3
                    on t1.id_fuente = t3.id
                    inner join pais as t4
                    on t3.id_pais = t4.id
                    and t1.usuario_asignado = '.$id_usr.'
                    order by t1.orden';
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function find_reff()
    {
        $query = 'SELECT * from fuentes';
        $data = $this->db->query($query);
        return $data->result_array();
    }

    function update_reff($id = null, $data = null){
        $this->db->where('id', $id);
        $this->db->update('precio_reff', $data);
    }

    function generar_excel_model(){
        $sql = 'SELECT t2.id_mercado, t2.descripcion_mercado, t2.atc_invima, t2.descripcion_atc, t2.forma_farmaceutica, t2.expediente_ficha, t2.expediente, t2.medicamentos, t4.nombre as pais, t3.nombre as fuente, t3.tipo_precio, t4.moneda, t1.precio_referencia, t1.cantidad, t1.precio_por_unidad, t1.casual_no_precio, t1.link, t1.nombre_archivo
                    from precio_reff as t1
                    inner join medicamentos as t2
                    on t1.id_medicamento = t2.id
                    inner join fuentes as t3
                    on t1.id_fuente = t3.id
                    inner join pais as t4
                    on t3.id_pais = t4.id
                    where t1.estado = "Guardado"';
        return $this->db->query($sql);
    }

    function generar_excel_model_all(){
        $sql = 'SELECT t2.id_mercado, t2.descripcion_mercado, t2.atc_invima, t2.descripcion_atc, t2.forma_farmaceutica, t2.expediente_ficha, t2.expediente, t2.medicamentos, t4.nombre as pais, t3.nombre as fuente, t3.tipo_precio, t4.moneda, t1.precio_referencia, t1.cantidad, t1.precio_por_unidad, t1.casual_no_precio, t1.link, t1.nombre_archivo
                    from precio_reff as t1
                    inner join medicamentos as t2
                    on t1.id_medicamento = t2.id
                    inner join fuentes as t3
                    on t1.id_fuente = t3.id
                    inner join pais as t4
                    on t3.id_pais = t4.id
                    where t1.estado = "Guardado"';
        return $this->db->query($sql);
    }

    public function num_registros()
    {
        $sql = "SELECT COUNT(*) as c FROM precio_reff";
        return $this->db->query($sql)->result_array();
    }

    public function num_registros_asignados()
    {
        $sql = "SELECT COUNT(*) as c FROM precio_reff where usuario_asignado is not null";
        return $this->db->query($sql)->result_array();
    }

    public function num_registros_terminados()
    {
        $sql = "SELECT COUNT(*) as c FROM precio_reff where estado = 'Guardado'";
        return $this->db->query($sql)->result_array();
    }

    public function num_registros_user_asignados()
    {
        $sql = "SELECT t1.username, count(*) as c
                from users as t1
                inner join users_groups as t2
                on t1.id = t2.user_id
                inner join precio_reff as t3
                on t3.usuario_asignado = t1.id
                and t2.group_id = 3";

        return $this->db->query($sql)->result_array();
    }

    public function num_registros_user()
    {
        $sql = "SELECT t1.username, max(fecha_registro)r_recha_ultimo_registro, sum(if(estado='Guardado',1,0))r_terminados, count(*) as r_asignados
                from users as t1
                inner join users_groups as t2
                on t1.id = t2.user_id
                inner join precio_reff as t3
                on t3.usuario_asignado = t1.id
                and t2.group_id = 3
                group by t1.id";

        return $this->db->query($sql)->result_array();
    }

}
?>