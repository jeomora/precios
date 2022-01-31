'use strict';
jQuery(document).ready(function() {
    $("#titlePrincipal").html("CAMBIOS DE PRECIOS");
    getMeNews();
    getMeOfes();
    getMeORec();
});

   
function getMeNews(){
    $(".otrosShows").html("");
    getNuevosA().done(function(resp){
        $(".otrosShows").html("");
        if(resp){
            $(".rowLoad").html("")
            oldResultsA(resp);
        }else{
            $(".rowLoad").html('<div class="col-xl-7"><h1 class="text-danger">NO SE ENCONTRARÓN DATOS, POR FAVOR ACTUALICE SU PAGINA PARA INTENTARLO NUEVAMENTE</h1></div><div class="col-xl-7"><img src="assets/img/loading4.gif" class="rowLoadImg"></div>');
        }
    })
}
function getNuevosA() {
    return $.ajax({
        url: site_url+"Uploads/getNuevosASucu",
        type: "POST",
        cache: false,
    });
}
function oldResultsA(respo){
    $.each(respo,function(inx,val){
        if(val.tipo == user_sucus || val.tipo == 9){
            if (val.suca != 0){
                var new_table = '<div class=row><table class="table table-bordered" style="text-align:center;"><thead><tr><th class="gensuca" colspan="4" style="padding:0">'+setZeros2(val.id_nuevo)+'</th><th class="showBody" data-id-user="'+val.id_nuevo+'">MOSTRAR LISTA</th>'+
                    '<th><a class="nav-link" target="_blank" href="Codigos/qrmeS/'+val.id_nuevo+'"><img src="assets/img/codigo-qr.png" style="height:45px"></a></th><th>'+
                    '<a class="nav-link" target="_blank" href="Uploads/excelA/'+val.id_nuevo+'"><img src="assets/img/excel.svg" style="height:45px"></a></th><th colspan="7">'+
                    formatDate2(val.fecha_registro)+'</th><th colspan="17" style="background:rgb(255,51,51)">AJUSTES</th></tr><tr><th style="width:100px" >CÓDIGO</th><th style="width:100px" >RENGLON 18</th><th style="width:70px" >LIN</th>'+
                    '<th style="width:350px" >DESCRIPCIÓN</th><th style="width:70px" >UM</th><th style="width:100px" >C</th><th style="width:150px" >PAQUETE</th>'+
                    '<th style="width:100px" class="ivaClass">IVA</th><th style="width:100px" class="renglon10Class">RENGLON 10</th><th colspan="5">PRECIOS DEL 1 AL 5</th>'+
                    '<th style="width:100px" >CÓDIGO</th><th style="width:350px" >DESCRIPCIÓN</th>'+
                    '<th style="" colspan="5">PRECIOS DEL 1 AL 5</th></tr></thead><tbody id="body'+val.id_nuevo+'" style="display:none">';
                $.each(val.detalles,function(index,value){

                    var colos = giveMeColor(value.estatus);
                    var des1 = colos[0];var des2 =colos[1];
                    var blues = "";
                    if(value.blues != 0){
                        blues = "style='background:#00b0f0 !important'";
                    }
                    if (value){
                        var renglon10 = ( value.costo/value.cantidad ) / ( 1+(value.iva/100) );
                        new_table += '<tr><td class="'+des1+'" '+blues+'>'+value.code1+'</td><td class="'+des1+'">'+value.code2+'</td><td class="'+des1+'">'+value.linea+'</td><td class="'+des1+'">'+value.desc1+'</td><td class="'+des1+'">'+value.unidad+'</td><td class="'+des1+'">'+value.cantidad+'</td><td>'+value.costo+'</td>'+
                            '<td class="ivaClass">'+formatMoney(value.iva,0)+'</td><td class="renglon10Class">'+value.rdiez+'</td>'+
                            '<td>'+formatMoney(value.pre11)+'<br><span '+isMayor(value.pre11,value.preciouno)+'>'+formatMoney(value.preciouno)+'</span></td>'+
                            '<td>'+formatMoney(value.pre22)+'<br><span '+isMayor(value.pre22,value.preciodos)+'>'+formatMoney(value.preciodos)+'</span></td>'+
                            '<td>'+formatMoney(value.pre33)+'<br><span '+isMayor(value.pre33,value.preciotres)+'>'+formatMoney(value.preciotres)+'</span></td>'+
                            '<td>'+formatMoney(value.pre44)+'<br><span '+isMayor(value.pre44,value.preciocuatro)+'>'+formatMoney(value.preciocuatro)+'</span></td>'+
                            '<td>'+formatMoney(value.pre55)+'<br><span '+isMayor(value.pre55,value.preciocinco)+'>'+formatMoney(value.preciocinco)+'</span></td>'+
                            '<td class="'+des2+'">'+isnulo(value.code3)+'</td><td class="'+des2+'">'+isnulo(value.desc2)+'</td>'+
                            '<td>'+isnuloF(value.pre1)+'<br><span '+isMayor(value.pre1,value.preciouno2)+'>'+formatMoney(value.preciouno2)+'</span></td>'+
                            '<td>'+isnuloF(value.pre2)+'<br><span '+isMayor(value.pre2,value.preciodos2)+'>'+formatMoney(value.preciodos2)+'</span></td>'+
                            '<td>'+isnuloF(value.pre3)+'<br><span '+isMayor(value.pre3,value.preciotres2)+'>'+formatMoney(value.preciotres2)+'</span></td>'+
                            '<td>'+isnuloF(value.pre4)+'<br><span '+isMayor(value.pre4,value.preciocuatro2)+'>'+formatMoney(value.preciocuatro2)+'</span></td>'+
                            '<td>'+isnuloF(value.pre5)+'<br><span '+isMayor(value.pre5,value.preciocinco2)+'>'+formatMoney(value.preciocinco2)+'</span></td></tr>'
                    }
                })
                
                new_table += '</tbody></table></div>';
                $(".otrosShows").prepend(new_table);
            }
        }
    })
}

