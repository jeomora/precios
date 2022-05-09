<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends MY_Controller {

	function __construct(){
		parent::__construct();
		
		$this->load->library("form_validation");
	}

	public function index(){
		$data['scripts'] = [
			'/scripts/Reporte/index',
		];
		
		$this->estructura("Reporte/index", $data);
	}

}