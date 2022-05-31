<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detalleentra_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "detalleentra";
		$this->PRI_INDEX = "id_detalle";
	}

	public function getMerma($where=[],$valo){
		$values = json_decode($valo);
		$this->db->select("p.id_producto,p.codigo,p.nombre,p.code,p.unidad,u.ides,l.nombre as linea,l.ides lin,lst.costo as lastcosto,pz.preciouno,pz.preciodos,pz.preciotres,pz.preciocuatro,pz.preciocinco,exc.existencia,sp.nombre as snombre,sp.id_sucursal, spz.preciouno as p1,spz.preciodos as p2,spz.preciotres as p3,spz.preciocuatro as p4,spz.preciocinco as p5,slst.costo as ls,sal.salcan,ent.entcan,nota.notacan,sex1.existencia as sexistencia1,sex2.existencia as sexistencia2,rems.sumorems, sal2.salcan2,ent2.entcan2,nota2.notacan2")
		->from("productos p")
		->join("lineas l","p.linea = l.id_linea","LEFT")
		->join("unidades u","p.ums = u.id_unidad","LEFT")
		->join("precios pz","p.id_producto = pz.id_producto AND pz.estatus = 1","LEFT")
		->join("lastcos lst","p.id_producto = lst.id_producto AND lst.estatus = 1","LEFT")
		->join("exicedis exc","p.id_producto = exc.id_producto AND exc.estatus = 1","LEFT")
		->join("(SELECT id_producto,SUM(cantidad) as sumorems from detalleremis dr WHERE id_remision IN (SELECT id_remision FROM remisiones r WHERE estatus = 1 AND DATE(fecha_registro) BETWEEN '".$values->inicio."' AND '".$values->final."') GROUP BY id_producto) rems ","p.id_producto = rems.id_producto","LEFT")

		->join("(SELECT *,SUM(cantidad) as salcan2,SUM(importe) as salimp,COUNT(*) as salnum FROM detalleajusal WHERE id_ajuste IN (SELECT id_ajuste FROM ajusalida WHERE DATE(fecha_registro) BETWEEN '".$values->inicio."' AND '".$values->final."' AND estatus = 1) GROUP BY id_producto) sal2","p.id_producto = sal2.id_producto","LEFT")
		->join("(SELECT *,SUM(cantidad) as entcan2,SUM(importe) as entimp,COUNT(*) as entnum FROM detalleajuent WHERE id_ajuste IN (SELECT id_ajuste FROM ajuentrada WHERE DATE(fecha_registro) BETWEEN '".$values->inicio."' AND '".$values->final."' AND estatus = 1) GROUP BY id_producto) ent2","p.id_producto = ent2.id_producto","LEFT")
		->join("(SELECT *,SUM(cantidad) as notacan2,SUM(importe) as notaimp,COUNT(id_producto) as notanum FROM detalleentra WHERE id_remision IN (SELECT id_entrada FROM entradas where estatus = 1 AND DATE(fecha_registro) BETWEEN '".$values->inicio."' AND '".$values->final."') GROUP BY id_producto) as nota2","p.id_producto = nota2.id_producto","LEFT")

		->join("sucproductos sp","p.id_producto = sp.id_prox AND sp.estatus = 1","LEFT")
		->join("sucprecios spz","sp.id_producto = spz.id_producto AND spz.estatus = 1","LEFT")
		->join("lastcossuc slst","sp.id_producto = slst.id_producto AND slst.estatus = 1","LEFT")
		->join("(SELECT *,SUM(cantidad) as salcan,SUM(importe) as salimp,COUNT(*) as salnum FROM detalleajusal WHERE id_ajuste IN (SELECT id_ajuste FROM ajusalida WHERE DATE(fecha_registro) BETWEEN '".$values->inicio."' AND '".$values->final."' AND estatus = 1) GROUP BY id_producto) sal","sp.id_producto = sal.id_producto","LEFT")
		->join("(SELECT *,SUM(cantidad) as entcan,SUM(importe) as entimp,COUNT(*) as entnum FROM detalleajuent WHERE id_ajuste IN (SELECT id_ajuste FROM ajuentrada WHERE DATE(fecha_registro) BETWEEN '".$values->inicio."' AND '".$values->final."' AND estatus = 1) GROUP BY id_producto) ent","sp.id_producto = ent.id_producto","LEFT")
		->join("(SELECT *,SUM(cantidad) as notacan,SUM(importe) as notaimp,COUNT(id_producto) as notanum FROM detalleentra WHERE id_remision IN (SELECT id_entrada FROM entradas where estatus = 1 AND DATE(fecha_registro) BETWEEN '".$values->inicio."' AND '".$values->final."') GROUP BY id_producto) as nota","sp.id_producto = nota.id_producto","LEFT")
		->join("existencias sex1","sp.id_producto = sex1.id_producto AND DATE(sex1.fecha_registro) = DATE_SUB('".$values->inicio."',INTERVAL 1 DAY) ","LEFT")
		->join("existencias sex2","sp.id_producto = sex2.id_producto AND DATE(sex2.fecha_registro) = '".$values->final."'","LEFT")
		->where("p.estatus = 1 AND p.linea = ".$values->linea."")
		->order_by("p.nombre","ASC");
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
			if (isset($comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto])) {
				
			}else{
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]					=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["nombre"]		=	$comparativa[$i]->nombre;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["code"]			=	$comparativa[$i]->code;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["codigo"]		=	$comparativa[$i]->codigo;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["id_producto"]	=	$comparativa[$i]->id_producto;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["unidad"]		=	$comparativa[$i]->unidad;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["ides"]			=	$comparativa[$i]->ides;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["linea"]		=	$comparativa[$i]->linea;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["lin"]			=	$comparativa[$i]->lin;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["preciouno"]	=	$comparativa[$i]->preciouno;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["preciodos"]	=	$comparativa[$i]->preciodos;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["preciotres"]	=	$comparativa[$i]->preciotres;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["preciocuatro"]	=	$comparativa[$i]->preciocuatro;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["preciocinco"]	=	$comparativa[$i]->preciocinco;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"]		=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["notacan"]	=	0;
				
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["entcan"]	=	0;

				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["sexistencia2"]	=	0;




				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["ucosto"]	=	$comparativa[$i]->lastcosto;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["puno"]	=	$comparativa[$i]->preciouno;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["sumorems"]	=	$comparativa[$i]->sumorems;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["notacan"]	=	$comparativa[$i]->notacan2;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["salcan"]	=	$comparativa[$i]->salcan2;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["entcan"]	=	$comparativa[$i]->entcan2;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["sexistencia2"]	=	0;

			}

			if($comparativa[$i]->id_sucursal <> 7 && $comparativa[$i]->id_sucursal <> "7"){
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["ucosto"]	=	$comparativa[$i]->ls;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["puno"]	=	$comparativa[$i]->p1;

				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["notacan"]	=	$comparativa[$i]->notacan;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["salcan"]	=	$comparativa[$i]->salcan;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["entcan"]	=	$comparativa[$i]->entcan;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["sexistencia1"]	=	$comparativa[$i]->sexistencia1;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["sexistencia2"]	=	$comparativa[$i]->sexistencia2;
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


	public function getMermaExcel($where=[],$inicio,$final,$linea){
		
		$this->db->select("p.id_producto,p.codigo,p.nombre,p.code,p.unidad,u.ides,l.nombre as linea,l.ides lin,lst.costo as lastcosto,pz.preciouno,pz.preciodos,pz.preciotres,pz.preciocuatro,pz.preciocinco,exc.existencia,sp.nombre as snombre,sp.id_sucursal, spz.preciouno as p1,spz.preciodos as p2,spz.preciotres as p3,spz.preciocuatro as p4,spz.preciocinco as p5,slst.costo as ls,sal.salcan,ent.entcan,nota.notacan,sex1.existencia as sexistencia1,sex2.existencia as sexistencia2,rems.sumorems, sal2.salcan2,ent2.entcan2,nota2.notacan2")
		->from("productos p")
		->join("lineas l","p.linea = l.id_linea","LEFT")
		->join("unidades u","p.ums = u.id_unidad","LEFT")
		->join("precios pz","p.id_producto = pz.id_producto AND pz.estatus = 1","LEFT")
		->join("lastcos lst","p.id_producto = lst.id_producto AND lst.estatus = 1","LEFT")
		->join("exicedis exc","p.id_producto = exc.id_producto AND exc.estatus = 1","LEFT")
		->join("(SELECT id_producto,SUM(cantidad) as sumorems from detalleremis dr WHERE id_remision IN (SELECT id_remision FROM remisiones r WHERE estatus = 1 AND DATE(fecha_registro) BETWEEN '".$inicio."' AND '".$final."') GROUP BY id_producto) rems ","p.id_producto = rems.id_producto","LEFT")

		->join("(SELECT *,SUM(cantidad) as salcan2,SUM(importe) as salimp,COUNT(*) as salnum FROM detalleajusal WHERE id_ajuste IN (SELECT id_ajuste FROM ajusalida WHERE DATE(fecha_registro) BETWEEN '".$inicio."' AND '".$final."' AND estatus = 1) GROUP BY id_producto) sal2","p.id_producto = sal2.id_producto","LEFT")
		->join("(SELECT *,SUM(cantidad) as entcan2,SUM(importe) as entimp,COUNT(*) as entnum FROM detalleajuent WHERE id_ajuste IN (SELECT id_ajuste FROM ajuentrada WHERE DATE(fecha_registro) BETWEEN '".$inicio."' AND '".$final."' AND estatus = 1) GROUP BY id_producto) ent2","p.id_producto = ent2.id_producto","LEFT")
		->join("(SELECT *,SUM(cantidad) as notacan2,SUM(importe) as notaimp,COUNT(id_producto) as notanum FROM detalleentra WHERE id_remision IN (SELECT id_entrada FROM entradas where estatus = 1 AND DATE(fecha_registro) BETWEEN '".$inicio."' AND '".$final."') GROUP BY id_producto) as nota2","p.id_producto = nota2.id_producto","LEFT")

		->join("sucproductos sp","p.id_producto = sp.id_prox AND sp.estatus = 1","LEFT")
		->join("sucprecios spz","sp.id_producto = spz.id_producto AND spz.estatus = 1","LEFT")
		->join("lastcossuc slst","sp.id_producto = slst.id_producto AND slst.estatus = 1","LEFT")
		->join("(SELECT *,SUM(cantidad) as salcan,SUM(importe) as salimp,COUNT(*) as salnum FROM detalleajusal WHERE id_ajuste IN (SELECT id_ajuste FROM ajusalida WHERE DATE(fecha_registro) BETWEEN '".$inicio."' AND '".$final."' AND estatus = 1) GROUP BY id_producto) sal","sp.id_producto = sal.id_producto","LEFT")
		->join("(SELECT *,SUM(cantidad) as entcan,SUM(importe) as entimp,COUNT(*) as entnum FROM detalleajuent WHERE id_ajuste IN (SELECT id_ajuste FROM ajuentrada WHERE DATE(fecha_registro) BETWEEN '".$inicio."' AND '".$final."' AND estatus = 1) GROUP BY id_producto) ent","sp.id_producto = ent.id_producto","LEFT")
		->join("(SELECT *,SUM(cantidad) as notacan,SUM(importe) as notaimp,COUNT(id_producto) as notanum FROM detalleentra WHERE id_remision IN (SELECT id_entrada FROM entradas where estatus = 1 AND DATE(fecha_registro) BETWEEN '".$inicio."' AND '".$final."') GROUP BY id_producto) as nota","sp.id_producto = nota.id_producto","LEFT")
		->join("existencias sex1","sp.id_producto = sex1.id_producto AND DATE(sex1.fecha_registro) = DATE_SUB('".$inicio."',INTERVAL 1 DAY) ","LEFT")
		->join("existencias sex2","sp.id_producto = sex2.id_producto AND DATE(sex2.fecha_registro) = '".$final."'","LEFT")
		->where("p.estatus = 1 AND p.linea = ".$linea."")
		->order_by("p.nombre","ASC");
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
			if (isset($comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto])) {
				
			}else{
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]					=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["nombre"]		=	$comparativa[$i]->nombre;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["code"]			=	$comparativa[$i]->code;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["codigo"]		=	$comparativa[$i]->codigo;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["id_producto"]	=	$comparativa[$i]->id_producto;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["unidad"]		=	$comparativa[$i]->unidad;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["ides"]			=	$comparativa[$i]->ides;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["linea"]		=	$comparativa[$i]->linea;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["lin"]			=	$comparativa[$i]->lin;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["preciouno"]	=	$comparativa[$i]->preciouno;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["preciodos"]	=	$comparativa[$i]->preciodos;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["preciotres"]	=	$comparativa[$i]->preciotres;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["preciocuatro"]	=	$comparativa[$i]->preciocuatro;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["preciocinco"]	=	$comparativa[$i]->preciocinco;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"]		=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["notacan"]	=	0;
				
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["entcan"]	=	0;

				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["sexistencia2"]	=	0;



				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["notacan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["entcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["sexistencia2"]	=	0;




				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["ucosto"]	=	$comparativa[$i]->lastcosto;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["puno"]	=	$comparativa[$i]->preciouno;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["sumorems"]	=	$comparativa[$i]->sumorems;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["notacan"]	=	$comparativa[$i]->notacan2;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["salcan"]	=	$comparativa[$i]->salcan2;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["entcan"]	=	$comparativa[$i]->entcan2;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["sexistencia1"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["sexistencia2"]	=	0;

			}

			if($comparativa[$i]->id_sucursal <> 7 && $comparativa[$i]->id_sucursal <> "7"){
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["ucosto"]	=	$comparativa[$i]->ls;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["puno"]	=	$comparativa[$i]->p1;

				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["notacan"]	=	$comparativa[$i]->notacan;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["salcan"]	=	$comparativa[$i]->salcan;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["entcan"]	=	$comparativa[$i]->entcan;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["sexistencia1"]	=	$comparativa[$i]->sexistencia1;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["sexistencia2"]	=	$comparativa[$i]->sexistencia2;
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


	public function getEntradasProd($where=[],$valo){
		$values = json_decode($valo);
		$this->db->select("de.id_detalle,de.unidad,de.producto,de.descripcion,de.cantidad,de.precio,de.importe,sp.codigo,sp.nombre,spx.preciouno,spx.preciodos,spx.preciotres,spx.preciocuatro,spx.preciocinco,e.folio,e.id_entrada,e.proveedor,e.fecha,e.subtotal,e.provee, e.total,e.fecha_registro,sex1.existencia as sexistencia1,sex2.existencia as sexistencia2")
		->from("sucproductos sp")
		->join("(SELECT * FROM detalleentra WHERE id_remision IN (SELECT id_entrada FROM entradas WHERE estatus = 1 AND id_sucursal = ".$values->id_suc." AND fecha_registro BETWEEN '".$values->inicio."' AND '".$values->final."')) de","sp.id_producto = de.id_producto","LEFT")
		->join("sucprecios spx","sp.id_producto = spx.id_producto","LEFT")
		->join("entradas e","de.id_remision = e.id_entrada AND e.estatus = 1","LEFT")
		->join("existencias sex1","sp.id_producto = sex1.id_producto AND DATE(sex1.fecha_registro) = DATE_SUB('".$values->inicio."',INTERVAL 1 DAY) ","LEFT")
		->join("existencias sex2","sp.id_producto = sex2.id_producto AND DATE(sex2.fecha_registro) = '".$values->final."'","LEFT")
		->where("sp.id_sucursal", $values->id_suc)
		->where("sp.id_prox", $values->id_prod)
		->order_by("e.folio","DESC");
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
			if (isset( $comparativaIndexada[$comparativa[$i]->id_detalle] )) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_detalle]					=	[];
				$comparativaIndexada[$comparativa[$i]->id_detalle]["unidad"]		=	$comparativa[$i]->unidad;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["id_detalle"]	=	$comparativa[$i]->id_detalle;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["producto"]		=	$comparativa[$i]->producto;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["descripcion"]	=	$comparativa[$i]->descripcion;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["cantidad"]		=	$comparativa[$i]->cantidad;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["precio"]		=	$comparativa[$i]->precio;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["importe"]		=	$comparativa[$i]->importe;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["codigo"]		=	$comparativa[$i]->codigo;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["preciouno"]	=	$comparativa[$i]->preciouno;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["preciodos"]	=	$comparativa[$i]->preciodos;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["preciotres"]	=	$comparativa[$i]->preciotres;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["preciocuatro"]	=	$comparativa[$i]->preciocuatro;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["preciocinco"]	=	$comparativa[$i]->preciocinco;

				$comparativaIndexada[$comparativa[$i]->id_detalle]["nombre"]		=	$comparativa[$i]->nombre;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["folio"]			=	$comparativa[$i]->folio;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["id_entrada"]	=	$comparativa[$i]->id_entrada;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["proveedor"]		=	$comparativa[$i]->proveedor;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["fecha"]			=	$comparativa[$i]->fecha;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["subtotal"]		=	$comparativa[$i]->subtotal;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["provee"]		=	$comparativa[$i]->provee;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["total"]			=	$comparativa[$i]->total;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["fecha_registro"]=	$comparativa[$i]->fecha_registro;

				$comparativaIndexada[$comparativa[$i]->id_detalle]["existencia1"]		=	$comparativa[$i]->existencia1;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["existencia2"]		=	$comparativa[$i]->existencia2;
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

	public function getAEntradasProd($where=[],$valo){
		$values = json_decode($valo);
		$this->db->select("sp.codigo,sp.nombre,de.code,de.descripcion,de.unidad,de.cantidad,de.precio,de.importe,de.id_detalle,a.id_sucursal,a.folio,a.fecha,a.referencia,a.fecha_registro")
		->from("sucproductos sp")
		->join("(SELECT * FROM detalleajuent WHERE id_ajuste IN (SELECT id_ajuste FROM ajuentrada WHERE estatus = 1 AND id_sucursal = ".$values->id_suc." AND fecha_registro BETWEEN '".$values->inicio."' AND '".$values->final."')) de","sp.id_producto = de.id_producto","LEFT")
		->join("ajuentrada a","de.id_ajuste = a.id_ajuste AND a.estatus = 1","LEFT")
		->where("sp.id_sucursal", $values->id_suc)
		->where("sp.id_prox", $values->id_prod)
		->order_by("a.folio","DESC");
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
			if (isset( $comparativaIndexada[$comparativa[$i]->id_detalle] )) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_detalle]					=	[];

				$comparativaIndexada[$comparativa[$i]->id_detalle]["codigo"]		=	$comparativa[$i]->codigo;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["nombre"]		=	$comparativa[$i]->nombre;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["code"]			=	$comparativa[$i]->code;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["unidad"]		=	$comparativa[$i]->unidad;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["descripcion"]	=	$comparativa[$i]->descripcion;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["cantidad"]		=	$comparativa[$i]->cantidad;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["precio"]		=	$comparativa[$i]->precio;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["importe"]		=	$comparativa[$i]->importe;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["id_detalle"]	=	$comparativa[$i]->id_detalle;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["id_sucursal"]	=	$comparativa[$i]->id_sucursal;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["folio"]			=	$comparativa[$i]->folio;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["fecha"]			=	$comparativa[$i]->fecha;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["referencia"]		=	$comparativa[$i]->referencia;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["fecha_registro"]		=	$comparativa[$i]->fecha_registro;
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

	public function getSEntradasProd($where=[],$valo){
		$values = json_decode($valo);
		$this->db->select("sp.codigo,sp.nombre,de.code,de.descripcion,de.unidad,de.cantidad,de.precio,de.importe,de.id_detalle,a.id_sucursal,a.folio,a.fecha,a.referencia,a.fecha_registro")
		->from("sucproductos sp")
		->join("(SELECT * FROM detalleajusal WHERE id_ajuste IN (SELECT id_ajuste FROM ajusalida WHERE estatus = 1 AND id_sucursal = ".$values->id_suc." AND fecha_registro BETWEEN '".$values->inicio."' AND '".$values->final."')) de","sp.id_producto = de.id_producto","LEFT")
		->join("ajusalida a","de.id_ajuste = a.id_ajuste AND a.estatus = 1","LEFT")
		->where("sp.id_sucursal", $values->id_suc)
		->where("sp.id_prox", $values->id_prod)
		->order_by("a.folio","DESC");
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
			if (isset( $comparativaIndexada[$comparativa[$i]->id_detalle] )) {
				
			}else{
				$comparativaIndexada[$comparativa[$i]->id_detalle]					=	[];

				$comparativaIndexada[$comparativa[$i]->id_detalle]["codigo"]		=	$comparativa[$i]->codigo;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["nombre"]		=	$comparativa[$i]->nombre;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["code"]		=	$comparativa[$i]->code;	
				$comparativaIndexada[$comparativa[$i]->id_detalle]["unidad"]		=	$comparativa[$i]->unidad;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["descripcion"]	=	$comparativa[$i]->descripcion;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["cantidad"]		=	$comparativa[$i]->cantidad;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["precio"]		=	$comparativa[$i]->precio;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["importe"]		=	$comparativa[$i]->importe;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["id_detalle"]	=	$comparativa[$i]->id_detalle;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["id_sucursal"]	=	$comparativa[$i]->id_sucursal;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["folio"]			=	$comparativa[$i]->folio;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["fecha"]			=	$comparativa[$i]->fecha;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["referencia"]		=	$comparativa[$i]->referencia;
				$comparativaIndexada[$comparativa[$i]->id_detalle]["fecha_registro"]		=	$comparativa[$i]->fecha_registro;
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

/* End of file Grupos_model.php */
/* Location: ./application/models/Grupos_model.php */