<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nuevos_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "nuevos";
		$this->PRI_INDEX = "id_nuevo";
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

	public function getMaxBlue($where=[]){
		$this->db->select("MAX(blues)+1 as blues from nuevo_detail");
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

	public function getMaxBlueB($where=[]){
		$this->db->select("MAX(blues)+1 as blues from nuevo_b");
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
		$user = $this->session->userdata();
		$this->db->select("n.id_nuevo,n.fecha_registro,n.agrego,n.estatus,nd.id_detail,nd.id_rojo,nd.code1,nd.code2,nd.code3,nd.linea,nd.desc1,nd.unidad,nd.desc2,nd.cantidad,nd.costo,nd.iva,nd.mar1,n.sucb
			,nd.mar2,nd.mar3,nd.mar4,nd.mar11,nd.mar22,nd.mar33,nd.rdiez,nd.mar44,nd.pre1,nd.pre2,nd.pre3,nd.pre4,nd.pre5,nd.pre11,nd.pre22,nd.pre33,nd.pre44,nd.pre55,nd.costopz,nd.matriz,u.nombre,l.estatus as listo,nd.estatus as estatusa,nd.estatusb,n.suca, n.sucb,pz.preciocuatro,pz.preciotres,pz.preciodos,pz.preciouno,pz.preciocinco,pz2.preciocuatro as preciocuatro2,pz2.preciotres as preciotres2,pz2.preciodos as preciodos2,pz2.preciouno as preciouno2,pz2.preciocinco as preciocinco2,nd.blues,n.tipo,la.costo as lastcosto")
			->from("nuevos n")
			->join("nuevo_detail nd","n.id_nuevo = nd.id_nuevo","left")
			->join("usuarios u","n.agrego = u.id_usuario" ,"left") 
			->join("listos l","nd.id_detail = l.id_detalle AND l.estatus = 1 AND l.id_sucursal = ".$user["id_sucursal"]."" ,"left") 
			->join("productos p","nd.code1 = p.codigo AND p.estatus <> 0 " ,"left")
			->join("precios pz","p.id_producto = pz.id_producto AND pz.estatus <> 0 " ,"left") 
			->join("lastcos la","p.id_producto = la.id_producto AND la.estatus <> 0 " ,"left")
			->join("productos p2","nd.code3 = p2.codigo AND p2.estatus <> 0 " ,"left") 
			->join("precios pz2","p2.id_producto = pz2.id_producto AND pz2.estatus <> 0 " ,"left") 
			->where("n.estatus = 1")
			->where("n.fecha_registro BETWEEN DATE_SUB(CURDATE(), INTERVAL 10 DAY) AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)")
			->order_by("nd.id_detail","ASC");

		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada[$comparativa[$i]->id_nuevo])) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_nuevo]					=	[];
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["nombre"]			=	$comparativa[$i]->nombre;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["id_nuevo"]		=	$comparativa[$i]->id_nuevo;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["sucb"]			=	$comparativa[$i]->sucb;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["suca"]			=	$comparativa[$i]->suca;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["tipo"]	=	$comparativa[$i]->tipo;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"]		=	[];
			}

			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["detalle"]=	$comparativa[$i]->id_detail;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costo"]	=	$comparativa[$i]->costo;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code1"]	=	$comparativa[$i]->code1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code2"]	=	$comparativa[$i]->code2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code3"]	=	$comparativa[$i]->code3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc1"]	=	$comparativa[$i]->desc1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc2"]	=	$comparativa[$i]->desc2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["unidad"]	=	$comparativa[$i]->unidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["cantidad"]=	$comparativa[$i]->cantidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costopz"]=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["iva"]	=	$comparativa[$i]->iva;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["linea"]	=	$comparativa[$i]->linea;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["matriz"]	=	$comparativa[$i]->matriz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre1"]	=	$comparativa[$i]->pre1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre2"]	=	$comparativa[$i]->pre2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre3"]	=	$comparativa[$i]->pre3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre4"]	=	$comparativa[$i]->pre4;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre5"]	=	$comparativa[$i]->pre5;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre11"]	=	$comparativa[$i]->pre11;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre22"]	=	$comparativa[$i]->pre22;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre33"]	=	$comparativa[$i]->pre33;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre44"]	=	$comparativa[$i]->pre44;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["blues"]	=	$comparativa[$i]->blues;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre55"]	=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["listo"]	=	$comparativa[$i]->listo;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["rdiez"]	=	$comparativa[$i]->rdiez;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["estatus"]	=	$comparativa[$i]->estatusa;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["estatusb"]	=	$comparativa[$i]->estatusb;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["lastcosto"]	=	$comparativa[$i]->lastcosto;

			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciouno"]	=	$comparativa[$i]->preciouno;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciodos"]	=	$comparativa[$i]->preciodos;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciotres"]	=	$comparativa[$i]->preciotres;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciocuatro"]	=	$comparativa[$i]->preciocuatro;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciocinco"]	=	$comparativa[$i]->preciocinco;

			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciouno2"]	=	$comparativa[$i]->preciouno2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciodos2"]	=	$comparativa[$i]->preciodos2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciotres2"]	=	$comparativa[$i]->preciotres2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciocuatro2"]	=	$comparativa[$i]->preciocuatro2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciocinco2"]	=	$comparativa[$i]->preciocinco2;

		}
		if ($comparativaIndexada) {
			return $comparativaIndexada;
		} else {
			return false;
		}
	}

	public function getRojosB($where = []){
		$user = $this->session->userdata();
		$this->db->select("n.id_nuevo,n.fecha_b as fecha_registro,n.agrego,n.estatus,nd.id_detail,nd.id_rojo,nd.code1,nd.code2,nd.code3,nd.linea,nd.desc1,nd.unidad,nd.desc2,nd.cantidad,nd.costo,nd.iva,n.sucb
			,nd.pre1,nd.pre2,nd.pre3,nd.pre11,nd.pre22,nd.pre33,nd.rdiez,nd.costopz,nd.matriz,u.nombre,nd.estatus as estato,n.suca, n.sucb,nd.blues")
			->from("nuevos n")
			->join("nuevo_b nd","n.id_nuevo= nd.id_nuevo and nd.estatus <> 0","left")
			->join("usuarios u","n.agrego = u.id_usuario" ,"left") 
			->where("n.estatus = 1")
			->where("n.fecha_b BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)")
			->order_by("nd.id_detail","ASC");

		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada[$comparativa[$i]->id_nuevo])) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_nuevo]					=	[];
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["nombre"]			=	$comparativa[$i]->nombre;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["id_nuevo"]		=	$comparativa[$i]->id_nuevo;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["sucb"]			=	$comparativa[$i]->sucb;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["suca"]			=	$comparativa[$i]->suca;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"]		=	[];
			}

			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["detalle"]=	$comparativa[$i]->id_detail;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costo"]	=	$comparativa[$i]->costo;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code1"]	=	$comparativa[$i]->code1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code2"]	=	$comparativa[$i]->code2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code3"]	=	$comparativa[$i]->code3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc1"]	=	$comparativa[$i]->desc1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc2"]	=	$comparativa[$i]->desc2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["unidad"]	=	$comparativa[$i]->unidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["cantidad"]=	$comparativa[$i]->cantidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costopz"]=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["iva"]	=	$comparativa[$i]->iva;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["linea"]	=	$comparativa[$i]->linea;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["matriz"]	=	$comparativa[$i]->matriz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre1"]	=	$comparativa[$i]->pre1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre2"]	=	$comparativa[$i]->pre2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre3"]	=	$comparativa[$i]->pre3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre11"]	=	$comparativa[$i]->pre11;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre22"]	=	$comparativa[$i]->pre22;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre33"]	=	$comparativa[$i]->pre33;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["rdiez"]	=	$comparativa[$i]->rdiez;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["estato"]	=	$comparativa[$i]->estato;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["estatus"]	=	$comparativa[$i]->estatus;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["blues"]	=	$comparativa[$i]->blues;

		}
		if ($comparativaIndexada) {
			return $comparativaIndexada;
		} else {
			return false;
		}
	}


	public function getRojo($valo){
		$user = $this->session->userdata();
		$this->db->select("n.id_nuevo,n.fecha_registro,n.agrego,n.estatus,nd.id_detail,nd.id_rojo,nd.code1,nd.code2,nd.code3,linea,nd.desc1,nd.unidad,nd.desc2,nd.cantidad,nd.costo,nd.iva,nd.mar1,
			,nd.mar2,nd.mar3,nd.mar4,nd.mar11,nd.mar22,nd.mar33,nd.mar44,nd.pre1,nd.pre2,nd.pre3,nd.pre4,nd.pre5,nd.pre11,nd.pre22,nd.pre33,nd.pre44,nd.pre55,nd.costopz,nd.matriz,u.nombre,l.estatus as listo,nd.blues")
			->from("nuevos n")
			->join("nuevo_detail nd","n.id_nuevo = nd.id_nuevo","left")
			->join("usuarios u","n.agrego = u.id_usuario" ,"left") 
			->join("listos l","nd.id_detail = l.id_detalle AND l.estatus = 1 AND l.id_sucursal = ".$user["id_sucursal"]."" ,"left") 
			->where("n.estatus = 1")
			->where("n.id_nuevo",$valo)
			->where("n.fecha_registro BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)")
			->order_by("n.id_nuevo","DESC");

		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada[$comparativa[$i]->id_nuevo])) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_nuevo]					=	[];
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["nombre"]			=	$comparativa[$i]->nombre;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["id_nuevo"]		=	$comparativa[$i]->id_nuevo;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"]		=	[];
			}

			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["detalle"]=	$comparativa[$i]->id_detail;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costo"]	=	$comparativa[$i]->costo;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code1"]	=	$comparativa[$i]->code1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code2"]	=	$comparativa[$i]->code2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code3"]	=	$comparativa[$i]->code3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc1"]	=	$comparativa[$i]->desc1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc2"]	=	$comparativa[$i]->desc2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["unidad"]	=	$comparativa[$i]->unidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["cantidad"]=	$comparativa[$i]->cantidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costopz"]=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["iva"]	=	$comparativa[$i]->iva;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["linea"]	=	$comparativa[$i]->linea;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["matriz"]	=	$comparativa[$i]->matriz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre1"]	=	$comparativa[$i]->pre1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre2"]	=	$comparativa[$i]->pre2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre3"]	=	$comparativa[$i]->pre3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre4"]	=	$comparativa[$i]->pre4;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre5"]	=	$comparativa[$i]->pre5;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre11"]	=	$comparativa[$i]->pre11;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre22"]	=	$comparativa[$i]->pre22;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre33"]	=	$comparativa[$i]->pre33;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre44"]	=	$comparativa[$i]->pre44;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre55"]	=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar1"]	=	$comparativa[$i]->mar1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar2"]	=	$comparativa[$i]->mar2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar3"]	=	$comparativa[$i]->mar3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar4"]	=	$comparativa[$i]->mar4;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar11"]	=	$comparativa[$i]->mar11;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar22"]	=	$comparativa[$i]->mar22;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar33"]	=	$comparativa[$i]->mar33;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar44"]	=	$comparativa[$i]->mar44;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["listo"]	=	$comparativa[$i]->listo;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["blues"]	=	$comparativa[$i]->blues;
		}
		if ($comparativaIndexada) {
			return $comparativaIndexada;
		} else {
			return false;
		}
	}


	public function getRojoB($valo){
		$user = $this->session->userdata();
		$this->db->select("n.id_nuevo,n.fecha_registro,n.agrego,n.estatus,nd.id_detail,nd.code1,nd.code2,nd.code3,linea,nd.desc1,nd.unidad,nd.desc2,nd.cantidad,nd.costo,nd.iva,nd.mar1,
			,nd.mar2,nd.mar3,nd.mar11,nd.mar22,nd.mar33,nd.pre1,nd.pre2,nd.pre3,nd.pre11,nd.pre22,nd.pre33,nd.costopz,nd.matriz,nd.detalle")
			->from("nuevos n")
			->join("nuevo_b nd","n.id_nuevo = nd.id_nuevo AND nd.estatus <> 0","left")
			->where("n.id_nuevo",$valo);

		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada[$comparativa[$i]->id_nuevo])) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_nuevo]					=	[];
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["id_nuevo"]		=	$comparativa[$i]->id_nuevo;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"]		=	[];
			}

			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["detalle"]=	$comparativa[$i]->detalle;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costo"]	=	$comparativa[$i]->costo;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code1"]	=	$comparativa[$i]->code1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code2"]	=	$comparativa[$i]->code2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code3"]	=	$comparativa[$i]->code3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc1"]	=	$comparativa[$i]->desc1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc2"]	=	$comparativa[$i]->desc2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["unidad"]	=	$comparativa[$i]->unidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["cantidad"]=	$comparativa[$i]->cantidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costopz"]=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["iva"]	=	$comparativa[$i]->iva;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["linea"]	=	$comparativa[$i]->linea;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["matriz"]	=	$comparativa[$i]->matriz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre1"]	=	$comparativa[$i]->pre1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre2"]	=	$comparativa[$i]->pre2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre3"]	=	$comparativa[$i]->pre3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre11"]	=	$comparativa[$i]->pre11;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre22"]	=	$comparativa[$i]->pre22;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre33"]	=	$comparativa[$i]->pre33;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre55"]	=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar1"]	=	$comparativa[$i]->mar1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar2"]	=	$comparativa[$i]->mar2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar3"]	=	$comparativa[$i]->mar3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar11"]	=	$comparativa[$i]->mar11;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar22"]	=	$comparativa[$i]->mar22;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar33"]	=	$comparativa[$i]->mar33;
		}
		if ($comparativaIndexada) {
			return $comparativaIndexada;
		} else {
			return false;
		}
	}

	public function getRojosSucu($where = []){
		$user = $this->session->userdata();
		$this->db->select("ss.access as sss,n.id_nuevo,n.fecha_registro,n.agrego,n.estatus,nd.id_detail,nd.id_rojo,nd.code1,nd.code2,nd.code3,nd.linea,nd.desc1,nd.unidad,nd.desc2,nd.cantidad,nd.costo,nd.iva,nd.mar1,n.sucb
			,nd.mar2,nd.mar3,nd.mar4,nd.mar11,nd.mar22,nd.mar33,nd.rdiez,nd.mar44,nd.pre1,nd.pre2,nd.pre3,nd.pre4,nd.pre5,nd.pre11,nd.pre22,nd.pre33,nd.pre44,nd.pre55,nd.costopz,nd.matriz,u.nombre,l.estatus as listo,nd.estatus as estatusa,nd.estatusb,n.suca, n.sucb,nd.blues,n.tipo")
			->from("nuevos n")
			->join("nuevo_detail nd","n.id_nuevo = nd.id_nuevo","left")
			->join("usuarios u","n.agrego = u.id_usuario" ,"left") 
			->join("listos l","nd.id_detail = l.id_detalle AND l.estatus = 1 AND l.id_sucursal = ".$user["id_sucursal"]."" ,"left") 
			->join("sucursales ss","ss.id_sucursal = ".$user["id_sucursal"]."" ,"left")
			->where("n.estatus = 1")
			->where("n.fecha_registro BETWEEN DATE_SUB(CURDATE(), INTERVAL 3 DAY) AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)")
			->order_by("nd.id_detail","ASC");

		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada[$comparativa[$i]->id_nuevo])) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_nuevo]					=	[];
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["nombre"]			=	$comparativa[$i]->nombre;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["id_nuevo"]		=	$comparativa[$i]->id_nuevo;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["sucb"]			=	$comparativa[$i]->sucb;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["suca"]			=	$comparativa[$i]->suca;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["tipo"]			=	$comparativa[$i]->tipo;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["sss"]			=	$comparativa[$i]->sss;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"]		=	[];
			}

			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["detalle"]=	$comparativa[$i]->id_detail;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costo"]	=	$comparativa[$i]->costo;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code1"]	=	$comparativa[$i]->code1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code2"]	=	$comparativa[$i]->code2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code3"]	=	$comparativa[$i]->code3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc1"]	=	$comparativa[$i]->desc1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc2"]	=	$comparativa[$i]->desc2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["unidad"]	=	$comparativa[$i]->unidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["cantidad"]=	$comparativa[$i]->cantidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costopz"]=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["iva"]	=	$comparativa[$i]->iva;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["linea"]	=	$comparativa[$i]->linea;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["matriz"]	=	$comparativa[$i]->matriz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre1"]	=	$comparativa[$i]->pre1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre2"]	=	$comparativa[$i]->pre2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre3"]	=	$comparativa[$i]->pre3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre4"]	=	$comparativa[$i]->pre4;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre5"]	=	$comparativa[$i]->pre5;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre11"]	=	$comparativa[$i]->pre11;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre22"]	=	$comparativa[$i]->pre22;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre33"]	=	$comparativa[$i]->pre33;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre44"]	=	$comparativa[$i]->pre44;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre55"]	=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["blues"]	=	$comparativa[$i]->blues;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["listo"]	=	$comparativa[$i]->listo;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["rdiez"]	=	$comparativa[$i]->rdiez;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["estatus"]	=	$comparativa[$i]->estatusa;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["estatusb"]	=	$comparativa[$i]->estatusb;
		}
		if ($comparativaIndexada) {
			return $comparativaIndexada;
		} else {
			return false;
		}
	}

	public function getListaSucu($where = [],$id_nuevo){
		$user = $this->session->userdata();
		$this->db->select("ss.access as sss,n.id_nuevo,n.fecha_registro,n.agrego,n.estatus,nd.id_detail,nd.id_rojo,nd.code1,nd.code2,nd.code3,nd.linea,nd.desc1,nd.unidad,nd.desc2,nd.cantidad,nd.costo,nd.iva,nd.mar1,n.sucb
			,nd.mar2,nd.mar3,nd.mar4,nd.mar11,nd.mar22,nd.mar33,nd.rdiez,nd.mar44,nd.pre1,nd.pre2,nd.pre3,nd.pre4,nd.pre5,nd.pre11,nd.pre22,nd.pre33,nd.pre44,nd.pre55,nd.costopz,nd.matriz,u.nombre,l.estatus as listo,nd.estatus as estatusa,nd.estatusb,n.suca, n.sucb,nd.blues,n.tipo")
			->from("nuevos n")
			->join("nuevo_detail nd","n.id_nuevo = nd.id_nuevo","left")
			->join("usuarios u","n.agrego = u.id_usuario" ,"left") 
			->join("listos l","nd.id_detail = l.id_detalle AND l.estatus = 1 AND l.id_sucursal = ".$user["id_sucursal"]."" ,"left") 
			->join("sucursales ss","ss.id_sucursal = ".$user["id_sucursal"]."" ,"left")
			->where("n.estatus = 1")
			->where("n.id_nuevo",$id_nuevo)
			->order_by("nd.id_detail","ASC");

		$comparativa = $this->db->get()->result();
		$comparativaIndexada = [];
		for ($i=0; $i<sizeof($comparativa); $i++) {
			if (isset($comparativaIndexada[$comparativa[$i]->id_nuevo])) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_nuevo]					=	[];
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["fecha_registro"]	=	$comparativa[$i]->fecha_registro;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["nombre"]			=	$comparativa[$i]->nombre;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["id_nuevo"]		=	$comparativa[$i]->id_nuevo;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["sucb"]			=	$comparativa[$i]->sucb;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["suca"]			=	$comparativa[$i]->suca;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["tipo"]			=	$comparativa[$i]->tipo;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["sss"]			=	$comparativa[$i]->sss;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"]		=	[];
			}

			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["detalle"]=	$comparativa[$i]->id_detail;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costo"]	=	$comparativa[$i]->costo;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code1"]	=	$comparativa[$i]->code1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code2"]	=	$comparativa[$i]->code2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code3"]	=	$comparativa[$i]->code3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc1"]	=	$comparativa[$i]->desc1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc2"]	=	$comparativa[$i]->desc2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["unidad"]	=	$comparativa[$i]->unidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["cantidad"]=	$comparativa[$i]->cantidad;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costopz"]=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["iva"]	=	$comparativa[$i]->iva;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["linea"]	=	$comparativa[$i]->linea;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["matriz"]	=	$comparativa[$i]->matriz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre1"]	=	$comparativa[$i]->pre1;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre2"]	=	$comparativa[$i]->pre2;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre3"]	=	$comparativa[$i]->pre3;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre4"]	=	$comparativa[$i]->pre4;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre5"]	=	$comparativa[$i]->pre5;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre11"]	=	$comparativa[$i]->pre11;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre22"]	=	$comparativa[$i]->pre22;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre33"]	=	$comparativa[$i]->pre33;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre44"]	=	$comparativa[$i]->pre44;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre55"]	=	$comparativa[$i]->costopz;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["blues"]	=	$comparativa[$i]->blues;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["listo"]	=	$comparativa[$i]->listo;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["rdiez"]	=	$comparativa[$i]->rdiez;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["estatus"]	=	$comparativa[$i]->estatusa;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["estatusb"]	=	$comparativa[$i]->estatusb;

			$this->db->select("pz.preciocuatro,pz.preciotres,pz.preciodos,pz.preciouno,pz.preciocinco")
			->from("sucproductos p")
			->join("sucprecios pz","p.id_producto = pz.id_producto AND pz.estatus <> 0 " ,"left") 
			->where("p.codigo = '".$comparativa[$i]->code1."' AND p.estatus <> 0 AND p.id_sucursal = ".$user["id_sucursal"]."");

			$compa2 = $this->db->get()->result();

			for ($e=0; $e<sizeof($compa2); $e++){
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciouno"]	=	$compa2[$e]->preciouno;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciodos"]	=	$compa2[$e]->preciodos;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciotres"]	=	$compa2[$e]->preciotres;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciocuatro"]	=	$compa2[$e]->preciocuatro;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciocinco"]	=	$compa2[$e]->preciocinco;
			}

			$this->db->select("pz.preciocuatro,pz.preciotres,pz.preciodos,pz.preciouno,pz.preciocinco")
			->from("sucproductos p")
			->join("sucprecios pz","p.id_producto = pz.id_producto AND pz.estatus <> 0 " ,"left") 
			->where("p.codigo = '".$comparativa[$i]->code3."' AND p.estatus <> 0 AND p.id_sucursal = ".$user["id_sucursal"]."");

			$compa2 = $this->db->get()->result();

			for ($e=0; $e<sizeof($compa2); $e++){
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciouno2"]	=	$compa2[$e]->preciouno;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciodos2"]	=	$compa2[$e]->preciodos;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciotres2"]	=	$compa2[$e]->preciotres;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciocuatro2"]	=	$compa2[$e]->preciocuatro;
				$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["preciocinco2"]	=	$compa2[$e]->preciocinco;
			}

		}
		if ($comparativaIndexada) {
			return $comparativaIndexada;
		} else {
			return false;
		}
	}
	
}