
<!DOCTYPE html>
<html lang="en" >
    <!--begin::Head-->
    <head><base href="<?php  echo base_url('') ?>">
        <meta charset="utf-8"/>
        <title>REGISTROS 2021</title>
        <meta name="description" content="Login page example"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>        <!--end::Fonts-->


        <!--begin::Page Custom Styles(used by this page)-->
            <link href="assets/css/pages/login/login-1.css?v=7.0.6" rel="stylesheet" type="text/css"/>
        <!--end::Page Custom Styles-->

        <!--begin::Global Theme Styles(used by all pages)-->
                    <link href="assets/plugins/global/plugins.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                    <link href="assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                    <link href="assets/css/style.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                <!--end::Global Theme Styles-->

        <!--begin::Layout Themes(used by all pages)-->
                <!--end::Layout Themes-->

        <link rel="shortcut icon" href="assets/img/abarrotes-min.ico"/>
        <script>
			var base_url = "<?php echo base_url("/"); ?>";
			var site_url = "<?php echo site_url("/"); ?>";
		</script>
        <style type="text/css">
            .logo-login{height:260px;max-width:100%;}
             @media (max-width: 800px){
                .logo-login{height:200px;max-width:100%;}
                a.text-center.mb-10{margin-bottom: 0 !important;}
                .d-flex.flex-column-auto.flex-column.pt-lg-40.pt-15{padding:0 !important;margin:0 !important;}
             }
        </style>
    </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_body"  class="header-fixed header-mobile-fixed subheader-enabled page-loading"  >

    	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-info" id="kt_login" style="background:#7E57C2 !important">
    <!--begin::Aside-->
    <div class="login-aside d-flex flex-column flex-row-auto" style="background-color:#FFF;">
        <!--begin::Aside Top-->
        <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
            <!--begin::Aside header-->
            <a href="#" class="text-center mb-10">
				<img src="assets/img/aztecalogo.png" class="logo-login" alt="" />
			</a>
            <!--end::Aside header-->

            <!--begin::Aside title-->
            <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg text-dark">
                Precios Azteca<br/>
                <span style="font-size:12px">Developed by I.T.I Jeovany Mora</span>
            </h3>
            <!--end::Aside title-->
        </div>
        <!--end::Aside Top-->

        <!--begin::Aside Bottom-->
        <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(assets/media/svg/illustrations/login.svg)"></div>
        <!--end::Aside Bottom-->
    </div>
    <!--begin::Aside-->

    <!--begin::Content-->
    <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
        <!--begin::Content body-->
        <div class="d-flex flex-column-fluid flex-center">
            <!--begin::Signin-->
            <div class="login-form login-signin">
                <!--begin::Form-->
                <form class="form"  id="kt_login_signin_form" action="Inicio/validamesta">
                    <!--begin::Title-->
                    <div class="pb-13 pt-lg-0 pt-5">
                        <h2 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Bienvenido Al Dashboard</h2>
                        <h3 class="font-weight-bolder text-dark font-size-h4">Por favor, ingrese sus datos</h3>
                    </div>
                    <!--begin::Title-->

                    <!--begin::Form group-->
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Correo</label>
                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg username" type="text" id="username" name="username" autocomplete="off"/>
                    </div>
                    <!--end::Form group-->

                    <!--begin::Form group-->
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-n5">
                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">Contraseña</label>
                        </div>

                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg password" type="password" name="password" id="password" autocomplete="off"/>
                    </div>
                    <!--end::Form group-->

                    <!--begin::Action-->
                    <div class="pb-lg-0 pb-5">
                        <button type="button" id="kt_login_signin_submit" style="background-color:#030171;border-color:#030171" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Ingresar</button>
                    </div>
                    <!--end::Action-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Signin-->

            <!--begin::Forgot-->
            <div class="login-form login-forgot">
                <!--begin::Form-->
                <form class="form" novalidate="novalidate" id="kt_login_forgot_form">
                    <!--begin::Title-->
                    <div class="pb-13 pt-lg-0 pt-5">
                        <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">¿Olvido su contraseña?</h3>
                        <p class="text-muted font-weight-bold font-size-h4">Ingrese su usuario para hacerle llegar su nueva contraseña</p>
                    </div>
                    <!--end::Title-->

                    <!--begin::Form group-->
                    <div class="form-group">
                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off"/>
                    </div>
                    <!--end::Form group-->

                    <!--begin::Form group-->
                    <div class="form-group d-flex flex-wrap pb-lg-0">
                        <button type="button" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Restaurar Contraseña</button>
                        <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancelar</button>
                    </div>
                    <!--end::Form group-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Forgot-->
        </div>
        <!--end::Content body-->

        <!--begin::Content footer-->
        <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
            <!--<a href="#" class="text-primary font-weight-bolder font-size-h5" style="color:#663259 !important">Terminos y condiciones</a>-->
            <a href="#" class="text-primary ml-10 font-weight-bolder font-size-h5" style="color:#663259 !important">Contáctanos</a>
        </div>
        <!--end::Content footer-->
    </div>
    <!--end::Content-->
</div>
<!--end::Login-->
	</div>
<!--end::Main-->


        <!--<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
        begin::Global Config(global config for global JS scripts)-->
        <script>
            var KTAppSettings = {
    "breakpoints": {
        "sm": 576,
        "md": 768,
        "lg": 992,
        "xl": 1200,
        "xxl": 1200
    },
    "colors": {
        "theme": {
            "base": {
                "white": "#ffffff",
                "primary": "#8950FC",
                "secondary": "#E5EAEE",
                "success": "#1BC5BD",
                "info": "#8950FC",
                "warning": "#FFA800",
                "danger": "#F64E60",
                "light": "#F3F6F9",
                "dark": "#212121"
            },
            "light": {
                "white": "#ffffff",
                "primary": "#E1E9FF",
                "secondary": "#ECF0F3",
                "success": "#C9F7F5",
                "info": "#EEE5FF",
                "warning": "#FFF4DE",
                "danger": "#FFE2E5",
                "light": "#F3F6F9",
                "dark": "#D6D6E0"
            },
            "inverse": {
                "white": "#ffffff",
                "primary": "#ffffff",
                "secondary": "#212121",
                "success": "#ffffff",
                "info": "#ffffff",
                "warning": "#ffffff",
                "danger": "#ffffff",
                "light": "#464E5F",
                "dark": "#ffffff"
            }
        },
        "gray": {
            "gray-100": "#F3F6F9",
            "gray-200": "#ECF0F3",
            "gray-300": "#E5EAEE",
            "gray-400": "#D6D6E0",
            "gray-500": "#B5B5C3",
            "gray-600": "#80808F",
            "gray-700": "#464E5F",
            "gray-800": "#1B283F",
            "gray-900": "#212121"
        }
    },
    "font-family": "Poppins"
};
        </script>
        <!--end::Global Config-->

    	<!--begin::Global Theme Bundle(used by all pages)-->
    	    	   <script src="assets/plugins/global/plugins.bundle.js?v=7.0.6"></script>
		    	   <script src="assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.6"></script>
		    	   <script src="assets/js/loginscr.js?v=7.0.6"></script>
				<!--end::Global Theme Bundle-->


                    <!--begin::Page Scripts(used by this page)-->
                            <script src="assets/js/pages/custom/login/login-general.js?v=7.0.6"></script>
                        <!--end::Page Scripts-->
            </body>
    <!--end::Body-->
</html>
