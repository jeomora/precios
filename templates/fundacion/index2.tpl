<!DOCTYPE html>
<html lang="en">
<head>
	 {% block head %}
            {{ Html.Meta("utf8") }}
            {{Html.LinkCss(["bootstrap.min","font-awesome.min","general","general2","general3","favicon","font-awesome.min","fonts"])}}
    {% endblock %}
    <meta property="og:image"              content="https://mifactura.com/templates/mifactura/fileimages/mifactura.jpg" />
    	<meta property="og:title"              content="mifactura.com" />
    <meta property="og:url"              content="https://mifactura.com/" />
    <meta property="og:description" content="mifactura.com el sistema de facturación electrónica CFDI más confiable en Latinoamérica." /></head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<nav class="navbar">
  <div class="container-fluid navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        {{Html.Img("templates/fundacion/fileimages/logo.svg",{link:"#", class:"img-responsive", id:"logo-header", style:"width:200px;"})}}
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li {{ Control == "Nosotros" ? 'class="activo "' : '' }} ><a href="nosotros">Nosotros</a></li>
        <li {{ Control == "Conoce" ? 'class="activo"' : '' }} ><a href="conoce#programas">Conóce</a></li>
        <li {{ Control == "Incolucra" ? 'class="activo"' : '' }} ><a href="pagnegocio">Involúcrate</a></li>
        <li {{ Control == "Empresas" ? 'class="activo"' : '' }} ><a href="distribuidores">Empresas</a></li>
        <li {{ Control == "Eventos" ? 'class="activo"' : '' }}><a href="eventos">Eventos</a></li>
        <li {{ Control == "Blog" ? 'class="activo"' : '' }}><a href="contacto">Blog</a></li>
        <li {{ Control == "Galeria" ? 'class="activo"' : '' }}><a href="galeria">Galería</a></li>
        <li {{ Control == "Contacto" ? 'class="activo"' : '' }}><a href="contacto">Contacto</a></li>
      </ul>
    </div>
  </div>
  <div class="container-fluid flat-green"><label class="label-white" id="informacion" >Información 55535353</label>
    <ul class="sociales-nav">
      <li><a href="#" class="fa fa-facebook"></a></li>
      <li><a href="#" class="fa fa-twitter"></a></li>
      <li><a href="#" class="fa fa-youtube"></a></li>
      <li><a href="#" class="fa fa-instagram"></a></li>
    </ul>
  </div>
</nav>
<div class="container-fluid img-template">
<div class="col-md-1 col-xs-12" id="orange-box">
    <div class="col-md-12 col-xs-2 orange-button">{{Html.Img("templates/fundacion/fileimages/heart-right.svg",{class:"img-responsive orange-img"})}}</div>
    <div class="col-md-12 col-xs-2 orange-button">{{Html.Img("templates/fundacion/fileimages/balon.svg",{class:"img-responsive orange-img"})}}</div>
  </div>
</div>
<div class="cuerpo">
  {{body}}
</div>
<footer>
  <div class="col-md-12 col-xs-12 footer-menu">
    <div class="col-md-12">
      <div class="col-md-3">
       {{Html.Img("templates/fundacion/fileimages/dadad.JPG",{class:"img-responsive"})}}
        <p class="dir-footer">Programa de RSE de Grupo Consultor EFE &trade; Paseo de los Héroes 10289 Int. 7002, Zona Urbana Río, Tijuana, B.C.,México </p>
      </div>
      <div class="col-md-2">
        <ul class="footer-list">
          <li><label for="">Nosotros</label></li>
          <li><a href="">Historia</a></li>
          <li><a href="">Somos</a></li>
          <li><a href="">Metas</a></li>
          <li><a href="">Consejos</a></li>
          <li><a href="">Voluntarios</a></li>
          <li><a href="">Transparencia</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <ul class="footer-list">
          <li><label for="">Conóce</label></li>
          <li><a href="">Retos</a></li>
          <li><a href="">Modelo Integral</a></li>
          <li><a href="">Programas</a></li>
          <li><a href="">Convocatorias</a></li>
          <li><a href="">Casos de Éxito</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <ul class="footer-list">
          <li><label for="">Involúcrate</label></li>
          <li><a href="">Red de voluntarios</a></li>
          <li><a href="">Prácticas Profesionales</a></li>
          <li><a href="">Donativos</a></li>
        </ul>
        <ul class="footer-list">
            <li><label for="">Empresas</label></li>
            <li><a href="">Taller RSE</a></li>
            <li><a href="">Donativos</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <ul class="footer-list">
          <li><label for="">Liga de la esperanza</label></li>
          <li><a href="">Qué es</a></li>
          <li><a href="">Cómo funciona</a></li>
          <li><a href="">Patrocina</a></li>
          <li><a href="">Calendario</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-12 line col-xs-12"></div>
    <div class="col-md-12 first-footer">
      <div class="col-md-7 col-xs-12">
        <label class="purple">Tel. +52 (664) 634 33 11</label>
      </div>
      <div class="col-md-5 col-xs-12" id="sociales-footer">
        <div class="col-md-5">
          <label class="purple">Síguenos</label>
        </div>
        <div class="col-md-7">
            <ul>
              <li><a href="#" class="fa fa-facebook"></a></li>
              <li><a href="#" class="fa fa-twitter"></a></li>
              <li><a href="#" class="fa fa-youtube"></a></li>
              <li><a href="#"class="fa fa-instagram"></a></li>
            </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-xs-12 flat-purple">
    <div class="col-md-5 col-xs-12"><label>TODOS LOS DERECHOS RESERVADOS ESPERANZA CONTIGO, A.C. 2017</label></div>
    <div class="col-md-3 col-xs-12"><a href="#" class="privacidad">AVISO DE PRIVACIDAD</a></div>
  </div>
</footer>
 {{Javascript.Js(["jquery","jquery-ui","jquery.filer","jquery.filer.min","custom","component","bootstrap.min","bootstrap-table","bootstrap-table-es", "bootstrap-dialog.min","bootstrap-arrastrar","tinymce/tinymce.min","select2","localstore","funciones","jform","validator","init","jquerycookie", "slider-home"])}}
</body>
</html>