$(document).off("click",".showBody").on("click",".showBody",function(event){
    event.preventDefault();
    var dis = $(this).data("idUser");
    //$("#body"+dis).css("display","block !important")
    document.getElementById("body"+dis).style.display = "contents";
})

$(document).off("click",".nuevoBtn").on("click",".nuevoBtn",function(event){
    event.preventDefault();
    var dis = $(this)
    var idrojo = dis.data("idRojo");
    $(".rojoTr"+idrojo).toggleClass("blockTh");
    dis.css("display","none");
    if(dis.html() == "Listo"){
        //dis.html("Regreso");
        setListo(1,idrojo)
    }else{
        dis.html("Listo");
        setListo(0,idrojo)
    }
    dis.css("display","none");
})

function setListo(val1,val2) {
    return $.ajax({
        url: site_url+"Uploads/setListo/"+val1+"/"+val2,
        type: "POST",
        cache: false,
    });
}

function isMayor(uno,dos){
    var color = "style='color:black;font-weight:bold'"
    if(uno > dos){
        color = "style='color:red;font-weight:bold'"
    }else if(uno < dos){
        color = "style='color:#00e900;font-weight:bold'"
    }
    return color;
}

function giveMeColor(estatus){
    var reso = ["",""];
    switch( parseInt(estatus) ){
        case 2:
            reso = ["cambioDe",""]; //2 EDITAR PZ 
            break;
        case 3:
            reso = ["","cambioDe"];//3 EDITAR CAJA 
            break;
        case 4:
            reso = ["cambioDe","cambioDe"];//4 EDITAR PZ Y CAJA 
            break;
        case 5:
            reso = ["cambioDe","eliminDe"];//5 EDITAR PZ Y ELIM CAJA 
            break;
        case 6:
            reso = ["eliminDe","cambioDe"];//6 EDITAR CAJA Y ELIM PZA 
            break;
        case 7:
            reso = ["cambioDe","agregaDe"];//7 EDITAR PZ Y ADD CAJA 
            break;
        case 8:
            reso = ["agregaDe","cambioDe"];//8 EDITAR CAJA Y ADD  PZA 
            break;
        case 9:
            reso = ["agregaDe",""];//9 ADD PZA 
            break;
        case 10:
            reso = ["","agregaDe"]; //10 ADD CJA 
            break;
        case 11:
            reso = ["agregaDe","agregaDe"]; //11 ADD PZA Y ADD CAJA 
            break;
        case 12:
            reso = ["agregaDe","eliminDe"]; //12 ADD PZA Y ELIM CJA 
            break;
        case 13:
            reso = ["eliminDe","agregaDe"]; //13 ADD CJA Y ELIM PZA 
            break;
        case 14:
            reso = ["eliminDe",""]; //14 ELIM PZA 
            break;
        case 15:
            reso = ["","eliminDe"]; //15 ELIM CJA 
            break;
        case 16:
            reso = ["eliminDe","eliminDe"]; //16 ELIM PZA Y ELIM CJA 
            break;
        default:
            return reso;
        break;
    }
    return reso;
}


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
        getMeNews()
    }
});


