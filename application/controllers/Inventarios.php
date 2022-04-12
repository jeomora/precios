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
		$this->load->model("Sucproductos_model", "sprod_md");
		$this->load->model("Cajas_model", "caja_md");
		$this->load->model("Lineas_model", "ln_md");
		$this->load->model("Nuevos_model", "new_md");
		$this->load->model("Imagenes_model", "img_md");
		$this->load->model("Ofertas_model", "ofe_md");
		$this->load->model("Inventario_model", "inv_md");
		$this->load->library("form_validation");
	}

	public function index(){
		$data['scripts'] = [
			'/scripts/Inventarios/index',
		];
		$data["ofertones"] = $this->ofe_md->getActivas(NULL);
		$this->estructura("Inventarios/index", $data);
	}

	public function getInventario(){
		$data = $this->inv_md->getInventario(NULL);
		$this->jsonResponse($data);
	}

	public function addInventario(){
		$productos = $this->inv_md->getE(NULL);
		if ($productos) {
			foreach ($productos as $key => $value) {
				$this->inv_md->insert(["id_producto"=>$value->id_producto, "cantidad"=>rand(5, 15), "id_pasillo"=>rand(1,27) ]);		
			}
		}
		$this->jsonResponse($productos);
	}


	public function qrme($value){
		$user = $this->session->userdata();//Trae los datos del usuario
		$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
		$data['scripts'] = [
			'/scripts/qrcode',
			'/scripts/Inventarios/codigos',
			'/scripts/Swiper/package/js/swiper.min',
		];
		$data['links'] = [
			'/scripts/Swiper/package/css/swiper.min',
		];
		$values = $this->inv_md->get(NULL,["id_pasillo"=>$value,"estatus"=>1]);
		$data["siArr"] = sizeof($values)/10;
		$this->estructuraQr("Inventarios/codigos", $data);
	}

	public function qrmeup($val){
		$values = $this->inv_md->getNuevos(NULL,$val);
		$this->jsonResponse($values);
	}

}