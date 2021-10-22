<!DOCTYPE html>
<html lang="en">
<head>
	 {% block head %}
            {{ Html.Meta("utf8") }}
            {{Html.LinkCss(["bootstrap","font-awesome.min","general","general2","general3","favicon","font-awesome.min","fonts","cesar"])}}
    {% endblock %}
		<meta name='description' content='Fundación Esperanza Contigo, A.C. ha sido creada para transformar la vida de niños en situación de abandono a través de un modelo de desarrollo integral enfocado en cuatro ejes distintos.' />

		<title>Fundación Esperanza Contigo, A.C. - Construyendo futuro con valor</title>

</head>
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<script type="text/javascript" src="//e.issuu.com/embed.js" async="true"></script>
{{Javascript.Js(["jquery","jquery-ui","jquery.filer","jquery.filer.min","custom","component","bootstrap.min","bootstrap-table","bootstrap-table-es", "bootstrap-dialog.min","bootstrap-arrastrar","tinymce/tinymce.min","select2","localstore","funciones","jform","validator","init","jquerycookie","jquery.waypoints", "progressbar.min"])}}
<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
<!-- Place this tag in your head or just before your close body tag. -->

<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: es_ES</script>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'es-419'}
</script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v2.9&appId=231444407358816";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--Start of Zendesk Chat Script-->
<script type="text/javascript">

