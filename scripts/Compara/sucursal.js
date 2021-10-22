jQuery(document).ready(function() {
    $("#titlePrincipal").html("COMPARACIÓN DE PRECIOS");
    comparaciones();
});


var theDate = new Date().getTime();
Dropzone.autoDiscover = false;

var myDropzoneMatriz = new Dropzone("div#kt_dropzone_uno", {
    paramName: "file_matriz",
    maxFiles: 1,
    maxFilesize: 200, 
    timeout: 1800000,
    renameFilename: function (filename) {
        return filename;
    },
    url: site_url+"Compara/upload_matriz",
    autoProcessQueue: true,
    queuecomplete: function (resp) {
        toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "1000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
        };
    },
    success: function(file, response){
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
        myDropzoneMatriz.removeAllFiles();
        if(response === "Documento incorrecto"){
            toastr.error("Por favor revise el txt que se subió a la plataforma","Archivo incorrecto");
        }else{
            toastr.success("Se cargarón correctamente los datos","Listo");
        }
        
    }
});


function getComparacion() {
    return $.ajax({
        url: site_url+"Compara/getComparacion",
        type: "POST",
        cache: false,
    });
}

function comparaciones() {
    $(".tbodyCompa").html("");
    getComparacion().done(function(resp){
        var p11 = 0;var p111 = 0;
        if(resp){
            $.each(resp,function(index,value){
                var p1 ="";var p2 ="";var p3 ="";var p4 ="";var p5 ="";
                if (parseFloat(value.preciouno) > parseFloat(value.p1)){
                    p1 = "style='background:#BAF3E0'";
                    p11++;
                }else if(parseFloat(value.preciouno) < parseFloat(value.p1)){
                    p1 = "style='background:#F9BABA'";
                    p111++;
                }
                if (parseFloat(value.preciodos) > parseFloat(value.p2)){
                    p2 = "style='background:#BAF3E0'";
                }else if(parseFloat(value.preciodos) < parseFloat(value.p2)){
                    p2 = "style='background:#F9BABA'";
                }
                if (parseFloat(value.preciotres) > parseFloat(value.p3)){
                    p3 = "style='background:#BAF3E0'";
                }else if(parseFloat(value.preciotres) < parseFloat(value.p3)){
                    p3 = "style='background:#F9BABA'";
                }
                if (parseFloat(value.preciocuatro) > parseFloat(value.p4)){
                    p4 = "style='background:#BAF3E0'";
                }else if(parseFloat(value.preciocuatro) < parseFloat(value.p4)){
                    p4 = "style='background:#F9BABA'";
                }
                if (parseFloat(value.preciocinco) > parseFloat(value.p5)){
                    p5 = "style='background:#BAF3E0'";
                }else if(parseFloat(value.preciocinco) < parseFloat(value.p5)){
                    p5 = "style='background:#F9BABA'";
                }
                $(".tbodyCompa").append('<tr><td>'+value.codigo+'</td><td>'+value.nombre+'</td><td>'+value.ums+'</td>'+
                    '<td '+p1+'>'+value.preciouno+'</td><td '+p2+'>'+value.preciodos+'</td><td '+p3+'>'+value.preciotres+'</td><td '+p4+'>'+value.preciocuatro+'</td><td '+p5+'>'+value.preciocinco+'</td>'+
                    '<td class="">'+value.codigo2+'</td><td class="">'+value.nombre2+'</td><td class="">'+value.ums2+'</td>'+
                    '<td>'+value.p1+'</td><td>'+value.p2+'</td><td>'+value.p3+'</td><td>'+value.p4+'</td><td>'+value.p5+'</td></tr>')
            })
            $(".countRojo").html(p111);
            $(".countVerde").html(p11)
        }
    })
}