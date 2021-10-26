<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model", "user_md");
		$this->load->model("Cambios_model", "cambio_md");
		$this->load->model("Productos_model", "prod_md");
		$this->load->model("Rojos_model", "rojo_md");
		$this->load->library("form_validation");
	}

	public function index(){
		if($this->session->userdata("username")){
			$user = $this->session->userdata();//Trae los datos del usuario
			$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
			$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
			$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
			$data['scripts'] = [
				'/scripts/Compras/index',
			];
			$this->estructura("Compras/index", $data);
		}else{
			$this->data["message"] =NULL;
			$this->estructura_login("Admin/login", $this->data, FALSE);
		}
	}

	public function upload_excel(){
		$user = $this->session->userdata();
		$this->load->library("excelfile");
		ini_set("memory_limit", -1);
		$file = $_FILES["file_excel"]["tmp_name"];
		$sheet = PHPExcel_IOFactory::load($file);
		$objExcel = PHPExcel_IOFactory::load($file);
		$sheet = $objExcel->getSheet(0);
		$num_rows = $sheet->getHighestDataRow();

		$filen = "excel".date("dmyHis")."".rand(1000,9999);
		$config['upload_path']          = './assets/uploads/excel/';
        $config['allowed_types']        = 'xlsx|xls';
        $config['max_size']             = 10000;
        $config['max_width']            = 10024;
        $config['max_height']           = 7608;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $new_existencias = FALSE;
        $this->upload->do_upload('file_excel',$filen);

        $new_cambio = [
			"accion" => "Sube Excel",
			"antes" => "".$filen,
			"id_usuario" => $user["id_usuario"]
		];
		$cambio = $this->cambio_md->insert($new_cambio);
		$mensaje = "Archivo invalido";
		for ($i=3; $i<=$num_rows; $i++) {
			if($this->getOldVal($sheet,$i,"A") <> "" && $this->getOldVal($sheet,$i,"A") <> "  "){
				if( $this->getOldVal($sheet,$i,"C") == "" ){///CAMBIO DE DESCRIPCIÓN
					$new_rojo=[
						"codigo"		=>	$this->getOldVal($sheet,$i,"A"),
						"descripcion"	=>	$this->getOldVal($sheet,$i,"B"),
						"agrego"		=>	$user["id_usuario"],
						"estatus"		=>	5,
						"fecha_registro"=>	date("Y-m-d H:i:s"),
					];

					$rojatzo = $this->rojo_md->get("id_rojo",[ 'codigo' => $this->getOldVal($sheet,$i,"A"), "estatus" => 5 ]);
					//Estatus 0 sí ya se ha agregado y no se ha modificado...
					if($rojatzo){
						$new_rojo["estatus"] = 0;
						$this->rojo_md->update(["estatus"=>0] , ['id_rojo' => $rojatzo[0]->id_rojo]);
					}
					$rojatzo = $this->rojo_md->get("id_rojo",[ 'codigo' => $this->getOldVal($sheet,$i,"A"), "estatus" => 3 ]);
					if($rojatzo){
						$new_rojo["estatus"] = 0;
						$this->rojo_md->update(["estatus"=>0] , ['id_rojo' => $rojatzo[0]->id_rojo]);
					}

					//Si no se encuentra un producto con el código, se agregará estatus 3 y se mostrará para hacer cambios. 
					
					$prods = $this->prod_md->get(NULL,[ 'codigo' => $this->getOldVal($sheet,$i,"A") ]);

					if($prods){
						$new_rojo["estatus"] = 5;
						$new_rojo["codigo"] = $prods[0]->codigo;
						$rojo = $this->rojo_md->insert($new_rojo);
					}else{
						$new_rojo["estatus"] = 3;
						$rojo = $this->rojo_md->insert($new_rojo);
					}


					$mensaje = "Archivo valido";
				}elseif( $this->getOldVal($sheet,$i,"D") <> ""){///ALTA DE PRODUCTO
					$new_rojo=[
						"codigo"		=>	$this->getOldVal($sheet,$i,"A"),
						"descripcion"	=>	$this->getOldVal($sheet,$i,"B"),
						"costo"	=>	$this->getOldVal($sheet,$i,"C"),
						"agrego"		=>	$user["id_usuario"],
						"estatus"		=>	4,
						"fecha_registro"=>	date("Y-m-d H:i:s"),
						"code_relacion"	=>	$this->getOldVal($sheet,$i,"E"),
						"um_nuevo"		=>	$this->getOldVal($sheet,$i,"D"),
						"codecaja"		=>	$this->codeCaja()
					];

					$rojatzo = $this->rojo_md->get("id_rojo",[ 'codigo' => $this->getOldVal($sheet,$i,"A"), "estatus" => 4 ]);
					//Estatus 0 sí ya se ha agregado y no se ha modificado...
					if($rojatzo){
						$new_rojo["estatus"] = 0;
						$this->rojo_md->update(["estatus"=>0] , ['id_rojo' => $rojatzo[0]->id_rojo]);
					}
					$rojatzo = $this->rojo_md->get("id_rojo",[ 'codigo' => $this->getOldVal($sheet,$i,"A"), "estatus" => 6 ]);
					if($rojatzo){
						$new_rojo["estatus"] = 0;
						$this->rojo_md->update(["estatus"=>0] , ['id_rojo' => $rojatzo[0]->id_rojo]);
					}

					//Si no se encuentra un producto con el código, se agregará estatus 3 y se mostrará para hacer cambios. 
					
					$prods = $this->prod_md->get(NULL,[ 'codigo' => $this->getOldVal($sheet,$i,"A") ]);

					if($prods){
						$new_rojo["estatus"] = 6;//ALTA CODIGO YA EXISTE
						$rojo = $this->rojo_md->insert($new_rojo);
					}else{
						$new_rojo["estatus"] = 4;
						$rojo = $this->rojo_md->insert($new_rojo);
					}


					$mensaje = "Archivo valido";
				}else{///AJUSTE DE PRECIOS

					$new_rojo=[
						"codigo"		=>	$this->getOldVal($sheet,$i,"A"),
						"descripcion"	=>	$this->getOldVal($sheet,$i,"B"),
						"costo"			=>	$this->getOldVal($sheet,$i,"C"),
						"agrego"		=>	$user["id_usuario"],
						"estatus"		=>	1,
						"fecha_registro"=>	date("Y-m-d H:i:s"),
					];

					$rojatzo = $this->rojo_md->get("id_rojo",[ 'codigo' => $this->getOldVal($sheet,$i,"A"), "estatus" => 1 ]);
					//Estatus 0 sí ya se ha agregado y no se ha modificado...
					if($rojatzo){
						$new_rojo["estatus"] = 0;
						$this->rojo_md->update(["estatus"=>0] , ['id_rojo' => $rojatzo[0]->id_rojo]);
					}
					$rojatzo = $this->rojo_md->get("id_rojo",[ 'codigo' => $this->getOldVal($sheet,$i,"A"), "estatus" => 3 ]);
					if($rojatzo){
						$new_rojo["estatus"] = 0;
						$this->rojo_md->update(["estatus"=>0] , ['id_rojo' => $rojatzo[0]->id_rojo]);
					}

					//Si no se encuentra un producto con el código, se agregará estatus 3 y se mostrará para hacer cambios. 
					


					$prods = $this->prod_md->get(NULL,[ 'codigo' => $this->getOldVal($sheet,$i,"A") ]);

					if($prods){
						$new_rojo["estatus"] = 1;
						$new_rojo["codigo"] = $prods[0]->codigo;
						$rojo = $this->rojo_md->insert($new_rojo);
					}else{
						$new_rojo["estatus"] = 3;
						$rojo = $this->rojo_md->insert($new_rojo);
					}


					$mensaje = "Archivo valido";

				}
				
			}
		}
		
		$this->jsonResponse($mensaje);
	}

	public function getRojosCompras(){
		$rojos = $this->rojo_md->getRojosCompras(NULL);
		$this->jsonResponse($rojos);
	}

	public function delRowRojo($id_rojo){
		$rojo = $this->rojo_md->get(NULL,["id_rojo"=>$id_rojo])[0];
		$upda = $this->rojo_md->update( ["estatus"=>0],["id_rojo"=>$id_rojo] );
		$user = $this->session->userdata();
		$cambio = [
			"id_usuario"	=>	$user["id_usuario"],
			"accion"		=>	1,
			"antes"			=>	$id_rojo,
			"despues"		=>	"Elimina Registro"
		];
		if($rojo->estatus == 1){
			$this->cambio_md->insert($cambio);
		}
		$this->jsonResponse($upda);
	}

	private function codeCaja(){
		$codigo = $this->rojo_md->codeCaja(NULL)[0];
		$busca1 = $this->prod_md->get(NULL,["codigo"=>$codigo->codecaja]);
		$busca2 = $this->prod_md->get(NULL,["code"=>$codigo->codecaja]);
		if($busca1 || $busca2){
			$codigo = $this->rojo_md->codeCaja(NULL);
			$busca1 = $this->prod_md->get(NULL,["codigo"=>$codigo->codecaja]);
			$busca2 = $this->prod_md->get(NULL,["code"=>$codigo->codecaja]);
			if($busca1 || $busca2){
				$codigo = $this->rojo_md->codeCaja(NULL);
			}
		}
		return $codigo->codecaja;
	}
}