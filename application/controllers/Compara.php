<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compara extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Usuarios_model", "user_md");
		$this->load->model("Cambios_model", "cambio_md");
		$this->load->model("Sucprecios_model", "sprize_md");
		$this->load->model("Sucproductos_model", "sprod_md");
		$this->load->model("Productos_model", "prod_md");
		$this->load->model("Nuevos_model", "new_md");
		$this->load->model("Nuevodetail_model", "det_md");
		$this->load->model("Listos_model", "listo_md");
		$this->load->model("Sucursales_model", "sucursal_md");
		$this->load->model("Lastcosuc_model", "lasto_md");
		$this->load->model("Existencias_model", "exis_md");
		$this->load->library("form_validation");
	}

	public function upload_matrizB(){
		$user = $this->session->userdata();
		ini_set("memory_limit", -1);	
		$user = $this->session->userdata();
		$filena=$_FILES['file_matriz']['name'];
		$filen = "sucursal".date("dmyHis")."".rand(1000,9999);
		$config['upload_path']          = './assets/uploads/matriciales/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 40000;
        $config['max_width']            = 40024;
        $config['max_height']           = 40024;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('file_matriz',$filen);
        $path_parts = pathinfo($_FILES["file_matriz"]["name"]);
		$extension = $path_parts['extension'];

		$new_cambio = [
			"accion" => "Sube Matricial Sucursal B",
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
			$this->sprod_md->update(["estatus"=>0],["estatus"=>1,"id_sucursal"=>$user["id_sucursal"]]);
			for ($i=0; $i<sizeof($pos); $i++){
				if (!empty($pos[$i])){
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("€", "P", $pos[$i]);
					$pos[$i] = str_replace("�", "P", $pos[$i]);
					$pos[$i] = str_replace("cei-029u-2.6", "", $pos[$i]);
					//$pos[$i] = str_replace("¥", "Ñ", $pos[$i]);
					$pos[$i] = str_replace("�", "Ñ", $pos[$i]);
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
							//NO SE MANEJARÁ FAMILIAS PARA SUCURSALES ALV
						}else{
							$code1 = substr($pos[$i], 0,17);
							$code1 = str_replace(" ", "", $code1);
							$descripcion = substr($pos[$i], 17,41);
							$descripcion = str_replace("  ", "", $descripcion);
							$unidad = substr($pos[$i], 58,3);
							$existencia = substr($pos[$i], 62,12);
							$existencia = str_replace(" ", "", $existencia);
							$existencia = str_replace(",", "", $existencia);
							$exo = substr($pos[$i], 73,1);
							if($exo == "-"){
								$existencia = "-".$existencia;
							}

							$p1 = substr($pos[$i], 76,12);
							$p1 = str_replace(" ", "", $p1);
							$p1 = str_replace(",", "", $p1);
							$exo = substr($pos[$i], 86,1);
							if($exo == "-"){
								$p1 = "-".$p1;
							}

							$p2 = substr($pos[$i], 87,12);
							$p2 = str_replace(" ", "", $p2);
							$p2 = str_replace(",", "", $p2);
							$exo = substr($pos[$i], 98,1);
							if($exo == "-"){
								$p2 = "-".$p2;
							}

							$p3 = substr($pos[$i], 99,12);
							$p3 = str_replace(" ", "", $p3);
							$p3 = str_replace(",", "", $p3);
							$exo = substr($pos[$i], 110,1);
							if($exo == "-"){
								$p3 = "-".$p3;
							}

							$code2 = substr($pos[$i], 112,26);
							$code2 = str_replace(" ", "", $code2);

							$code1 = str_replace("\r", "", $code1);
							$code2 = str_replace("\r", "", $code2);
							$prodC = $this->prod_md->get(NULL,["codigo"=>$code1,"estatus"=>1]);
							
							if($prodC){
								$prodC1 = $prodC[0]->id_producto;
							}else{
								$prodC2 = $this->prod_md->get(NULL,["codigo"=>$code2,"estatus"=>1]);
								if($prodC2){
									$prodC1 = $prodC2[0]->id_producto;
								}else{
									$prodC1 = 222;
								}
							}
							$new_producto=[
								"codigo"		=>	$code1,
								"nombre"		=>	$descripcion,
								"registro"		=>	$user["id_usuario"],
								"ums"			=>	$unidad,
								"code"			=>	$code2,
								"id_sucursal"	=>	$user["id_sucursal"],
								"fecha_registro"=>	date("Y-m-d H:i:s"),
								"estatus"		=>	1,
								"id_prox"		=>	$prodC1
							];

							$producto = $this->sprod_md->get(NULL,["codigo"=>$code1,"id_sucursal"=>$user["id_sucursal"],"estatus"=>1]);

							if($producto){
								$id_producto = $this->sprod_md->update($new_producto,$producto[0]->id_producto);
								$id_producto = $producto[0]->id_producto;
							}else{
								$id_producto = $this->sprod_md->insert($new_producto);
							}
							$new_existencia=[
								"id_producto"	=>	$id_producto,
								"existencia"	=>	$existencia,
								"fecha_registro"=>	date("Y-m-d H:i:s")
							];

							$existencia = $this->exis_md->get(NULL,[ "id_producto"=>$id_producto,"DATE(fecha_registro)"=>date("Y-m-d") ]);

							if($existencia){
								$id_existencia = $this->exis_md->update(["estatus"=>0],["id_producto"=>$id_producto,"DATE(fecha_registro)"=>date("Y-m-d") ]);
								//$id_existencia = $existencia[0]->id_existencia;
							}
							$id_existencia = $this->exis_md->insert($new_existencia);

							$new_precios=[
								"id_producto"	=>	$id_producto,
								"preciouno"		=>	$p1,
								"preciodos"		=>	$p2,
								"preciotres"	=>	$p3,
								"registro"		=>	$user["id_usuario"],
								"fecha_registro"=>	date("Y-m-d H:i:s")
							];


							$precio = $this->sprize_md->get(NULL,["id_producto"=>$id_producto,"estatus"=>1])[0];

							if($precio){
								$id_producto = $this->sprize_md->update($new_precios,$precio->id_precio);
							}else{
								$id_producto = $this->sprize_md->insert($new_precios);
							}
							
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

	public function sucursales(){
		if($this->session->userdata("username")){
			$user = $this->session->userdata();//Trae los datos del usuario
			$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
			$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
			$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
			$data['scripts'] = [
				'/scripts/Compara/sucursal',
			];
			$this->estructura("Compara/sucursal", $data);
		}else{
			$this->data["message"] =NULL;
			$this->estructura_login("Admin/login", $this->data, FALSE);
		}
	}

	public function getComparacion(){
		$comparativa = $this->sprod_md->getComparacion(NULL);
		$this->jsonResponse($comparativa);
	}

	public function getComparacionCedis($sucursal=8){
		$comparativa = $this->sprod_md->getComparacionCedis(NULL,$sucursal);
		$this->jsonResponse($comparativa);
	}

	public function getRenglonCedis($sucursal=8){
		$comparativa = $this->sprod_md->getRenglonCedis(NULL,$sucursal);
		$this->jsonResponse($comparativa);
	}

	public function upload_matriz(){
		$user = $this->session->userdata();
		mb_internal_encoding("UTF-8");
		ini_set("memory_limit", -1);	
		$user = $this->session->userdata();
		$filena=$_FILES['file_matriz']['name'];
		$filen = "matricial".date("dmyHis")."".rand(1000,9999);
		$config['upload_path']          = './assets/uploads/matriciales/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 40000;
        $config['max_width']            = 40024;
        $config['max_height']           = 40024;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('file_matriz',$filen);
        $path_parts = pathinfo($_FILES["file_matriz"]["name"]);
		$extension = $path_parts['extension'];


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
				$new_cambio = [
				"accion" => "Sube Matricial",
				"antes" => "".$filen.".".$extension,
				"id_usuario" => $user["id_usuario"]
			];
			$cambio = $this->cambio_md->insert($new_cambio);
		}else{
			$new_cambio = [
				"accion" => "Sube CATALOGO",
				"antes" => "".$filen.".".$extension,
				"id_usuario" => $user["id_usuario"]
			];
			$cambio = $this->cambio_md->insert($new_cambio);
		}
		if ($filena){
			$this->sprod_md->update(["estatus"=>0],["estatus"=>1,"id_sucursal"=>$user["id_sucursal"]]);
			for ($i=0; $i<sizeof($pos); $i++){
				if (!empty($pos[$i])){
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("€", "P", $pos[$i]);
					$pos[$i] = str_replace("�", "P", $pos[$i]);
					$pos[$i] = str_replace("cei-029u-2.6", "", $pos[$i]);
					$pos[$i] = str_replace("¥", "Ñ", $pos[$i]);
					$pos[$i] = str_replace(chr(190), "Ñ", $pos[$i]);
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
							/*$fam = substr($pos[$i], 3,2);
							$familia = substr($pos[$i], 8);
							

							$lineas = $this->line_md->get("id_linea",["ides"=>$fam])[0];
							if($lineas){
								$linea = $this->line_md->update(["nombre"=>$familia,"ides"=>$fam,"registro"=>$user['id_usuario']],$lineas->id_linea);
								$linea = $lineas->id_linea;
							}else{
								$linea = $this->line_md->insert(["nombre"=>$familia,"ides"=>$fam,"registro"=>$user['id_usuario']]);
							}*/
						}else{
							$code1 = substr($pos[$i], 0,17);
							$code1 = str_replace(" ", "", $code1);
							$descripcion = substr($pos[$i], 17,36);
							//$descripcion = str_replace("¥", "Ñ", $descripcion);
							$unidad = substr($pos[$i], 53,3);
							$existencia = substr($pos[$i], 56,12);
							$existencia = str_replace(" ", "", $existencia);
							$existencia = str_replace(",", "", $existencia);
							$exo = substr($pos[$i], 68,1);
							if($exo == "-"){
								$existencia = "-".$existencia;
							}

							$p1 = substr($pos[$i], 70,11);
							$p1 = str_replace(" ", "", $p1);
							$p1 = str_replace(",", "", $p1);
							$exo = substr($pos[$i], 81,1);
							if($exo == "-"){
								$p1 = "-".$p1;
							}

							$p2 = substr($pos[$i], 82,12);
							$p2 = str_replace(" ", "", $p2);
							$p2 = str_replace(",", "", $p2);
							$exo = substr($pos[$i], 93,1);
							if($exo == "-"){
								$p2 = "-".$p2;
							}

							$p3 = substr($pos[$i], 94,12);
							$p3 = str_replace(" ", "", $p3);
							$p3 = str_replace(",", "", $p3);
							$exo = substr($pos[$i], 105,1);
							if($exo == "-"){
								$p3 = "-".$p3;
							}

							$p4 = substr($pos[$i], 106,12);
							$p4 = str_replace(" ", "", $p4);
							$p4 = str_replace(",", "", $p4);
							$exo = substr($pos[$i], 117,1);
							if($exo == "-"){
								$p4 = "-".$p4;
							}

							$p5 = substr($pos[$i], 118,12);
							$p5 = str_replace(" ", "", $p5);
							$p5 = str_replace(",", "", $p5);
							$exo = substr($pos[$i], 129,1);
							if($exo == "-"){
								$p5 = "-".$p5;
							}

							$code2 = substr($pos[$i], 130,14);
							$code2 = str_replace(" ", "", $code2);


							$code1 = str_replace("\r", "", $code1);
							$code2 = str_replace("\r", "", $code2);
							$prodC = $this->prod_md->get(NULL,["codigo"=>$code1,"estatus"=>1]);
							
							if($prodC){
								$prodC1 = $prodC[0]->id_producto;
							}else{
								$prodC2 = $this->prod_md->get(NULL,["codigo"=>$code2,"estatus"=>1]);
								if($prodC2){
									$prodC1 = $prodC2[0]->id_producto;
								}else{
									$prodC1 = 222;
								}
							}
							$new_producto=[
								"codigo"		=>	$code1,
								"nombre"		=>	$descripcion,
								"registro"		=>	$user["id_usuario"],
								"ums"			=>	$unidad,
								"code"			=>	$code2,
								"id_sucursal"	=>	$user["id_sucursal"],
								"fecha_registro"=>	date("Y-m-d H:i:s"),
								"estatus"		=>	1,
								"id_prox"		=>	$prodC1
							];

							$producto = $this->sprod_md->get(NULL,["codigo"=>$code1,"id_sucursal"=>$user["id_sucursal"]]);

							if($producto){
								$id_producto = $this->sprod_md->update($new_producto,["id_producto"=>$producto[0]->id_producto]);
								$id_producto = $producto[0]->id_producto;
							}else{
								$id_producto = $this->sprod_md->insert($new_producto);
							}

							$new_existencia=[
								"id_producto"	=>	$id_producto,
								"existencia"	=>	$existencia,
								"fecha_registro"=>	date("Y-m-d H:i:s")
							];

							$existencia = $this->exis_md->get(NULL,[ "id_producto"=>$id_producto,"DATE(fecha_registro)"=>date("Y-m-d") ]);

							if($existencia){
								$id_existencia = $this->exis_md->update(["estatus"=>0],["id_producto"=>$id_producto, "DATE(fecha_registro)"=>date("Y-m-d")]);
							}
							$id_existencia = $this->exis_md->insert($new_existencia);
							

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


							$precio = $this->sprize_md->get(NULL,["id_producto"=>$id_producto,"estatus"=>1]);

							if($precio){
								$id_producto = $this->sprize_md->update($new_precios,$precio[0]->id_precio);
							}else{
								$id_precio = $this->sprize_md->insert($new_precios);
							}
							
							
						}
					}
				}
			}
			
			$mensaje=[	"id"	=>	'Éxito',
						"desc"	=>	'Datos cargados correctamdente en el Sistema',
						"type"	=>	'success'];
			$this->jsonResponse($mensaje);
		}else{
			if(strpos($dom,"Catalogo de Articulos")){
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
						if(strpos($pos[$i],"cei-0291-2.6")  && strlen($pos[$i]) < 150){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"Catalogo de Articulos") && strlen($pos[$i]) < 150){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"D e s c r i p c i o n")  && strlen($pos[$i]) < 150){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"Codigo")  && strlen($pos[$i]) < 150){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"-----------")){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"Hoja : ") && strlen($pos[$i]) < 150){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"*******************") && strlen($pos[$i]) < 150){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"Utilidad") && strlen($pos[$i]) < 150){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"CEDIS ABARROTES AZTECA")  && strlen($pos[$i]) < 150){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"FIN DE REPORTE")){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"Proveedor")){
							$pos[$i] = "";
						}
						if(strpos($pos[$i],"(Continuacion)")){
							$pos[$i] = "";
						}
						if(strlen($pos[$i]) < 10){
							$pos[$i] = "";	
						}
						
						if($pos[$i] <> ""){
							if (substr($pos[$i], 0,1) === " "){
								$codigo = substr($pos[$i], 4,16); 
								$codigo = str_replace(" ", "", $codigo);
								$nome = substr($pos[$i], 21,48); 
								$nome = str_replace("  ", "", $nome);
								$nome = str_replace("¥", "Ñ", $nome);

								$lastco = substr($pos[$i], 80,13); 
								$lastco = str_replace(" ", "", $lastco);
								$lastco = str_replace(",", "", $lastco);

								$prod = $this->sprod_md->get(NULL,["estatus"=>1,"codigo"=>$codigo,"id_sucursal"=>$user["id_sucursal"]]);
								if ($prod) {
									$this->sprod_md->update(["nombre"=>$nome],["id_producto"=>$prod[0]->id_producto]);

									$lasto  = $this->lasto_md->get(NULL , ["id_producto"=>$prod[0]->id_producto,"estatus"=>1,"id_sucursal"=>$user["id_sucursal"]]);
									if($lasto){
										$this->lasto_md->update(["costo"=>$lastco] , [ "id_last"=>$lasto[0]->id_last ]);
									}else{
										$last = $this->lasto_md->insert([ "costo"=>$lastco,"codigo"=>$codigo,"id_sucursal"=>$user["id_sucursal"],"id_producto"=>$prod[0]->id_producto ]);
									}
								}

								
								
							}
						}				
					}
				}
				$mensaje=[	"id"	=>	'Éxito',
							"desc"	=>	'Datos cargados correctamente en el Sistema',
							"type"	=>	'success'];
				$this->jsonResponse($mensaje);
			}
		}
	}

	public function excelCompa(){
		$user = $this->session->userdata();
		ini_set("memory_limit", "-1");
		ini_set("max_execution_time", "-1");
		$this->load->library("excelfile");
		$hoja = $this->excelfile->setActiveSheetIndex(0);
		$this->excelfile->setActiveSheetIndex(0)->setTitle("COMPARACIÓN");
        $this->excelfile->setActiveSheetIndex(0);

        $sucursal = $this->sucursal_md->get(NULL,["id_sucursal"=>$user["id_sucursal"]])[0];

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
		$hoja = $this->excelfile->getActiveSheet();


		$comparativa = $this->sprod_md->getComparacion(NULL);

		//FECHA EN FORMATO COMPLETO PARA LOS TITULOS Y TABLAS
		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$day = date('w');
		$week_start = date('d', strtotime('-'.($day).' days'));
		$week_end = date('d', strtotime('+'.(6-$day).' days'));
		$rws = 1;
		$hoja->mergeCells('A'.$rws.':C'.$rws);
		$hoja->mergeCells('D'.$rws.':H'.$rws);
		$this->cellStyle("A".$rws.":H".$rws, "FAEBD7","000000", TRUE, 12, "Calibri");
		$hoja->setCellValue("A".$rws, "SUCURSAL ".$sucursal->nombre)->getColumnDimension('A')->setWidth(20);
		$hoja->setCellValue("D".$rws, "PRECIOS ".$sucursal->nombre)->getColumnDimension('D')->setWidth(14);

		$hoja->mergeCells('I'.$rws.':K'.$rws);
		$hoja->mergeCells('L'.$rws.':P'.$rws);
		$this->cellStyle("I".$rws.":P".$rws, "7FFFD4","000000", TRUE, 12, "Calibri");
		$hoja->setCellValue("I".$rws, "CEDIS")->getColumnDimension('I')->setWidth(20);
		$hoja->setCellValue("L".$rws, "PRECIOS CEDIS")->getColumnDimension('L')->setWidth(14);
		$rws++;
		$this->cellStyle("A".$rws.":H".$rws, "FAEBD7","000000", TRUE, 12, "Calibri");
		$this->cellStyle("I".$rws.":P".$rws, "7FFFD4","000000", TRUE, 12, "Calibri");
		$hoja->setCellValue("A".$rws, "CÓDIGO");
		$hoja->setCellValue("B".$rws, "DESCRIPCIÓN")->getColumnDimension('B')->setWidth(45);
		$hoja->setCellValue("C".$rws, "UM")->getColumnDimension('C')->setWidth(10);
		$hoja->setCellValue("D".$rws, "PRECIO 1");
		$hoja->setCellValue("E".$rws, "PRECIO 2")->getColumnDimension('E')->setWidth(14);
		$hoja->setCellValue("F".$rws, "PRECIO 3")->getColumnDimension('F')->setWidth(14);
		$hoja->setCellValue("G".$rws, "PRECIO 4")->getColumnDimension('G')->setWidth(14);
		$hoja->setCellValue("H".$rws, "PRECIO 5")->getColumnDimension('H')->setWidth(14);
		$hoja->setCellValue("I".$rws, "CÓDIGO");
		$hoja->setCellValue("J".$rws, "DESCRIPCIÓN")->getColumnDimension('J')->setWidth(45);
		$hoja->setCellValue("K".$rws, "UM")->getColumnDimension('K')->setWidth(10);
		$hoja->setCellValue("L".$rws, "PRECIO 1");
		$hoja->setCellValue("M".$rws, "PRECIO 2")->getColumnDimension('M')->setWidth(14);
		$hoja->setCellValue("N".$rws, "PRECIO 3")->getColumnDimension('N')->setWidth(14);
		$hoja->setCellValue("O".$rws, "PRECIO 4")->getColumnDimension('O')->setWidth(14);
		$hoja->setCellValue("P".$rws, "PRECIO 5")->getColumnDimension('P')->setWidth(14);
		//baf3e0
		$rws++;
		if ($comparativa) {
			foreach ($comparativa as $key => $value) {
				//$this->cellStyle("I".$rws.":P".$rws, "BAF3E0", "000000", TRUE, 12, "Calibri");
				$hoja->setCellValue("A".$rws, $value->codigo);
				$hoja->setCellValue("B".$rws, $value->nombre);
				$hoja->setCellValue("C".$rws, $value->ums);
				$hoja->setCellValue("D".$rws, $value->preciouno)->getStyle("D{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("E".$rws, $value->preciodos)->getStyle("E{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("F".$rws, $value->preciotres)->getStyle("F{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("G".$rws, $value->preciocuatro)->getStyle("G{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("H".$rws, $value->preciocinco)->getStyle("H{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

				$hoja->setCellValue("I".$rws, $value->codigo);
				$hoja->setCellValue("J".$rws, $value->nombre);
				$hoja->setCellValue("K".$rws, $value->ums);
				$hoja->setCellValue("L".$rws, $value->p1)->getStyle("L{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("M".$rws, $value->p2)->getStyle("M{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("N".$rws, $value->p3)->getStyle("N{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("O".$rws, $value->p4)->getStyle("O{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("P".$rws, $value->p5)->getStyle("P{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

				if($value->preciouno > $value->p1){
					$this->cellStyle("D".$rws, "BAF3E0", "000000", FALSE, 12, "Calibri");
				}elseif($value->preciouno < $value->p1){
					$this->cellStyle("D".$rws, "F9BABA", "000000", FALSE, 12, "Calibri");
				}
				if($value->preciodos > $value->p2){
					$this->cellStyle("E".$rws, "BAF3E0", "000000", FALSE, 12, "Calibri");
				}elseif($value->preciodos < $value->p2){
					$this->cellStyle("E".$rws, "F9BABA", "000000", FALSE, 12, "Calibri");
				}
				if($value->preciotres > $value->p3){
					$this->cellStyle("F".$rws, "BAF3E0", "000000", FALSE, 12, "Calibri");
				}elseif($value->preciotres < $value->p3){
					$this->cellStyle("F".$rws, "F9BABA", "000000", FALSE, 12, "Calibri");
				}
				if($value->preciocuatro > $value->p4){
					$this->cellStyle("G".$rws, "BAF3E0", "000000", FALSE, 12, "Calibri");
				}elseif($value->preciocuatro < $value->p4){
					$this->cellStyle("G".$rws, "F9BABA", "000000", FALSE, 12, "Calibri");
				}
				if($value->preciocinco > $value->p5){
					$this->cellStyle("H".$rws, "BAF3E0", "000000", FALSE, 12, "Calibri");
				}elseif($value->preciocinco < $value->p5){
					$this->cellStyle("H".$rws, "F9BABA", "000000", FALSE, 12, "Calibri");
				}

				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.":P".$rws)->applyFromArray($styleArray2);
				$rws++;
			}
		}

		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$file_name = "COMPARACIÓN AL ".$fecha.".xlsx"; //Nombre del documento con extención
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment;filename=".$file_name);
		header("Cache-Control: max-age=0");
		$excel_Writer = PHPExcel_IOFactory::createWriter($this->excelfile, "Excel2007");
		$excel_Writer->save("php://output");
	}

	public function cedis(){
		if($this->session->userdata("username")){
			$user = $this->session->userdata();//Trae los datos del usuario
			$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
			$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
			$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
			$data["lasta"] = $this->user_md->getLastDate(NULL);
			$data['scripts'] = [
				'/scripts/Compara/cedis',
			];
			$this->estructura("Compara/cedis", $data);
			//$this->jsonResponse($data["lasta"]);
		}else{
			$this->data["message"] =NULL;
			$this->estructura_login("Admin/login", $this->data, FALSE);
		}
	}

	public function excelCompaCedis($cedis){
		$user = $this->session->userdata();
		ini_set("memory_limit", "-1");
		ini_set("max_execution_time", "-1");
		$this->load->library("excelfile");
		$hoja = $this->excelfile->setActiveSheetIndex(0);
		$this->excelfile->setActiveSheetIndex(0)->setTitle("COMPARACIÓN");
        $this->excelfile->setActiveSheetIndex(0);

        $sucursal = $this->sucursal_md->get(NULL,["id_sucursal"=>$cedis])[0];

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
		$hoja = $this->excelfile->getActiveSheet();


		$comparativa = $this->sprod_md->getComparacionCedis(NULL,$cedis);

		//FECHA EN FORMATO COMPLETO PARA LOS TITULOS Y TABLAS
		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$day = date('w');
		$week_start = date('d', strtotime('-'.($day).' days'));
		$week_end = date('d', strtotime('+'.(6-$day).' days'));
		$rws = 1;
		$hoja->mergeCells('A'.$rws.':C'.$rws);
		$hoja->mergeCells('D'.$rws.':H'.$rws);
		$this->cellStyle("A".$rws.":H".$rws, "FAEBD7","000000", TRUE, 12, "Calibri");
		$hoja->setCellValue("A".$rws, "SUCURSAL ".$sucursal->nombre)->getColumnDimension('A')->setWidth(20);
		$hoja->setCellValue("D".$rws, "PRECIOS ".$sucursal->nombre)->getColumnDimension('D')->setWidth(14);

		$hoja->mergeCells('I'.$rws.':K'.$rws);
		$hoja->mergeCells('L'.$rws.':P'.$rws);
		$this->cellStyle("I".$rws.":P".$rws, "7FFFD4","000000", TRUE, 12, "Calibri");
		$hoja->setCellValue("I".$rws, "CEDIS")->getColumnDimension('I')->setWidth(20);
		$hoja->setCellValue("L".$rws, "PRECIOS CEDIS")->getColumnDimension('L')->setWidth(14);
		$rws++;
		$this->cellStyle("A".$rws.":H".$rws, "FAEBD7","000000", TRUE, 12, "Calibri");
		$this->cellStyle("I".$rws.":P".$rws, "7FFFD4","000000", TRUE, 12, "Calibri");
		$hoja->setCellValue("A".$rws, "CÓDIGO");
		$hoja->setCellValue("B".$rws, "DESCRIPCIÓN")->getColumnDimension('B')->setWidth(45);
		$hoja->setCellValue("C".$rws, "UM")->getColumnDimension('C')->setWidth(10);
		$hoja->setCellValue("D".$rws, "PRECIO 1");
		$hoja->setCellValue("E".$rws, "PRECIO 2")->getColumnDimension('E')->setWidth(14);
		$hoja->setCellValue("F".$rws, "PRECIO 3")->getColumnDimension('F')->setWidth(14);
		$hoja->setCellValue("G".$rws, "PRECIO 4")->getColumnDimension('G')->setWidth(14);
		$hoja->setCellValue("H".$rws, "PRECIO 5")->getColumnDimension('H')->setWidth(14);
		$hoja->setCellValue("I".$rws, "CÓDIGO");
		$hoja->setCellValue("J".$rws, "DESCRIPCIÓN")->getColumnDimension('J')->setWidth(45);
		$hoja->setCellValue("K".$rws, "UM")->getColumnDimension('K')->setWidth(10);
		$hoja->setCellValue("L".$rws, "PRECIO 1");
		$hoja->setCellValue("M".$rws, "PRECIO 2")->getColumnDimension('M')->setWidth(14);
		$hoja->setCellValue("N".$rws, "PRECIO 3")->getColumnDimension('N')->setWidth(14);
		$hoja->setCellValue("O".$rws, "PRECIO 4")->getColumnDimension('O')->setWidth(14);
		$hoja->setCellValue("P".$rws, "PRECIO 5")->getColumnDimension('P')->setWidth(14);
		//baf3e0
		$rws++;
		if ($comparativa) {
			foreach ($comparativa as $key => $value) {
				//$this->cellStyle("I".$rws.":P".$rws, "BAF3E0", "000000", TRUE, 12, "Calibri");
				$hoja->setCellValue("A".$rws, $value->codigo);
				$hoja->setCellValue("B".$rws, $value->nombre);
				$hoja->setCellValue("C".$rws, $value->ums);
				$hoja->setCellValue("D".$rws, $value->preciouno)->getStyle("D{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("E".$rws, $value->preciodos)->getStyle("E{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("F".$rws, $value->preciotres)->getStyle("F{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("G".$rws, $value->preciocuatro)->getStyle("G{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("H".$rws, $value->preciocinco)->getStyle("H{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");

				$hoja->setCellValue("I".$rws, $value->codigo);
				$hoja->setCellValue("J".$rws, $value->nombre);
				$hoja->setCellValue("K".$rws, $value->ums);
				$hoja->setCellValue("L".$rws, $value->p1)->getStyle("L{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("M".$rws, $value->p2)->getStyle("M{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("N".$rws, $value->p3)->getStyle("N{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("O".$rws, $value->p4)->getStyle("O{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$hoja->setCellValue("P".$rws, $value->p5)->getStyle("P{$rws}")->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				if( $value->cofe <> null && $value->cofe <> ""){
                    $this->cellStyle("A".$rws.":C".$rws, "F7C9FF", "000000", FALSE, 12, "Calibri");
                    $this->cellStyle("I".$rws.":K".$rws, "F7C9FF", "000000", FALSE, 12, "Calibri");
                }
				if($value->preciouno > $value->p1){
					$this->cellStyle("D".$rws, "BAF3E0", "000000", FALSE, 12, "Calibri");
				}elseif($value->preciouno < $value->p1){
					$this->cellStyle("D".$rws, "F9BABA", "000000", FALSE, 12, "Calibri");
				}
				if($value->preciodos > $value->p2){
					$this->cellStyle("E".$rws, "BAF3E0", "000000", FALSE, 12, "Calibri");
				}elseif($value->preciodos < $value->p2){
					$this->cellStyle("E".$rws, "F9BABA", "000000", FALSE, 12, "Calibri");
				}
				if($value->preciotres > $value->p3){
					$this->cellStyle("F".$rws, "BAF3E0", "000000", FALSE, 12, "Calibri");
				}elseif($value->preciotres < $value->p3){
					$this->cellStyle("F".$rws, "F9BABA", "000000", FALSE, 12, "Calibri");
				}
				if($value->preciocuatro > $value->p4){
					$this->cellStyle("G".$rws, "BAF3E0", "000000", FALSE, 12, "Calibri");
				}elseif($value->preciocuatro < $value->p4){
					$this->cellStyle("G".$rws, "F9BABA", "000000", FALSE, 12, "Calibri");
				}
				if($value->preciocinco > $value->p5){
					$this->cellStyle("H".$rws, "BAF3E0", "000000", FALSE, 12, "Calibri");
				}elseif($value->preciocinco < $value->p5){
					$this->cellStyle("H".$rws, "F9BABA", "000000", FALSE, 12, "Calibri");
				}

				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.":P".$rws)->applyFromArray($styleArray2);
				$rws++;
			}
		}

		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$file_name = "COMPARACIÓN AL ".$fecha.".xlsx"; //Nombre del documento con extención
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment;filename=".$file_name);
		header("Cache-Control: max-age=0");
		$excel_Writer = PHPExcel_IOFactory::createWriter($this->excelfile, "Excel2007");
		$excel_Writer->save("php://output");
	}

	public function codigos(){
		if($this->session->userdata("username")){
			$user = $this->session->userdata();//Trae los datos del usuario
			$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
			$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
			$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
			$data["lasta"] = $this->user_md->getLastDate(NULL);
			$data['scripts'] = [
				'/scripts/Compara/codigos',
			];
			$this->estructura("Compara/codigos", $data);
			//$this->jsonResponse($data["lasta"]);
		}else{
			$this->data["message"] =NULL;
			$this->estructura_login("Admin/login", $this->data, FALSE);
		}
	}

	public function getCodigosccCedis($sucursal=8){
		$comparativa = $this->sprod_md->getCodigosccCedis(NULL,$sucursal);
		$this->jsonResponse($comparativa);
	}

	public function getCodigosccSucus($sucursal=8){
		$comparativa = $this->sprod_md->getCodigosccSucus(NULL,$sucursal);
		$this->jsonResponse($comparativa);
	}

	public function faster(){
		if($this->session->userdata("username")){
			$user = $this->session->userdata();//Trae los datos del usuario
			$data["dias"] = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
			$data["meses"] = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
			$data["fecha"] =  $data["dias"][date('w')]." ".date('d')." DE ".$data["meses"][date('n')-1]. " DEL ".date('Y') ;
			$data["lasta"] = $this->user_md->getLastDate(NULL);
			$data['scripts'] = [
				'/scripts/Compara/faster',
			];
			$this->estructura("Compara/faster", $data);
			//$this->jsonResponse($data["lasta"]);
		}else{
			$this->data["message"] =NULL;
			$this->estructura_login("Admin/login", $this->data, FALSE);
		}
	}

	public function getComparacionFast($sucursal=8){
		$comparativa = $this->sprod_md->getComparacionFast(NULL,$sucursal);
		$this->jsonResponse($comparativa);
	}

}
