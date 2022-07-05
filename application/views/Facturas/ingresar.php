<style type="text/css">
    .input-group-text,.input-group-prepend,input{border-color:#000 !important;}
    .input-group-text{background:#000 !important;}
</style>

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class=" container" style="min-width:96vw;">
			<!--begin::Dashboard-->

                <div class="row">
                    <div class="flex-column flex-lg-row-auto col-xl-12">
                        <!--begin::Card-->
                        <div class="card">
                            <!--begin::Body-->
                            <div class="card-body col-xl-8">
                                <div class="form-group col-xl-4">
                                    <div class="input-group input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="text-white flaticon-folder-1"></i></span></div>
                                        <input type="text" class="form-control folioFacto" placeholder="INGRESA EL FOLIO" name="folioFacto" />
                                    </div>
                                    <span class="form-text text-muted txt1" id="txt1">INGRESA EL FOLIO DE LA FACTURA</span>
                                </div>
                                <div class="form-group col-xl-4">
                                    <div class="input-group input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="text-white flaticon-truck"></i></span></div>
                                        <input type="text" class="form-control proveeFacto" placeholder="NOMBRE DEL PROVEEDOR" name="proveeFacto" />
                                    </div>
                                    <span class="form-text text-muted txt2" id="txt2">INGRESA EL NOMBRE DEL PROVEEDOR</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Card-->
                        <div class="col-xl-12">
                            <h1>No. PRODUCTOS : <span class="noprods text-bold">0</span></h1>
                        </div>
                        <div class="card">
                            <div class="card-body col-xl-12" style="display: inline-flex;">
                                <div class="form-group col-xl-4">
                                    <div class="input-group input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="text-white flaticon-cart"></i></span></div>
                                        <input type="text" class="form-control codeProd" placeholder="CÓDIGO DEL PRODUCTO" name="codeProd" />
                                    </div>
                                    <span class="form-text text-muted txt3" id="txt3">PRODUCTO</span>
                                </div>

                                <div class="form-group col-xl-4">
                                    <div class="input-group input-group">
                                        <div class="input-group-prepend"><span class="input-group-text"><i class="text-white flaticon-layers"></i></span></div>
                                        <input type="text" class="form-control cantProd" placeholder="CANTIDAD EN LA FACTURA" name="cantProd" />
                                    </div>
                                    <span class="form-text text-muted txt4" id="txt4">CANTIDAD EN LA FACTURA</span>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>CÓDIGO</th>
                                                <th>COMPUCAJA</th>
                                                <th>CANTIDAD</th>
                                                <th>ELIMINAR</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbodyPreFacto">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xl-12" style="text-align:right;padding:20px;">
                                <div class="btn btn-light-success d-inline-flex align-items-center btn-lg mr-5 saveNote">
                                    <div class="d-flex flex-column text-right pr-3">
                                        <span class="text-dark-75 font-weight-bold font-size-sm">GUARDAR</span>
                                        <span class="font-weight-bolder font-size-sm">CTRL + M</span>
                                    </div>
                                    <span class="symbol symbol-40">
                                        <img alt="Pic" src="assets/media/svg/icons/General/Save.svg"/>
                                    </span>
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

