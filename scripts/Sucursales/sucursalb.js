'use strict';
jQuery(document).ready(function() {
    $("#titlePrincipal").html("CAMBIOS DE PRECIOS");
    getMeNews();
});

function getMeNews(){
    $(".otrosShowsB").html("");
    getNuevosB().done(function(resp){
        $(".otrosShowsB").html("");
        if(resp){
            if(resp){
                oldResultsB(resp);
            }else{
                $(".rowLoad").html('<div class="col-xl-7"><h1 class="text-danger">NO SE ENCONTRARÓN DATOS, POR FAVOR ACTUALICE SU PAGINA PARA INTENTARLO NUEVAMENTE</h1></div><div class="col-xl-7"><img src="assets/img/loading4.gif" class="rowLoadImg"></div>');
            }
        }
    })
}


function oldResultsB(respo){
    $.each(respo,function(indx,value){
        if (value.sucb != 0){
            var oldsB = '<div class="row"><table class="table table-bordered" style="text-align:center;"><thead><tr><th class="gensuca" colspan="4" style="padding:0">'+
                                setZeros2(value.id_nuevo)+'</th><th class="showBodyB" data-id-user="'+value.id_nuevo+'">MOSTRAR LISTA</th>'+
                                '<th><a class="nav-link" target="_blank" href="Codigos/qrmeSB/'+value.id_nuevo+'"><img src="assets/img/codigo-qr.png" style="height:45px"></a></th>'+
                                '<th><a class="nav-link" target="_blank" href="Uploads/excelB/'+value.id_nuevo+'"><img src="assets/img/excel.svg" style="height:45px"></a></th>'+
                                '<th colspan="5">'+formatDate2(value.fecha_registro)+'</th><th colspan="18" style="background:rgb(255,51,51)">AJUSTES</th></tr><tr>'+
                                '<th style="width:100px" >CÓDIGO</th><th style="width:100px" >RENGLON 18</th><th style="width:70px" >LIN</th><th style="width:350px" >DESCRIPCIÓN</th><th style="width:70px" >UM</th>'+
                                '<th style="width:100px" >C</th><th style="width:150px" >COSTO<br>PZA</th><th style="width:100px" class="ivaClass">IVA</th><th style="width:100px" class="renglon10Class">RENGLON 10</th>'+
                                '<th colspan="3" style="background:#bdd7ee">PRECIOS DEL 1 AL 3</th><th style="width:100px" >CÓDIGO</th><th style="width:350px" >DESCRIPCIÓN</th>'+
                                '<th style="width:100px" >PAQUETE</th><th style="background:#bdd7ee" colspan="3">PRECIOS DEL 1 AL 3</th></tr></thead><tbody id="bodyB'+value.id_nuevo+'" style="display:none">';

            $.each(value.detalles,function(inx,val){
                var colos = giveMeColor(val.estato);
                var des1 = colos[0];var des2 =colos[1];
                var blues = "";
                
                console.log(colos)
                console.log(colos[0])
                console.log(colos[1])
                if(val.blues != 0){
                    blues = "style='background:#00b0f0 !important'";
                }
                if(val.estatusb != "0"){
                    var renglon10 = ( val.costo/val.cantidad ) / ( 1+(val.iva/100) );

                    oldsB +=    '<tr><td class="'+des1+'" '+blues+'>'+val.code1+'</td><td class="'+des1+'">'+val.code2+'</td><td>'+val.linea+'</td><td>'+val.desc1+'</td><td>'+val.unidad+'</td><td>'+val.cantidad+'</td><td>'+formatMoney(val.costo)+'</td>'+
                                '<td class="ivaClass">'+val.iva+'</td><td class="renglon10Class">'+val.rdiez+'</td><td class="precioB">'+formatMoney(val.pre11)+'</td><td class="precioB">'+formatMoney(val.pre22)+
                                '</td><td class="precioB">'+formatMoney(val.pre33)+'</td><td class="'+des2+'">'+isnulo(val.code3)+'</td><td class="'+des2+'">'+isnulo(val.desc2)+'</td><td>'+isnuloF(val.costopz)+'</td><td class="precioB">'+isnuloF(val.pre1)+'</td><td class="precioB">'+
                                isnuloF(val.pre2)+'</td><td class="precioB">'+isnuloF(val.pre3)+'</td></tr>';
                }                        
            })

            oldsB += '</tbody></table></div>';
            $(".otrosShowsB").prepend(oldsB)
            $(".rowLoad").html("")
        }
    })
}

function getNuevosB() {
    return $.ajax({
        url: site_url+"Uploads/getNuevosB",
        type: "POST",
        cache: false,
    });
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

$(document).off("click",".showBodyB").on("click",".showBodyB",function(event){
    event.preventDefault();
    var dis = $(this).data("idUser");
    //$("#body"+dis).css("display","block !important")
    document.getElementById("bodyB"+dis).style.display = "contents";
})

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