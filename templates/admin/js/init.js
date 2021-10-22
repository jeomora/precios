App.body = $("body");
App.header = $("header");
App.cliente = App.body.attr("class");
App.control = App.body.data("control");
App.referer = App.body.data("referer");
App.imgLoader = App.body.data("loader");
App.mlateral = $("#mlateral");
App.permisos = $localStore.get("permisosEurogruas");
App.menu = $localStore.get("menuEurogruas");
App.token = $localStore.get("tokenEurogruas");
App.page = $("#page");
App.navbar = App.header.find(".navbar-nav");
App.barra =$("#barra");
App.listones =$("#listones");
App.pheading=$("#pheading");
App.panel=$("#panel");
App.panel2=$("#panel2");
App.footer=$("#footer");
App.icono=$("#icono-soporte");


App.body
.removeData(["control", "referer", "loader"])
.removeAttr("data-control data-referer data-loader");

App.page.removeAttr("class");

if(App.token){
    if (App.menu==0){
        $("#menublogs").remove();
        $("#menutest").remove();
    }
    else if (App.menu==1){
        $("#menuadmin").remove();
        $("#menutest").remove();
    }
    else if (App.menu==2){
        $("#menuadmin").remove();
        $("#menublogs").remove();
    }
    var encoded = App.token.split('.')[1];
    App.user = JSON.parse(App.urlBase64Decode(encoded));
    App.user.data.exp = App.user.exp;
    App.user = App.user.data;

    App.page.addClass("container-fluid");
    App.header.addClass("scrolling");


    $("#btnSalir").click(function(){
        $localStore.drop("tokenEurogruas");
        $localStore.drop("permisosEurogruas");
        $localStore.drop("menuEurogruas");

        location.href = "admin/usuarios/login";
        return false;
    });

        $('#soport').click(function () {
        $('#Modalsoporte').modal('show');
        return false;
            });

        var URLSITE = "{{ Html.Link('','',{action:true}) }}";

            $(window).scroll(function() {
                var scroll = $(window).scrollTop();

                if (scroll >= 50) {
                    $(".navbar").addClass("scrolling");
                } else {
                    $(".navbar").removeClass("scrolling");
                }
            });

            BootstrapDialog.confirm = function(message, callback) {
                new BootstrapDialog({
                    title: '<i class="fa fa-warning peligro"></i>',
                    message: message,
                    type: BootstrapDialog.TYPE_DANGER,
                    closable: false,
                    size: BootstrapDialog.SIZE_NORMAL,
                    data: {
                        'callback': callback
                    },
                    buttons: [{
                        label: 'Sí',
                        cssClass: 'btn-primary btn-agregar',
                        action: function(dialog) {
                            typeof dialog.getData('callback') === 'function' && dialog.getData('callback')(true);
                            dialog.close();
                        }
                    },
                    {
                        label: 'No',
                        cssClass: 'btn-primary btn-agregar',
                        action: function(dialog) {
                            typeof dialog.getData('callback') === 'function' && dialog.getData('callback')(false);
                            dialog.close();
                        }
                        }]
                }).open();
            };


        $("#btnGuardar").click(function(){
            App.icono.addClass("fa-spin");
            $("#titulo-modal").css("display","none");
            $("#frmSoporte").css("display","none");
            $(".modal-cabecera").append("<div>Enviando</div>");
            $(".modal-cuerpo").append("<div style='font-size: 30px;'>Procesando su solicitud...</div>");
        });


        $("#frmSoporte").jform({
            after:function(response){
            redireccion="admin";
            App.Alert(response,redireccion);
            }
        });


}else{

    if(location.pathname.indexOf("admin/usuarios/login") != -1){
        App.page.addClass("container col-md-4 col-md-offset-4");
        App.page.find(".panel .panel-heading").html('<i class="fa fa-user"></i>INGRESAR AL PANEL');
        App.barra.remove();
        App.listones.remove();
        App.pheading.remove();
        App.footer.remove();
        App.mlateral.remove();
        App.panel2.removeClass("col-md-10");
        App.panel.removeClass("panel");
        App.panel2.addClass("col-md-12");
        App.navbar.remove();
    }else location.href = "admin/usuarios/login";
}
