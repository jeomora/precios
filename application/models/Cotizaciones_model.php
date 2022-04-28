<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cotizaciones_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "cotizaciones";
		$this->PRI_INDEX = "id_cotizacion";
	}

	public function hayCotizaciones($where=[]){
		$this->db->select("* FROM cotizaciones WHERE DATE(fecha_registro) = DATE(CURDATE())");
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

	public function getCotizacionesHoy($where=[]){
		$this->db->select("c.folio,c.idsucu,s.ides,s.tipo,s.ides2,s.nombre,sf.totafru,sv.totaver,sa.totabar, sa2.totabar as totis FROM cotizaciones c  
LEFT JOIN sucos s ON c.idsucu = s.ides OR c.idsucu = s.ides2 
LEFT JOIN (SELECT c.idsucu,SUM(c.total) as totafru FROM cotizaciones c WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 AND c.id_cotizacion IN (SELECT id_cotizacion FROM detallecotiz GROUP BY id_cotizacion HAVING ROUND(AVG(familia)) = 75) GROUP BY c.idsucu) as sf ON s.ides = sf.idsucu OR s.ides2 = sf.idsucu
LEFT JOIN (SELECT c.idsucu,SUM(c.total) as totaver FROM cotizaciones c WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 AND c.id_cotizacion IN (SELECT id_cotizacion FROM detallecotiz GROUP BY id_cotizacion HAVING ROUND(AVG(familia)) = 76) GROUP BY c.idsucu) as sv ON s.ides = sv.idsucu OR s.ides2 = sv.idsucu
LEFT JOIN (SELECT c.idsucu,SUM(c.total) as totabar FROM cotizaciones c WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 AND c.id_cotizacion NOT IN (SELECT id_cotizacion FROM detallecotiz GROUP BY id_cotizacion HAVING ROUND(AVG(familia)) = 76) AND c.id_cotizacion NOT IN (SELECT id_cotizacion FROM detallecotiz GROUP BY id_cotizacion HAVING ROUND(AVG(familia)) = 75) GROUP BY c.idsucu) as sa ON s.ides = sa.idsucu 
LEFT JOIN (SELECT c.idsucu,SUM(c.total) as totabar FROM cotizaciones c WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 AND c.id_cotizacion NOT IN (SELECT id_cotizacion FROM detallecotiz GROUP BY id_cotizacion HAVING ROUND(AVG(familia)) = 76) AND c.id_cotizacion NOT IN (SELECT id_cotizacion FROM detallecotiz GROUP BY id_cotizacion HAVING ROUND(AVG(familia)) = 75) GROUP BY c.idsucu) as sa2 ON s.ides2 = sa2.idsucu
WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 
GROUP BY s.id_sucursal")
		->order_by("s.tipo,s.nombre","ASC");
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

	public function getCotizNoRemis($where=[]){
		$this->db->select("* FROM cotizaciones WHERE estatus = 1 AND DATE(fecha_registro) = DATE(CURDATE()) AND remision = '000000'");
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

/* End of file Grupos_model.php */
/* Location: ./application/models/Grupos_model.php */