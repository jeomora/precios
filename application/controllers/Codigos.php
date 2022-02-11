<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Codigos extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model", "user_md");
		$this->load->model("Sucursales_model", "sucu_md");
		$this->load->model("Nuevodetail_model", "det_md");
		$this->load->model("Nuevob_model", "newb_md");
		$this->load->model("Ofertas_model", "ofe_md");
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

	public function ofertas($value){
		$user = $this->session->userdata();//Trae los datos del usuario
		$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
		$data['scripts'] = [
			'/scripts/qrcode',
			'/scripts/Totales/ofertas',
			'/scripts/Swiper/package/js/swiper.min',
		];
		$data['links'] = [
			'/scripts/Swiper/package/css/swiper.min',
		];
		$values = $this->ofe_md->getOferton(["o.conjunto"=>$value]);
		$data["siArr"] = sizeof($values);
		$this->estructuraQr("Dashboards/ofertas", $data);
	}

	public function ofertasS($value){
		$user = $this->session->userdata();//Trae los datos del usuario
		$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
		if ($user["id_sucursal"] == 1) {
			$data['scripts'] = [
				'/scripts/qrcode',
				'/scripts/Totales/ofertasST',
				'/scripts/Swiper/package/js/swiper.min',
			];
		} else {
			$data['scripts'] = [
				'/scripts/qrcode',
				'/scripts/Totales/ofertasS',
				'/scripts/Swiper/package/js/swiper.min',
			];
		}
		
		$data['links'] = [
			'/scripts/Swiper/package/css/swiper.min',
		];
		$values = $this->ofe_md->getOferton(["o.conjunto"=>$value]);
		$data["siArr"] = sizeof($values);
		$this->estructuraQr("Dashboards/ofertas", $data);
	}

	public function ofertasR($value){
		$user = $this->session->userdata();//Trae los datos del usuario
		$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
		$data['scripts'] = [
			'/scripts/qrcode',
			'/scripts/Totales/ofertasR',
			'/scripts/Swiper/package/js/swiper.min',
		];
		$data['links'] = [
			'/scripts/Swiper/package/css/swiper.min',
		];
		$values = $this->ofe_md->getOferton(["o.conjunto"=>$value]);
		$data["siArr"] = sizeof($values);
		$this->estructuraQr("Dashboards/ofertas", $data);
	}

	public function ofertasRS($value){
		$user = $this->session->userdata();//Trae los datos del usuario
		$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
		if ($user["id_sucursal"] == 1) {
			$data['scripts'] = [
				'/scripts/qrcode',
				'/scripts/Totales/ofertasRST',
				'/scripts/Swiper/package/js/swiper.min',
			];
		} else {
			$data['scripts'] = [
				'/scripts/qrcode',
				'/scripts/Totales/ofertasRS',
				'/scripts/Swiper/package/js/swiper.min',
			];
		}
		$data['links'] = [
			'/scripts/Swiper/package/css/swiper.min',
		];
		$values = $this->ofe_md->getOferton(["o.conjunto"=>$value]);
		$data["siArr"] = sizeof($values);
		$this->estructuraQr("Dashboards/ofertas", $data);
	}

	public function qrmeup($val){
		$values = $this->det_md->getNuevos(NULL,$val);
		$this->jsonResponse($values);
	}

	public function qrmeupB($val){
		$values = $this->newb_md->getNuevosB(NULL,$val);
		$this->jsonResponse($values);
	}

	public function qrmeOf($val){
		$values = $this->ofe_md->getOferton(["o.conjunto"=>$val]);
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
		
		if($user["id_sucursal"] == 1){
			$data['scripts'] = [
				'/scripts/qrcode',
				'/scripts/Totales/codigosT',
				'/scripts/Swiper/package/js/swiper.min',
			];
		}else{
			$data['scripts'] = [
				'/scripts/qrcode',
				'/scripts/Totales/codigosS',
				'/scripts/Swiper/package/js/swiper.min',
			];
		}
		$data['links'] = [
			'/scripts/Swiper/package/css/swiper.min',
		];
		$values = $this->det_md->get(NULL,["id_nuevo"=>$value]);
		$data["siArr"] = sizeof($values);
		$this->estructuraQr("Dashboards/codigosS", $data);
	}

	public function qrmeSB($value){
		$user = $this->session->userdata();//Trae los datos del usuario
		$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
		$data['scripts'] = [
			'/scripts/qrcode',
			'/scripts/Totales/codigosSB',
			'/scripts/Swiper/package/js/swiper.min',
		];
		$data['links'] = [
			'/scripts/Swiper/package/css/swiper.min',
		];
		$values = $this->newb_md->get(NULL,["id_nuevo"=>$value]);
		$data["siArr"] = sizeof($values);
		$this->estructuraQr("Dashboards/codigosSB", $data);
	}
}