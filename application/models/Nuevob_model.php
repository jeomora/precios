<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nuevob_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "nuevo_b";
		$this->PRI_INDEX = "id_nuevo";
	}

	public function getNuevosB($where=[],$val){
		$user = $this->session->userdata();
		$this->db->select("d.id_detail,d.id_nuevo,d.id_rojo,d.estatus,d.code1,d.code2,d.linea,d.desc1,d.unidad,d.code3,d.desc2,d.cantidad,d.costo,d.iva,d.mar1,d.mar2,d.mar3,d.mar11,d.mar22,d.mar33,d.pre1,d.pre2,d.pre3, d.pre11,d.pre22,d.pre33,d.costopz,d.matriz,d.rdiez,d.proves,d.umcaja,l.estatus as liston,d.blues,s.nombre,e.existencia,s.codigo,sss.codigo as codigosss,sss.nombre as nombresss")
		->from("nuevo_b d")
		->join("listos l","d.id_detail = l.id_detalle AND l.id_sucursal = ".$user["id_sucursal"]."","LEFT")
		->join("sucproductos s","d.code1 = s.codigo and s.id_sucursal = ".$user["id_sucursal"]."","LEFT")
		->join("existencias e","s.id_producto = e.id_producto","LEFT")
		->join("sucproductos sss","d.code3 = sss.codigo and sss.id_sucursal = ".$user["id_sucursal"]."","LEFT")
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

/* End of file Grupos_model.php */
/* Location: ./application/models/Grupos_model.php */