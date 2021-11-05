'use strict';
var rojosArray = [];
var almacena = [];
var descChange = 0;
var idLinea = 0;
jQuery(document).ready(function() {
    $("#titlePrincipal").html("CAMBIO DE PRECIOS ADMINISTRADOR");
    $(".spinSpan").css("display","none")
   
    getMaxNew().done(function(resp){
        if (resp.nuevo != null){
            $(".btn-show-rojos").html( setZeros2(parseInt(resp.nuevo)+1) )
            $(".btn-show-altas").html( setZeros2(parseInt(resp.nuevo)+1) )
        }else{
            $(".btn-show-rojos").html( setZeros2(1) )
            $(".btn-show-altas").html( setZeros2(1) )
        }
    })

    
    getMeDesc();
    getMeRojos();
    getMeAltas();
    getMeNews();
});

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

/*var myDropzoneExcel = new Dropzone("div#kt_dropzone_tres", {
    paramName: "file_excel",
    maxFiles: 1,
    maxFilesize: 200, // MB
    timeout: 1800000,
    renameFilename: function (filename) {
        return filename;
    },
    url: site_url+"Uploads/upload_excel",
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
        myDropzoneExcel.removeAllFiles();
        getMeRojos();
        if(response === "Archivo invalido"){
            toastr.error("Por favor revise el archivo que se subió a la plataforma","Archivo invalido o vacio");
        }else{
            toastr.success("Se cargarón correctamente los datos","Listo");
        }
        
    }
});*/

/******** DESCRIPCIONES DE PRODUCTOS ********
 * *********************************
 * *********************************
 * *********************************
 * *********************************
*********************************/

function getCambioDesc() {
    return $.ajax({
        url: site_url+"Uploads/getCambioDesc",
        type: "POST",
        cache: false,
    });
}
function getMeDesc(){
    getCambioDesc().done(function(resp){
        $(".descosBody").html("")
        if(resp){
            $.each(resp,function(index,value){
                $(".descosBody").append('<tr class="descoTr descoTr'+value.id_rojo+'"><td>'+
                    '<button type="button" class="btn btn-outline-info descoBtn" data-id-rojo="'+value.id_rojo+'" data-toggle="modal" data-target="#kt_modal_desco">CAMBIAR</button></td>'+
                    '</td><td>'+value.nombre+'</td><td>'+value.codigo+'</td>'+
                    '<td><input type="text" class="form-control inputransparent descoRojo descoRojo'+value.id_rojo+'" placeholder="'+value.descripcion+'" value="'+value.descripcion+'" data-id-rojo="'+value.id_rojo+'"/></td>'+
                    '<td>'+value.producto+'</td></tr>')
            })
        }else{
            $(".descosBody").html('<tr><td colspan="4" style="font-size:24px;">NO SE HAN SOLICITADO CAMBIOS</td></tr>')
            
        }
    })
}

$(document).off("click",".descoBtn").on("click",".descoBtn",function(event){
    event.preventDefault();
    var dis = $(this)
    var idrojo = dis.data("idRojo");
    descChange = idrojo;
});

$(document).off("change keyup",".descoRojo").on("change keyup",".descoRojo",function(event){
    event.preventDefault();
    var idrojo = $(this).data("idRojo");
    $(this).attr("value",$(this).val());
})

$(document).off("click",".change_row").on("click",".change_row",function(event){
    event.preventDefault();
    setCambiar( JSON.stringify({"id_rojo":descChange,"nuevo":$(".descoRojo"+descChange).val()}) ).done(function(resp){
        toastr.success("Se envió el cambio de descripción","Listo");
        $('#kt_modal_desco').modal('hide');
        $(".descoTr"+descChange).remove();
    })
})

function setCambiar(values) {
    return $.ajax({
        url: site_url+"Uploads/setCambiar",
        type: "POST",
        dataType: "JSON",
        data:{
            value : values
        }
    });
}

/******** DESCRIPCIONES DE PRODUCTOS ********
 * *********************************
 * *********************************
 * *********************************
 * *********************************
*********************************/

function getAltas() {
    return $.ajax({
        url: site_url+"Uploads/getAltas",
        type: "POST",
        cache: false,
    });
}


