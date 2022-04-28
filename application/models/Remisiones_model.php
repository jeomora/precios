<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Remisiones_model extends MY_Model {

	function __construct(){
		parent::__construct();
		$this->TABLE_NAME = "remisiones";
		$this->PRI_INDEX = "id_remision";
	}

	public function hayRemisiones($where=[]){
		$this->db->select("* FROM remisiones WHERE DATE(fecha_registro) = DATE(CURDATE())");
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

	public function getRemisNoCotiz($where=[]){
		$this->db->select("* FROM remisiones WHERE estatus = 1 AND DATE(fecha_registro) = DATE(CURDATE()) AND folio NOT IN (SELECT remision FROM cotizaciones WHERE estatus = 1 AND DATE(fecha_registro) = DATE(CURDATE()))");
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

	public function getRemisionesHoy($where=[]){
		$this->db->select("c.folio,c.idsucu,s.ides,s.tipo,s.ides2,s.nombre,sf.totafru,sv.totaver,sa.totabar, sa2.totabar as totis FROM remisiones c  
LEFT JOIN sucos s ON c.idsucu = s.ides OR c.idsucu = s.ides2 
LEFT JOIN (SELECT c.idsucu,SUM(c.total) as totafru FROM remisiones c WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 AND c.id_remision IN (SELECT id_remision FROM detalleremis GROUP BY id_remision HAVING ROUND(AVG(familia)) = 75) GROUP BY c.idsucu) as sf ON s.ides = sf.idsucu OR s.ides2 = sf.idsucu
LEFT JOIN (SELECT c.idsucu,SUM(c.total) as totaver FROM remisiones c WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 AND c.id_remision IN (SELECT id_remision FROM detalleremis GROUP BY id_remision HAVING ROUND(AVG(familia)) = 76) GROUP BY c.idsucu) as sv ON s.ides = sv.idsucu OR s.ides2 = sv.idsucu
LEFT JOIN (SELECT c.idsucu,SUM(c.total) as totabar FROM remisiones c WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 AND c.id_remision NOT IN (SELECT id_remision FROM detalleremis GROUP BY id_remision HAVING ROUND(AVG(familia)) = 76) AND c.id_remision NOT IN (SELECT id_remision FROM detalleremis GROUP BY id_remision HAVING ROUND(AVG(familia)) = 75) GROUP BY c.idsucu) as sa ON s.ides = sa.idsucu 
LEFT JOIN (SELECT c.idsucu,SUM(c.total) as totabar FROM remisiones c WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 AND c.id_remision NOT IN (SELECT id_remision FROM detalleremis GROUP BY id_remision HAVING ROUND(AVG(familia)) = 76) AND c.id_remision NOT IN (SELECT id_remision FROM detalleremis GROUP BY id_remision HAVING ROUND(AVG(familia)) = 75) GROUP BY c.idsucu) as sa2 ON s.ides2 = sa2.idsucu
WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 
GROUP BY s.id_sucursal ORDER BY s.tipo,s.nombre ASC");
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


	public function getDiferencias($where=[]){
		$this->db->select("c.folio as foluno,c.total as totuno,r.folio as foldos,r.total as totdos FROM cotizaciones c LEFT JOIN remisiones r ON c.remision = r.folio AND r.estatus = 1 WHERE DATE(c.fecha_registro) = DATE(CURDATE()) AND c.estatus = 1 HAVING c.total <> r.total");
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