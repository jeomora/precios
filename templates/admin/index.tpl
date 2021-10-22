<!DOCTYPE html>
<html>
    <head>
        {% block head %}
            {{ Html.Meta("utf8") }}
            <title>{% block title %}{{title}}{% endblock %}</title>
            {{Html.LinkCss(["bootstrap.min","favicon","main","bootstrap-table","select2.min","font-awesome.min","fonts","normalize","demo","component","jquery.nube","jquery.nube2"])}}
        {% endblock %}
        <link rel="stylesheet" href="/templates/admin/fonts/">
        <script src="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
        <link href="http://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
        
    </head>
    <body data-referer="{{referer}}">
        <nav  class="navbar navbar-info navbar-fixed-top barra" id="barra">
            <div class="navbar-header">
                {{Html.Img("templates/admin/admiNETlogo.svg",{link:"", class:"img-responsive"})}}
            </div>
            <div id="navbar" class"navbar-collapse collapse">
                <div id= "btnSalir" class="navbar-right btn-salir">{{Html.Link("usuarios/salir","<i class='fa fa-sign-out'></i> Cerrar sesión ", {class:""})}}</div>
                <div class=" navbar-right img-logo2">{{ Html.Img("templates/admin/logoSemi.svg", {"class":"img-logo2"}) }}</div>
            </div>
        </nav>
        <div id="listones">
            <div class="listones" >
                <div class="lnegro"></div>
                <div class="lazul"></div>
            </div>
            <div class="lgris" ></div>
        </div>
        <div class="container-fluid contenedor">
            <div class="row caja-row">
                <div class="col-sm-4 col-md-2 caja-menu" id="mlateral">
                    <nav class="navbar navbar-default nav-ajuste">
                        <ul class="nav navbar-nav navlist" id="menuadmin">
                            <li {{ Control == "Index" ? 'class="activo"' : '' }}>
                                {{ Html.Link("","<i class='fa fa-home'></i> Inicio")}}
                            </li>
                            <li {{ Control == "Blog" ? 'class="activo"' : '' }}{{ Control == "Categorias"  ? 'class="activo"' : '' }}{{ Control == "Etiquetas"  ? 'class="activo"' : '' }}>
                                <a>{{"<i class='fa fa-pencil-square-o'></i> Blog"}}</a>
                                <ul class="submenu"  id="sumenu">
                                    <li class="item-submenu">
                                        {{ Html.Link("blogs","<i class='fa fa-pencil-square-o'></i>Vista Blog")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("blog","<i class='fa fa-commenting'></i> Artículos")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("categoriasblog","<i class='fa fa-folder'></i> Categorías ")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("medios","<i class='fa fa-paper-plane'></i> Medios ")}}
                                    </li>
                                </ul>
                            </li>
                            <li {{ Control == "Voluntarios" ? 'class="activo"' : '' }}>
                                {{ Html.Link("voluntarios/index","<i class='fa  fa-group'></i> Voluntarios")}}
                            </li>
                            <li {{ Control == "Eventos" ? 'class="activo"' : '' }}{{ Control == "Slider"  ? 'class="activo"' : '' }}{{ Control == "Etiquetas"  ? 'class="activo"' : '' }}>
                                <a>{{"<i class='fa fa-calendar'></i> Eventos"}}</a>
                                <ul class="submenu"  id="sumenu">
                                    <li class="item-submenu">
                                        {{ Html.Link("veventos/index","<i class='fa fa-calendar'></i> Vista Eventos")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("eventos/index","<i class='fa fa-sliders'></i> Slider Eventos")}}
                                    </li>
                                </ul>
                            </li>
                            <li {{ Control == "Home" ? 'class="activo"' : '' }}{{ Control == "Slider"  ? 'class="activo"' : '' }}{{ Control == "Etiquetas"  ? 'class="activo"' : '' }}>
                                <a>{{"<i class='fa fa-home'></i> Home"}}</a>
                                <ul class="submenu"  id="sumenu">
                                    <li class="item-submenu">
                                        {{ Html.Link("home/index","<i class='fa fa-home'></i> Vista Home")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("sliderhome/index","<i class='fa fa-sliders'></i> Slider Home")}}
                                    </li>
                                </ul>
                            </li>
                            <li {{ Control == "Nosotros" ? 'class="activo"' : '' }}{{ Control == "Consejo"  ? 'class="activo"' : '' }}{{ Control == "Etiquetas"  ? 'class="activo"' : '' }}>
                                <a>{{"<i class='fa fa-suitcase'></i> Nosotros"}}</a>
                                <ul class="submenu"  id="sumenu">
                                    <li class="item-submenu">
                                        {{ Html.Link("nosotros/index","<i class='fa  fa-group'></i> Vista Nosotros")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("consejo/index","<i class='fa fa-user-plus'></i> Consejo Directivo ")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("lideres/index","<i class='fa fa-user-plus'></i> Líderes de Comisión ")}}
                                    </li>
                                     <li class="item-submenu">
                                        {{ Html.Link("slidertesti/index","<i class='fa fa-sliders'></i> Slider de Voluntarios")}}
                                    </li>
                                </ul>
                            </li>
                            <li {{ Control == "Conoce" ? 'class="activo"' : '' }}{{ Control == "Programas"  ? 'class="activo"' : '' }}{{ Control == "Etiquetas"  ? 'class="activo"' : '' }}>
                                <a>{{"<i class='fa fa-rocket'></i> Programas"}}</a>
                                <ul class="submenu"  id="sumenu">
                                    <li class="item-submenu">
                                        {{ Html.Link("conoce/index","<i class='fa fa-rocket'></i> Vista Programas")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("programas/index","<i class='fa fa-sliders'></i> Slider de programas")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("convocatorias/index","<i class='fa fa-bullhorn'></i> Convocatorias")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("testi/index","<i class='fa fa-sliders'></i> Slider de Testimonios")}}
                                    </li>
                                </ul>
                            </li>
                            <li {{ Control == "Involucrate" ? 'class="activo"' : '' }}{{ Control == "Testivoluntarios"  ? 'class="activo"' : '' }}{{ Control == "Etiquetas"  ? 'class="activo"' : '' }}>
                                <a>{{"<i class='fa fa-child'></i> Involúcrate"}}</a>
                                <ul class="submenu"  id="sumenu">
                                    <li class="item-submenu">
                                       {{ Html.Link("involucrate/index","<i class='fa  fa-child'></i> Vista Involúcrate")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("testivoluntarios/index","<i class='fa fa-sliders'></i> Slider de Testimonios")}}
                                    </li>
                                </ul>
                            </li>
                            <li {{ Control == "Vcomisiones" ? 'class="activo"' : '' }}{{ Control == "Comisiones"  ? 'class="activo"' : '' }}{{ Control == "Etiquetas"  ? 'class="activo"' : '' }}>
                                <a>{{"<i class='fa fa-ticket'></i> Comisiones"}}</a>
                                <ul class="submenu"  id="sumenu">
                                    <li class="item-submenu">
                                        {{ Html.Link("vcomisiones/index","<i class='fa fa-ticket'></i> Vista Comisiones")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("comisiones/index","<i class='fa fa-ticket'></i> Listado Comisiones")}}
                                    </li>
                                </ul>
                            </li>
                            <li {{ Control == "Vgaleria" ? 'class="activo"' : '' }}{{ Control == "Comisiones"  ? 'class="activo"' : '' }}{{ Control == "Etiquetas"  ? 'class="activo"' : '' }}>
                                <a>{{"<i class='fa fa-picture-o'></i> Galería"}}</a>
                                <ul class="submenu"  id="sumenu">
                                    <li class="item-submenu">
                                        {{ Html.Link("vgaleria/index","<i class='fa fa-smile-o'></i> Vista Galería")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("videos/index","<i class='fa fa-video-camera'></i> Slider Videos")}}
                                    </li>
                                    <!--<li class="item-submenu">
                                        {{ Html.Link("galeriafolders/index","<i class='fa fa-folder-open-o'></i> Carpeta de Imágenes")}}
                                    </li>-->
                                     <li class="item-submenu">
                                        {{ Html.Link("galeriaimages/index","<i class='fa fa-picture-o'></i> Imágenes")}}
                                    </li>
                                </ul>
                            </li>
                            <li {{ Control == "Donaciones" ? 'class="activo"' : '' }}{{ Control == "Sponsors"  ? 'class="activo"' : '' }}{{ Control == "Etiquetas"  ? 'class="activo"' : '' }}>
                                <a>{{"<i class='fa fa-money'></i> Donativos"}}</a>
                                <ul class="submenu"  id="sumenu">
                                    <li class="item-submenu">
                                        {{ Html.Link("donaciones/index","<i class='fa fa-money'></i> Vista Donativos")}}
                                    </li>
                                    <li class="item-submenu">
                                        {{ Html.Link("sponsors/index","<i class='fa fa-user'></i> Sponsors")}}
                                    </li>
                                     <li class="item-submenu">
                                        {{ Html.Link("donativo/index","<i class='fa fa-gift'></i> Vista Donativo")}}
                                    </li>
                                </ul>
                            </li>
                            <li class="item-submenu">
                                {{ Html.Link("liga/index","<i class='fa fa-futbol-o'></i> Vista Liga")}}
                            </li>
                            <li class="item-submenu">
                                {{ Html.Link("contacto/index","<i class='fa fa-envelope'></i> Vista Contacto")}}
                            </li>
                            <li class="item-submenu">
                                {{ Html.Link("empresas/index","<i class='fa fa-building-o'></i> Vista Empresas")}}
                            </li>
                            <li class="item-submenu">
                                {{ Html.Link("footer/index","<i class='fa fa-heart'></i> Vista Footer")}}
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-10 caja-body" id="panel2">
                    <div class="panel panel-primary" id="panel">
                      <div class="panel-heading" id="pheading">
                        <div class="titulo">{{title}}</div>
                        <div class="subtitulo">{{subtitle}}</div>
                      </div>
                      <div class="panel-body">
                        <div id="panl" class="panel-body panel2">
                            {{ body }}
                        </div>
                     </div>
                      <footer class="foot2 navbar-fixed-bottom" id="footer">
                        <div id="soport">
                            <button type="button" id="support" class="btn-soporte" data-toggle="modal" data-target="#Modalsoporte">
                                <i class="fa fa-cogs"></i> {{"Soporte"}}
                            </button>
                        </div>
                        <div class="derechos2">
                            {{"Derechos Reservados-"}}{{ Html.Img("fileimages/sesmark_blanco.svg", {"class":"logo-derechos2","link":""}) }}{{""}}
                        </div>
                      </footer>
                    </div>
                </div>
            </div>
        </div>
        <div id="Modalsoporte" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialogo" style=" width: 600px !important">
                <div class="modal-content">
                    <div  class="modal-header modal-cabecera"><i id="icono-soporte" class="fa fa-cog  peligro"></i>
                        <br>
                        <div id="titulo-modal">{{"Soporte"}}</div>
                    </div>
                        <div class="modal-body modal-cuerpo">
                        {{ Form.create({control:"contacto",function:"enviar"},"frmSoporte") }}
                             <div class="col-md-12 colum">
                                <div class="form-group texareamodal">
                                    {{ Form.TextArea("texto",{"label":{"text":"Puede enviarnos sus sugerencias o problemas técnicos", "class":"control-label titulo-modalsoporte"}, "class":"form-control",rows:"5"}) }}
                                </div>
                            </div>
                        {{Form.Submit("Guardar",{"id":"btnGuardar","class":"btn  btn-agregar"})}}
                        {{Html.Link("","Cancelar",{"class":"btn btn-agregar"})}}
                        {{ Form.End() }}

                        </div>
                    <div class="modal-footer">
                      {{ Html.Img("templates/admin/sesmarklogo2-01.svg", {"class":"logo-derechos2","link":""}) }}
                    </div>
                </div>
            </div>
        </div>

        {{Javascript.Js(["jquery","jquery-ui","jquery.filer","jquery.filer.min","custom","component","bootstrap.min","bootstrap-table","bootstrap-table-es", "bootstrap-dialog.min","bootstrap-arrastrar","tinymce/tinymce.min","select2","localstore","funciones","jform","validator","init"])}}

    </body>
</html>
