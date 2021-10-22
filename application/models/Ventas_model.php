<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ventas_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "ventas";
		$this->PRI_INDEX = "id_venta";
	}

	public function getVentas($where = []){
		$this->db->select("v.id_venta,v.cantidad,v.id_sucursal,v.id_usuario,v.fecha_registro,v.imagen,v.estatus,s.nombre,s.color FROM ventas v LEFT JOIN sucursales s ON v.id_sucursal = s.id_sucursal WHERE DATE(v.fecha_registro) = DATE(CURDATE()) OR DATE(v.fecha_registro) > DATE(DATE_SUB(CURDATE(),INTERVAL 3 DAY)) AND v.estatus = 1")
		->order_by("v.fecha_registro","DESC")
		->limit(200);


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
				if (isset($comparativaIndexada[$comparativa[$i]->id_sucursal]["cantidad2"])) {
					
				}else{
					$comparativaIndexada[$comparativa[$i]->id_sucursal]["cantidad2"]	=	$comparativa[$i]->cantidad;
					$comparativaIndexada[$comparativa[$i]->id_sucursal]["imagen2"]	=	$comparativa[$i]->imagen;
					$comparativaIndexada[$comparativa[$i]->id_sucursal]["fecha_registro2"]	=	$comparativa[$i]->fecha_registro;
					$comparativaIndexada[$comparativa[$i]->id_sucursal]["flag"]	=	$flag;
					$flag++;
				}
			}else{
				$comparativaIndexada[$comparativa[$i]->id_sucursal]				=	[];
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["nombre"]	=	$comparativa[$i]->nombre;
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["cantidad"]	=	$comparativa[$i]->cantidad;
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["id_usuario"]		=	$comparativa[$i]->id_usuario;
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["id_sucursal"]=	$comparativa[$i]->id_sucursal;
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["imagen"]	=	$comparativa[$i]->imagen;
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["estatus"]		=	$comparativa[$i]->estatus;
				$comparativaIndexada[$comparativa[$i]->id_sucursal]["color"]=	$comparativa[$i]->color;
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
}