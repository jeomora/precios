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
		->where("CURDATE() > DATE(fecha_inicio)")
		->where("CURDATE() < DATE(fecha_termino)")
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
		$this->db->select("o.id_oferta,o.fecha_registro,o.fecha_inicio,o.fecha_termino,o.id_producto,o.codigo,o.nombre,o.precio,o.normal,o.maximo,o.estatus,o.registro,o.tipo,o.conjunto,l.ides as ln,l.nombre as linea,u.ides as umedida,p.unidad,p.imagen,i.url,i.tags,i.nombre as imag")
		->from("ofertas o")
		->join("productos p","o.codigo = p.codigo","LEFT")
		->join("lineas l","p.linea = l.id_linea","LEFT")
		->join("unidades u","p.ums = u.id_unidad","LEFT")
		->join("imagenes i","p.imagen = i.id_imagen","LEFT")
		->where("o.estatus <> 0")
		->where("CURDATE() < o.fecha_termino")
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

	public function getRecientes($where=[]){
		$this->db->select("*")
		->from("ofertas")
		->where("estatus <> 0")
		->where("DATE_SUB(CURDATE(), INTERVAL 2 DAY) <= DATE(fecha_termino)")
		->where("CURDATE() > DATE(fecha_termino)")
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
		$this->db->select("o.id_oferta,o.fecha_registro,o.fecha_inicio,o.fecha_termino,o.id_producto,o.codigo,o.nombre,o.precio,o.nombre,o.normal,o.maximo,o.estatus,o.tipo,p.codigo, u.ides,l.iva,p.ums,lo.estatus as liston,pz.preciouno,pz.preciocinco")
		->from("ofertas o")
		->join("productos p","o.codigo = p.codigo","LEFT")
		->join("unidades u","p.ums = u.id_unidad","LEFT")
		->join("lineas l","p.linea = l.id_linea","LEFT")
		->join("precios pz","p.id_producto = pz.id_producto AND pz.estatus <> 0")
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