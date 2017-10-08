<?php

class Salarios extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function insert_salario(){
    	$salario = array(
    		'id_usuario_fk' => $this->session->userdata('user_id')
    	);

    	$salario = array_merge($this->input->post(), $salario);

    	$salario['data_salario'] = date('Y-m-d', strtotime($salario['data_salario']));
        $salario['data_vale'] = date('Y-m-d', strtotime($salario['data_vale']));

    	$this->db->insert('salarios', $salario);
    	$insert_id = $this->db->insert_id();

    	return $insert_id;
    }

    function get_salario_user($id){
    	$this->db->where('id_usuario_fk', $id);
    	$query = $this->db->get('salarios');

    	$row = $query->row_array();

    	if($row){
    		return $row;
    	}else
    		return false;
    }
}

?>