<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entradas_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "entradas";
		$this->PRI_INDEX = "id_entrada";
	}

	public function hayRemisiones($where=[]){
		$this->db->select("* FROM entradas WHERE DATE(fecha_registro) = DATE(CURDATE())");
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

	public function getMisEntradas($where = [],$id_sucursal){
		$this->db->select("drs.id_detalle,r.id_entrada,r.folio,r.fecha_registro,r.proveedor,r.provee, r.fecha,r.subtotal,r.siniva,r.iva,r.estatus,r.agrego,r.total,drs.producto,drs.descripcion,drs.familia,drs.unidad,drs.cantidad,drs.precio,drs.importe FROM entradas r RIGHT JOIN detalleentra drs ON r.id_entrada = drs.id_remision WHERE r.estatus = 1 AND r.id_sucursal =".$id_sucursal." AND DATE(r.fecha_registro) = DATE(CURDATE())")
		->order_by("r.id_entrada","ASC");


		if ($where !== NULL) {
			if (is_array($where)) {
				foreach ($where as $field=>$value) {
					$this->db->where($field, $value);
				}
			} else {
				$this->db->where($this->PRI_INDEX, $where);
			}
		}
		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		$flag = 0;
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada[$comparativa[$i]->id_entrada])) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_entrada]				=	[];
				$comparativaIndexada[$comparativa[$i]->id_entrada]["folio"]	=	$comparativa[$i]->folio;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["fecha"]	=	$comparativa[$i]->fecha;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["subtotal"]		=	$comparativa[$i]->subtotal;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["id_entrada"]=	$comparativa[$i]->id_entrada;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["siniva"]	=	$comparativa[$i]->siniva;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["estatus"]		=	$comparativa[$i]->estatus;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["agrego"]=	$comparativa[$i]->agrego;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["total"]=	$comparativa[$i]->total;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["proveedor"]=	$comparativa[$i]->proveedor;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["provee"]=	$comparativa[$i]->provee;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"]				=	[];
			}


			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["producto"] =	$comparativa[$i]->producto;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["descripcion"] =	$comparativa[$i]->descripcion;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["familia"] =	$comparativa[$i]->familia;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["unidad"] =	$comparativa[$i]->unidad;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["cantidad"] =	$comparativa[$i]->cantidad;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["precio"] =	$comparativa[$i]->precio;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["importe"] =	$comparativa[$i]->importe;
			
		}
		if ($comparativaIndexada) {
			if (is_array($where)) {
				return $comparativaIndexada;
			} else {
				return $comparativaIndexada;
			}
		} else {
			return false;
		}
	}

	public function getMisDevoluciones($where = [],$id_sucursal){
		$this->db->select("drs.id_detalle,r.id_entrada,r.folio,r.fecha_registro,r.proveedor,r.provee,r.fecha,r.subtotal,r.siniva,r.iva,r.estatus,r.agrego,r.total,drs.producto,drs.descripcion,drs.familia,drs.unidad,drs.cantidad,drs.precio,drs.importe FROM entradas r RIGHT JOIN detalleentra drs ON r.id_entrada = drs.id_remision WHERE r.estatus = 2 AND r.id_sucursal =".$id_sucursal." AND DATE(r.fecha_registro) = DATE(CURDATE())")
		->order_by("r.id_entrada","ASC");


		if ($where !== NULL) {
			if (is_array($where)) {
				foreach ($where as $field=>$value) {
					$this->db->where($field, $value);
				}
			} else {
				$this->db->where($this->PRI_INDEX, $where);
			}
		}
		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		$flag = 0;
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada[$comparativa[$i]->id_entrada])) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_entrada]				=	[];
				$comparativaIndexada[$comparativa[$i]->id_entrada]["folio"]	=	$comparativa[$i]->folio;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["fecha"]	=	$comparativa[$i]->fecha;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["subtotal"]		=	$comparativa[$i]->subtotal;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["id_entrada"]=	$comparativa[$i]->id_entrada;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["siniva"]	=	$comparativa[$i]->siniva;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["estatus"]		=	$comparativa[$i]->estatus;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["agrego"]=	$comparativa[$i]->agrego;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["total"]=	$comparativa[$i]->total;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["proveedor"]=	$comparativa[$i]->proveedor;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["provee"]=	$comparativa[$i]->provee;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"]				=	[];
			}


			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["producto"] =	$comparativa[$i]->producto;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["descripcion"] =	$comparativa[$i]->descripcion;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["familia"] =	$comparativa[$i]->familia;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["unidad"] =	$comparativa[$i]->unidad;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["cantidad"] =	$comparativa[$i]->cantidad;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["precio"] =	$comparativa[$i]->precio;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["importe"] =	$comparativa[$i]->importe;
			
		}
		if ($comparativaIndexada) {
			if (is_array($where)) {
				return $comparativaIndexada;
			} else {
				return $comparativaIndexada;
			}
		} else {
			return false;
		}
	}

	public function getEntradas($where = []){
		$this->db->select("SUM(total) as total,id_sucursal,fecha_registro")
		->from("entradas")
		->where("estatus",1)
		->group_by("id_sucursal,DATE(fecha_registro)")
		->order_by("fecha_registro","DESC");


		if ($where !== NULL) {
			if (is_array($where)) {
				foreach ($where as $field=>$value) {
					$this->db->where($field, $value);
				}
			} else {
				$this->db->where($this->PRI_INDEX, $where);
			}
		}
		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		$flag = 0;
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada[$comparativa[$i]->id_sucursal])) {
				if (isset($comparativaIndexada[$comparativa[$i]->id_sucursal]["total2"])) {
					
				}else{
					$comparativaIndexada[$comparativa[$i]->id_sucursal]["total2"]	=	$comparativa[$i]->total;
					$comparativaIndexada[$comparativa[$i]->id_sucursal]["fecha_registro2"]	=	$comparativa[$i]->fecha_registro;
					$flag++;
				}
			}else{
				$comparativaIndexada[$comparativa[$i]->id_sucursal]				=	[];
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["total"]	=	$comparativa[$i]->total;
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["id_sucursal"]		=	$comparativa[$i]->id_sucursal;
			}
			
			
			if ($flag == 10){
				break;
			}

		}
		if ($comparativaIndexada) {
			if (is_array($where)) {
				return $comparativaIndexada;
			} else {
				return $comparativaIndexada;
			}
		} else {
			return false;
		}
	}

	public function getSucusRemisiones($where = []){
		$this->db->select("drs.id_detalle,r.id_entrada,r.folio,r.fecha_registro,r.proveedor,r.provee, r.fecha,r.subtotal,r.siniva,r.iva,r.estatus,r.agrego,r.total,drs.producto,drs.descripcion,drs.familia,drs.unidad,drs.cantidad,drs.precio,drs.importe FROM entradas r RIGHT JOIN detalleentra drs ON r.id_entrada = drs.id_remision WHERE r.estatus = 1 AND r.id_sucursal =".$id_sucursal." AND DATE(r.fecha_registro) = DATE(CURDATE())")
		->order_by("r.id_entrada","ASC");


		if ($where !== NULL) {
			if (is_array($where)) {
				foreach ($where as $field=>$value) {
					$this->db->where($field, $value);
				}
			} else {
				$this->db->where($this->PRI_INDEX, $where);
			}
		}
		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		$flag = 0;
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada[$comparativa[$i]->id_entrada])) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_entrada]				=	[];
				$comparativaIndexada[$comparativa[$i]->id_entrada]["folio"]	=	$comparativa[$i]->folio;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["fecha"]	=	$comparativa[$i]->fecha;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["subtotal"]		=	$comparativa[$i]->subtotal;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["id_entrada"]=	$comparativa[$i]->id_entrada;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["siniva"]	=	$comparativa[$i]->siniva;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["estatus"]		=	$comparativa[$i]->estatus;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["agrego"]=	$comparativa[$i]->agrego;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["total"]=	$comparativa[$i]->total;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["proveedor"]=	$comparativa[$i]->proveedor;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["provee"]=	$comparativa[$i]->provee;
				$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"]				=	[];
			}


			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["producto"] =	$comparativa[$i]->producto;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["descripcion"] =	$comparativa[$i]->descripcion;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["familia"] =	$comparativa[$i]->familia;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["unidad"] =	$comparativa[$i]->unidad;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["cantidad"] =	$comparativa[$i]->cantidad;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["precio"] =	$comparativa[$i]->precio;
			$comparativaIndexada[$comparativa[$i]->id_entrada]["detalles"][$comparativa[$i]->id_detalle]["importe"] =	$comparativa[$i]->importe;
			
		}
		if ($comparativaIndexada) {
			if (is_array($where)) {
				return $comparativaIndexada;
			} else {
				return $comparativaIndexada;
			}
		} else {
			return false;
		}
	}

	public function remisMatriz($where=[],$wheros=[]){
		$this->db->select("* FROM entradas WHERE DATE(fecha_registro) = DATE(' ".$wheros['fecha']." ') AND id_sucursal = ".$wheros['id_sucursal']." AND folio = '".$wheros['folio']."'");
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