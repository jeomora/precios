<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucproductos_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "sucproductos";
		$this->PRI_INDEX = "id_producto";
	}

	public function getComparacion($where = []){
		$user = $this->session->userdata();
		$this->db->select("p.id_producto,sp.codigo,sp.nombre,sp.ums,sp.code,spz.preciouno,spz.preciodos,spz.preciotres,spz.preciocuatro,spz.preciocinco, p.codigo as codigo2,p.nombre as nombre2,p.ums as ums2,p.code as code2,pz.preciouno as p1,pz.preciodos as p2,pz.preciotres as p3,pz.preciocuatro as p4,pz.preciocinco as p5")
		->from("sucproductos sp") 
		->join("sucprecios spz","sp.id_producto = spz.id_producto","LEFT")
		->join("productos p","sp.codigo = p.codigo","LEFT")
		->join("precios pz","p.id_producto = pz.id_producto AND pz.estatus = 1","LEFT")
		->where("sp.id_sucursal = ".$user['id_sucursal'])
		->having("p.id_producto IS NOT NULL AND spz.preciouno <> pz.preciouno")
		->group_by("sp.id_producto")
		->order_by("sp.nombre");

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