<style type="text/css">
    
    #resultsBuscaProd{width:100%;}
    .table th, .table td{padding:0.5rem;}
    .h1FormatoGeneral{text-align:center;padding-top:20px;font-family:Algerian;font-size:50px;background:yellow;}
    @media (min-width: 900px){
        .div12FormatoGeneral{display:inline-flex;padding:0}
    }
    @media (max-width: 800px){
        .tdCode,.tdName{font-size:12px;}
        .text-muted{display:none;}
        .h1FormatoGeneral{font-size:26px;}
        .imgFormatoGeneral{display:none;}
        .titleFormatoGeneral{display:none;}
    }
    .d-flex.flex-row.flex-column-fluid.container{min-width:85% !important;}
    tr:hover{background: #7ee886 !important;}
    .imgFormatoGen{max-width:100%;}
    .imgFormatoGeneral{padding:0;background:#ccc;}
    .titleFormatoGeneral{background:#d9e1f2;font-family:Algerian;font-weight:bold;text-align:center;font-size:20px;border:1px solid;}
    .rowFormatoGeneral{font-size: 18px;border: 1px solid;}
    .flex-column-fluid{padding:0;padding-top:10px;}
    span.cotizNR{font-weight:bold;cursor:pointer;}
</style>
<!--begin::Header Menu Wrapper-->
<div class="d-flex flex-row flex-column-fluid container">
    <!--begin::Tab Content-->
    <div class="main d-flex flex-column flex-row-fluid">
        <!--  VISTA PARA SUBIR COTIZACIONES / REMISIONES  -->
        <div class="content flex-column-fluid kt_content_comparativo tabVisible">
            <div class="content flex-column-fluid">
                <!--begin::Row Advertencia-->
                <div class="row">
                    <div class="alert alert-custom alert-light-warning fade show mb-5" role="alert">
                        <div class="alert-icon"><i class="flaticon-warning"></i></div>
                        <div class="alert-text">
                            Comparativo entre cotizaciones y remisiones, en el apartado <span class="text-success font-size-h6">Subir .txt Cotizaciones</span> seleccione el archivo de cotizaciones para obtener los totales cotizados por las sucursales dadas de alta en el sistema.
                            <br>
                            Sí desea obtener las diferencias entre cotizaciones y remisiones por favor suba el archivo de <span class="text-primary font-size-h6">Remisiones (.txt)</span> para obtener la información completa.
                        </div>
                        <div class="alert-close">
                            
                        </div>
                    </div>
                </div>
                <!--end::Row Advertencia-->

                <!--begin::Row Dropzone-->
                <div class="row col-md-12">
                    <div class="col-md-6 card card-custom bg-light-success card-stretch gutter-b">
                        <?php echo form_open_multipart("", array('id' => 'upload_cotizaciones')); ?>
                            <span class="card-title font-weight-bolder text-success font-size-h2 mb-0 mt-6 d-block svg-icon svg-icon-2x svg-icon-success">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M5.74714567,13.0425758 C4.09410362,11.9740356 3,10.1147886 3,8 C3,4.6862915 5.6862915,2 9,2 C11.7957591,2 14.1449096,3.91215918 14.8109738,6.5 L17.25,6.5 C19.3210678,6.5 21,8.17893219 21,10.25 C21,12.3210678 19.3210678,14 17.25,14 L8.25,14 C7.28817895,14 6.41093178,13.6378962 5.74714567,13.0425758 Z" fill="#000000" opacity="0.3"/>
                                        <path d="M11.1288761,15.7336977 L11.1288761,17.6901712 L9.12120481,17.6901712 C8.84506244,17.6901712 8.62120481,17.9140288 8.62120481,18.1901712 L8.62120481,19.2134699 C8.62120481,19.4896123 8.84506244,19.7134699 9.12120481,19.7134699 L11.1288761,19.7134699 L11.1288761,21.6699434 C11.1288761,21.9460858 11.3527337,22.1699434 11.6288761,22.1699434 C11.7471877,22.1699434 11.8616664,22.1279896 11.951961,22.0515402 L15.4576222,19.0834174 C15.6683723,18.9049825 15.6945689,18.5894857 15.5161341,18.3787356 C15.4982803,18.3576485 15.4787093,18.3380775 15.4576222,18.3202237 L11.951961,15.3521009 C11.7412109,15.173666 11.4257142,15.1998627 11.2472793,15.4106128 C11.1708299,15.5009075 11.1288761,15.6153861 11.1288761,15.7336977 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 18.661508) rotate(-90.000000) translate(-11.959697, -18.661508) "/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                                 Subir .txt Cotizaciones
                            </span>
                            <br><br>
                            <input type="file" class="btn btn-light-success font-weight-bold" style="padding:0" id="file_cotizaciones" name="file_cotizaciones" value="">
                        <?php echo form_close(); ?>
                    </div>
                    <div class="col-md-6 card card-custom bg-light-primary card-stretch gutter-b">
                        <?php echo form_open_multipart("", array('id' => 'upload_remisiones')); ?>
                            <span class="card-title font-weight-bolder text-primary font-size-h2 mb-0 mt-6 d-block svg-icon svg-icon-2x svg-icon-primary">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M5.74714567,13.0425758 C4.09410362,11.9740356 3,10.1147886 3,8 C3,4.6862915 5.6862915,2 9,2 C11.7957591,2 14.1449096,3.91215918 14.8109738,6.5 L17.25,6.5 C19.3210678,6.5 21,8.17893219 21,10.25 C21,12.3210678 19.3210678,14 17.25,14 L8.25,14 C7.28817895,14 6.41093178,13.6378962 5.74714567,13.0425758 Z" fill="#000000" opacity="0.3"/>
                                        <path d="M11.1288761,15.7336977 L11.1288761,17.6901712 L9.12120481,17.6901712 C8.84506244,17.6901712 8.62120481,17.9140288 8.62120481,18.1901712 L8.62120481,19.2134699 C8.62120481,19.4896123 8.84506244,19.7134699 9.12120481,19.7134699 L11.1288761,19.7134699 L11.1288761,21.6699434 C11.1288761,21.9460858 11.3527337,22.1699434 11.6288761,22.1699434 C11.7471877,22.1699434 11.8616664,22.1279896 11.951961,22.0515402 L15.4576222,19.0834174 C15.6683723,18.9049825 15.6945689,18.5894857 15.5161341,18.3787356 C15.4982803,18.3576485 15.4787093,18.3380775 15.4576222,18.3202237 L11.951961,15.3521009 C11.7412109,15.173666 11.4257142,15.1998627 11.2472793,15.4106128 C11.1708299,15.5009075 11.1288761,15.6153861 11.1288761,15.7336977 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.959697, 18.661508) rotate(-90.000000) translate(-11.959697, -18.661508) "/>
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                                 Subir .txt Remisiones
                            </span>
                            <br><br>
                            <input type="file" class="btn btn-light-primary font-weight-bold" style="padding:0" id="file_remisiones" name="file_remisiones" value="">
                        <?php echo form_close(); ?>
                    </div>
                </div>
                <!--end::Row Dropzone-->

                <div class="row" style="height:50px"></div>


                <div class="col-xl-12" style="padding:0">
                    <div class="col-xl-12" style="display:inline-flex;padding:0;">
                        <div class="col-xl-2 imgFormatoGeneral">
                            <img src="<?php echo base_url('/assets/img/logo_abarrotes.png') ?>" class="imgFormatoGen">
                        </div>
                        <div class="col-xl-8 h1FormatoGeneral">
                            FORMATO GENERAL
                        </div>
                        <div class="col-xl-2 imgFormatoGeneral">
                            <img src="<?php echo base_url('/assets/img/logo_abarrotes.png') ?>" class="imgFormatoGen">
                        </div>
                    </div>
                    <div class="col-xl-12" style="background:rgb(189,215,238);text-align:center;font-size:22px;border:1px solid;">
                        COTIZACIÓN SIN REMISIÓN: -- 
                        <?php if($cotizNoRemis):foreach ($cotizNoRemis as $key => $value): ?>
                            <?php echo "<span class='cotizNR' data-id-folio='".$value->folio."'>".$value->folio." </span>-- ";?>
                        <?php endforeach;endif; ?>
                    </div>
                    <div class="col-xl-12" style="background:rgb(238,227,189);text-align:center;font-size:22px;border:1px solid;">
                        REMISIÓN SIN COTIZACIÓN: -- <?php if($remisNoCotiz):foreach ($remisNoCotiz as $key => $value): echo $value->folio." --- ";endforeach;endif; ?>
                    </div>
                    <div class="col-xl-12" style="background:rgb(238,189,189);text-align:center;font-size:22px;border:1px solid;">
                        DIFERENCIAS (COTIZ-REMIS): -- <br><?php if($diferencias):foreach ($diferencias as $key => $value): echo "[".$value->foluno."($ ".number_format($value->totuno,2,".",",").")"." - ".$value->foldos."($".number_format($value->totdos,2,".",",").")]<br>";endforeach;endif; ?>
                    </div>
                    <div class="col-xl-12 div12FormatoGeneral">
                        <div class="col-xl-3 titleFormatoGeneral">
                            SUCURSAL
                        </div>
                        <div class="col-xl-2 titleFormatoGeneral">
                            FRUTA
                        </div>
                        <div class="col-xl-2 titleFormatoGeneral">
                            VERDURA
                        </div>
                        <div class="col-xl-2 titleFormatoGeneral">
                            ABARROTE
                        </div>
                        <div class="col-xl-2 titleFormatoGeneral">
                            TOTAL
                        </div>
                        <div class="col-xl-1 titleFormatoGeneral">
                            REMISIONES
                        </div>
                    </div>
                    <?php $flagA=0;$flagA1=0;$frutas=0;$verduras=0;$abarrotes=0;if($cotizHoy):foreach ($cotizHoy as $key => $value): ?>
                        <?php if($value->tipo == 2 && $flagA == 0):$flagA = 1; ?>
                            <div class="col-xl-12 titleFormatoGeneral" style="background:yellow;">
                                TIENDAS CHICAS
                            </div>
                        <?php elseif($value->tipo == 3 && $flagA1 == 0):$flagA1 = 1; ?>
                            <div class="col-xl-12 titleFormatoGeneral" style="background:yellow;">
                                OTROS CLIENTES
                            </div>
                        <?php endif; ?>
                        
                        <div class="col-xl-12 div12FormatoGeneral" id="resFormatoGeneral">
                            <?php $frutas+=floatval($value->totafru);$verduras+=floatval($value->totaver);$abarrotes+=floatval($value->totabar)+floatval($value->totis); ?>
                            <div class="col-xl-3 rowFormatoGeneral" style="background:rgb(198,224,180);">
                                <?php echo $value->nombre ?>         
                            </div>
                            <div class="col-xl-2 rowFormatoGeneral">
                                 <?php echo "$ ".number_format($value->totafru,2,".",",")?> 
                            </div>
                            <div class="col-xl-2 rowFormatoGeneral">
                                 <?php echo "$ ".number_format($value->totaver,2,".",",")?> 
                            </div>
                            <div class="col-xl-2 rowFormatoGeneral">
                                 <?php echo "$ ".number_format(($value->totabar + $value->totis),2,".",",")?> 
                            </div>
                            <?php $ttt1 = floatval($value->totafru)+floatval($value->totaver)+floatval($value->totabar)+floatval($value->totis) ; ?>
                            <?php $ttt2 = floatval($value->totre) + floatval($value->totre2) ; ?>
                            <div class="col-xl-2 rowFormatoGeneral" style="background:rgb(0,176,240)">
                                 <?php echo "$ ".number_format( $ttt1 ,2,".",",")?> 
                            </div>
                            <div class="col-xl-1 rowFormatoGeneral" style="<?php if(round($ttt2,2) <> round($ttt1,2)):echo 'background:rgb(240,111,0)';else:echo 'background:rgb(0,240,185)';endif; ?> ">
                                 <?php echo "$ ".number_format( $ttt2 ,2,".",",")?> 
                            </div>
                        </div>
                    <?php endforeach;endif; ?>
                    <div class="col-xl-12 div12FormatoGeneral" style="background:yellow;">
                        <div class="col-xl-3 rowFormatoGeneral">
                                    
                        </div>
                        <div class="col-xl-2 rowFormatoGeneral">
                             <?php echo "$ ".number_format($frutas,2,".",",")?> 
                        </div>
                        <div class="col-xl-2 rowFormatoGeneral">
                             <?php echo "$ ".number_format($verduras,2,".",",")?> 
                        </div>
                        <div class="col-xl-2 rowFormatoGeneral">
                             <?php echo "$ ".number_format($abarrotes,2,".",",")?> 
                        </div>
                        <div class="col-xl-2 rowFormatoGeneral">
                             <?php echo "$ ".number_format( (floatval($frutas)+floatval($verduras)+floatval($abarrotes)) ,2,".",",")?> 
                        </div>
                        <div class="col-xl-1 rowFormatoGeneral">
                             
                        </div>
                    </div>
                </div>

                <div class="col-xl-12" style="text-align:right;">
                    <a class="btn btn-success" href="Salidas/printFormato" target="_blank" style="font-size:20px;margin-top:20px;">
                        DESCARGAR EXCEL
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
<!--end::Header Menu Wrapper-->



<!--begin::Modal-->
<div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <?php echo form_open("", array("id"=>'form_usuario_delete')); ?>
            <input type="hidden" name="id_usuario" id="id_usuario" value="">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¿Desea eliminar el usuario?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <p>Sí esta completamente seguro de eliminar el usuario <br><span style="font-weight:bold;" id="spanuser"></span>, por favor haga clic en el botón eliminar. <br><span style="font-weight:bold;color:red;">Esta acción no se puede deshacer</span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger delete_usuario">Eliminar</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!--end::Modal-->

<!--begin::Modal EDITAR-->
<div class="modal fade" id="kt_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?php echo form_open("", array("id"=>'form_usuario_edit')); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_usuarios" id="id_usuarios" value="">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input id="nombre" type="text" name="nombre" value="" class="form-control" placeholder="Nombre">
                            <div class="invalid-feedback userValid">Campo requerido.</div>
                        </div>
                    </div>
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">Usuario</label>
                            <input id="email" type="text" name="email" value="" class="form-control" placeholder="Ejemplo: user2021">
                            <div class="invalid-feedback mailValid">Campo requerido</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Contraseña</label> <!-- $password trae la contraseña desencritada -->
                            <input id="password" type="text" name="password" class="form-control" placeholder="*********">
                            <div class="invalid-feedback passValid">Introduzca una contraseña de al menos 8 digitos.</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="id_grupo">Grupos</label>
                            <select name="id_grupo" class="form-control chosen-select" id="id_grupo">
                                <?php if ($grupos):foreach ($grupos as $key => $value): ?>
                                    <option value="<?php echo $value->id_grupo ?>"><?php echo $value->nombre ?></option>
                                <?php endforeach; endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 sucuss" style="display:none">
                        <div class="form-group">
                            <label for="id_sucuss">Sucursal</label>
                            <select name="id_sucuss" class="form-control chosen-select" id="id_sucuss">
                                <option value="1">CEDIS</option>
                                <?php if ($sucursales):foreach ($sucursales as $key => $value): ?>
                                    <option value="<?php echo $value->id_sucursal ?>"><?php echo $value->nombre ?></option>
                                <?php endforeach; endif ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary update_usuario">Editar Usuario</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!--end::Modal-->

<!--begin::Modal NUEVO-->
<div class="modal fade" id="kt_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <?php echo form_open("", array("id"=>'form_usuario_new')); ?>
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_usuarioss" id="id_usuarioss" value="">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input id="nombres" type="text" name="nombres" value="" class="form-control" placeholder="Nombre">
                            <div class="invalid-feedback usersValid">Campo requerido.</div>
                        </div>
                    </div>
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="correo">Usuario</label>
                            <input id="correos" type="text" name="correos" value="" class="form-control" placeholder="Usuario2021">
                            <div class="invalid-feedback mailsValid">Introduzca una direccion de correo valida.</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Contraseña</label> <!-- $password trae la contraseña desencritada -->
                            <input id="passwords" type="text" name="passwords" class="form-control" placeholder="*********">
                            <div class="invalid-feedback passsValid">Introduzca una contraseña de al menos 8 digitos.</div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="id_grupo">Grupos</label>
                            <select name="id_grupos" class="form-control chosen-select" id="id_grupos">
                                <?php if ($grupos):foreach ($grupos as $key => $value): ?>
                                    <option value="<?php echo $value->id_grupo ?>"><?php echo $value->nombre ?></option>
                                <?php endforeach; endif ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 sucus" style="display:none">
                        <div class="form-group">
                            <label for="id_sucu">Sucursal</label>
                            <select name="id_sucu" class="form-control chosen-select" id="id_sucu">
                                <option value="1">CEDIS</option>
                                <?php if ($sucursales):foreach ($sucursales as $key => $value): ?>
                                    <option value="<?php echo $value->id_sucursal ?>"><?php echo $value->nombre ?></option>
                                <?php endforeach; endif ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary new_usuario">Crear Usuario</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

<!--end::Modal-->