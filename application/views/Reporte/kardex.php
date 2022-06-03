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
                                        <h4 class="text-info font-weight-bolder">BUSCAR PRODUCTO</h4>
                                        <p class="text-dark font-weight-bold mt-3">
                                            SE MOSTRARAN LOS ULTIMOS MOVIMIENTOS REGISTRADOS SEGUN EL PRODUCTO QUE SELECCIONE. <br>
                                            INGRESE EL PRODUCTO DESEADO Y SE MOSTRARÁN EN LA LISTA, AL CLIC EN "VER MAS" SE ABRIRA UNA PESTAÑA CON INFORMACIÓN MÁS DETALLADA DEL PRODUCTO.

                                        </p>
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

            <div class="row">
                <div class="col-xl-4">
                    <div class="form-group">
                        <label>BUSCAR PRODUCTO</label>
                        <input type="text" class="form-control"  placeholder="Puede buscar por codigo, descripción" id="kardexSearch" />
                        <span class="form-text text-muted">Se mostrarán los primeros 10 resultados</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <table class="table table-bordered table-striped rounded">
                        <thead class="thead-dark">
                            <tr>
                                <th>CÓDIGO</th>
                                <th>DESCRIPCIÓN</th>
                                <th>LINEA</th>
                                <th>UNIDAD</th>
                                <th>ENTRADAS (CEDIS)</th>
                                <th>REMISIONES</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody class="tbodyKardex">
                            
                        </tbody>
                    </table>
                </div>
            </div>

        <!--end::Dashboard-->
		</div>
        <!--end::Container-->
	</div>
    <!--end::Entry-->
</div>
<!--end::Content-->
