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
        comparaciones()
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
    
    getComparacion().done(function(resp){
        var p11 = 0;var p111 = 0;
        if(resp){
            var flagcien = 1;var clasecien="style='display:table-row'";
            $.each(resp,function(index,value){
                var p1 ="";var p2 ="";var p3 ="";var p4 ="";var p5 ="";var cofes = "";var pzofe = value.p1;
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
                if( index >= (50 * flagcien) ){
                    flagcien++;
                    clasecien="style='display:none;'";
                }
                if( value.cofe != null && value.cofe != "" && value.cofe != undefined ){
                    cofes = "cofes";
                    pzofe = value.precio
                }
                $(".tbodyCompa").append('<tr class="cienrow cien'+flagcien+'" '+clasecien+'><td class="'+cofes+'">'+(index+1)+'</td><td class="'+cofes+'">'+value.codigo+'</td><td class="'+cofes+'">'+value.nombre+'</td><td class="'+cofes+'">'+value.ums+'</td>'+
                    '<td '+p1+'>'+value.preciouno+'</td><td '+p2+'>'+value.preciodos+'</td><td '+p3+'>'+value.preciotres+'</td><td '+p4+'>'+value.preciocuatro+'</td><td '+p5+'>'+value.preciocinco+'</td>'+
                    '<td class="'+cofes+'">'+value.codigo2+'</td><td class="'+cofes+'">'+value.nombre2+'</td><td class="'+cofes+'">'+value.ums+'</td>'+
                    '<td class="'+cofes+'">'+formatMoney(pzofe)+'</td><td>'+value.p2+'</td><td>'+value.p3+'</td><td>'+value.p4+'</td><td>'+value.p5+'</td></tr>')
            })
            console.log(flagcien)
            $(".countRojo").html(p111);
            $(".countVerde").html(p11)//<button type="button" class="btn btn-outline-secondary font-weight-bold">26 - 50</button>
            var rowload = '<div class="btn-group" role="group" aria-label="Button group with nested dropdown"><button type="button" class="btn btn-outline-secondary font-weight-bold btnpagsuc btnpagsuc1 btn-dark" data-id-rojo="1">1 - 50</button>';
            for (var i = 1; i < flagcien - 1; i++) {
                rowload += '<button type="button" class="btn btn-outline-secondary font-weight-bold btnpagsuc btnpagsuc'+(i + 1)+'" data-id-rojo="'+(i + 1)+'">'+(i * 50 + 1)+' - '+((i + 1) * 50)+'</button>'
            }
            rowload += '<button type="button" class="btn btn-outline-secondary font-weight-bold btnpagsuc btnpagsuc'+flagcien+'" data-id-rojo="'+flagcien+'">'+((flagcien-1) * 50)+' +</button>'
            $(".rowLoad").html(rowload+'</div><div><h4 style="font-size:16px"><br>Se encontrarón '+resp.length+' resultados</h4></div>');
        }else{
            $(".rowLoad").html('<div class="col-xl-3"><h1 class="text-danger">NO SE ENCONTRARÓN DATOS, POR FAVOR ACTUALICE SU PAGINA PARA INTENTARLO NUEVAMENTE</h1></div><div class="col-xl-6"><img src="assets/img/loading4.gif" class="rowLoadImg"></div>');
        }
    })
}

$(document).off("click",".btnpagsuc").on("click",".btnpagsuc",function(e){
    e.preventDefault();
    var dis = $(this).data("idRojo");
    
    $(".cienrow").css("display","none")
    $(".cien"+dis).css("display","table-row")

    $(".btnpagsuc").removeClass("btn-dark")
    $(".btnpagsuc"+dis).addClass("btn-dark")
})