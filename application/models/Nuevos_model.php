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

	public function getRojos($where = []){
		$user = $this->session->userdata();
		$this->db->select("n.id_nuevo,n.fecha_registro,n.agrego,n.estatus,nd.id_detail,nd.id_rojo,nd.code1,nd.code2,nd.code3,nd.linea,nd.desc1,nd.unidad,nd.desc2,nd.cantidad,nd.costo,nd.iva,nd.mar1,n.sucb
			,nd.mar2,nd.mar3,nd.mar4,nd.mar11,nd.mar22,nd.mar33,nd.mar44,nd.pre1,nd.pre2,nd.pre3,nd.pre4,nd.pre5,nd.pre11,nd.pre22,nd.pre33,nd.pre44,nd.pre55,nd.costopz,nd.matriz,u.nombre,l.estatus as listo,nb.code1 as code1b,nb.code2 as code2b,nb.code3 as code3b,nb.desc1 as desc1b,nb.desc2 as desc2b,nb.unidad as unidadb,nb.cantidad as cantidadb,nb.costo as costob,nb.iva as ivab,nb.mar1 as mar1b,nb.mar2 as mar2b,nb.mar3 as mar3b,nb.mar11 as mar11b,nb.mar22 as mar22b,nb.mar33 as mar33b,nb.pre1 as pre1b,nb.pre2 as pre2b,nb.pre3 as pre3b,nb.pre11 as pre11b,nb.pre22 as pre22b,nb.pre33 as pre33b,nb.costo as costopzb,nb.matriz as matrizb,nb.linea as lineab,nd.estatus as estatusa,nd.estatusb,n.suca, n.sucb")
			->from("nuevos n")
			->join("nuevo_detail nd","n.id_nuevo = nd.id_nuevo","left")
			->join("nuevo_b nb","n.id_nuevo= nb.id_nuevo and nb.estatus <> 0","left")
			->join("usuarios u","n.agrego = u.id_usuario" ,"left") 
			->join("listos l","nd.id_detail = l.id_detalle AND l.estatus = 1 AND l.id_sucursal = ".$user["id_sucursal"]."" ,"left") 
			->where("n.estatus = 1")
			->where("n.fecha_registro BETWEEN DATE_SUB(CURDATE(), INTERVAL 21 DAY) AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)")
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
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["estatus"]	=	$comparativa[$i]->estatusa;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["estatusb"]	=	$comparativa[$i]->estatusb;

			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costob"]	=	$comparativa[$i]->costob;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code1b"]	=	$comparativa[$i]->code1b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code2b"]	=	$comparativa[$i]->code2b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["code3b"]	=	$comparativa[$i]->code3b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc1b"]	=	$comparativa[$i]->desc1b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["desc2b"]	=	$comparativa[$i]->desc2b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["unidadb"]	=	$comparativa[$i]->unidadb;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["cantidadb"]=	$comparativa[$i]->cantidadb;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["costopzb"]=	$comparativa[$i]->costopzb;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["ivab"]	=	$comparativa[$i]->ivab;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["lineab"]	=	$comparativa[$i]->lineab;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["matrizb"]	=	$comparativa[$i]->matrizb;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre1b"]	=	$comparativa[$i]->pre1b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre2b"]	=	$comparativa[$i]->pre2b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre3b"]	=	$comparativa[$i]->pre3b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre11b"]	=	$comparativa[$i]->pre11b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre22b"]	=	$comparativa[$i]->pre22b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["pre33b"]	=	$comparativa[$i]->pre33b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar1b"]	=	$comparativa[$i]->mar1b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar2b"]	=	$comparativa[$i]->mar2b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar3b"]	=	$comparativa[$i]->mar3b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar11b"]	=	$comparativa[$i]->mar11b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar22b"]	=	$comparativa[$i]->mar22b;
			$comparativaIndexada[$comparativa[$i]->id_nuevo]["detalles"][$comparativa[$i]->id_detail]["mar33b"]	=	$comparativa[$i]->mar33b;

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
			,nd.mar2,nd.mar3,nd.mar4,nd.mar11,nd.mar22,nd.mar33,nd.mar44,nd.pre1,nd.pre2,nd.pre3,nd.pre4,nd.pre5,nd.pre11,nd.pre22,nd.pre33,nd.pre44,nd.pre55,nd.costopz,nd.matriz,u.nombre,l.estatus as listo")
			->from("nuevos n")
			->join("nuevo_detail nd","n.id_nuevo = nd.id_nuevo","left")
			->join("usuarios u","n.agrego = u.id_usuario" ,"left") 
			->join("listos l","nd.id_detail = l.id_detalle AND l.estatus = 1 AND l.id_sucursal = ".$user["id_sucursal"]."" ,"left") 
			->where("n.estatus = 1")
			->where("n.id_nuevo",$valo)
			->where("n.fecha_registro BETWEEN DATE_SUB(CURDATE(), INTERVAL 21 DAY) AND DATE_ADD(CURDATE(), INTERVAL 3 DAY)")
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
	
}