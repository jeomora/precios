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
    .th1{background:antiquewhite;}
    .th2{background:aquamarine;}
    .th22{background:#7fffd450;}
    tr:hover{background: burlywood;}
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
                                            <h4 class="text-info font-weight-bolder">SUBIR ARCHIVO MATRICIAL    </h4>
                                            <p class="text-dark font-weight-bold mt-3">
                                                Al haber obtenido el archivo txt del sistema Compucaja, podrá seleccionarlo al clic en la parte del recuadro. <br>
                                                Se realizará la comparación y se mostrarán los productos registrados de su archivo que no tienen relación a los registrados en CEDIS. <br>

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


                <!--begin::Row-->
                <div class="row col-xl-12 " style="padding-bottom:20px;">
                    <a href="Compara/ExcelCompa" class="btn btn-text-dark-50 btn-icon-primary font-weight-bold btn-hover-bg-light mr-3" id="excelCompa" target="_blank" style="border-bottom:1px solid #ccc;box-shadow:5px 5px 8px #ccc;">
                        <i class="flaticon2-file"></i> DESCARGAR A UN EXCEL
                    </a>                    
                </div>
                <!--begin::Row-->
                <div class="row col-xl-12 " style="padding-bottom:20px;">
                    <div class="col-xl-6">
                        <h1>MÁS BAJO PRECIO 1:  <span class="countRojo"></span></h1>
                    </div>
                    <div class="col-xl-6">
                        <h1>MÁS ALTO PRECIO 1:  <span class="countVerde"></span></h1>
                    </div>
                </div>


                <!--begin::Row-->
                <div class="row col-xl-12 " style="padding-bottom:20px;">
                    <div class="row">
                        <table class="table table-bordered" style="text-align:center;">
                            <thead>
                                <tr>
                                    <th class="th1" colspan="3">SUPER</th>
                                    <th class="th1" colspan="5">PRECIOS<br>SUPER</th>
                                    <th class="th2" colspan="3">CEDIS</th>
                                    <th class="th2" colspan="5">PRECIOS<br>CEDIS</th>
                                </tr>
                                <tr>
                                    <th class="th1" style="width:100px" >CÓDIGO</th>
                                    <th class="th1" style="width:350px" >DESCRIPCIÓN</th>
                                    <th class="th1" style="width:70px" >UM</th>
                                    <th class="th1" style="width:70px" >PRECIO 1</th>
                                    <th class="th1" style="width:70px" >PRECIO 2</th>
                                    <th class="th1" style="width:70px" >PRECIO 3</th>
                                    <th class="th1" style="width:70px" >PRECIO 4</th>
                                    <th class="th1" style="width:70px" >PRECIO 5</th>
                                    <th class="th2" style="width:100px" >CÓDIGO</th>
                                    <th class="th2" style="width:350px" >DESCRIPCIÓN</th>
                                    <th class="th2" style="width:70px" >UM</th>
                                    <th class="th2" style="width:70px" >PRECIO 1</th>
                                    <th class="th2" style="width:70px" >PRECIO 2</th>
                                    <th class="th2" style="width:70px" >PRECIO 3</th>
                                    <th class="th2" style="width:70px" >PRECIO 4</th>
                                    <th class="th2" style="width:70px" >PRECIO 5</th>
                                </tr>
                            </thead>
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

		