function getOfertas(){
    return $.ajax({
        url: site_url+"Uploads/getOfertas",
        type: "POST",
        cache: false,
    });
}

function formatDate2Bold(fecha){
    var f = new Date(fecha);
    var d = f.getDate();
    var dd = f.getDay();
    var m =  f.getMonth();
    var y = f.getFullYear();
    var h = f.getHours();
    var minutes = f.getMinutes();
    var mm = ( minutes < 10 ? "0" : "" ) + minutes;
    var seconds = f.getSeconds();
    var s = ( seconds < 10 ? "0" : "" ) + seconds
    var dias = new Array("DOMINGO","LUNES","MARTES","MIÉRCOLES","JUEVES","VIERNES","SÁBADO");
    var meses = new Array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
    return ("<span class='boldSpan'>"+dias[dd]+" "+d+"</span> DE "+meses[m]);
}

function getOferta(dis){
    return $.ajax({
        url: site_url+"Uploads/getOferta/"+dis,
        type: "POST",
        cache: false,
    });
}

function getORecientes(){
    return $.ajax({
        url: site_url+"Uploads/getORecientes",
        type: "POST",
        cache: false,
    });
}

function getMeOfes(){
    $(".bodyOfes").html("");
    getOfertas().done(function(reso){
        var ofert = 0;var flag = 0;var echoes = "";var tipso = 0;
        if(reso){
            $.each(reso,function(index,val){
                console.log(val.tipo)
                console.log(user_sucus)
                if(val.tipo == user_sucus || val.tipo == 9){
                    if(ofert != val.conjunto){
                        if(flag != 0){
                            flag=0;
                            echoes += '</div><a class="btn btn-block btn-sm btn-light-success font-weight-bolder text-uppercase py-4 modalOferta" data-toggle="modal" data-target="#kt_modal_oferta" data-id-user="'+ofert+'">Ver lista completa</a>'+
                            '<a href="Codigos/ofertasS/'+ofert+'" target="_blank"  class="btn btn-block btn-sm btn-light-success font-weight-bolder text-uppercase py-4">'+'<img src="assets/img/codigo-qr.png" style="height:45px"></a></div></div></div>';
                        }
                        var corto = val.nombre;
                        if(val.nombre.length >= 35){
                            corto = val.nombre.substring(0,35)+"...";
                        }
                        echoes += '<div class="col-xl-3"><div class="card card-custom gutter-b card-stretch"><div class="card-body pt-4 d-flex flex-column justify-content-between"><div class="d-flex align-items-center mb-7">'+
                                    '<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3"><div class="symbol symbol-lg-75 symbol-success"><span class="symbol-label font-size-h3 font-weight-boldest">'+val.conjunto+'</span>'+
                                    '</div></div><div class="d-flex flex-column"><a class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">OFERTA-'+
                                    val.conjunto+'</a><span class="text-muted font-weight-bold">'+formatDate(val.fecha_registro)+'</span></div></div><p class="mb-7  font-weight-boldest">Fecha Inicio <span class="text-dark pr-1">'+
                                    formatDate(val.fecha_inicio)+'</span><br>Fecha Termino <span class="text-success pr-1">'+formatDate(val.fecha_termino)+'</span></p><div class="mb-7"><div class="d-flex justify-content-between align-items-center">'+
                                    '<span class="text-dark-75 font-weight-bolder mr-2">'+corto+'</span><span class="text-muted font-weight-bold">$ '+formatMoney(val.precio)+'</span></div>';
                        flag++;
                        ofert = val.conjunto;
                    }else{
                        if(flag < 4){
                            flag++;var corto = val.nombre;
                            if(val.nombre.length >= 35){
                                corto = val.nombre.substring(0,35)+"...";
                            }
                            echoes += '<div class="d-flex justify-content-between align-items-center"><span class="text-dark-75 font-weight-bolder mr-2">'+corto+'</span><span class="text-muted font-weight-bold">$ '+
                            formatMoney(val.precio)+'</span></div>'
                        }
                    }
                }
                tipso = val.tipo;
            })
            if(tipso == user_sucus || tipso == 9){
                echoes+='</div> <a class="btn btn-block btn-sm btn-light-success font-weight-bolder text-uppercase py-4 modalOferta" data-toggle="modal" data-target="#kt_modal_oferta" data-id-user="'+ofert+'">Ver lista completa</a>'+
                '<a href="Codigos/ofertasS/'+ofert+'" target="_blank" class="btn btn-block btn-sm btn-light-success font-weight-bolder text-uppercase py-4"><img src="assets/img/codigo-qr.png" style="height:45px"></a></div></div></div>';
            }
            $(".bodyOfes").html(echoes);
        }
    })
}


