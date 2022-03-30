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
                                        <h4 class="text-info font-weight-bolder">LECTOR DE CÓDIGOS</h4>
                                        <p class="text-dark font-weight-bold mt-3">
                                            
                                        </p>

                                        <button type="button" class="btn btn-dark font-weight-bold mr-2" data-toggle="modal" data-target="#kt_modal_prodsImg">BUSCAR PRODUCTO</button>
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
            <!--begin::Row-->
            <div class="row ml-lg-8 dropRow" style="padding-bottom:20px;">       
                <div class="flex-row-lg-fluid col-xl-12">
                    <div class="row">
                        <h3 class="btn btn-sm btn-text btn-light-info text-uppercase font-weight-bold" style="font-size:30px">
                            LECTOR
                        </h3>
                    </div>
                    <div class="row bodyORec">
                    </div>
                    <!--end::Row-->

                </div>
                    <!--<h1 style="text-align:center;font-size:40px;">OFERTAS ACTIVAS</h1>
                    
                    <div class="flex-row-lg-fluid col-xl-12">
                        <div class="row bodyOfes">
                        </div>
                    </div>-->
            </div>
            <!--end::Row-->

            <div class="row col-xl-12">
                <p id="resultado">código</p>
                <p>A continuación, el contenedor: </p>
                <div id="contenedor"></div>
            </div>

            <!--begin::Row-->
            <div class="row rowtos">          
                <div class="col-md-4 my-2 my-md-0">
                    <div class="input-icon">
                        <input type="text" class="form-control" placeholder="Buscar en la tabla" id="tableSearch">
                        <span>
                            <i class="flaticon2-search-1 text-muted"></i>
                        </span>
                    </div>
                </div> 
                <div class="col-xl-12">
                    <!--begin::Advance Table Widget 10-->
                    <div class="card card-custom gutter-b card-stretch">
                        <!--begin::Body-->
                        <div class="card-body py-0" style="padding-bottom:30px !important">
                            <div class="kt-portlet__body kt-portlet__body--fit" id="cardTable"><div class="kt-datatable datatable datatable-bordered datatable-head-custom" id="prodTable"></div></div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Advance Table Widget 10-->
                </div>
            </div>
            <!--end::Row-->

            <div class="row">
            	<div class="col-xl-12">
            		<div class="row col-xl-12 otrosShowsB" style="padding-bottom:20px;padding-top:30px;">
            			
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
<div class="modal fade" id="kt_modal_imagen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CAMBIAR IMAGEN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body row col-xl-12">
                <input type="hidden" name="id_produs" id="id_produs" value="">
                <div class="col-xl-12">
                    <h1 class="h1Modaltitle"></h1>
                    <h2 class="h1Modalcode"></h1>
                    <h3 class="h1ModalUmd"></h1>
                </div>
                <div class="col-xl-4 imgPreview">
                    <img src="assets/uploads/productos/sinimagen.png" class="imgPreviews">
                </div>
                <div class="col-xl-8">
                    <div class="col-xl-12">
                        <div class="dropzone dropzone-default dropzone-success" id="kt_dropzone_img">
                            <div class="dropzone-msg dz-message needsclick">
                                <h3 class="dropzone-msg-title">SUBIR ARCHIVO IMAGEN (PNG|JPG|JPEG)</h3>
                                <span class="dropzone-msg-desc">Clic para seleccionar la imagen y/o arrastre el archivo.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12" style="display:inline-flex;padding:40px 20px;">
                        <div class="col-xl-5" style="height:10px;border-bottom:1px solid #ccc;"></div>
                        <div class="col-xl-2" style="text-align:center;font-weight:bold;">Ó</div>
                        <div class="col-xl-5" style="height:10px;border-bottom:1px solid #ccc;"></div>
                    </div>
                    <div class="col-xl-12">
                        <div class="input-group rounded bg-light">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="svg-icon svg-icon-lg">
                                        <!--begin::Svg Icon | path:/metronic/theme/html/demo5/dist/assets/media/svg/icons/General/Search.svg-->
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                                            </g>
                                        </svg>
                                        <!--end::Svg Icon-->
                                    </span>
                                </span>
                            </div>
                            <input type="text" class="form-control h-45px bscimg" placeholder="BUSCAR IMAGEN...">
                        </div>
                        <div class="form-text text-muted">SE MOSTRARÁN RESULTADOS A PARTIR DE LA 3 LETRA</div>
                        <div class="form-text text-muted">Ejemplo: 7151428724026, jitomate, fruta, DT, etc. (Sólo se muestran los primeros 12 resultados)</div>
                    </div>
                    <div class="col-xl-12 row resImgs">
                        
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                <!--<button type="button" class="btn btn-primary update_imagen" data-dismiss="modal">CANCELAR</button>-->
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->


