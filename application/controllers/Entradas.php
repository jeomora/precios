<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entradas extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Cambios_model", "cambio_md");
		$this->load->model("EntTxt_model", "ent_md");
		$this->load->model("SalTxt_model", "sal_md");
		$this->load->model("Entradas_model", "remis_md");
		$this->load->model("Sucproductos_model", "sprod_md");
		$this->load->model("Productos_model", "prod_md");
		$this->load->model("Detalleentra_model", "dremis_md");
		$this->load->model("Detalleajusal_model", "dsali_md");
		$this->load->model("Detalleajuent_model", "dentr_md");
		$this->load->model("Ajusalida_model", "ajsal_md");
		$this->load->model("Ajuentrada_model", "ajent_md");
		$this->load->model("AjuTxt_model", "ajtxt_md");
		$this->load->model("Sucprecios_model", "sprize_md");
		$this->load->model("Precios_model", "prize_md");
		$this->load->model("Existencias_model", "exis_md");
		$this->load->model("Exicedis_model","exced_md");
		$this->load->model("Unidades_model", "ums_md");
		$this->load->library("form_validation");
	}


	public function subeEntrada(){
		ini_set("memory_limit", -1);
		$user = $this->session->userdata();

		///ALMACENANDO LOS DATOS

		$dom = file_get_contents($_FILES["file_inventario"]["tmp_name"]); 
		$articulos = [];
		$flag = 0;
		$flagNo = 1;
		$pos = explode("\n", $dom);
		$folio = "";
		
		/* EL ARCHIVO QUE SE SUBIO ES UN TXT DE NOTAS DE ENTRADA*/
		if( strpos($dom,"Relacion Notas de Entrada")  ||  strpos($dom,"RELACION NOTAS DE ENTRADA") ){
			$filen = "ent".date("dmyHis")."".rand(1000,9999);
			$config['upload_path']          = './assets/uploads/entradas/';
	        $config['allowed_types']        = '*';
	        $config['max_size']             = 40000;
	        $config['max_width']            = 40024;
	        $config['max_height']           = 40024;
	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);
	        $this->upload->do_upload('file_inventario',$filen);
	        $archi = "RELACION NOTAS DE ENTRADA";


	        $path_parts = pathinfo($_FILES["file_inventario"]["name"]);
			$extension = $path_parts['extension'];

			$fecha = new DateTime(date('Y-m-d H:i:s'));
			$new_entrada = [
				"id_usuario"	=>	$user["id_usuario"],
				"fecha_registro"=>	$fecha->format('Y-m-d H:i:s'),
				"txtfile"		=>	$filen.".".$extension,
				"id_sucursal"	=>	$user["id_sucursal"],
			];

			$inventa = $this->ent_md->get(NULL,["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d')]);
			if($inventa){
				$ino = $this->ent_md->update(["estatus"=>0],["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d')]);
			}
			$ino = $this->ent_md->insert($new_entrada);
			$cambios = [
				"id_usuario" => $user["id_usuario"],
				"fecha_cambio" => date('Y-m-d H:i:s'),
				"antes" => "Sube Archivo txt",
				"despues" => $ino];
			$data['cambios'] = $this->cambio_md->insert($cambios);


			$linea = 0;$flag2 = 0;$flag =0;
			for ($i=0; $i<sizeof($pos); $i++){
				if (!empty($pos[$i])){
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("€", "P", $pos[$i]);
					$pos[$i] = str_replace("�", "P", $pos[$i]);
					$pos[$i] = str_replace("¥", "Ñ", $pos[$i]);
					$pos[$i] = str_replace("?", "Ñ", $pos[$i]);
					

					if(strpos($pos[$i],"cei-0675-2.6") && strlen($pos[$i]) < 200 ){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Relacion Notas de Entrada")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Proveedor")){
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
					if(strpos($pos[$i],"N o m b r e") && strlen($pos[$i]) < 200){
						$pos[$i] = "";
					}
					if(strpos($pos[$i]," ") === false){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"D e s c r i p c i o n")){
						$pos[$i] = "";
					}
					if (strlen($pos[$i]) < 10) {
						$pos[$i] = "";	
					}
					if (strpos($pos[$i],"D E V O L U C I O N E S") || strpos($pos[$i],"D E V O L U C I O N E S :")) {
						$i=sizeof($pos);
					}
					if($pos[$i] <> ""){
						if(strpos($pos[$i],"00-00-") || strpos($pos[$i],"00-ZZ-")){
							$estatus = 1;
							$flag =0;
							$folio = substr($pos[$i], 2,6);
							$sucus = substr($pos[$i], 18,4);
							$fecha = substr($pos[$i], 64,9);
							$nombresucu = substr($pos[$i], 23,30);
							$agrego = substr($pos[$i], 85,6);
							if($pos[$i][0] == "D"){
								$estatus = 2;
							}
						}elseif( strpos($pos[$i],"Subtotal:") ){
							$subto = substr($pos[$i], 42,12);
							$subto = str_replace(" ", "", $subto);
							$subto = str_replace(",", "", $subto);
							$siniv = substr($pos[$i], 84,12);
							$siniv = str_replace(" ", "", $siniv);
							$siniv = str_replace(",", "", $siniv);
							$ivass = substr($pos[$i], 104,8);
							$ivass = str_replace(" ", "", $ivass);
							$ivass = str_replace(",", "", $ivass);
							$total = substr($pos[$i], 120,12);
							$total = str_replace(" ", "", $total);
							$total = str_replace(",", "", $total);
							$fechaGood = $this->getDateMatriz($fecha);
							$new_factura = [
								"folio"		=>	$folio,
								"proveedor"	=>	$sucus,
								"fecha"		=>	$fecha,
								"subtotal"	=>	$subto,
								"siniva"	=>	$siniv,
								"iva"		=>	$ivass,
								"total"		=>	$total,
								"registro"	=>	$user["id_usuario"],
								"agrego"	=>	$agrego,
								"estatus"	=>	$estatus,
								"id_sucursal"=>$user["id_sucursal"],
								"provee"	=>	$nombresucu,
								"fecha_registro"=>$fechaGood
							];
							
							$this->db->query("UPDATE entradas SET estatus = 0 WHERE DATE(fecha_registro) = DATE('".$fechaGood."') AND id_sucursal = ".$user["id_sucursal"]." AND folio = '".$folio."'");
							/*$hayRemis = $this->remis_md->remisMatriz(NULL,[ "fecha"=>$fechaGood,"folio"=>$folio,"id_sucursal"=>$user["id_sucursal"] ]);
							if($hayRemis && $flag2 == 0){
								
							}*/
							$flag2 =1;
							$new_c = $this->remis_md->insert($new_factura);
							for ($ed=0; $ed < sizeof($new_detalle); $ed++){ 
							 	$new_detalle[$ed]["id_remision"] = $new_c;
								$this->dremis_md->insert($new_detalle[$ed]);
							}
							$new_detalle = [];
							
						}elseif( strpos($pos[$i],"Tot. devolucion") ){
							$this->db->query("UPDATE entradas SET estatus = 0 WHERE id_remision = ".$new_c." ");
						}else{
							$producto = substr($pos[$i], 22,17);
							$producto = str_replace(" ", "", $producto);
							$descripcion = substr($pos[$i], 40,33);
							$descripcion = str_replace("  ", "", $descripcion);
							$familia = substr($pos[$i], 19,2);
							$unidad = substr($pos[$i], 73,3);
							$cantidad = substr($pos[$i], 80,12);
							$cantidad = str_replace(" ", "", $cantidad);
							$cantidad = str_replace(",", "", $cantidad);
							$unitario = substr($pos[$i], 94,12);
							$unitario = str_replace(" ", "", $unitario);
							$unitario = str_replace(",", "", $unitario);
							$importe = substr($pos[$i], 120,12);
							$importe = str_replace(" ", "", $importe);
							$importe = str_replace(",", "", $importe);
							if($user["id_sucursal"] == 7){
								$id_pro = $this->prod_md->get(NULL,["codigo"=>$producto,"estatus"=>1]);
							}else{
								$id_pro = $this->sprod_md->get(NULL,["codigo"=>$producto,"id_sucursal"=>$user["id_sucursal"],"estatus"=>1]);
							}
							
							if($id_pro){
								$idesp = $id_pro[0]->id_producto;
								$idsic = $this->sprod_md->get(NULL,["id_producto"=>$idesp]);
								if($idsic){

								}else{
									$this->sprod_md->insert(["id_producto"=>$idesp,"codigo"=>"SINCODE","id_sucursal"=>7,"estatus"=>0,"registro"=>1,"code"=>"SINCODE","ums"=>1,"nombre"=>"SINCODE","id_prox"=>222]);
								}
							}else{
								$idesp = 2;
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
								"id_producto"	=>	$idesp
							];
							$flag ++;
						}
					}
				}
			}

			/*AJUSTES DE SALIDA*/
		}elseif( (strpos($dom,"AJU.SALIDAS")  ||  strpos($dom,"Total de salidas")) && (strpos($dom,"AJU.ENTRADAS")  ||  strpos($dom,"Total de entradas")) ){
			$filen = "aju".date("dmyHis")."".rand(1000,9999);
			$config['upload_path']          = './assets/uploads/ajustes/';
	        $config['allowed_types']        = '*';
	        $config['max_size']             = 40000;
	        $config['max_width']            = 40024;
	        $config['max_height']           = 40024;
	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);
	        $this->upload->do_upload('file_inventario',$filen);
	        $archi = "AJUSTES DE INVENTARIO ENTRADA Y SALIDA";


	        $path_parts = pathinfo($_FILES["file_inventario"]["name"]);
			$extension = $path_parts['extension'];

			
			$fecha = new DateTime(date('Y-m-d H:i:s'));
			$new_entrada = [
				"id_usuario"	=>	$user["id_usuario"],
				"fecha_registro"=>	$fecha->format('Y-m-d H:i:s'),
				"txtfile"		=>	$filen.".".$extension,
				"id_sucursal"	=>	$user["id_sucursal"],
			];

			//POR SI HABIA SUBIDO ALGUN OTRO

			$inventa = $this->sal_md->get(NULL,["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d')]);
			if($inventa){
				$ino = $this->sal_md->update(["estatus"=>0],["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d')]);
			}
			$ino = $this->sal_md->insert($new_entrada);
			$inventa = $this->ajtxt_md->get(NULL,["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d')]);
			if($inventa){
				$ino = $this->ajtxt_md->update(["estatus"=>0],["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d')]);
			}
			$ino = $this->ajtxt_md->insert($new_entrada);

			$cambios = [
				"id_usuario" => $user["id_usuario"],
				"fecha_cambio" => date('Y-m-d H:i:s'),
				"antes" => "Sube AJUSTES INVENTARIO txt",
				"despues" => $ino];
			$data['cambios'] = $this->cambio_md->insert($cambios);

			$ajsa = 1;
			
			$hayS = $this->ajsal_md->get(NULL,["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d'),"estatus"=>1]);
			if($hayS){
				$this->ajsal_md->update(["estatus"=>0],["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d'),"estatus"=>1]);
			}
			$hayS = $this->ajent_md->get(NULL,["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d'),"estatus"=>1]);
			if($hayS){
				$this->ajent_md->update(["estatus"=>0],["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d'),"estatus"=>1]);
			}

			$tipo = false;
			for ($i=0; $i<sizeof($pos); $i++){
				if (!empty($pos[$i])){
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("€", "P", $pos[$i]);
					$pos[$i] = str_replace("�", "P", $pos[$i]);
					$pos[$i] = str_replace("¥", "Ñ", $pos[$i]);
					$pos[$i] = str_replace("?", "Ñ", $pos[$i]);
					

					if(strpos($pos[$i],"cei-029f-2.6") && strlen($pos[$i]) < 200 ){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Notas de Entrada/Salida")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Descripcion")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Total de articulos")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"-----------")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Hoja : ") && strlen($pos[$i]) < 200){
						$pos[$i] = "";
					}
					if(strpos($pos[$i]," ") === false){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"I m p o r t e")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Referencia")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Cantidad")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Movimiento")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"FIN DE REPORTE")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Total de salidas")){
						$pos[$i] = "";
					}
					if (strlen($pos[$i]) < 10) {
						$pos[$i] = "";	
					}
					$fecha = new DateTime(date('Y-m-d H:i:s'));
					
					if(strpos($pos[$i],"AJU.SALIDAS")){
						$foli = substr($pos[$i], 9,6);
						$refe = substr($pos[$i], 16,11);
						$fech = substr($pos[$i], 61,9);
						$fechaGood = $this->getDateMatriz($fech);
						$new_salida = [
							"id_sucursal"	=>	$user["id_sucursal"],
							"folio"			=>	$foli,
							"fecha"			=>	$fech,
							"referencia"	=>	$refe,
							"fecha_registro"=>	$fechaGood
						];
						$this->db->query("UPDATE ajusalida SET estatus = 0 WHERE DATE(fecha_registro) = DATE('".$fechaGood."') AND id_sucursal = ".$user["id_sucursal"]." AND folio = '".$foli."'");
						$ajsa = $this->ajsal_md->insert($new_salida);
						$tipo = false;
					}elseif(strpos($pos[$i],"AJU.ENTRADAS")){
						$foli = substr($pos[$i], 9,6);
						$refe = substr($pos[$i], 16,11);
						$fech = substr($pos[$i], 61,9);
						$fechaGood = $this->getDateMatriz($fech);
						$new_salida = [
							"id_sucursal"	=>	$user["id_sucursal"],
							"folio"			=>	$foli,
							"fecha"			=>	$fech,
							"referencia"	=>	$refe,
							"fecha_registro"=>	$fechaGood
						];
						$this->db->query("UPDATE ajuentrada SET estatus = 0 WHERE DATE(fecha_registro) = DATE('".$fechaGood."') AND id_sucursal = ".$user["id_sucursal"]." AND folio = '".$foli."'");
						$ajsa = $this->ajent_md->insert($new_salida);
						$tipo = true;
					}elseif($pos[$i] <> ""){
						$code = substr($pos[$i], 6,17);
						$code = str_replace(" ", "", $code);
						$line = substr($pos[$i], 3,2);
						$desc = substr($pos[$i], 23,31);
						$desc = str_replace("  ", "", $desc);
						$unme = substr($pos[$i], 54,3);
						$cant = substr($pos[$i], 58,10);
						$cant = str_replace(" ", "", $cant);
						$cant = str_replace(",", "", $cant);
						$prec = substr($pos[$i], 69,10);
						$prec = str_replace(" ", "", $prec);
						$prec = str_replace(",", "", $prec);
						$impo = substr($pos[$i], 80,15);
						$impo = str_replace(" ", "", $impo);
						$impo = str_replace(",", "", $impo);
						if($user["id_sucursal"] == 7){
							$prodo = $this->prod_md->get(NULL,["codigo"=>$code]);
						}else{
							$prodo = $this->sprod_md->get(NULL,["codigo"=>$code,"id_sucursal"=>$user["id_sucursal"]]);
						}
						
						if($prodo){
							$prodo = $prodo[0]->id_producto;
							$idsic = $this->sprod_md->get(NULL,["id_producto"=>$prodo]);
							if($idsic){
								
							}else{
								$this->sprod_md->insert(["id_producto"=>$prodo,"codigo"=>"SINCODE","id_sucursal"=>7,"estatus"=>0,"registro"=>1,"code"=>"SINCODE","ums"=>1,"nombre"=>"SINCODE","id_prox"=>222]);
							}
						}else{
							$prodo = 2;
						}

						$new_desal = [
							"linea"			=>	$line,
							"code"			=>	$code,
							"descripcion"	=>	$desc,
							"unidad"		=>	$unme,
							"cantidad"		=>	$cant,
							"precio"		=>	$prec,
							"importe"		=>	$impo,
							"id_ajuste"		=>	$ajsa,
							"id_producto"	=>	$prodo
						];
						if($tipo){
							$this->dentr_md->insert($new_desal);
						}else{
							$this->dsali_md->insert($new_desal);
						}
						

					}
				}
			}

			/*AJUSTES DE ENTRADA*/
		}elseif( strpos($dom,"AJU.SALIDAS")  ||  strpos($dom,"Total de salidas") ){
			$filen = "sal".date("dmyHis")."".rand(1000,9999);
			$config['upload_path']          = './assets/uploads/ajustes/';
	        $config['allowed_types']        = '*';
	        $config['max_size']             = 40000;
	        $config['max_width']            = 40024;
	        $config['max_height']           = 40024;
	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);
	        $this->upload->do_upload('file_inventario',$filen);
	        $archi = "AJUSTES DE INVENTARIO SALIDAS";


	        $path_parts = pathinfo($_FILES["file_inventario"]["name"]);
			$extension = $path_parts['extension'];

			
			$fecha = new DateTime(date('Y-m-d H:i:s'));
			$new_entrada = [
				"id_usuario"	=>	$user["id_usuario"],
				"fecha_registro"=>	$fecha->format('Y-m-d H:i:s'),
				"txtfile"		=>	$filen.".".$extension,
				"id_sucursal"	=>	$user["id_sucursal"],
			];

			$inventa = $this->sal_md->get(NULL,["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d')]);
			if($inventa){
				$ino = $this->sal_md->update(["estatus"=>0],["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d')]);
			}
			$ino = $this->sal_md->insert($new_entrada);
			$cambios = [
				"id_usuario" => $user["id_usuario"],
				"fecha_cambio" => date('Y-m-d H:i:s'),
				"antes" => "Sube AJUSTES SALIDA txt",
				"despues" => $ino];
			$data['cambios'] = $this->cambio_md->insert($cambios);

			$ajsa = 1;
			$linea = 0;$flag2 = 0;$flag =0;
			$hayS = $this->ajsal_md->get(NULL,["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d'),"estatus"=>1]);
			if($hayS){
				$this->ajsal_md->update(["estatus"=>0],["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d'),"estatus"=>1]);
			}
			for ($i=0; $i<sizeof($pos); $i++){
				if (!empty($pos[$i])){
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("€", "P", $pos[$i]);
					$pos[$i] = str_replace("�", "P", $pos[$i]);
					$pos[$i] = str_replace("¥", "Ñ", $pos[$i]);
					$pos[$i] = str_replace("?", "Ñ", $pos[$i]);
					

					if(strpos($pos[$i],"cei-029f-2.6") && strlen($pos[$i]) < 200 ){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Notas de Entrada/Salida")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Descripcion")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Total de articulos")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"-----------")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Hoja : ") && strlen($pos[$i]) < 200){
						$pos[$i] = "";
					}
					if(strpos($pos[$i]," ") === false){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"I m p o r t e")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Referencia")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Cantidad")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Movimiento")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"FIN DE REPORTE")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Total de salidas")){
						$pos[$i] = "";
					}
					if (strlen($pos[$i]) < 10) {
						$pos[$i] = "";	
					}
					$fecha = new DateTime(date('Y-m-d H:i:s'));
					
					if(strpos($pos[$i],"AJU.SALIDAS") || strpos($pos[$i],"ALMACEN GENERAL")){
						$foli = substr($pos[$i], 9,6);
						$refe = substr($pos[$i], 16,11);
						$fech = substr($pos[$i], 61,9);
						
						$new_salida = [
							"id_sucursal"	=>	$user["id_sucursal"],
							"folio"			=>	$foli,
							"fecha"			=>	$fech,
							"referencia"	=>	$refe,
						];
						$fechaGood = $this->getDateMatriz($fech);
						$this->db->query("UPDATE ajusalida SET estatus = 0 WHERE DATE(fecha_registro) = DATE('".$fechaGood."') AND id_sucursal = ".$user["id_sucursal"]." AND folio = '".$foli."'");
						$ajsa = $this->ajsal_md->insert($new_salida);
					}elseif($pos[$i] <> ""){
						$code = substr($pos[$i], 6,17);
						$code = str_replace(" ", "", $code);
						$line = substr($pos[$i], 3,2);
						$desc = substr($pos[$i], 23,31);
						$desc = str_replace("  ", "", $desc);
						$unme = substr($pos[$i], 54,3);
						$cant = substr($pos[$i], 58,10);
						$cant = str_replace(" ", "", $cant);
						$cant = str_replace(",", "", $cant);
						$prec = substr($pos[$i], 69,10);
						$prec = str_replace(" ", "", $prec);
						$prec = str_replace(",", "", $prec);
						$impo = substr($pos[$i], 80,15);
						$impo = str_replace(" ", "", $impo);
						$impo = str_replace(",", "", $impo);
						if($user["id_sucursal"] == 7){
							$prodo = $this->prod_md->get(NULL,["codigo"=>$code]);
						}else{
							$prodo = $this->sprod_md->get(NULL,["codigo"=>$code,"id_sucursal"=>$user["id_sucursal"]]);
						}
						
						if($prodo){
							$prodo = $prodo[0]->id_producto;
						}else{
							$prodo = 2;
						}

						$new_desal = [
							"linea"			=>	$line,
							"code"			=>	$code,
							"descripcion"	=>	$desc,
							"unidad"		=>	$unme,
							"cantidad"		=>	$cant,
							"precio"		=>	$prec,
							"importe"		=>	$impo,
							"id_ajuste"		=>	$ajsa,
							"id_producto"	=>	$prodo
						];
						$this->dsali_md->insert($new_desal);

					}
				}
			}

			/*AJUSTES DE ENTRADA*/
		}elseif( strpos($dom,"AJU.ENTRADAS")  ||  strpos($dom,"Total de entradas") ){
			$filen = "ent".date("dmyHis")."".rand(1000,9999);
			$config['upload_path']          = './assets/uploads/ajustes/';
	        $config['allowed_types']        = '*';
	        $config['max_size']             = 40000;
	        $config['max_width']            = 40024;
	        $config['max_height']           = 40024;
	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);
	        $this->upload->do_upload('file_inventario',$filen);
	        $archi = "AJUSTES DE INVENTARIO ENTRADA";


	        $path_parts = pathinfo($_FILES["file_inventario"]["name"]);
			$extension = $path_parts['extension'];

			
			$fecha = new DateTime(date('Y-m-d H:i:s'));
			$new_entrada = [
				"id_usuario"	=>	$user["id_usuario"],
				"fecha_registro"=>	$fecha->format('Y-m-d H:i:s'),
				"txtfile"		=>	$filen.".".$extension,
				"id_sucursal"	=>	$user["id_sucursal"],
			];

			$inventa = $this->ajtxt_md->get(NULL,["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d')]);
			if($inventa){
				$ino = $this->ajtxt_md->update(["estatus"=>0],["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d')]);
			}
			$ino = $this->ajtxt_md->insert($new_entrada);
			$cambios = [
				"id_usuario" => $user["id_usuario"],
				"fecha_cambio" => date('Y-m-d H:i:s'),
				"antes" => "Sube AJUSTE ENTRADAS txt",
				"despues" => $ino];
			$data['cambios'] = $this->cambio_md->insert($cambios);

			$ajsa = 1;
			$linea = 0;$flag2 = 0;$flag =0;
			$hayS = $this->ajent_md->get(NULL,["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d'),"estatus"=>1]);
			if($hayS){
				$this->ajent_md->update(["estatus"=>0],["id_sucursal"=>$user["id_sucursal"],"DATE(fecha_registro)"=>$fecha->format('Y-m-d'),"estatus"=>1]);
			}
			for ($i=0; $i<sizeof($pos); $i++){
				if (!empty($pos[$i])){
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("€", "P", $pos[$i]);
					$pos[$i] = str_replace("�", "P", $pos[$i]);
					$pos[$i] = str_replace("¥", "Ñ", $pos[$i]);
					$pos[$i] = str_replace("?", "Ñ", $pos[$i]);
					

					if(strpos($pos[$i],"cei-029f-2.6") && strlen($pos[$i]) < 200 ){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Notas de Entrada/Salida")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Descripcion")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Total de articulos")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"-----------")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Hoja : ") && strlen($pos[$i]) < 200){
						$pos[$i] = "";
					}
					if(strpos($pos[$i]," ") === false){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"I m p o r t e")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Referencia")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Cantidad")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Movimiento")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"FIN DE REPORTE")){
						$pos[$i] = "";
					}
					if(strpos($pos[$i],"Total de salidas")){
						$pos[$i] = "";
					}
					if (strlen($pos[$i]) < 10) {
						$pos[$i] = "";	
					}
					$fecha = new DateTime(date('Y-m-d H:i:s'));
					
					if(strpos($pos[$i],"AJU.ENTRADAS") || strpos($pos[$i],"ALMACEN GENERAL")){
						$foli = substr($pos[$i], 9,6);
						$refe = substr($pos[$i], 16,11);
						$fech = substr($pos[$i], 61,9);
						
						$new_salida = [
							"id_sucursal"	=>	$user["id_sucursal"],
							"folio"			=>	$foli,
							"fecha"			=>	$fech,
							"referencia"	=>	$refe,
						];
						$fechaGood = $this->getDateMatriz($fech);
						$this->db->query("UPDATE ajuentrada SET estatus = 0 WHERE DATE(fecha_registro) = DATE('".$fechaGood."') AND id_sucursal = ".$user["id_sucursal"]." AND folio = '".$foli."'");
						$ajsa = $this->ajent_md->insert($new_salida);
					}elseif($pos[$i] <> ""){
						$code = substr($pos[$i], 6,17);
						$code = str_replace(" ", "", $code);
						$line = substr($pos[$i], 3,2);
						$desc = substr($pos[$i], 23,31);
						$desc = str_replace("  ", "", $desc);
						$unme = substr($pos[$i], 54,3);
						$cant = substr($pos[$i], 58,10);
						$cant = str_replace(" ", "", $cant);
						$cant = str_replace(",", "", $cant);
						$prec = substr($pos[$i], 69,10);
						$prec = str_replace(" ", "", $prec);
						$prec = str_replace(",", "", $prec);
						$impo = substr($pos[$i], 80,15);
						$impo = str_replace(" ", "", $impo);
						$impo = str_replace(",", "", $impo);
						if($user["id_sucursal"] == 7){
							$prodo = $this->prod_md->get(NULL,["codigo"=>$code]);
						}else{
							$prodo = $this->sprod_md->get(NULL,["codigo"=>$code,"id_sucursal"=>$user["id_sucursal"]]);
						}
						
						if($prodo){
							$prodo = $prodo[0]->id_producto;
						}else{
							$prodo = 2;
						}

						$new_desal = [
							"linea"			=>	$line,
							"code"			=>	$code,
							"descripcion"	=>	$desc,
							"unidad"		=>	$unme,
							"cantidad"		=>	$cant,
							"precio"		=>	$prec,
							"importe"		=>	$impo,
							"id_ajuste"		=>	$ajsa,
							"id_producto"	=>	$prodo
						];
						$this->dentr_md->insert($new_desal);

					}
				}
			}
		}elseif( strpos($dom,"LISTA DE PRECIOS CON EXISTENCIA") ){
			$archi = "MATRICIAL";
			for ($i=0; $i<sizeof($pos); $i++){
				if (!empty($pos[$i])){
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
					$pos[$i] = str_replace("", "", $pos[$i]);
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


							if($user["id_sucursal"] == 7){
								
								$producto = $this->prod_md->get(NULL,["codigo"=>$code1]);

								if($producto){
									$id_producto = $producto[0]->id_producto;
								}else{
									$id_producto = 222;
								}

								$new_existencia=[
									"id_producto"	=>	$id_producto,
									"existencia"	=>	$existencia,
									"fecha_registro"=>	date("Y-m-d H:i:s")
								];

								$existencia = $this->exced_md->get(NULL,[ "id_producto"=>$id_producto,"DATE(fecha_registro)"=>date("Y-m-d") ]);

								if($existencia){
									$id_existencia = $this->exced_md->update(["estatus"=>0],["id_producto"=>$id_producto]);
								}
								$id_existencia = $this->exced_md->insert($new_existencia);
								
							}else{
								

								$producto = $this->sprod_md->get(NULL,["codigo"=>$code1,"id_sucursal"=>$user["id_sucursal"]]);

								if($producto){
									$id_producto = $producto[0]->id_producto;
								}else{
									$id_producto = 2;
								}

								$new_existencia=[
									"id_producto"	=>	$id_producto,
									"existencia"	=>	$existencia,
									"fecha_registro"=>	date("Y-m-d H:i:s")
								];

								$existencia = $this->exis_md->get(NULL,[ "id_producto"=>$id_producto,"DATE(fecha_registro)"=>date("Y-m-d")]);

								if($existencia){
									$id_existencia = $this->exis_md->update(["estatus"=>0],["id_producto"=>$id_producto]);
								}
								$id_existencia = $this->exis_md->insert($new_existencia);
								
							}
							
						}
					}
				}
			}
			
			$mensaje=[	"id"	=>	'Éxito',
						"desc"	=>	'Datos cargados correctamente en el Sistema',
						"type"	=>	'success'];
		}

 
		$this->jsonResponse($archi);
	}


	public function getDateMatriz($stronzo){
		$fecha = new DateTime(date('Y-m-d H:i:s'));
		$stronzo = str_replace("Ene", "01", $stronzo);
		$stronzo = str_replace("Feb", "02", $stronzo);
		$stronzo = str_replace("Mar", "03", $stronzo);
		$stronzo = str_replace("Abr", "04", $stronzo);
		$stronzo = str_replace("May", "05", $stronzo);
		$stronzo = str_replace("Jun", "06", $stronzo);
		$stronzo = str_replace("Jul", "07", $stronzo);
		$stronzo = str_replace("Ago", "08", $stronzo);
		$stronzo = str_replace("Sep", "09", $stronzo);
		$stronzo = str_replace("Oct", "10", $stronzo);
		$stronzo = str_replace("Nov", "11", $stronzo);
		$stronzo = str_replace("Dic", "12", $stronzo);
		$good = "20".substr($stronzo,6,2)."-".substr($stronzo,3,2)."-".substr($stronzo, 0,2)." ".$fecha->format('H:i:s');
		
		return $good;
	}

} 