<style>
    @media only screen and (max-width: 600px) {
      #imgStart{display:none}
    }
    @media (min-width: 1700px){
        .container{max-width: 1700px;}
    }
    td,th{border:1px solid !important;}    
    
    .margen1Class{background: rgb(255,117,173);width:100px;}
    .margen2Class{background: rgb(255,192,0);width:100px;}
    li.nav-item.mb-2{border:1px solid #ccc;border-radius:12px;text-align:center;}
    a#sucursal-tab-uno,a#sucursal-tab-mat,a#sucursal-tab-2,a#sucursal-tab-3,a#sucursal-tab-4,a#sucursal-tab-5{padding-left:3rem;padding-right:3rem;}
    .inputransparent{background:rgba(0,0,0,.10);}
    .preciososRojos{width:150px;}
    .blockTh{background:#feffad;}
    .gensuca{background:aquamarine;padding:0;font-size:20px;}
    .precioB{background:#bdd7ee;}
    
    .th2{background:aquamarine;}
    .th22{background:#7fffd450;}
    tr:hover{background: #f5e5d0;}
    td.preC{font-weight:bold;font-size:16px;}
    .spandif{color:#b9b9b9;font-size:12px;}
    .thFecha{color:#000;background:#ecff82;}
    .th1{background:#303656;color:#FFF;}
    .ivaClass{background: rgb(255,204,102);}
    .renglon10Class{background: rgb(196,215,155);}
    .thE{background:#04a304;}
    .thE2{background:#04a30450;}
    .spandif2{color:#747474;font-size:12px;}
    .descos{font-size:16px;}
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
                                            <h4 class="text-info font-weight-bolder">ACTUALIZACIÓN DE PRECIOS    </h4>
                                            <p class="text-dark font-weight-bold mt-3">
                                                Descargar la plantilla para solicitar el cambio de precios, en la tabla podrá visualizar los productos que se subieron en el archivo excel. <br>
                                                Sí se suben ALTAS DE PRODUCTOS, se mostrarán en la segunda tabla. <br>
                                                Sí se solicita el ajuste de precio pero en código no coincide, se mostraran en la tercer tabla esos productos, puede volver a intentarlo con un cero (0) al inicio del código.

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
                <!--begin::Row-->
                <div class="row col-xl-12 dropRow" style="padding-bottom:20px;">
                    <div class="col-xl-2">
                        <a href="assets/uploads/templates/edicion.xlsx" class="btn btn-text-warning btn-icon-warning font-weight-bold btn-hover-bg-light mr-3" target="_blank" style="border-bottom:1px solid #ccc;box-shadow:5px 5px 8px #FFA800;border:1px solid #FFA800;padding:20px;">
                            <i class="flaticon2-file"></i> PLANTILLA <br>CAMBIO DE DESCRIPCIÓN
                        </a>
                    </div>
                    <div class="col-xl-2">
                        <a href="assets/uploads/templates/ajustes.xlsx" class="btn btn-text-primary btn-icon-primary font-weight-bold btn-hover-bg-light mr-3" target="_blank" style="border-bottom:1px solid #ccc;box-shadow:5px 5px 8px #F64E60;border:1px solid #F64E60;padding:20px;">
                            <i class="flaticon2-file"></i> PLANTILLA <br>AJUSTE DE PRECIOS
                        </a>
                    </div>
                    <div class="col-xl-2">
                        <a href="assets/uploads/templates/altas.xlsx" class="btn btn-text-success btn-icon-success font-weight-bold btn-hover-bg-light mr-3" target="_blank" style="border-bottom:1px solid #ccc;box-shadow:5px 5px 8px #1BC5BD;border:1px solid #1BC5BD;padding:20px;">
                            <i class="flaticon2-file"></i> PLANTILLA <br>ALTA DE PRODUCTOS
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="dropzone dropzone-default dropzone-success" id="kt_dropzone_uno">
                            <div class="dropzone-msg dz-message needsclick">
                                <h3 class="dropzone-msg-title">SUBIR ARCHIVO EXCEL</h3>
                                <span class="dropzone-msg-desc">Clic para seleccionar arhivo y/o arrastre el archivo excel.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Row-->


                <!--begin::Row-->
                <div class="row col-xl-12 " style="padding-bottom:20px;">
                    
                </div>
                <!--begin::Row-->                

                <!--begin::Row-->
                <div class="row col-xl-12 " style="padding-bottom:20px;">
                    <div class="row tableame">
                        <table class="table table-bordered" style="text-align:center;">
                            <tbody class="tbodyCompa">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Row-->



            <!--end::Dashboard-->
		</div>
        <!--end::Container-->
	</div>
    <!--end::Entry-->
</div>
<!--end::Content-->



<!--begin::Modal ELIMINAR ROW -->
<div class="modal fade" id="kt_modal_row" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ELIMINAR REGISTRO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                
                <i class="flaticon-warning kt-font-danger"></i>
                Al presionar "ELIMINAR" se borrará el registro. <br>
                Podrá registrar la linea subiendo un archivo excel. <br>
                En caso de estar segur@ con la eliminación presione el botón "Eliminar".
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary del_row">ELIMINAR</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->