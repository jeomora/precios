<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploads extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model", "user_md");
		$this->load->model("Cambios_model", "cambio_md");
		$this->load->model("Lineas_model", "line_md");
		$this->load->model("Unidades_model", "ums_md");
		$this->load->model("Precios_model", "prize_md");
		$this->load->model("Productos_model", "prod_md");
		$this->load->model("Sucprecios_model", "sprize_md");
		$this->load->model("Sucproductos_model", "sprod_md");
		$this->load->model("Cajas_model", "caja_md");
		$this->load->model("Relcajacata_model", "relcc_md");
		$this->load->model("Catalogo_model", "cata_md");
		$this->load->model("Rojos_model", "rojo_md");
		$this->load->model("Nuevos_model", "new_md");
		$this->load->model("Nuevodetail_model", "det_md");
		$this->load->model("Listos_model", "listo_md");
		$this->load->library("form_validation");
	}

	public function upload_matriz(){
		$user = $this->session->userdata();
		ini_set("memory_limit", -1);	
		$user = $this->session->userdata();
		$filena=$_FILES['file_matriz']['name'];
		$filen = "matricial".date("dmyHis")."".rand(1000,9999);
		$config['upload_path']          = './assets/uploads/matriciales/';
        $config['allowed_types']        = 'jpg|jpeg|png|jfif|pdf';
        $config['max_size']             = 40000;
        $config['max_width']            = 40024;
        $config['max_height']           = 40024;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('file_matriz',$filen);
        $path_parts = pathinfo($_FILES["file_matriz"]["name"]);
		$extension = $path_parts['extension'];

		$new_cambio = [
			"accion" => "Sube Matricial",
			"antes" => "".$filen.".".$extension,
			"id_usuario" => $user["id_usuario"]
		];
		$cambio = $this->cambio_md->insert($new_cambio);


		$data ['id_prov'] = 0;
		$dom = file_get_contents($_FILES["file_matriz"]["tmp_name"]); 
		$articulos = [];

		$flag = 0;
		$flagNo = 1;
		$pos = explode("\n", $dom);
		$folio = "";

		$familia = "";
		$fam = "";
		$code1 = "";
		$code2 = "";
		$unidad = "";
		$existencia = "";
		$descripcion = "";
		$linea = 0;
		$filena = false;
		if(strpos($dom,"LISTA DE PRECIOS CON EXISTENCIA")){
			$filena = true;
		}
		if ($filena){
			for ($i=0; $i<sizeof($pos); $i++){
				if (!empty($pos[$i])){
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("€", "P", $pos[$i]);
					$pos[$i] = str_replace("�", "P", $pos[$i]);
					$pos[$i] = str_replace("cei-029u-2.6", "", $pos[$i]);
					$pos[$i] = str_replace("¥", "Ñ", $pos[$i]);
					$pos[$i] = str_replace("?", "Ñ", $pos[$i]);
					
					if(strpos($pos[$i],"Hoja : ") && strlen($pos[$i]) < 200){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Descripcion") && strlen($pos[$i]) < 200){
						$pos[$i] = "";
					}
					if(strpos($pos[$i]," ") === false){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"LISTA DE PRECIOS CON EXISTENCIA") && strlen($pos[$i]) < 220){
						$pos[$i] = "";
					}
					if (strlen($pos[$i]) < 10) {
						$pos[$i] = "";	
					}
					
					if($pos[$i] <> ""){
						if (substr($pos[$i], 0,1) === " "){
							$fam = substr($pos[$i], 3,2);
							$familia = substr($pos[$i], 8);
							

							$lineas = $this->line_md->get("id_linea",["ides"=>$fam])[0];
							if($lineas){
								$linea = $this->line_md->update(["nombre"=>$familia,"ides"=>$fam,"registro"=>$user['id_usuario']],$lineas->id_linea);
								$linea = $lineas->id_linea;
							}else{
								$linea = $this->line_md->insert(["nombre"=>$familia,"ides"=>$fam,"registro"=>$user['id_usuario']]);
							}
						}else{
							$code1 = substr($pos[$i], 0,17);
							$code1 = str_replace(" ", "", $code1);
							$descripcion = substr($pos[$i], 17,36);
							$unidad = substr($pos[$i], 53,3);
							$existencia = substr($pos[$i], 56,12);

							$p1 = substr($pos[$i], 70,11);
							$p1 = str_replace(" ", "", $p1);
							$p1 = str_replace(",", "", $p1);

							$p2 = substr($pos[$i], 81,12);
							$p2 = str_replace(" ", "", $p2);
							$p2 = str_replace(",", "", $p2);

							$p3 = substr($pos[$i], 93,12);
							$p3 = str_replace(" ", "", $p3);
							$p3 = str_replace(",", "", $p3);

							$p4 = substr($pos[$i], 105,12);
							$p4 = str_replace(" ", "", $p4);
							$p4 = str_replace(",", "", $p4);

							$p5 = substr($pos[$i], 117,12);
							$p5 = str_replace(" ", "", $p5);
							$p5 = str_replace(",", "", $p5);

							$code2 = substr($pos[$i], 129,14);
							$code2 = str_replace(" ", "", $code2);
							
							$ums = $this->ums_md->get("id_unidad",["ides"=>$unidad])[0];

							if(!$ums){
								$ums = $this->ums_md->insert(["ides"=>$unidad,"registro"=>$user['id_usuario']]);
							}else{
								$ums = $ums->id_unidad;
							}

							$new_producto=[
								"codigo"		=>	$code1,
								"nombre"		=>	$descripcion,
								"registro"		=>	$user["id_usuario"],
								"linea"			=>	$linea,
								"ums"			=>	$ums,
								"code"			=>	$code2,
								"fecha_registro"=>	date("Y-m-d H:i:s")
							];

							$producto = $this->prod_md->get(NULL,["codigo"=>$code1,"estatus"=>1])[0];

							if($producto){
								$id_producto = $this->prod_md->update($new_producto,$producto->id_producto);
								$id_producto = $producto->id_producto;
							}else{
								$id_producto = $this->prod_md->insert($new_producto);
							}
							

							$new_precios=[
								"id_producto"	=>	$id_producto,
								"preciouno"		=>	$p1,
								"preciodos"		=>	$p2,
								"preciotres"	=>	$p3,
								"preciocuatro"	=>	$p4,
								"preciocinco"	=>	$p5,
								"registro"		=>	$user["id_usuario"],
								"fecha_registro"=>	date("Y-m-d H:i:s")
							];


							$precio = $this->prize_md->get(NULL,["id_producto"=>$id_producto,"estatus"=>1])[0];

							if($precio){
								$id_producto = $this->prize_md->update(["estatus"=>0],["id_producto"=>$producto->id_producto]);
							}
							$id_precio = $this->prize_md->insert($new_precios);
							
						}
					}
				}
			}
			
			$mensaje=[	"id"	=>	'Éxito',
						"desc"	=>	'Datos cargados correctamente en el Sistema',
						"type"	=>	'success'];
			$this->jsonResponse($mensaje);
		}else{
			$this->jsonResponse("Documento incorrecto");
		}
	}

	public function upload_catalogo(){
		ini_set("memory_limit", -1);

		$user = $this->session->userdata();
		$filen = "catalogo".date("dmyHis")."".rand(1000,9999);
		$config['upload_path']          = './assets/uploads/catalogo/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 40000;
        $config['max_width']            = 40024;
        $config['max_height']           = 40024;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('file_catalogo',$filen);
        $path_parts = pathinfo($_FILES["file_catalogo"]["name"]);
		$extension = $path_parts['extension'];

		$new_cambio = [
			"accion" => "Sube Catálogo",
			"antes" => "".$filen.".".$extension,
			"id_usuario" => $user["id_usuario"]
		];
		$cambio = $this->cambio_md->insert($new_cambio);

		$user = $this->session->userdata();
		$fecha = new DateTime(date('Y-m-d H:i:s'));

		$dom = file_get_contents($_FILES["file_catalogo"]["tmp_name"]); 
		$articulos = [];
		$flag = 0;
		$flagNo = 1;
		$pos = explode("\n", $dom);

		$flag = 0;
		$catalogo = [];
		$filena = false;
		if(strpos($dom,"Lista de Precios (PAQUETES)")){
			$filena = true;
		}
		if(!$filena){
			$this->jsonResponse("Documento incorrecto");
		}else{
			for ($i=0; $i<sizeof($pos); $i++){
				if (!empty($pos[$i])){
					
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("€", "P", $pos[$i]);
					$pos[$i] = str_replace("�", "P", $pos[$i]);
					$pos[$i] = str_replace("¥", "Ñ", $pos[$i]);
					$pos[$i] = str_replace("?", "Ñ", $pos[$i]);
					if(strpos($pos[$i],"cei-029m-2.6")  && strlen($pos[$i]) < 150){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Lista de Precios") && strlen($pos[$i]) < 150){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Descripcion")  && strlen($pos[$i]) < 150){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Codigo-Paquete")  && strlen($pos[$i]) < 150){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"-----------")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Hoja : ") && strlen($pos[$i]) < 150){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"N o m b r e") && strlen($pos[$i]) < 150){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Precio c") && strlen($pos[$i]) < 150){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"CEDIS ABARROTES AZTECA")  && strlen($pos[$i]) < 150){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"FIN DE REPORTE")){
						$pos[$i] = "";
					}
					if(strlen($pos[$i]) < 10){
						$pos[$i] = "";	
					}

					if($pos[$i] <> ""){
						if( substr($pos[$i], 2,1) == "-" ){
							$cajafa	=	substr($pos[$i], 0,2);
							$cajaco	=	str_replace(" ", "", substr($pos[$i], 3,15));
							$cajads	=	str_replace("  ", "", substr($pos[$i], 20,52));
							$cajaum	=	substr($pos[$i], 72,3);
							$new_cajon =[
								"cajafa"	=>	$cajafa,
								"cajaco"	=>	$cajaco,
								"cajads"	=>	$cajads,
								"cajaum"	=>	$cajaum,
								"fecha_registro"=>	date("Y-m-d H:i:s"),
								"registro"	=>	$user["id_usuario"]
							];
							$hayCaja = $this->caja_md->get(NULL,["estatus"=>1,"cajaco"=>$cajaco]);
							if($hayCaja){
								$this->caja_md->update(["estatus"=>0],["estatus"=>1,"cajaco"=>$cajaco]);
							}
							$new_caja = $this->caja_md->insert($new_cajon);
						}else{
							if(isset( $catalogo[ str_replace(" ", "", substr($pos[$i], 4,17)) ] )){
								$new_cata = $this->cata_md->get(NULL,["estatus"=>1,"codigo"=>str_replace(" ", "", substr($pos[$i], 4,17))])[0];
								$new_rel = $this->relcc_md->insert(["id_caja"=>$new_caja,"id_catalogo"=>$new_cata->id_catalogo,"cantidad"=>str_replace(",", "", str_replace(" ", "", substr($pos[$i], 65,8)))]);
							}else{
								$new_catas =[
									"codigo"		=>	str_replace(" ", "", substr($pos[$i], 4,17)),
									"descripcion"	=>	str_replace("  ", "", substr($pos[$i], 21,44)),
									"unidad"		=>	str_replace(",", "", str_replace(" ", "", substr($pos[$i], 65,8))),
									"registro"		=>	$user["id_usuario"],
								];
								$catalogo[$new_catas["codigo"]]["caja1"] = $new_caja;
								$haycata = $this->cata_md->get(NULL,["estatus"=>1,"codigo"=>str_replace(" ", "", substr($pos[$i], 4,17))]);
								if($haycata){
									$this->cata_md->update(["estatus"=>0],["estatus"=>1,"codigo"=>str_replace(" ", "", substr($pos[$i], 4,17))]);
								}
								$new_cata = $this->cata_md->insert($new_catas);
								$new_rel = $this->relcc_md->insert(["id_caja"=>$new_caja,"id_catalogo"=>$new_cata,"cantidad"=>str_replace(",", "", str_replace(" ", "", substr($pos[$i], 65,8)))]);
							}
						}
					}				}
			}
			$mensaje=[	"id"	=>	'Éxito',
						"desc"	=>	'Datos cargados correctamente en el Sistema',
						"type"	=>	'success'];
			$this->jsonResponse($mensaje);
		}	

		$this->jsonResponse($pos)	;
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
				$new_rojo=[
					"codigo"		=>	$this->getOldVal($sheet,$i,"A"),
					"descripcion"	=>	$this->getOldVal($sheet,$i,"B"),
					"costo"			=>	$this->getOldVal($sheet,$i,"C"),
					"agrego"		=>	$user["id_usuario"],
					"estatus"		=>	1,
					"fecha_registro"=>	date("Y-m-d H:i:s"),
				];

				$rojatzo = $this->rojo_md->get("id_rojo",[ 'codigo' => $this->getOldVal($sheet,$i,"A"), "estatus" => 1 ]);
				if($rojatzo){
					$new_rojo["estatus"] = 0;
					$this->rojo_md->update($new_rojo, ['id_rojo' => $rojatzo[0]->id_rojo]);
				}
				$new_rojo["estatus"] = 1;
				$rojo = $this->rojo_md->insert($new_rojo);
				$mensaje = "Archivo valido";
			}
		}
		
		$this->jsonResponse($mensaje);
	}

	public function getRojos(){
		$rojos = $this->rojo_md->getRojos(NULL);
		$this->jsonResponse($rojos);
	}

	public function saveRojos(){
		$values = json_decode($this->input->post("value"));
		$user = $this->session->userdata();
		$nuevo = $this->new_md->insert(["agrego" => $user["id_usuario"]]);
		foreach ($values as $key => $value) {
			if($value){
				$new_nuevo = [
					"id_nuevo"	=> $nuevo,
					"id_rojo"	=> $value->id_rojo,
					"code1"		=> $value->codigo1,
					"code2"		=> $value->codigo2,
					"code3"		=> $value->code3,
					"linea"		=> $value->lin,
					"desc1"		=> $value->desc1,
					"unidad"	=> $value->um,
					"desc2"		=> $value->desc2,
					"cantidad"	=> $value->cantidad,
					"costo"		=> $value->costo,
					"iva"		=> $value->iva,
					"mar1"		=> $value->mar1,
					"mar2"		=> $value->mar2,
					"mar3"		=> $value->mar3,
					"mar4"		=> $value->mar4,
					"mar11"		=> $value->mar11,
					"mar22"		=> $value->mar22,
					"mar33"		=> $value->mar33,
					"mar44"		=> $value->mar44,
					"pre1"		=> $value->pre1,
					"pre2"		=> $value->pre2,
					"pre3"		=> $value->pre3,
					"pre4"		=> $value->pre4,
					"pre5"		=> ($value->costo + 0.01),
					"pre11"		=> $value->pre11,
					"pre22"		=> $value->pre22,
					"pre33"		=> $value->pre33,
					"pre44"		=> $value->pre44,
					"costopz"	=> $value->costopz,
					"matriz"	=> $value->matriz,
				];
				$detail = $this->det_md->insert($new_nuevo);
				$this->rojo_md->update(["estatus"=>2],["id_rojo"=>$value->id_rojo]);
				$matriz = $this->prod_md->get(NULL,["codigo"=>$value->codigo1]);
				if($matriz){
					$new_precios = [
						"id_producto"		=>	$matriz[0]->id_producto,
						"preciouno"			=>	$value->pre1,
						"preciodos"			=>	$value->pre2,
						"preciotres"		=>	$value->pre3,
						"preciocuatro"		=>	$value->pre4,
						"preciocinco"		=>	$value->pre5,
						"registro"			=> $user["id_usuario"]
					];
					$this->prize_md->update(["estatus"=>0],["id_producto"=>$matriz[0]->id_producto]);
					$this->prize_md->insert($new_precios);
					$matriz = $this->prod_md->get(NULL,["codigo"=>$value->code3]);
					if ($matriz) {
						$new_precios = [
							"id_producto"		=>	$matriz[0]->id_producto,
							"preciouno"			=>	$value->pre11,
							"preciodos"			=>	$value->pre22,
							"preciotres"		=>	$value->pre33,
							"preciocuatro"		=>	$value->pre44,
							"preciocinco"		=>	$value->costopz,
							"registro"			=> $user["id_usuario"]
						];
						$this->prize_md->update(["estatus"=>0],["id_producto"=>$matriz[0]->id_producto]);
						$this->prize_md->insert($new_precios);
					}
				}
			}
		}
		$this->jsonResponse($nuevo);
	}

	public function getMaxNew(){
		$this->jsonResponse($this->new_md->getMaxReg(NULL)[0]);
	}

	public function getNuevos(){
		$rojos = $this->new_md->getRojos(NULL);
		$this->jsonResponse($rojos);
	}

	public function setListo($val1,$val2){
		$user = $this->session->userdata();
		$listo = $this->listo_md->get(NULL,["id_detalle"=>$val2,"id_sucursal"=>$user["id_sucursal"]]);
		if($listo){
			$this->listo_md->update([ "estatus"=>$val1,"fecha_registro"=>date("Y-m-d H:i:s"),"agrego"=>$user["id_usuario"] ],["id_listo"=>$listo[0]->id_listo]);
		}else{
			$this->listo_md->insert([ "agrego"=>$user["id_usuario"],"id_sucursal"=>$user["id_sucursal"],"id_detalle"=>$val2 ]);
		}
	}

	
}