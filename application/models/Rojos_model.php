<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rojos_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "rojos";
		$this->PRI_INDEX = "id_rojo";
	} 

	public function getMaxReg($where=[]){
		$this->db->select("MAX(fecha_registro) as fecha from rojos");
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

	public function getRojos($where = []){
		$this->db->select("r.id_rojo,r.codigo,r.descripcion,p.nombre,r.costo,r.fecha_registro,p.codigo as code1,p.code as code2,pr.preciocinco,l.ides,u.ides as uni,l.iva,preciouno,preciodos,preciotres,preciocuatro")
			->from("rojos r")
			->join("productos p","r.codigo = p.codigo","left")
			->join("precios pr","p.id_producto = pr.id_producto" ,"left")
			->join("lineas l ","p.linea = l.id_linea","left")
			->join("unidades u","p.ums = u.id_unidad","left") 
			->where("r.estatus = 1")
			->group_by("r.id_rojo")
			->order_by("r.fecha_registro","DESC");


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
			if (isset($comparativaIndexada[$comparativa[$i]->id_rojo])) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_rojo]				=	[];
				$comparativaIndexada[$comparativa[$i]->id_rojo]["descripcion"]	=	$comparativa[$i]->nombre;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["codigo"]	=	$comparativa[$i]->codigo;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["costo"]		=	$comparativa[$i]->costo;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["id_rojo"]=	$comparativa[$i]->id_rojo;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["code1"]	=	$comparativa[$i]->code1;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["code2"]		=	$comparativa[$i]->code2;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["preciouno"]=	$comparativa[$i]->preciouno;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["preciodos"]=	$comparativa[$i]->preciodos;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["preciotres"]=	$comparativa[$i]->preciotres;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["preciocuatro"]=	$comparativa[$i]->preciocuatro;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["preciocinco"]=	$comparativa[$i]->preciocinco;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["ides"]=	$comparativa[$i]->ides;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["uni"]=	$comparativa[$i]->uni;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["iva"]=	$comparativa[$i]->iva;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"]=	[];
				$flag++;
			}

			$this->db->select("c.id_caja,c.cajaco,c.cajaum,rcc.cantidad,rcc.id_catalogo,cg.codigo,cg.descripcion,preciocinco,preciouno,preciodos,preciotres,preciocuatro
					FROM cajas c 
					LEFT JOIN relcajacata rcc ON c.id_caja = rcc.id_caja 
					LEFT JOIN catalogo cg ON rcc.id_catalogo = cg.id_catalogo 
					LEFT JOIN productos p ON cg.codigo = cg.codigo 
					LEFT JOIN precios pr ON p.id_producto = pr.id_producto
					WHERE c.estatus = 1 AND c.cajaco = '".$comparativa[$i]->codigo."'")
				->order_by("c.id_caja","DESC");
			$comparativa2 = $this->db->get()->result();
			for ($e=0; $e<sizeof($comparativa2); $e++) {
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_catalogo]["codigo"] = $comparativa2[$e]->codigo;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_catalogo]["cantidad"] = $comparativa2[$e]->cantidad;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_catalogo]["descripcion"] = $comparativa2[$e]->descripcion;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_catalogo]["id_caja"] = $comparativa2[$e]->id_caja;

				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_catalogo]["preciouno"]=	$comparativa2[$e]->preciouno;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_catalogo]["preciodos"]=	$comparativa2[$e]->preciodos;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_catalogo]["preciotres"]=	$comparativa2[$e]->preciotres;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_catalogo]["preciocuatro"]=	$comparativa2[$e]->preciocuatro;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_catalogo]["preciocinco"]=	$comparativa2[$e]->preciocinco;
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

	public function getRojosCompras($where=[]){
		$user = $this->session->userdata();
		$this->db->select("r.id_rojo,r.codigo,r.descripcion,r.costo,DATE(r.fecha_registro) as fecha ,r.estatus,nd.id_nuevo,nd.linea,nd.cantidad,nd.costo as costo2,nd.iva,nd.matriz,nd.costopz,nd.pre1,nd.pre2,nd.pre3,nd.pre4,nd.pre5,nd.pre11,nd.pre22,nd.pre33,nd.pre44,nd.pre55,p.nombre as desco,p2.nombre as desco2,r.um_nuevo")
		->from("rojos r")
		->join("nuevo_detail nd" , "r.id_rojo = nd.id_rojo","LEFT")
		->join("productos p" , "r.codigo = p.codigo","LEFT")
		->join("productos p2" , "r.code_relacion = p2.codigo","LEFT")
		->where("r.estatus <> 0")
		->where("r.agrego",$user["id_usuario"])
		->where("r.fecha_registro BETWEEN DATE_SUB(CURDATE(), INTERVAL 21 DAY) AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)")
		->order_by("r.fecha_registro","DESC");
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