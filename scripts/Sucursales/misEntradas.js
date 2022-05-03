'use strict';

var imageName= "";var imageName2= "";
jQuery(document).ready(function() {
    $("#titlePrincipal").html("ENTRADAS TXT");
});

function goBack() {
  window.history.back();
}

var theDate = new Date().getTime();
Dropzone.autoDiscover = false;

var myDropzoneV = new Dropzone("div#kt_dropzone_venta", {
    paramName: "file_inventario",
    maxFiles: 1,
    maxFilesize: 200, // MB
    timeout: 1800000,
    renameFilename: function (filename) {
        return theDate + '_' + filename;
    },
    url: site_url+"Entradas/subeEntrada",
    autoProcessQueue: true,
    queuecomplete: function (resp) {
        toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": "location.reload()",
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "1000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
        };
        toastr.success("Listo","Espere un momento a que se carguen los datos");
    },
    success: function(file, response){
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
        myDropzoneV.removeAllFiles();
        imageName2 = response;
        location.reload();
        $("#ultTxt").html("<h1>Archivo del día : <a href='assets/img/entradas/"+response+"' target='_blank'>"+time+"</a></h1>")
        
    }
});