function isnulo(vlo){
    vlo = vlo == null ? "" : vlo;
    return vlo;
}
function getMeAltas(){
    
    getAltas().done(function(resp){
        $(".altasBody").html("")
        if(resp){
            var chain = "";
            $.each(resp,function(index,value){
                var lins = "";
                if(value.ides != "" && value.ides != null){
                    lins = value.ides
                }
                value.preciouno = isnulo(value.preciouno);value.preciodos = isnulo(value.preciodos);value.preciotres = isnulo(value.preciotres);value.preciocuatro = isnulo(value.preciocuatro);value.preciocinco = isnulo(value.preciocinco);
                value.iva = isnulo(value.iva);value.linea = isnulo(value.linea);value.ides = isnulo(value.ides);value.code1 = isnulo(value.code1);value.nombre = isnulo(value.nombre);
                var renglon10 = ( value.costo/value.um_nuevo ) / ( 1+(value.iva/100) );

                //MARGENES
                var mar1 = Math.round(((value.preciouno*100)/(value.preciocinco-0.01))-100);
                var mar2 = Math.round(((value.preciodos*100)/(value.preciocinco-0.01))-100);
                var mar3 = Math.round(((value.preciotres*100)/(value.preciocinco-0.01))-100);
                var mar4 = Math.round(((value.preciocuatro*100)/(value.preciocinco-0.01))-100);

                //PRECIOS CAJA*
                var pre1 = Math.ceil( ((value.costo * (mar1/100))+parseFloat(value.costo))*10 )/10;
                var pre2 = Math.ceil( ((value.costo * (mar2/100))+parseFloat(value.costo))*10 )/10;
                var pre3 = Math.ceil( ((value.costo * (mar3/100))+parseFloat(value.costo))*10 )/10;
                var pre4 = Math.ceil( ((value.costo * (mar4/100))+parseFloat(value.costo))*10 )/10;
                var pre5 = value.costo/value.um_nuevo + 0.01;

                //MARGENES PIEZA
                //MARGENES
                var mar11 = Math.round(((value.preciouno*100)/(value.preciocinco-0.01))-100);
                var mar22 = Math.round(((value.preciodos*100)/(value.preciocinco-0.01))-100);
                var mar33 = Math.round(((value.preciotres*100)/(value.preciocinco-0.01))-100);
                var mar44 = Math.round(((value.preciocuatro*100)/(value.preciocinco-0.01))-100);

                //POR PIEZA
                var costopz = value.costo / value.um_nuevo;
                var pre11 = Math.ceil( ((costopz * (mar11/100))+parseFloat(costopz))*10 )/10;
                var pre22 = Math.ceil( ((costopz * (mar22/100))+parseFloat(costopz))*10 )/10;
                var pre33 = Math.ceil( ((costopz * (mar33/100))+parseFloat(costopz))*10 )/10;
                var pre44 = Math.ceil( ((costopz * (mar44/100))+parseFloat(costopz))*10 )/10;
                var pre55 = parseFloat(value.costo) + 0.01;

                var arreid_rojo = { "id_rojo":value.id_rojo,"codigo1":value.codigo,"codigo2":"","lin":lins,"desc1":value.descripcion,"um":"","code3":value.codecaja,"desc2":value.descripcion, 
                    "cantidad":value.um_nuevo,"costo":value.costo,"iva":value.iva,"mar1":mar1,"mar11":mar11, "mar2":mar2,"mar22":mar22, "mar3":mar3,"mar33":mar33,"pre5":pre5, 
                    "mar4":mar4,"mar44":mar44, "pre1":pre1,"pre11":pre11,"pre2":pre2,"pre22":pre22, "pre3":pre3,"pre33":pre33, "pre4":pre4,"pre44":pre44,"mostrar":0,"matriz":"","costopz":costopz,
                    "estatus":2 }
                rojosArray[value.id_rojo] = arreid_rojo;

                var codeCaja = value.codecaja;

                chain = '<tr class="rojoTr rojoTr'+value.id_rojo+'" data-id-rojo="'+value.id_rojo+'">'+
                    '<td><button type="button" class="btn btn-outline-warning rojoBtn" data-id-rojo="'+value.id_rojo+'">Mostrar</button></td>'+
                    '<td>'+value.usua+'</td><td>'+value.codigo+'</td>'+
                    '<td><span class="form-control seLine seLine'+value.id_rojo+'">'+lins+'</span>'+
                    '<span class="listaLineas" data-toggle="modal" data-target="#kt_modal_lineas" style="cursor:pointer;background:aqua;" data-id-rojo="'+value.id_rojo+'">Cambiar linea</span></td>'+
                    '<td><textarea type="text" class="form-control inputransparent descoUno" placeholder="'+value.descripcion+'" value="'+value.descripcion+'">'+value.descripcion+'</textarea></td>'+
                    '<td><input type="text" class="form-control cantRojo" placeholder="'+formatMoney(value.um_nuevo,0)+'" value="'+formatMoney(value.um_nuevo,0)+'"/></td>'+
                    '<td><input type="text" class="form-control costoRojo" placeholder="'+formatMoney(value.costo)+'" value="'+formatMoney(value.costo)+'"/></td>'+
                    '<td class="thAsoc">'+value.linea+'<br>'+value.ides+'</td><td class="thAsoc">'+value.code1+'</td><td class="thAsoc">'+value.nombre+'</td>'+
                    '<td class="ivaClass"><input type="text" class="form-control inputransparent ivaRojo ivaRojo'+value.id_rojo+'" placeholder="'+formatMoney(value.iva,0)+'" value="'+formatMoney(value.iva,0)+'"/></td>'+
                    '<td class="renglon10Class">'+formatMoney(renglon10,5)+'</td>'+
                    '<td class="preciososRojos"><input type="text" class="form-control pre11Rojo" placeholder="'+formatMoney(pre11)+'" value="'+formatMoney(pre11)+'"/></td>'+
                    '<td class="preciososRojos"><input type="text" class="form-control pre22Rojo" placeholder="'+formatMoney(pre22)+'" value="'+formatMoney(pre22)+'"/></td>'+
                    '<td class="preciososRojos"><input type="text" class="form-control pre33Rojo" placeholder="'+formatMoney(pre33)+'" value="'+formatMoney(pre33)+'"/></td>'+
                    '<td class="preciososRojos"><input type="text" class="form-control pre44Rojo" placeholder="'+formatMoney(pre44)+'" value="'+formatMoney(pre44)+'"/></td>'+
                    '<td class="pre5">'+formatMoney(pre5)+'</td>'+
                    '<td class="margen1Class"><input type="text" class="form-control inputransparent mar11Rojo" placeholder="'+mar11+'" value="'+mar11+'"/></td>'+
                    '<td class="margen1Class"><input type="text" class="form-control inputransparent mar22Rojo" placeholder="'+mar22+'" value="'+mar22+'"/></td>'+
                    '<td class="margen1Class"><input type="text" class="form-control inputransparent mar33Rojo" placeholder="'+mar33+'" value="'+mar33+'"/></td>'+
                    '<td class="margen1Class"><input type="text" class="form-control inputransparent mar44Rojo" placeholder="'+mar44+'" value="'+mar44+'"/></td>'+
                    '<td><input type="text" class="form-control inputransparent codeDos" placeholder="'+codeCaja+'" value="'+codeCaja+'"/></td>'+
                    '<td><textarea type="text" class="form-control inputransparent descoDos" placeholder="'+value.descripcion+'" value="'+value.descripcion+'">'+value.descripcion+'</textarea></td>'+
                    '<td class="preciososRojos"><input type="text" class="form-control pre1Rojo" placeholder="'+formatMoney(pre1)+'" value="'+formatMoney(pre1)+'"/></td>'+
                    '<td class="preciososRojos"><input type="text" class="form-control pre2Rojo" placeholder="'+formatMoney(pre2)+'" value="'+formatMoney(pre2)+'"/></td>'+
                    '<td class="preciososRojos"><input type="text" class="form-control pre3Rojo" placeholder="'+formatMoney(pre3)+'" value="'+formatMoney(pre3)+'"/></td>'+
                    '<td class="preciososRojos"><input type="text" class="form-control pre4Rojo" placeholder="'+formatMoney(pre4)+'" value="'+formatMoney(pre4)+'"/></td>'+
                    '</td><td class="pre55">'+formatMoney(pre55)+'</td>'+
                    '<td class="margen2Class"><input type="text" class="form-control inputransparent mar1Rojo" placeholder="'+mar1+'" value="'+mar1+'"/></td>'+
                    '<td class="margen2Class"><input type="text" class="form-control inputransparent mar2Rojo" placeholder="'+mar2+'" value="'+mar2+'"/></td>'+
                    '<td class="margen2Class"><input type="text" class="form-control inputransparent mar3Rojo" placeholder="'+mar3+'" value="'+mar3+'"/></td>'+
                    '<td class="margen2Class"><input type="text" class="form-control inputransparent mar4Rojo" placeholder="'+mar4+'" value="'+mar4+'"/></td>'+
                    '</tr>';

                $(".altasBody").append(chain)
            });
        }else{
            $(".altasBody").html('<tr><td colspan="10" style="font-size:24px;">NO HAY SOLICITUDES PARA ALTA DE PRODUCTOS</td></tr>')
            
        }
    })
}

$(document).off("click",".descoBtn").on("click",".descoBtn",function(event){
    event.preventDefault();
    var dis = $(this)
    var idrojo = dis.data("idRojo");
    descChange = idrojo;
});

