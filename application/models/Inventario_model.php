<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "inventario";
		$this->PRI_INDEX = "id_inventario";
	}

	public function getCodigo($where=[]){
		$user = $this->session->userdata();
		$this->db->select("s.id_producto,s.codigo,s.code,s.nombre,s.ums,s.code,s.id_sucursal,SUM(i.cantidad) as cantidad,MAX(i.fecha_registro) as fecha_registro,i.estatus,s.estatus as elim")
		->from("sucproductos s")
		->join("inventario i","s.id_producto = i.id_producto AND i.estatus = 1","LEFT");
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


	public function getCodigoCs($where=[]){
		$user = $this->session->userdata();
		$this->db->select("s.id_producto,s.codigo,s.code,s.nombre,s.ums,s.code,s.estatus as elim")
		->from("productos s");
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


	public function getEntradas($where=[]){
		$user = $this->session->userdata();
		$this->db->select("i.id_inventario,i.id_producto,i.cantidad,i.fecha_registro,i.id_pasillo,s.nombre,s.codigo,s.ums")
		->from("inventario i")
		->join("sucproductos s","i.id_producto = s.id_producto","LEFT")
		->order_by("i.fecha_registro","DESC");
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

	public function getInventario($where = []){
		$user = $this->session->userdata();
		$this->db->select("i.id_inventario,i.id_producto,i.cantidad,i.fecha_registro,i.id_pasillo,p.nombre as pasillo,p.imagen,s.codigo,s.nombre,s.ums,sp.preciotres,i.estatus,ps.codigo as codp,ps.nombre as nomp,e.existencia")
			->from("inventario i")
			->join("pasillos p","i.id_pasillo = p.id_pasillo","LEFT")
			->join("sucproductos s","i.id_producto = s.id_producto" ,"LEFT") 
			->join("sucprecios sp","i.id_producto = sp.id_producto","LEFT")
			->join("productos ps","i.id_producto = ps.id_producto" ,"LEFT") 
			->join("existencias e","i.id_producto = e.id_producto" ,"LEFT")
			->where("i.estatus <> 0")
			->order_by("i.id_pasillo,i.id_producto","ASC");

		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo])) {
				
			}else{
				$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]					=	[];
				$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["id_pasillo"]	=	$comparativa[$i]->id_pasillo;
				$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["pasillo"]			=	$comparativa[$i]->pasillo;
				$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"]		=	[];
				$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["producto"]		=	[];
			}

			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["id_inventario"]	=	$comparativa[$i]->id_inventario;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["nombre"]			=	$comparativa[$i]->nombre;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["nomp"]			=	$comparativa[$i]->nomp;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["codp"]			=	$comparativa[$i]->codp;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["ums"]				=	$comparativa[$i]->ums;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["imagen"]			=	$comparativa[$i]->imagen;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["cantidad"]			=	$comparativa[$i]->cantidad;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["codigo"]			=	$comparativa[$i]->codigo;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["id_producto"]		=	$comparativa[$i]->id_producto;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["preciocinco"]		=	$comparativa[$i]->preciotres;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["existencia"]		=	$comparativa[$i]->existencia;
			$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["detalles"][$comparativa[$i]->id_inventario]["estatus"]		=	$comparativa[$i]->estatus;

			if (isset( $comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["producto"][$comparativa[$i]->id_producto] )){
				$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["producto"][$comparativa[$i]->id_producto]["nombre"]	=	$comparativa[$i]->nombre;
				$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["producto"][$comparativa[$i]->id_producto]["cantidad"]	+=	$comparativa[$i]->cantidad;
			} else{
				$comparativaIndexada["pasillos"][$comparativa[$i]->id_pasillo]["producto"][$comparativa[$i]->id_producto]["cantidad"]	=	$comparativa[$i]->cantidad;
			}


			if (isset($comparativaIndexada["totales"][$comparativa[$i]->id_producto])) {
				$comparativaIndexada["totales"][$comparativa[$i]->id_producto]["cantidad"]	+=	$comparativa[$i]->cantidad;
			}else{
				$comparativaIndexada["totales"][$comparativa[$i]->id_producto]["nombre"]	=	$comparativa[$i]->nombre;
				$comparativaIndexada["totales"][$comparativa[$i]->id_producto]["cantidad"]	=	$comparativa[$i]->cantidad;
			}



		}
		if ($comparativaIndexada) {
			return $comparativaIndexada;
		} else {
			return false;
		}
	}

	public function getE($where=[]){
		$user = $this->session->userdata();
		$this->db->select("*")
		->from("sucproductos s")
		->join("existencias e","s.id_producto = e.id_producto","left")
		->where("s.estatus",1)
		->where("s.id_sucursal",8)
		->having("e.existencia > 1");
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


	public function getNuevos($where=[],$value){
		$user = $this->session->userdata();
		$this->db->select("i.id_producto,i.cantidad,i.fecha_registro,s.codigo,s.nombre,s.ums")
		->from("inventario i")
		->join("sucproductos s","i.id_producto = s.id_producto","LEFT")
		->where("i.id_pasillo",$value)
		->where("i.estatus",1);
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

	public function getCedis($where=[],$value){
		$user = $this->session->userdata();
		$this->db->select("i.id_producto,i.cantidad,i.fecha_registro,s.codigo,s.nombre,s.ums")
		->from("inventario i")
		->join("productos s","i.id_producto = s.id_producto","LEFT")
		->where("i.id_pasillo",$value)
		->where("i.estatus",2);
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