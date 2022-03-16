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
    .blockTh{background:#feffad;}
    .gensuca{background:aquamarine;padding:0;font-size:20px;}
    .precioB{background:#bdd7ee;}
    th{background:antiquewhite;}
    .cambioDe{background: #FFFF00;}
    .eliminDe{background: #FF8484;}
    .agregaDe{background: rgb(146,208,80);}
    .showBody{cursor:pointer;background:aqua;font-size:18px;}
    .dmo1{font-weight: bold;}
    .dmo2{color: red;}
    .rowLoadImg{height: 150px;}
    .bodoche>tr>td{padding-bottom:1px;}
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
                                        <h4 class="text-info font-weight-bolder">NUEVOS PRECIOS</h4>
                                        <p class="text-dark font-weight-bold mt-3">
                                            A continuación podrá visualizar los precios para actualizar.<br>
                                            Cualquier duda o sugerencia le pedimos comunicarse con el personal responsable en el área de compras.<br>
                                            <h1>SE MUESTRAN SÓLO LOS CAMBIOS DE LOS ÚLTIMOS 3 DÍAS.</h1>
                                        </p>
                                        <div class="form-group" style="border:1px dashed;padding:5px 15px;">
                                            <h3>SELECCIONE SI SE IMPRIMEN ETIQUETAS DE PRECIO</h3>
                                            <div class="radio-inline">
                                                <label class="radio radio-lg" style="font-size:16px">
                                                    <input type="radio" <?php if($etiqueto->printo == 1):echo 'checked="checked"';endif; ?> name="radio_no" class="radioC" value="1"/>
                                                    <span></span>
                                                    Sí se imprimen etiquetas.(Excepto carnes frias y semillas)
                                                </label>
                                                <div class="form-group row">
                                                    <div class="col-lg-6 col-md-9 col-sm-12">
                                                        <input type='text' class="form-control" id="no_etiquetas" type="text" value="<?php echo $etiqueto->manyp ?>" />
                                                        <span class="form-text text-muted"># ETIQUETAS</span>
                                                    </div>
                                                </div>
                                                <label class="radio radio-lg" style="font-size:16px">
                                                    <input type="radio" <?php if($etiqueto->printo == 0):echo 'checked="checked"';endif; ?> name="radio_no" class="radioC" value="0"/>
                                                    <span></span>
                                                    No etiquetas
                                                </label>
                                            </div>
                                        </div>
                                        <h3 class="text-danger">LA IMPRESORA DEBE ESTAR CONECTADA AL ADMINISTRADOR QUE REALICE EL CAMBIO</h3>
                                    </div>
                                </div>
                                <div class="position-absolute right-0 bottom-0 mr-5 overflow-hidden">
                                    <img src="assets/media/svg/illustrations/cajas.svg" style="height:400px;width:400px;margin-bottom:-27px;" id="imgStart" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Engage Widget 8-->
                </div>
            </div>
            <!--end::Row-->	
            <!--begin::Row-->
            <div class="row ml-lg-8 dropRow" style="padding-bottom:20px;">       
                <div class="col-xl-4">
                    <div class="row col-xl-12 rowLoad" style="padding-bottom:20px;">
                        <div class="col-xl-7">
                            <h1 class="text-warning">CARGANDO DATOS</h1>
                        </div>
                        <div class="col-xl-5">
                            <img src="assets/img/loading3.gif" class="rowLoadImg">
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="dropzone dropzone-default dropzone-warning" id="kt_dropzone_uno">
                        <div class="dropzone-msg dz-message needsclick">
                            <h3 class="dropzone-msg-title">SUBIR ARCHIVO TXT MATRICIAL / CATALOGO</h3>
                            <span class="dropzone-msg-desc">Clic para seleccionar arhivo y/o arrastre el archivo txt.</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4"></div>
                <div class="flex-row-lg-fluid col-xl-12">
                    <div class="row">
                        <h3 class="btn btn-sm btn-text btn-light-warning text-uppercase font-weight-bold" style="font-size:30px">
                            NO TE OLVIDES DE REGRESAR LOS PRECIOS DE LAS OFERTAS QUE HAN TERMINADO
                        </h3>
                    </div>
                    <div class="row bodyORec">
                    </div>
                    <!--end::Row-->

                </div>
                    <h1 style="text-align:center;font-size:40px;">OFERTAS ACTIVAS</h1>
                    
                    <div class="flex-row-lg-fluid col-xl-12">
                        <div class="row bodyOfes">
                        </div>
                    </div>
            </div>
            <!--end::Row-->

            <div class="row">
            	<div class="col-xl-12">
            		<div class="row col-xl-12 otrosShows" style="padding-bottom:20px;padding-top:30px;">
            			
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

<!--begin::Modal EDITAR DESCRIPCIÓN  -->
<div class="modal fade" id="kt_modal_compara" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">COMPARA PRECIOS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" style="text-align:center;">
                    <thead class="thead-dark">
                        <tr>
                            <th style="">CÓDIGO</th>
                            <th style="">NOMBRE</th>
                            <th style="">UM</th>
                            <th style="">RENGLON 10</th>
                            <th colspan="5">PRECIOS DEL 1 AL 5</th>
                        </tr>
                    </thead>
                    <tbody class="bodyModalCompara">
                        
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