$(document).off("click",".listaLineas").on("click",".listaLineas",function(event){
    event.preventDefault();
    var dis = $(this)
    var idrojo = dis.data("idRojo");
    idLinea = idrojo;
});

$(document).off("click",".rowLinea").on("click",".rowLinea",function(event){
    event.preventDefault();
    var dis = $(this)
    var ides = dis.data("idRojo");
    $(".seLine"+idLinea).html(ides);
    rojosArray[idLinea]["lin"] = ides;

    var iva = dis.data("idIva");
    $(".ivaRojo"+idLinea).attr("value",iva)
    $(".ivaRojo"+idLinea).val(iva)
    changeIva($(".ivaRojo"+idLinea));
    $('#kt_modal_lineas').modal('hide');
});


$(document).off("change keyup",".descoUno").on("change keyup",".descoUno",function(event){
    event.preventDefault();
    var idrojo = $(this).closest(".rojoTr").data("idRojo");
    $(this).attr("value",formatMoney($(this).val()));
    rojosArray[idrojo]["desc1"] = $(this).val();
    console.log(rojosArray)
})

$(document).off("change keyup",".descoDos").on("change keyup",".descoDos",function(event){
    event.preventDefault();
    var idrojo = $(this).closest(".rojoTr").data("idRojo");
    $(this).attr("value",formatMoney($(this).val()));
    rojosArray[idrojo]["desc2"] = $(this).val();
    console.log(rojosArray)
})

$(document).off("change keyup",".codeDos").on("change keyup",".codeDos",function(event){
    event.preventDefault();
    var idrojo = $(this).closest(".rojoTr").data("idRojo");
    $(this).attr("value",formatMoney($(this).val()));
    rojosArray[idrojo]["code3"] = $(this).val();
    console.log(rojosArray)
})

/********CAMBIO DE PRECIOS ********
 * *********************************
 * *********************************
 * *********************************
 * *********************************
*********************************/

function getRojos() {
    return $.ajax({
        url: site_url+"Uploads/getRojos",
        type: "POST",
        cache: false,
    });
}

function getMeRojos(){
    getRojos().done(function(resp){
        $("#bodySucA").html("");
        if(resp){
            $.each(resp,function(index,value){
                
                if (!jQuery.isEmptyObject(value.relaciones) ) {
                    $.each(value.relaciones,function(indx,val){
                        initializeTable(value,val)
                    })
                }else{
                    initializeTable(value)
                }
            })
        }
    })
}

function initializeTable(value,val = []){
    
    var dif1 = value.costo - value.preciocinco;var cods2 = "";
    if (jQuery.isEmptyObject(val)){
        val.cantidad = 1;
        val.codigo = value.code1;
        cods2 = value.code2;
        val.descripcion = "";
        val.id_caja = 0;
        val.preciouno = value.preciouno;
        val.preciodos = value.preciodos;
        val.preciotres = value.preciotres;
        val.preciocuatro = value.preciocuatro;
        val.preciocinco = value.preciocinco;
    }else{
        val.cantidad = val.cantidad == 0 ? 1 : val.cantidad == "" ? 1 : val.cantidad == null ? 1 : val.cantidad;
    }
    var renglon10 = ( value.costo/val.cantidad ) / ( 1+(value.iva/100) );
    var pre5 = value.costo/val.cantidad + 0.01;
    var pre55 = parseFloat(value.costo) + 0.01;

    //MARGENES
    var mar1 = Math.round(((value.preciouno*100)/(value.preciocinco-0.01))-100);
    var mar2 = Math.round(((value.preciodos*100)/(value.preciocinco-0.01))-100);
    var mar3 = Math.round(((value.preciotres*100)/(value.preciocinco-0.01))-100);
    var mar4 = Math.round(((value.preciocuatro*100)/(value.preciocinco-0.01))-100);

    //PRECIOS CAJA*
    var pre1 = Math.ceil( ((value.costo * (mar1/100))+parseFloat(value.costo))*10 )/10;
    var pre2 = Math.ceil( ((value.costo * (mar2/100))+parseFloat(value.costo))*10 )/10;
    var pre3 = Math.ceil( ((value.costo * (mar3/100))+parseFloat(value.costo))*10 )/10;
    var pre4 = Math.ceil( ((value.costo * (mar4/100))+parseFloat(value.costo))*10 )/10;
    console.log(value)
    console.log(value.costo)
    console.log(mar1)
    console.log((value.costo * (mar1/100)))
    console.log(((value.costo * (mar1/100))+parseFloat(value.costo)))
    //MARGENES PIEZA
    //MARGENES
    var mar11 = Math.round(((val.preciouno*100)/(val.preciocinco-0.01))-100);
    var mar22 = Math.round(((val.preciodos*100)/(val.preciocinco-0.01))-100);
    var mar33 = Math.round(((val.preciotres*100)/(val.preciocinco-0.01))-100);
    var mar44 = Math.round(((val.preciocuatro*100)/(val.preciocinco-0.01))-100);

    //POR PIEZA
    var costopz = value.costo / val.cantidad;
    var pre11 = Math.ceil( ((costopz * (mar11/100))+parseFloat(costopz))*10 )/10;
    var pre22 = Math.ceil( ((costopz * (mar22/100))+parseFloat(costopz))*10 )/10;
    var pre33 = Math.ceil( ((costopz * (mar33/100))+parseFloat(costopz))*10 )/10;
    var pre44 = Math.ceil( ((costopz * (mar44/100))+parseFloat(costopz))*10 )/10;

    var difp1=pre1-value.costo;var difp2=pre2-value.costo;var difp3=pre3-value.costo;var difp4=pre4-value.costo;
    var difp11=pre11-costopz;var difp22=pre22-costopz;var difp33=pre33-costopz;var difp44=pre44-costopz;

    var arreid_rojo = { "id_rojo":value.id_rojo,"codigo1":val.codigo,"codigo2":cods2,"lin":value.ides,"desc1":value.descripcion,"um":value.uni,"code3":value.code1,"desc2":val.descripcion, 
        "cantidad":val.cantidad,"costo":value.costo,"iva":value.iva,"mar1":mar1,"mar11":mar11, "mar2":mar2,"mar22":mar22, "mar3":mar3,"mar33":mar33,"pre5":pre5, 
        "mar4":mar4,"mar44":mar44, "pre1":pre1,"pre11":pre11,"pre2":pre2,"pre22":pre22, "pre3":pre3,"pre33":pre33, "pre4":pre4,"pre44":pre44,"mostrar":0,"matriz":value.preciocinco,"costopz":costopz,"estatus":1 }
    rojosArray[value.id_rojo] = arreid_rojo;
    
    $("#bodySucA").append('<tr class="rojoTr rojoTr'+value.id_rojo+'" data-id-rojo="'+value.id_rojo+'" data-id-caja="'+val.id_caja+'">'+
        '<td><button type="button" class="btn btn-outline-warning rojoBtn" data-id-rojo="'+value.id_rojo+'" data-id-caja="'+val.id_caja+'">Mostrar</button></td><td>'+value.usu+'</td>'+
        '<td>'+value.code1+'</td>'+
        '<td>'+value.code2+'</td><td>'+value.ides+'</td><td>'+value.descripcion+'</td><td>'+value.uni+'</td>'+
        '<td><input type="text" class="form-control cantRojo" placeholder="'+formatMoney(val.cantidad,0)+'" value="'+formatMoney(val.cantidad,0)+'"/></td>'+
        '<td><input type="text" class="form-control costoRojo" placeholder="'+formatMoney(value.costo)+'" value="'+formatMoney(value.costo)+'"/></td>'+
        '<td class="cincoRojo" data-id-costo="'+value.preciocinco+'">$ '+formatMoney(value.preciocinco)+'</td><td class="difes">$ '+formatMoney(dif1)+'</td>'+
        '<td class="ivaClass"><input type="text" class="form-control inputransparent ivaRojo" placeholder="'+formatMoney(value.iva,0)+'" value="'+formatMoney(value.iva,0)+'"/></td>'+
        '<td class="renglon10Class">'+formatMoney(renglon10,5)+'</td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre11Rojo" placeholder="'+formatMoney(pre11)+'" value="'+formatMoney(pre11)+'"/>'+
        '<span class="difPrecios difP11">'+formatMoney(difp11)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre22Rojo" placeholder="'+formatMoney(pre22)+'" value="'+formatMoney(pre22)+'"/>'+
        '<span class="difPrecios difP22">'+formatMoney(difp22)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre33Rojo" placeholder="'+formatMoney(pre33)+'" value="'+formatMoney(pre33)+'"/>'+
        '<span class="difPrecios difP33">'+formatMoney(difp33)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre44Rojo" placeholder="'+formatMoney(pre44)+'" value="'+formatMoney(pre44)+'"/>'+
        '<span class="difPrecios difP44">'+formatMoney(difp44)+'</span></td>'+
        '<td class="pre5">'+formatMoney(pre5)+'</td>'+
        '<td class="margen1Class"><input type="text" class="form-control inputransparent mar11Rojo" placeholder="'+mar11+'" value="'+mar11+'"/></td>'+
        '<td class="margen1Class"><input type="text" class="form-control inputransparent mar22Rojo" placeholder="'+mar22+'" value="'+mar22+'"/></td>'+
        '<td class="margen1Class"><input type="text" class="form-control inputransparent mar33Rojo" placeholder="'+mar33+'" value="'+mar33+'"/></td>'+
        '<td class="margen1Class"><input type="text" class="form-control inputransparent mar44Rojo" placeholder="'+mar44+'" value="'+mar44+'"/></td>'+
        '<td>'+val.codigo+'</td><td>'+value.ides+'</td><td>'+val.descripcion+'</td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre1Rojo" placeholder="'+formatMoney(pre1)+'" value="'+formatMoney(pre1)+'"/>'+
        '<span class="difPrecios difP1">'+formatMoney(difp1)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre2Rojo" placeholder="'+formatMoney(pre2)+'" value="'+formatMoney(pre2)+'"/>'+
        '<span class="difPrecios difP2">'+formatMoney(difp2)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre3Rojo" placeholder="'+formatMoney(pre3)+'" value="'+formatMoney(pre3)+'"/>'+
        '<span class="difPrecios difP3">'+formatMoney(difp3)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre4Rojo" placeholder="'+formatMoney(pre4)+'" value="'+formatMoney(pre4)+'"/>'+
        '<span class="difPrecios difP4">'+formatMoney(difp4)+'</span></td>'+
        '</td><td class="pre55">'+formatMoney(pre55)+'</td>'+
        '<td class="margen2Class"><input type="text" class="form-control inputransparent mar1Rojo" placeholder="'+mar1+'" value="'+mar1+'"/></td>'+
        '<td class="margen2Class"><input type="text" class="form-control inputransparent mar2Rojo" placeholder="'+mar2+'" value="'+mar2+'"/></td>'+
        '<td class="margen2Class"><input type="text" class="form-control inputransparent mar3Rojo" placeholder="'+mar3+'" value="'+mar3+'"/></td>'+
        '<td class="margen2Class"><input type="text" class="form-control inputransparent mar4Rojo" placeholder="'+mar4+'" value="'+mar4+'"/></td>'+
        '</tr>')
}

