<style>
    @media only screen and (max-width: 600px) {
      #imgStart{display:none}
    }
    @media (min-width: 1700px){
        .container{max-width: 1700px;}
    }
    .clickFacto{cursor:pointer;}
    .codeCaja{display:none;}
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
                                        <h4 class="text-info font-weight-bolder">BUSCAR Y AGREGAR FACTURAS A COMPUCAJA</h4>
                                        <p class="text-dark font-weight-bold mt-3">
                                            A continuación podrás encontrar algunas de las facturas que se han agregado a tu sucursal <br>
                                            Deberas buscar por el folio que viene en la factura y apareceran los resultados en la tabla <br>
                                            Confirma que sea del proveedor que requieres. Debes también que revisar los productos que correspondan a los que tienes en tu factura física. <br>
                                            Si no viene algún producto omitelo con el boton en la parte derecha del renglon, así tambien puedes editar el numero de productos. <br>

                                        </p>
                                        <button type='button' class='btn btn-success addFacto h3 px-12 py-2' data-toggle='modal' data-target='#modalBuscaf'>AGREGA NUEVA NOTA</button>
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

            <div class="row prenots">

                
            </div>

            <div class="row">
                <div class="flex-column flex-lg-row-auto col-xl-12">
                    <!--begin::Card-->
                    <div class="card">
                        <!--
                        <div class="card-body col-xl-12">
                            <div class="form-group col-xl-4">
                                <div class="input-group input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-search "></i></span></div>
                                    <input type="text" class="form-control fieldFactos" placeholder="Buscar Folio" />
                                </div>
                                <span class="form-text text-muted">INGRESE EL FOLIO QUE APARECE EN SU FACTURA</span>
                            </div>
                            
                            <div class="d-flex align-items-center col-xl-2">
                                <button type="button" class="btn btn-primary me-5" id="buscofactos">Buscar</button>
                            </div>
                            
                        </div>
                        -->
                    </div>
                    <!--end::Card-->
                </div>
            </div>

            <div class="row">
                <div class="col-xl-3">
                    <!--begin::List Widget 4-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">RESULTADOS DE BÚSQUEDA</h3>
                            <div class="card-toolbar">
                                
                            </div>
                        </div>
                        <div class="card-body pt-2 resolF">
                            
                            
                            

                        </div>-->
                    </div>
                    <!--end:List Widget 4-->
                </div>

            </div>
                
            <!--end::Dashboard-->
		</div>
        <!--end::Container-->
	</div>
    <!--end::Entry-->
</div>
<!--end::Content-->



<!--begin::Modal BUSCAR FACTO-->
<div class="modal fade" id="modalBuscaf" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">BUSCAR PRODUCTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light alert-elevate" role="alert">
                    <div class="alert-icon"><i class="flaticon-warning kt-font-danger"></i></div>
                    <div class="alert-text">
                        Al seleccionar el producto este se mostrará en la pantalla anterior justo en el renglon seleccionado previamente.<br>
                        Se mostrarán los primeros 15 resultados, en caso de no encontrar el producto deseado prueba otra palabra clave, o el código del producto.
                    </div>
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="form-control-label">Buscar producto.</label>
                    <input type="text" class="form-control" id="buscaProd" name="buscaProd">
                    <span class="form-text text-muted">INGRESE SU BUSQUEDA COMO CÓDIGO, PALABRA CLAVE, ETC.</span>
                </div>
                <div class="row col-xl-12">
                    <table class="table table-bordered table-striped rounded">
                        <thead class="thead-dark">
                            <tr>
                                <th>CÓDIGO</th>
                                <th>NOMBRE</th>
                                <th>UM</th>
                                <th>PRECIO</th>
                            </tr>
                        </thead>
                        <tbody class="tbodyBuscaP">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->


<!--begin::Modal VER MAYOREO-->
<div class="modal fade" id="modalDetailsF" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-xl" role="document" style="min-width:98%;max-width:98%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">PRE NOTA NAYOREO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row col-xl-12">
                    <div class="col-xl-9" style="">
                        <table class="table table-bordered table-striped rounded">
                            <thead class="thead-dark text-center">
                                <tr>
                                    <th colspan="2">MAYOREO</th>
                                    <th colspan="4" style="background-color:#3F5bF5">COMPUCAJA</th>
                                    <th colspan="3" class="bg-success">FACTURA</th>
                                    <th>TUS DATOS</th>
                                </tr>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>CANTIDAD</th>
                                    <th style="background-color:#3F5bF5">CÓDIGO</th>
                                    <th style="background-color:#3F5bF5">NOMBRE</th>
                                    <th style="background-color:#3F5bF5">UNIDAD</th>
                                    <th style="background-color:#3F5bF5">PRECIO</th>
                                    <th class="bg-success">CODIGO</th>
                                    <th class="bg-success">NOMBRE</th>
                                    <th class="bg-success">CANTIDAD</th>
                                    <th>REAL</th>
                                </tr>
                            </thead>
                            <tbody class="tbodyBuscaP">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xl-3 buscFacto" style="box-shadow:0px 0px 30px 0px rgb(82 63 105);border-radius:5px;">
                        <h1 style="padding-top:15px">ASOCIAR FACTURA</h1>
                        <div class="card-body col-xl-12">
                            <div class="form-group">
                                <div class="input-group input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="la la-search "></i></span></div>
                                    <input type="text" class="form-control fieldFactos" placeholder="Buscar Folio" />
                                </div>
                                <span class="form-text text-muted">INGRESE EL FOLIO QUE APARECE EN SU FACTURA</span>
                            </div>
                            <!--begin:Action-->
                            <div class="d-flex align-items-center col-xl-2">
                                <button type="button" class="btn btn-primary me-5" id="buscofactos">Buscar</button>
                            </div>
                            <!--end:Action-->
                        </div>
                        <!--end::Body-->
                        <div class="col-xl-12">
                            <div class="card-body pt-2 resolF" style="height:35rem;overflow-y:scroll;">
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 detaFacto" style="display:none;box-shadow:0px 0px 30px 0px rgb(82 63 105);border-radius:5px;">
                        <div class="card card-custom col-xl-12" style="padding:0;">
                            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                                <div class="card-title">
                                    <h3 class="card-label labelFacto">.....
                                    <span class="d-block text-muted pt-2 font-size-sm">PRODUCTOS EN LA FACTURA</span></h3>
                                </div>
                            </div>
                            <div class="card-body" style="padding:0">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="font-size:10px">CÓDIGO</th>
                                            <th style="font-size:10px">DESCRIPCIÓN</th>
                                            <th class="bg-success" style="font-size:10px;">IDES</th>
                                            <th style="font-size:10px">CANTIDAD</th>
                                            <th style="font-size:10px">UNIDAD</th>
                                            <th style="font-size:10px">IMPORTE</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbodyFacto" style="font-size:11px">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->

