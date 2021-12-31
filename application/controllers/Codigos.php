<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Codigos extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model", "user_md");
		$this->load->model("Sucursales_model", "sucu_md");
		$this->load->model("Nuevodetail_model", "det_md");
		$this->load->library("form_validation");
	}

	public function qrme($value){
		$user = $this->session->userdata();//Trae los datos del usuario
		$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
		$data['scripts'] = [
			'/scripts/qrcode',
			'/scripts/Totales/codigos',
			'/scripts/Swiper/package/js/swiper.min',
		];
		$data['links'] = [
			'/scripts/Swiper/package/css/swiper.min',
		];
		$values = $this->det_md->get(NULL,["id_nuevo"=>$value]);
		$data["siArr"] = sizeof($values);
		$this->estructuraQr("Dashboards/codigos", $data);
	}

	public function qrmeup($val){
		$values = $this->det_md->get(NULL,["id_nuevo"=>$val]);
		$this->jsonResponse($values);
	}

	public function getMeClave(){
		$user = $this->session->userdata();
		$values = $this->sucu_md->get(NULL,["id_sucursal"=>$user["id_sucursal"]])[0];
		$this->jsonResponse($values);
	}


	public function qrmeS($value){
		$user = $this->session->userdata();//Trae los datos del usuario
		$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
		$data['scripts'] = [
			'/scripts/qrcode',
			'/scripts/Totales/codigosS',
			'/scripts/Swiper/package/js/swiper.min',
		];
		$data['links'] = [
			'/scripts/Swiper/package/css/swiper.min',
		];
		$values = $this->det_md->get(NULL,["id_nuevo"=>$value]);
		$data["siArr"] = sizeof($values);
		$this->estructuraQr("Dashboards/codigosS", $data);
	}
}