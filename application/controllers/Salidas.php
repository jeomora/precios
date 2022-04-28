<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');

class Salidas extends MY_Controller {

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
		$this->load->model("Sucos_model", "sucos_md");
		$this->load->model("Detallecotiz_model", "dcotiz_md");
		$this->load->model("Detalleremis_model", "dremis_md");
		$this->load->model("Remisiones_model", "remis_md");
		$this->load->library("form_validation");
	}

	public function upload_cotizaciones(){
		$user = $this->session->userdata();
		ini_set("memory_limit", -1);
		$dom = file_get_contents($_FILES["file_cotizaciones"]["tmp_name"]); 
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
		$linea = 0;$flag2 = 0;$flag =0;
		for ($i=0; $i<sizeof($pos); $i++){
			if (!empty($pos[$i])){
				$pos[$i] = str_replace("", "", $pos[$i]);
				$pos[$i] = str_replace("", "", $pos[$i]);
				$pos[$i] = str_replace("cei-03a3-2.6", "", $pos[$i]);
				$pos[$i] = str_replace("€", "P", $pos[$i]);
				$pos[$i] = str_replace("�", "P", $pos[$i]);
				$pos[$i] = str_replace("¥", "Ñ", $pos[$i]);
				$pos[$i] = str_replace("?", "Ñ", $pos[$i]);
				

				if(strpos($pos[$i],"Relacion de Cotizaciones del ")){
					$pos[$i] = "";
				}
				if(strpos($pos[$i]," Cliente")){
					$pos[$i] = "";
				}
				if(strpos($pos[$i],"CEDIS ABARROTES AZTECA")){
					$pos[$i] = "";
				}
				if(strpos($pos[$i],"Precio Unit.")){
					$pos[$i] = "";
				}
				if(strpos($pos[$i],"-------------------")){
					$pos[$i] = "";
				}
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
					if( strpos($pos[$i],"Pe=") ){
						$flag =0;
						$cotiz = substr($pos[$i], 2,6);
						$sucus = substr($pos[$i], 18,4);
						$fecha = substr($pos[$i], 64,9);
						$pedid = substr($pos[$i], 88,6);
						$remis = substr($pos[$i], 99,6);
						$factu = substr($pos[$i], 110,6);
						$nombresucu = substr($pos[$i], 23,30);
						
					}elseif( strpos($pos[$i],"Subtotal:") ){
						$subto = substr($pos[$i], 50,12);
						$subto = str_replace(" ", "", $subto);
						$subto = str_replace(",", "", $subto);
						$desct = substr($pos[$i], 71,8);
						$desct = str_replace(" ", "", $desct);
						$siniv = substr($pos[$i], 92,12);
						$siniv = str_replace(" ", "", $siniv);
						$siniv = str_replace(",", "", $siniv);
						$subto = substr($pos[$i], 50,12);
						$subto = str_replace(" ", "", $subto);
						$subto = str_replace(",", "", $subto);
						$ivass = substr($pos[$i], 111,10);
						$ivass = str_replace(" ", "", $ivass);
						$ivass = str_replace(",", "", $ivass);
						$total = substr($pos[$i], 128,12);
						$total = str_replace(" ", "", $total);
						$total = str_replace(",", "", $total);
						$new_factura = [
							"folio"		=>	$cotiz,
							"idsucu"	=>	$sucus,
							"fecha"		=>	$fecha,
							"fa"		=>	$factu,
							"remision"	=>	$remis,
							"pe"		=>	$pedid,
							"subtotal"	=>	$subto,
							"siniva"	=>	$siniv,
							"iva"		=>	$ivass,
							"total"		=>	$total,
							"registro"	=>	$user["id_usuario"]
						];
						$hayCotiz = $this->cotiz_md->hayCotizaciones(NULL);
						if($hayCotiz && $flag2 == 0){
							$this->db->query("UPDATE cotizaciones SET estatus = 0 WHERE DATE(fecha_registro) = DATE(CURDATE())");
						}
						$flag2 =1;
						$existSucu = $this->sucos_md->get(NULL,["ides"=>$sucus]);
						if(!$existSucu) {
							$existSucu = $this->sucos_md->get(NULL,["ides2"=>$sucus]);
							if(!$existSucu) {
								$existSucu = $this->sucos_md->get(NULL,["ides3"=>$sucus]);
								if(!$existSucu){
									$this->sucos_md->insert(["ides"=>$sucus,"nombre"=>$nombresucu,"registro"=>$user["id_usuario"],"tipo"=>3]);
								}
							}
						}
						$new_c = $this->cotiz_md->insert($new_factura);
						for ($ed=0; $ed < sizeof($new_detalle); $ed++){ 
						 	$new_detalle[$ed]["id_cotizacion"] = $new_c;
							$this->dcotiz_md->insert($new_detalle[$ed]);
						}
						$new_detalle = [];
						
					}else{
						$producto = substr($pos[$i], 22,18);
						$producto = str_replace(" ", "", $producto);
						$descripcion = substr($pos[$i], 40,37);
						
						$familia = substr($pos[$i], 19,2);
						$unidad = substr($pos[$i], 81,3);
						$cantidad = substr($pos[$i], 86,14);
						$cantidad = str_replace(" ", "", $cantidad);
						$cantidad = str_replace(",", "", $cantidad);
						$unitario = substr($pos[$i], 102,12);
						$unitario = str_replace(" ", "", $unitario);
						$unitario = str_replace(",", "", $unitario);
						$importe = substr($pos[$i], 123,17);
						$importe = str_replace(" ", "", $importe);
						$importe = str_replace(",", "", $importe);

						$prodo = $this->prod_md->get(NULL,["codigo"=>$producto,"estatus"=>1]);
						$id_prodo = 222;
						if($prodo){
							$id_prodo = $prodo[0]->id_producto;
						}

						$new_detalle[$flag] = [
							"producto"		=>	$producto,
							"descripcion"	=>	$descripcion,
							"familia"		=>	$familia,
							"unidad"		=>	$unidad,
							"cantidad"		=>	$cantidad,
							"precio"		=>	$unitario,
							"importe"		=>	$importe,
							"id_cotizacion"	=>	"",
							"id_producto"	=>	$id_prodo
						];
						$flag ++;
					}
				}
			}
		}
		
		$mensaje=[	"id"	=>	'Éxito',
					"desc"	=>	'Precios cargados correctamente en el Sistema',
					"type"	=>	'success'];
		$this->jsonResponse($mensaje);
		
	}

	public function upload_remisiones(){
		$user = $this->session->userdata();
		ini_set("memory_limit", -1);
		$dom = file_get_contents($_FILES["file_remisiones"]["tmp_name"]); 
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
		$linea = 0;$flag2 = 0;$flag =0;
		for ($i=0; $i<sizeof($pos); $i++){
			if (!empty($pos[$i])){
				$pos[$i] = str_replace("", "", $pos[$i]);
				$pos[$i] = str_replace("", "", $pos[$i]);
				$pos[$i] = str_replace("cei-03a8-2.6", "", $pos[$i]);
				$pos[$i] = str_replace("€", "P", $pos[$i]);
				$pos[$i] = str_replace("�", "P", $pos[$i]);
				$pos[$i] = str_replace("¥", "Ñ", $pos[$i]);
				$pos[$i] = str_replace("?", "Ñ", $pos[$i]);
				

				if(strpos($pos[$i],"Remisiones del ")){
					$pos[$i] = "";
				}
				if(strpos($pos[$i]," Cliente")){
					$pos[$i] = "";
				}
				if(strpos($pos[$i],"CEDIS ABARROTES AZTECA") && !strpos($pos[$i],"00-00-")){
					$pos[$i] = "";
				}
				if(strpos($pos[$i],"Precio Unit.")){
					$pos[$i] = "";
				}
				if(strpos($pos[$i],"-----------")){
					$pos[$i] = "";
				}
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
					if( strpos($pos[$i],"00-00-") ){
						$flag =0;
						$remis = substr($pos[$i], 2,6);
						$sucus = substr($pos[$i], 25,4);
						$fecha = substr($pos[$i], 9,9);
						$nombresucu = substr($pos[$i], 30,30);
						$agrego = substr($pos[$i], 61,22);
						
					}elseif( strpos($pos[$i],"Subtotal:") ){
						$subto = substr($pos[$i], 52,12);
						$subto = str_replace(" ", "", $subto);
						$subto = str_replace(",", "", $subto);
						$siniv = substr($pos[$i], 100,12);
						$siniv = str_replace(" ", "", $siniv);
						$siniv = str_replace(",", "", $siniv);
						$ivass = substr($pos[$i], 119,10);
						$ivass = str_replace(" ", "", $ivass);
						$ivass = str_replace(",", "", $ivass);
						$total = substr($pos[$i], 136,12);
						$total = str_replace(" ", "", $total);
						$total = str_replace(",", "", $total);
						$new_factura = [
							"folio"		=>	$remis,
							"idsucu"	=>	$sucus,
							"fecha"		=>	$fecha,
							"subtotal"	=>	$subto,
							"siniva"	=>	$siniv,
							"iva"		=>	$ivass,
							"total"		=>	$total,
							"registro"	=>	$user["id_usuario"],
							"agrego"	=>	$agrego
						];
						$hayRemis = $this->remis_md->hayRemisiones(NULL);
						if($hayRemis && $flag2 == 0){
							$this->db->query("UPDATE remisiones SET estatus = 0 WHERE DATE(fecha_registro) = DATE(CURDATE())");
						}
						$flag2 =1;
						$new_c = $this->remis_md->insert($new_factura);
						for ($ed=0; $ed < sizeof($new_detalle); $ed++){ 
						 	$new_detalle[$ed]["id_remision"] = $new_c;
							$this->dremis_md->insert($new_detalle[$ed]);
						}
						$new_detalle = [];
						
					}elseif( strpos($pos[$i],"Tot. devolucion") ){
						$this->db->query("UPDATE remisiones SET estatus = 0 WHERE id_remision = ".$new_c." ");
					}else{
						$producto = substr($pos[$i], 15,17);
						$producto = str_replace(" ", "", $producto);
						$descripcion = substr($pos[$i], 32,41);
						
						$familia = substr($pos[$i], 12,2);
						$unidad = substr($pos[$i], 73,3);
						$cantidad = substr($pos[$i], 76,12);
						$cantidad = str_replace(" ", "", $cantidad);
						$cantidad = str_replace(",", "", $cantidad);
						$unitario = substr($pos[$i], 115,12);
						$unitario = str_replace(" ", "", $unitario);
						$unitario = str_replace(",", "", $unitario);
						$importe = substr($pos[$i], 136,12);
						$importe = str_replace(" ", "", $importe);
						$importe = str_replace(",", "", $importe);

						$prodo = $this->prod_md->get(NULL,["codigo"=>$producto,"estatus"=>1]);
						$id_prodo = 222;
						if($prodo){
							$id_prodo = $prodo[0]->id_producto;
						}


						$new_detalle[$flag] = [
							"producto"		=>	$producto,
							"descripcion"	=>	$descripcion,
							"familia"		=>	$familia,
							"unidad"		=>	$unidad,
							"cantidad"		=>	$cantidad,
							"precio"		=>	$unitario,
							"importe"		=>	$importe,
							"id_remision"	=>	"",
							"id_producto"	=>	$id_prodo
						];
						$flag ++;
					}
				}
			}
		}
		
		$mensaje=[	"id"	=>	'Éxito',
					"desc"	=>	'Precios cargados correctamente en el Sistema',
					"type"	=>	'success'];
		$this->jsonResponse($mensaje);
		
	}


}
