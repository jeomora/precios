<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detalleentra_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "detalleentra";
		$this->PRI_INDEX = "id_detalle";
	}

	public function getMerma($where=[]){
		$this->db->select("p.id_producto,p.codigo,p.nombre,p.code,p.unidad,u.ides,l.nombre as linea,l.ides lin,lst.costo as lastcosto,pz.preciouno,pz.preciodos,pz.preciotres,pz.preciocuatro,pz.preciocinco,exc.existencia,sp.nombre as snombre,sp.id_sucursal, spz.preciouno as p1,spz.preciodos as p2,spz.preciotres as p3,spz.preciocuatro as p4,spz.preciocinco as p5,slst.costo as ls,sex.existencia as sexistencia,sal.salcan,sal.salimp,sal.salnum,ent.entcan,ent.entimp,ent.entnum,nota.notacan,nota.notaimp,nota.notanum")
		->from("productos p")
		->join("lineas l","p.linea = l.id_linea","LEFT")
		->join("unidades u","p.ums = u.id_unidad","LEFT")
		->join("precios pz","p.id_producto = pz.id_producto AND pz.estatus = 1","LEFT")
		->join("lastcos lst","p.id_producto = lst.id_producto AND lst.estatus = 1","LEFT")
		->join("exicedis exc","p.id_producto = exc.id_producto AND exc.estatus = 1","LEFT")
		->join("sucproductos sp","p.id_producto = sp.id_prox AND sp.estatus = 1","LEFT")
		->join("sucprecios spz","sp.id_producto = spz.id_producto AND spz.estatus = 1","LEFT")
		->join("lastcossuc slst","sp.id_producto = slst.id_producto AND slst.estatus = 1","LEFT")
		->join("existencias sex","sp.id_producto = sex.id_producto AND sex.estatus = 1","LEFT")
		->join("(SELECT *,SUM(cantidad) as salcan,SUM(importe) as salimp,COUNT(*) as salnum FROM detalleajusal WHERE id_ajuste IN (SELECT id_ajuste FROM ajuSalida WHERE DATE(fecha_registro) BETWEEN '2022-05-06' AND '2022-05-12' AND estatus = 1) GROUP BY id_producto) sal","sp.id_producto = sal.id_producto","LEFT")
		->join("(SELECT *,SUM(cantidad) as entcan,SUM(importe) as entimp,COUNT(*) as entnum FROM detalleajuent WHERE id_ajuste IN (SELECT id_ajuste FROM ajuEntrada WHERE DATE(fecha_registro) BETWEEN '2022-05-06' AND '2022-05-12' AND estatus = 1) GROUP BY id_producto) ent","sp.id_producto = ent.id_producto","LEFT")
		->join("(SELECT *,SUM(cantidad) as notacan,SUM(importe) as notaimp,COUNT(id_producto) as notanum FROM detalleentra WHERE id_remision IN (SELECT id_entrada FROM entradas where estatus = 1 AND DATE(fecha_registro) BETWEEN '2022-05-06' AND '2022-05-12') GROUP BY id_producto) as nota","sp.id_producto = nota.id_producto","LEFT")
		->where("p.estatus = 1 AND p.linea = 2")
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
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["notaimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["notanum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["salnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["entnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["entimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["salimp"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][1]["entcan"]	=	0;

				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][2]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["notacan"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["notaimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["notanum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["salnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["entnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["entimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["salimp"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["entcan"]	=	0;

				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["notacan"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["notaimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["notanum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["salnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["entnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["entimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["salimp"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][3]["entcan"]	=	0;

				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["notacan"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["notaimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["notanum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["salnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["entnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["entimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["salimp"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][4]["entcan"]	=	0;

				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["notacan"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["notaimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["notanum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["salnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["entnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["entimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["salimp"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][5]["entcan"]	=	0;

				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["notacan"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["notaimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["notanum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["salnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["entnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["entimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["salimp"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][6]["entcan"]	=	0;

				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]	=	[];
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["ucosto"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["puno"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["notacan"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["notaimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["notanum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["salnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["entnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["entimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["salimp"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][8]["entcan"]	=	0;


				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["ucosto"]	=	$comparativa[$i]->lastcosto;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["puno"]	=	$comparativa[$i]->preciocinco;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["notacan"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["notaimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["notanum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["salnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["entnum"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["entimp"]	=	0;
				//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["salimp"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["salcan"]	=	0;
				$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][7]["entcan"]	=	0;

			}


			$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["ucosto"]	=	$comparativa[$i]->lastcosto;
			$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["puno"]	=	$comparativa[$i]->p1;

			$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["notacan"]	=	$comparativa[$i]->notacan;
			//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["notaimp"]	=	$comparativa[$i]->notaimp;
			//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["notanum"]	=	$comparativa[$i]->notanum;
			//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["salnum"]	=	$comparativa[$i]->salnum;
			//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["entnum"]	=	$comparativa[$i]->entnum;
			//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["entimp"]	=	$comparativa[$i]->entimp;
			//$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["salimp"]	=	$comparativa[$i]->salimp;
			$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["salcan"]	=	$comparativa[$i]->salcan;
			$comparativaIndexada[substr($comparativa[$i]->nombre, 0,1)."".$comparativa[$i]->id_producto]["sucursales"][$comparativa[$i]->id_sucursal]["entcan"]	=	$comparativa[$i]->entcan;
			
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