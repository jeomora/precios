<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "productos";
		$this->PRI_INDEX = "id_producto";
	}

	public function getProdSelect($where=[],$value){
		$values = json_decode($value);
		$buscando = explode(" ",$values->buscando);
		$cadena = "";
		foreach($buscando as $key => $busca){
			$cadena = $cadena." p.nombre LIKE '%".$busca."%' AND ";
		}
		$cadena = substr($cadena,0,-4);
		$this->db->select("p.id_producto as id,p.codigo,p.nombre,l.nombre as linea,l.ides,u.ides as unidad,ps.preciouno,ps.preciodos,ps.preciotres,ps.preciocuatro,ps.preciocinco FROM productos p LEFT JOIN lineas l ON p.linea = l.id_linea LEFT JOIN unidades u ON p.ums = u.id_unidad LEFT JOIN precios ps ON p.id_producto = ps.id_producto AND ps.estatus = 1 WHERE".$cadena." ORDER BY p.linea ASC LIMIT 20");
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
		$this->db->select("MAX(fecha_registro) as fecha from productos");
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

	public function getPlantilla($where=[]){
		$this->db->select("p.id_producto,p.codigo,p.nombre,p.code ,l.nombre as linea, l.ides, l.iva, u.ides as uns,pz.preciouno,pz.preciodos,pz.preciotres,pz.preciocuatro,pz.preciocinco")
		->from("productos p")
		->join("lineas l","p.linea = l.id_linea AND l.estatus = 1","LEFT")
		->join("unidades u","p.ums = u.id_unidad AND u.estatus = 1","LEFT")
		->join("precios pz","p.id_producto = pz.id_producto AND pz.estatus = 1","LEFT")
		->where("p.estatus",1)
		->order_by("l.ides,p.nombre","ASC");
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

	public function getPlantillaSin($where=[]){
		$this->db->select("p.id_producto,p.codigo,p.nombre,p.code ,l.nombre as linea, l.ides, l.iva, u.ides as uns")
		->from("productos p")
		->join("lineas l","p.linea = l.id_linea AND l.estatus = 1","LEFT")
		->join("unidades u","p.ums = u.id_unidad AND u.estatus = 1","LEFT")
		->where("p.estatus",1)
		->order_by("l.ides,p.nombre","ASC");
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