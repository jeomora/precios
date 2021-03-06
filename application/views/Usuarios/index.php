<style>
    @media only screen and (max-width: 600px) {
      #imgStart{display:none}
    }
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
                                        <h4 class="text-dark font-weight-bolder">Lista de usuarios</h4>
                                        <p class="text-dark-50 font-weight-bold mt-3">
                                            Usuarios Registrados: <?php echo $cuantos->total ?>
                                        </p>
                                    </div>
                                    <button type="submit" class="btn btn-light-success font-weight-bold mt-3 mt-sm-0 px-7" data-toggle="modal" data-target="#kt_modal_2">
                                        <span class="svg-icon svg-icon-lg">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Layout/Layout-4-blocks.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24"/>
                                                    <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                    <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>
                                                </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                            Agregar Usuario
                                        </span>
                                    </button>
                                </div>
                                <div class="position-absolute right-0 bottom-0 mr-5 overflow-hidden">
                                    <img src="assets/media/svg/illustrations/usuarios.svg" style="height:350px;width:350px;margin-bottom:-100px;" id="imgStart" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Engage Widget 8-->
                </div>
            </div>
            <!--end::Row-->

            <!--begin::Row-->
            <div class="row">          
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
                            <div class="kt-portlet__body kt-portlet__body--fit">
                                <!--begin: Datatable -->
                                <div class="kt-datatable datatable datatable-bordered datatable-head-custom" id="prodTable"></div>
                                <!--end: Datatable -->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Advance Table Widget 10-->
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


<!--begin::Modal-->
    <div class="modal fade" id="kt_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <?php echo form_open("", array("id"=>'form_usuario_delete')); ?>
                <input type="hidden" name="id_usuario" id="id_usuario" value="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">??Desea eliminar el usuario?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <p>S?? esta completamente seguro de eliminar el usuario <br><span style="font-weight:bold;" id="spanuser"></span>, por favor haga clic en el bot??n eliminar. <br><span style="font-weight:bold;color:red;">Esta acci??n no se puede deshacer</span></p>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input id="apellido" type="text" name="apellido" value="" class="form-control" placeholder="Apellido">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input id="correo" type="text" name="correo" value="" class="form-control" placeholder="ejemplo@email.com">
                                <div class="invalid-feedback mailValid">Introduzca una direccion de correo valida.</div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="password">Contrase??a</label> <!-- $password trae la contrase??a desencritada -->
                                <input id="password" type="text" name="password" class="form-control" placeholder="*********">
                                <div class="invalid-feedback passValid">Introduzca una contrase??a de al menos 8 digitos.</div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="id_grupo">Grupos</label>
                                <select name="id_grupo" class="form-control chosen-select" id="id_grupo">
                                    <?php if ($grupos):foreach ($grupos as $key => $value): ?>
                                        <option value="<?php echo $value->id_grupo ?>"><?php echo $value->nombre ?></option>
                                    <?php endforeach; endif ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 sucuss" style="display:none">
                            <div class="form-group">
                                <label for="id_sucuss">Sucursal</label>
                                <select name="id_sucuss" class="form-control chosen-select" id="id_sucuss">
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="apellido">Apellido</label>
                                <input id="apellidos" type="text" name="apellidos" value="" class="form-control" placeholder="Apellido">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input id="correos" type="text" name="correos" value="" class="form-control" placeholder="ejemplo@email.com">
                                <div class="invalid-feedback mailsValid">Introduzca una direccion de correo valida.</div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="password">Contrase??a</label> <!-- $password trae la contrase??a desencritada -->
                                <input id="passwords" type="text" name="passwords" class="form-control" placeholder="*********">
                                <div class="invalid-feedback passsValid">Introduzca una contrase??a de al menos 8 digitos.</div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="id_grupo">Grupos</label>
                                <select name="id_grupos" class="form-control chosen-select" id="id_grupos">
                                    <?php if ($grupos):foreach ($grupos as $key => $value): ?>
                                        <option value="<?php echo $value->id_grupo ?>"><?php echo $value->nombre ?></option>
                                    <?php endforeach; endif ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 sucus" style="display:none">
                            <div class="form-group">
                                <label for="id_sucu">Sucursal</label>
                                <select name="id_sucu" class="form-control chosen-select" id="id_sucu">
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