function getMeORec(){
    $(".bodyORec").html("");
    getORecientes().done(function(reso){
        var ofert = 0;var flag = 0;var echoes = "";
        if(reso){
            $.each(reso,function(index,val){
                if(ofert != val.conjunto){
                    if(flag != 0){
                        flag=0;
                        echoes += '</div><a class="btn btn-block btn-sm btn-light-danger font-weight-bolder text-uppercase py-4 modalOferta" data-toggle="modal" data-target="#kt_modal_oferta" data-id-user="'+ofert+'">Ver productos</a>'+
                        '<a href="Codigos/ofertasRS/'+ofert+'" target="_blank"  class="btn btn-block btn-sm btn-light-primary font-weight-bolder text-uppercase py-4">'+'<img src="assets/img/codigo-qr.png" style="height:45px"></a></div></div></div>';
                    }

                    echoes += '<div class="col-xl-2"><div class="card card-custom gutter-b card-stretch"><div class="card-body pt-4 d-flex flex-column justify-content-between"><div class="d-flex align-items-center mb-7">'+
                                '<div class="flex-shrink-0 mr-4 mt-lg-0 mt-3"><div class="symbol symbol-lg-75 symbol-primary"><span class="symbol-label font-size-h3 font-weight-boldest">'+val.conjunto+'</span>'+
                                '</div></div><div class="d-flex flex-column"><a class="text-warning font-weight-bold text-hover-primary font-size-h4 mb-0">OFERTA-'+
                                val.conjunto+'</a><span class="text-muted font-weight-bold">'+formatDate(val.fecha_registro)+'</span></div></div><p class="mb-7  font-weight-boldest">Fecha Termino <span class="text-primary pr-1">'+
                                formatDate(val.fecha_termino)+'</span></p>';
                    flag++;
                    ofert = val.conjunto;
                }
            })
            echoes+='</div> <a class="btn btn-block btn-sm btn-light-danger font-weight-bolder text-uppercase py-4 modalOferta" data-toggle="modal" data-target="#kt_modal_oferta" data-id-user="'+ofert+'">Ver lista completa</a>'+
            '<a href="Codigos/ofertasRS/'+ofert+'" target="_blank" class="btn btn-block btn-sm btn-light-primary font-weight-bolder text-uppercase py-4"><img src="assets/img/codigo-qr.png" style="height:45px"></a></div></div></div>';
            $(".bodyORec").html(echoes);
        }
    })
}


$(document).off("click",".modalOferta").on("click",".modalOferta",function(event){
    var dis = $(this).data("idUser");
    $(".bodyModalOfes").html("")
    getOferta(dis).done(function(resp){
        if(resp){
            console.log(resp)
            $.each(resp,function(index,val){
                if(index == 0){
                    $(".modalOfeInicia").html(formatDate2Bold(val.fecha_inicio))
                    $(".modalOfeTermina").html(formatDate2Bold(val.fecha_termino))
                }
                var color = "text-dark";var color2 = "text-dark";
                var dif1 = val.precio - val.preciouno;var dif2 = val.precio - val.preciocinco;
                var por1 = dif1 / val.preciouno * 100; var por2 = dif2 / val.preciocinco * 100;
                if(por1 >= 20 || por1 <= -20){
                    color = "text-primary"
                }
                if(por2 >= 20 || por2 <= -20){
                    color2 = "text-primary"
                }
                $(".bodyModalOfes").append('<tr><td>'+val.codigo+'</td><td>'+val.nombre+'</td><td style="font-weight:bold;background:rgba(255,204,255,.60);">$'+formatMoney(val.precio)+'</td><td style="background:rgba(244,176,132,.60);">$ '+
                    formatMoney(val.normal)+'</td><td>'+val.maximo+'</td><td>$'+formatMoney(val.preciouno)+'<br><span class="dmo1 '+color+'">$'+formatMoney(dif1)+' <br> % '+formatMoney(por1)+'</span></td><td>$ '+
                    formatMoney(val.preciocinco)+'<br><span class="dmo1 '+color2+'">$'+formatMoney(dif2)+' <br> % '+formatMoney(por2)+'</span></td></tr>')
            })
        }
    })
})