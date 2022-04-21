<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');

class AndroidApi extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model", "user_md");
		$this->load->model("Sucursales_model", "sucu_md");
		$this->load->model("Nuevodetail_model", "det_md");
		$this->load->model("Nuevob_model", "newb_md");
		$this->load->model("Ofertas_model", "ofe_md");
		$this->load->model("Cambios_model", "chg_md");
		$this->load->model("Pasillos_model", "pass_md");
		$this->load->model("Inventario_model", "inv_md");
		$this->load->library("form_validation");
	}

	public function getPasillos($ids = 8){
		$res = $this->pass_md->getPasillos(["p.id_sucursal"=>$ids,"p.estatus"=>1]);
		if($res){
			$data = [ 
				"count"		=>	sizeof($res),
				"next"		=>	"",
				"previous"	=>	"",
				"results"	=>	[]
			];
			foreach ($res as $key => $val) {
				$data["results"][$key] = [
					"id"		=>	$val->id_pasillo,
					"nombre"	=>	$val->nombre,
					"imagen"	=>	$val->imagen,
					"sucursal"	=>	$val->id_sucursal,
					"estatus"	=>	$val->estatus,
					"sumpas"	=>	$val->sumpas,
					"color"		=>	$val->color,
					"txtCol"		=>	$val->txtCol,
				];
			}
		}else{
			$data = [ 
				"count"		=>	0,
				"next"		=>	"",
				"previous"	=>	"",
				"results"	=>	[]
			];
		}
		$this->jsonResponse($res);
	}

	public function getProducto($producto){
		$ids = 12;
		$res = $this->inv_md->getCodigo(["s.id_sucursal"=>$ids,"s.codigo"=>$producto,"s.estatus"=>1]);
		if($res){
			if($res[0]->id_producto == null){
				$res = $this->inv_md->getCodigo(["s.id_sucursal"=>$ids,"s.codigo"=>"".intval($producto),"s.estatus"=>1]);
			}
		}else{
			$res = $this->inv_md->getCodigo(["s.id_sucursal"=>$ids,"s.codigo"=>"".intval($producto),"s.estatus"=>1]);
		}
		$this->jsonResponse($res);
	}

	public function getProductoCs($producto){
		$res = $this->inv_md->getCodigoCs(["s.codigo"=>$producto,"s.estatus"=>1]);
		if($res){
			if($res[0]->id_producto == null){
				$res = $this->inv_md->getCodigoCs(["s.codigo"=>"".intval($producto),"s.estatus"=>1]);
			}
		}else{
			$res = $this->inv_md->getCodigoCs(["s.codigo"=>"".intval($producto),"s.estatus"=>1]);
		}
		$this->jsonResponse($res);
	}

	public function setEProducto($id,$cant,$pas){
		$this->inv_md->insert(["id_producto"=>$id,"cantidad"=>$cant,"id_pasillo"=>$pas]);
		$this->jsonResponse($cant);
	}


	public function setEProductoCs($id,$cant,$pas){
		$this->inv_md->insert(["id_producto"=>$id,"cantidad"=>$cant,"id_pasillo"=>$pas,"estatus"=>2]);
		$this->jsonResponse($cant);
	}

	public function getEntradas($id){
		$cant = $this->inv_md->getEntradas(["id_pasillo"=>$id,"i.estatus"=>1]);
		$this->jsonResponse($cant);
	}

}

