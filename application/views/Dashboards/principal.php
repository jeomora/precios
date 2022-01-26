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
    .showBodyB,.showBody{cursor:pointer;background:aqua;font-size:18px;}

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

    .ofePz{background:rgb(255,204,255,.50);font-weight:bold;font-size:18px;padding-bottom:1px !important;}
    .ofeIn{background:rgba(112,48,160,.17);}
    .ofeTe{background:rgba(0,32,96,.17);}
    tr.bodyOfestr:hover{background: bisque;}
    .boldSpan{font-weight:bold;}
    .bodyModalOfes>tr:hover{background: bisque;}
    .dmo1{font-weight: bold;}
    .dmo2{color: red;}
</style>
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class=" container" style="min-width:95vw;overflow-x:scroll;">
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
                                <span class="nav-text">PAQUETES <br>
                                    <span class="fechaUpload">
                                        Hace <?php echo $hcatalo ?>
                                    </span>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="sucursal-tab-oferta" data-toggle="tab" href="#store-oferta">
                                <span class="nav-text">
                                    CATÁLOGO DE<br> ARTICULOS
                                </span>
                                <span>
                                    
                                </span>
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" id="sucursal-tab-subeoferta" data-toggle="tab" href="#store-subeoferta">
                                <span class="nav-text">
                                    AGREGAR <br> OFERTAS
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
                        <div class="tab-content" id="myTabContent1">
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

                            <div class="tab-pane fade" id="store-oferta" role="tabpanel" aria-labelledby="store-tab-oferta"><!-- CATÁLOGOS -->

                                <h1>SUBIR ARCHIVO CATÁLOGOS</h1>
                                <!--begin::Row-->
                                <div class="row col-xl-12 dropRow" style="padding-bottom:20px;">
                                    <div class="col-lg-4 col-md-4 col-sm-4"></div>         
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="dropzone dropzone-default dropzone-info" id="kt_dropzone_cata">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">SUBIR ARCHIVO TXT CATÁLOGO DE ARTICULOS</h3>
                                                <span class="dropzone-msg-desc">Clic para seleccionar arhivo y/o arrastre el archivo txt.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                        
                            <div class="tab-pane fade" id="store-cat" role="tabpanel" aria-labelledby="store-tab-cat"><!-- PAQUETES -->

                                <h1>SUBIR ARCHIVO PAQUETES</h1>
                                <!--begin::Row-->
                                <div class="row col-xl-12 dropRow" style="padding-bottom:20px;">
                                    <div class="col-lg-4 col-md-4 col-sm-4"></div>         
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div class="dropzone dropzone-default dropzone-info" id="kt_dropzone_dos">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">SUBIR ARCHIVO TXT PAQUETES</h3>
                                                <span class="dropzone-msg-desc">Clic para seleccionar arhivo y/o arrastre el archivo txt.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>

                            <div class="tab-pane fade" id="store-subeoferta" role="tabpanel" aria-labelledby="store-tab-subeoferta"><!-- OFERTAS -->
                                <div class="row ml-lg-8 dropRow dropRowMargin" style="padding-bottom:20px;">        
                                    <div class="col-xl-3">
                                        <div class="dropzone dropzone-default dropzone-info" id="kt_dropzone_ofertas">
                                            <div class="dropzone-msg dz-message needsclick">
                                                <h3 class="dropzone-msg-title">SUBIR ARCHIVO EXCEL OFERTAS</h3>
                                                <span class="dropzone-msg-desc">Clic para seleccionar arhivo y/o arrastre el archivo xlsx.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-row-lg-fluid col-xl-9">
                                        <div class="row">
                                            <h3 class="btn btn-sm btn-text btn-light-warning text-uppercase font-weight-bold" style="font-size:30px">
                                                NO TE OLVIDES DE REGRESAR LOS PRECIOS DE LAS OFERTAS QUE HAN TERMINADO
                                            </h3>
                                        </div>
                                        <div class="row bodyORec">
                                        </div>
                                    </div>
                                </div>
                                <!--end::Row-->

                                <h1 style="text-align:center;font-size:40px;">OFERTAS ACTIVAS</h1>
                                
                                <div class="flex-row-lg-fluid ml-lg-8">
                                    <div class="row bodyOfes">
                                    </div>
                                </div>
                                
                            </div>
                            
                            <div class="tab-pane fade" id="store-sua" role="tabpanel" aria-labelledby="store-tab-sua"><!-- SUCURSALES A -->

                                <h1>SUCURSALES A</h1>


                                <!--begin::Row-->
                                <div class="row col-xl-12 otrosShows" style="padding-bottom:20px;padding-top:30px;">
                                    

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


<!--begin::Modal EDITAR DESCRIPCIÓN  -->
<div class="modal fade" id="kt_modal_oferta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">LISTA DE PRODUCTOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" style="text-align:center;">
                    <thead class="thead-dark">
                        <tr>
                            <th style="background:rgb(255,0,102);color:#000;">INICIA</th>
                            <th class="modalOfeInicia" style="background:rgb(112,48,160);color:#FFF;"></th>
                            <th style="background:rgb(255,0,102);color:#000;">TERMINA</th>
                            <th colspan="2" class="modalOfeTermina" style="background:rgb(0,32,96);color:#FFF;"></th>
                            <th colspan="2" style="background:rgb(255,0,102);"></th>

                        </tr>
                        <tr>
                            <th style="background:#FFF;color:#000;">CÓDIGO</th>
                            <th style="background:#FFF;color:#000;">NOMBRE</th>
                            <th style="background:rgb(255,204,255);color:#000;">OFERTA</th>
                            <th style="background:rgb(244,176,132);color:#000;">NORMAL</th>
                            <th style="background:#FFF;color:#000;">MÁXIMO</th>
                            <th style="background:#FFF;color:#000;">ANTERIOR</th>
                            <th style="background:#FFF;color:#000;">PRECIO 5</th>
                        </tr>
                    </thead>
                    <tbody class="bodyModalOfes">
                        
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