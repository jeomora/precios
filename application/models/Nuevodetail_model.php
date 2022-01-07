<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nuevodetail_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "nuevo_detail";
		$this->PRI_INDEX = "id_detail";
	} 

	public function getMaxReg($where=[]){
		$this->db->select("MAX(id_nuevo) as nuevo from nuevos");
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


	public function getNuevos($where=[],$val){
		$user = $this->session->userdata();
		$this->db->select("d.id_detail,d.id_nuevo,d.id_rojo,d.estatus,d.estatusb,d.code1,d.code2,d.linea,d.desc1,d.unidad,d.code3,d.desc2,d.cantidad,d.costo,d.iva,d.mar1,d.mar2,d.mar3,d.mar4,d.mar11,d.mar22,d.mar33,d.mar44,d.pre1,d.pre2,d.pre3,d.pre4,d.pre5, d.pre11,d.pre22,d.pre33,d.pre44,d.pre55,d.costopz,d.matriz,d.asociado,d.rdiez,d.proves,d.umcaja,l.estatus as liston")
		->from("nuevo_detail d")
		->join("listos l","d.id_detail = l.id_detalle AND l.id_sucursal = ".$user["id_sucursal"]."","LEFT")
		->where("d.id_nuevo",$val);
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