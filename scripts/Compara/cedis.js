jQuery(document).ready(function() {
    $("#titlePrincipal").html("COMPARACIÓN DE PRECIOS");
    comparaciones(8);
});
var cualdis = 8;

function getComparacion(value) {
    return $.ajax({
        url: site_url+"Compara/getComparacionCedis/"+value,
        type: "POST",
        cache: false,
    });
}

function comparaciones(vSucuCed) {
    
    getComparacion(vSucuCed).done(function(resp){
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
                var lstcst = "";
                if(value.lastcostosuc != value.lastcosto){
                    lstcst = "style='background:#F9BABA'";
                }
                $(".tbodyCompa").append('<tr class="cienrow cien'+flagcien+'" '+clasecien+'><td class="'+cofes+'">'+(index+1)+'</td><td class="'+cofes+'">'+value.codigo+'</td><td class="'+cofes+'">'+value.nombre+'</td><td class="'+cofes+'">'+value.ums+'</td>'+
                    '<td '+p1+'>'+value.preciouno+'</td><td '+p2+'>'+value.preciodos+'</td><td '+p3+'>'+value.preciotres+'</td><td '+p4+'>'+value.preciocuatro+'</td><td '+p5+'>'+value.preciocinco+'</td>'+
                    '<td '+lstcst+'>'+value.lastcostosuc+'</td><td '+lstcst+'>'+value.lastcosto+'</td>'+
                    '<td class="'+cofes+'">'+value.codigo2+'</td><td class="'+cofes+'">'+value.nombre2+'</td><td class="'+cofes+'">'+value.ums+'</td>'+
                    '<td class="'+cofes+'">'+formatMoney(pzofe)+'</td><td>'+value.p2+'</td><td>'+value.p3+'</td><td>'+value.p4+'</td><td>'+value.p5+'</td></tr>')
            })
            $(".countRojo").html(p111);
            $(".countVerde").html(p11)//<button type="button" class="btn btn-outline-secondary font-weight-bold">26 - 50</button>
            var rowload = '<div class="btn-group" role="group" aria-label="Button group with nested dropdown"><button type="button" class="btn btn-outline-secondary font-weight-bold btnpagsuc btnpagsuc1 btn-dark" data-id-rojo="1">1 - 50</button>';
            for (var i = 1; i < flagcien - 1; i++) {
                rowload += '<button type="button" class="btn btn-outline-secondary font-weight-bold btnpagsuc btnpagsuc'+(i + 1)+'" data-id-rojo="'+(i + 1)+'">'+(i * 50 + 1)+' - '+((i + 1) * 50)+'</button>'
            }
            rowload += '<button type="button" class="btn btn-outline-secondary font-weight-bold btnpagsuc btnpagsuc'+flagcien+'" data-id-rojo="'+flagcien+'">'+((flagcien-1) * 50)+' +</button>'
            $(".rowLoad").html(rowload+'</div><div><h4 style="font-size:16px"><br>Se encontrarón '+resp.length+' resultados</h4></div>');
            $("#excelCompa").css("display","block");
        }else{
            $(".rowLoad").html('<div class="col-xl-3"><h1 class="text-danger">NO SE ENCONTRARÓN DATOS, POR FAVOR SELECCIONA OTRA SUCURSAL Y VUELVE A SELECCIONAR ESTA</h1></div><div class="col-xl-6"><img src="assets/img/loading4.gif" class="rowLoadImg"></div>');
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
    $(".thSucus2").html("PRECIOS <br>"+dis2);
    $(".btnCualBusco").removeClass("btn-success")
    $(".btnCualBusco1").addClass("btn-success")
    comparaciones(dis)

    $(".btnSucuCedis").removeClass("btn-success")
    $(".btnSucuCedis"+dis).addClass("btn-success")
})


$(document).off("click",".btnCualBusco").on("click",".btnCualBusco",function(e){
    e.preventDefault();
    $(".btnCualBusco").removeClass("btn-success")
    $(this).addClass("btn-success")
    var dis = $(this).data("idRojo");
    $(".tbodyCompa").html("")
    $(".countRojo").html("")
    $(".countVerde").html("")
    $("#excelCompa").css("display","none");
    $(".rowLoad").html('<div class="col-xl-3"><h1 class="text-warning">CARGANDO DATOS...</h1></div><div class="col-xl-6"><img src="assets/img/loading3.gif" class="rowLoadImg"></div>');
    if(dis == 10){
        comparaRenglon(cualdis);
    }else{
        comparaciones(cualdis)
    }
})


