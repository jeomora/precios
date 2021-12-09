'use strict';
var rojosArray = [];
var almacena = [];
var brojosArray = [];
var balmacena = [];
var descChange = 0;
var idLinea = 0;
jQuery(document).ready(function() {
    $("#titlePrincipal").html("CAMBIO DE PRECIOS ADMINISTRADOR");
    $(".spinSpan").css("display","none")
    
    getMeNews();
});

function getMeNews(){
    $(".otrosShowsB").html("");
    $(".otrosShows").html("");
    getNuevosA().done(function(resp){
        $(".otrosShows").html("");
        if(resp){
            oldResultsA(resp);
        }
    })
    getNuevosB().done(function(resp){
        $(".otrosShowsB").html("");
        if(resp){
            oldResultsB(resp);
        }
    })
}

function getNuevosA() {
    return $.ajax({
        url: site_url+"Uploads/getNuevosA",
        type: "POST",
        cache: false,
    });
}

function getNuevosB() {
    return $.ajax({
        url: site_url+"Uploads/getNuevosB",
        type: "POST",
        cache: false,
    });
}

function oldResultsA(respo){
    $.each(respo,function(inx,val){
        if (val.suca != 0){
            var new_table = '<div class=row><table class="table table-bordered" style="text-align:center;"><thead><tr><th class="gensuca" colspan="5" style="padding:0">'+setZeros2(val.id_nuevo)+'</th>'+
                '<th><a class="nav-link" target="_blank" href="Codigos/qrme/'+val.id_nuevo+'"><img src="assets/img/codigo-qr.png" style="height:45px"></a></th><th>'+
                '<a class="nav-link" target="_blank" href="Uploads/excelA/'+val.id_nuevo+'"><img src="assets/img/excel.svg" style="height:45px"></a></th><th colspan="7">'+
                formatDate2(getDate())+'</th><th colspan="17" style="background:rgb(255,51,51)">AJUSTES</th></tr><tr><th style="width:100px" >CÓDIGO</th><th style="width:100px" >RENGLON 18</th><th style="width:70px" >LIN</th>'+
                '<th style="width:350px" >DESCRIPCIÓN</th><th style="width:70px" >UM</th><th style="width:100px" >C</th><th style="width:150px" >PAQUETE</th>'+
                '<th style="width:100px" class="ivaClass">IVA</th><th style="width:100px" class="renglon10Class">RENGLON 10</th><th colspan="5">PRECIOS DEL 1 AL 5</th>'+
                '<th style="width:100px" >CÓDIGO</th><th style="width:350px" >DESCRIPCIÓN</th>'+
                '<th style="" colspan="5">PRECIOS DEL 1 AL 5</th></tr></thead><tbody>';
            $.each(val.detalles,function(index,value){
                if (value){
                    var renglon10 = ( value.costo/value.cantidad ) / ( 1+(value.iva/100) );
                    new_table += '<tr><td>'+value.code1+'</td><td>'+value.code2+'</td><td>'+value.linea+'</td><td>'+value.desc1+'</td><td>'+value.unidad+'</td><td>'+value.cantidad+'</td><td>'+value.costo+'</td>'+
                        '<td class="ivaClass">'+formatMoney(value.iva,0)+'</td><td class="renglon10Class">'+value.rdiez+'</td><td>'+formatMoney(value.pre11)+'</td><td>'+formatMoney(value.pre22)+
                        '</td><td>'+formatMoney(value.pre33)+'</td><td>'+formatMoney(value.pre44)+'</td><td>'+formatMoney(value.pre55)+'</td>'+
                        '<td>'+isnulo(value.code3)+'</td><td>'+isnulo(value.desc2)+'</td>'+
                        '<td>'+isnuloF(value.pre1)+'</td><td>'+isnuloF(value.pre2)+'</td><td>'+isnuloF(value.pre3)+'</td><td>'+isnuloF(value.pre4)+'</td><td>'+isnuloF(value.pre5)+'</td></tr>'
                }
            })
            
            new_table += '</tbody></table></div>';
            $(".otrosShows").prepend(new_table);
        }
    })
}

