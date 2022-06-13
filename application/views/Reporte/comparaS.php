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
                                        <h4 class="text-info font-weight-bolder">COMPARAR NOTAS DE ENTRADA CON CEDIS</h4>
                                        <p class="text-dark font-weight-bold mt-3">
                                            AGREGUE SU ARCHIVO TXT CON SUS NOTAS DE ENTRADA DEL DÍA <br>
                                            SÓLO SE MOSTRARÁN LAS NOTAS DEL DÍA CORRIENTE, EN CASO DE QUE SE REQUIERA UNA NOTA QUE NO SE VEA REFLEJADA POR LA FECHA COMUNICARSE AL ÁREA CORRESPONDIENTE. <br>
                                            SE MOSTRARÁ EL COMPARATIVO COMPLETO CUANDO CEDIS HAYA TERMINADO SU REGISTRO DE ARCHIVOS Y SE MOSTRARÁN LAS COMPARACIONES EN SU PANTALLA. <br> 
                                            SI NO SE MUESTRAN LOS RESULTADOS Y SE HA ASEGURADO QUE TANTO CEDIS COMO EN SU SUCURSAL SE SUBIERON LOS ARCHIVOS TXT CORRESPONDIENTES COMUNIQUESE AL ÁREA DE SISTEMAS. 

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

            <!--end::Row-->
            <div class="row col-xl-12 allInvVen">          
                <div class="col-xl-12">
                    <div class="dropzone dropzone-default dropzone-success" id="kt_dropzone_venta">
                        <div class="dropzone-msg dz-message needsclick">
                            <h3 class="dropzone-msg-title">Clic para seleccionar archivo txt.</h3>
                            <span class="dropzone-msg-desc">Usuarlmente el archivo txt de notas de entrada se llama CEI0675R</span>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
            <div class="row col-xl-12"
            >
                <h1>
                    Lista Notas De Entrada
                </h1>
                <?php if($entradas): ?>
                    <?php foreach($entradas as $key => $value): ?>
                        <div class="row col-xl-12">
                            <table class="table" style="text-align:center;">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>
                                            <span>Folio</span>
                                        </th>
                                        <th>
                                            <span>Proveedor</span>
                                        </th>
                                        <th>
                                            <span>Nombre</span>
                                        </th>
                                        <th>
                                            <span>Fecha</span>
                                        </th>
                                        <th>
                                            <span>Referencia</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    <tr class="">
                                        <td class="">
                                            <span class="font-weight-bolder font-size-h5"><?php echo $value["folio"] ?></span>
                                        </td>
                                        <td class="">
                                            <span class="font-weight-bolder font-size-h5"><?php echo $value["proveedor"] ?></span>
                                        </td>
                                        <td class="">
                                            <span class="font-weight-bolder font-size-h5"><?php echo $value["provee"] ?></span>
                                        </td>
                                        <td class="">
                                            <span class="font-weight-bolder font-size-h5"><?php echo $value["fecha"] ?></span>
                                        </td>
                                        <td class="">
                                            <span class="font-weight-bolder font-size-h5"><?php echo $value["agrego"] ?></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered" style="text-align:center;">
                                <thead class="thead-ligth">
                                    <tr>
                                        <th>
                                            <span>Articulo</span>
                                        </th>
                                        <th>
                                            <span>Descripción</span>
                                        </th>
                                        <th>
                                            <span>Unidad</span>
                                        </th>
                                        <th>
                                            <span>Cantidad</span>
                                        </th>
                                        <th>
                                            <span>Precio</span>
                                        </th>
                                        <th>
                                            <span>Importe</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="">
                            <?php if($value["detalles"]):foreach($value["detalles"] as $key => $val): ?>
                                        <tr class="">
                                            <td class="">
                                                <span><?php echo "00-".$val["familia"]."-".$val["producto"] ?></span>
                                            </td>
                                            <td class="">
                                                <span><?php echo $val["descripcion"] ?></span>
                                            </td>
                                            <td class="">
                                                <span><?php echo $val["unidad"] ?></span>
                                            </td>
                                            <td class="">
                                                <span><?php echo $val["cantidad"] ?></span>
                                            </td>
                                            <td class="">
                                                <span><?php echo $val["precio"] ?></span>
                                            </td>
                                            <td class="">
                                                <span class="font-weight-bolder font-size-h5"><?php echo number_format($val["importe"],2,".",",") ?></span>
                                            </td>
                                        </tr>
                            <?php endforeach;endif; ?>
                                </tbody>
                                <thead class="thead-ligth">
                                    <tr>
                                        <th colspan="2">
                                            <span>Subtotal: $ <?php echo number_format($value["subtotal"],2,".",",") ?></span>
                                        </th>
                                        <th colspan="2">
                                            <span>Sin iva: $ <?php echo number_format($value["siniva"],2,".",",") ?></span>
                                        </th>
                                        <th colspan="2">
                                            <span class="font-weight-bolder font-size-h5">Total: $ <?php echo number_format($value["total"],2,".",",") ?></span>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <!--end::Dashboard-->

        <!--end::Dashboard-->
		</div>
        <!--end::Container-->
	</div>
    <!--end::Entry-->
</div>
<!--end::Content-->