function initializeTableB(value,val = []){
    var dif1 = value.costo - value.preciocinco;
    if (jQuery.isEmptyObject(val)){
        val.cantidad = 1;
        val.codigo = "";
        val.descripcion = "";
        val.id_caja = 0;
        val.preciouno = value.preciouno;
        val.preciodos = value.preciodos;
        val.preciotres = value.preciotres;
        val.preciocuatro = value.preciocuatro;
        val.preciocinco = value.preciocinco;
    }else{
        val.cantidad = val.cantidad == 0 ? 1 : val.cantidad == "" ? 1 : val.cantidad == null ? 1 : val.cantidad;
    }
    var renglon10 = ( value.costo/val.cantidad ) / ( 1+(value.iva/100) );
    var pre5 = value.costo/val.cantidad + 0.01;
    var pre55 = parseFloat(value.costo) + 0.01;

    //MARGENES
    var mar1 = Math.round(((value.preciouno*100)/(value.preciocinco-0.01))-100);
    var mar2 = Math.round(((value.preciodos*100)/(value.preciocinco-0.01))-100);
    var mar3 = Math.round(((value.preciotres*100)/(value.preciocinco-0.01))-100);
    var mar4 = Math.round(((value.preciocuatro*100)/(value.preciocinco-0.01))-100);

    //PRECIOS CAJA*
    var pre1 = Math.ceil( ((value.costo * (mar1/100))+parseFloat(value.costo))*10 )/10;
    var pre2 = Math.ceil( ((value.costo * (mar2/100))+parseFloat(value.costo))*10 )/10;
    var pre3 = Math.ceil( ((value.costo * (mar3/100))+parseFloat(value.costo))*10 )/10;
    var pre4 = Math.ceil( ((value.costo * (mar4/100))+parseFloat(value.costo))*10 )/10;

    //MARGENES PIEZA
    //MARGENES
    var mar11 = Math.round(((val.preciouno*100)/(val.preciocinco-0.01))-100);
    var mar22 = Math.round(((val.preciodos*100)/(val.preciocinco-0.01))-100);
    var mar33 = Math.round(((val.preciotres*100)/(val.preciocinco-0.01))-100);
    var mar44 = Math.round(((val.preciocuatro*100)/(val.preciocinco-0.01))-100);

    //POR PIEZA
    var costopz = value.costo / val.cantidad;
    var pre11 = Math.ceil( ((costopz * (mar11/100))+parseFloat(costopz))*10 )/10;
    var pre22 = Math.ceil( ((costopz * (mar22/100))+parseFloat(costopz))*10 )/10;
    var pre33 = Math.ceil( ((costopz * (mar33/100))+parseFloat(costopz))*10 )/10;
    var pre44 = Math.ceil( ((costopz * (mar44/100))+parseFloat(costopz))*10 )/10;

    var difp1=pre1-value.costo;var difp2=pre2-value.costo;var difp3=pre3-value.costo;var difp4=pre4-value.costo;
    var difp11=pre11-costopz;var difp22=pre22-costopz;var difp33=pre33-costopz;var difp44=pre44-costopz;

    var arreid_rojo = { "id_rojo":value.id_rojo,"codigo1":value.code1,"codigo2":value.code2,"lin":value.ides,"desc1":value.descripcion,"um":value.uni,"code3":val.codigo,"desc2":val.descripcion, 
        "cantidad":val.cantidad,"costo":value.costo,"iva":value.iva,"mar1":mar1,"mar11":mar11, "mar2":mar2,"mar22":mar22, "mar3":mar3,"mar33":mar33,"pre5":pre5, 
        "mar4":mar4,"mar44":mar44, "pre1":pre1,"pre11":pre11,"pre2":pre2,"pre22":pre22, "pre3":pre3,"pre33":pre33, "pre4":pre4,"pre44":pre44,"mostrar":0,"matriz":value.preciocinco,"costopz":costopz,"estatus":1 }
    rojosArray[value.id_rojo] = arreid_rojo;
    
    $("#bodySucA").append('<tr class="rojoTr rojoTr'+value.id_rojo+'" data-id-rojo="'+value.id_rojo+'" data-id-caja="'+val.id_caja+'">'+
        '<td><button type="button" class="btn btn-outline-warning rojoBtn" data-id-rojo="'+value.id_rojo+'" data-id-caja="'+val.id_caja+'">Mostrar</button></td><td>'+value.code1+'</td>'+
        '<td>'+value.code2+'</td><td>'+value.ides+'</td><td>'+value.descripcion+'</td><td>'+value.uni+'</td>'+
        '<td><input type="text" class="form-control cantRojo" placeholder="'+formatMoney(val.cantidad,0)+'" value="'+formatMoney(val.cantidad,0)+'"/></td>'+
        '<td><input type="text" class="form-control costoRojo" placeholder="'+formatMoney(value.costo)+'" value="'+formatMoney(value.costo)+'"/></td>'+
        '<td class="cincoRojo" data-id-costo="'+value.preciocinco+'">$ '+formatMoney(value.preciocinco)+'</td><td class="difes">$ '+formatMoney(dif1)+'</td>'+
        '<td class="ivaClass"><input type="text" class="form-control inputransparent ivaRojo" placeholder="'+formatMoney(value.iva,0)+'" value="'+formatMoney(value.iva,0)+'"/></td>'+
        '<td class="renglon10Class">'+formatMoney(renglon10,5)+'</td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre1Rojo" placeholder="'+formatMoney(pre1)+'" value="'+formatMoney(pre1)+'"/>'+
        '<span class="difPrecios difP1">'+formatMoney(difp1)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre2Rojo" placeholder="'+formatMoney(pre2)+'" value="'+formatMoney(pre2)+'"/>'+
        '<span class="difPrecios difP2">'+formatMoney(difp2)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre3Rojo" placeholder="'+formatMoney(pre3)+'" value="'+formatMoney(pre3)+'"/>'+
        '<span class="difPrecios difP3">'+formatMoney(difp3)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre4Rojo" placeholder="'+formatMoney(pre4)+'" value="'+formatMoney(pre4)+'"/>'+
        '<span class="difPrecios difP4">'+formatMoney(difp4)+'</span></td>'+
        '<td class="pre5">'+formatMoney(pre5)+'</td>'+
        '<td class="margen1Class"><input type="text" class="form-control inputransparent mar1Rojo" placeholder="'+mar1+'" value="'+mar1+'"/></td>'+
        '<td class="margen1Class"><input type="text" class="form-control inputransparent mar2Rojo" placeholder="'+mar2+'" value="'+mar2+'"/></td>'+
        '<td class="margen1Class"><input type="text" class="form-control inputransparent mar3Rojo" placeholder="'+mar3+'" value="'+mar3+'"/></td>'+
        '<td class="margen1Class"><input type="text" class="form-control inputransparent mar4Rojo" placeholder="'+mar4+'" value="'+mar4+'"/></td>'+
        '<td>'+val.codigo+'</td><td>'+value.ides+'</td><td>'+val.descripcion+'</td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre11Rojo" placeholder="'+formatMoney(pre11)+'" value="'+formatMoney(pre11)+'"/>'+
        '<span class="difPrecios difP11">'+formatMoney(difp11)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre22Rojo" placeholder="'+formatMoney(pre22)+'" value="'+formatMoney(pre22)+'"/>'+
        '<span class="difPrecios difP22">'+formatMoney(difp22)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre33Rojo" placeholder="'+formatMoney(pre33)+'" value="'+formatMoney(pre33)+'"/>'+
        '<span class="difPrecios difP33">'+formatMoney(difp33)+'</span></td>'+
        '<td class="preciososRojos"><input type="text" class="form-control pre44Rojo" placeholder="'+formatMoney(pre44)+'" value="'+formatMoney(pre44)+'"/>'+
        '<span class="difPrecios difP44">'+formatMoney(difp44)+'</span></td>'+
        '</td><td class="pre55">'+formatMoney(pre55)+'</td>'+
        '<td class="margen2Class"><input type="text" class="form-control inputransparent mar11Rojo" placeholder="'+mar11+'" value="'+mar11+'"/></td>'+
        '<td class="margen2Class"><input type="text" class="form-control inputransparent mar22Rojo" placeholder="'+mar22+'" value="'+mar22+'"/></td>'+
        '<td class="margen2Class"><input type="text" class="form-control inputransparent mar33Rojo" placeholder="'+mar33+'" value="'+mar33+'"/></td>'+
        '<td class="margen2Class"><input type="text" class="form-control inputransparent mar44Rojo" placeholder="'+mar44+'" value="'+mar44+'"/></td>'+
        '</tr>')
}