function oldResultsB(respo){
    $.each(respo,function(indx,value){
        if (value.sucb != 0){
            var oldsB = '<div class="row" style="overflow-x:scroll;padding-bottom: 50px;"><table class="table table-bordered" style="text-align:center;"><thead><tr><th class="gensuca" colspan="4" style="padding:0">'+
                                setZeros2(value.id_nuevo)+'</th>'+
                                '<th><a class="nav-link" target="_blank" href="Uploads/excelB/'+value.id_nuevo+'"><img src="assets/img/excel.svg" style="height:45px"></a></th>'+
                                '<th colspan="7">'+formatDate2(value.fecha_registro)+'</th><th colspan="18" style="background:rgb(255,51,51)">AJUSTES</th></tr><tr>'+
                                '<th style="width:100px" >CÓDIGO</th><th style="width:100px" >RENGLON 18</th><th style="width:70px" >LIN</th><th style="width:350px" >DESCRIPCIÓN</th><th style="width:70px" >UM</th>'+
                                '<th style="width:100px" >C</th><th style="width:150px" >COSTO<br>PZA</th><th style="width:100px" class="ivaClass">IVA</th><th style="width:100px" class="renglon10Class">RENGLON 10</th>'+
                                '<th colspan="3" style="background:#bdd7ee">PRECIOS DEL 1 AL 3</th><th style="width:100px" >CÓDIGO</th><th style="width:350px" >DESCRIPCIÓN</th>'+
                                '<th style="width:100px" >PAQUETE</th><th style="background:#bdd7ee" colspan="3">PRECIOS DEL 1 AL 3</th></tr></thead><tbody>';

            $.each(value.detalles,function(inx,val){
                if(val.estatusb != "0"){
                    var renglon10 = ( val.costo/val.cantidad ) / ( 1+(val.iva/100) );

                    oldsB +=    '<tr><td>'+val.code1+'</td><td>'+val.code2+'</td><td>'+val.linea+'</td><td>'+val.desc1+'</td><td>'+val.unidad+'</td><td>'+val.cantidad+'</td><td>'+formatMoney(val.costo)+'</td>'+
                                '<td class="ivaClass">'+val.iva+'</td><td class="renglon10Class">'+val.rdiez+'</td><td class="precioB">'+formatMoney(val.pre11)+'</td><td class="precioB">'+formatMoney(val.pre22)+
                                '</td><td class="precioB">'+formatMoney(val.pre33)+'</td><td>'+isnulo(val.code3)+'</td><td>'+isnulo(val.desc2)+'</td><td>'+isnuloF(val.costopz)+'</td><td class="precioB">'+isnuloF(val.pre1)+'</td><td class="precioB">'+
                                isnuloF(val.pre2)+'</td><td class="precioB">'+isnuloF(val.pre3)+'</td></tr>';
                }                        
            })

            oldsB += '</tbody></table></div>';
            $(".otrosShowsB").prepend(oldsB)
        }
    })
}


var theDate = new Date().getTime();
Dropzone.autoDiscover = false;

var myDropzoneMatriz = new Dropzone("div#kt_dropzone_uno", {
    paramName: "file_matriz",
    maxFiles: 1,
    maxFilesize: 200, // MB
    timeout: 1800000,
    renameFilename: function (filename) {
        return filename;
    },
    url: site_url+"Uploads/upload_matriz",
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

var myDropzoneCatalogo = new Dropzone("div#kt_dropzone_dos", {
    paramName: "file_catalogo",
    maxFiles: 1,
    maxFilesize: 200, // MB
    timeout: 1800000,
    renameFilename: function (filename) {
        return filename;
    },
    url: site_url+"Uploads/upload_catalogo",
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
        myDropzoneCatalogo.removeAllFiles();
        if(response === "Documento incorrecto"){
            toastr.error("Por favor revise el txt que se subió a la plataforma","Archivo incorrecto");
        }else{
            toastr.success("Se cargarón correctamente los datos","Listo");
        }
        
    }
});

var myDropzoneCambios  = new Dropzone("div#kt_dropzone_cuatro", {
    paramName: "file_excel",
    maxFiles: 1,
    maxFilesize: 200, // MB
    timeout: 1800000,
    renameFilename: function (filename) {
        return filename;
    },
    url: site_url+"Uploads/upload_cambios",
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
        myDropzoneCambios.removeAllFiles();
        if(response === "Archivo invalido"){
            toastr.error("Por favor revise el archivo que se subió a la plataforma","Archivo invalido o vacio");
        }else{
            toastr.success("Se cargarón correctamente los datos","Listo");
        }
        getMeNews();
    }
});


function isnulo(vlo){
    vlo = vlo == null ? "" : vlo;
    vlo = vlo == 0 ? "" : vlo;
    return vlo;
}
function isnuloF(vlo){
    vlo = vlo == null ? "" : vlo;
    vlo = vlo == 0 ? "" : formatMoney(vlo);
    return vlo;
}

function getDate(){
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = mm + '/' + dd + '/' + yyyy;
    return today;
}
