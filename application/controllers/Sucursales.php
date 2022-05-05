<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sucursales extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model", "user_md");
		$this->load->model("Sucursales_model", "sucu_md");
		$this->load->model("Cambios_model", "cambio_md");
		$this->load->model("EntTxt_model", "ent_md");
		$this->load->model("Entradas_model", "remis_md");
		$this->load->model("Sucproductos_model", "sprod_md");
		$this->load->model("Detalleremis_model", "dremis_md");
		$this->load->model("SalTxt_model", "sal_md");
		$this->load->model("AjuTxt_model", "ajtxt_md");
		$this->load->library("form_validation");
	}

	public function index(){
		ini_set("memory_limit", "-1");
		$data['scripts'] = [
			'/scripts/Sucursales/index',
		];
		$data["cuantos"] = $this->sucu_md->getCount(NULL)[0];
		$this->estructura("Sucursales/index", $data);
	}

	public function getSucursales(){
		return $this->jsonResponse($this->sucu_md->get(NULL));
	}

	public function save_sucursal(){
		$usuario = [
			"nombre"	=>	$this->input->post('codigos'),
			"formato"	=>	$this->input->post('formato'),
			"typeSuc"	=>	$this->input->post('seletype'),
		];

		$getUsuario = $this->sucu_md->get(NULL, ['nombre'=>$usuario['nombre'],'formato'=>$usuario['formato']])[0];
		$user = $this->session->userdata();
		if(!$getUsuario){
			$data ['id_usuario'] = $this->sucu_md->insert($usuario);
			$mensaje = ["id" 	=> 'Éxito',
						"desc"	=> 'Sucursal registrada correctamente',
						"type"	=> 'success'];
		}else{
			$mensaje = [
				"id" 	=> 'Alerta',
				"desc"	=> 'La sucursal ['.$usuario['nombre'].']  ya está registrada en el Sistema',
				"type"	=> 'error'
			];
		}
		$this->jsonResponse($usuario);
	}

	public function getCharts($id_sucursal){
		return $this->jsonResponse($this->sucu_md->getCharts(["id_sucursal"=>$id_sucursal]));
	}

	public function getCharts2($id_sucursal){
		return $this->jsonResponse($this->sucu_md->getCharts2(["id_sucursal"=>$id_sucursal]));
	}

	public function misEntradas(){
		ini_set("memory_limit", "-1");
		$user = $this->session->userdata();
		$data['scripts'] = [
			'/scripts/Sucursales/misEntradas',
		];
		$fecha = new DateTime(date('Y-m-d H:i:s'));
		$data["miEntrada"] = $this->ent_md->get(NULL, ["id_sucursal"=>$user["id_sucursal"],"estatus"=>1,"DATE(fecha_registro)"=>$fecha->format('Y-m-d') ] );

		$data["miSalida"] = $this->sal_md->get(NULL, ["id_sucursal"=>$user["id_sucursal"],"estatus"=>1,"DATE(fecha_registro)"=>$fecha->format('Y-m-d') ] );

		$data["miAjuste"] = $this->ajtxt_md->get(NULL, ["id_sucursal"=>$user["id_sucursal"],"estatus"=>1,"DATE(fecha_registro)"=>$fecha->format('Y-m-d') ] );


		$data["entradas"] = $this->remis_md->getMisEntradas(NULL,$user["id_sucursal"]);
		$data["devolus"] = $this->remis_md->getMisDevoluciones(NULL,$user["id_sucursal"]);
		
		$this->estructura("Sucursales/misEntradas", $data);
		//$this->jsonResponse($data["entradas"]);
	}

}
