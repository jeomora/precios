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
                                        <h4 class="text-info font-weight-bolder">REPORTE DE SUCURSALES</h4>
                                        <p class="text-dark font-weight-bold mt-3">
                                            Como predeterminado se muestra la sucursal Super Cd Industrial, podra seleccionar cualquiera o todas las sucursales.<br>
                                            Puede seleccionar/agregar un producto a la consulta o si lo prefiere una familia(linea) de productos.<br>
                                            Puede seleccionar el rango de fechas para obtener su consulta, de manera predeterminada se selecciona un rango de 1 semana.<br>
                                            El boton "DESCARGAR REPORTE EXCEL" tomara los parametros de su busqueda y los agregara a su reporte
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
                <div class="col-xl-12">
                    <div class="col-xl-4">
                        <div class="form-group">
                            <div class="input-icon">
                                <input type="text" class="form-control" placeholder="Buscar producto..."/>
                                <span><i class="flaticon2-search-1 icon-md"></i></span>
                            </div>
                            <span class="form-text text-muted">Ejemplo: Amarilla</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-4">
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <select class="form-control select2" id="selectLinea" name="selectLinea">
                                    <option value="0">SELECCIONE UNA LINEA(FAMILIA)</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="CA">California</option>
                                    <option value="NV">Nevada</option>
                                    <option value="OR">Oregon</option>
                                    <option value="WA">Washington</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="CO">Colorado</option>
                                    <option value="ID">Idaho</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="UT">Utah</option>
                                    <option value="WY">Wyoming</option>
                                    <option value="AL">Alabama</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TX">Texas</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="IN">Indiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="OH">Ohio</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WV">West Virginia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="col-xl-4">
                        <label class="col-sm-12">RANGO DE FECHAS</label>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <input type='text' class="form-control" id="rangeFecha" readonly placeholder="SELECCIONE EL RANGO DE FECHAS" type="text" name="rangeFecha" />
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