//SI CAMBIA EL PRECIO MANUALMENTE NO SE MODIFICAN LOS MARGENES NI LOS DEMAS PRECIOS
$(document).off("change keyup",".pre1Rojo").on("change keyup",".pre1Rojo",function(event){
    event.preventDefault();
    cambioPrecios($(this),"pre1")    
})
$(document).off("change keyup",".pre11Rojo").on("change keyup",".pre11Rojo",function(event){
    event.preventDefault();
    cambioPrecios($(this),"pre11")
})
$(document).off("change keyup",".pre2Rojo").on("change keyup",".pre2Rojo",function(event){
    event.preventDefault();
    cambioPrecios($(this),"pre2")
})
$(document).off("change keyup",".pre22Rojo").on("change keyup",".pre22Rojo",function(event){
    event.preventDefault();
    cambioPrecios($(this),"pre22")
})
$(document).off("change keyup",".pre3Rojo").on("change keyup",".pre3Rojo",function(event){
    event.preventDefault();
    cambioPrecios($(this),"pre3")
})
$(document).off("change keyup",".pre33Rojo").on("change keyup",".pre33Rojo",function(event){
    event.preventDefault();
    cambioPrecios($(this),"pre33")
})
$(document).off("change keyup",".pre4Rojo").on("change keyup",".pre4Rojo",function(event){
    event.preventDefault();
    cambioPrecios($(this),"pre4")
})
$(document).off("change keyup",".pre44Rojo").on("change keyup",".pre44Rojo",function(event){
    event.preventDefault();
    cambioPrecios($(this),"pre44")
})
function cambioPrecios(precio,cual){
    var idrojo = precio.closest(".rojoTr").data("idRojo");
    precio.attr("value",formatMoney(precio.val()));
    rojosArray[idrojo][cual] = precio.val().replace(/,/g , '');
    comparaPrecios(idrojo)
    comparaPreciosPz(idrojo)
}

