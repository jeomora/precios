<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lineas_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "lineas";
		$this->PRI_INDEX = "id_linea";
	} 

	public function getLineas($where=[]){
		$this->db->select("nombre FROM lineas");
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