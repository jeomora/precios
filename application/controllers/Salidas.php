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

	public function printFormato(){
		ini_set("memory_limit", "-1");
		$user = $this->session->userdata();
		ini_set("max_execution_time", "-1");
		$this->load->library("excelfile");
		$hoja = $this->excelfile->setActiveSheetIndex(0);
		$this->excelfile->setActiveSheetIndex(0)->setTitle("REPORTE");
        
		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_THIN
		    )
		  ),
		  'alignment' => array(
		       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		   ) 
		);
		$styleArrayR = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_MEDIUM
		    )
		  ),
		  'alignment' => array(
		       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
		       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		   ) 
		);
		$styleArrayL = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_MEDIUM
		    )
		  ),
		  'alignment' => array(
		       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
		       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		   ) 
		);
		$hoja = $this->excelfile->getActiveSheet();

		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$day = date('w');
		$hoja->mergeCells('A1:E2');
		$this->cellStyle("A1:E2", "FFC000", "000000", FALSE, 11, "Calibri");

		$hoja->mergeCells('A3:E4');
		$hoja->setCellValue("A3", "FORMATO GENERAL")->getColumnDimension('A')->setWidth(45);
		$this->excelfile->getActiveSheet()->getRowDimension('3')->setRowHeight(65);
		$this->excelfile->getActiveSheet()->getStyle('A3:E3')->applyFromArray($styleArray);		
		$this->cellStyle("A3:E4", "00B0F0", "FFFFFF", FALSE, 48, "Algerian");


		$hoja->mergeCells('A5:E5');
		$hoja->setCellValue("A5", $fecha)->getColumnDimension('E')->setWidth(20);
		$this->excelfile->getActiveSheet()->getStyle('A5:E5')->applyFromArray($styleArrayR);
		$this->cellStyle("A5:E5", "FFFF00", "203764", TRUE, 16, "Calibri");
		$this->excelfile->getActiveSheet()->getStyle('A5')->applyFromArray($styleArrayR);

		$hoja->mergeCells('A6:D6');
		$this->cellStyle("A6:D6", "FF9900", "000000", FALSE, 11, "Calibri");

		$hoja->mergeCells('A7:D7');
		$hoja->setCellValue("A7", "SUCURSALES (A)");
		$this->excelfile->getActiveSheet()->getStyle('A7:E7')->applyFromArray($styleArray);
		$this->cellStyle("A7:D7", "FFFF00", "203764", FALSE, 12, "Cooper Black");

		$hoja->setCellValue("A8", "SUCURSAL");
		$hoja->setCellValue("B8", "FRUTA")->getColumnDimension('B')->setWidth(20);
		$hoja->setCellValue("C8", "VERDURA")->getColumnDimension('C')->setWidth(20);
		$hoja->setCellValue("D8", "ABARROTE")->getColumnDimension('D')->setWidth(20);
		$this->excelfile->getActiveSheet()->getStyle('A8')->applyFromArray($styleArray);
		$this->excelfile->getActiveSheet()->getStyle('B8')->applyFromArray($styleArray);
		$this->excelfile->getActiveSheet()->getStyle('C8')->applyFromArray($styleArray);
		$this->excelfile->getActiveSheet()->getStyle('D8')->applyFromArray($styleArray);
		$this->cellStyle("A8:D8", "FF9900", "203764", TRUE, 16, "Algerian");

		$hoja->mergeCells('E6:E8');
		$hoja->setCellValue("E6", "TOTAL");
		$this->excelfile->getActiveSheet()->getStyle('E6:E8')->applyFromArray($styleArray);
		$this->cellStyle("E6:E8", "00B0F0", "203764", TRUE, 20, "Bauhaus 93");


		$cotizHoy = $this->cotiz_md->getCotizacionesHoy(NULL);
		$flag = 9;$flagA = 0;$flagA1 = 0;$sumb  = "";$sumc  = "";$sumd  = "";$sume  = "";
		if($cotizHoy){
			foreach ($cotizHoy as $key => $value) {
				if($value->tipo == 2 && $flagA == 0){
					$flagA = 1;
					$hoja->mergeCells('A'.$flag.':E'.$flag);
					$this->cellStyle("A{$flag}:E{$flag}", "FFC000", "000000", FALSE, 11, "Calibri");
					$flag++;
					$hoja->mergeCells('A'.$flag.':E'.$flag);
					$hoja->setCellValue("A{$flag}", "SUCURSALES (B)");
					$this->excelfile->getActiveSheet()->getStyle('A'.$flag.':E'.$flag)->applyFromArray($styleArray);
					$this->cellStyle("A{$flag}:E{$flag}", "FFFF00", "203764", FALSE, 12, "Cooper Black");
					$flag++;
				}elseif($value->tipo == 3 && $flagA1 == 0){
					$flagA1 = 1;
					$hoja->mergeCells('A'.$flag.':E'.$flag);
					$this->cellStyle("A{$flag}:E{$flag}", "FFC000", "000000", FALSE, 11, "Calibri");
					$flag++;
					$hoja->mergeCells('A'.$flag.':E'.$flag);
					$hoja->setCellValue("A{$flag}", "OTROS CLIENTES");
					$this->excelfile->getActiveSheet()->getStyle('A'.$flag.':E'.$flag)->applyFromArray($styleArray);
					$this->cellStyle("A{$flag}:E{$flag}", "FFFF00", "203764", FALSE, 12, "Cooper Black");
					$flag++;
				}

				$hoja->setCellValue("A{$flag}", $value->nombre);
				$this->cellStyle("A{$flag}", "00B0F0", "203764", TRUE, 11, "Arial Black");
				$this->excelfile->getActiveSheet()->getStyle('A'.$flag)->applyFromArray($styleArrayL);

				$hoja->setCellValue("B{$flag}", $this->isZerote($value->totafru));
				$hoja->setCellValue("C{$flag}", $this->isZerote($value->totaver));
				$hoja->setCellValue("D{$flag}", $this->isZerote($value->totabar + $value->totis));
				$this->cellStyle("B{$flag}:D{$flag}", "FFFFFF", "000000", TRUE, 11, "Arial Black");
				$this->excelfile->getActiveSheet()->getStyle('B'.$flag.':D'.$flag)->applyFromArray($styleArrayR);

				$hoja->setCellValue("E{$flag}", "=SUM(B{$flag}:D{$flag})");				
				$this->cellStyle("E{$flag}", "9BC2E6", "000000", TRUE, 11, "Arial Black");
				$this->excelfile->getActiveSheet()->getStyle('E'.$flag)->applyFromArray($styleArrayR);

				$this->excelfile->getActiveSheet()->getStyle("B".$flag.":E".$flag)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
				$sumb  .= "+B".$flag;$sumc  .= "+C".$flag;$sumd  .= "+D".$flag;$sume  .= "+E".$flag;
				$flag++;
				
			}

			$hoja->mergeCells('A'.$flag.':E'.$flag);
			$this->cellStyle("A{$flag}:E{$flag}", "FFC000", "000000", FALSE, 11, "Calibri");
			$flag++;

			$hoja->setCellValue("A{$flag}", "TOTAL");
			$this->cellStyle("A{$flag}", "00B0F0", "203764", FALSE, 12, "Arial Black");
			$this->excelfile->getActiveSheet()->getStyle('A'.$flag)->applyFromArray($styleArrayL);

			$hoja->setCellValue("B{$flag}", "=".$sumb);
			$hoja->setCellValue("C{$flag}", "=".$sumc);
			$hoja->setCellValue("D{$flag}", "=".$sumd);
			$this->cellStyle("B{$flag}:D{$flag}", "FFFF00", "203764", FALSE, 12, "Arial Black");
			$this->excelfile->getActiveSheet()->getStyle('B'.$flag.':D'.$flag)->applyFromArray($styleArrayR);

			$hoja->setCellValue("E{$flag}", "=".$sume);			
			$this->cellStyle("E{$flag}", "FFFF00", "203764", TRUE, 11, "Arial Black");
			$this->excelfile->getActiveSheet()->getStyle('E'.$flag)->applyFromArray($styleArrayR);
			$this->excelfile->getActiveSheet()->getStyle("B".$flag.":E".$flag)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
			$flag++;

			$this->excelfile->getActiveSheet()->getStyle("B".$flag.":B".$flag)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
			$hoja->setCellValue("A{$flag}", "TOTAL FRUTA");
			$this->cellStyle("A{$flag}", "00B0F0", "203764", FALSE, 12, "Arial Black");
			$this->excelfile->getActiveSheet()->getStyle('A'.$flag)->applyFromArray($styleArrayL);
			$hoja->setCellValue("B{$flag}", "=B".($flag-1)."");
			$this->cellStyle("B{$flag}", "FFFF00", "203764", TRUE, 11, "Arial Black");
			$this->excelfile->getActiveSheet()->getStyle('B'.$flag)->applyFromArray($styleArrayR);
			$flag++;

			$this->excelfile->getActiveSheet()->getStyle("B".$flag.":B".$flag)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
			$hoja->setCellValue("A{$flag}", "TOTAL VERDURA");
			$this->cellStyle("A{$flag}", "00B0F0", "203764", FALSE, 12, "Arial Black");
			$this->excelfile->getActiveSheet()->getStyle('A'.$flag)->applyFromArray($styleArrayL);
			$hoja->setCellValue("B{$flag}", "=C".($flag-2)."");			
			$this->cellStyle("B{$flag}", "FFFF00", "203764", TRUE, 11, "Arial Black");
			$this->excelfile->getActiveSheet()->getStyle('B'.$flag)->applyFromArray($styleArrayR);
			$flag++;

			$this->excelfile->getActiveSheet()->getStyle("B".$flag.":B".$flag)->getNumberFormat()->setFormatCode("_(\"$\"* #,##0.00_);_(\"$\"* \(#,##0.00\);_(\"$\"* \"-\"??_);_(@_)");
			$hoja->setCellValue("A{$flag}", "TOTAL ABARROTE");			
			$this->cellStyle("A{$flag}", "00B0F0", "203764", FALSE, 12, "Arial Black");
			$this->excelfile->getActiveSheet()->getStyle('A'.$flag)->applyFromArray($styleArrayL);
			$hoja->setCellValue("B{$flag}", "=D".($flag-3)."");
			$this->cellStyle("B{$flag}", "FFFF00", "203764", TRUE, 11, "Arial Black");
			$this->excelfile->getActiveSheet()->getStyle('B'.$flag)->applyFromArray($styleArrayR);
			$flag++;

		}


		$file_name = "FORMATO GENERAL.xlsx"; //Nombre del documento con extención
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment;filename=".$file_name);
		header("Cache-Control: max-age=0");
		$excel_Writer = PHPExcel_IOFactory::createWriter($this->excelfile, "Excel2007");
		$excel_Writer->save("php://output");
		$this->jsonResponse($cotizHoy);

		
	}

	public function isZerote($number){
		if($number == "" || $number == NULL){
			return 0;
		}else{
			return $number;
		}
	}


}
