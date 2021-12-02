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
		$this->db->select("r.id_rojo,r.codigo,r.descripcion,p.nombre,p.id_producto,r.costo,r.fecha_registro,p.codigo as code1,p.code as code2,pr.preciocinco,l.ides,u.ides as uni,l.iva,preciouno,preciodos,preciotres,preciocuatro, usr.nombre as usu")
			->from("rojos r")
			->join("productos p","r.codigo = p.codigo","left")
			->join("precios pr","p.id_producto = pr.id_producto AND pr.estatus = 1" ,"left")
			->join("lineas l ","p.linea = l.id_linea","left")
			->join("unidades u","p.ums = u.id_unidad","left") 
			->join("usuarios usr","r.agrego = usr.id_usuario","left")
			->where("r.estatus",1)
			->group_by("r.id_rojo")
			->order_by("r.id_rojo","DESC");


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
				$comparativaIndexada[$comparativa[$i]->id_rojo]["usu"]=	$comparativa[$i]->usu;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"]=	[];
				$flag++;
			}

			$this->db->select("c.id_producto,c.code,c.codigo,p.cantidad,c.nombre as descripcion,pz.preciocinco,pz.preciouno,pz.preciodos,pz.preciotres,pz.preciocuatro
				FROM paquetes p 
					LEFT JOIN productos c ON p.id_pieza = c.id_producto AND c.estatus = 1 
					LEFT JOIN precios pz ON p.id_pieza = pz.id_producto AND pz.estatus = 1 
					WHERE p.estatus = 1 AND p.id_caja = '".$comparativa[$i]->id_producto."'")
				->order_by("c.id_producto","DESC");
			$comparativa2 = $this->db->get()->result();
			for ($e=0; $e<sizeof($comparativa2); $e++){
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["codigo"] = $comparativa2[$e]->codigo;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["cods"] = $comparativa2[$e]->code;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["cantidad"] = $comparativa2[$e]->cantidad;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["descripcion"] = $comparativa2[$e]->descripcion;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["id_caja"] = $comparativa2[$e]->id_producto;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["preciouno"]=	$comparativa2[$e]->preciouno;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["preciodos"]=	$comparativa2[$e]->preciodos;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["preciotres"]=	$comparativa2[$e]->preciotres;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["preciocuatro"]=	$comparativa2[$e]->preciocuatro;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["preciocinco"]=	$comparativa2[$e]->preciocinco;
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
		->group_by("r.codigo")
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

	public function getCambioDesc($where=[]){
		$this->db->select("r.id_rojo,r.codigo,r.descripcion,r.fecha_registro,usr.nombre,p.nombre AS producto")
		->from("rojos r")
		->join("usuarios usr","r.agrego = usr.id_usuario","left")
		->join("productos p","r.codigo = p.codigo","LEFT")
		->where("r.estatus",5)
		->group_by("r.codigo")
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

	public function getAltas($where=[]){
		$this->db->select("r.id_rojo,r.codigo,r.descripcion,r.costo,r.fecha_registro,r.code_relacion,r.um_nuevo ,pz.preciouno,pz.preciodos,pz.preciotres,pz.preciocuatro,pz.preciocinco,p.codigo as code1,p.nombre,l.nombre as linea,l.iva,l.ides,usr.nombre as usua,r.codecaja")
		->from("rojos r")
		->join("usuarios usr","r.agrego = usr.id_usuario","left")
		->join("productos p","r.code_relacion = p.codigo","left")
		->join("precios pz","p.id_producto = pz.id_producto AND pz.estatus = 1","left")
		->join("lineas l","p.linea = l.id_linea","left")
		->where("r.estatus",4)
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

	public function codeCaja($where=[]){
		$this->db->select("FLOOR(RAND()*(999999-1000+1))+10 as codecaja FROM lineas HAVING codecaja NOT IN (SELECT codigo FROM productos) LIMIT 1");
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


	public function getRojos2($where = []){
		$this->db->select("r.id_rojo,r.codigo,r.descripcion,p.nombre,p.id_producto,r.costo,r.fecha_registro,p.codigo as code1,p.code as code2,pr.preciocinco,l.ides,u.ides as uni,l.iva,pr.preciouno,pr.preciodos,pr.preciotres,pr.preciocuatro, usr.nombre as usu,r.estatus,r.descripcion as rdes,r.um_nuevo,l2.ides as ides2,l2.iva as iva2,pr2.preciocinco as p5,pr2.preciouno as p1,pr2.preciodos as p2,pr2.preciotres as p3,pr2.preciocuatro as p4")
			->from("rojos r")
			->join("productos p","r.codigo = p.codigo","left")
			->join("precios pr","p.id_producto = pr.id_producto AND pr.estatus = 1" ,"left")
			->join("lineas l ","p.linea = l.id_linea","left")
			->join("unidades u","p.ums = u.id_unidad","left") 
			->join("usuarios usr","r.agrego = usr.id_usuario","left")
			->join("productos p2","r.code_relacion = p2.codigo","left")
			->join("lineas l2","p2.linea = l2.id_linea","left")
			->join("precios pr2","p2.id_producto = pr2.id_producto AND pr2.estatus = 1" ,"left")
			->where("r.estatus = 5 OR r.estatus = 1 OR r.estatus = 4")
			->group_by("r.id_rojo")
			->order_by("r.descripcion","ASC");


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
				$comparativaIndexada[$comparativa[$i]->id_rojo]["p1"]=	$comparativa[$i]->p1;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["p2"]=	$comparativa[$i]->p2;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["p3"]=	$comparativa[$i]->p3;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["p4"]=	$comparativa[$i]->p4;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["p5"]=	$comparativa[$i]->p5;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["ides"]=	$comparativa[$i]->ides;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["estatus"]=	$comparativa[$i]->estatus;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["uni"]=	$comparativa[$i]->uni;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["iva"]=	$comparativa[$i]->iva;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["usu"]=	$comparativa[$i]->usu;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["rdes"]=	$comparativa[$i]->rdes;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["um_nuevo"]=	$comparativa[$i]->um_nuevo;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["ides2"]=	$comparativa[$i]->ides2;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["iva2"]=	$comparativa[$i]->iva2;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"]=	[];
				$flag++;
			}

			$this->db->select("c.id_producto,c.code,c.codigo,p.cantidad,c.nombre as descripcion,pz.preciocinco,pz.preciouno,pz.preciodos,pz.preciotres,pz.preciocuatro
				FROM paquetes p 
					LEFT JOIN productos c ON p.id_pieza = c.id_producto AND c.estatus = 1 
					LEFT JOIN precios pz ON p.id_pieza = pz.id_producto AND pz.estatus = 1 
					WHERE p.estatus = 1 AND p.id_caja = '".$comparativa[$i]->id_producto."'")
				->order_by("c.id_producto","DESC");
			$comparativa2 = $this->db->get()->result();
			for ($e=0; $e<sizeof($comparativa2); $e++){
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["codigo"] = $comparativa2[$e]->codigo;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["cods"] = $comparativa2[$e]->code;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["cantidad"] = $comparativa2[$e]->cantidad;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["descripcion"] = $comparativa2[$e]->descripcion;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["id_caja"] = $comparativa2[$e]->id_producto;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["preciouno"]=	$comparativa2[$e]->preciouno;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["preciodos"]=	$comparativa2[$e]->preciodos;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["preciotres"]=	$comparativa2[$e]->preciotres;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["preciocuatro"]=	$comparativa2[$e]->preciocuatro;
				$comparativaIndexada[$comparativa[$i]->id_rojo]["relaciones"][$comparativa2[$e]->id_producto]["preciocinco"]=	$comparativa2[$e]->preciocinco;
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