function comparaRenglon(vSucuCed) {
    
    getRenglon(vSucuCed).done(function(resp){
        var p11 = 0;var p111 = 0;
        if(resp){
            var flagcien = 1;var clasecien="style='display:table-row'";
            $.each(resp,function(index,value){
                var p1 ="";var p2 ="";var p3 ="";var p4 ="";var p5 ="";var cofes = "";var pzofe = value.p1;
                if (parseFloat(value.preciouno) > parseFloat(value.p1)){
                    p1 = "style='background:#BAF3E0'";
                    //p11++;
                }else if(parseFloat(value.preciouno) < parseFloat(value.p1)){
                    p1 = "style='background:#F9BABA'";
                    
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
                var lstcst = "";
                if(value.lastcostosuc > value.lastcosto){
                    p111++;
                }else if(value.lastcostosuc < value.lastcosto){
                    p11++;
                }
                if(value.lastcostosuc != value.lastcosto){
                    lstcst = "style='background:#F9BABA'";
                    $(".tbodyCompa").append('<tr class="cienrow cien'+flagcien+'" '+clasecien+'><td class="'+cofes+'">'+(index+1)+'</td><td class="'+cofes+'">'+value.codigo+'</td><td class="'+cofes+'">'+value.nombre+'</td><td class="'+cofes+'">'+value.ums+'</td>'+
                    '<td '+p1+'>'+value.preciouno+'</td><td '+p2+'>'+value.preciodos+'</td><td '+p3+'>'+value.preciotres+'</td><td '+p4+'>'+value.preciocuatro+'</td><td '+p5+'>'+value.preciocinco+'</td>'+
                    '<td '+lstcst+'>'+value.lastcostosuc+'</td><td '+lstcst+'>'+value.lastcosto+'</td>'+
                    '<td class="'+cofes+'">'+value.codigo2+'</td><td class="'+cofes+'">'+value.nombre2+'</td><td class="'+cofes+'">'+value.ums+'</td>'+
                    '<td class="'+cofes+'">'+formatMoney(pzofe)+'</td><td>'+value.p2+'</td><td>'+value.p3+'</td><td>'+value.p4+'</td><td>'+value.p5+'</td></tr>')
                }
                
            })
            $(".countRojo").html(p111);
            $(".countVerde").html(p11)//<button type="button" class="btn btn-outline-secondary font-weight-bold">26 - 50</button>
            var rowload = '<div class="btn-group" role="group" aria-label="Button group with nested dropdown"><button type="button" class="btn btn-outline-secondary font-weight-bold btnpagsuc btnpagsuc1 btn-dark" data-id-rojo="1">1 - 50</button>';
            for (var i = 1; i < flagcien - 1; i++) {
                rowload += '<button type="button" class="btn btn-outline-secondary font-weight-bold btnpagsuc btnpagsuc'+(i + 1)+'" data-id-rojo="'+(i + 1)+'">'+(i * 50 + 1)+' - '+((i + 1) * 50)+'</button>'
            }
            rowload += '<button type="button" class="btn btn-outline-secondary font-weight-bold btnpagsuc btnpagsuc'+flagcien+'" data-id-rojo="'+flagcien+'">'+((flagcien-1) * 50)+' +</button>'
            $(".rowLoad").html(rowload+'</div><div><h4 style="font-size:16px"><br>Se encontrarón '+resp.length+' resultados</h4></div>');
            //$("#excelCompa").css("display","block");
        }else{
            $(".rowLoad").html('<div class="col-xl-3"><h1 class="text-danger">NO SE ENCONTRARÓN DATOS, POR FAVOR SELECCIONA OTRA SUCURSAL Y VUELVE A SELECCIONAR ESTA</h1></div><div class="col-xl-6"><img src="assets/img/loading4.gif" class="rowLoadImg"></div>');
        }
    })
}

function getRenglon(value) {
    return $.ajax({
        url: site_url+"Compara/getRenglonCedis/"+value,
        type: "POST",
        cache: false,
    });
}