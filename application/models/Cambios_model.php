<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cambios_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "cambios";
		$this->PRI_INDEX = "id_cambio";
	}

	public function getCambios($where=[]){
		$this->db->select("id_cambio, usuarios.nombre AS usuario, DATE_SUB(cambios.fecha_cambio, INTERVAL 5 HOUR) as fecha_cambio, antes, despues, accion")
		->from("cambios")
		->join("usuarios", $this->TABLE_NAME.".id_usuario = usuarios.id_usuario", "INNER")
		->order_by($this->TABLE_NAME.".fecha_cambio", "DESC");;
		
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
				return $result;
			}
		} else {
			return false;
		}
	}

	public function getCambioYa($where=[]){
		$this->db->select("c.id_cambio,c.estatus,c.fecha_cambio,c.antes,c.despues,s.nombre,s.typeSuc,n.fecha_registro,b.fecha_registro as fecha_b")
		->from("cambios c")
		->join("usuarios u", "c.id_usuario = u.id_usuario", "LEFT")
		->join("sucursales s", "u.id_sucursal = s.id_sucursal", "LEFT")
		->join("nuevos n", "c.estatus = n.id_nuevo", "LEFT")
		->join("nuevos b", "c.estatus = b.id_nuevo", "LEFT")
		->where("c.fecha_cambio BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)")
		->where("c.accion","YA EXISTE")
		->order_by("c.fecha_cambio", "DESC");;
		
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
				return $result;
			}
		} else {
			return false;
		}
	}



}

/* End of file Menus_model.php */
/* Location: ./application/models/Menus_model.php */
