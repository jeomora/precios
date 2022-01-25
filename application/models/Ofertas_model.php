<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ofertas_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "ofertas";
		$this->PRI_INDEX = "id_oferta";
	}

	public function getDobles($where=[],$value){
		$this->db->select("*")
		->from("ofertas")
		->where("estatus <> 0")
		->where("CURDATE() > fecha_inicio")
		->where("CURDATE() < fecha_termino")
		->where("codigo = '".$value."'");
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

	public function getactivas($where=[]){
		$this->db->select("*")
		->from("ofertas")
		->where("estatus <> 0")
		->where("CURDATE() < fecha_termino")
		->order_by("conjunto","DESC");
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

	public function getMaxReg($where=[]){
		$this->db->select("MAX(conjunto) as fecha from ofertas");
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

	public function getOferton($where=[]){
		$this->db->select("o.id_oferta,o.fecha_registro,o.fecha_inicio,o.fecha_termino,o.id_producto,o.codigo,o.nombre,o.precio,o.nombre,o.maximo,o.estatus,o.tipo,p.codigo, u.ides,l.iva,p.ums,lo.estatus as liston")
		->from("ofertas o")
		->join("productos p","o.codigo = p.codigo","LEFT")
		->join("unidades u","p.ums = u.id_unidad","LEFT")
		->join("lineas l","p.linea = l.id_linea","LEFT")
		->join("listosOf lo","o.id_oferta = lo.id_detalle","LEFT")
		->order_by("id_oferta","ASC");
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

/* End of file Ofertas_model.php */
/* Location: ./application/models/Grupos_model.php */