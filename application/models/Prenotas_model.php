<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prenotas_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "zprenota";
		$this->PRI_INDEX = "id_prenota";
	}

	public function getPreLast($where=[]){
		$this->db->select("MAX(identificador) as lastgas")
		->from("zprenota");
		if ($where !== NULL) {
			if (is_array($where)) {
				foreach ($where as $field=>$value) {
					$this->db->where($field, $value);
				}
			} else {
				$this->db->where($this->PRI_INDEX, $where);
			}
		}
		$result = $this->db->get()->result();
		if ($result) {
			if (is_array($where)) {
				return $result;
			} else {
				return array_shift($result);
			}
		} else {
			return false;
		}
	}

	public function getPrenota($where=[],$id_s){
		$this->db->select("zp.id_prenota,zp.folio,zp.fecha_registro,zp.estatus,zp.proveedor,zp.codigo,zp.cantidad,zp.identificador,zp.ides,zp.nombre,p.codigo as pcodigo,p.nombre as pnombre,px.preciocinco,l.costo,u.ides")
		->from("zprenota zp")
		->join("productos p","zp.ides = p.id_producto","LEFT")
		->join("precios px","zp.ides = px.id_precio AND px.estatus = 1","LEFT")
		->join("lastcos l","zp.ides = l.id_producto AND l.estatus = 1","LEFT")
		->join("unidades u","p.ums = u.id_unidad","LEFT")
		->where("zp.identificador",$id_s)
		->order_by("zp.id_prenota","ASC");
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