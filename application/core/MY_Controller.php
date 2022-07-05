<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	protected $header = ""; //Archivo header
	protected $top_menu = ""; //Menú arriba
	protected $folder = ""; //Contenedor de las vistas del menú
	protected $footer = ""; //Archivo footer
	protected $main = ""; //Archivo principal
	protected $ASSETS;
	protected $UPLOADS;
	protected $KEY;


	function __construct() {
		parent::__construct();
		$data["usuario"] = $this->session->userdata();//Trae los datos del usuario;
		//Asignamos el valor a las variables"!
		$this->ASSETS = "./assets/";
		$this->UPLOADS = "uploads/";
		$this->KEY='APGoyQGOKAR5iXQ1wiO6i4jNczeMV7Sg';//Para encriptar las contraseñas
		$this->qrcode = "";
		$this->load->vars($data);
		$this->header = "Structure/header";
		$this->top_menu  = "Structure/top_menu";
		$this->top_menu2  = "Structure/top_menu2";
		$this->footer = "Structure/footer";
		$this->footer2 = "Structure/footer2";
		$this->main = "Structure/main";
		$this->folder = "Structure";
		$this->load->model("Sucursales_model", "sucu_md");
		$this->load->model("Avatars_model", "ava_md");

	}

	public function estructura($view, $data = NULL) {
		$data["svgs33"] = $this->ava_md->get();
		$data["dayss"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["monthss"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["sucursales"] = $this->sucu_md->get(NULL);
		$this->load->view($this->header, $data);
		$this->load->view($this->top_menu, $data);
		$this->load->view($view, $data);
		$this->load->view($this->footer, $data);
		$this->load->view($this->main, $data);
	}

	public function estructuraFactus($view, $data = NULL) {
		$data["svgs33"] = $this->ava_md->get();
		$data["dayss"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["monthss"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["sucursales"] = $this->sucu_md->get(NULL);
		$this->load->view($this->header, $data);
		$this->load->view($this->top_menu2, $data);
		$this->load->view($view, $data);
		$this->load->view($this->footer2, $data);
		$this->load->view($this->main, $data);
	}

	public function estructuraQr($view, $data = NULL) {
		$data["svgs33"] = $this->ava_md->get();
		$data["dayss"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$data["monthss"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$data["sucursales"] = $this->sucu_md->get(NULL);
		$this->load->view("Structure/headerQr", $data);
		$this->load->view($view, $data);
		$this->load->view("Structure/footerQr", $data);
	}

	public function jsonResponse( $response ) {
		header( "content-type: application/json; charset=utf8" );
		echo json_encode( $response );
	}

	public function createFolder($folder){
		$base = $this->ASSETS.$this->UPLOADS;
		$ruta = $this->ASSETS.$this->UPLOADS.$folder."/";
		if(!is_dir($ruta)){
			mkdir($this->ASSETS, 0777);
			mkdir($base, 0777);
			mkdir($ruta, 0777);
		}
		return $ruta;
	}

	public function weekNumber($date=NULL){
		if (empty($date)) {
			$fecha = new DateTime(date('Y-m-d H:i:s'));
			$intervalo = new DateInterval('P2D');
			$fecha->add($intervalo);
			$date = $fecha->format('Y-m-d H:i:s');
		}
		$day	=	substr(date($date),8,2);//Día actual
		$month	=	substr(date($date),5,2);//Mes actual
		$year	=	substr(date($date),0,4);//Año actual
		return date("W", mktime(0,0,0,$month,$day,$year));//El número de la semana
	}

	public function getOldVal($sheets,$i,$le){
		$cellB = $sheets->getCell($le.$i)->getValue();
		if(strstr($cellB,'=')==true){
		    $cellB = $sheets->getCell($le.$i)->getOldCalculatedValue();
		}
		return $cellB;
	}

	public function cellStyle($cells=NULL, $background=NULL, $font_color=NULL, $bold=FALSE, $font_size=NULL, $font_family=NULL){
		$this->load->library("excelfile");
		$this->excelfile->getActiveSheet()->getStyle($cells)->applyFromArray(
			array(	"fill"	=>	array(	"type"	=>	PHPExcel_Style_Fill::FILL_SOLID,
										"color"	=>	array("rgb"	=>	$background)),
					"alignment"	=>	array(	"horizontal"	=>	PHPExcel_Style_Alignment::HORIZONTAL_CENTER,),
					"font"		=>	array(	"bold"			=>	$bold,
											"color"			=>	array(	"rgb"	=>	$font_color),
											"size"			=>	$font_size,
											"name"			=>	$font_family))
		);
	}

	public function encryptPassword($password=NULL){
		//$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->KEY), $password, MCRYPT_MODE_CBC, md5(md5($this->KEY))));
		$secret_key = 'Aguila Blanca';
		$secret_iv = 'desiframe esta';
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
		$encrypted = base64_encode( openssl_encrypt( $password, $encrypt_method, $key, 0, $iv ) );
		return $encrypted;
	}

	public function showPassword($password=NULL){
		$secret_key = 'Aguila Blanca';
		$secret_iv = 'desiframe esta';
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
		//$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->KEY), base64_decode($password), MCRYPT_MODE_CBC, md5(md5($this->KEY))), "\0");
		$output = openssl_decrypt( base64_decode( $password ), $encrypt_method, $key, 0, $iv );
		return $output;
	}


	public function dateDiff($date){
		$mydate= date("Y-m-d H:i:s");
		$theDiff="";
		$datetime1 = date_create($date);
		$datetime2 = date_create($mydate);
		$interval = date_diff($datetime1, $datetime2);

		$min=$interval->format('%i');
		$sec=$interval->format('%s');
		$hour=$interval->format('%h');
		$mon=$interval->format('%m');
		$day=$interval->format('%d');
		$year=$interval->format('%y');
		if($interval->format('%i%h%d%m%y')=="00000"){
			return $sec." Segundos";
		}else if($interval->format('%h%d%m%y')=="0000"){
			return $min." Minutos";
		}else if($interval->format('%d%m%y')=="000"){
			return $hour." Horas";
		}else if($interval->format('%m%y')=="00"){
			return $day." Dias";
		}else if($interval->format('%y')=="0"){
			return $mon." Meses";
		}else{
			return $year." Años";
		}
	}


}

/* End of file MY_Controller.php */
/* Location: ./application/controllers/MY_Controller.php */