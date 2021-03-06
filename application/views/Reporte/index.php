<style>
    @media only screen and (max-width: 600px) {
      #imgStart{display:none}
    }
    @media (min-width: 1700px){.container{max-width: 1700px;}.headpedven{font-size:16px;}}
    .imgPreviews,.imgPreviews2{max-width:100%;}
    .imgOfes,.imgOfes2{max-height:100px;}
    .resolImg,.resolImg2{padding:1px;border:1px solid #ccc;text-align:center;overflow:hidden;cursor:pointer;}
    .descoImgs,.descoImgs2{overflow:hidden;}
    .imgResoImg,.imgResoImg2{max-width:100%;border-radius:35px;max-height:200px;}
    .cambioSelec{display:none;}

    #contenedor video{
    max-width: 100%;
    width: 100%;
}
#contenedor{
    max-width: 100%;
    position:relative;
}
canvas{
    max-width: 100%;
}
canvas.drawingBuffer{
    position:absolute;
    top:0;
    left:0;
}

.suc0Head{background:#000;color:#FFF;font-size:24px !important;}
.suc0Thead{background:#000;color:#FFF;}

.suc7Head{background:#c00000;color:#000;font-size:24px !important;}
.suc7Thead{background-image:linear-gradient(135deg, white 85%, #c00000 15%);}
.suc6Head{background:#01b0f0;color:#000;font-size:24px !important;}
.suc6Thead{background-image:linear-gradient(135deg, white 85%, #01b0f0 15%);}
.suc5Head{background:#c5c5c5;color:#000;font-size:24px !important;}
.suc5Thead{background-image:linear-gradient(135deg, white 85%, #c5c5c5 15%);}
.suc4Head{background:#93d051;color:#000;font-size:24px !important;}
.suc4Thead{background-image:linear-gradient(135deg, white 85%, #93d051 15%);}
.suc3Head{background:#b1a0c7;color:#000;font-size:24px !important;}
.suc3Thead{background-image:linear-gradient(135deg, white 85%, #b1a0c7 15%);}
.suc2Head{background:#da9694;color:#000;font-size:24px !important;}
.suc2Thead{background-image:linear-gradient(135deg, white 85%, #da9694 15%);}
.suc1Head{background:#4cacc6;color:#000;font-size:24px !important;}
.suc1Thead{background-image:linear-gradient(135deg, white 85%, #4cacc6 15%);}
.posZOver{position:absolute;top:0;left:0;right:0;padding:50px;z-index:100;background:white;bottom:0;overflow:scroll;}
.td1left{border-left: 2px solid #4cacc6 !important;}.td1right{border-right: 2px solid #4cacc6 !important;}
.td2left{border-left: 2px solid #da9694 !important;}.td2right{border-right: 2px solid #da9694 !important;}
.td3left{border-left: 2px solid #b1a0c7 !important;}.td3right{border-right: 2px solid #b1a0c7 !important;}
.td4left{border-left: 2px solid #93d051 !important;}.td4right{border-right: 2px solid #93d051 !important;}
.td5left{border-left: 2px solid #c5c5c5 !important;}.td5right{border-right: 2px solid #c5c5c5 !important;}
.td6left{border-left: 2px solid #01b0f0 !important;}.td6right{border-right: 2px solid #01b0f0 !important;}
.td7left{border-left: 2px solid #c00000 !important;}.td7right{border-right: 2px solid #c00000 !important;}
.td8left{border-left: 2px solid #4cacc6 !important;}.td8right{border-right: 2px solid #4cacc6 !important;}
thead th { position: sticky; top: 0; }
.codeSticky{ position: sticky; left: 0;background: #e7d9d9;}
.modal-dialog.modal-dialog-centered.modal-xl{max-width: 90% !important;}
.tfootEntra1,.tfootAjue1,.tfootAjus1{text-align:right;font-size:20px;}.tfootEntra2,.tfootAjus2,.tfootAjue2{text-align:left;}
</style>
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class=" container" style="min-width:96vw;overflow-x:scroll;">
			<!--begin::Dashboard-->

            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">
                    <!--begin::Engage Widget 8-->
                    <div class="card card-custom gutter-b card-stretch card-shadowless">
                        <div class="card-body p-0 d-flex">
                            <div class="d-flex align-items-start justify-content-start flex-grow-1 bg-light-info p-8 card-rounded flex-grow-1 position-relative">
                                <div class="d-flex flex-column align-items-start flex-grow-1 h-100">
                                    <div class="p-1 flex-grow-1">
                                        <h4 class="text-info font-weight-bolder">REPORTE DE SUCURSALES</h4>
                                        <p class="text-dark font-weight-bold mt-3">
                                            Como predeterminado se muestra la sucursal Super Cd Industrial, podra seleccionar cualquiera o todas las sucursales.<br>
                                            Puede seleccionar/agregar un producto a la consulta o si lo prefiere una familia(linea) de productos.<br>
                                            Puede seleccionar el rango de fechas para obtener su consulta, de manera predeterminada se selecciona un rango de 1 semana.<br>
                                            El boton "DESCARGAR REPORTE EXCEL" tomara los parametros de su busqueda y los agregara a su reporte
                                        </p>
                                    </div>
                                </div>
                                <div class="position-absolute right-0 bottom-0 mr-5 overflow-hidden">
                                    <img src="assets/media/svg/illustrations/designi.svg" style="height:250px;width:350px;margin-bottom:-35px;" id="imgStart" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Engage Widget 8-->
                </div>
            </div>
            <!--end::Row-->	

            <!--<div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-4">
                        <div class="form-group">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Buscar producto..."/>
                                <span><i class="flaticon2-search-1 icon-md"></i></span>
                            </div>
                            <span class="form-text text-muted">Ejemplo: Amarilla</span>
                        </div>
                    </div>
                </div>
            </div>-->
            <?php echo form_open("Reporte/downExcel", array("id" => 'reporte_downsExcel', "target" => '_blank')); ?>
            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-4">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <select class="form-control select2" id="selectLinea" name="selectLinea">
                                    <option value="2">FRUTAS</option>
                                    <?php if($lineas):foreach ($lineas as $key => $vlinea): ?>
                                        <option value="<?php echo $vlinea->id_linea ?>"><?php echo $vlinea->nombre ?></option>
                                    <?php endforeach;endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-4">
                        <label class="col-sm-12">RANGO DE FECHAS</label>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type='text' class="form-control" id="rangeFecha" readonly placeholder="SELECCIONE EL RANGO DE FECHAS" type="text" name="rangeFecha" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin-bottom:15px;">
                <div class="col-xl-12">
                    <div class="col-xl-4">
                        <button class="btn btn-light-success d-inline-flex align-items-center btn-lg mr-5" id="btnDownExcel">
                            <div class="d-flex flex-column text-right pr-3">
                                <span class="text-dark-75 font-weight-bold font-size-sm">DESCARGAR</span>
                                <span class="font-weight-bolder font-size-sm">FORMATO XLSX (EXCEL)</span>
                            </div>
                            <span class="symbol symbol-40">
                                <img alt="Pic" src="assets/img/excel.svg"/>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
 
            <div class="row">
                <div class="col-xl-12" style="overflow: scroll;max-height: 50rem;">
                    <table class="table table-bordered">
                        <thead>
                            <tr style="text-align: center;">
                                <th colspan="6" class="suc0 suc0Head">DETALLES DEL PRODUCTO <br>SEG??N COMPUCAJA CEDIS</th>
                                <th colspan="10" class="suc7 suc7Head">CEDIS</th>
                                <th colspan="10" class="suc6 suc6Head">SOLIDARIDAD</th>
                                <th colspan="10" class="suc5 suc5Head">ULTRA</th>
                                <th colspan="10" class="suc4 suc4Head">TRINCHERAS</th>
                                <th colspan="10" class="suc3 suc3Head">MERCADO</th>
                                <th colspan="10" class="suc2 suc2Head">TENENCIA</th>
                                <th colspan="10" class="suc1 suc1Head">TIJERAS</th>
                                <th colspan="6" class="suc0 suc0Head">TOTALES</th>
                            </tr>
                            <tr>
                                <th class="suc0Thead">ID</th>
                                <th class="suc0Thead">C??DIGO</th>
                                <th class="suc0Thead">DESCRIPCI??N</th>
                                <th class="suc0Thead">UNIDAD</th>
                                <th class="suc0Thead">UM</th>
                                <th class="suc0Thead">LINEA</th>

                                <th class="suc7Thead">ULTIMO <br> COSTO</th>
                                <th class="suc7Thead">PX <br> VENTA</th>
                                <th class="suc7Thead">% <br> UTILIDAD</th>
                                <th class="suc7Thead">COMPRO</th>
                                <th class="suc7Thead">VENDIO</th>
                                <th class="suc7Thead">MERMA</th>
                                <th class="suc7Thead">TOTAL <br>COMPRA</th>
                                <th class="suc7Thead">TOTAL <br>MERMA</th>
                                <th class="suc7Thead">PX <br>REAL</th>
                                <th class="suc7Thead">DETALLES</th>

                                <th class="suc6Thead">ULTIMO <br> COSTO</th>
                                <th class="suc6Thead">PX <br> VENTA</th>
                                <th class="suc6Thead">% <br> UTILIDAD</th>
                                <th class="suc6Thead">COMPRO</th>
                                <th class="suc6Thead">VENDIO</th>
                                <th class="suc6Thead">MERMA</th>
                                <th class="suc6Thead">TOTAL <br>COMPRA</th>
                                <th class="suc6Thead">TOTAL <br>MERMA</th>
                                <th class="suc6Thead">PX <br>REAL</th>
                                <th class="suc6Thead">DETALLES</th>

                                <th class="suc5Thead">ULTIMO <br> COSTO</th>
                                <th class="suc5Thead">PX <br> VENTA</th>
                                <th class="suc5Thead">% <br> UTILIDAD</th>
                                <th class="suc5Thead">COMPRO</th>
                                <th class="suc5Thead">VENDIO</th>
                                <th class="suc5Thead">MERMA</th>
                                <th class="suc5Thead">TOTAL <br>COMPRA</th>
                                <th class="suc5Thead">TOTAL <br>MERMA</th>
                                <th class="suc5Thead">PX <br>REAL</th>
                                <th class="suc5Thead">DETALLES</th>

                                <th class="suc4Thead">ULTIMO <br> COSTO</th>
                                <th class="suc4Thead">PX <br> VENTA</th>
                                <th class="suc4Thead">% <br> UTILIDAD</th>
                                <th class="suc4Thead">COMPRO</th>
                                <th class="suc4Thead">VENDIO</th>
                                <th class="suc4Thead">MERMA</th>
                                <th class="suc4Thead">TOTAL <br>COMPRA</th>
                                <th class="suc4Thead">TOTAL <br>MERMA</th>
                                <th class="suc4Thead">PX <br>REAL</th>
                                <th class="suc4Thead">DETALLES</th>

                                <th class="suc3Thead">ULTIMO <br> COSTO</th>
                                <th class="suc3Thead">PX <br> VENTA</th>
                                <th class="suc3Thead">% <br> UTILIDAD</th>
                                <th class="suc3Thead">COMPRO</th>
                                <th class="suc3Thead">VENDIO</th>
                                <th class="suc3Thead">MERMA</th>
                                <th class="suc3Thead">TOTAL <br>COMPRA</th>
                                <th class="suc3Thead">TOTAL <br>MERMA</th>
                                <th class="suc3Thead">PX <br>REAL</th>
                                <th class="suc3Thead">DETALLES</th>

                                <th class="suc2Thead">ULTIMO <br> COSTO</th>
                                <th class="suc2Thead">PX <br> VENTA</th>
                                <th class="suc2Thead">% <br> UTILIDAD</th>
                                <th class="suc2Thead">COMPRO</th>
                                <th class="suc2Thead">VENDIO</th>
                                <th class="suc2Thead">MERMA</th>
                                <th class="suc2Thead">TOTAL <br>COMPRA</th>
                                <th class="suc2Thead">TOTAL <br>MERMA</th>
                                <th class="suc2Thead">PX <br>REAL</th>
                                <th class="suc2Thead">DETALLES</th>

                                <th class="suc1Thead">ULTIMO <br> COSTO</th>
                                <th class="suc1Thead">PX <br> VENTA</th>
                                <th class="suc1Thead">% <br> UTILIDAD</th>
                                <th class="suc1Thead">COMPRO</th>
                                <th class="suc1Thead">VENDIO</th>
                                <th class="suc1Thead">MERMA</th>
                                <th class="suc1Thead">TOTAL <br>COMPRA</th>
                                <th class="suc1Thead">TOTAL <br>MERMA</th>
                                <th class="suc1Thead">PX <br>REAL</th>
                                <th class="suc1Thead">DETALLES</th>


                                <th class="suc0Thead">TOTAL <br>COMPRA</th>
                                <th class="suc0Thead">TOTAL <br>VENTA</th>
                                <th class="suc0Thead">TOTAL <br>MERMA</th>
                                <th class="suc0Thead">TOTALES <br>COMPRA</th>
                                <th class="suc0Thead">TOTALES <br>MERMA</th>
                                <th class="suc0Thead">PX <br>REAL</th>
                            </tr>
                        </thead>
                        <tbody class="tbodyMermas">
                            
                        </tbody>
                    </table>
                </div>
            </div>



        <!--end::Dashboard-->
		</div>
        <!--end::Container-->
	</div>
    <!--end::Entry-->
</div>
<!--end::Content-->

<div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="modalDetails" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">DETALLES MOVIMIENTOS DEL PRODUCTO <span class="fIni"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-12" style="text-align:center;">
                        <!--<img src="assets/img/loading2.gif" class="imgLoadModal">-->
                    </div>
                </div>
                <div class="row col-xl-12">
                    <table class="table table-bordered table-striped rounded">
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="4"><h2>CALCULO DE VENTAS </h2></th>
                            </tr>
                            <tr>
                                <th>INVENTARIO INICIO</th>
                                <th>NOTAS ENTRADA</th>
                                <th>AJUSTES ENTRADA</th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="venEnt1"></td>
                                <td class="venEnt2"></td>
                                <td class="venEnt3"></td>
                                <td class="venEnt4"></td>
                            </tr>
                        </tbody>
                        <thead class="thead-dark">
                            <tr>
                                <th>INVENTARIO FINAL</th>
                                <th>AJUSTES SALIDA</th>
                                <th></th>
                                <th>TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="venSal1"></td>
                                <td class="venSal2"></td>
                                <td></td>
                                <td class="venSal3"></td>
                            </tr>
                        </tbody>
                        <thead class="thead-dark">
                            <tr>
                                <th colspan="3" style="text-align:right;">TOTAL VENTAS</th>
                                <th class="ventotis"></th>
                            </tr>
                        </thead>
                    </table>
                </div>

                <div class="row col-xl-12">
                    <!-- NOTAS DE ENTRADA -->
                    <div class="col-xl-4" style="padding:10px">
                        <table class="table table-bordered table-striped rounded">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="6"><h2>NOTAS DE ENTRADA </h2><span class="tfootEntra1"></span></th>
                                </tr>
                                <tr>
                                    <th>FOLIO</th>
                                    <th>FECHA</th>
                                    <th>PROVEEDOR</th>
                                    <th>CANTIDAD</th>
                                    <th>IMPORTE</th>
                                    <th>TOTAL DE LA NOTA</th>
                                </tr>
                            </thead>
                            <tbody class="tbodyEntra">
                                
                            </tbody>
                            <tfoot class="thead-dark">
                                <tr>
                                    <th colspan="4" class="tfootEntra1"></th>
                                    <th colspan="2" class="tfootEntra2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- AJUSTES DE ENTRADA -->
                    <div class="col-xl-4" style="padding:10px">
                        <table class="table table-bordered table-striped rounded">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="5"><h2>AJUSTES DE ENTRADA </h2><span class="tfootAjue1"></span></th>
                                </tr>
                                <tr>
                                    <th>FOLIO</th>
                                    <th>FECHA</th>
                                    <th>REFERENCIA</th>
                                    <th>CANTIDAD</th>
                                    <th>IMPORTE</th>
                                </tr>
                            </thead>
                            <tbody class="tbodyAjue">
                                
                            </tbody>
                            <tfoot class="thead-dark">
                                <tr>
                                    <th colspan="4" class="tfootAjue1"></th>
                                    <th class="tfootAjue2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>


                    <!-- AJUSTES DE SALIDA -->
                    <div class="col-xl-4" style="padding:10px">
                        <table class="table table-bordered table-striped rounded">
                            <thead class="thead-dark">
                                <tr>
                                    <th colspan="5"><h2>AJUSTES DE SALIDA </h2><span class="tfootAjus1"></span></th>
                                </tr>
                                <tr>
                                    <th>FOLIO</th>
                                    <th>FECHA</th>
                                    <th>REFERENCIA</th>
                                    <th>CANTIDAD</th>
                                    <th>IMPORTE</th>
                                </tr>
                            </thead>
                            <tbody class="tbodyAjus">
                                
                            </tbody>
                            <tfoot class="thead-dark">
                                <tr>
                                    <th colspan="4" class="tfootAjus1"></th>
                                    <th class="tfootAjus2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                <!--<button type="button" class="btn btn-primary"></button>-->
            </div>
        </div>
    </div>
</div>