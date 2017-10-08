<?php

class Transacoes extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function insert_transacao($data){
        $this->db->insert('transacoes', $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    function get_saida_user($id, $data_ini, $data_fim){
        $this->db->where('tipo_valor',2);
        $this->db->where('flparcela',0);
    	$this->db->where('id_usuario_fk', $id);
        $this->db->where('data >=', $data_ini);
        $this->db->where('data <=', $data_fim);
        $this->db->order_by('data', 'id_transacoes');
    	$query = $this->db->get('transacoes');

    	$rows = $query->result_array();

    	if($rows){
    		return $rows;
    	}else
    		return array();
    }

    function get_saida_user_parcela($id, $data_fim){
        $this->db->where('tipo_valor',2);
        $this->db->where('flparcela',1);
        $this->db->where('id_usuario_fk', $id);
        $this->db->where('data <=', $data_fim);
        $this->db->order_by('data', 'id_transacoes');
        $query = $this->db->get('transacoes');

        $rows = $query->result_array();

        if($rows){
            return $rows;
        }else
            return array();
    }

    function get_entrada_user($id, $data_ini, $data_fim){
        $this->db->where('tipo_valor',1);
        $this->db->where('flparcela',0);
        $this->db->where('id_usuario_fk', $id);
        $this->db->where('data >=', $data_ini);
        $this->db->where('data <=', $data_fim);
        $this->db->order_by('data', 'id_transacoes');
        $query = $this->db->get('transacoes');
        $rows = $query->result_array();

        if($rows){
            return $rows;
        }else
            return array();
    }

    function get_entrada_user_parcela($id, $data_fim){
        $this->db->where('tipo_valor',1);
        $this->db->where('flparcela',1);
        $this->db->where('id_usuario_fk', $id);
        $this->db->where('data <=', $data_fim);
        $this->db->order_by('data', 'id_transacoes');
        $query = $this->db->get('transacoes');
        
        $rows = $query->result_array();

        if($rows){
            return $rows;
        }else
            return array();
    }
}

?>