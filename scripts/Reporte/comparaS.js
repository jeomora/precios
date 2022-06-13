var imageName= "";var imageName2= "";
jQuery(document).ready(function() {
    $("#titlePrincipal").html("ARCHIVOS TXT");
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
              "newestOnTop": true,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300000",
              "hideDuration": "100000",
              "timeOut": "500000",
              "extendedTimeOut": "1000000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
        };
        
    },
    success: function(file, response){
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
        myDropzoneV.removeAllFiles();
        imageName2 = response;
        toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": true,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "3000000",
              "hideDuration": "1000000",
              "timeOut": "5000000",
              "extendedTimeOut": "10000000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
        };
        toastr.success("Se subio el archivo correctamente",response);
        //location.reload();
        $("#ultTxt").html("<h1>Archivo del día : "+time+"</h1>")
        
    }
});
