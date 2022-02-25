jQuery(document).ready(function() {
    $("#titlePrincipal").html("COMPARACIÓN DE CODIGOS Y DESCRIPCIONES");
    comparaciones(8);
});
var cualdis = 8;

function getComparacion(value) {
    return $.ajax({
        url: site_url+"Compara/getCodigosccCedis/"+value,
        type: "POST",
        cache: false,
    });
}

function getComparacion2(value) {
    return $.ajax({
        url: site_url+"Compara/getCodigosccSucus/"+value,
        type: "POST",
        cache: false,
    });
}

function comparaciones(vSucuCed) {
    $(".tableAll1").css("display","block")
    $(".tableAll2").css("display","none")
    getComparacion(vSucuCed).done(function(resp){
        var p11 = 0;var p111 = 0;
        if(resp){
            $.each(resp,function(index,value){
                $(".tbodyCompa").append('<tr class="cienrow"><td>'+(index+1)+'</td><td>'+value.codigo+'</td><td>'+value.nombre+'</td><td>'+value.ums+'</td></tr>')
            })
            $(".countRojo").html(resp.length);
            $(".rowLoad").html('<div><h4 style="font-size:16px"><br>Se encontrarón '+resp.length+' resultados</h4></div>');
        }else{
            $(".rowLoad").html('<div class="col-xl-3"><h1 class="text-danger">NO SE ENCONTRARÓN DATOS, POR FAVOR SELECCIONA OTRA SUCURSAL Y VUELVE A SELECCIONAR ESTA</h1></div><div class="col-xl-6"><img src="assets/img/loading4.gif" class="rowLoadImg"></div>');
        }
    })
}

function comparaciones2(vSucuCed) {
    $(".tableAll2").css("display","block")
    $(".tableAll1").css("display","none")
    getComparacion2(vSucuCed).done(function(resp){
        var p11 = 0;var p111 = 0;
        if(resp){
            $.each(resp,function(index,value){
                var nombo = "";
                for (var i = 0;i <= value.nombre.length - 1; i++) {
                    value.nombre[i] 
                    if(value.nombre2[i]){
                        if(value.nombre2[i] != value.nombre[i]){
                            nombo += "<span style='background:yellow'>"+value.nombre[i]+"</span>";
                        }else{
                            nombo += ""+value.nombre[i];
                        }
                    }else{
                        nombo += ""+value.nombre[i];
                    }
                }
                if(value.nombre.length < value.nombre2.length){
                        nombo += "<span style='background:yellow'>-></span>";
                    }
                $(".tbodyCompa2").append('<tr class="cienrow"><td>'+(index+1)+'</td><td>'+value.codigo+'</td><td>'+nombo+'</td><td>'+value.ums+'</td>'+
                    '<td>'+value.codigo2+'</td><td>'+value.nombre2+'</td><td>'+value.ums2+'</td></tr>')
            })
            $(".countVerde").html(resp.length);
            $(".rowLoad").html('<div><h4 style="font-size:16px"><br>Se encontrarón '+resp.length+' resultados</h4></div>');
        }else{
            $(".rowLoad").html('<div class="col-xl-3"><h1 class="text-danger">NO SE ENCONTRARÓN DATOS, POR FAVOR SELECCIONA OTRA SUCURSAL Y VUELVE A SELECCIONAR ESTA</h1></div><div class="col-xl-6"><img src="assets/img/loading4.gif" class="rowLoadImg"></div>');
        }
    })
}


$(document).off("click",".btnSucuCedis").on("click",".btnSucuCedis",function(e){
    e.preventDefault();
    var dis = $(this).data("idUser");
    var dis2 = $(this).data("idRojo");
    cualdis = dis;
    $(".tbodyCompa").html("")
    $(".countRojo").html("")
    $(".countVerde").html("")
    $("#excelCompa").css("display","none");
    $("#excelCompa").attr("href","Compara/ExcelCompaCedis/"+dis);
    $(".rowLoad").html('<div class="col-xl-3"><h1 class="text-warning">CARGANDO DATOS...</h1></div><div class="col-xl-6"><img src="assets/img/loading3.gif" class="rowLoadImg"></div>');
    $(".thSucus").html(dis2);
    $(".thSucus2").html(" <br>"+dis2);
    $(".btnCualBusco").removeClass("btn-danger")
    $(".btnCualBusco1").addClass("btn-danger")
    comparaciones(dis)

    $(".btnSucuCedis").removeClass("btn-danger")
    $(".btnSucuCedis"+dis).addClass("btn-danger")
})


$(document).off("click",".btnCualBusco").on("click",".btnCualBusco",function(e){
    e.preventDefault();
    $(".btnCualBusco").removeClass("btn-danger")
    $(this).addClass("btn-danger")
    var dis = $(this).data("idRojo");
    $(".tbodyCompa2").html("")
    $(".countRojo").html("")
    $(".countVerde").html("")
    $("#excelCompa").css("display","none");
    $(".rowLoad").html('<div class="col-xl-3"><h1 class="text-warning">CARGANDO DATOS...</h1></div><div class="col-xl-6"><img src="assets/img/loading3.gif" class="rowLoadImg"></div>');
    if(dis == 10){
        comparaciones2(cualdis);
    }else{
        comparaciones(cualdis)
    }
})



