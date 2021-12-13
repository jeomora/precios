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
    .codDes { position: sticky; left: 0; z-index: 10;background:#dfdfdf;border:1px solid !important;}
    .ivaClass{background: rgb(255,204,102,0.5);}
    .pre5,.pre55{background: rgb(204,153,255,0.5);}
    .renglon10Class{background: rgb(196,215,155,0.5);}
    .margen1Class{background: rgb(255,117,173,0.5);width:100px;}
    .margen2Class{background: rgb(255,192,0,0.5);width:100px;}
    li.nav-item.mb-2{border:1px solid #ccc;border-radius:12px;text-align:center;}
    a#sucursal-tab-uno,a#sucursal-tab-mat,a#sucursal-tab-2,a#sucursal-tab-3,a#sucursal-tab-4,a#sucursal-tab-5{padding-left:3rem;padding-right:3rem;}
    .inputransparent{background:rgba(0,0,0,.10);}
    .preciososRojos{width:150px;}
    .difPrecios{color:#b9b9b9;}
    .blockTh{background:#adffe8;}
    .gensuca{background:aquamarine;padding:0;font-size:20px;}
    .precioB{background:#bdd7ee;}
    th.thAsoc{background:#3595e9 !important;}
    td.thAsoc{background:#3595e950 !important;}
    .rowScroll::-webkit-scrollbar {-webkit-appearance:none;width: 7px;position: absolute;background: rgba(0,0,0,0.1);}
    .rowScroll::-webkit-scrollbar-thumb {border-radius: 4px;background-color: rgba(255, 0, 24, .5);-webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5)} 
    .footer{display:none !important;}
    .rowLinea:hover{background:#ffc7c7;cursor:pointer;}
    input.form-control.costoRojo,input.form-control.pre11Rojo,input.form-control.pre22Rojo,input.form-control.pre33Rojo,input.form-control.pre1Rojo,input.form-control.pre2Rojo,input.form-control.pre3Rojo,input.form-control.pre4Rojo {width:80px;padding:5px;}
    input.form-control.cantRojo,input.form-control.inputransparent.ivaRojo,input.form-control.pre44Rojo,input.form-control.mar11Rojo,input.form-control.mar22Rojo,input.form-control.mar33Rojo,input.form-control.mar44Rojo,input.form-control.mar1Rojo,input.form-control.mar2Rojo,input.form-control.mar3Rojo,input.form-control.mar4Rojo{width:60px;padding:5px;}
    textarea.form-control.inputransparent.descoUno,textarea.form-control.inputransparent.descoDos,input.form-control.inputransparent.codeDos{width:150px;}
    textarea.form-control.inputransparent.descoUno,textarea.form-control.inputransparent.descoDos{height:100px;}

input.form-control.bcostoRojo,input.form-control.bpre11Rojo,input.form-control.bpre22Rojo,input.form-control.bpre33Rojo,input.form-control.bpre1Rojo,input.form-control.bpre2Rojo,input.form-control.bpre3Rojo{width:80px;padding:5px;}
input.form-control.bcantRojo,input.form-control.bmar11Rojo,input.form-control.bmar22Rojo,input.form-control.bmar33Rojo,input.form-control.bmar1Rojo,input.form-control.bmar2Rojo,input.form-control.bmar3Rojo{width:60px;padding:5px;}
    .thAsoc{width: 170px;}
    @media (min-width: 992px){
        .content{padding:0px 0;}
    }
    tr.rojoTr:hover{background:#fbf6d4;}
    .rojoSure,.detSure{display:none;}
    .rojoDel,.rojoSure,.detSure{margin-top:10px;}
    .guardaBes{cursor:pointer;}
    td{padding:8px !important;}
    .form-control{border-radius: 3px;}
    .pzxum{background:#0002;font-weight:bold;}

    .cambioDe{background: #FFFF00;}
    .eliminDe{background: #FF8484;}
    .agregaDe{background: rgb(146,208,80);}
</style>
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class=" container" style="min-width:95vw;">
			<!--begin::Dashboard-->


            <div class="row" style="height:100%">
                <div class="col-xl-12">
                    <ul class="nav nav-pills"  role="tablist">
                        <li class="nav-item mb-2">
                            <a class="nav-link active" id="sucursal-tab-uno" data-toggle="tab" href="#store-uno">
                                <span class="nav-text">AJUSTE DE <br>PRECIOS
                                    <span class="fechaUpload">
                                        
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="sucursal-tab-oferta" data-toggle="tab" href="#store-oferta">
                                <span class="nav-text">
                                    AGREGAR <br> OFERTAS
                                </span>
                                <span>
                                    
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
                            <a class="nav-link" id="sucursal-tab-oferta" data-toggle="tab" href="#store-oferta">
                                <span class="nav-text">
                                    COMPARACIÓN <br> PRECIOS
                                </span>
                                <span>
                                    
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
                        <div class="tab-content" id="myTabContent1" style="overflow-x:hidden;">
                            <div class="tab-pane fade active show rowScroll" id="store-uno" role="tabpanel" aria-labelledby="store-tab-uno"  ><!-- MATRICIAL -->
                                <h1 style="margin-top:30px;">AJUSTE DE PRECIOS</h1>
                                <h6 style="margin-top:30px;" class="lastAjuste">ÚLTIMO AJUSTE : </h6>
                                <div class="row col-xl-12 dropRow" style="padding-bottom:20px;height:50rem;">
                                    <div class="col-xl-3">
                                        
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="dropzone dropzone-default dropzone-success" id="kt_dropzone_cuatro">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">SUBIR CAMBIOS</h3>
                                                <span class="dropzone-msg-desc">Clic para seleccionar arhivo y/o arrastre el archivo excel.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="tab-pane fade" id="store-mat" role="tabpanel" aria-labelledby="store-tab-mat"><!-- DESCRIPCIONES -->

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

                            <div class="tab-pane fade" id="store-oferta" role="tabpanel" aria-labelledby="store-tab-oferta"><!-- OFERTAS -->

                                <h1 style="margin-top:30px;">AGREGAR OFERTAS</h1>
                                <div class="col-xl-12" style="padding:20px">
                                    <!--<button type="button" class="btn btn-success btn-shadow-hover font-weight-bold mr-2"  data-toggle="modal" data-target="#kt_modal_oferta">
                                        AGREGAR OFERTA
                                    </button>-->
                                    <a href="assets/uploads/ofertas frutas.xlsx" class="btn btn-warning btn-shadow-hover font-weight-bold mr-2">
                                        PLANTILLA FRUTAS
                                    </a>
                                    <a href="assets/uploads/ofertas verduras.xlsx" class="btn btn-success btn-shadow-hover font-weight-bold mr-2">
                                        PLANTILLA VERDURAS
                                    </a>
                                    <a href="assets/uploads/ofertas varios.xlsx" class="btn btn-info btn-shadow-hover font-weight-bold mr-2">
                                        PLANTILLA PROMOCIONES
                                    </a>
                                </div>

                                
                                <div class="row col-xl-12"></div>
                                <div class="row col-xl-1"></div>
                                <div class="row col-xl-12 descos">
                                    <table class="table" style="text-align:center;">
                                        <thead class="bg-info text-white">
                                            <tr>
                                                <th width="12%">CAMBIAR/ELIMINAR</th>
                                                <th width="12%">CÓDIGO</th>
                                                <th width="40%">DESCRIPCIÓN</th>
                                                <th width="6%">UM</th>
                                                <th width="15%">OFERTA</th>
                                                <th width="15%">MÁXIMO</th>
                                            </tr>
                                        </thead>
                                        <tbody class="promoBody">
                                            <tr>
                                                <td colspan="6" style="font-size:24px;padding:0">
                                                    <img src="assets/img/loading1.gif" style="width:90px">CARGANDO LAS OFERTAS <img src="assets/img/loading1.gif" style="width:90px">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
                            
                            <div class="tab-pane fade" id="store-sua" role="tabpanel" aria-labelledby="store-tab-sua" style="padding:30px"><!-- SUCURSALES A -->

                                <h1>SUCURSALES A</h1>


                                <!--begin::Row-->
                                <div class="row col-xl-12 otrosShows" style="padding-bottom:20px;padding-top:30px;">
                                    <?php if($rojosHoy):foreach($rojosHoy as $key => $value):if($value["detalles"] <> null): ?>
                                        <div class="row" style="overflow-x:scroll;padding-bottom: 50px;">
                                            <table class="table table-bordered" style="text-align:center;">
                                                <thead>
                                                    <tr>
                                                        <th class="gensuca" colspan="5" style="padding:0">
                                                            <?php echo "GEN SUCA21-0".$value["id_nuevo"] ?>
                                                        </th>
                                                        <th>
                                                            <a class="nav-link" target="_blank" href="Codigos/qrme/<?php echo $value['id_nuevo'] ?>">
                                                                <img src="assets/img/codigo-qr.png" style="height:45px">
                                                            </a>
                                                        </th>
                                                        <th>
                                                            <a class="nav-link" target="_blank" href="Uploads/excelA/<?php echo $value['id_nuevo'] ?>">
                                                                <img src="assets/img/excel.svg" style="height:45px">
                                                            </a>
                                                        </th>
                                                        <th colspan="6">
                                                            <?php echo $fecha ?>
                                                        </th>
                                                        <th colspan="17" style="background:rgb(255,51,51)">AJUSTES</th>
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
                                                        <th style="width:100px" >CÓDIGO</th>
                                                        <th style="width:350px" >DESCRIPCIÓN</th>
                                                        <th style="" colspan="5">PRECIOS DEL 1 AL 5</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($value["detalles"] as $key2 => $val):if($val["estatus"]<>0): $renglon10 = ( $val["costo"]/$val["cantidad"] ) / ( 1+($val["iva"]/100) ); ?>
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
                                                            <td><?php echo number_format($val["pre11"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre22"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre33"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre44"],2,".",",") ?></td>
                                                            <td><?php echo number_format(($val["costo"]+0.01),2,".",",") ?></td>
                                                            <td><?php echo $val["code3"] ?></td>
                                                            <td><?php echo $val["desc2"] ?></td>
                                                            <td><?php echo number_format($val["pre1"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre2"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre3"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["pre4"],2,".",",") ?></td>
                                                            <td><?php echo number_format($val["costopz"],2,".",",") ?></td>
                                                        </tr>
                                                    <?php endif;endforeach; ?>
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




<!--begin::Modal EDITAR DESCRIPCIÓN  -->
<div class="modal fade" id="kt_modal_desco" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">EDITAR DESCRIPCIÓN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                
                <i class="flaticon-warning kt-font-danger"></i>
                Al presionar "EDITAR"  se realizará la edición de la descripción en la base de datos, y se mostrará a las sucursales para que realicen el cambio en sus sistemas Compucaja. <br>
                Sí esta segur@ de realizar el cambio precione el botón "EDITAR".
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success change_row">EDITAR</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->


<!--begin::Modal EDITAR DESCRIPCIÓN  -->
<div class="modal fade" id="kt_modal_lineas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">LINEAS DE PRODUCTOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" style="text-align:center;">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>IVA</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($lineas as $key => $value):?>
                            <tr class="rowLinea" data-id-rojo="<?php echo $value->ides ?>" data-id-iva="<?php echo number_format($value->iva,0) ?>">
                                <td><?php echo $value->ides ?></td>
                                <td><?php echo $value->nombre ?></td>
                                <td><?php echo number_format($value->iva,0) ?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->