window.$zopim||(function(d,s){var z=$zopim=function(c){
z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='https://v2.zopim.com/?4Tievd53YES17eVu5RJ3cl7f96onc9dq';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zendesk Chat Script-->

<script>
  $zopim(function() {
    $zopim.livechat.badge.setColor('#f5f5ef');
    $zopim.livechat.button.setColor('#f5f5ef');

     $zopim.livechat.badge.setImage('http://www.esperanzacontigo.org/templates/mifactura/fileimages/4logo.png');
    $zopim.livechat.theme.reload(); // apply new theme settings
    $zopim.livechat.badge.show();
  });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDu4VAem_e_K118WIg4xY5Hum7ZvNy9_Fs"asyncdefer></script>

<body>
<nav class="navbar">
  <div class="container-fluid navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      {{Html.Img("templates/fundacion/fileimages/logo.svg",{link:"#", class:"img-responsive", id:"logo-header"})}}
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li {{ Control == "Nosotros" ? 'class="activo "' : '' }} ><a href="nosotros">Nosotros</a></li>
        <li {{ Control == "Conoce" ? 'class="activo"' : '' }} ><a href="conoce#programas">Programas</a></li>
				<li {{ Control == "Comisiones" ? 'class="activo"' : '' }} ><a href="comisiones">Comisiones</a></li>
        <li {{ Control == "Involucrate" ? 'class="activo"' : '' }} ><a href="involucrate">Involúcrate</a></li>
        <li {{ Control == "Empresas" ? 'class="activo"' : '' }} ><a href="empresas">Empresas</a></li>
				<li {{ Control == "Donativos" ? 'class="activo"' : '' }} ><a href="donativos">Donativos</a></li>
				<li {{ Control == "Liga" ? 'class="activo"' : '' }} class="li-liga"><a href="liga">Liga de la Esperanza</a></li>
        <li {{ Control == "Eventos" ? 'class="activo"' : '' }}><a href="eventos">Eventos</a></li>
        <li {{ Control == "Blog" ? 'class="activo"' : '' }} style="text-align:center;"><a href="blog">Blog</a></li>
        <li {{ Control == "Galeria" ? 'class="activo"' : '' }}><a href="galeria">Galería</a></li>
        <li {{ Control == "Contacto" ? 'class="activo"' : '' }}><a href="contacto">Contacto</a></li>
				<li {{ Control == "Donativos" ? 'class="activo esconde"' : 'class="esconde"' }} ><a href="donativos" style="color:#DC4654;"> Donativos</a></li>
				<li {{ Control == "Liga" ? 'class="activo esconde"' : 'class="esconde"' }} ><a href="liga" style="color:#F46819;">Liga de la Esperanza</a></li>
      </ul>
    </div>
  </div>
  <div class="container-fluid flat-green"><label class="label-white" id="informacion" >Teléfono +52 (664) 634 3338</label>
    <ul class="sociales-nav">
			<li><a id="fb1" target="_blank" href="" class="fa fa-facebook"></a></li>
			<li><a id="tw1" target="_blank" href="" class="fa fa-twitter"></a></li>
			<li><a id="yt1" target="_blank" href="" class="fa fa-youtube"></a></li>
			<li><a id="insta1" target="_blank" href="" class="fa fa-instagram"></a></li>
    </ul>
  </div>
</nav>
<div class="container-fluid img-template">
<div class="col-md-1 col-xs-12" id="orange-box">
    <div class="col-md-12 col-xs-2 orange-button" id="orange-button1">{{Html.Img("templates/fundacion/fileimages/corazon.svg",{class:"img-responsive orange-img"})}} <div class="hrtone"> ¡Ellos cuentan con tu apoyo! <a href="donativos"><div class="donahsq">dona aquí</div></a></div></div>
    <div class="col-md-12 col-xs-2 orange-button orange-button2" id="orange-button2">{{Html.Img("templates/fundacion/fileimages/balon.svg",{class:"img-responsive orange-img"})}} <div class="hrtone"> Liga de la Esperanza conócela <a href="liga"><div class="donahsq">y participa aquí</div></a></div></div>
  </div>
</div>
<div class="cuerpo">
  {{body}}
</div>
<footer>
  <div class="col-md-12 col-xs-12 footer-menu">
    <div class="col-md-12">
      <div class="col-md-3">
       {{Html.Img("templates/fundacion/fileimages/logo.svg",{class:"img-responsive logofot"})}}
        <p id="dir" class="dir-footer"></p>
      </div>
      <div class="col-md-2">
        <ul class="footer-list">
          <li><a href="nosotros" ><label style="cursor:pointer;" for="">Nosotros</label><a href=""></li>

          <li><a href="nosotros#somos">Somos</a></li>
          <li><a href="nosotros#metas">Metas</a></li>
          <li><a href="nosotros#consejo">Consejo</a></li>
          <li><a href="nosotros#voluntarios">Voluntarios</a></li>
          <li><a href="nosotros#transparencia">Transparencia</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <ul class="footer-list">
					<li><a href="conoce" ><label style="cursor:pointer;" for="">Conoce</label><a href=""></li>
      <!--    <li><a href="">Retos</a></li>  -->
          <li><a href="conoce#modelo">Modelo Integral</a></li>
          <li><a href="conoce#programas">Programas</a></li>
          <li><a href="conoce#convocatorias">Convocatorias</a></li>
          <li><a href="conoce#casos">Casos de Éxito</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <ul class="footer-list">
					  <li><a href="involucrate" ><label style="cursor:pointer;" for="">Involúcrate</label><a href=""></li>

          <li><a href="involucrate#red">Red de voluntarios</a></li>
          <li><a href="involucrate#practicas">Prácticas Profesionales</a></li>
          <li><a href="donativos">Donativos</a></li>
        </ul>
        <ul class="footer-list">
						  <li><a href="empresas" ><label style="cursor:pointer;" for="">Empresas</label><a href=""></li>

            <li><a href="empresas#taller-div">Taller RSE</a></li>
            <li><a href="empresas#dona">Donativos</a></li>
        </ul>
      </div>
      <div class="col-md-2">
        <ul class="footer-list">
					<li><a href="liga" ><label style="cursor:pointer;" for="">Liga de la esperanza</label><a href=""></li>
          <li><a href="liga#que">¿Qué es?</a></li>
          <li><a href="liga#saber-liga">¿Cómo funciona?</a></li>
          <li><a href="liga#patrocino">Patrocina</a></li>
          <li><a href="liga#calendar">Calendario</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-12 line col-xs-12"></div>
    <div class="col-md-12 first-footer">
      <div class="col-md-7 col-xs-12">
        <label id="tel" class="purple"></label>
				<div class="col-md-12 text-right social-icons social-iconsftr">
				<ul class="social-share">
					<div class="sharesec1">

								<li style="margin-right: 8px;display: inline;">
									<a href="https://twitter.com/share" class="twitter-share-button" data-show-count="false">Tweet</a>
								</li>
								<li style="margin-right: 9px;display: inline;">
									<div class="fb-share-button" 	 data-href="http://esperanzacontigo.org/" style="display: inline-flex;"	 data-layout="button_count"></div>
									</li>
						</div>
							<div class="sharesec2">
									<li style="margin-right: 9px;display: inline;">
								<div class="g-plus" data-action="share" data-annotation="bubble" data-href="http://esperanzacontigo.org/"></div>
								</li>
								<li>
								<script type="IN/Share" data-counter="right"></script>
							</li>
							</div>
			</ul>
			</div>
      </div>
      <div class="col-md-5 col-xs-12" id="sociales-footer">
        <div class="col-md-4 txtprpls" style="text-align: right;padding-right:0">
          <label class="purple">Síguenos</label>
        </div>
        <div class="col-md-8 redsfoot">
            <ul class="redsfoot">
              <li><a id="fb" href="" class="fa fa-facebook"></a></li>
              <li><a id="tw" href="" class="fa fa-twitter"></a></li>
              <li><a id="yt" href="" class="fa fa-youtube"></a></li>
              <li><a id="insta" href=""class="fa fa-instagram"></a></li>
            </ul>
        </div>
      </div>
			<div class="col-md-7 col-xs-12">


					<label class="purple" id="email" style="margin-top: -20px;position: absolute;"></label>

		</div>
    </div>
  </div>
  <div class="col-md-12 col-xs-12 flat-purple">
    <div class="col-md-5 col-xs-12"><label>Todos los derechos reservados.
Fundación Esperanza Contigo, A.C.</label></div>
    <div class="col-md-3 col-xs-12"><a href="avisodeprivacidad" class="privacidad">Aviso de Privacidad</a></div>
  </div>
	<div class="col-md-12 linea-footer col-xs-12">
	</div>
	<div class="col-md-12 footer-negro col-xs-12">
	<a href="http://www.grupoconsultorefe.com/" style="text-decoration:none;color: #fff;"  target="_blank">  PROGRAMA DE RESPONSABILIDAD SOCIAL EMPRESARIAL DE GRUPO CONSULTOR EFE™ </a>
	</div>
</footer>

</body>
</html>