<!--begin::Modal EDITAR DESCRIPCIÓN  -->
<div class="modal fade" id="kt_modal_prodsImg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">CAMBIAR IMAGEN DE ALGÚN PRODUCTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body row col-xl-12">
                <input type="hidden" name="id_produs2" id="id_produs2" value="">
                <div class="row col-xl-6">
                    <div class="input-group rounded bg-light">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <span class="svg-icon svg-icon-lg">
                                    <!--begin::Svg Icon | path:/metronic/theme/html/demo5/dist/assets/media/svg/icons/General/Search.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"></rect>
                                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </span>
                        </div>
                        <input type="text" class="form-control h-45px buscaProd1" placeholder="BUSCAR PRODUCTO...">
                    </div>
                    <div class="form-text text-muted">SE MOSTRARÁN RESULTADOS A PARTIR DE LA 3 LETRA</div><br>
                    <div class="form-text text-muted">Ejemplo: 7151428724026, PEPSI, BOING (Sólo se muestran los primeros 10 resultados)</div>
                </div>
                <div class="row col-xl-12">
                    <table class="table table-bordered table-hover rounded" id="tbleResos">
                        <thead class="thead-dark">
                            <tr>
                                <th>-</th>
                                <th>CÓDIGO</th>
                                <th>NOMBRE</th>
                                <th>UNIDAD</th>
                                <th>LN</th>
                                <th>LINEA</th>
                                <th>IMAGEN</th>
                                <th>SELECCIONAR</th>
                            </tr>
                        </thead>
                        <tbody id="tbleResosBody">

                        </tbody>
                    </table>
                </div>
                <div class="cambioSelec">
                    <div class="col-xl-12">
                        <h1 class="h1Modaltitle2"></h1>
                        <h2 class="h1Modalcode2"></h1>
                        <h3 class="h1ModalUmd2"></h1>
                    </div>
                    <div class="col-xl-4 imgPreview2">
                        <img src="assets/uploads/productos/sinimagen.png" class="imgPreviews2">
                    </div>
                    <div class="col-xl-8">
                        <div class="col-xl-12">
                            <div class="dropzone dropzone-default dropzone-success" id="kt_dropzone_img2">
                                <div class="dropzone-msg dz-message needsclick">
                                    <h3 class="dropzone-msg-title">SUBIR ARCHIVO IMAGEN (PNG|JPG|JPEG)</h3>
                                    <span class="dropzone-msg-desc">Clic para seleccionar la imagen y/o arrastre el archivo.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12" style="display:inline-flex;padding:40px 20px;">
                            <div class="col-xl-5" style="height:10px;border-bottom:1px solid #ccc;"></div>
                            <div class="col-xl-2" style="text-align:center;font-weight:bold;">Ó</div>
                            <div class="col-xl-5" style="height:10px;border-bottom:1px solid #ccc;"></div>
                        </div>
                        <div class="col-xl-12">
                            <div class="input-group rounded bg-light">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <span class="svg-icon svg-icon-lg">
                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo5/dist/assets/media/svg/icons/General/Search.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                    <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                    <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z" fill="#000000" fill-rule="nonzero"></path>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                        </span>
                                    </span>
                                </div>
                                <input type="text" class="form-control h-45px bscimg2" placeholder="BUSCAR IMAGEN...">
                            </div>
                            <div class="form-text text-muted">SE MOSTRARÁN RESULTADOS A PARTIR DE LA 3 LETRA</div><br>
                            <div class="form-text text-muted">Ejemplo: 7151428724026, jitomate, fruta, DT, etc. (Sólo se muestran los primeros 12 resultados)</div>
                        </div>
                        <div class="col-xl-12 row resImgs2">
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                <!--<button type="button" class="btn btn-primary update_imagen" data-dismiss="modal">CANCELAR</button>-->
            </div>
        </div>
    </div>
</div>
<!--end::Modal-->