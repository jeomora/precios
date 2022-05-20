<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Lineas_model","ln_md");
		$this->load->model("Detalleentra_model","dentr_md");
		$this->load->library("form_validation");
	}

	public function index(){
		$data['scripts'] = [
			'/scripts/Reporte/index',
		];
		$data["lineas"] = $this->ln_md->get(NULL,["estatus"=>1]);
		$this->estructura("Reporte/index", $data);
	}

	public function getMerma(){
		$merma = $this->dentr_md->getMerma(NULL);
		$this->jsonResponse($merma);
	}

}