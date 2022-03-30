<?php
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
		$this->load->library("form_validation");
	}
}