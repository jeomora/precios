<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventarios extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model", "user_md");
		$this->load->model("Grupos_model", "grupo_md");
		$this->load->model("Avatars_model", "ava_md");
		$this->load->model("Cambios_model", "cambio_md");
		$this->load->model("Productos_model", "prod_md");
		$this->load->model("Cajas_model", "caja_md");
		$this->load->model("Lineas_model", "ln_md");
		$this->load->model("Nuevos_model", "new_md");
		$this->load->model("Imagenes_model", "img_md");
		$this->load->model("Ofertas_model", "ofe_md");
		$this->load->library("form_validation");
	}

	public function index(){
		$data['scripts'] = [
			'/scripts/Inventarios/index',
			'/scripts/Inventarios/lectorlib',
			'/scripts/Inventarios/lector',
		];
		$data["ofertones"] = $this->ofe_md->getActivas(NULL);
		$this->estructura("Inventarios/index", $data);
	}

}