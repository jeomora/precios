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


					$mensaje = "Archivo valido 1";
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


					$mensaje = "Archivo valido 2";
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


					$mensaje = "Archivo valido 3";

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

	public function plantilla(){
		ini_set("memory_limit", "-1");
		ini_set("max_execution_time", "-1");
		$this->load->library("excelfile");
		$hoja = $this->excelfile->setActiveSheetIndex(0);
		$this->excelfile->setActiveSheetIndex(0)->setTitle("CAMBIOS");
		$this->excelfile->createSheet();
        $hoja1 = $this->excelfile->setActiveSheetIndex(1)->setTitle("PRODUCTOS");
        
        $this->excelfile->setActiveSheetIndex(1);

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

		$noProds = 0;
		
		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;

		$rws = 1;
		$rws2 = 0;
		$prods = $this->prod_md->getPlantilla(NULL);
		//$this->jsonResponse($prods);
		$hoja->mergeCells('A'.$rws.':H'.$rws);
		$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':H'.$rws)->applyFromArray($styleArray);
		$this->cellStyle('A'.$rws.':H'.$rws, "99E993", "000000", TRUE, 16, "Franklin Gothic Book");
		$hoja->setCellValue("A{$rws}", "PRODUCTOS AL DÍA ".$fecha);
		$rws++;
		$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':H'.$rws)->applyFromArray($styleArray);
		$this->cellStyle('A'.$rws.':H'.$rws, "99E993", "000000", TRUE, 12, "Franklin Gothic Book");
		$hoja->setCellValue("A{$rws}", "CÓDIGO")->getColumnDimension('A')->setWidth(25);
		$hoja->setCellValue("B{$rws}", "DESCRIPCIÓN")->getColumnDimension('B')->setWidth(35);
		$hoja->setCellValue("C{$rws}", "U.M.")->getColumnDimension('C')->setWidth(18);
		$hoja->setCellValue("D{$rws}", "PRECIO 1")->getColumnDimension('D')->setWidth(20);
		$hoja->setCellValue("E{$rws}", "PRECIO 2")->getColumnDimension('E')->setWidth(20);
		$hoja->setCellValue("F{$rws}", "PRECIO 3")->getColumnDimension('F')->setWidth(20);
		$hoja->setCellValue("G{$rws}", "PRECIO 4")->getColumnDimension('G')->setWidth(20);
		$hoja->setCellValue("H{$rws}", "PRECIO 5")->getColumnDimension('H')->setWidth(20);
		$rws++;
		$lin = "";
		if ($prods) {
			foreach($prods as $key => $value){
				if ($lin <> $value->linea) {
					$lin = $value->linea;
					$hoja->mergeCells('A'.$rws.':H'.$rws);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':H'.$rws)->applyFromArray($styleArray);
					$this->cellStyle('A'.$rws.':H'.$rws, "000000", "FFFFFF", TRUE, 16, "Franklin Gothic Book");
					$hoja->setCellValue("A{$rws}", $value->linea);
					$rws++;
				}
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':H'.$rws)->applyFromArray($styleArray);
				$this->cellStyle('A'.$rws.':H'.$rws, "FFFFFF", "000000", FALSE, 12, "Franklin Gothic Book");
				$hoja->setCellValue("A{$rws}", $value->codigo)->getColumnDimension('A')->setWidth(25);
				$hoja->setCellValue("B{$rws}", $value->nombre)->getColumnDimension('B')->setWidth(50);
				$hoja->setCellValue("C{$rws}", $value->uns)->getColumnDimension('C')->setWidth(18);
				$hoja->setCellValue("D{$rws}", $value->preciouno)->getColumnDimension('D')->setWidth(20);
				$hoja->setCellValue("E{$rws}", $value->preciodos)->getColumnDimension('E')->setWidth(20);
				$hoja->setCellValue("F{$rws}", $value->preciotres)->getColumnDimension('F')->setWidth(20);
				$hoja->setCellValue("G{$rws}", $value->preciocuatro)->getColumnDimension('G')->setWidth(20);
				$hoja->setCellValue("H{$rws}", $value->preciocinco)->getColumnDimension('H')->setWidth(20);
				$rws++;
			}
		}
		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$file_name = "AJUSTE DE PRECIOS ".$fecha.".xlsx"; //Nombre del documento con extención
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment;filename=".$file_name);
		header("Cache-Control: max-age=0");
		$excel_Writer = PHPExcel_IOFactory::createWriter($this->excelfile, "Excel2007");
		$excel_Writer->save("php://output");
	}

	public function plantillaSin(){
		ini_set("memory_limit", "-1");
		ini_set("max_execution_time", "-1");
		$this->load->library("excelfile");
		$hoja = $this->excelfile->setActiveSheetIndex(0);
		$this->excelfile->setActiveSheetIndex(0)->setTitle("CAMBIOS");
		$this->excelfile->createSheet();
        $hoja1 = $this->excelfile->setActiveSheetIndex(1)->setTitle("PRODUCTOS");
        
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
		$rws = 1;
		$rws2 = 1;

		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;

		$hoja1 = $this->excelfile->getActiveSheet();
		$hoja1->mergeCells('A'.$rws2.':D'.$rws2);
		$this->excelfile->getActiveSheet()->getStyle('A'.$rws2.':D'.$rws2)->applyFromArray($styleArray);
		$this->cellStyle('A'.$rws2.':D'.$rws2, "44546A", "FFFFFF", TRUE, 18, "Bahnschrift");
		$hoja1->setCellValue("A{$rws2}", "AJUSTE DE PRECIOS ".$fecha);
		$rws2++;
		$this->excelfile->getActiveSheet()->getStyle('A'.$rws2.':D'.$rws2)->applyFromArray($styleArray);
		$this->cellStyle('A'.$rws2.':D'.$rws2, "44546A", "FFFFFF", TRUE, 18, "Bahnschrift");
		$hoja1->setCellValue("A{$rws2}", "CÓDIGO")->getColumnDimension('A')->setWidth(25);
		$hoja1->setCellValue("B{$rws2}", "DESCRIPCIÓN")->getColumnDimension('B')->setWidth(50);
		$hoja1->setCellValue("C{$rws2}", "PRECIO")->getColumnDimension('C')->setWidth(18);
		$hoja1->setCellValue("D{$rws2}", "PRECIO 5")->getColumnDimension('D')->setWidth(18);

		
		$this->excelfile->setActiveSheetIndex(1);
		$hoja = $this->excelfile->getActiveSheet();
		$noProds = 0;
		
		

		$prods = $this->prod_md->getPlantilla(NULL);
		//$this->jsonResponse($prods);
		$hoja->mergeCells('A'.$rws.':D'.$rws);
		$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':D'.$rws)->applyFromArray($styleArray);
		$this->cellStyle('A'.$rws.':D'.$rws, "99E993", "000000", TRUE, 16, "Franklin Gothic Book");
		$hoja->setCellValue("A{$rws}", "PRODUCTOS AL DÍA ".$fecha);
		$rws++;
		$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':D'.$rws)->applyFromArray($styleArray);
		$this->cellStyle('A'.$rws.':D'.$rws, "99E993", "000000", TRUE, 12, "Franklin Gothic Book");
		$hoja->setCellValue("A{$rws}", "CÓDIGO")->getColumnDimension('A')->setWidth(25);
		$hoja->setCellValue("B{$rws}", "DESCRIPCIÓN")->getColumnDimension('B')->setWidth(35);
		$hoja->setCellValue("C{$rws}", "U.M.")->getColumnDimension('C')->setWidth(18);
		$hoja1->setCellValue("D{$rws}", "PRECIO 5")->getColumnDimension('D')->setWidth(18);
	
		$rws++;
		$lin = "";
		if ($prods) {
			foreach($prods as $key => $value){
				if ($lin <> $value->linea) {
					$lin = $value->linea;
					$hoja->mergeCells('A'.$rws.':D'.$rws);
					$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':D'.$rws)->applyFromArray($styleArray);
					$this->cellStyle('A'.$rws.':D'.$rws, "000000", "FFFFFF", TRUE, 16, "Franklin Gothic Book");
					$hoja->setCellValue("A{$rws}", $value->linea);
					$rws++;
				}
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':D'.$rws)->applyFromArray($styleArray);
				$this->cellStyle('A'.$rws.':D'.$rws, "FFFFFF", "000000", FALSE, 12, "Franklin Gothic Book");
				$hoja->setCellValue("A{$rws}", $value->codigo);
				$hoja->setCellValue("B{$rws}", $value->nombre);
				$hoja->setCellValue("C{$rws}", $value->uns);
				$hoja->setCellValue("D{$rws}", $value->preciocinco);
				$rws++;
			}
		}
		$this->excelfile->setActiveSheetIndex(0);
		for ($i=3; $i <= 100; $i++) { 
			$this->excelfile->getActiveSheet()->getStyle('A'.$i.':D'.$i)->applyFromArray($styleArray);
			$this->cellStyle('A'.$i.':D'.$i, "FFFFFF", "000000", FALSE, 12, "Franklin Gothic Book");
			$hoja1->setCellValue("B{$i}", "=VLOOKUP(A".$i.",PRODUCTOS!A4:C".$rws.",2,FALSE)");
			$hoja1->setCellValue("D{$i}", "=VLOOKUP(A".$i.",PRODUCTOS!A4:D".$rws.",4,FALSE)");
		}
		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$file_name = "AJUSTE DE PRECIOS ".$fecha.".xlsx"; //Nombre del documento con extención
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment;filename=".$file_name);
		header("Cache-Control: max-age=0");
		$excel_Writer = PHPExcel_IOFactory::createWriter($this->excelfile, "Excel2007");
		$excel_Writer->save("php://output");
	}
}