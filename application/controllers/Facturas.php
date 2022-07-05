<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturas extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Productos_model", "prod_md");
		$this->load->model("Sucursales_model", "sucu_md");
		$this->load->model("Nuevodetail_model", "det_md");
		$this->load->model("Nuevob_model", "newb_md");
		$this->load->model("Ofertas_model", "ofe_md");
		$this->load->model("Cambios_model", "chg_md");
		$this->load->model("Pasillos_model", "pass_md");
		$this->load->model("Inventario_model", "inv_md");
		$this->load->model("AjuTxt_model", "ajua_md");
		$this->load->model("Prenotas_model", "pre_md");
		$this->load->library("form_validation");
	}


	public function index(){
		if($this->session->userdata("username")){
			$user = $this->session->userdata();//Trae los datos del usuario
			$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
			$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
			$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
			$data['scripts'] = [
				'/scripts/Facturas/index',
			];
			$this->estructura("Facturas/index", $data);
		}else{
			$this->data["message"] =NULL;
			$this->estructura_login("Admin/login", $this->data, FALSE);
		}
	}

	public function buscaProdF($val){
		$busca = $this->prod_md->buscaProdF(NULL,$val);
		$this->jsonResponse($busca);
	}

	public function misPrenotas(){
		$busca = $this->pre_md->get(NULL,["estatus"=>2]);
		$this->jsonResponse($busca);
	}

	public function ingresar(){
		$user = $this->session->userdata();
		$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
		$data['scripts'] = [
			'/scripts/Facturas/ingresar',
		];
		$this->estructuraFactus("Facturas/ingresar", $data);
	}


	public function buscaleProd($val){
		$busca = $this->prod_md->get(NULL,["codigo"=>$val,"estatus"=>1]);
		if(!$busca && substr($val,0,1) == "0"){
			$busca = $this->prod_md->get(NULL,["codigo"=>substr($val,1),"estatus"=>1]);
			if(substr($val,1,2) == "0"){
				$busca = $this->prod_md->get(NULL,["codigo"=>substr($val,2),"estatus"=>1]);
			}
		}
		$this->jsonResponse($busca);
	}

	public function saveNota(){
		$value = json_decode($this->input->post('values'), true);
		$ultimo = $this->pre_md->getPreLast(NULL);
		if ($ultimo->lastgas === NULL || $ultimo->lastgas === "") {
			$lastgas = 1;
		}else{
			$lastgas = $ultimo->lastgas+1;
		}

		foreach ($value["detalle"] as $key => $v) {
			$new_detail = [
				"identificador"	=> $lastgas,
				"proveedor"		=> $value["prove"]["proveedor"],
				"folio"			=> $value["folio"]["folio"],
				"nombre"		=> $v["nombre"],
				"codigo"		=> $v["codigo"],
				"cantidad"		=> $v["cantidad"],
				"ides"			=> $v["identifico"],
			];
			$detail_id = $this->pre_md->insert($new_detail);
		}
		$this->jsonResponse($lastgas);
	}

	public function prenotab($nota){
		$busca = $this->pre_md->getPrenota(NULL,$nota);
		$this->jsonResponse($busca);
	}
}