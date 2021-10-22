<style>
    @media only screen and (max-width: 600px) {
      #imgStart{display:none}
    }
    @media (min-width: 1700px){.container{max-width: 1700px;}.headpedven{font-size:16px;}}
    .titleTable{font-size:18px;font-weight:bold;text-align: center;border:1px solid;}
    .rowTable{font-size:18px;text-align: center;border:1px solid;}
    .spinSpan{height:30px;}
    .fechaUpload{font-size:10px;}
    .tableFixHead{ overflow: auto;}
    td,th{border:1px solid !important;}    
    .tableFixHead thead th { position: sticky; top: 0; z-index: 1; }
    .tableFixHead tbody th { position: sticky; left: 0; }
     @media only screen and (max-width: 900px) {
        .tableFixHead{ overflow: auto;}
    }
    .ivaClass{background: rgb(255,204,102);}
    .pre5{background: rgb(204,153,255);}
    .renglon10Class{background: rgb(196,215,155);}
    .margen1Class{background: rgb(255,117,173);width:100px;}
    .margen2Class{background: rgb(255,192,0);width:100px;}
    li.nav-item.mb-2{border:1px solid #ccc;border-radius:12px;text-align:center;}
    a#sucursal-tab-uno,a#sucursal-tab-mat,a#sucursal-tab-2,a#sucursal-tab-3,a#sucursal-tab-4,a#sucursal-tab-5{padding-left:3rem;padding-right:3rem;}
    .inputransparent{background:rgba(0,0,0,.10);}
    .preciososRojos{width:150px;}
    .difPrecios{color:#b9b9b9;}
    .blockTh{background:#adffe8;}
    .gensuca{background:aquamarine;padding:0;font-size:20px;}
    .precioB{background:#bdd7ee;}
</style>
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class=" container" style="min-width:96vw;">
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
                                        <h4 class="text-info font-weight-bolder">Cambio de Precios</h4>
                                        <p class="text-dark font-weight-bold mt-3">
                                            En la siguiente sección podrá obtener los precios sugeridos para cambio de precios en sucursales "A" y sucursales "B".<br>
                                            Es necesario seguir los siguientes pasos: <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1.- Subir archivo matricial.<br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2.- Subir archivo de catálogos (Se sugiere subirlo sólo cuando se armen diferentes paquetes).<br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3.- Descargar la plantilla para agregar los productos que cambiaran de precio.<br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4.- Subir archivo Excel para buscar los nuevos precios.<br>
                                        </p>
                                    </div>
                                </div>
                                <div class="position-absolute right-0 bottom-0 mr-5 overflow-hidden">
                                    <img src="assets/media/svg/illustrations/dashboard.svg" style="height:350px;width:350px;margin-bottom:-80px;" id="imgStart" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Engage Widget 8-->
                </div>
            </div>
            <!--end::Row-->

            <div class="row">
                <div class="col-xl-12">
                    <ul class="nav nav-pills"  role="tablist">
                        <li class="nav-item mb-2">
                            <a class="nav-link active" id="sucursal-tab-uno" data-toggle="tab" href="#store-uno">
                                <span class="nav-text">CALCULAR <br>PRECIOS
                                    <span class="fechaUpload">
                                        
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="sucursal-tab-mat" data-toggle="tab" href="#store-mat">
                                <span class="nav-text">
                                    MATRICIAL  <br>
                                    <span class="fechaUpload">
                                        Hace <?php echo $hmatriz ?>
                                    </span>
                                </span>
                                <span>
                                    
                                </span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="sucursal-tab-2" data-toggle="tab" href="#store-cat" aria-controls="sucursal">
                                <span class="nav-text">CATÁLOGOS  <br>
                                    <span class="fechaUpload">
                                        Hace <?php echo $hcatalo ?>
                                    </span>
                                </span>
                                
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="sucursal-tab-3" data-toggle="tab" href="#store-exc" aria-controls="sucursal">
                                <span class="nav-text">EXCEL <br>CAMBIOS  <br>
                                    <span class="fechaUpload">
                                        
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="sucursal-tab-4" data-toggle="tab" href="#store-sua" aria-controls="sucursal">
                                <span class="nav-text">SUCURSALES <br>A   <br>
                                    <span class="fechaUpload">
                                        
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="sucursal-tab-5" data-toggle="tab" href="#store-sub" aria-controls="sucursal">
                                <span class="nav-text">SUCURSALES <br>B   <br>
                                    <span class="fechaUpload">
                                        
                                    </span>
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-xl-12">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-content" id="myTabContent1" style="overflow-x:scroll;">
                            <div class="tab-pane fade active show" id="store-uno" role="tabpanel" aria-labelledby="store-tab-uno" style="width:3500px;"><!-- MATRICIAL -->

                                <h1>CALCULAR PRECIOS</h1>
                                <!--begin::Row-->
                                <div class="row col-xl-12 tableFixHead" style="padding-bottom:20px;height:50rem;">
                                    <table class="table table-bordered" style="text-align:center;">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="padding:0">
                                                    <button type="button" class="btn btn-outline-success btn-lg btn-block btn-show-rojos" style="border-radius:0;">
                                                        
                                                    </button>
                                                </th>
                                                <th colspan="10">
                                                    <?php echo $fecha ?>
                                                </th>
                                                <th colspan="18" style="background:rgb(255,51,51)">
                                                    AJUSTES
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="width:70px" >MOSTRAR</th>
                                                <th style="width:100px" >CÓDIGO</th>
                                                <th style="width:100px" >RENGLON 18</th>
                                                <th style="width:50px" >LIN</th>
                                                <th style="width:350px" >DESCRIPCIÓN</th>
                                                <th style="width:50px" >UM</th>
                                                <th style="width:100px" >C</th>
                                                <th style="width:150px" >PAQUETE</th>
                                                <th style="width:100px" >MATRICIAL</th>
                                                <th style="width:100px" >DIF</th>
                                                <th style="width:100px" class="ivaClass">IVA</th>
                                                <th style="width:100px" class="renglon10Class">RENGLON 10</th>
                                                <th colspan="5">PRECIOS DEL 1 AL 5</th>
                                                <th style="width:100px" colspan="4" class="margen1Class">MARGENES</th>
                                                <th style="width:100px" >CÓDIGO</th>
                                                <th style="width:70px" >LIN</th>
                                                <th style="width:350px" >DESCRIPCIÓN</th>
                                                <th style="" colspan="5">PRECIOS DEL 1 AL 5</th>
                                                <th style="width:100px" colspan="4" class="margen2Class">MARGENES</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodySucA">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="store-mat" role="tabpanel" aria-labelledby="store-tab-mat"><!-- MATRICIAL -->

                                <h1>SUBIR ARCHIVO MATRICIAL</h1>
                                <!--begin::Row-->
                                <div class="row col-xl-12 dropRow" style="padding-bottom:20px;height:50rem;">
                                    <div class="col-lg-4 col-md-4 col-sm-4"></div>         
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="dropzone dropzone-default dropzone-warning" id="kt_dropzone_uno">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">SUBIR ARCHIVO TXT MATRICIAL</h3>
                                                <span class="dropzone-msg-desc">Clic para seleccionar arhivo y/o arrastre el archivo txt.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->
                                <!--begin::Row
                                <div class="row col-xl-12" style="padding-bottom:20px;">
                                    <div class="form-group  col-xl-6">
                                        <label>Buscar Producto</label>
                                        <div class="input-icon">
                                            <input type="text" class="form-control" name="buscaProd" id="buscaProd" placeholder="Escriba el código, nombre del producto"/>
                                            <span><i class="flaticon2-search-1 icon-md"></i></span>
                                        </div>
                                        <span class="form-text text-muted">A partir del 4 caracter se empezarám a mostrar los resultados. </span></div>
                                </div>
                                end::Row-->
                            </div>
                        
                            <div class="tab-pane fade" id="store-cat" role="tabpanel" aria-labelledby="store-tab-cat"><!-- CATÁLOGOS -->

                                <h1>SUBIR ARCHIVO CATÁLOGOS</h1>
                                <!--begin::Row-->
                                <div class="row col-xl-12 dropRow" style="padding-bottom:20px;">
                                    <div class="col-lg-4 col-md-4 col-sm-4"></div>         
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="dropzone dropzone-default dropzone-info" id="kt_dropzone_dos">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">SUBIR ARCHIVO TXT CATÁLOGOS</h3>
                                                <span class="dropzone-msg-desc">Clic para seleccionar arhivo y/o arrastre el archivo txt.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->
                                
                                

                            </div>
                            <div class="tab-pane fade" id="store-exc" role="tabpanel" aria-labelledby="store-tab-exc"><!-- EXCEL -->

                                <h1 style="padding-bottom:20px;">SUBIR ARCHIVO EXCEL CAMBIO DE PRECIOS</h1>
                                
                                <!--begin::Row-->
                                <div class="row col-xl-12 dropRow" style="padding-bottom:20px;">
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <a href="assets/uploads/precios.xlsx" target="_blank" class="btn btn-light-success font-weight-bold mr-2">
                                            DESCARGAR PLANTILLA <br> (SUBIR PRODUCTOS A CAMBIAR)
                                        </a>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="dropzone dropzone-default dropzone-success" id="kt_dropzone_tres">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">SUBIR ARCHIVO EXCEL</h3>
                                                <span class="dropzone-msg-desc">Clic para seleccionar arhivo y/o arrastre el archivo excel.</span>
                                            </div>
                                        </div>
                                    </div>                          
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row col-xl-12 dropRow" style="padding-bottom:20px;">
                                             
                                    
                                </div>
                                <!--end::Row-->

                            </div>
                            <div class="tab-pane fade" id="store-sua" role="tabpanel" aria-labelledby="store-tab-sua" style="padding:30px"><!-- SUCURSALES A -->

                                <h1>SUCURSALES A</h1>


                                <!--begin::Row-->
                                <div class="row col-xl-12 otrosShows" style="padding-bottom:20px;padding-top:30px;">
                                    <?php if($rojosHoy):foreach($rojosHoy as $key => $value):if($value["detalles"] <> null): ?>
                                        <div class="row" style="overflow-x:scroll;padding-bottom: 50px;">
                                            <table class="table table-bordered" style="text-align:center;">
                                                <thead>
                                                    <tr>
                                                        <th class="gensuca" colspan="4" style="padding:0">
                                                            <?php echo "GEN SUCA21-0".$value["id_nuevo"] ?>
                                                        </th>
                                                        <th colspan="8">
                                                            <?php echo $fecha ?>
                                                        </th>
                                                        <th colspan="18" style="background:rgb(255,51,51)">AJUSTES</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="width:100px" >CÓDIGO</th>
                                                        <th style="width:100px" >RENGLON 18</th>
                                                        <th style="width:70px" >LIN</th>
                                                        <th style="width:350px" >DESCRIPCIÓN</th>
                                                        <th style="width:70px" >UM</th>
                                                        <th style="width:100px" >C</th>
                                                        <th style="width:150px" >PAQUETE</th>
                                                        <th style="width:100px" class="ivaClass">IVA</th>
                                                        <th style="width:100px" class="renglon10Class">RENGLON 10</th>
                                                        <th colspan="5">PRECIOS DEL 1 AL 5</th>
                                                        <th style="width:100px" colspan="4" class="margen1Class">MARGENES</th>
                                                        <th style="width:100px" >CÓDIGO</th>
                                                        <th style="width:350px" >DESCRIPCIÓN</th>
                                                        <th style="" colspan="5">PRECIOS DEL 1 AL 5</th>
                                                        <th style="width:100px" colspan="4" class="margen2Class">MARGENES</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($value["detalles"] as $key2 => $val): $renglon10 = ( $val["costo"]/$val["cantidad"] ) / ( 1+($val["iva"]/100) ); ?>
                                                        <tr>
                                                            <td><?php echo $val["code1"] ?></td>
                                                            <td><?php echo $val["code2"] ?></td>
                                                            <td><?php echo $val["linea"] ?></td>
                                                            <td><?php echo $val["desc1"] ?></td>
                                                            <td><?php echo $val["unidad"] ?></td>
                                                            <td><?php echo $val["cantidad"] ?></td>
                                                            <td><?php echo $val["costo"] ?></td>
                                                            <td class="ivaClass"><?php echo $val["iva"] ?></td>
                                                            <td class="renglon10Class"><?php echo number_format($renglon10,2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre1"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre2"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre3"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre4"],2,".",",") ?></td>
                                                            <td><?php echo number_format(($val["costo"]+0.01),2,".",",") ?></td>
                                                            <td class="margen1Class"><?php echo $val["mar1"] ?></td>
                                                            <td class="margen1Class"><?php echo $val["mar2"] ?></td>
                                                            <td class="margen1Class"><?php echo $val["mar3"] ?></td>
                                                            <td class="margen1Class"><?php echo $val["mar4"] ?></td>
                                                            <td><?php echo $val["code3"] ?></td>
                                                            <td><?php echo $val["desc2"] ?></td>
                                                            <td><?php echo number_format($val["pre11"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre22"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre33"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre44"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["costopz"],2,".",",") ?></td>
                                                            <td class="margen2Class"><?php echo $val["mar11"] ?></td>
                                                            <td class="margen2Class"><?php echo $val["mar22"] ?></td>
                                                            <td class="margen2Class"><?php echo $val["mar33"] ?></td>
                                                            <td class="margen2Class"><?php echo $val["mar44"] ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php endif;endforeach; ?>
                                    <?php endif; ?>

                                </div>

                                

                            </div>


                            <div class="tab-pane fade" id="store-sub" role="tabpanel" aria-labelledby="store-tab-sub"><!-- SUCURSALES B -->

                                <h1>SUCURSALES B</h1>


                                <!--begin::Row-->
                                <div class="row col-xl-12 otrosShowsB" style="padding-bottom:20px;padding-top:30px;">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            

        <!--end::Dashboard-->
		</div>
        <!--end::Container-->
	</div>
    <!--end::Entry-->
</div>
<!--end::Content-->

		