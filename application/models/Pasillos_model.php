<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pasillos_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "pasillos";
		$this->PRI_INDEX = "id_pasillo";
	}

	public function getPasillos($where=[]){
		$user = $this->session->userdata();
		$this->db->select("p.id_pasillo,p.nombre,p.imagen,p.id_sucursal,p.estatus,i.sumpas")
		->from("pasillos p")
		->join("(SELECT *,COUNT(id_pasillo) as sumpas FROM inventario GROUP BY id_pasillo) i","p.id_pasillo = i.id_pasillo AND i.estatus = 1","LEFT");
		if($where !== NULL){
			if(is_array($where)){
				foreach ($where as $field => $value) {
					$this->db->where($field, $value);
				}
			}else{
				$this->db->where($this->PRI_INDEX, $where);
			}
		}
		$result = $this->db->get()->result();
		if($result){
			if(is_array($where)){
				return $result;
			}else{
				return $result;
			}
		}else{
			return false;
		}
	}



}

/* End of file Grupos_model.php */
/* Location: ./application/models/Grupos_model.php */