<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "inventario";
		$this->PRI_INDEX = "id_inventario";
	}

	public function getCodigo($where=[]){
		$user = $this->session->userdata();
		$this->db->select("s.id_producto,s.codigo,s.code,s.nombre,s.ums,s.code,s.id_sucursal,SUM(i.cantidad) as cantidad,MAX(i.fecha_registro) as fecha_registro,i.estatus,s.estatus as elim")
		->from("sucproductos s")
		->join("inventario i","s.id_producto = i.id_producto AND i.estatus = 1","LEFT");
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


	public function getCodigoCs($where=[]){
		$user = $this->session->userdata();
		$this->db->select("s.id_producto,s.codigo,s.code,s.nombre,s.ums,s.code,s.estatus as elim")
		->from("productos s");
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


public function getEntradas($where=[]){
		$user = $this->session->userdata();
		$this->db->select("i.id_inventario,i.id_producto,i.cantidad,i.fecha_registro,i.id_pasillo,s.nombre,s.codigo,s.ums")
		->from("inventario i")
		->join("sucproductos s","i.id_producto = s.id_producto","LEFT")
		->order_by("i.fecha_registro","DESC");
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