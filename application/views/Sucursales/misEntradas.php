<style>
@media only screen and (min-width: 800px) {
 .text-dark-50.font-weight-bold.mt-3{max-width:70%;}
 .inventarioDiv{border-right:2px solid #000;}     
}
@media only screen and (max-width: 600px) {
  #imgStart{display:none}
  .ventasDiv{margin-top: 20px;}
  .modal-body{padding:10px 0px;}
}
.inventarioImg,.ventasImg,.ventaImg,.imgJustUp{border:1px solid #ececec;max-width:100%;}
h1.inventarioTotal,h1.ventaTotal{font-size:3rem;}
.inventarioDiv,.ventasDiv{box-shadow:10px 10px 5px #aaaaaa;border:1px solid #ececec;padding:20px;}
.allInvVen{text-align:center;padding-right:0;}
</style>
<!--begin::Content-->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class=" container ">
            <!--begin::Dashboard-->
            <!--begin::Row-->
            <div class="row">
                <div class="col-xl-12">
                    <!--begin::Engage Widget 8-->
                    <div class="card card-custom gutter-b card-stretch card-shadowless">
                        <div class="card-body p-0 d-flex">
                            <div class="d-flex align-items-start justify-content-start flex-grow-1 bg-light p-8 card-rounded flex-grow-1 position-relative">
                                <div class="d-flex flex-column align-items-start flex-grow-1 h-100">
                                    <div class="p-1 flex-grow-1">
                                        <h4 class="text-dark font-weight-bolder">Mis Archivos TXT,DAT Desde Compucaja</h4>
                                        <p class="text-dark-50 font-weight-bold mt-3">
                                            En la parte baja podrá subir a la plataforma los archivos txt. <br>
                                            En el texto de abajo le aparecera el enlace para descargar los archivos, en caso de querer asegurarse de haber subido el archivo correcto.
                                            El archivo ENTRADAS regularmente se descarga de compucaja con el nombre CEI0675R, <span style="font-weight:bold;">ESTO NO QUIERE DECIR QUE NECESARIAMENTE DEBE LLEVAR TAL NOMBRE PARA SUBIRLO A LA PLATAFORMA</span> , 
                                            <span class="text-primary" style="font-weight:bold;">SIN EMBARGO LE PEDIMOS NO MODIFICAR NADA DENTRO DEL ARCHIVO. CASO CONTRARIO ES POSIBLE NO SE LEA CORRECTAMENTE EL CONTENIDO DEL ARCHIVO.</span>
                                        </p>
                                        <?php if($miEntrada): ?>
                                            <div class="text-dark-50 font-weight-bold mt-3" id="ultTxt">
                                                <h1>TXT NOTAS DE ENTRADA : <a href="assets/uploads/entradas/<?php echo $miEntrada[0]->txtfile ?>" target="_blank"><?php echo $miEntrada[0]->fecha_registro ?></a></h1>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-dark-50 font-weight-bold mt-3" id="ultTxt">
                                                <h1>TXT NOTAS DE ENTRADA : Sin archivos</h1>
                                            </div>
                                        <?php endif;?>

                                        <?php if($miSalida): ?>
                                            <div class="text-dark-50 font-weight-bold mt-3" id="ultTxt">
                                                <h1>TXT AJUSTES DE SALIDA : <a href="assets/uploads/ajustes/<?php echo $miSalida[0]->txtfile ?>" target="_blank"><?php echo $miSalida[0]->fecha_registro ?></a></h1>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-dark-50 font-weight-bold mt-3" id="ultTxt">
                                                <h1>TXT AJUSTES DE SALIDA : Sin archivos</h1>
                                            </div>
                                        <?php endif;?>

                                        <?php if($miAjuste): ?>
                                            <div class="text-dark-50 font-weight-bold mt-3" id="ultTxt">
                                                <h1>TXT AJUSTES DE ENTRADA : <a href="assets/uploads/ajustes/<?php echo $miAjuste[0]->txtfile ?>" target="_blank"><?php echo $miAjuste[0]->fecha_registro ?></a></h1>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-dark-50 font-weight-bold mt-3" id="ultTxt">
                                                <h1>TXT AJUSTES DE ENTRADA : Sin archivos</h1>
                                            </div>
                                        <?php endif;?>

                                    </div>
                                </div>
                                <div class="position-absolute right-0 bottom-0 mr-5 overflow-hidden">
                                    <img src="assets/media/svg/illustrations/sucvus.svg" style="height:400px;width:400px;margin-bottom:-82px;" id="imgStart" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Engage Widget 8-->
                </div>
            </div>
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
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
</div>
<!--end::Content-->


