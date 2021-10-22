jQuery(document).ready(function() {
    $("#titlePrincipal").html("CAMBIOS DE PRECIOS");
    getMeNews();
});


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
        console.log(resp)
        if(resp){
            $.each(resp,function(index,value){
                oldResultsB(value);
            })
        }
    })
}


function oldResultsB(value){
    var oldsB = '<div class="row" style="overflow-x:scroll;padding-bottom: 50px;"><table class="table table-bordered" style="text-align:center;"><thead><tr><th class="gensuca" colspan="5" style="padding:0">'+
                    setZeros2(value.id_nuevo)+'</th><th colspan="8">'+formatDate2(value.fecha_registro)+'</th><th colspan="18" style="background:rgb(255,51,51)">AJUSTES</th></tr><tr>'+
                    '<th style="width:70px" >MARCAR<br>LISTO</th><th style="width:100px" >CÓDIGO</th><th style="width:100px" >RENGLON 18</th><th style="width:70px" >LIN</th><th style="width:350px" >DESCRIPCIÓN</th><th style="width:70px" >UM</th>'+
                    '<th style="width:100px" >C</th><th style="width:150px" >PAQUETE</th><th style="width:100px" class="ivaClass">IVA</th><th style="width:100px" class="renglon10Class">RENGLON 10</th>'+
                    '<th colspan="3" style="background:#bdd7ee">PRECIOS DEL 1 AL 3</th><th style="width:100px" >CÓDIGO</th><th style="width:350px" >DESCRIPCIÓN</th>'+
                    '<th style="width:100px" >COSTO<br>PZA</th><th style="background:#bdd7ee" colspan="3">PRECIOS DEL 1 AL 3</th></tr></thead><tbody>';

    $.each(value.detalles,function(inx,val){
        var listones = " ";var listones2 = "btn-outline-warning";var listones3 = "Listo";
        if(val.listo == 1){
            listones = " blockTh";
            listones2 = "btn-primary";
            listones3 = "display:none";
        }
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

        oldsB +=    '<tr class="rojoTr'+val.detalle+' '+listones+'"><td><button type="button" class="btn '+listones2+' nuevoBtn" data-id-rojo="'+val.detalle+'" style="'+listones3+'">'+listones3+'</button></td>'+
                    '<td>'+val.code1+'</td><td>'+val.code2+'</td><td>'+val.linea+'</td><td>'+val.desc1+'</td><td>'+val.unidad+'</td><td>'+val.cantidad+'</td><td>'+val.pre4+'</td>'+
                    '<td class="ivaClass">'+val.iva+'</td><td class="renglon10Class">'+formatMoney(renglon10)+'</td><td class="precioB">'+formatMoney(pre1)+'</td><td class="precioB">'+formatMoney(pre2)+
                    '</td><td class="precioB">'+formatMoney(pre3)+'</td></td><td>'+val.code3+'</td><td>'+val.desc2+'</td><td>'+formatMoney(costopz)+'</td><td class="precioB">'+formatMoney(pre11)+
                    '</td><td class="precioB">'+formatMoney(pre22)+'</td><td class="precioB">'+pre33+'</td></tr>';
    })

    oldsB += '</tbody></table></div>';
    $(".otrosShowsB").prepend(oldsB);
}


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