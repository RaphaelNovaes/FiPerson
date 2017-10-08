<?php

class Usuarios extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function insert_usuario(){
    	$this->db->insert('usuarios', $this->input->post());
    	$insert_id = $this->db->insert_id();

    	return array($insert_id, $this->input->post('nome'));
    }

    public function get_user($id){
    	$this->db->where('id_usuario', $id);
    	$query = $this->db->get('usuarios');

    	$row = $query->row_array();

    	if($row){
    		return $row;
    	}else
    		return false;
    }

    public function valid_user($user, $pass){
        $this->db->select('id_usuario, nome');
    	$this->db->where('login', $user);
    	$this->db->where('senha', $pass);
    	$query = $this->db->get('usuarios');

    	$row = $query->row_array();

    	if($row){
    		return $row;
    	}else
    		return false;
    }
}

?>