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
		$this->load->model("Listosof_model", "listof_md");
		$this->load->model("Paquetes_model", "pack_md");
		$this->load->model("Nuevob_model", "newb_md");
		$this->load->model("Ofertas_model", "ofe_md");
		$this->load->library("form_validation");
	}

	public function upload_matriz(){
		$user = $this->session->userdata();
		ini_set("memory_limit", -1);	
		
		$filena=$_FILES['file_matriz']['name'];
		$filen = "matricial".date("dmyHis")."".rand(1000,9999);
		$config['upload_path']          = './assets/uploads/matriciales/';
        $config['allowed_types']        = 'jpg|xls|xlsx|dat|txt';
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
								$id_producto = $this->prize_md->update(["estatus"=>0],["id_producto"=>$id_producto]);
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
		$hayCaja = false;
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
							$cajaco	=	str_replace(" ", "", substr($pos[$i], 3,15));
							$hayCaja = $this->prod_md->get(NULL,["estatus"=>1,"codigo"=>$cajaco]);
						}else{
							if($hayCaja){
								$codpz = str_replace(" ", "", substr($pos[$i], 4,17));
								$canpz = str_replace(",", "", str_replace(" ", "", substr($pos[$i], 65,8)));
								$pieza = $this->prod_md->get(NULL,["estatus"=>1,"codigo"=>$codpz]);
								if($pieza) {
									$this->pack_md->update(["estatus"=>0],["estatus"=>1,"id_caja"=>$hayCaja[0]->id_producto,"id_pieza"=>$pieza[0]->id_producto]);
									$this->pack_md->insert([ "estatus"=>1,"id_caja"=>$hayCaja[0]->id_producto,"id_pieza"=>$pieza[0]->id_producto,"cantidad"=>$canpz ]);
									$this->prod_md->update(["unidad"=>$canpz],["id_producto"=>$pieza[0]->id_producto]);
								}
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
        $config['max_size']             = 80000;
        $config['max_width']            = 80024;
        $config['max_height']           = 87608;
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
					"estatus"	=> $value->estatus,
				];
				$detail = $this->det_md->insert($new_nuevo);
				if ($value->estatus == 2) {
					$this->rojo_md->update(["estatus"=>7],["id_rojo"=>$value->id_rojo]);
				}else{
					$this->rojo_md->update(["estatus"=>2],["id_rojo"=>$value->id_rojo]);
				}

				$matriz = $this->prod_md->get(NULL,["codigo"=>$value->codigo1]);
				if($matriz){
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
					$matriz = $this->prod_md->get(NULL,["codigo"=>$value->code3]);
					if ($matriz) {
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
					}
				}else{
					$linea = $this->line_md->get(NULL,["ides"=>$value->lin])[0];
					
					$new_producto = [
						"codigo"	=>	$value->codigo1,
						"nombre"	=>	$value->desc1,
						"registro"	=>	$user["id_usuario"],
						"linea"		=>	$linea->id_linea,
						"unidad"	=>	$value->cantidad,
						"ums"		=>	1,
						"code"		=>	$value->codigo1
					];
					$prodo = $this->prod_md->insert($new_producto);

					$new_precios = [
						"id_producto"		=>	$prodo,
						"preciouno"			=>	$value->pre11,
						"preciodos"			=>	$value->pre22,
						"preciotres"		=>	$value->pre33,
						"preciocuatro"		=>	$value->pre44,
						"preciocinco"		=>	$value->costopz,
						"registro"			=> $user["id_usuario"]
					];
					$this->prize_md->insert($new_precios);
					$matriz = $this->prod_md->get(NULL,["codigo"=>$value->code3]);
					if ($matriz) {
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
					}else{
						$new_producto = [
							"codigo"	=>	$value->code3,
							"nombre"	=>	$value->desc2,
							"registro"	=>	$user["id_usuario"],
							"linea"		=>	$linea->id_linea,
							"unidad"	=>	$value->cantidad,
							"ums"		=>	1,
							"code"		=>	$value->code3
						];
						$prodo = $this->prod_md->insert($new_producto);
						$new_precios = [
							"id_producto"		=>	$prodo,
							"preciouno"			=>	$value->pre1,
							"preciodos"			=>	$value->pre2,
							"preciotres"		=>	$value->pre3,
							"preciocuatro"		=>	$value->pre4,
							"preciocinco"		=>	$value->pre5,
							"registro"			=> $user["id_usuario"]
						];
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

	public function getNuevosA(){
		$rojos = $this->new_md->getRojos(NULL);
		$this->jsonResponse($rojos);
	}
	public function getNuevosASucu(){
		$rojos = $this->new_md->getRojosSucu(NULL);
		$this->jsonResponse($rojos);
	}

	public function getNuevosB(){
		$rojos = $this->new_md->getRojosB(NULL);
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

	public function setListoOf($val1,$val2){
		$user = $this->session->userdata();
		$listo = $this->listof_md->get(NULL,["id_detalle"=>$val2,"id_sucursal"=>$user["id_sucursal"]]);
		if($listo){
			$this->listof_md->update([ "estatus"=>$val1,"fecha_registro"=>date("Y-m-d H:i:s"),"agrego"=>$user["id_usuario"] ],["id_listo"=>$listo[0]->id_listo]);
		}else{
			$this->listof_md->insert([ "agrego"=>$user["id_usuario"],"id_sucursal"=>$user["id_sucursal"],"id_detalle"=>$val2 ]);
		}
	}

	public function getCambioDesc(){
		$rojos = $this->rojo_md->getCambioDesc(NULL);
		$this->jsonResponse($rojos);
	}

	public function setCambiar(){
		$user = $this->session->userdata();
		$values = json_decode($this->input->post("value"));
		$rojo = $this->rojo_md->update( ["estatus"=>8,] , ["id_rojo"=>$values->id_rojo] );
		$cambio = [
			"id_usuario"	=>	$user["id_usuario"],
			"accion"		=>	8,
			"antes"			=>	$values->id_rojo,
			"despues"		=>	$values->nuevo
		];
		$rojo = $this->rojo_md->get(NULL,["id_rojo"=>$values->id_rojo])[0];
		$producto = $this->prod_md->update(["nombre"=>$values->nuevo],["codigo"=>$rojo->codigo]);
		$this->cambio_md->insert($cambio);
		$this->jsonResponse($cambio);
	}

	public function getAltas(){
		$rojos = $this->rojo_md->getAltas(NULL);
		$this->jsonResponse($rojos);
	}

	public function delRemove($valo){
		$this->rojo_md->update(["estatus"=>0],["id_rojo"=>$valo]);
		$this->jsonResponse("DONE B**CH");
	}

	public function excelA($valo){
		$rojos = $this->new_md->getRojo($valo);
		ini_set("memory_limit", "-1");
		ini_set("max_execution_time", "-1");
		$this->load->library("excelfile");
		$hoja = $this->excelfile->setActiveSheetIndex(0);
		$this->excelfile->setActiveSheetIndex(0)->setTitle("AJUSTES");
        $this->excelfile->setActiveSheetIndex(0);

		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);
		$styleArray2 = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_MEDIUM
		    )
		  )
		);
		$styleArrayNone = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN,
		      'color' => array('rgb' => 'FFFFFF')
		    )
		  )
		);
		$rws = 2;

		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;

		
		
		$lin = "";
		//$this->jsonResponse($rojos);
		$this->cellStyle('A1', "FFFFFF", "000000", FALSE, 31, "Arial Narrow");
		$this->excelfile->getActiveSheet()->getStyle('A1:CC1')->applyFromArray($styleArrayNone);
		if ($rojos){
			foreach ($rojos as $key => $value) {
				$hoja->mergeCells('A'.$rws.':D'.$rws);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':W'.$rws)->applyFromArray($styleArray2);
				$this->cellStyle('A'.$rws, "E26505", "000000", TRUE, 48, "Arial Narrow");
				$hoja->setCellValue("A{$rws}", "GEN SUCA21-0".$value["id_nuevo"]);
				$hoja->mergeCells('E'.$rws.':K'.$rws);
				$this->cellStyle('E'.$rws.':K'.$rws, "FFFFFF", "000000", TRUE, 36, "Arial Narrow");
				$hoja->setCellValue("E{$rws}", $fecha);
				$hoja->mergeCells('L'.$rws.':W'.$rws);
				$this->cellStyle('L'.$rws.':W'.$rws, "DF9406", "000000", FALSE, 48, "Arial Narrow");
				$hoja->setCellValue("L{$rws}", "ALTAS Y AJUSTES");
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':W'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':W'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$rws++;
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':W'.$rws)->applyFromArray($styleArray2);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':W'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':W'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->cellStyle('A'.$rws, "FFFFFF", "000000", FALSE, 24, "Arial Narrow");
				$hoja->setCellValue("A{$rws}", "CÓDIGO PRINCIPAL")->getColumnDimension('A')->setWidth(55);
				$this->cellStyle('B'.$rws, "FFFFFF", "000000", FALSE, 26, "Arial Narrow");
				$hoja->setCellValue("B{$rws}", "RENGLON 18")->getColumnDimension('B')->setWidth(55);
				$this->cellStyle('C'.$rws, "FFFFFF", "000000", TRUE, 24, "Arial Narrow");
				$hoja->setCellValue("C{$rws}", "LIN")->getColumnDimension('C')->setWidth(14);
				$this->cellStyle('D'.$rws, "FFFFFF", "000000", FALSE, 24, "Arial Narrow");
				$hoja->setCellValue("D{$rws}", "DESCRIPCIÓN")->getColumnDimension('D')->setWidth(95);
				$this->cellStyle('E'.$rws, "FFFFFF", "000000", FALSE, 22, "Arial Narrow");
				$hoja->setCellValue("E{$rws}", "UM")->getColumnDimension('E')->setWidth(14);
				$this->cellStyle('F'.$rws, "FFFFFF", "000000", FALSE, 28, "Arial Narrow");
				$hoja->setCellValue("F{$rws}", "C")->getColumnDimension('F')->setWidth(14);
				$this->cellStyle('G'.$rws, "FFFFFF", "000000", FALSE, 28, "Arial Narrow");
				$hoja->setCellValue("G{$rws}", "PAQUETE")->getColumnDimension('G')->setWidth(36);
				$this->cellStyle('H'.$rws, "FFCC66", "000000", TRUE, 28, "Arial Narrow");
				$hoja->setCellValue("H{$rws}", "IVA")->getColumnDimension('H')->setWidth(14);
				$this->cellStyle('I'.$rws, "FFA887", "000000", TRUE, 32, "Arial Narrow");
				$hoja->setCellValue("I{$rws}", "Renglon 10")->getColumnDimension('I')->setWidth(50);

				$hoja->mergeCells('J'.$rws.':N'.$rws);
				$this->cellStyle('J'.$rws, "FFFFFF", "000000", FALSE, 29, "Arial Narrow");
				$hoja->setCellValue("J{$rws}", "PRECIOS DEL 1 AL 5")->getColumnDimension('J')->setWidth(30);
				$hoja->setCellValue("K{$rws}", "")->getColumnDimension('K')->setWidth(30);
				$hoja->setCellValue("L{$rws}", "")->getColumnDimension('L')->setWidth(30);
				$hoja->setCellValue("M{$rws}", "")->getColumnDimension('M')->setWidth(30);
				$hoja->setCellValue("N{$rws}", "")->getColumnDimension('N')->setWidth(30);

				$this->cellStyle('O'.$rws, "FFFFFF", "000000", FALSE, 24, "Arial Narrow");
				$hoja->setCellValue("O{$rws}", "CÓDIGO PRINC CJA")->getColumnDimension('O')->setWidth(55);
				$this->cellStyle('P'.$rws, "FFFFFF", "000000", FALSE, 26, "Arial Narrow");
				$hoja->setCellValue("P{$rws}", "LIN")->getColumnDimension('P')->setWidth(14);
				$this->cellStyle('Q'.$rws, "FFFFFF", "000000", FALSE, 24, "Arial Narrow");
				$hoja->setCellValue("Q{$rws}", "DESCRIPCIÓN")->getColumnDimension('Q')->setWidth(95);
				$this->cellStyle('R'.$rws, "FFFFFF", "000000", FALSE, 22, "Arial Narrow");
				$hoja->setCellValue("R{$rws}", "UM")->getColumnDimension('R')->setWidth(14);

				$hoja->mergeCells('S'.$rws.':W'.$rws);
				$this->cellStyle('S'.$rws, "FFFFFF", "000000", FALSE, 31, "Arial Narrow");
				$hoja->setCellValue("S{$rws}", "PRECIOS DEL 1 AL 5")->getColumnDimension('S')->setWidth(30);
				$hoja->setCellValue("T{$rws}", "")->getColumnDimension('T')->setWidth(30);
				$hoja->setCellValue("U{$rws}", "")->getColumnDimension('U')->setWidth(30);
				$hoja->setCellValue("V{$rws}", "")->getColumnDimension('V')->setWidth(30);
				$hoja->setCellValue("W{$rws}", "")->getColumnDimension('W')->setWidth(30);
				$rws++;

				foreach ($value["detalles"] as $key => $val) {
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':W'.$rws)->applyFromArray($styleArray);
					$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':N'.$rws)->getAlignment()->setIndent(1);
					$this->excelfile->getActiveSheet()->getStyle('S'.$rws.':W'.$rws)->getAlignment()->setIndent(1);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':W'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);

					$this->cellStyle('A'.$rws.':W'.$rws, "FFFFFF", "000000", FALSE, 28, "Arial Narrow");
					$hoja->setCellValue("A{$rws}", $val["code1"])->getStyle('A'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
					$hoja->setCellValue("B{$rws}", $val["code2"])->getStyle('B'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
					$this->cellStyle('C'.$rws, "FFFFFF", "000000", TRUE, 24, "Arial Narrow");
					$hoja->setCellValue("C{$rws}", $val["linea"]);
					$this->cellStyle('D'.$rws, "FFFFFF", "000000", FALSE, 24, "Arial Narrow");
					$hoja->setCellValue("D{$rws}", $val["desc1"]);
					$this->cellStyle('E'.$rws, "FFFFFF", "000000", FALSE, 22, "Arial Narrow");
					$hoja->setCellValue("E{$rws}", $val["unidad"]);
					$hoja->setCellValue("F{$rws}", $val["cantidad"]);
					$hoja->setCellValue("G{$rws}", $val["costo"])->getStyle("G{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$this->cellStyle('H'.$rws, "FFCC66", "000000", TRUE, 28, "Arial Narrow");
					$hoja->setCellValue("H{$rws}", $val["iva"]);
					$this->cellStyle('I'.$rws, "FFA887", "000000", TRUE, 32, "Arial Narrow");
					$hoja->setCellValue("I{$rws}", "=(G{$rws}/F{$rws})/(1+(H{$rws}/100))")->getStyle("I{$rws}")->getNumberFormat()->setFormatCode('#,##0.0000_-');
					$this->cellStyle('J'.$rws.':M'.$rws, "FFFFFF", "000000", FALSE, 31, "Arial Narrow");
					$hoja->setCellValue("J{$rws}", $val["pre11"])->getStyle("J{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("K{$rws}", $val["pre22"])->getStyle("K{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("L{$rws}", $val["pre33"])->getStyle("L{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("M{$rws}", $val["pre44"])->getStyle("M{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$this->cellStyle('N'.$rws, "CC99FF", "000000", FALSE, 31, "Arial Narrow");
					$hoja->setCellValue("N{$rws}", "=+(G{$rws}/F{$rws})+0.01")->getStyle("N{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("O{$rws}", $val["code3"])->getStyle('O'.$rws)->getNumberFormat()->setFormatCode('# ???/???');

					$this->cellStyle('P'.$rws, "FFFFFF", "000000", TRUE, 24, "Arial Narrow");
					$hoja->setCellValue("P{$rws}", $val["linea"]);
					$this->cellStyle('Q'.$rws, "FFFFFF", "000000", FALSE, 24, "Arial Narrow");
					$hoja->setCellValue("Q{$rws}", $val["desc2"]);
					$this->cellStyle('R'.$rws, "FFFFFF", "000000", FALSE, 22, "Arial Narrow");
					$hoja->setCellValue("R{$rws}", $val["unidad"]);

					$this->cellStyle('S'.$rws.':W'.$rws, "FFFFFF", "000000", FALSE, 31, "Arial Narrow");
					$hoja->setCellValue("S{$rws}", $val["pre1"])->getStyle("S{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("T{$rws}", $val["pre2"])->getStyle("T{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("U{$rws}", $val["pre3"])->getStyle("U{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("V{$rws}", $val["pre4"])->getStyle("V{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$this->cellStyle('W'.$rws, "CC99FF", "000000", FALSE, 31, "Arial Narrow");
					$hoja->setCellValue("W{$rws}", "=G{$rws}+0.01")->getStyle("W{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$this->cellStyle('W'.$rws.':CC'.$rws, "FFFFFF", "000000", FALSE, 31, "Arial Narrow");


					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':W'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':B'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excelfile->getActiveSheet()->getStyle('O'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excelfile->getActiveSheet()->getStyle('G'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':N'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$this->excelfile->getActiveSheet()->getStyle('S'.$rws.':W'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$this->excelfile->getActiveSheet()->getStyle('D'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$this->excelfile->getActiveSheet()->getStyle('Q'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

					$rws++;
				}
			}
		}
		$this->cellStyle('A'.$rws.':CC'.($rws+150), "FFFFFF", "000000", FALSE, 31, "Arial Narrow");
		$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':CC'.($rws+150))->applyFromArray($styleArrayNone);

		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$file_name = "CAMBIOS SUC A ".$fecha.".xlsx"; //Nombre del documento con extención
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment;filename=".$file_name);
		header("Cache-Control: max-age=0");
		$excel_Writer = PHPExcel_IOFactory::createWriter($this->excelfile, "Excel2007");
		$excel_Writer->save("php://output");
	}

	public function excelB($valo){
		$rojos = $this->new_md->getRojoB($valo);
		ini_set("memory_limit", "-1");
		ini_set("max_execution_time", "-1");
		$this->load->library("excelfile");
		$hoja = $this->excelfile->setActiveSheetIndex(0);
		$this->excelfile->setActiveSheetIndex(0)->setTitle("AJUSTES");
        $this->excelfile->setActiveSheetIndex(0);

		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);
		$styleArray2 = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_MEDIUM
		    )
		  )
		);
		$styleArrayNone = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN,
		      'color' => array('rgb' => 'FFFFFF')
		    )
		  )
		);
		$rws = 2;

		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;

		
		
		$lin = "";
		//$this->jsonResponse($rojos);
		$this->cellStyle('A1', "FFFFFF", "000000", FALSE, 31, "Arial Narrow");
		$this->excelfile->getActiveSheet()->getStyle('A1:CC1')->applyFromArray($styleArrayNone);
		if ($rojos){
			foreach ($rojos as $key => $value) {
				$hoja->mergeCells('A'.$rws.':D'.$rws);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->applyFromArray($styleArray2);
				$this->cellStyle('A'.$rws, "00B0F0", "000000", TRUE, 48, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("A{$rws}", "GEN SUCB21-0".$value["id_nuevo"]);
				$hoja->mergeCells('E'.$rws.':T'.$rws);
				$this->cellStyle('E'.$rws.':T'.$rws, "FBBDFB", "000000", TRUE, 36, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("E{$rws}", $fecha);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$rws++;
				$hoja->mergeCells('A'.$rws.':L'.$rws);
				$hoja->mergeCells('M'.$rws.':T'.$rws);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->applyFromArray($styleArray2);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->cellStyle('A'.$rws, "D9FFF2", "000000", FALSE, 24, "Bahnschrift Light SemiCondensed");
				$this->cellStyle('M'.$rws, "FCE4D6", "000000", FALSE, 24, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("M{$rws}", "PAQUETES");
				$rws++;

				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->applyFromArray($styleArray2);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->cellStyle('A'.$rws, "FFFFFF", "000000", FALSE, 24, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("A{$rws}", "CÓDIGO PRINCIPAL")->getColumnDimension('A')->setWidth(55);
				$this->cellStyle('B'.$rws, "FFFFFF", "000000", FALSE, 26, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("B{$rws}", "RENGLON 18")->getColumnDimension('B')->setWidth(55);
				$this->cellStyle('C'.$rws, "FFFFFF", "000000", TRUE, 24, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("C{$rws}", "LIN")->getColumnDimension('C')->setWidth(14);
				$this->cellStyle('D'.$rws, "FFFFFF", "000000", FALSE, 24, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("D{$rws}", "DESCRIPCIÓN")->getColumnDimension('D')->setWidth(95);
				$this->cellStyle('E'.$rws, "FFFFFF", "000000", FALSE, 22, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("E{$rws}", "UM")->getColumnDimension('E')->setWidth(14);
				$this->cellStyle('F'.$rws, "FFFFFF", "000000", FALSE, 28, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("F{$rws}", "C")->getColumnDimension('F')->setWidth(14);

				$this->cellStyle('G'.$rws, "00B0F0", "000000", FALSE, 28, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("G{$rws}", "IVA")->getColumnDimension('G')->setWidth(14);
				$this->cellStyle('H'.$rws, "FFA887", "000000", TRUE, 32, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("H{$rws}", "COSTO PZ")->getColumnDimension('H')->setWidth(50);
				$this->cellStyle('I'.$rws, "C6D6B4", "000000", TRUE, 32, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("I{$rws}", "RENGLON 10")->getColumnDimension('I')->setWidth(50);

				$this->cellStyle('J'.$rws, "BDD7EE", "000000", FALSE, 29, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("J{$rws}", "PREC 1")->getColumnDimension('J')->setWidth(30);
				$this->cellStyle('K'.$rws, "BDD7EE", "000000", FALSE, 29, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("K{$rws}", "PREC 2")->getColumnDimension('K')->setWidth(30);
				$this->cellStyle('L'.$rws, "BDD7EE", "000000", FALSE, 29, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("L{$rws}", "PREC 3")->getColumnDimension('L')->setWidth(30);

				$this->cellStyle('M'.$rws, "FFFFFF", "000000", FALSE, 24, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("M{$rws}", "CÓDIGO PRINC CJA")->getColumnDimension('M')->setWidth(55);
				$this->cellStyle('N'.$rws, "FFFFFF", "000000", FALSE, 26, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("N{$rws}", "LIN")->getColumnDimension('N')->setWidth(14);
				$this->cellStyle('O'.$rws, "FFFFFF", "000000", FALSE, 24, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("O{$rws}", "DESCRIPCIÓN")->getColumnDimension('O')->setWidth(95);
				$this->cellStyle('P'.$rws, "FFFFFF", "000000", FALSE, 22, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("P{$rws}", "UM")->getColumnDimension('P')->setWidth(14);


				$this->cellStyle('Q'.$rws, "FFFF00", "000000", FALSE, 31, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("Q{$rws}", "COSTO CJA")->getColumnDimension('Q')->setWidth(30);
				$this->cellStyle('R'.$rws, "BDD7EE", "000000", FALSE, 31, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("R{$rws}", "PREC 1")->getColumnDimension('R')->setWidth(30);
				$this->cellStyle('S'.$rws, "BDD7EE", "000000", FALSE, 31, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("S{$rws}", "PREC 2")->getColumnDimension('S')->setWidth(30);
				$this->cellStyle('T'.$rws, "BDD7EE", "000000", FALSE, 31, "Bahnschrift Light SemiCondensed");
				$hoja->setCellValue("T{$rws}", "PREC 3")->getColumnDimension('T')->setWidth(30);
				
				$rws++;

				foreach ($value["detalles"] as $key => $val) {
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->applyFromArray($styleArray);
					$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':L'.$rws)->getAlignment()->setIndent(1);
					$this->excelfile->getActiveSheet()->getStyle('R'.$rws.':T'.$rws)->getAlignment()->setIndent(1);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);

					$this->cellStyle('A'.$rws.':T'.$rws, "FFFFFF", "000000", FALSE, 28, "Bahnschrift Light SemiCondensed");
					$hoja->setCellValue("A{$rws}", $val["code1"])->getStyle('A'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
					$hoja->setCellValue("B{$rws}", $val["code2"])->getStyle('B'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
					$this->cellStyle('C'.$rws, "FFFFFF", "000000", TRUE, 24, "Bahnschrift Light SemiCondensed");
					$hoja->setCellValue("C{$rws}", $val["linea"]);
					$this->cellStyle('D'.$rws, "FFFFFF", "000000", FALSE, 24, "Bahnschrift Light SemiCondensed");
					$hoja->setCellValue("D{$rws}", $val["desc1"]);
					$this->cellStyle('E'.$rws, "FFFFFF", "000000", FALSE, 22, "Arial Narrow");
					$hoja->setCellValue("E{$rws}", $val["unidad"]);
					$this->cellStyle('E'.$rws, "FFFFFF", "000000", FALSE, 28, "Arial Narrow");
					$hoja->setCellValue("F{$rws}", $val["cantidad"]);
				
					$this->cellStyle('G'.$rws, "FFFFFF", "000000", TRUE, 28, "Arial Narrow");
					$hoja->setCellValue("G{$rws}", $val["iva"]);
					$this->cellStyle('H'.$rws, "FFFFFF", "000000", TRUE, 32, "Bahnschrift Light SemiCondensed");
					$hoja->setCellValue("H{$rws}", "=Q{$rws}/F{$rws}")->getStyle("H{$rws}")->getNumberFormat()->setFormatCode('#,##0.0000_-');
					$this->cellStyle('I'.$rws, "C6D6B4", "000000", TRUE, 32, "Arial");
					$hoja->setCellValue("I{$rws}", "=IF(Q{$rws}>0,(Q{$rws}/F{$rws})/(1+(G{$rws}/100)),((H{$rws})/(1+((G{$rws}/100)))))")->getStyle("I{$rws}")->getNumberFormat()->setFormatCode('#,##0.0000_-');

					$this->cellStyle('J'.$rws.':L'.$rws, "BDD7EE", "000000", FALSE, 31, "Bahnschrift Light SemiCondensed");
					$hoja->setCellValue("J{$rws}", $val["pre11"])->getStyle("J{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("K{$rws}", $val["pre22"])->getStyle("K{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("L{$rws}", $val["pre33"])->getStyle("L{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');

					$hoja->setCellValue("M{$rws}", $val["code3"])->getStyle('M'.$rws)->getNumberFormat()->setFormatCode('# ???/???');

					$this->cellStyle('N'.$rws, "FFFFFF", "000000", TRUE, 24, "Bahnschrift Light SemiCondensed");
					$hoja->setCellValue("N{$rws}", $val["linea"]);
					$this->cellStyle('O'.$rws, "FFFFFF", "000000", FALSE, 24, "Bahnschrift Light SemiCondensed");
					$hoja->setCellValue("O{$rws}", $val["desc2"]);
					$this->cellStyle('P'.$rws, "FFFFFF", "000000", FALSE, 22, "Bahnschrift Light SemiCondensed");
					$hoja->setCellValue("P{$rws}", $val["unidad"]);
					$hoja->setCellValue("Q{$rws}", $val["costo"])->getStyle("Q{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');

					$this->cellStyle('R'.$rws.':T'.$rws, "BDD7EE", "000000", FALSE, 31, "Bahnschrift Light SemiCondensed");
					$hoja->setCellValue("R{$rws}", $val["pre1"])->getStyle("R{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("S{$rws}", $val["pre2"])->getStyle("S{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					$hoja->setCellValue("T{$rws}", $val["pre3"])->getStyle("T{$rws}")->getNumberFormat()->setFormatCode('#,##0.00_-');
					

					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':T'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':B'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excelfile->getActiveSheet()->getStyle('M'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excelfile->getActiveSheet()->getStyle('Q'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

					$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':L'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$this->excelfile->getActiveSheet()->getStyle('R'.$rws.':T'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$this->excelfile->getActiveSheet()->getStyle('D'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$this->excelfile->getActiveSheet()->getStyle('O'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

					$rws++;
				}
			}
		}
		$this->cellStyle('A'.$rws.':CC'.($rws+150), "FFFFFF", "000000", FALSE, 31, "Bahnschrift Light SemiCondensed");
		$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':CC'.($rws+150))->applyFromArray($styleArrayNone);

		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$file_name = "CAMBIOS SUCB ".$fecha.".xlsx"; //Nombre del documento con extención
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment;filename=".$file_name);
		header("Cache-Control: max-age=0");
		$excel_Writer = PHPExcel_IOFactory::createWriter($this->excelfile, "Excel2007");
		$excel_Writer->save("php://output");
	}

	public function detalleRemove($detalle){
		$this->det_md->update(["estatusb"=>0],["id_detail"=>$detalle]);
		$this->jsonResponse("Done");
	}

	public function saveDetalle(){
		$value = json_decode($this->input->post("value"));
		$user = $this->session->userdata();
		$nuevo = $this->new_md->update(["sucb"=>1],["id_nuevo"=>$value->id_nuevo]);

		$new_nuevo = [
			"detalle"	=> $value->id_rojo,
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
			"mar1"		=> $value->bmar1,
			"mar2"		=> $value->bmar2,
			"mar3"		=> $value->bmar3,
			"mar11"		=> $value->bmar11,
			"mar22"		=> $value->bmar22,
			"mar33"		=> $value->bmar33,
			"pre1"		=> $value->bpre1,
			"pre2"		=> $value->bpre2,
			"pre3"		=> $value->bpre3,
			"pre11"		=> $value->bpre11,
			"pre22"		=> $value->bpre22,
			"pre33"		=> $value->bpre33,
			"costopz"	=> $value->costopz,
			"matriz"	=> $value->matriz,
			"estatus"	=> $value->estatus,
			"id_nuevo"	=> $value->id_nuevo
		];
		$this->newb_md->update(["estatus"=>0],["id_nuevo"=>$value->id_nuevo,"detalle"=> $value->id_rojo]);
		$nuevob = $this->newb_md->insert($new_nuevo);
		
		$this->jsonResponse($new_nuevo);
	}

	public function rojosCalc($vero){
		if ($vero == 1 || $vero == "1") {
			$rojos = $this->rojo_md->getRojos3();
		}else{
			$rojos = $this->rojo_md->getRojos2();
		}
		ini_set("memory_limit", "-1");
		ini_set("max_execution_time", "-1");
		$this->load->library("excelfile");
		$hoja = $this->excelfile->setActiveSheetIndex(0);
		$this->excelfile->setActiveSheetIndex(0)->setTitle("AJUSTES");
        $this->excelfile->setActiveSheetIndex(0);
        $this->excelfile->createSheet();
        $hoja1 = $this->excelfile->setActiveSheetIndex(1)->setTitle("SUC B");
        $this->excelfile->setActiveSheetIndex(0);
		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  )
		);
		$styleArray2 = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_MEDIUM
		    )
		  )
		);
		$styleArrayNone = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN,
		      'color' => array('rgb' => 'FFFFFF')
		    )
		  )
		);
		$rws = 2;

		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;

		
		
		$lin = "";
		//$this->jsonResponse($rojos);
		$this->cellStyle('A1', "FFFFFF", "000000", FALSE, 31, "Arial Narrow");
		$this->excelfile->getActiveSheet()->getStyle('A1:AF1')->applyFromArray($styleArrayNone);
		if ($rojos){
			if (1==1) { //SUCURSALES A
				$hoja->mergeCells('A'.$rws.':D'.$rws);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->applyFromArray($styleArray2);
				$this->cellStyle('A'.$rws, "E26505", "000000", TRUE, 36, "Arial Narrow");
				$hoja->setCellValue("A{$rws}", "NUEVOS PRECIOS");
				$hoja->mergeCells('E'.$rws.':K'.$rws);
				$this->cellStyle('E'.$rws.':K'.$rws, "FFFFFF", "000000", TRUE, 24, "Arial Narrow");
				$hoja->setCellValue("E{$rws}", $fecha);
				$hoja->mergeCells('L'.$rws.':AF'.$rws);
				$this->cellStyle('L'.$rws.':AF'.$rws, "DF9406", "000000", FALSE, 36, "Arial Narrow");
				$hoja->setCellValue("L{$rws}", "ALTAS Y AJUSTES");
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$rws++;
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->applyFromArray($styleArray2);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(40);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->cellStyle('A'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
				$hoja->setCellValue("A{$rws}", "CÓDIGO PRINCIPAL")->getColumnDimension('A')->setWidth(35);
				$this->cellStyle('B'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
				$hoja->setCellValue("B{$rws}", "RENGLON 18")->getColumnDimension('B')->setWidth(35);
				$this->cellStyle('C'.$rws, "FFFFFF", "000000", TRUE, 16, "Arial Narrow");
				$hoja->setCellValue("C{$rws}", "LIN")->getColumnDimension('C')->setWidth(8);
				$this->cellStyle('D'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
				$hoja->setCellValue("D{$rws}", "DESCRIPCIÓN")->getColumnDimension('D')->setWidth(65);
				$this->cellStyle('E'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
				$hoja->setCellValue("E{$rws}", "UM")->getColumnDimension('E')->setWidth(8);
				$this->cellStyle('F'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
				$hoja->setCellValue("F{$rws}", "C")->getColumnDimension('F')->setWidth(8);
				$this->cellStyle('G'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
				$hoja->setCellValue("G{$rws}", "PAQUETE")->getColumnDimension('G')->setWidth(15);
				$this->cellStyle('H'.$rws, "FFCC66", "000000", TRUE, 18, "Arial Narrow");
				$hoja->setCellValue("H{$rws}", "IVA")->getColumnDimension('H')->setWidth(8);
				$this->cellStyle('I'.$rws, "FFA887", "000000", TRUE, 18, "Arial Narrow");
				$hoja->setCellValue("I{$rws}", "Renglon 10")->getColumnDimension('I')->setWidth(25);

				$hoja->mergeCells('J'.$rws.':N'.$rws);
				$this->cellStyle('J'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
				$hoja->setCellValue("J{$rws}", "PRECIOS DEL 1 AL 5")->getColumnDimension('J')->setWidth(15);
				$hoja->setCellValue("K{$rws}", "")->getColumnDimension('K')->setWidth(15);
				$hoja->setCellValue("L{$rws}", "")->getColumnDimension('L')->setWidth(15);
				$hoja->setCellValue("M{$rws}", "")->getColumnDimension('M')->setWidth(15);
				$hoja->setCellValue("N{$rws}", "")->getColumnDimension('N')->setWidth(15);

				$hoja->mergeCells('O'.$rws.':R'.$rws);
				$this->cellStyle('O'.$rws, "DAEEF3", "000000", TRUE, 18, "Arial Narrow");
				$hoja->setCellValue("O{$rws}", "MARGENES")->getColumnDimension('O')->setWidth(10);
				$hoja->setCellValue("P{$rws}", "")->getColumnDimension('P')->setWidth(10);
				$hoja->setCellValue("Q{$rws}", "")->getColumnDimension('Q')->setWidth(10);
				$hoja->setCellValue("R{$rws}", "")->getColumnDimension('R')->setWidth(10);

				$this->cellStyle('AC'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
				$hoja->setCellValue("AC{$rws}", "CÓDIGO PRINC CJA")->getColumnDimension('AC')->setWidth(35);
				$this->cellStyle('AD'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
				$hoja->setCellValue("AD{$rws}", "LIN")->getColumnDimension('AD')->setWidth(8);
				$this->cellStyle('AE'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
				$hoja->setCellValue("AE{$rws}", "DESCRIPCIÓN")->getColumnDimension('AE')->setWidth(65);
				$this->cellStyle('AF'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
				$hoja->setCellValue("AF{$rws}", "UM")->getColumnDimension('AF')->setWidth(8);

				$hoja->mergeCells('S'.$rws.':W'.$rws);
				$this->cellStyle('S'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
				$hoja->setCellValue("S{$rws}", "PRECIOS DEL 1 AL 5")->getColumnDimension('S')->setWidth(15);
				$hoja->setCellValue("T{$rws}", "")->getColumnDimension('T')->setWidth(15);
				$hoja->setCellValue("U{$rws}", "")->getColumnDimension('U')->setWidth(15);
				$hoja->setCellValue("V{$rws}", "")->getColumnDimension('V')->setWidth(15);
				$hoja->setCellValue("W{$rws}", "")->getColumnDimension('W')->setWidth(15);

				$hoja->mergeCells('X'.$rws.':AA'.$rws);
				$this->cellStyle('X'.$rws, "DAEEF3", "000000", TRUE, 18, "Arial Narrow");
				$hoja->setCellValue("X{$rws}", "MARGENES")->getColumnDimension('X')->setWidth(10);
				$hoja->setCellValue("Y{$rws}", "")->getColumnDimension('Y')->setWidth(10);
				$hoja->setCellValue("Z{$rws}", "")->getColumnDimension('Z')->setWidth(10);
				$hoja->setCellValue("AA{$rws}", "")->getColumnDimension('AA')->setWidth(10);

				$this->cellStyle('AB'.$rws, "8DB4E2", "000000", TRUE, 18, "Arial Narrow");
				$hoja->setCellValue("AB{$rws}", "PZ * CAJA")->getColumnDimension('AB')->setWidth(20);
			}
			

			$rws=1;
			$this->excelfile->setActiveSheetIndex(1);
			if(2==2){
				$hoja1->mergeCells('A'.$rws.':D'.$rws);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->applyFromArray($styleArray2);
				$this->cellStyle('A'.$rws, "00B0F0", "000000", TRUE, 24, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("A{$rws}", "SUCURSALES B");
				$hoja1->mergeCells('E'.$rws.':Z'.$rws);
				$this->cellStyle('E'.$rws.':Z'.$rws, "FBBDFB", "000000", TRUE, 24, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("E{$rws}", $fecha);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$rws++;
				$hoja1->mergeCells('A'.$rws.':O'.$rws);
				$hoja1->mergeCells('P'.$rws.':Z'.$rws);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->applyFromArray($styleArray2);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->cellStyle('A'.$rws, "D9FFF2", "000000", FALSE, 24, "Bahnschrift Light SemiCondensed");
				$this->cellStyle('P'.$rws, "FCE4D6", "000000", FALSE, 24, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("P{$rws}", "PAQUETES");
				$rws++;

				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->applyFromArray($styleArray2);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
				$this->cellStyle('A'.$rws, "FFFFFF", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("A{$rws}", "CÓDIGO PRINCIPAL")->getColumnDimension('A')->setWidth(34);
				$this->cellStyle('B'.$rws, "FFFFFF", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("B{$rws}", "RENGLON 18")->getColumnDimension('B')->setWidth(34);
				$this->cellStyle('C'.$rws, "FFFFFF", "000000", TRUE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("C{$rws}", "LIN")->getColumnDimension('C')->setWidth(8);
				$this->cellStyle('D'.$rws, "FFFFFF", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("D{$rws}", "DESCRIPCIÓN")->getColumnDimension('D')->setWidth(65);
				$this->cellStyle('E'.$rws, "FFFFFF", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("E{$rws}", "UM")->getColumnDimension('E')->setWidth(8);
				$this->cellStyle('F'.$rws, "FFFFFF", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("F{$rws}", "C")->getColumnDimension('F')->setWidth(8);

				$this->cellStyle('G'.$rws, "00B0F0", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("G{$rws}", "IVA")->getColumnDimension('G')->setWidth(8);
				$this->cellStyle('H'.$rws, "FFCC66", "000000", TRUE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("H{$rws}", "PAQUETE")->getColumnDimension('H')->setWidth(18);
				$this->cellStyle('I'.$rws, "C6D6B4", "000000", TRUE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("I{$rws}", "RENGLON 10")->getColumnDimension('I')->setWidth(18);

				$this->cellStyle('J'.$rws, "BDD7EE", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("J{$rws}", "PREC 1")->getColumnDimension('J')->setWidth(18);
				$this->cellStyle('K'.$rws, "BDD7EE", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("K{$rws}", "PREC 2")->getColumnDimension('K')->setWidth(18);
				$this->cellStyle('L'.$rws, "BDD7EE", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("L{$rws}", "PREC 3")->getColumnDimension('L')->setWidth(18);

				$this->cellStyle('M'.$rws.':O'.$rws, "FBBDFB", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->mergeCells('M'.$rws.':O'.$rws);
				$hoja1->setCellValue("M{$rws}", "MARGENES")->getColumnDimension('M')->setWidth(18);
				$hoja1->setCellValue("N{$rws}", "")->getColumnDimension('N')->setWidth(18);
				$hoja1->setCellValue("O{$rws}", "")->getColumnDimension('O')->setWidth(18);

				$this->cellStyle('W'.$rws, "FFFFFF", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("W{$rws}", "CÓDIGO PRINC CJA")->getColumnDimension('W')->setWidth(34);
				$this->cellStyle('X'.$rws, "FFFFFF", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("X{$rws}", "LIN")->getColumnDimension('X')->setWidth(8);
				$this->cellStyle('Y'.$rws, "FFFFFF", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("Y{$rws}", "DESCRIPCIÓN")->getColumnDimension('Y')->setWidth(65);
				$this->cellStyle('Z'.$rws, "FFFFFF", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("Z{$rws}", "UM")->getColumnDimension('Z')->setWidth(8);

				$this->cellStyle('P'.$rws, "BDD7EE", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("P{$rws}", "PREC 1")->getColumnDimension('P')->setWidth(18);
				$this->cellStyle('Q'.$rws, "BDD7EE", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");//fbbdfb
				$hoja1->setCellValue("Q{$rws}", "PREC 2")->getColumnDimension('Q')->setWidth(18);
				$this->cellStyle('R'.$rws, "BDD7EE", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->setCellValue("R{$rws}", "PREC 3")->getColumnDimension('R')->setWidth(18);

				$this->cellStyle('S'.$rws.':U'.$rws, "FBBDFB", "000000", FALSE, 18, "Bahnschrift Light SemiCondensed");
				$hoja1->mergeCells('S'.$rws.':U'.$rws);
				$hoja1->setCellValue("S{$rws}", "MARGENES")->getColumnDimension('S')->setWidth(18);
				$hoja1->setCellValue("T{$rws}", "")->getColumnDimension('T')->setWidth(18);
				$hoja1->setCellValue("U{$rws}", "")->getColumnDimension('U')->setWidth(18);
				$this->cellStyle('V'.$rws, "8DB4E2", "000000", TRUE, 18, "Arial Narrow");
				$hoja1->setCellValue("V{$rws}", "PZ * CAJA")->getColumnDimension('V')->setWidth(20);
			}
			$this->excelfile->setActiveSheetIndex(0);
			$rws++;
			foreach ($rojos as $key => $value) {
				if( 1 == 1){
					$this->cellStyle('A'.$rws.':AF'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
					$hoja->setCellValue("A{$rws}", $value["code1"])->getStyle('A'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
					$hoja->setCellValue("B{$rws}", $value["code2"])->getStyle('B'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
					$this->cellStyle('C'.$rws, "FFFFFF", "000000", TRUE, 16, "Arial Narrow");
					$hoja->setCellValue("C{$rws}", $value["ides"]);
					$this->cellStyle('D'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
					$hoja->setCellValue("D{$rws}", $value["descripcion"]);
					$this->cellStyle('E'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
					$hoja->setCellValue("E{$rws}", $value["uni"]);
					$hoja->setCellValue("F{$rws}", 1);//$value["cantidad"]
					if ($value["estatus"] == 5){
						$hoja->setCellValue("G{$rws}", ($value["preciocinco"] - 0.01))->getStyle("G{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					}else{
						$hoja->setCellValue("G{$rws}", $value["costo"])->getStyle("G{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					}

					

					$this->cellStyle('H'.$rws, "FFCC66", "000000", TRUE, 18, "Arial Narrow");
					$hoja->setCellValue("H{$rws}", $value["iva"]);
					$this->cellStyle('I'.$rws, "FFA887", "000000", TRUE, 18, "Arial Narrow");
					$hoja->setCellValue("I{$rws}", "=(G{$rws}/F{$rws})/(1+(H{$rws}/100))")->getStyle("I{$rws}")->getNumberFormat()->setFormatCode('#,##0.0000_-');
					$this->cellStyle('J'.$rws.':M'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");

					$mar1 = round( ( ($value["preciouno"]*100)/($value["preciocinco"]-0.01) )-100 );
				    $mar2 = round( ( ($value["preciodos"]*100)/($value["preciocinco"]-0.01) )-100 );
				    $mar3 = round( ( ($value["preciotres"]*100)/($value["preciocinco"]-0.01) )-100 );
				    $mar4 = round( ( ($value["preciocuatro"]*100)/($value["preciocinco"]-0.01) )-100 );

				    $this->cellStyle('O'.$rws.":R".$rws, "DAEEF3", "000000", FALSE, 18, "Arial Narrow");
				    $this->cellStyle('X'.$rws.":AA".$rws, "DAEEF3", "000000", FALSE, 18, "Arial Narrow");

				    $hoja->setCellValue("O{$rws}", $mar1);
					$hoja->setCellValue("P{$rws}", $mar2);
					$hoja->setCellValue("Q{$rws}", $mar3);
					$hoja->setCellValue("R{$rws}", $mar4);

					$hoja->setCellValue("J{$rws}", "=ROUND((G{$rws}/F{$rws})+((O{$rws}*(G{$rws}/F{$rws}))/100),1)")->getStyle("J{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					$hoja->setCellValue("K{$rws}", "=ROUND((G{$rws}/F{$rws})+((P{$rws}*(G{$rws}/F{$rws}))/100),1)")->getStyle("K{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					$hoja->setCellValue("L{$rws}", "=ROUND((G{$rws}/F{$rws})+((Q{$rws}*(G{$rws}/F{$rws}))/100),1)")->getStyle("L{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					$hoja->setCellValue("M{$rws}", "=ROUND((G{$rws}/F{$rws})+((R{$rws}*(G{$rws}/F{$rws}))/100),1)")->getStyle("M{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					$this->cellStyle('N'.$rws, "CC99FF", "000000", FALSE, 18, "Arial Narrow");
					$hoja->setCellValue("N{$rws}", "=+(G{$rws}/F{$rws})+0.01")->getStyle("N{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

					$hoja->setCellValue("AB{$rws}", "=N{$rws}*F{$rws}")->getStyle("AB{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					$this->cellStyle('AB'.$rws, "8DB4E2", "000000", TRUE, 18, "Arial Narrow");
					if ($value["estatus"] == 5){
						$this->cellStyle('A'.$rws.':D'.$rws, "FFFF00", "000000", FALSE, 16, "Arial Narrow");
					}elseif($value["estatus"] == 4){
						$this->cellStyle('A'.$rws.':D'.$rws, "92D050", "000000", FALSE, 16, "Arial Narrow");
						$this->cellStyle('C'.$rws, "92D050", "000000", TRUE, 16, "Arial Narrow");
						$hoja->setCellValue("A{$rws}", $value["codigo"]);
						$hoja->setCellValue("B{$rws}", $value["codigo"]);
						$hoja->setCellValue("D{$rws}", $value["rdes"]);
						$hoja->setCellValue("F{$rws}", $value["um_nuevo"]);
						$hoja->setCellValue("C{$rws}", $value["ides2"]);
						$hoja->setCellValue("H{$rws}", $value["iva2"]);
						
						$mar1 = round( ( ($value["p1"]*100)/($value["p5"]-0.01) )-100 );
					    $mar2 = round( ( ($value["p2"]*100)/($value["p5"]-0.01) )-100 );
					    $mar3 = round( ( ($value["p3"]*100)/($value["p5"]-0.01) )-100 );
					    $mar4 = round( ( ($value["p4"]*100)/($value["p5"]-0.01) )-100 );
						$hoja->setCellValue("O{$rws}", $mar1);
						$hoja->setCellValue("P{$rws}", $mar2);
						$hoja->setCellValue("Q{$rws}", $mar3);
						$hoja->setCellValue("R{$rws}", $mar4);

						if (is_numeric($value["um_nuevo"])){
							if (intval($value["um_nuevo"]) > 1) {
								$hoja->setCellValue("X{$rws}", 0);
								$hoja->setCellValue("Y{$rws}", 0);
								$hoja->setCellValue("Z{$rws}", 0);
								$hoja->setCellValue("AA{$rws}", 0);
								$hoja->setCellValue("AD{$rws}", $value["ides2"]);
								$hoja->setCellValue("S{$rws}", "=ROUND(G{$rws}+((X{$rws}*G{$rws})/100),1)")->getStyle("S{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
								$hoja->setCellValue("T{$rws}", "=ROUND(G{$rws}+((Y{$rws}*G{$rws})/100),1)")->getStyle("T{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
								$hoja->setCellValue("U{$rws}", "=ROUND(G{$rws}+((Z{$rws}*G{$rws})/100),1)")->getStyle("U{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
								$hoja->setCellValue("V{$rws}", "=ROUND(G{$rws}+((AA{$rws}*G{$rws})/100),1)")->getStyle("V{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
								$this->cellStyle('W'.$rws, "CC99FF", "000000", FALSE, 18, "Arial Narrow");
								$this->cellStyle('S'.$rws.":V".$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
								$hoja->setCellValue("W{$rws}", "=G{$rws}+0.01")->getStyle("W{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

								$hoja->setCellValue("X{$rws}", $mar1);
								$hoja->setCellValue("Y{$rws}", $mar2);
								$hoja->setCellValue("Z{$rws}", $mar3);
								$hoja->setCellValue("AA{$rws}", $mar4);

								$this->excelfile->setActiveSheetIndex(1);
								$this->cellStyle('P'.$rws.':R'.$rws, "BDD7EE", "000000", FALSE, 18, "Arial Narrow");
								$hoja1->setCellValue("P{$rws}", "=ROUND(H{$rws}+((S{$rws}*H{$rws})/100),1)")->getStyle("P{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
								$hoja1->setCellValue("Q{$rws}", "=ROUND(H{$rws}+((T{$rws}*H{$rws})/100),1)")->getStyle("Q{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
								$hoja1->setCellValue("R{$rws}", "=ROUND(H{$rws}+((U{$rws}*H{$rws})/100),1)")->getStyle("R{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
								$this->excelfile->setActiveSheetIndex(0);
							}
						}else{
							$hoja->setCellValue("F{$rws}", 1);
						}
							
					}
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->applyFromArray($styleArray);
					$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':N'.$rws)->getAlignment()->setIndent(1);
					$this->excelfile->getActiveSheet()->getStyle('S'.$rws.':AF'.$rws)->getAlignment()->setIndent(1);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':B'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excelfile->getActiveSheet()->getStyle('AB'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$this->excelfile->getActiveSheet()->getStyle('G'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':N'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$this->excelfile->getActiveSheet()->getStyle('S'.$rws.':W'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
					$this->excelfile->getActiveSheet()->getStyle('D'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$this->excelfile->getActiveSheet()->getStyle('AE'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
					$hoja->setCellValue("AG{$rws}", $value["id_rojo"]);
				}

				if( 2 == 2){
					//SUCURSALES B
					$this->excelfile->setActiveSheetIndex(1);
					$hoja1->setCellValue("A{$rws}", "=AJUSTES!A".$rws)->getStyle('A'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
					$hoja1->setCellValue("B{$rws}", "=AJUSTES!B".$rws)->getStyle('B'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
					$hoja1->setCellValue("C{$rws}", "=AJUSTES!C".$rws);
					$hoja1->setCellValue("D{$rws}", "=AJUSTES!D".$rws);
					$hoja1->setCellValue("E{$rws}", "=AJUSTES!E".$rws);
					$hoja1->setCellValue("F{$rws}", "=AJUSTES!F".$rws);
					$hoja1->setCellValue("G{$rws}", "=AJUSTES!H".$rws);
					$hoja1->setCellValue("H{$rws}", "=AJUSTES!M".$rws)->getStyle("H{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");//PRECIO 4 CAJA
					$hoja1->setCellValue("W{$rws}", "=AJUSTES!AC".$rws);
					$hoja1->setCellValue("X{$rws}", "=AJUSTES!AD".$rws);
					$hoja1->setCellValue("Y{$rws}", "=AJUSTES!AE".$rws);
					$hoja1->setCellValue("Z{$rws}", "=AJUSTES!AF".$rws);

					$hoja1->setCellValue("M{$rws}", "=AJUSTES!P".$rws);//MARGENES
					$hoja1->setCellValue("N{$rws}", "=AJUSTES!Q".$rws);
					$hoja1->setCellValue("O{$rws}", "=AJUSTES!R".$rws);
					$hoja1->setCellValue("S{$rws}", "=AJUSTES!Y".$rws);
					$hoja1->setCellValue("T{$rws}", "=AJUSTES!Z".$rws);
					$hoja1->setCellValue("U{$rws}", "=AJUSTES!AA".$rws);
					
					$hoja1->setCellValue("V{$rws}", "=L".$rws."*H".$rws)->getStyle("V{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

					$hoja1->setCellValue("J{$rws}", "=ROUND((H{$rws}/F{$rws})+((M{$rws}*(H{$rws}/F{$rws}))/100),1)")->getStyle("J{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					$hoja1->setCellValue("K{$rws}", "=ROUND((H{$rws}/F{$rws})+((N{$rws}*(H{$rws}/F{$rws}))/100),1)")->getStyle("K{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
					$hoja1->setCellValue("L{$rws}", "=ROUND((H{$rws}/F{$rws})+((O{$rws}*(H{$rws}/F{$rws}))/100),1)")->getStyle("L{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

					$hoja1->setCellValue("I{$rws}", "=(H{$rws}/F{$rws})/(1+(G{$rws}/100))")->getStyle("I{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.0000_);_(* \(#,##0.0000\);_(* \"-\"??_);_(@_)");

					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->applyFromArray($styleArray);
					$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':L'.$rws)->getAlignment()->setIndent(1);
					$this->excelfile->getActiveSheet()->getStyle('P'.$rws.':R'.$rws)->getAlignment()->setIndent(1);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);

					$this->cellStyle('A'.$rws.':Z'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
					$this->cellStyle('C'.$rws, "FFFFFF", "000000", TRUE, 18, "Arial Narrow");
					$this->cellStyle('W'.$rws, "FFFFFF", "000000", TRUE, 18, "Arial Narrow");

					$this->cellStyle('H'.$rws, "FFCC66", "000000", TRUE, 18, "Arial Narrow");
					$this->cellStyle('I'.$rws, "C6D6B4", "000000", TRUE, 18, "Arial Narrow");//00B0F0
					$this->cellStyle('G'.$rws, "00B0F0", "000000", TRUE, 18, "Arial Narrow");
					$this->cellStyle('J'.$rws.':L'.$rws, "BDD7EE", "000000", FALSE, 18, "Arial Narrow");
					$this->cellStyle('M'.$rws.':O'.$rws, "FBBDFB", "000000", FALSE, 18, "Arial Narrow");

					$this->cellStyle('P'.$rws.':R'.$rws, "BDD7EE", "000000", FALSE, 18, "Arial Narrow");

					$this->cellStyle('S'.$rws.':U'.$rws, "BDD7EE", "000000", FALSE, 18, "Arial Narrow");
					$this->cellStyle('S'.$rws.':U'.$rws, "FBBDFB", "000000", FALSE, 18, "Arial Narrow");
					$this->cellStyle('V'.$rws, "8DB4E2", "000000", FALSE, 18, "Arial Narrow");


					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

					if ($value["estatus"] == 5){
						$this->cellStyle('A'.$rws.':D'.$rws, "FFFF00", "000000", FALSE, 18, "Arial Narrow");
					}elseif($value["estatus"] == 4){
						$this->cellStyle('A'.$rws.':D'.$rws, "92D050", "000000", FALSE, 18, "Arial Narrow");
						$hoja1->setCellValue("H{$rws}", "=AJUSTES!V".$rws)->getStyle("H{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");//PRECIO 4 CAJA
					}
					$hoja1->setCellValue("AA{$rws}", "=AJUSTES!AG".$rws);
					$this->excelfile->setActiveSheetIndex(0);
				}
				$this->excelfile->setActiveSheetIndex(0);
				if(!empty($value["relaciones"])){
					foreach ($value["relaciones"] as $key => $val){
						if(1 == 1){
							$this->cellStyle('A'.$rws.':AF'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
							$this->cellStyle('C'.$rws, "FFFFFF", "000000", TRUE, 16, "Arial Narrow");
							$this->cellStyle('D'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
							$this->cellStyle('E'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");

							$hoja->setCellValue("G{$rws}", $value["costo"])->getStyle("G{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$this->cellStyle('H'.$rws, "FFCC66", "000000", TRUE, 18, "Arial Narrow");
							$hoja->setCellValue("H{$rws}", $value["iva"]);
							$this->cellStyle('I'.$rws, "FFA887", "000000", TRUE, 18, "Arial Narrow");
							$hoja->setCellValue("I{$rws}", "=(G{$rws}/F{$rws})/(1+(H{$rws}/100))")->getStyle("I{$rws}")->getNumberFormat()->setFormatCode('#,##0.0000_-');
							$this->cellStyle('J'.$rws.':M'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
							$this->cellStyle('S'.$rws.':V'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");

							$mar1 = round( ( ($value["preciouno"]*100)/($value["preciocinco"]-0.01) )-100 );
						    $mar2 = round( ( ($value["preciodos"]*100)/($value["preciocinco"]-0.01) )-100 );
						    $mar3 = round( ( ($value["preciotres"]*100)/($value["preciocinco"]-0.01) )-100 );
						    $mar4 = round( ( ($value["preciocuatro"]*100)/($value["preciocinco"]-0.01) )-100 );

						    $this->cellStyle('O'.$rws.":R".$rws, "DAEEF3", "000000", FALSE, 18, "Arial Narrow");
						    $this->cellStyle('X'.$rws.":AA".$rws, "DAEEF3", "000000", FALSE, 18, "Arial Narrow");

							$hoja->setCellValue("J{$rws}", "=ROUND((G{$rws}/F{$rws})+((O{$rws}*(G{$rws}/F{$rws}))/100),1)")->getStyle("J{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$hoja->setCellValue("K{$rws}", "=ROUND((G{$rws}/F{$rws})+((P{$rws}*(G{$rws}/F{$rws}))/100),1)")->getStyle("K{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$hoja->setCellValue("L{$rws}", "=ROUND((G{$rws}/F{$rws})+((Q{$rws}*(G{$rws}/F{$rws}))/100),1)")->getStyle("L{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$hoja->setCellValue("M{$rws}", "=ROUND((G{$rws}/F{$rws})+((R{$rws}*(G{$rws}/F{$rws}))/100),1)")->getStyle("M{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$this->cellStyle('N'.$rws, "CC99FF", "000000", FALSE, 18, "Arial Narrow");
							$hoja->setCellValue("N{$rws}", "=+(G{$rws}/F{$rws})+0.01")->getStyle("N{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

							$hoja->setCellValue("AB{$rws}", "=N{$rws}*F{$rws}")->getStyle("AB{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");


							if($val["cantidad"] == "" || $val["cantidad"] == 0){
								$val["cantidad"] = 1;
							}
							$hoja->setCellValue("F{$rws}", $val["cantidad"]);//$value["cantidad"]

							$mar11 = round((($val["preciouno"]*100)/($val["preciocinco"]-0.01))-100);
						    $mar22 = round((($val["preciodos"]*100)/($val["preciocinco"]-0.01))-100);
						    $mar33 = round((($val["preciotres"]*100)/($val["preciocinco"]-0.01))-100);
						    $mar44 = round((($val["preciocuatro"]*100)/($val["preciocinco"]-0.01))-100);

						    $hoja->setCellValue("A{$rws}", $val["codigo"])->getStyle('A'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
							$hoja->setCellValue("B{$rws}", $val["cods"])->getStyle('B'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
							$hoja->setCellValue("C{$rws}", $value["ides"]);
							$hoja->setCellValue("D{$rws}", $val["descripcion"]);
							$hoja->setCellValue("E{$rws}", $value["uni"]);

						    $hoja->setCellValue("O{$rws}", $mar11)->getStyle("O{$rws}");
							$hoja->setCellValue("P{$rws}", $mar22)->getStyle("P{$rws}");
							$hoja->setCellValue("Q{$rws}", $mar33)->getStyle("Q{$rws}");
							$hoja->setCellValue("R{$rws}", $mar44)->getStyle("R{$rws}");

						    $hoja->setCellValue("X{$rws}", $mar1)->getStyle("X{$rws}");
							$hoja->setCellValue("Y{$rws}", $mar2)->getStyle("Y{$rws}");
							$hoja->setCellValue("Z{$rws}", $mar3)->getStyle("Z{$rws}");
							$hoja->setCellValue("AA{$rws}", $mar4)->getStyle("AA{$rws}");

						    $hoja->setCellValue("S{$rws}", "=ROUND(G{$rws}+((X{$rws}*G{$rws})/100),1)")->getStyle("S{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$hoja->setCellValue("T{$rws}", "=ROUND(G{$rws}+((Y{$rws}*G{$rws})/100),1)")->getStyle("T{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$hoja->setCellValue("U{$rws}", "=ROUND(G{$rws}+((Z{$rws}*G{$rws})/100),1)")->getStyle("U{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$hoja->setCellValue("V{$rws}", "=ROUND(G{$rws}+((AA{$rws}*G{$rws})/100),1)")->getStyle("V{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							
							$this->cellStyle('W'.$rws, "CC99FF", "000000", FALSE, 18, "Arial Narrow");
							$hoja->setCellValue("W{$rws}", "=G{$rws}+0.01")->getStyle("W{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

							$hoja->setCellValue("AC{$rws}", $value["code1"])->getStyle('AC'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
							$this->cellStyle('AD'.$rws, "FFFFFF", "000000", TRUE, 16, "Arial Narrow");
							$hoja->setCellValue("AD{$rws}", $value["ides"]);
							$this->cellStyle('AE'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
							$hoja->setCellValue("AE{$rws}", $value["descripcion"]);
							$this->cellStyle('AF'.$rws, "FFFFFF", "000000", FALSE, 16, "Arial Narrow");
							$hoja->setCellValue("AF{$rws}", $value["uni"]);
							$this->cellStyle('AB'.$rws, "8DB4E2", "000000", TRUE, 18, "Arial Narrow");
							if ($value["estatus"] == 5){
								$this->cellStyle('A'.$rws.':D'.$rws, "FFFF00", "000000", FALSE, 16, "Arial Narrow");
								$this->cellStyle('AC'.$rws.':AF'.$rws, "FFFF00", "000000", FALSE, 16, "Arial Narrow");
							}elseif($value["estatus"] == 4){
								$this->cellStyle('A'.$rws.':D'.$rws, "92D050", "000000", FALSE, 16, "Arial Narrow");
								$this->cellStyle('AC'.$rws.':AF'.$rws, "92D050", "000000", FALSE, 16, "Arial Narrow");
							}

							$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->applyFromArray($styleArray);
							$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':N'.$rws)->getAlignment()->setIndent(1);
							$this->excelfile->getActiveSheet()->getStyle('S'.$rws.':AF'.$rws)->getAlignment()->setIndent(1);
							$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);
							$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':AF'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':B'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$this->excelfile->getActiveSheet()->getStyle('AB'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$this->excelfile->getActiveSheet()->getStyle('G'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':N'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$this->excelfile->getActiveSheet()->getStyle('S'.$rws.':W'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$this->excelfile->getActiveSheet()->getStyle('D'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							$this->excelfile->getActiveSheet()->getStyle('AE'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							$hoja->setCellValue("AG{$rws}", $value["id_rojo"]);
						}
						

						if(2 == 2){
							//SUCURSALES B
							$this->excelfile->setActiveSheetIndex(1);

							$hoja1->setCellValue("A{$rws}", "=AJUSTES!A".$rws)->getStyle('A'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
							$hoja1->setCellValue("B{$rws}", "=AJUSTES!B".$rws)->getStyle('B'.$rws)->getNumberFormat()->setFormatCode('# ???/???');
							$hoja1->setCellValue("C{$rws}", "=AJUSTES!C".$rws);
							$hoja1->setCellValue("D{$rws}", "=AJUSTES!D".$rws);
							$hoja1->setCellValue("E{$rws}", "=AJUSTES!E".$rws);
							$hoja1->setCellValue("F{$rws}", "=AJUSTES!F".$rws);
							$hoja1->setCellValue("G{$rws}", "=AJUSTES!H".$rws);
							$hoja1->setCellValue("H{$rws}", "=AJUSTES!V".$rws)->getStyle("H{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");//PRECIO 4 CAJA
							$hoja1->setCellValue("W{$rws}", "=AJUSTES!AC".$rws);
							$hoja1->setCellValue("X{$rws}", "=AJUSTES!AD".$rws);
							$hoja1->setCellValue("Y{$rws}", "=AJUSTES!AE".$rws);
							$hoja1->setCellValue("Z{$rws}", "=AJUSTES!AF".$rws);

							$hoja1->setCellValue("M{$rws}", "=AJUSTES!P".$rws);//MARGENES
							$hoja1->setCellValue("N{$rws}", "=AJUSTES!Q".$rws);
							$hoja1->setCellValue("O{$rws}", "=AJUSTES!R".$rws);
							$hoja1->setCellValue("S{$rws}", "=AJUSTES!Y".$rws);
							$hoja1->setCellValue("T{$rws}", "=AJUSTES!Z".$rws);
							$hoja1->setCellValue("U{$rws}", "=AJUSTES!AA".$rws);
							
							$hoja1->setCellValue("V{$rws}", "=L".$rws."*H".$rws)->getStyle("V{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

							$hoja1->setCellValue("J{$rws}", "=ROUND((H{$rws}/F{$rws})+((M{$rws}*(H{$rws}/F{$rws}))/100),1)")->getStyle("J{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$hoja1->setCellValue("K{$rws}", "=ROUND((H{$rws}/F{$rws})+((N{$rws}*(H{$rws}/F{$rws}))/100),1)")->getStyle("K{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$hoja1->setCellValue("L{$rws}", "=ROUND((H{$rws}/F{$rws})+((O{$rws}*(H{$rws}/F{$rws}))/100),1)")->getStyle("L{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

							$hoja1->setCellValue("I{$rws}", "=(H{$rws}/F{$rws})/(1+(G{$rws}/100))")->getStyle("I{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.0000_);_(* \(#,##0.0000\);_(* \"-\"??_);_(@_)");

							$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->applyFromArray($styleArray);
							$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':L'.$rws)->getAlignment()->setIndent(1);
							$this->excelfile->getActiveSheet()->getStyle('P'.$rws.':R'.$rws)->getAlignment()->setIndent(1);
							$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getActiveSheet()->getRowDimension('1')->setRowHeight(60);

							$hoja1->setCellValue("P{$rws}", "=ROUND(H{$rws}+((S{$rws}*H{$rws})/100),1)")->getStyle("P{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$hoja1->setCellValue("Q{$rws}", "=ROUND(H{$rws}+((T{$rws}*H{$rws})/100),1)")->getStyle("Q{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
							$hoja1->setCellValue("R{$rws}", "=ROUND(H{$rws}+((U{$rws}*H{$rws})/100),1)")->getStyle("R{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");

							$this->cellStyle('A'.$rws.':Z'.$rws, "FFFFFF", "000000", FALSE, 18, "Arial Narrow");
							$this->cellStyle('C'.$rws, "FFFFFF", "000000", TRUE, 18, "Arial Narrow");
							$this->cellStyle('X'.$rws, "FFFFFF", "000000", TRUE, 18, "Arial Narrow");

							$this->cellStyle('H'.$rws, "FFCC66", "000000", TRUE, 18, "Arial Narrow");
							$this->cellStyle('I'.$rws, "C6D6B4", "000000", TRUE, 18, "Arial Narrow");//00B0F0
							$this->cellStyle('G'.$rws, "00B0F0", "000000", TRUE, 18, "Arial Narrow");
							$this->cellStyle('J'.$rws.':L'.$rws, "BDD7EE", "000000", FALSE, 18, "Arial Narrow");
							$this->cellStyle('M'.$rws.':O'.$rws, "FBBDFB", "000000", FALSE, 18, "Arial Narrow");

							$this->cellStyle('P'.$rws.':R'.$rws, "BDD7EE", "000000", FALSE, 18, "Arial Narrow");
							$this->cellStyle('S'.$rws.':U'.$rws, "FBBDFB", "000000", FALSE, 18, "Arial Narrow");
							$this->cellStyle('V'.$rws, "8DB4E2", "000000", FALSE, 18, "Arial Narrow");


							$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':Z'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':B'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$this->excelfile->getActiveSheet()->getStyle('W'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$this->excelfile->getActiveSheet()->getStyle('J'.$rws.':L'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$this->excelfile->getActiveSheet()->getStyle('P'.$rws.':R'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
							$this->excelfile->getActiveSheet()->getStyle('D'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
							$this->excelfile->getActiveSheet()->getStyle('Y'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

							if ($value["estatus"] == 5){
								$this->cellStyle('A'.$rws.':D'.$rws, "FFFF00", "000000", FALSE, 18, "Arial Narrow");
								$this->cellStyle('W'.$rws.':Z'.$rws, "FFFF00", "000000", FALSE, 18, "Arial Narrow");
							}elseif($value["estatus"] == 4){
								$this->cellStyle('A'.$rws.':D'.$rws, "92D050", "000000", FALSE, 18, "Arial Narrow");
								$this->cellStyle('W'.$rws.':Z'.$rws, "92D050", "000000", FALSE, 18, "Arial Narrow");
							}
							$hoja1->setCellValue("AA{$rws}", "=AJUSTES!AG".$rws);
						}

						$this->excelfile->setActiveSheetIndex(0);
						$rws++;
					}
				}else{
					$rws++;
				}
			}
		}
		
		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$file_name = "AJUSTE DE PRECIOS CALCULADORA.xlsx"; //Nombre del documento con extención
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment;filename=".$file_name);
		header("Cache-Control: max-age=0");
		$excel_Writer = PHPExcel_IOFactory::createWriter($this->excelfile, "Excel2007");
		$excel_Writer->save("php://output");
	}

	public function vero(){
		$rojos = $this->rojo_md->getRojos3();
		$this->jsonResponse($rojos);
	}

	public function upload_cambios(){
		$user = $this->session->userdata();
		$this->load->library("excelfile");
		ini_set("memory_limit", -1);
		$file = $_FILES["file_excel"]["tmp_name"];
		
		$objExcel = PHPExcel_IOFactory::load($file);
		$sheet = $objExcel->getSheet(0);
		$num_rows = $sheet->getHighestDataRow();

		$filen = "cambios".$user["id_usuario"]."x".date("dmyHis")."".rand(1000,9999);
		$config['upload_path']          = './assets/uploads/cambios/';
        $config['allowed_types']        = 'xlsx|xls';
        $config['max_size']             = 10000;
        $config['max_width']            = 10024;
        $config['max_height']           = 7608;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $new_existencias = FALSE;
        $this->upload->do_upload('file_excel',$filen);

        
		$mensaje = "Archivo invalido";
		$id_nuevo = 0;
		$flag = 1;
		$colores = [];$pack = [];
		$blues = $this->new_md->getMaxBlue(NULL)[0];
		if ( $this->getOldVal($sheet,4,"J") == "PRECIOS DEL 1 AL 5" || $this->getOldVal($sheet,5,"J") == "PRECIOS DEL 1 AL 5" || $this->getOldVal($sheet,4,"J") == "PRECIOS  ARTICULOS DEL 1 AL 5" || $this->getOldVal($sheet,5,"J") == "PRECIOS  ARTICULOS DEL 1 AL 5") {
			for ($i=4; $i<=$num_rows; $i++) {
				if($this->getOldVal($sheet,$i,"A") <> "" && $this->getOldVal($sheet,$i,"A") <> "  " && $this->getOldVal($sheet,$i,"A") <> "CODIGO PRINCIPAL"){
					if ($flag == 1) {
						$flag++;
						$nuevoid = $this->new_md->get(NULL,["suca"=>0]);
						if($nuevoid){
							$this->new_md->update(["suca"=>1 ],["id_nuevo"=>$nuevoid[0]->id_nuevo]);//GET NEW ID
							$id_nuevo = $nuevoid[0]->id_nuevo;
						}else{
							$id_nuevo = $this->new_md->insert([ "agrego"=>$user["id_usuario"],"suca"=>1 ]);//GET NEW ID
						}
					}
					
					$id_rojo = $this->rojo_md->get(NULL, ["codigo"=>$this->getOldVal($sheet,$i,"A")] );
					if (!$id_rojo) {
						$id_rojo = $this->rojo_md->get(NULL, ["codigo"=>$this->getOldVal($sheet,$i,"O")] );
					}
					$rojo = 1;
					if($id_rojo){
						$rojo = $id_rojo[0]->id_rojo;
						if($id_rojo[0]->estatus == 1){
							$this->rojo_md->update(["estatus"=>2],["id_rojo"=>$id_rojo[0]->id_rojo]);
						}elseif($id_rojo[0]->estatus == 4){
							$this->rojo_md->update(["estatus"=>7],["id_rojo"=>$id_rojo[0]->id_rojo]);
						}elseif($id_rojo[0]->estatus == 5){
							$this->rojo_md->update(["estatus"=>8],["id_rojo"=>$id_rojo[0]->id_rojo]);
						}
					}
					//OBTENER CEROS INICIALES
					$prodo = $this->prod_md->get(NULL,["codigo"=>$this->getOldVal($sheet,$i,"A"),"estatus"=>1]);
					if ($prodo){
						$prodo = $prodo[0]->codigo;
					}else{
						$prodo = $this->getOldVal($sheet,$i,"A");
					}
					$prodo2 = $this->prod_md->get(NULL,["codigo"=>$this->getOldVal($sheet,$i,"O"),"estatus"=>1]);
					if ($prodo2){
						$prodo2 = $prodo2[0]->codigo;
					}else{
						$prodo2 = $this->getOldVal($sheet,$i,"O");
					}
					$blue = $this->getHexBlue($sheet,$i);
					//$reds = $sheet->getStyle('O'.$i)->getFill()->getStartColor()->getRGB();
					//$reds = $this->getHex($reds);
					$bl = 0;
					if($blue){
						$bl = $blues->blues;
					}
					if($bl === 0){
						$blues = $this->new_md->getMaxBlue(NULL)[0];
					}
					$colore = $this->getMeColor($sheet,$i);
					$new_rojo[$i]=[
						"id_nuevo"		=>	$id_nuevo,
						"id_rojo"		=>	$rojo,
						"code1"			=>	$prodo,
						"code2"			=>	$this->getOldVal($sheet,$i,"B"),
						"linea"			=>	$this->getOldVal($sheet,$i,"C"),
						"desc1"			=>	$this->getOldVal($sheet,$i,"D"),
						"unidad"		=>	$this->getOldVal($sheet,$i,"E"),
						"code3"			=>	$prodo2,
						"desc2"			=>	$this->getOldVal($sheet,$i,"Q"),
						"cantidad"		=>	$this->getOldVal($sheet,$i,"F"),
						"costo"			=>	$this->getOldVal($sheet,$i,"G"),
						"iva"			=>	$this->getOldVal($sheet,$i,"H"),
						"pre1"			=>	$this->getOldVal($sheet,$i,"S"),
						"pre2"			=>	$this->getOldVal($sheet,$i,"T"),
						"pre3"			=>	$this->getOldVal($sheet,$i,"U"),
						"pre4"			=>	$this->getOldVal($sheet,$i,"V"),
						"pre5"			=>	$this->getOldVal($sheet,$i,"W"),
						"pre11"			=>	$this->getOldVal($sheet,$i,"J"),
						"pre22"			=>	$this->getOldVal($sheet,$i,"K"),
						"pre33"			=>	$this->getOldVal($sheet,$i,"L"),
						"pre44"			=>	$this->getOldVal($sheet,$i,"M"),
						"pre55"			=>	$this->getOldVal($sheet,$i,"N"),
						"rdiez"			=>	$this->getOldVal($sheet,$i,"I"),
						"costopz"		=>	($this->getOldVal($sheet,$i,"N")-0.01),
						"estatus"		=>	$colore,
						"blues"			=>	$bl
					];

					$colores[$i] = $this->actualizaBase($colore,$new_rojo[$i]);

					$pr1 = $this->prod_md->get(NULL,["codigo" => $prodo]);
	    			$pr2 = $this->prod_md->get(NULL,["codigo" => $prodo2]);
	    			if ($pr1){
	    				$this->prize_md->update( ["estatus"=>0],["id_producto"=>$pr1[0]->id_producto] );
	    				$this->prize_md->insert([ "id_producto"=>$pr1[0]->id_producto,"preciouno"=>$this->getOldVal($sheet,$i,"J"),"preciodos"=>$this->getOldVal($sheet,$i,"K"),"preciotres"=>$this->getOldVal($sheet,$i,"L"),"preciocuatro"=>$this->getOldVal($sheet,$i,"M"),"preciocinco"=>$this->getOldVal($sheet,$i,"N"),"registro"=>$user["id_usuario"] ]);
	    			}
	    			if ($pr2){
	    				$this->prize_md->update( ["estatus"=>0],["id_producto"=>$pr2[0]->id_producto] );
	    				$this->prize_md->insert([ "id_producto"=>$pr2[0]->id_producto,"preciouno"=>$this->getOldVal($sheet,$i,"S"),"preciodos"=>$this->getOldVal($sheet,$i,"T"),"preciotres"=>$this->getOldVal($sheet,$i,"U"),"preciocuatro"=>$this->getOldVal($sheet,$i,"V"),"preciocinco"=>$this->getOldVal($sheet,$i,"W"),"registro"=>$user["id_usuario"] ]);
	    			}
					$this->det_md->insert($new_rojo[$i]);

					
					$mensaje = "SE REGISTRARON SUC A";
				}
			}
			$new_cambio = [
				"accion" => "Sube Cambios A",
				"antes" => "".$filen,
				"id_usuario" => $user["id_usuario"]
			];
			$cambio = $this->cambio_md->insert($new_cambio);
		}else{
			for ($i=4; $i<=$num_rows; $i++) {
				if($this->getOldVal($sheet,$i,"A") <> "" && $this->getOldVal($sheet,$i,"A") <> "  " && $this->getOldVal($sheet,$i,"A") <> "CODIGO PRINCIPAL"){
					if ($flag == 1) {
						$flag++;
						$nuevoid = $this->new_md->get(NULL,["sucb"=>0]);
						if($nuevoid){
							$this->new_md->update(["sucb"=>1 ],["id_nuevo"=>$nuevoid[0]->id_nuevo]);//GET NEW ID
							$id_nuevo = $nuevoid[0]->id_nuevo;
						}else{
							$id_nuevo = $this->new_md->insert([ "agrego"=>$user["id_usuario"],"sucb"=>1 ]);//GET NEW ID
						}
					}
					
					$rojo = 1;

					$prodo = $this->prod_md->get(NULL,["codigo"=>$this->getOldVal($sheet,$i,"A"),"estatus"=>1]);
					if ($prodo){
						$prodo = $prodo[0]->codigo;
					}else{
						$this->getOldVal($sheet,$i,"A");
					}
					$prodo2 = $this->prod_md->get(NULL,["codigo"=>$this->getOldVal($sheet,$i,"AD"),"estatus"=>1]);
					if ($prodo2){
						$prodo2 = $prodo2[0]->codigo;
					}else{
						$this->getOldVal($sheet,$i,"AD");
					}
					$new_rojo[$i]=[
						"id_nuevo"		=>	$id_nuevo,
						"id_rojo"		=>	$rojo,
						"code1"			=>	$prodo,
						"code2"			=>	$this->getOldVal($sheet,$i,"B"),
						"linea"			=>	$this->getOldVal($sheet,$i,"C"),
						"desc1"			=>	$this->getOldVal($sheet,$i,"D"),
						"unidad"		=>	$this->getOldVal($sheet,$i,"E"),
						"code3"			=>	$prodo2,
						"desc2"			=>	$this->getOldVal($sheet,$i,"AF"),
						"cantidad"		=>	$this->getOldVal($sheet,$i,"F"),
						"costo"			=>	$this->getOldVal($sheet,$i,"H"),
						"iva"			=>	$this->getOldVal($sheet,$i,"G"),
						"pre11"			=>	$this->getOldVal($sheet,$i,"P"),
						"pre22"			=>	$this->getOldVal($sheet,$i,"Q"),
						"pre33"			=>	$this->getOldVal($sheet,$i,"R"),
						"pre1"			=>	$this->getOldVal($sheet,$i,"AI"),
						"pre2"			=>	$this->getOldVal($sheet,$i,"AJ"),
						"pre3"			=>	$this->getOldVal($sheet,$i,"AK"),
						"rdiez"			=>	$this->getOldVal($sheet,$i,"I"),
						"costopz"		=>	$this->getOldVal($sheet,$i,"AH"),
					];

					$this->newb_md->insert($new_rojo[$i]);
					$mensaje = "SE REGISTRARON SUC B";
				}
			}
			$new_cambio = [
				"accion" => "Sube Cambios B",
				"antes" => "".$filen,
				"id_usuario" => $user["id_usuario"]
			];
			$cambio = $this->cambio_md->insert($new_cambio);
		}


		$this->jsonResponse($colores);
	}

	private function getHex($color){
		$uno = substr($color,0,2);
		$dos = substr($color,2,2);
		$tre = substr($color,4,2);
		if(hexdec($dos) > hexdec($uno) && hexdec($uno) < 200){
			$color = 1;//verde ALTA
		}elseif(hexdec($uno) > 190 && hexdec($dos) > 190 && hexdec($tre) < 160){
			$color = 2; //amarillo EDICIÓN
		}elseif((hexdec($uno) > 150 && hexdec($dos) < 100 && hexdec($tre) < 100) || ( hexdec($uno) > hexdec($dos) && hexdec($uno) > hexdec($tre) && hexdec($uno) > 150) && hexdec($dos) < 200 && hexdec($tre) < 200){
			$color = 3;//rojo ELIMINAR
		}else{
			$color = 0;
		}
		return $color;
	}

	private function getHexBlue($sheet,$i){
		$color = $sheet->getStyle('A'.$i)->getFill()->getStartColor()->getRGB();
		$uno = substr($color,0,2);
		$dos = substr($color,2,2);
		$tre = substr($color,4,2);
		//$this->jsonResponse($color);
		if((hexdec($tre) >= 100 && hexdec($dos) < 100 && hexdec($uno) < 100) || (( hexdec($tre) > hexdec($dos) && hexdec($tre) > hexdec($uno) && hexdec($tre) > 150) && hexdec($dos) < 200 && hexdec($uno) < 200)){
			$color = true;//rojo azul
		}else{
			$color = false;
		}
		return $color;
	}

	private function getMeColor($sheet,$i){
		$color = $sheet->getStyle('B'.$i)->getFill()->getStartColor()->getRGB();
		$color = $this->getHex($color);
		if($color == 0){
			$color = $sheet->getStyle('C'.$i)->getFill()->getStartColor()->getRGB();
			$color = $this->getHex($color);
			if($color == 0){
				$color = $sheet->getStyle('D'.$i)->getFill()->getStartColor()->getRGB();
				$color = $this->getHex($color);
			}
		}

		$color2 = $sheet->getStyle('P'.$i)->getFill()->getStartColor()->getRGB();
		$color2 = $this->getHex($color2);
		if($color2 == 0){
			$color2 = $sheet->getStyle('Q'.$i)->getFill()->getStartColor()->getRGB();
			$color2 = $this->getHex($color2);
			if($color2 == 0){
				$color2 = $sheet->getStyle('R'.$i)->getFill()->getStartColor()->getRGB();
				$color2 = $this->getHex($color2);
			}
		}

		$canto = $sheet->getStyle('F'.$i)->getFill()->getStartColor()->getRGB();
		$canto = $this->getHex($canto);
		if ($canto <> 0){
			$canto = 0.1;
		}


		switch ([$color,$color2]) {
			case [2,0]:
				$colores = 2; //2 EDITAR PZ 
				break;
			case [0,2]:
				$colores = 3; //3 EDITAR CAJA 
				break;
			case [2,2]:
				$colores = 4; //4 EDITAR PZ Y CAJA 
				break;
			case [2,3]:
				$colores = 5; //5 EDITAR PZ Y ELIM CAJA 
				break;
			case [3,2]:
				$colores = 6; //6 EDITAR CAJA Y ELIM PZA 
				break;
			case [2,1]:
				$colores = 7; //7 EDITAR PZ Y ADD CAJA 
				break;
			case [1,2]:
				$colores = 8; //8 EDITAR CAJA Y ADD  PZA 
				break;
			case [1,0]:
				$colores = 9; //9 ADD PZA 
				break;
			case [0,1]:
				$colores = 10; //10 ADD CJA 
				break;
			case [1,1]:
				$colores = 11; //11 ADD PZA Y ADD CAJA 
				break;
			case [1,3]:
				$colores = 12; //12 ADD PZA Y ELIM CJA 
				break;
			case [3,1]:
				$colores = 13; //13 ADD CJA Y ELIM PZA 
				break;
			case [3,0]:
				$colores = 14; //14 ELIM PZA 
				break;
			case [0,3]:
				$colores = 15; //15 ELIM CJA 
				break;
			case [3,3]:
				$colores = 16; //16 ELIM PZA Y ELIM CJA 
				break;
			default:
				$colores = 1; //SI TIENE 0.1 SE CAMBÍA LA CANTIDAD	
				break;
		}

		return $colores+$canto;
	}

	private function actualizaBase($caso,$nuevo){
		$linea = $this->line_md->get(NULL,["ides"=>$nuevo["linea"]]);
		if($linea){
			$linea = $linea[0]->id_linea;
		}else{
			$linea = $this->prod_md->get(NULL,["codigo"=>$nuevo["code1"]]);
			if($linea){
				$linea = 1;
			}
		}
		if(fmod($caso, 1) !== 0.00){
		    $caso = $caso - 0.1;
		}
		$user = $this->session->userdata();
		switch ($caso) {
			case 2://2 EDITAR PZ 
				$this->prod_md->update( ["code"=>$nuevo["code2"],"nombre"=>$nuevo["desc1"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"]], ["codigo"=>$nuevo["code1"]] );
				break;
			case 3://3 EDITAR CAJA 
				$this->prod_md->update( ["nombre"=>$nuevo["desc2"]], ["codigo"=>$nuevo["code3"]] );
				break;
			case 4://4 EDITAR PZ Y CAJA 
				$this->prod_md->update( ["code"=>$nuevo["code2"],"nombre"=>$nuevo["desc1"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"]], ["codigo"=>$nuevo["code1"]] );
				$this->prod_md->update( ["nombre"=>$nuevo["desc2"]], ["codigo"=>$nuevo["code3"]] );
				break;
			case 5://5 EDITAR PZ Y ELIM CAJA 
				$this->prod_md->update( ["code"=>$nuevo["code2"],"nombre"=>$nuevo["desc1"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"]], ["codigo"=>$nuevo["code1"]] );
				$this->prod_md->update( ["estatus"=>0,"codigo"=>"ELIMINADO".$nuevo["code3"]], ["codigo"=>$nuevo["code3"]] );
				break;
			case 6://6 EDITAR CAJA Y ELIM PZA 
				$this->prod_md->update( ["estatus"=>0,"codigo"=>"ELIMINADO".$nuevo["code1"]], ["codigo"=>$nuevo["code1"]] );
				$this->prod_md->update( ["nombre"=>$nuevo["desc2"]], ["codigo"=>$nuevo["code3"]] );
				break;
			case 7://7 EDITAR PZ Y ADD CAJA 
				$this->prod_md->update( ["code"=>$nuevo["code2"],"nombre"=>$nuevo["desc1"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"]], ["codigo"=>$nuevo["code1"]] );
				$this->altaPz( ["codigo"=> $nuevo["code3"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"],"ums"=>2,"nombre"=>$nuevo["desc2"],"registro"=>$user["id_usuario"],"code"=>$nuevo["code3"]] );
				break;
			case 8://8 EDITAR CAJA Y ADD  PZA 
				$this->prod_md->update( ["nombre"=>$nuevo["desc2"]], ["codigo"=>$nuevo["code3"]] );
				$this->altaPz( ["codigo"=> $nuevo["code1"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"],"ums"=>1,"nombre"=>$nuevo["desc1"],"registro"=>$user["id_usuario"],"code"=>$nuevo["code2"]] );
				break;
			case 9://9 ADD PZA 
				$this->altaPz( ["codigo"=> $nuevo["code1"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"],"ums"=>1,"nombre"=>$nuevo["desc1"],"registro"=>$user["id_usuario"],"code"=>$nuevo["code2"]] );
				break;
			case 10://10 ADD CJA 
				$this->altaPz( ["codigo"=> $nuevo["code3"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"],"ums"=>2,"nombre"=>$nuevo["desc2"],"registro"=>$user["id_usuario"],"code"=>$nuevo["code3"]] );
				break;
			case 11://11 ADD PZA Y ADD CAJA 
				$this->altaPz( ["codigo"=> $nuevo["code3"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"],"ums"=>2,"nombre"=>$nuevo["desc2"],"registro"=>$user["id_usuario"],"code"=>$nuevo["code3"]] );
				$this->altaPz( ["codigo"=> $nuevo["code1"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"],"ums"=>1,"nombre"=>$nuevo["desc1"],"registro"=>$user["id_usuario"],"code"=>$nuevo["code2"]] );
				break;
			case 12://12 ADD PZA Y ELIM CJA 
				$this->altaPz( ["codigo"=> $nuevo["code1"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"],"ums"=>1,"nombre"=>$nuevo["desc1"],"registro"=>$user["id_usuario"],"code"=>$nuevo["code2"]] );
				$this->prod_md->update( ["estatus"=>0,"codigo"=>"ELIMINADO".$nuevo["code3"]], ["codigo"=>$nuevo["code3"]] );
				break;
			case 13://13 ADD CJA Y ELIM PZA 
				$this->altaPz( ["codigo"=> $nuevo["code3"],"linea"=>$linea,"unidad"=>$nuevo["cantidad"],"ums"=>2,"nombre"=>$nuevo["desc2"],"registro"=>$user["id_usuario"],"code"=>$nuevo["code3"]] );
				$this->prod_md->update( ["estatus"=>0,"codigo"=>"ELIMINADO".$nuevo["code1"]], ["codigo"=>$nuevo["code1"]] );
				break;
			case 14://14 ELIM PZA 
				$this->prod_md->update( ["estatus"=>0,"codigo"=>"ELIMINADO".$nuevo["code1"]], ["codigo"=>$nuevo["code1"]] );
				break;
			case 15://15 ELIM CJA 
				$this->prod_md->update( ["estatus"=>0,"codigo"=>"ELIMINADO".$nuevo["code3"]], ["codigo"=>$nuevo["code3"]] );
				break;
			case 16://16 ELIM PZA Y ELIM CJA 
				$this->prod_md->update( ["estatus"=>0,"codigo"=>"ELIMINADO".$nuevo["code1"]], ["codigo"=>$nuevo["code1"]] );
				$this->prod_md->update( ["estatus"=>0,"codigo"=>"ELIMINADO".$nuevo["code3"]], ["codigo"=>$nuevo["code3"]] );
				break;
			default:
				//
				break;
		}
		$pr1 = $this->prod_md->get(NULL,["codigo" => $nuevo["code1"]]);
	    $pr2 = $this->prod_md->get(NULL,["codigo" => $nuevo["code3"]]);
	    if ($pr1 && $pr2){
	    	$paq = $this->pack_md->get( NULL, ["id_caja"=>$pr2[0]->id_producto,"id_pieza"=>$pr1[0]->id_producto]);
	    	if($paq){
	    		$this->pack_md->update(["estatus"=>0],["id_caja"=>$pr2[0]->id_producto,"id_pieza"=>$pr1[0]->id_producto]);
	    		$this->pack_md->insert( ["id_caja"=>$pr2[0]->id_producto,"id_pieza"=>$pr1[0]->id_producto,"cantidad"=>$nuevo["cantidad"]] );
	    	}
	    }
		return $caso;
	}


	private function altaPz($arr){
		$prod = $this->prod_md->get(NULL, ["codigo"=>$arr["codigo"]]);
		if($prod){
			$prod = $this->prod_md->update( $arr,["codigo"=>$arr["codigo"]] );
		}else{
			$prod = $this->prod_md->insert( $arr );	
		}
	}

	public function upload_ofertas(){
		$user = $this->session->userdata();
		$this->load->library("excelfile");
		ini_set("memory_limit", -1);
		$file = $_FILES["file_excel"]["tmp_name"];
		
		$objExcel = PHPExcel_IOFactory::load($file);
		$sheet = $objExcel->getSheet(0);
		$num_rows = $sheet->getHighestDataRow();

		$filen = "ofertas".$user["id_usuario"]."x".date("dmyHis")."".rand(1000,9999);
		$config['upload_path']          = './assets/uploads/ofertas/';
        $config['allowed_types']        = 'xlsx|xls';
        $config['max_size']             = 10000;
        $config['max_width']            = 10024;
        $config['max_height']           = 76080;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('file_excel',$filen);

        
		$mensaje = "Archivo invalido";
		$id_nuevo = 0;
		$flag = 1;
		$inicio = "";$termino="";
		$conjunto = $this->getMaxOfes();
		$conju = floatval($conjunto->fecha) +1;
		$conju2 = floatval($conjunto->fecha) +2;
		if ( 1 == 1 ) {//OFERTAS DE LA SEMANA
			$inicio = date('Y-m-d 07:00:00',PHPExcel_Shared_Date::ExcelToPHP( $this->getOldVal($sheet,3,"B")));
			$termino= date('Y-m-d 22:00:00',PHPExcel_Shared_Date::ExcelToPHP( $this->getOldVal($sheet,3,"D")));

			$inicio2 = date('Y-m-d 07:00:00',PHPExcel_Shared_Date::ExcelToPHP( $this->getOldVal($sheet,3,"G")));
			$termin2 = date('Y-m-d 22:00:00',PHPExcel_Shared_Date::ExcelToPHP( $this->getOldVal($sheet,3,"I")));
			for ($i=5; $i<=$num_rows; $i++) {
				if($this->getOldVal($sheet,$i,"A") <> "" && $this->getOldVal($sheet,$i,"A") <> "  " && $this->getOldVal($sheet,$i,"A") <> "CODIGO" && $this->getOldVal($sheet,$i,"A") <> "0" && $this->getOldVal($sheet,$i,"A") <> 0){
					$produ = 0;$codo = $this->getOldVal($sheet,$i,"A");
					$pro = $this->prod_md->get(NULL,["estatus"=>1,"codigo"=>$this->getOldVal($sheet,$i,"A")]);
					if($pro){
						$produ = $pro[0]->id_producto;
						$codo = $pro[0]->codigo;
					}
					$new_ofe=[
						"fecha_inicio"	=>	$inicio,
						"fecha_termino"	=>	$termino,
						"codigo"		=>	$codo,
						"nombre"		=>	$this->getOldVal($sheet,$i,"B"),
						"precio"		=>	$this->getOldVal($sheet,$i,"C"),
						"normal"		=>	$this->getOldVal($sheet,$i,"D"),
						"maximo"		=>	$this->getOldVal($sheet,$i,"E"),
						"registro"		=>	$user["id_usuario"],
						"tipo"			=>	1,
						"id_producto"	=>	$produ,
						"conjunto"		=>	$conju
					];
					
					$this->ofe_md->insert($new_ofe);
				}

				if($this->getOldVal($sheet,$i,"F") <> "" && $this->getOldVal($sheet,$i,"F") <> "  " && $this->getOldVal($sheet,$i,"F") <> "CODIGO" && $this->getOldVal($sheet,$i,"F") <> "0" && $this->getOldVal($sheet,$i,"F") <> 0){
					$produ = 0;$codo = $this->getOldVal($sheet,$i,"F");
					$pro = $this->prod_md->get(NULL,["estatus"=>1,"codigo"=>$this->getOldVal($sheet,$i,"F")]);
					if($pro){
						$produ = $pro[0]->id_producto;
						$codo = $pro[0]->codigo;
					}
					$new_ofe=[
						"fecha_inicio"	=>	$inicio2,
						"fecha_termino"	=>	$termin2,
						"codigo"		=>	$codo,
						"nombre"		=>	$this->getOldVal($sheet,$i,"G"),
						"precio"		=>	$this->getOldVal($sheet,$i,"H"),
						"normal"		=>	$this->getOldVal($sheet,$i,"I"),
						"maximo"		=>	$this->getOldVal($sheet,$i,"J"),
						"registro"		=>	$user["id_usuario"],
						"tipo"			=>	1,
						"id_producto"	=>	$produ,
						"conjunto"		=>	$conju2
					];
					
					$this->ofe_md->insert($new_ofe);
				}


			}
			$new_cambio = [
				"accion" => "Sube Ofertas SEMANALES",
				"antes" => "".$filen,
				"id_usuario" => $user["id_usuario"]
			];
			$cambio = $this->cambio_md->insert($new_cambio);
		}


		$this->jsonResponse( $conju );
	}

	public function excelDate($excel_date){
		$unix_date = ($excel_date - 25569) * 86400;
		$excel_date = 25569 + ($unix_date / 86400);
		$unix_date = ($excel_date - 25569) * 86400;
		return gmdate("Y-m-d", $unix_date);
	}

	public function getOfertas(){
		$this->jsonResponse( $this->ofe_md->getActivas(NULL) );
	}

	public function getORecientes(){
		$this->jsonResponse( $this->ofe_md->getRecientes(NULL) );
	}

	public function getOferta($dis){
		$this->jsonResponse( $this->ofe_md->getOferton(["o.conjunto"=>$dis]) );
	}

	public function getMaxOfes(){
		return $this->ofe_md->getMaxReg(NULL)[0];
	}


}