//SE CAMBIAN LOS MARGENES
function changeMargin(mare,cual1,cual2,cual3){
    var idrojo = mare.closest(".rojoTr").data("idRojo");
    var mar1 = mare.val().replace(/,/g , '');
    mare.attr("value",mar1);
    rojosArray[idrojo][cual1] = mar1;
    var pre1 = Math.ceil( ((rojosArray[idrojo].costo * (mar1/100))+parseFloat(rojosArray[idrojo].costo))*10 )/10;
    rojosArray[idrojo][cual2] = pre1;
    mare.closest(".rojoTr").find("."+cual3).val(formatMoney(pre1));
    mare.closest(".rojoTr").find("."+cual3).attr("value",formatMoney(pre1));
    comparaPrecios(idrojo)
}

function changeMarginPz(mare,cual1,cual2,cual3){
    var idrojo = mare.closest(".rojoTr").data("idRojo");
    var mar1 = mare.val().replace(/,/g , '');
    mare.attr("value",mar1);
    rojosArray[idrojo][cual1] = mar1;
    var pre1 = Math.ceil( ((rojosArray[idrojo].costopz * (mar1/100))+parseFloat(rojosArray[idrojo].costopz))*10 )/10;
    rojosArray[idrojo][cual2] = pre1;
    mare.closest(".rojoTr").find("."+cual3).val(formatMoney(pre1));
    mare.closest(".rojoTr").find("."+cual3).attr("value",formatMoney(pre1));
    comparaPreciosPz(idrojo)
}

$(document).off("change keyup",".mar1Rojo").on("change keyup",".mar1Rojo",function(event){
    event.preventDefault();
    changeMargin($(this),"mar1","pre1","pre1Rojo")
})
$(document).off("change keyup",".mar2Rojo").on("change keyup",".mar2Rojo",function(event){
    event.preventDefault();
    changeMargin($(this),"mar2","pre2","pre2Rojo")
})
$(document).off("change keyup",".mar3Rojo").on("change keyup",".mar3Rojo",function(event){
    event.preventDefault();
    changeMargin($(this),"mar3","pre3","pre3Rojo")
})
$(document).off("change keyup",".mar4Rojo").on("change keyup",".mar4Rojo",function(event){
    event.preventDefault();
    changeMargin($(this),"mar4","pre4","pre4Rojo")
})
//SE CAMBIAN LOS MARGENES DE LAS PIEZAS
$(document).off("change keyup",".mar11Rojo").on("change keyup",".mar11Rojo",function(event){
    event.preventDefault();
    changeMarginPz($(this),"mar11","pre11","pre11Rojo")
})
$(document).off("change keyup",".mar22Rojo").on("change keyup",".mar22Rojo",function(event){
    event.preventDefault();
    changeMarginPz($(this),"mar22","pre22","pre22Rojo")
})
$(document).off("change keyup",".mar33Rojo").on("change keyup",".mar33Rojo",function(event){
    event.preventDefault();
    changeMarginPz($(this),"mar33","pre33","pre33Rojo")
})
$(document).off("change keyup",".mar44Rojo").on("change keyup",".mar44Rojo",function(event){
    event.preventDefault();
    changeMarginPz($(this),"mar44","pre44","pre44Rojo")
})

//SE CAMBIA EL IVA
$(document).off("change keyup",".ivaRojo").on("change keyup",".ivaRojo",function(event){
    event.preventDefault();
    changeIva($(this));
})
function changeIva(ivaClass){
    ivaClass.attr("value",ivaClass.val().replace(/,/g , ''));
    var iva = ivaClass.val().replace(/,/g , '');
    var idrojo = ivaClass.closest(".rojoTr").data("idRojo");
    var renglon10 = (  rojosArray[idrojo].costo / rojosArray[idrojo].cantidad ) / ( 1+(iva/100) );
    ivaClass.closest(".rojoTr").find(".renglon10Class").html(formatMoney(renglon10,5));
    rojosArray[idrojo].iva = iva;
}


//CAMBIO PRECIO PAQUETE
$(document).off("change keyup",".costoRojo").on("change keyup",".costoRojo",function(event){
    event.preventDefault();
    changeCosto($(this));
})
function changeCosto(costoRojo){
    var costo = costoRojo.val().replace(/,/g , '');
    costoRojo.attr("value",costo)
    var idrojo = costoRojo.closest(".rojoTr").data("idRojo");

    var pre5 = costo/rojosArray[idrojo].cantidad + 0.01;
    var pre55 = parseFloat(costo) + 0.01;


    var difes = costo - rojosArray[idrojo].matriz;
    $(".rojoTr"+idrojo).find(".difes").html( "$ "+ formatMoney( difes ) )

    $(".rojoTr"+idrojo).find(".pre5").html( formatMoney( pre5 ) )
    $(".rojoTr"+idrojo).find(".pre55").html( formatMoney( pre55 ) )
    
    rojosArray[idrojo].costo = costo;
    rojosArray[idrojo].costopz = costo / rojosArray[idrojo].cantidad;
    changeMarginPrice(idrojo);
    changeIva($(".rojoTr"+idrojo).find(".ivaRojo"));
}
$(document).off("change keyup",".cantRojo").on("change keyup",".cantRojo",function(event){
    event.preventDefault();
    var idrojo = $(this).closest(".rojoTr").data("idRojo");
    rojosArray[idrojo].cantidad = $(this).val().replace(/,/g , '');
    $(this).attr("value",$(this).val().replace(/,/g , ''))
    changeCosto($(".rojoTr"+idrojo).find(".costoRojo"));
})

