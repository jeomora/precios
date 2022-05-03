<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entradas extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Cambios_model", "cambio_md");
		$this->load->model("EntTxt_model", "ent_md");
		$this->load->model("Entradas_model", "remis_md");
		$this->load->model("Sucproductos_model", "sprod_md");
		$this->load->model("Detalleremis_model", "dremis_md");
		$this->load->library("form_validation");
	}


	public function subeEntrada(){
		ini_set("memory_limit", -1);
		$user = $this->session->userdata();
		$filen = "ent".date("dmyHis")."".rand(1000,9999);
		$config['upload_path']          = './assets/img/entradas/';
        $config['allowed_types']        = '*';
        $config['max_size']             = 40000;
        $config['max_width']            = 40024;
        $config['max_height']           = 40024;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
        $this->upload->do_upload('file_inventario',$filen);
        $path_parts = pathinfo($_FILES["file_inventario"]["name"]);
		$extension = $path_parts['extension'];

		$user = $this->session->userdata();
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


		///ALMACENANDO LOS DATOS

		$dom = file_get_contents($_FILES["file_inventario"]["tmp_name"]); 
		$articulos = [];
		$flag = 0;
		$flagNo = 1;
		$pos = explode("\n", $dom);
		$folio = "";

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
							"provee"	=>	$nombresucu
						];
						
						$hayRemis = $this->remis_md->hayRemisiones(NULL,["id_sucursal"=>$user["id_sucursal"]]);
						if($hayRemis && $flag2 == 0){
							$this->db->query("UPDATE remisiones SET estatus = 0 WHERE DATE(fecha_registro) = DATE(CURDATE()) AND id_sucursal = ".$user["id_sucursal"]." ");
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

						$id_pro = $this->sprod_md->get(NULL,["codigo"=>$producto,"id_sucursal"=>$user["id_sucursal"],"estatus"=>1]);
						if($id_pro){
							$idesp = $id_pro[0]->id_producto;
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
 
		$this->jsonResponse($filen.".".$extension);
	}

} 