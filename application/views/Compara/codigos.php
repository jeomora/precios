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
    .cofes{background: #f7c9ff;}
    img.rowLoadImg {height: 150px;}
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
                                <div class="d-flex align-items-start justify-content-start flex-grow-1 bg-light-primary p-8 card-rounded flex-grow-1 position-relative">
                                    <div class="d-flex flex-column align-items-start flex-grow-1 h-100">
                                        <div class="p-1 flex-grow-1">
                                            <h4 class="text-primary font-weight-bolder">COMPARACIÓN DE CÓDIGOS A CEDIS    </h4>
                                            <p class="text-dark font-weight-bold mt-3">
                                                SE MOSTRARÁN LOS CÓDIGOS QUE NO COINCIDEN ENTRE LAS SUCURSALES<br>
                                                SE PODRÁ REALIZAR LA COMPARACIÓN DE DESCRIPCIONES DEL PRODUCTO.

                                            </p>
                                        </div>
                                    </div>
                                    <div class="position-absolute right-0 bottom-0 mr-5 overflow-hidden">
                                        <img src="assets/media/svg/illustrations/datacodes.svg" style="height:280px;width:280px;margin-bottom:-80px;" id="imgStart" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Engage Widget 8-->
                    </div>
                </div>
                <!--end::Row-->

                <div class="row col-xl-12">
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <button type="button" class="btn btn btn-outline-secondary font-weight-bold btnSucuCedis btnSucuCedis8 btn-danger" data-id-user="8" data-id-rojo="SUPER">
                            SUPER CD INDUSTRIAL<br>
                            <?php if(isset($lasta[8])):echo $dias[date('w',strtotime($lasta[8]["lastdate"]))]." ".date('d',strtotime($lasta[8]["lastdate"]))." DE ".$meses[date('n',strtotime($lasta[8]["lastdate"]))-1]." ".date('H:i:s', strtotime($lasta[8]["lastdate"]));else:echo "Sin Registro";endif; ?><br>
                            <span style="font-size:16px"><?php if(isset($lasta[8])):$now=time();$datediff=$now-strtotime($lasta[8]["lastdate"]);echo "(".round($datediff / (60 * 60 * 24))." días)";endif; ?></span><br>
                        </button>
                        <button type="button" class="btn btn btn-outline-secondary font-weight-bold btnSucuCedis btnSucuCedis1" data-id-user="1" data-id-rojo="TIJERAS">
                            TIJERAS<br>
                            <?php if(isset($lasta[1])):echo $dias[date('w',strtotime($lasta[1]["lastdate"]))]." ".date('d',strtotime($lasta[1]["lastdate"]))." DE ".$meses[date('n',strtotime($lasta[1]["lastdate"]))-1]." ".date('H:i:s', strtotime($lasta[1]["lastdate"]));else:echo "Sin Registro";endif; ?><br>
                            <span style="font-size:16px"><?php if(isset($lasta[1])):$now=time();$datediff=$now-strtotime($lasta[1]["lastdate"]);echo "(".round($datediff / (60 * 60 * 24))." días)";endif; ?></span><br>
                        </button>
                        <button type="button" class="btn btn btn-outline-secondary font-weight-bold btnSucuCedis btnSucuCedis2" data-id-user="2" data-id-rojo="TENENCIA">
                            TENENCIA<br>
                            <?php if(isset($lasta[2])):echo $dias[date('w',strtotime($lasta[2]["lastdate"]))]." ".date('d',strtotime($lasta[2]["lastdate"]))." DE ".$meses[date('n',strtotime($lasta[2]["lastdate"]))-1]." ".date('H:i:s', strtotime($lasta[2]["lastdate"]));else:echo "Sin Registro";endif; ?><br>
                            <span style="font-size:16px"><?php if(isset($lasta[2])):$now=time();$datediff=$now-strtotime($lasta[2]["lastdate"]);echo "(".round($datediff / (60 * 60 * 24))." días)";endif; ?></span><br>
                        </button>
                        <button type="button" class="btn btn btn-outline-secondary font-weight-bold btnSucuCedis btnSucuCedis3" data-id-user="3" data-id-rojo="MERCADO">
                            MERCADO<br>
                            <?php if(isset($lasta[3])):echo $dias[date('w',strtotime($lasta[3]["lastdate"]))]." ".date('d',strtotime($lasta[3]["lastdate"]))." DE ".$meses[date('n',strtotime($lasta[3]["lastdate"]))-1]." ".date('H:i:s', strtotime($lasta[3]["lastdate"]));else:echo "Sin Registro";endif; ?><br>
                            <span style="font-size:16px"><?php if(isset($lasta[3])):$now=time();$datediff=$now-strtotime($lasta[3]["lastdate"]);echo "(".round($datediff / (60 * 60 * 24))." días)";endif; ?></span><br>
                        </button>
                        <button type="button" class="btn btn btn-outline-secondary font-weight-bold btnSucuCedis btnSucuCedis4" data-id-user="4" data-id-rojo="TRINCHERAS">
                            TRINCHERAS<br>
                            <?php if(isset($lasta[4])):echo $dias[date('w',strtotime($lasta[4]["lastdate"]))]." ".date('d',strtotime($lasta[4]["lastdate"]))." DE ".$meses[date('n',strtotime($lasta[4]["lastdate"]))-1]." ".date('H:i:s', strtotime($lasta[4]["lastdate"]));else:echo "Sin Registro";endif; ?><br>
                            <span style="font-size:16px"><?php if(isset($lasta[4])):$now=time();$datediff=$now-strtotime($lasta[4]["lastdate"]);echo "(".round($datediff / (60 * 60 * 24))." días)";endif; ?></span><br>
                        </button>
                        <button type="button" class="btn btn btn-outline-secondary font-weight-bold btnSucuCedis btnSucuCedis5" data-id-user="5" data-id-rojo="ULTRAMARINOS">
                            ULTRAMARINOS<br>
                            <?php if(isset($lasta[5])):echo $dias[date('w',strtotime($lasta[5]["lastdate"]))]." ".date('d',strtotime($lasta[5]["lastdate"]))." DE ".$meses[date('n',strtotime($lasta[5]["lastdate"]))-1]." ".date('H:i:s', strtotime($lasta[5]["lastdate"]));else:echo "Sin Registro";endif; ?><br>
                            <span style="font-size:16px"><?php if(isset($lasta[5])):$now=time();$datediff=$now-strtotime($lasta[5]["lastdate"]);echo "(".round($datediff / (60 * 60 * 24))." días)";endif; ?></span><br>
                        </button>
                        <button type="button" class="btn btn btn-outline-secondary font-weight-bold btnSucuCedis btnSucuCedis6" data-id-user="6" data-id-rojo="SOLIDARIDAD">
                            SOLIDARIDAD<br>
                            <?php if(isset($lasta[6])):echo $dias[date('w',strtotime($lasta[6]["lastdate"]))]." ".date('d',strtotime($lasta[6]["lastdate"]))." DE ".$meses[date('n',strtotime($lasta[6]["lastdate"]))-1]." ".date('H:i:s', strtotime($lasta[6]["lastdate"]));else:echo "Sin Registro";endif; ?><br>
                            <span style="font-size:16px"><?php if(isset($lasta[6])):$now=time();$datediff=$now-strtotime($lasta[6]["lastdate"]);echo "(".round($datediff / (60 * 60 * 24))." días)";endif; ?></span><br>
                        </button>
                    </div>
                </div>

                <div class="row col-xl-12" style="padding-bottom:50px">
                    
                </div>


                <!--begin::Row-->
                <div class="row col-xl-12 " style="padding-bottom:20px;">
                    <a href="Compara/ExcelCompaCedis/8" class="btn btn-text-dark-50 btn-icon-primary font-weight-bold btn-hover-bg-light mr-3" id="excelCompa" target="_blank" style="border-bottom:1px solid #ccc;box-shadow:5px 5px 8px #ccc;display:none;">
                        <i class="flaticon2-file"></i> DESCARGAR A UN EXCEL
                    </a>                    
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row col-xl-12 " style="padding-bottom:20px;">
                    <div class="btn-group btn-group-lg" role="group" aria-label="Large button group">
                        <button type="button" class="btn btn-outline-secondary btnCualBusco" data-id-rojo="10">DESCRIPCIÓN</button>
                        <button type="button" class="btn btn-outline-secondary btnCualBusco btn-danger btnCualBusco1" data-id-rojo="1">CÓDIGOS</button>
                        <!--<button type="button" class="btn btn-outline-secondary btnCualBusco btnCualBusco2" data-id-rojo="2">PRECIO 2</button>
                        <button type="button" class="btn btn-outline-secondary btnCualBusco btnCualBusco3" data-id-rojo="3">PRECIO 3</button>
                        <button type="button" class="btn btn-outline-secondary btnCualBusco btnCualBusco4" data-id-rojo="4">PRECIO 4</button>
                        <button type="button" class="btn btn-outline-secondary btnCualBusco btnCualBusco5" data-id-rojo="5">PRECIO 5</button>-->
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
                <div class="row col-xl-12 " style="padding-bottom:20px;">
                    <div class="col-xl-6">
                        <h1>CODIGOS QUE NO TIENE CEDIS:  <span class="countRojo"></span></h1>
                    </div>
                    <div class="col-xl-6">
                        <h1>DESCRIPCIONES DIFERENTES:  <span class="countVerde"></span></h1>
                    </div>
                </div>

                <div class="row col-xl-12">
                    
                    
                </div>

                <!--begin::Row-->
                <div class="row col-xl-6 rowLoad" style="padding-bottom:20px;">
                    <div class="col-xl-3">
                        <h1 class="text-warning">CARGANDO DATOS</h1>
                    </div>
                    <div class="col-xl-6">
                        <img src="assets/img/loading3.gif" class="rowLoadImg">
                    </div>
                </div>
                <div class="row col-xl-12 " style="padding-bottom:20px;">
                    <div class="row">
                        <table class="table table-bordered tableAll1" style="text-align:center;">
                            <thead>
                                <tr>
                                    <th class="th1 thSucus" colspan="4">SUCURSAL</th>
                                </tr>
                                <tr>
                                    <th class="th1" style="width:50px" >#</th>
                                    <th class="th1" style="width:100px" >CÓDIGO</th>
                                    <th class="th1" style="width:350px" >DESCRIPCIÓN</th>
                                    <th class="th1" style="width:70px" >UM</th>
                                </tr>
                            </thead>
                            <tbody class="tbodyCompa">

                            </tbody>
                        </table>
                    </div>
                </div>
                <!--end::Row-->
                <div class="row col-xl-12 " style="padding-bottom:20px;">
                    <div class="row">
                        <table class="table table-bordered tableAll2" style="text-align:center;display:none;">
                            <thead>
                                <tr>
                                    <th class="th1 thSucus" colspan="4">SUPER</th>
                                    <th class="th2" colspan="3">CEDIS</th>
                                </tr>
                                <tr>
                                    <th class="th1" style="width:50px" >#</th>
                                    <th class="th1" style="width:100px" >CÓDIGO</th>
                                    <th class="th1" style="width:350px" >DESCRIPCIÓN</th>
                                    <th class="th1" style="width:70px" >UM</th>
                                    <th class="th2" style="width:100px" >CÓDIGO</th>
                                    <th class="th2" style="width:350px" >DESCRIPCIÓN</th>
                                    <th class="th2" style="width:70px" >UM</th>
                                </tr>
                            </thead>
                            <tbody class="tbodyCompa2">

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row col-xl-12 rowLoad" style="padding-bottom:20px;">
                    <div class="col-xl-3">
                        <h1 class="text-warning">CARGANDO DATOS</h1>
                    </div>
                    <div class="col-xl-6">
                        <img src="assets/img/loading3.gif" class="rowLoadImg">
                    </div>
                </div>



            <!--end::Dashboard-->
		</div>
        <!--end::Container-->
	</div>
    <!--end::Entry-->
</div>
<!--end::Content-->

		