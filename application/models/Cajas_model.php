<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cajas_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "cajas";
		$this->PRI_INDEX = "id_caja";
	}

	public function getMaxReg($where=[]){
		$this->db->select("MAX(fecha_registro) as fecha from cajas");
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