function changeMarginPrice(idrojo){
    for (var i = 1; i <= 4; i++) {
        changeMargin2($(".rojoTr"+idrojo).find(".mar"+i+"Rojo"),"mar"+i,"pre"+i,"pre"+i+"Rojo");
        changeMarginPz2($(".rojoTr"+idrojo).find(".mar"+i+""+i+"Rojo"),"mar"+i+""+i,"pre"+i+""+i,"pre"+i+""+i+"Rojo");
    }
    comparaPrecios(idrojo)
    comparaPreciosPz(idrojo)
}

//SE CAMBIAN LOS MARGENES
function changeMargin2(mare,cual1,cual2,cual3){
    var idrojo = mare.closest(".rojoTr").data("idRojo");
    var mar1 = mare.val().replace(/,/g , '');
    mare.attr("value",mar1);
    rojosArray[idrojo][cual1] = mar1;
    var pre1 = Math.ceil( ((rojosArray[idrojo].costo * (mar1/100))+parseFloat(rojosArray[idrojo].costo))*10 )/10;
    rojosArray[idrojo][cual2] = pre1;
    mare.closest(".rojoTr").find("."+cual3).val(formatMoney(pre1));
    mare.closest(".rojoTr").find("."+cual3).attr("value",formatMoney(pre1));
}

function changeMarginPz2(mare,cual1,cual2,cual3){
    var idrojo = mare.closest(".rojoTr").data("idRojo");
    var mar1 = mare.val().replace(/,/g , '');
    mare.attr("value",mar1);
    rojosArray[idrojo][cual1] = mar1;
    var pre1 = Math.ceil( ((rojosArray[idrojo].costopz * (mar1/100))+parseFloat(rojosArray[idrojo].costopz))*10 )/10;
    rojosArray[idrojo][cual2] = pre1;
    mare.closest(".rojoTr").find("."+cual3).val(formatMoney(pre1));
    mare.closest(".rojoTr").find("."+cual3).attr("value",formatMoney(pre1));
}

function comparaPrecios(idrojo){
    for(var i=1;i<=4;i++){
        if(rojosArray[idrojo]["pre"+i] < rojosArray[idrojo]["pre"+(i+1)]){
            $(".rojoTr"+idrojo).find(".pre"+i+"Rojo").css({"color":"red","border-color":"red"});
        }else{
            $(".rojoTr"+idrojo).find(".pre"+i+"Rojo").css({"color":"black","border-color":"#E4E6EF"})
        }
        $(".rojoTr"+idrojo).find(".difP"+i).html( formatMoney(rojosArray[idrojo]["pre"+i] - rojosArray[idrojo].costo) )
    }
    if (rojosArray[idrojo]["pre4"] < rojosArray[idrojo]["costo"]){
        $(".rojoTr"+idrojo).find(".pre4Rojo").css({"color":"red","border-color":"red"});
    }else{
        $(".rojoTr"+idrojo).find(".pre4Rojo").css({"color":"black","border-color":"#E4E6EF"})
    }
    $(".rojoTr"+idrojo).find(".difP4").html( formatMoney(rojosArray[idrojo]["pre4"] - rojosArray[idrojo].costo) )
}


function comparaPreciosPz(idrojo){
    for(var i=1;i<=4;i++){
        if(rojosArray[idrojo]["pre"+i+""+i] < rojosArray[idrojo]["pre"+(i+1)+""+(i+1)]){
            $(".rojoTr"+idrojo).find(".pre"+i+""+i+"Rojo").css({"color":"red","border-color":"red"});
        }else{
            $(".rojoTr"+idrojo).find(".pre"+i+""+i+"Rojo").css({"color":"black","border-color":"#E4E6EF"})
        }
        $(".rojoTr"+idrojo).find(".difP"+i+""+i).html( formatMoney(rojosArray[idrojo]["pre"+i+""+i] - rojosArray[idrojo].costopz) )
    }
    if (rojosArray[idrojo]["pre44"] < rojosArray[idrojo]["costopz"]){
        $(".rojoTr"+idrojo).find(".pre44Rojo").css({"color":"red","border-color":"red"});
    }else{
        $(".rojoTr"+idrojo).find(".pre44Rojo").css({"color":"black","border-color":"#E4E6EF"})
    }
    $(".rojoTr"+idrojo).find(".difP4").html( formatMoney(rojosArray[idrojo]["pre4"] - rojosArray[idrojo].costopz) )
}

$(document).off("click",".rojoBtn").on("click",".rojoBtn",function(event){
    event.preventDefault();
    var idrojo = $(this).data("idRojo");
    var dis = $(this)
    $(".rojoTr"+idrojo).toggleClass("blockTh");
    dis.toggleClass("btn-outline-warning")
    dis.toggleClass("btn-primary")
    console.log(idrojo)
    console.log(rojosArray)
    console.log(rojosArray[idrojo])
    console.log(rojosArray[idrojo]["mostrar"])
    if(dis.html() == "Mostrar"){
        dis.html("No Mostrar");
        rojosArray[idrojo]["mostrar"] = 1;
    }else{
        dis.html("Mostrar");
        rojosArray[idrojo]["mostrar"] = 0;
    }
})

$(document).off("click",".btn-show-rojos").on("click",".btn-show-rojos",function(event){
    event.preventDefault();
    var dis = $(this);
    
    $.each(rojosArray,function(index,value){
        
        if(value){
            if(value.mostrar == 1){
                almacena[value.id_rojo] = value;
                $(".rojoTr"+value.id_rojo).remove();
                rojosArray[value.id_rojo] = "";
            }
        }
    })
    
    if(almacena.length != 0){
        saveRojos(JSON.stringify(almacena)).done(function(resp){
            $(".btn-show-rojos").html( setZeros2( parseInt(resp)+1 ) );
            addTable(resp)
            getMeNews();
        });
    }else{
        toastr.warning("Por favor marque productos para mostrar","Sin productos");
    }
    
})

function saveRojos(values,folio){
    return $.ajax({
        url: site_url+"Uploads/saveRojos",
        type: "POST",
        dataType: "JSON",
        data:{
            value : values
        }
    });
}

function getMaxNew(){
    return $.ajax({
        url: site_url+"Uploads/getMaxNew",
        type: "GET",
        dataType: "JSON",
    });
}

