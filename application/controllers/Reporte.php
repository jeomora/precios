<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model("Lineas_model","ln_md");
		$this->load->model("Detalleentra_model","dentr_md");
		$this->load->library("form_validation");
	}

	public function index(){
		$data['scripts'] = [
			'/scripts/Reporte/index',
		];
		$data["lineas"] = $this->ln_md->get(NULL,["estatus"=>1]);
		$this->estructura("Reporte/index", $data);
	}

	public function getMerma(){
		$valo = $this->input->post("values");
		$merma = $this->dentr_md->getMerma(NULL,$valo);
		$this->jsonResponse($merma);
	}

	public function downExcel(){
		
		$ini = $this->input->post('rangeFecha');
		$inicio = substr($ini, 6,4)."-".substr($ini, 0,2)."-".substr($ini, 3,2);
		$finale = substr($ini, 19,4)."-".substr($ini, 13,2)."-".substr($ini, 16,2);
		$lineas = $this->input->post('selectLinea');
		
		$merma = $this->dentr_md->getMermaExcel(NULL,$inicio,$finale,$lineas);
		//$this->jsonResponse($merma)	;
		ini_set("memory_limit", "-1");
		ini_set("max_execution_time", "-1");
		$this->load->library("excelfile");
		$hoja = $this->excelfile->setActiveSheetIndex(0);
		$this->excelfile->setActiveSheetIndex(0)->setTitle("REPORTE");
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
		$rws = 1;

		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;


		if(1==1){
			$hoja->mergeCells('A'.$rws.':E'.$rws);
			$this->cellStyle('A'.$rws, "000000", "FFFFFF", TRUE, 16, "Calibri");
			$hoja->setCellValue("A{$rws}", "DETALLES DEL PRODUCTO");
			$hoja->mergeCells('F'.$rws.':N'.$rws);
			$this->cellStyle('F'.$rws.':N'.$rws, "66FFFB", "000000", TRUE, 18, "Calibri");
			$hoja->setCellValue("F{$rws}", "CEDIS");
			$hoja->mergeCells('O'.$rws.':W'.$rws);
			$this->cellStyle('O'.$rws.':W'.$rws, "FF0066", "000000", TRUE, 18, "Calibri");
			$hoja->setCellValue("O{$rws}", "SUPER");
			$hoja->mergeCells('X'.$rws.':AF'.$rws);
			$this->cellStyle('X'.$rws.':AF'.$rws, "01B0F0", "000000", TRUE, 18, "Calibri");
			$hoja->setCellValue("X{$rws}", "SOLIDARIDAD");
			$hoja->mergeCells('AG'.$rws.':AO'.$rws);
			$this->cellStyle('AG'.$rws.':AO'.$rws, "C5C5C5", "000000", TRUE, 18, "Calibri");
			$hoja->setCellValue("AG{$rws}", "ULTRAMARINOS");
			$hoja->mergeCells('AP'.$rws.':AX'.$rws);
			$this->cellStyle('AP'.$rws.':AX'.$rws, "92D051", "000000", TRUE, 18, "Calibri");
			$hoja->setCellValue("AP{$rws}", "TRINCHERAS");
			$hoja->mergeCells('AY'.$rws.':BG'.$rws);
			$this->cellStyle('AY'.$rws.':BG'.$rws, "B1A0C7", "000000", TRUE, 18, "Calibri");
			$hoja->setCellValue("AY{$rws}", "MERCADO");
			$hoja->mergeCells('BH'.$rws.':BP'.$rws);
			$this->cellStyle('BH'.$rws.':BP'.$rws, "DA9694", "000000", TRUE, 18, "Calibri");
			$hoja->setCellValue("BH{$rws}", "TENENCIA");
			$hoja->mergeCells('BQ'.$rws.':BY'.$rws);
			$this->cellStyle('BQ'.$rws.':BY'.$rws, "4CACC6", "000000", TRUE, 18, "Calibri");
			$hoja->setCellValue("BQ{$rws}", "TIJERAS");

			$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':BY'.$rws)->applyFromArray($styleArray);
			$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':BY'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$rws++;


			
			$this->cellStyle('A'.$rws.':E'.$rws, "000000", "FFFFFF", TRUE, 16, "Calibri");
			$hoja->setCellValue("A{$rws}", "CÓDIGO")->getColumnDimension('A')->setWidth(14);
			$hoja->setCellValue("B{$rws}", "DESCRIPCIÓN")->getColumnDimension('B')->setWidth(54);
			$hoja->setCellValue("C{$rws}", "UNIDAD")->getColumnDimension('C')->setWidth(10);
			$hoja->setCellValue("D{$rws}", "UM")->getColumnDimension('D')->setWidth(10);
			$hoja->setCellValue("E{$rws}", "LINEA")->getColumnDimension('E')->setWidth(10);
			//CEDIS
			$this->cellStyle('F'.$rws.':N'.$rws, "66FFFB", "000000", TRUE, 16, "Calibri");
			$hoja->setCellValue("F{$rws}", "Ú. COSTO")->getColumnDimension('F')->setWidth(14);
			$hoja->setCellValue("G{$rws}", "PX VENTA")->getColumnDimension('G')->setWidth(14);
			$hoja->setCellValue("H{$rws}", "% UTILIDAD")->getColumnDimension('H')->setWidth(10);
			$hoja->setCellValue("I{$rws}", "COMPRO")->getColumnDimension('I')->setWidth(14);
			$hoja->setCellValue("J{$rws}", "VENDIO")->getColumnDimension('J')->setWidth(14);
			$hoja->setCellValue("K{$rws}", "MERMA")->getColumnDimension('K')->setWidth(14);
			$hoja->setCellValue("L{$rws}", "T. COMPRA")->getColumnDimension('L')->setWidth(14);
			$hoja->setCellValue("M{$rws}", "T. MERMA")->getColumnDimension('M')->setWidth(14);
			$hoja->setCellValue("N{$rws}", "PX REAL")->getColumnDimension('N')->setWidth(14);
			//SUPER
			$this->cellStyle('O'.$rws.':W'.$rws, "FF0066", "000000", TRUE, 16, "Calibri");
			$hoja->setCellValue("O{$rws}", "Ú. COSTO")->getColumnDimension('O')->setWidth(14);
			$hoja->setCellValue("P{$rws}", "PX VENTA")->getColumnDimension('P')->setWidth(14);
			$hoja->setCellValue("Q{$rws}", "% UTILIDAD")->getColumnDimension('Q')->setWidth(10);
			$hoja->setCellValue("R{$rws}", "COMPRO")->getColumnDimension('R')->setWidth(14);
			$hoja->setCellValue("S{$rws}", "VENDIO")->getColumnDimension('S')->setWidth(14);
			$hoja->setCellValue("T{$rws}", "MERMA")->getColumnDimension('T')->setWidth(14);
			$hoja->setCellValue("U{$rws}", "T. COMPRA")->getColumnDimension('U')->setWidth(14);
			$hoja->setCellValue("V{$rws}", "T. MERMA")->getColumnDimension('V')->setWidth(14);
			$hoja->setCellValue("W{$rws}", "PX REAL")->getColumnDimension('W')->setWidth(14);
			//SOLIDARIDAD
			$this->cellStyle('X'.$rws.':AF'.$rws, "01B0F0", "000000", TRUE, 16, "Calibri");
			$hoja->setCellValue("X{$rws}", "Ú. COSTO")->getColumnDimension('X')->setWidth(14);
			$hoja->setCellValue("Y{$rws}", "PX VENTA")->getColumnDimension('Y')->setWidth(14);
			$hoja->setCellValue("Z{$rws}", "% UTILIDAD")->getColumnDimension('Z')->setWidth(10);
			$hoja->setCellValue("AA{$rws}", "COMPRO")->getColumnDimension('AA')->setWidth(14);
			$hoja->setCellValue("AB{$rws}", "VENDIO")->getColumnDimension('AB')->setWidth(14);
			$hoja->setCellValue("AC{$rws}", "MERMA")->getColumnDimension('AC')->setWidth(14);
			$hoja->setCellValue("AD{$rws}", "T. COMPRA")->getColumnDimension('AD')->setWidth(14);
			$hoja->setCellValue("AE{$rws}", "T. MERMA")->getColumnDimension('AE')->setWidth(14);
			$hoja->setCellValue("AF{$rws}", "PX REAL")->getColumnDimension('AF')->setWidth(14);
			//ULTRAMARINOS
			$this->cellStyle('AG'.$rws.':AO'.$rws, "C5C5C5", "000000", TRUE, 16, "Calibri");
			$hoja->setCellValue("AG{$rws}", "Ú. COSTO")->getColumnDimension('AG')->setWidth(14);
			$hoja->setCellValue("AH{$rws}", "PX VENTA")->getColumnDimension('AH')->setWidth(14);
			$hoja->setCellValue("AI{$rws}", "% UTILIDAD")->getColumnDimension('AI')->setWidth(10);
			$hoja->setCellValue("AJ{$rws}", "COMPRO")->getColumnDimension('AJ')->setWidth(14);
			$hoja->setCellValue("AK{$rws}", "VENDIO")->getColumnDimension('AK')->setWidth(14);
			$hoja->setCellValue("AL{$rws}", "MERMA")->getColumnDimension('AL')->setWidth(14);
			$hoja->setCellValue("AM{$rws}", "T. COMPRA")->getColumnDimension('AM')->setWidth(14);
			$hoja->setCellValue("AN{$rws}", "T. MERMA")->getColumnDimension('AN')->setWidth(14);
			$hoja->setCellValue("AO{$rws}", "PX REAL")->getColumnDimension('AO')->setWidth(14);
			//TRINCHERAS
			$this->cellStyle('AP'.$rws.':AX'.$rws, "92D051", "000000", TRUE, 16, "Calibri");
			$hoja->setCellValue("AP{$rws}", "Ú. COSTO")->getColumnDimension('AP')->setWidth(14);
			$hoja->setCellValue("AQ{$rws}", "PX VENTA")->getColumnDimension('AQ')->setWidth(14);
			$hoja->setCellValue("AR{$rws}", "% UTILIDAD")->getColumnDimension('AR')->setWidth(10);
			$hoja->setCellValue("AS{$rws}", "COMPRO")->getColumnDimension('AS')->setWidth(14);
			$hoja->setCellValue("AT{$rws}", "VENDIO")->getColumnDimension('AT')->setWidth(14);
			$hoja->setCellValue("AU{$rws}", "MERMA")->getColumnDimension('AU')->setWidth(14);
			$hoja->setCellValue("AV{$rws}", "T. COMPRA")->getColumnDimension('AV')->setWidth(14);
			$hoja->setCellValue("AW{$rws}", "T. MERMA")->getColumnDimension('AW')->setWidth(14);
			$hoja->setCellValue("AX{$rws}", "PX REAL")->getColumnDimension('AX')->setWidth(14);
			//MERCADO
			$this->cellStyle('AY'.$rws.':BG'.$rws, "B1A0C7", "000000", TRUE, 16, "Calibri");
			$hoja->setCellValue("AY{$rws}", "Ú. COSTO")->getColumnDimension('AY')->setWidth(14);
			$hoja->setCellValue("AZ{$rws}", "PX VENTA")->getColumnDimension('AZ')->setWidth(14);
			$hoja->setCellValue("BA{$rws}", "% UTILIDAD")->getColumnDimension('BA')->setWidth(10);
			$hoja->setCellValue("BB{$rws}", "COMPRO")->getColumnDimension('BB')->setWidth(14);
			$hoja->setCellValue("BC{$rws}", "VENDIO")->getColumnDimension('BC')->setWidth(14);
			$hoja->setCellValue("BD{$rws}", "MERMA")->getColumnDimension('BD')->setWidth(14);
			$hoja->setCellValue("BE{$rws}", "T. COMPRA")->getColumnDimension('BE')->setWidth(14);
			$hoja->setCellValue("BF{$rws}", "T. MERMA")->getColumnDimension('BF')->setWidth(14);
			$hoja->setCellValue("BG{$rws}", "PX REAL")->getColumnDimension('BG')->setWidth(14);
			//TENENCIA
			$this->cellStyle('BH'.$rws.':BP'.$rws, "DA9694", "000000", TRUE, 16, "Calibri");
			$hoja->setCellValue("BH{$rws}", "Ú. COSTO")->getColumnDimension('BH')->setWidth(14);
			$hoja->setCellValue("BI{$rws}", "PX VENTA")->getColumnDimension('BI')->setWidth(14);
			$hoja->setCellValue("BJ{$rws}", "% UTILIDAD")->getColumnDimension('BJ')->setWidth(10);
			$hoja->setCellValue("BK{$rws}", "COMPRO")->getColumnDimension('BK')->setWidth(14);
			$hoja->setCellValue("BL{$rws}", "VENDIO")->getColumnDimension('BL')->setWidth(14);
			$hoja->setCellValue("BM{$rws}", "MERMA")->getColumnDimension('BM')->setWidth(14);
			$hoja->setCellValue("BN{$rws}", "T. COMPRA")->getColumnDimension('BN')->setWidth(14);
			$hoja->setCellValue("BO{$rws}", "T. MERMA")->getColumnDimension('BO')->setWidth(14);
			$hoja->setCellValue("BP{$rws}", "PX REAL")->getColumnDimension('BP')->setWidth(14);
			//TIJERAS
			$this->cellStyle('BQ'.$rws.':BY'.$rws, "4CACC6", "000000", TRUE, 16, "Calibri");
			$hoja->setCellValue("BQ{$rws}", "Ú. COSTO")->getColumnDimension('BQ')->setWidth(14);
			$hoja->setCellValue("BR{$rws}", "PX VENTA")->getColumnDimension('BR')->setWidth(14);
			$hoja->setCellValue("BS{$rws}", "% UTILIDAD")->getColumnDimension('BS')->setWidth(10);
			$hoja->setCellValue("BT{$rws}", "COMPRO")->getColumnDimension('BT')->setWidth(14);
			$hoja->setCellValue("BU{$rws}", "VENDIO")->getColumnDimension('BU')->setWidth(14);
			$hoja->setCellValue("BV{$rws}", "MERMA")->getColumnDimension('BV')->setWidth(14);
			$hoja->setCellValue("BW{$rws}", "T. COMPRA")->getColumnDimension('BW')->setWidth(14);
			$hoja->setCellValue("BX{$rws}", "T. MERMA")->getColumnDimension('BX')->setWidth(14);
			$hoja->setCellValue("BY{$rws}", "PX REAL")->getColumnDimension('BY')->setWidth(14);

			$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':BY'.$rws)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
			$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':BY'.$rws)->applyFromArray($styleArray);
			$rws++;
		}
		
		if ($merma){
			foreach ($merma as $key => $value) {
				$this->excelfile->getActiveSheet()->getStyle('A'.$rws.':BY'.$rws)->applyFromArray($styleArray);
				$this->cellStyle('A'.$rws.':BY'.$rws, "FFFFFF", "000000", FALSE, 12, "Arial Narrow");


				$hoja->setCellValue("A{$rws}", $value["codigo"]);
				$hoja->setCellValue("B{$rws}", $value["nombre"]);
				$hoja->setCellValue("C{$rws}", $value["ides"]);
				$hoja->setCellValue("D{$rws}", $value["unidad"]);
				$hoja->setCellValue("E{$rws}", $value["linea"]);

				//CEDIS
				$hoja->setCellValue("F{$rws}", $value["sucursales"][7]["ucosto"])->getStyle("F{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("G{$rws}", $value["sucursales"][7]["puno"])->getStyle("G{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("H{$rws}", "=(G{$rws}-F{$rws})/G{$rws}")->getStyle("H{$rws}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
				$hoja->setCellValue("I{$rws}", '='.$this->isnulos($value["sucursales"][7]["entcan"]).'+'.$this->isnulos($value["sucursales"][7]["notacan"]))->getStyle("I{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("J{$rws}", $value["sucursales"][7]["sumorems"] )->getStyle("J{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("K{$rws}", $value["sucursales"][7]["salcan"] )->getStyle("K{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("L{$rws}", "=F{$rws}*I{$rws}")->getStyle("L{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("M{$rws}", "=F{$rws}*K{$rws}")->getStyle("M{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("N{$rws}", "=L{$rws}/J{$rws}")->getStyle("N{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');


				$condRed = new PHPExcel_Style_Conditional();
				$condRed->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHAN)
		                ->addCondition('G'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF9C0006')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFFFC7CE'),
								  'endcolor' =>array('argb' => 'FFFFC7CE')
								)
							)
						);
				$condGreen = new PHPExcel_Style_Conditional();
				$condGreen->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
		                ->addCondition('G'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF006100')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFC6EFCE'),
								  'endcolor' =>array('argb' => 'FFC6EFCE')
								)
							)
						);

		        $conditionalStyles = $this->excelfile->getActiveSheet()->getStyle('N'.$rws)->getConditionalStyles();
				array_push($conditionalStyles,$condRed);
				array_push($conditionalStyles,$condGreen);
				$this->excelfile->getActiveSheet()->getStyle('N'.$rws)->setConditionalStyles($conditionalStyles);



				//SUPER
				$entra6 = $this->isnulos($value["sucursales"][8]["entcan"])+$this->isnulos($value["sucursales"][8]["notacan"]);
				$inve6 = ($this->isnulos($value["sucursales"][8]["sexistencia1"])+$entra6) - ( $this->isnulos($value["sucursales"][8]["sexistencia2"]) + $this->isnulos($value["sucursales"][8]["salcan"]) ) ;
				$hoja->setCellValue("O{$rws}", $value["sucursales"][8]["ucosto"])->getStyle("O{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("P{$rws}", $value["sucursales"][8]["puno"])->getStyle("P{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("Q{$rws}", "=(P{$rws}-O{$rws})/P{$rws}")->getStyle("Q{$rws}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
				$hoja->setCellValue("R{$rws}", '='.$this->isnulos($value["sucursales"][8]["entcan"]).'+'.$this->isnulos($value["sucursales"][8]["notacan"]))->getStyle("R{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("S{$rws}", $inve6 )->getStyle("S{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("T{$rws}", $value["sucursales"][8]["salcan"] )->getStyle("T{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("U{$rws}", "=O{$rws}*R{$rws}")->getStyle("U{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("V{$rws}", "=O{$rws}*T{$rws}")->getStyle("V{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("W{$rws}", "=U{$rws}/S{$rws}")->getStyle("W{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');


				$condRed = new PHPExcel_Style_Conditional();
				$condRed->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHAN)
		                ->addCondition('P'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF9C0006')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFFFC7CE'),
								  'endcolor' =>array('argb' => 'FFFFC7CE')
								)
							)
						);
				$condGreen = new PHPExcel_Style_Conditional();
				$condGreen->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
		                ->addCondition('P'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF006100')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFC6EFCE'),
								  'endcolor' =>array('argb' => 'FFC6EFCE')
								)
							)
						);

		        $conditionalStyles = $this->excelfile->getActiveSheet()->getStyle('W'.$rws)->getConditionalStyles();
				array_push($conditionalStyles,$condRed);
				array_push($conditionalStyles,$condGreen);
				$this->excelfile->getActiveSheet()->getStyle('W'.$rws)->setConditionalStyles($conditionalStyles);



				//SOLIDARIDAD
				$entra6 = $this->isnulos($value["sucursales"][6]["entcan"])+$this->isnulos($value["sucursales"][6]["notacan"]);
				$inve6 = ($this->isnulos($value["sucursales"][6]["sexistencia1"])+$entra6) - ( $this->isnulos($value["sucursales"][6]["sexistencia2"]) + $this->isnulos($value["sucursales"][6]["salcan"]) ) ;
				$hoja->setCellValue("X{$rws}", $value["sucursales"][6]["ucosto"])->getStyle("X{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("Y{$rws}", $value["sucursales"][6]["puno"])->getStyle("Y{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("Z{$rws}", "=(Y{$rws}-X{$rws})/Y{$rws}")->getStyle("Z{$rws}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
				$hoja->setCellValue("AA{$rws}", '='.$this->isnulos($value["sucursales"][6]["entcan"]).'+'.$this->isnulos($value["sucursales"][6]["notacan"]))->getStyle("AA{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("AB{$rws}", $inve6 )->getStyle("AB{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("AC{$rws}", $value["sucursales"][6]["salcan"] )->getStyle("AC{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("AD{$rws}", "=X{$rws}*AA{$rws}")->getStyle("AD{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AE{$rws}", "=X{$rws}*AC{$rws}")->getStyle("AE{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AF{$rws}", "=AD{$rws}/AB{$rws}")->getStyle("AF{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');


				$condRed = new PHPExcel_Style_Conditional();
				$condRed->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHAN)
		                ->addCondition('Y'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF9C0006')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFFFC7CE'),
								  'endcolor' =>array('argb' => 'FFFFC7CE')
								)
							)
						);
				$condGreen = new PHPExcel_Style_Conditional();
				$condGreen->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
		                ->addCondition('Y'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF006100')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFC6EFCE'),
								  'endcolor' =>array('argb' => 'FFC6EFCE')
								)
							)
						);

		        $conditionalStyles = $this->excelfile->getActiveSheet()->getStyle('AF'.$rws)->getConditionalStyles();
				array_push($conditionalStyles,$condRed);
				array_push($conditionalStyles,$condGreen);
				$this->excelfile->getActiveSheet()->getStyle('AF'.$rws)->setConditionalStyles($conditionalStyles);



				//ULTRAMARINOS
				$entra6 = $this->isnulos($value["sucursales"][5]["entcan"])+$this->isnulos($value["sucursales"][5]["notacan"]);
				$inve6 = ($this->isnulos($value["sucursales"][5]["sexistencia1"])+$entra6) - ( $this->isnulos($value["sucursales"][5]["sexistencia2"]) + $this->isnulos($value["sucursales"][5]["salcan"]) ) ;
				$hoja->setCellValue("AG{$rws}", $value["sucursales"][5]["ucosto"])->getStyle("AG{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AH{$rws}", $value["sucursales"][5]["puno"])->getStyle("AH{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AI{$rws}", "=(AH{$rws}-AG{$rws})/AH{$rws}")->getStyle("AI{$rws}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
				$hoja->setCellValue("AJ{$rws}", '='.$this->isnulos($value["sucursales"][5]["entcan"]).'+'.$this->isnulos($value["sucursales"][5]["notacan"]))->getStyle("AJ{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("AK{$rws}", $inve6 )->getStyle("AK{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("AL{$rws}", $value["sucursales"][5]["salcan"] )->getStyle("AL{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("AM{$rws}", "=AG{$rws}*AJ{$rws}")->getStyle("AM{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AN{$rws}", "=AG{$rws}*AL{$rws}")->getStyle("AN{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AO{$rws}", "=AM{$rws}/AK{$rws}")->getStyle("AO{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');


				$condRed = new PHPExcel_Style_Conditional();
				$condRed->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHAN)
		                ->addCondition('AH'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF9C0006')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFFFC7CE'),
								  'endcolor' =>array('argb' => 'FFFFC7CE')
								)
							)
						);
				$condGreen = new PHPExcel_Style_Conditional();
				$condGreen->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
		                ->addCondition('AH'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF006100')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFC6EFCE'),
								  'endcolor' =>array('argb' => 'FFC6EFCE')
								)
							)
						);

		        $conditionalStyles = $this->excelfile->getActiveSheet()->getStyle('AO'.$rws)->getConditionalStyles();
				array_push($conditionalStyles,$condRed);
				array_push($conditionalStyles,$condGreen);
				$this->excelfile->getActiveSheet()->getStyle('AO'.$rws)->setConditionalStyles($conditionalStyles);



				//TRINCHERAS
				$entra6 = $this->isnulos($value["sucursales"][4]["entcan"])+$this->isnulos($value["sucursales"][4]["notacan"]);
				$inve6 = ($this->isnulos($value["sucursales"][4]["sexistencia1"])+$entra6) - ( $this->isnulos($value["sucursales"][4]["sexistencia2"]) + $this->isnulos($value["sucursales"][4]["salcan"]) ) ;
				$hoja->setCellValue("AP{$rws}", $value["sucursales"][4]["ucosto"])->getStyle("AP{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AQ{$rws}", $value["sucursales"][4]["puno"])->getStyle("AQ{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AR{$rws}", "=(AQ{$rws}-AP{$rws})/AQ{$rws}")->getStyle("AR{$rws}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
				$hoja->setCellValue("AS{$rws}", '='.$this->isnulos($value["sucursales"][4]["entcan"]).'+'.$this->isnulos($value["sucursales"][4]["notacan"]))->getStyle("AS{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("AT{$rws}", $inve6 )->getStyle("AT{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("AU{$rws}", $value["sucursales"][4]["salcan"] )->getStyle("AU{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("AV{$rws}", "=AP{$rws}*AS{$rws}")->getStyle("AV{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AW{$rws}", "=AP{$rws}*AU{$rws}")->getStyle("AW{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AX{$rws}", "=AV{$rws}/AT{$rws}")->getStyle("AX{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');


				$condRed = new PHPExcel_Style_Conditional();
				$condRed->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHAN)
		                ->addCondition('AQ'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF9C0006')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFFFC7CE'),
								  'endcolor' =>array('argb' => 'FFFFC7CE')
								)
							)
						);
				$condGreen = new PHPExcel_Style_Conditional();
				$condGreen->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
		                ->addCondition('AQ'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF006100')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFC6EFCE'),
								  'endcolor' =>array('argb' => 'FFC6EFCE')
								)
							)
						);

		        $conditionalStyles = $this->excelfile->getActiveSheet()->getStyle('AX'.$rws)->getConditionalStyles();
				array_push($conditionalStyles,$condRed);
				array_push($conditionalStyles,$condGreen);
				$this->excelfile->getActiveSheet()->getStyle('AX'.$rws)->setConditionalStyles($conditionalStyles);



				//MERCADO
				$entra6 = $this->isnulos($value["sucursales"][3]["entcan"])+$this->isnulos($value["sucursales"][3]["notacan"]);
				$inve6 = ($this->isnulos($value["sucursales"][3]["sexistencia1"])+$entra6) - ( $this->isnulos($value["sucursales"][3]["sexistencia2"]) + $this->isnulos($value["sucursales"][3]["salcan"]) ) ;
				$hoja->setCellValue("AY{$rws}", $value["sucursales"][3]["ucosto"])->getStyle("AY{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("AZ{$rws}", $value["sucursales"][3]["puno"])->getStyle("AZ{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BA{$rws}", "=(AZ{$rws}-AY{$rws})/AZ{$rws}")->getStyle("BA{$rws}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
				$hoja->setCellValue("BB{$rws}", '='.$this->isnulos($value["sucursales"][3]["entcan"]).'+'.$this->isnulos($value["sucursales"][3]["notacan"]))->getStyle("BB{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("BC{$rws}", $inve6 )->getStyle("BC{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("BD{$rws}", $value["sucursales"][3]["salcan"] )->getStyle("BD{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("BE{$rws}", "=AY{$rws}*BB{$rws}")->getStyle("BE{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BF{$rws}", "=AY{$rws}*BD{$rws}")->getStyle("BF{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BG{$rws}", "=BE{$rws}/BC{$rws}")->getStyle("BG{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');


				$condRed = new PHPExcel_Style_Conditional();
				$condRed->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHAN)
		                ->addCondition('AZ'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF9C0006')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFFFC7CE'),
								  'endcolor' =>array('argb' => 'FFFFC7CE')
								)
							)
						);
				$condGreen = new PHPExcel_Style_Conditional();
				$condGreen->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
		                ->addCondition('AZ'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF006100')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFC6EFCE'),
								  'endcolor' =>array('argb' => 'FFC6EFCE')
								)
							)
						);

		        $conditionalStyles = $this->excelfile->getActiveSheet()->getStyle('BG'.$rws)->getConditionalStyles();
				array_push($conditionalStyles,$condRed);
				array_push($conditionalStyles,$condGreen);
				$this->excelfile->getActiveSheet()->getStyle('BG'.$rws)->setConditionalStyles($conditionalStyles);



				//TENENCIA
				$entra6 = $this->isnulos($value["sucursales"][2]["entcan"])+$this->isnulos($value["sucursales"][2]["notacan"]);
				$inve6 = ($this->isnulos($value["sucursales"][2]["sexistencia1"])+$entra6) - ( $this->isnulos($value["sucursales"][2]["sexistencia2"]) + $this->isnulos($value["sucursales"][2]["salcan"]) ) ;
				$hoja->setCellValue("BH{$rws}", $value["sucursales"][2]["ucosto"])->getStyle("BH{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BI{$rws}", $value["sucursales"][2]["puno"])->getStyle("BI{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BJ{$rws}", "=(BI{$rws}-BH{$rws})/BI{$rws}")->getStyle("BJ{$rws}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
				$hoja->setCellValue("BK{$rws}", '='.$this->isnulos($value["sucursales"][2]["entcan"]).'+'.$this->isnulos($value["sucursales"][2]["notacan"]))->getStyle("BK{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("BL{$rws}", $inve6 )->getStyle("BL{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("BM{$rws}", $value["sucursales"][2]["salcan"] )->getStyle("BM{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("BN{$rws}", "=BH{$rws}*BK{$rws}")->getStyle("BN{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BO{$rws}", "=BH{$rws}*BM{$rws}")->getStyle("BO{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BP{$rws}", "=BN{$rws}/BL{$rws}")->getStyle("BP{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');


				$condRed = new PHPExcel_Style_Conditional();
				$condRed->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHAN)
		                ->addCondition('BI'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF9C0006')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFFFC7CE'),
								  'endcolor' =>array('argb' => 'FFFFC7CE')
								)
							)
						);
				$condGreen = new PHPExcel_Style_Conditional();
				$condGreen->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
		                ->addCondition('BI'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF006100')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFC6EFCE'),
								  'endcolor' =>array('argb' => 'FFC6EFCE')
								)
							)
						);

		        $conditionalStyles = $this->excelfile->getActiveSheet()->getStyle('BP'.$rws)->getConditionalStyles();
				array_push($conditionalStyles,$condRed);
				array_push($conditionalStyles,$condGreen);
				$this->excelfile->getActiveSheet()->getStyle('BP'.$rws)->setConditionalStyles($conditionalStyles);



				//TIJERAS
				$entra6 = $this->isnulos($value["sucursales"][1]["entcan"])+$this->isnulos($value["sucursales"][1]["notacan"]);
				$inve6 = ($this->isnulos($value["sucursales"][1]["sexistencia1"])+$entra6) - ( $this->isnulos($value["sucursales"][1]["sexistencia2"]) + $this->isnulos($value["sucursales"][1]["salcan"]) ) ;
				$hoja->setCellValue("BQ{$rws}", $value["sucursales"][1]["ucosto"])->getStyle("BQ{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BR{$rws}", $value["sucursales"][1]["puno"])->getStyle("BR{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BS{$rws}", "=(BR{$rws}-BQ{$rws})/BR{$rws}")->getStyle("BS{$rws}")->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_PERCENTAGE_00);
				$hoja->setCellValue("BT{$rws}", '='.$this->isnulos($value["sucursales"][1]["entcan"]).'+'.$this->isnulos($value["sucursales"][1]["notacan"]))->getStyle("BT{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("BU{$rws}", $inve6 )->getStyle("BU{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("BV{$rws}", $value["sucursales"][1]["salcan"] )->getStyle("BV{$rws}")->getNumberFormat()->setFormatCode("_(* #,##0.00_);_(* \(#,##0.00\);_(* \"-\"??_);_(@_)");
				$hoja->setCellValue("BW{$rws}", "=BQ{$rws}*BT{$rws}")->getStyle("BW{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BX{$rws}", "=BQ{$rws}*BV{$rws}")->getStyle("BX{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');
				$hoja->setCellValue("BY{$rws}", "=BW{$rws}/BU{$rws}")->getStyle("BY{$rws}")->getNumberFormat()->setFormatCode('_("$"* #,##0.00_);_("$"* \(#,##0.00\);_("$"* "-"??_);_(@_)');


				$condRed = new PHPExcel_Style_Conditional();
				$condRed->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHAN)
		                ->addCondition('BR'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF9C0006')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFFFC7CE'),
								  'endcolor' =>array('argb' => 'FFFFC7CE')
								)
							)
						);
				$condGreen = new PHPExcel_Style_Conditional();
				$condGreen->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
		                ->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
		                ->addCondition('BR'.$rws)
		                ->getStyle()
		                ->applyFromArray(
		                	array(
							  'font'=>array(
							   'color'=>array('argb'=>'FF006100')
							  ),
							  'fill'=>array(
								  'type' =>PHPExcel_Style_Fill::FILL_SOLID,
								  'startcolor' =>array('argb' => 'FFC6EFCE'),
								  'endcolor' =>array('argb' => 'FFC6EFCE')
								)
							)
						);

		        $conditionalStyles = $this->excelfile->getActiveSheet()->getStyle('BY'.$rws)->getConditionalStyles();
				array_push($conditionalStyles,$condRed);
				array_push($conditionalStyles,$condGreen);
				$this->excelfile->getActiveSheet()->getStyle('BY'.$rws)->setConditionalStyles($conditionalStyles);




				
				$rws++;

			}
		}


		$dias = array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
		$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
		$fecha =  $dias[date('w')]." ".date('d')." DE ".$meses[date('n')-1]. " DEL ".date('Y') ;
		$file_name = "REPORTE MERMA ".$fecha.".xlsx"; //Nombre del documento con extención
		header("Content-Type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment;filename=".$file_name);
		header("Cache-Control: max-age=0");
		$excel_Writer = PHPExcel_IOFactory::createWriter($this->excelfile, "Excel2007");
		$excel_Writer->save("php://output");
	}


	public function isnulos($number){
		if(is_null($number) || $number == ""){
			return 0;
		}else{
			return $number;
		}
	}


	public function getMermaProd(){
		$valo = $this->input->post("values");
		$entra = $this->dentr_md->getEntradasProd(NULL,$valo);
		$ajuen = $this->dentr_md->getAEntradasProd(NULL,$valo);
		$ajusa = $this->dentr_md->getSEntradasProd(NULL,$valo);
		$this->jsonResponse(["entra"=>$entra,"ajuen"=>$ajuen,"ajusa"=>$ajusa]);
	}

	public function kardex(){
		$data['scripts'] = [
			'/scripts/Reporte/kardex',
		];
		$data["lineas"] = $this->ln_md->get(NULL,["estatus"=>1]);
		$this->estructura("Reporte/kardex", $data);
	}

	public function buscaKardex(){
		$valo = $this->input->post("values");
		$merma = $this->dentr_md->buscaKardex(NULL,$valo);
		$this->jsonResponse($merma);
	}

}