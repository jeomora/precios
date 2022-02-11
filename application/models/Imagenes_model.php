<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagenes_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "imagenes";
		$this->PRI_INDEX = "id_imagen";
	}

	public function getImagen($where=[],$id_por){
		$this->db->select("p.id_producto,p.codigo,p.nombre,i.url,i.tags,u.ides")
		->from("productos p")
		->join("imagenes i","p.imagen = i.id_imagen","LEFT")
		->join("unidades u","p.ums = u.id_unidad","LEFT")
		->where("p.id_producto",$id_por);
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

	public function getImagesB($where=[],$values){
		$value = json_decode($values);
		$this->db->select("i.url,i.tags,i.nombre,i.id_imagen")
		->from("imagenes i")
		->where("i.tags LIKE '%".$value->busca."%'")
		->limit(12);
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

	public function buscaProducto($where=[],$values){
		$value = json_decode($values);
		$this->db->select("p.nombre,p.codigo,i.url,i.id_imagen,p.imagen,p.id_producto,l.ides,l.nombre as linea,u.ides as unidad,i.tags,i.nombre as ima")
		->from("productos p")
		->join("lineas l","p.linea = l.id_linea","LEFT")
		->join("unidades u","p.ums = u.id_unidad","LEFT")
		->join("imagenes i","p.imagen = i.id_imagen","LEFT")
		->where("p.nombre LIKE '%".$value->busca."%' OR p.codigo LIKE '%".$value->busca."%'")
		->limit(10);
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