function addTable(nuevo){
    var new_table = '<div class=row><table class="table table-bordered" style="text-align:center;"><thead><tr><th class="gensuca" colspan="4" style="padding:0">'+setZeros2(nuevo)+'</th><th colspan="8">'+
        formatDate2(getDate())+'</th><th colspan="18" style="background:rgb(255,51,51)">AJUSTES</th></tr><tr><th style="width:100px" >CÓDIGO</th><th style="width:100px" >RENGLON 18</th><th style="width:70px" >LIN</th>'+
        '<th style="width:350px" >DESCRIPCIÓN</th><th style="width:70px" >UM</th><th style="width:100px" >C</th><th style="width:150px" >PAQUETE</th>'+
        '<th style="width:100px" class="ivaClass">IVA</th><th style="width:100px" class="renglon10Class">RENGLON 10</th><th colspan="5">PRECIOS DEL 1 AL 5</th>'+
        '<th style="width:100px" colspan="4" class="margen1Class">MARGENES</th><th style="width:100px" >CÓDIGO</th><th style="width:350px" >DESCRIPCIÓN</th>'+
        '<th style="" colspan="5">PRECIOS DEL 1 AL 5</th><th style="width:100px" colspan="4" class="margen2Class">MARGENES</th></tr></thead><tbody>';
    $.each(almacena,function(index,value){
        if (value){
            var renglon10 = ( value.costo/value.cantidad ) / ( 1+(value.iva/100) );
            new_table += '<tr><td>'+value.codigo1+'</td><td>'+value.codigo2+'</td><td>'+value.lin+'</td><td>'+value.desc1+'</td><td>'+value.um+'</td><td>'+value.cantidad+'</td><td>'+value.costo+'</td>'+
                '<td class="ivaClass">'+formatMoney(value.iva,0)+'</td><td class="renglon10Class">'+formatMoney(renglon10)+'</td><td>'+formatMoney(value.pre1)+'</td><td>'+formatMoney(value.pre2)+
                '</td><td>'+formatMoney(value.pre3)+'</td><td>'+formatMoney(value.pre4)+'</td><td>'+formatMoney(parseFloat(value.costo)+0.01)+'</td>'+
                '<td class="margen1Class">'+value.mar1+'</td><td class="margen1Class">'+value.mar2+'</td><td class="margen1Class">'+value.mar3+'</td><td class="margen1Class">'+value.mar4+'</td>'+
                '<td>'+value.code3+'</td><td>'+value.desc2+'</td>'+
                '<td>'+formatMoney(value.pre11)+'</td><td>'+formatMoney(value.pre22)+'</td><td>'+formatMoney(value.pre33)+'</td><td>'+formatMoney(value.pre44)+'</td><td>'+formatMoney(value.costopz)+'</td>'+
                '<td class="margen2Class">'+value.mar11+'</td><td class="margen2Class">'+value.mar22+'</td><td class="margen2Class">'+value.mar33+'</td><td class="margen2Class">'+value.mar44+'</td></tr>'
        }
    })
    
    new_table += '</tbody></table></div>';
    $(".otrosShows").prepend(new_table);
    almacena = [];
}

function getDate(){
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = mm + '/' + dd + '/' + yyyy;
    return today;
}

function getNuevos() {
    return $.ajax({
        url: site_url+"Uploads/getNuevos",
        type: "POST",
        cache: false,
    });
}

function getMeNews(){
    $(".otrosShowsB").html("");
    getNuevos().done(function(resp){
        $(".otrosShowsB").html("");
        if(resp){
            $.each(resp,function(index,value){
                oldResultsB(value);
            })
        }
    })
}


function oldResultsB(value){
    var oldsB = '<div class="row" style="overflow-x:scroll;padding-bottom: 50px;"><table class="table table-bordered" style="text-align:center;"><thead><tr><th class="gensuca" colspan="4" style="padding:0">'+
                                setZeros2(value.id_nuevo)+'</th><th colspan="8">'+formatDate2(value.fecha_registro)+'</th><th colspan="18" style="background:rgb(255,51,51)">AJUSTES</th></tr><tr>'+
                                '<th style="width:100px" >CÓDIGO</th><th style="width:100px" >RENGLON 18</th><th style="width:70px" >LIN</th><th style="width:350px" >DESCRIPCIÓN</th><th style="width:70px" >UM</th>'+
                                '<th style="width:100px" >C</th><th style="width:150px" >PAQUETE</th><th style="width:100px" class="ivaClass">IVA</th><th style="width:100px" class="renglon10Class">RENGLON 10</th>'+
                                '<th colspan="3" style="background:#bdd7ee">PRECIOS DEL 1 AL 3</th><th style="width:100px" colspan="3" class="margen1Class">MARGENES</th><th style="width:100px" >CÓDIGO</th><th style="width:350px" >DESCRIPCIÓN</th>'+
                                '<th style="width:100px" >COSTO<br>PZA</th><th style="background:#bdd7ee" colspan="3">PRECIOS DEL 1 AL 3</th><th style="width:100px" colspan="3" class="margen2Class">MARGENES</th></tr></thead><tbody>';

    $.each(value.detalles,function(inx,val){
        var renglon10 = ( val.pre4/val.cantidad ) / ( 1+(val.iva/100) );
        var pre5 = val.pre4/val.cantidad + 0.01;
        var pre55 = parseFloat(val.pre4) + 0.01;

        //PRECIOS CAJA*
        var pre1 = Math.ceil( ((val.pre4 * (val.mar1/100))+parseFloat(val.pre4))*10 )/10;
        var pre2 = Math.ceil( ((val.pre4 * (val.mar2/100))+parseFloat(val.pre4))*10 )/10;
        var pre3 = Math.ceil( ((val.pre4 * (val.mar3/100))+parseFloat(val.pre4))*10 )/10;

        //POR PIEZA
        var costopz = val.pre4 / val.cantidad;
        var pre11 = Math.ceil( ((costopz * (val.mar11/100))+parseFloat(costopz))*10 )/10;
        var pre22 = Math.ceil( ((costopz * (val.mar22/100))+parseFloat(costopz))*10 )/10;
        var pre33 = Math.ceil( ((costopz * (val.mar33/100))+parseFloat(costopz))*10 )/10;

        oldsB +=    '<tr><td>'+val.code1+'</td><td>'+val.code2+'</td><td>'+val.linea+'</td><td>'+val.desc1+'</td><td>'+val.unidad+'</td><td>'+val.cantidad+'</td><td>'+val.pre4+'</td>'+
                    '<td class="ivaClass">'+val.iva+'</td><td class="renglon10Class">'+formatMoney(renglon10)+'</td><td class="precioB">'+formatMoney(pre1)+'</td><td class="precioB">'+formatMoney(pre2)+
                    '</td><td class="precioB">'+formatMoney(pre3)+'</td><td class="margen1Class">'+val.mar1+'</td><td class="margen1Class">'+val.mar2+'</td>'+
                    '<td class="margen1Class">'+val.mar3+'</td><td>'+val.code3+'</td><td>'+val.desc2+'</td><td>'+formatMoney(costopz)+'</td><td class="precioB">'+formatMoney(pre11)+'</td><td class="precioB">'+
                    formatMoney(pre22)+'</td><td class="precioB">'+pre33+'</td><td class="margen2Class">'+val.mar11+'</td><td class="margen2Class">'+val.mar22+'</td><td class="margen2Class">'+val.mar33+'</td></tr>';
    })

    oldsB += '</tbody></table></div>';
    $(".otrosShowsB").prepend(oldsB)                                                     
}