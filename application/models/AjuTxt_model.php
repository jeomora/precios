<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjuTxt_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "ajuTxt";
		$this->PRI_INDEX = "id_entrada";
	}

	public function getDifesInves($where=[],$id_sucursal,$fecha){
		if($fecha == ""){
			$fecha = "CURDATE()";
		}else{
			$fecha = "'".$fecha."'";
		}
		$this->db->select("sp.codigo,sp.nombre,e.existencia,x.existencia as exis2,(x.existencia - e.existencia) as difos,((x.existencia - e.existencia) * l.costo) as difes,l.costo")
		->from("sucproductos sp")
		->join("existencias e","sp.id_producto = e.id_producto AND e.estatus = 1 AND DATE(e.fecha_registro) = ".$fecha."","LEFT")
		->join("existencias x","sp.id_producto = x.id_producto AND x.estatus = 1 AND DATE(x.fecha_registro) = DATE_SUB(".$fecha.", INTERVAL 1 DAY)","LEFT")
		->join("lastcossuc l","sp.id_producto = l.id_producto","LEFT")
		->where("sp.id_sucursal",$id_sucursal)
		->order_by("difes","DESC")
		->limit(20);
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


	public function entrando($where=[],$id_sucursal,$fecha){
		if($fecha == ""){
			$fecha = "CURDATE()";
		}else{
			$fecha = "'".$fecha."'";
		}
		$this->db->select("e.folio,e.provee,e.fecha,e.subtotal,e.total,e.agrego,d.producto,d.familia,d.descripcion,d.unidad,d.cantidad,d.precio,d.importe")
		->from("entradas e")
		->join("detalleentra d","e.id_entrada = d.id_remision","LEFT")
		->where("e.id_sucursal",$id_sucursal)
		->where("DATE(e.fecha_registro) = ".$fecha)
		->where("e.estatus",1)
		->order_by("e.folio","ASC");
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