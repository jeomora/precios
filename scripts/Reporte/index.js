'use strict';
var dataJSONArray = "";
var datatable = "";
var datos = "";
jQuery(document).ready(function() {
    $("#titlePrincipal").html("REPORTE SUCURSALES");
    KTSelect2.init();
    KTBootstrapDaterangepicker.init();
    //getReporte();
});
 
function getReporte(){
    var fechRan = $('#rangeFecha').val();
    datos = {"inicio": fechRan.substring(6,10)+"-"+fechRan.substring(0,2)+"-"+fechRan.substring(3,5), "final":fechRan.substring(19,23)+"-"+fechRan.substring(13,15)+"-"+fechRan.substring(16,18), "linea":$('#selectLinea').val()}
    $(".fIni").html(" ( "+formatDate2(datos.inicio)+" - "+formatDate2(datos.final)+" )")
    $(".tbodyMermas").html("")
    $(".imgLoadModal").css("display","block");
    getMerma(JSON.stringify(datos)).done(function(resp){
        
        if(resp){
            $.each(resp,function(index,value){
                console.log(value)
                var porce7 =  ((value.sucursales[7].puno-value.sucursales[7].ucosto)/value.sucursales[7].puno)*100;
                var porce6 =  ((value.sucursales[6].puno-value.sucursales[6].ucosto)/value.sucursales[6].puno)*100;
                var porce5 =  ((value.sucursales[5].puno-value.sucursales[5].ucosto)/value.sucursales[5].puno)*100;
                var porce4 =  ((value.sucursales[4].puno-value.sucursales[4].ucosto)/value.sucursales[4].puno)*100;
                var porce3 =  ((value.sucursales[3].puno-value.sucursales[3].ucosto)/value.sucursales[3].puno)*100;
                var porce2 =  ((value.sucursales[2].puno-value.sucursales[2].ucosto)/value.sucursales[2].puno)*100;
                var porce1 =  ((value.sucursales[1].puno-value.sucursales[1].ucosto)/value.sucursales[1].puno)*100;
                var porce8 =  ((value.sucursales[8].puno-value.sucursales[8].ucosto)/value.sucursales[8].puno)*100;


                var entra1 = isnull(value.sucursales[1].entcan)+isnull(value.sucursales[1].notacan);
                var entra2 = isnull(value.sucursales[2].entcan)+isnull(value.sucursales[2].notacan);
                var entra3 = isnull(value.sucursales[3].entcan)+isnull(value.sucursales[3].notacan);
                var entra4 = isnull(value.sucursales[4].entcan)+isnull(value.sucursales[4].notacan);
                var entra5 = isnull(value.sucursales[5].entcan)+isnull(value.sucursales[5].notacan);
                var entra6 = isnull(value.sucursales[6].entcan)+isnull(value.sucursales[6].notacan);
                var entra7 = isnull(value.sucursales[7].entcan)+isnull(value.sucursales[7].notacan);
                var entra8 = isnull(value.sucursales[8].entcan)+isnull(value.sucursales[8].notacan);

                var inve1 = (isnull(value.sucursales[1].sexistencia1)+entra1) - ( isnull(value.sucursales[1].sexistencia2) + isnull(value.sucursales[1].salcan) ) ;
                var inve2 = (isnull(value.sucursales[2].sexistencia1)+entra2) - ( isnull(value.sucursales[2].sexistencia2) + isnull(value.sucursales[2].salcan) ) ;
                var inve3 = (isnull(value.sucursales[3].sexistencia1)+entra3) - ( isnull(value.sucursales[3].sexistencia2) + isnull(value.sucursales[3].salcan) ) ;
                var inve4 = (isnull(value.sucursales[4].sexistencia1)+entra4) - ( isnull(value.sucursales[4].sexistencia2) + isnull(value.sucursales[4].salcan) ) ;
                var inve5 = (isnull(value.sucursales[5].sexistencia1)+entra5) - ( isnull(value.sucursales[5].sexistencia2) + isnull(value.sucursales[5].salcan) ) ;
                var inve6 = (isnull(value.sucursales[6].sexistencia1)+entra6) - ( isnull(value.sucursales[6].sexistencia2) + isnull(value.sucursales[6].salcan) ) ;
                var inve7 = (isnull(value.sucursales[7].sexistencia1)+entra7) - ( isnull(value.sucursales[7].sexistencia2) + isnull(value.sucursales[7].salcan) ) ;
                var inve8 = (isnull(value.sucursales[8].sexistencia1)+entra8) - ( isnull(value.sucursales[8].sexistencia2) + isnull(value.sucursales[8].salcan) ) ;


                var totcom1 = entra1 * value.sucursales[1].ucosto;
                var totcom2 = entra2 * value.sucursales[2].ucosto;
                var totcom3 = entra3 * value.sucursales[3].ucosto;
                var totcom4 = entra4 * value.sucursales[4].ucosto;
                var totcom5 = entra5 * value.sucursales[5].ucosto;
                var totcom6 = entra6 * value.sucursales[6].ucosto;
                var totcom7 = entra7 * value.sucursales[7].ucosto;
                var totcom8 = entra1 * value.sucursales[8].ucosto;



                $(".tbodyMermas").append("<tr><td>"+value.id_producto+"</td><td>"+value.codigo+"</td><td class='font-weight-bolder codeSticky'>"+value.nombre+"</td><td>"+value.ides+"</td><td>"+value.unidad+"</td><td>"+value.linea+"</td>"+
                    //RENGLONES CEDIS
                    "<td class='font-weight-bolder td7left'>$ "+formatMoney(value.sucursales[7].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[7].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce7)+"</td>"+
                    "<td>"+formatMoney(entra7)+"</td><td>"+formatMoney(value.sucursales[7].sumorems)+"</td><td>"+formatMoney(value.sucursales[7].salcan)+"</td><td>$ "+formatMoney( totcom7 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[7].salcan * value.sucursales[7].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;' >$ "+formatMoney( (totcom7/isnull(value.sucursales[7].sumorems)) )+"</td>"+
                    "<td class='td7right'></td>"+//<button type='button' class='btn btn-outline-success showdetails' data-toggle='modal' data-target='#modalDetails' data-id-sucu='7' data-id-rojo='"+value.id_producto+"'>VER DETALLES</button>
                    //RENGLONES SOLIDARIDAD
                    "<td class='font-weight-bolder td6left'>$ "+formatMoney(value.sucursales[6].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[6].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce6)+"</td>"+
                    "<td>"+formatMoney(entra6)+"</td><td>"+formatMoney(inve6)+"</td><td>"+formatMoney(value.sucursales[6].salcan)+"</td><td>$ "+formatMoney( totcom6 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[6].salcan * value.sucursales[6].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;' >$ "+formatMoney( (totcom6/inve6) )+"</td>"+
                    "<td class='td6right'><button type='button' class='btn btn-outline-success showdetails' data-toggle='modal' data-target='#modalDetails' data-id-sucu='6' data-id-rojo='"+value.id_producto+"'>VER DETALLES</button></td>"+
                    //RENGLONES ULTRAMARINOS    
                    "<td class='font-weight-bolder td5left'>$ "+formatMoney(value.sucursales[5].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[5].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce5)+"</td>"+
                    "<td>"+formatMoney(entra5)+"</td><td>"+formatMoney(inve5)+"</td><td>"+formatMoney(value.sucursales[5].salcan)+"</td><td>$ "+formatMoney( totcom5 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[5].salcan * value.sucursales[5].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;' >$ "+formatMoney( (totcom5/inve5) )+"</td>"+
                    "<td class='td5right'><button type='button' class='btn btn-outline-success showdetails' data-toggle='modal' data-target='#modalDetails' data-id-sucu='5' data-id-rojo='"+value.id_producto+"'>VER DETALLES</button></td>"+
                    //RENGLONES TRINCHERAS    
                    "<td class='font-weight-bolder td4left'>$ "+formatMoney(value.sucursales[4].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[4].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce4)+"</td>"+
                    "<td>"+formatMoney(entra4)+"</td><td>"+formatMoney(inve4)+"</td><td>"+formatMoney(value.sucursales[4].salcan)+"</td><td>$ "+formatMoney( totcom4 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[4].salcan * value.sucursales[4].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;' >$ "+formatMoney( (totcom4/inve4) )+"</td>"+
                    "<td class='td4right'><button type='button' class='btn btn-outline-success showdetails' data-toggle='modal' data-target='#modalDetails' data-id-sucu='4' data-id-rojo='"+value.id_producto+"'>VER DETALLES</button></td>"+
                    //RENGLONES MERCADO    
                    "<td class='font-weight-bolder td3left'>$ "+formatMoney(value.sucursales[3].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[3].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce3)+"</td>"+
                    "<td>"+formatMoney(entra3)+"</td><td>"+formatMoney(inve3)+"</td><td>"+formatMoney(value.sucursales[3].salcan)+"</td><td>$ "+formatMoney( totcom3 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[3].salcan * value.sucursales[3].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;' >$ "+formatMoney( (totcom3/inve3) )+"</td>"+
                    "<td class='td3right'><button type='button' class='btn btn-outline-success showdetails' data-toggle='modal' data-target='#modalDetails' data-id-sucu='3' data-id-rojo='"+value.id_producto+"'>VER DETALLES</button></td>"+
                    //RENGLONES TENENCIA    
                    "<td class='font-weight-bolder td2left'>$ "+formatMoney(value.sucursales[2].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[2].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce2)+"</td>"+
                    "<td>"+formatMoney(entra2)+"</td><td>"+formatMoney(inve2)+"</td><td>"+formatMoney(value.sucursales[2].salcan)+"</td><td>$ "+formatMoney( totcom2 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[2].salcan * value.sucursales[2].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;' >$ "+formatMoney( (totcom2/inve2) )+"</td>"+
                    "<td class='td2right'><button type='button' class='btn btn-outline-success showdetails' data-toggle='modal' data-target='#modalDetails' data-id-sucu='2' data-id-rojo='"+value.id_producto+"'>VER DETALLES</button></td>"+
                    //RENGLONES TIJERAS    
                    "<td class='font-weight-bolder td1left'>$ "+formatMoney(value.sucursales[1].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[1].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce1)+"</td>"+
                    "<td>"+formatMoney(entra1)+"</td><td>"+formatMoney(inve1)+"</td><td>"+formatMoney(value.sucursales[1].salcan)+"</td><td>$ "+formatMoney( totcom1 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[1].salcan * value.sucursales[1].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;' >$ "+formatMoney( (totcom1/inve1) )+"</td>"+
                    "<td class='td1right'><button type='button' class='btn btn-outline-success showdetails' data-toggle='modal' data-target='#modalDetails' data-id-sucu='1' data-id-rojo='"+value.id_producto+"'>VER DETALLES</button></td>"+
                    "</tr>")
            })
        }
        $(".imgLoadModal").css("display","none");
    })
}

$(document).off("click",".showdetails").on("click",".showdetails",function(event){
    event.preventDefault();
    
    $(".imgLoadModal").css("display","block");
    var fechRan = $('#rangeFecha').val();
    $(".tbodyEntra").html("");$(".tfootEntra1").html("0");$(".tfootEntra2").html("$ 0.00");
    $(".tbodyAjue").html("");$(".tfootAjue1").html("0");$(".tfootAjue2").html("$ 0.00");
    $(".tbodyAjus").html("");$(".tfootAjus1").html("0");$(".tfootAjus2").html("$ 0.00");

    datos = {"inicio": fechRan.substring(6,10)+"-"+fechRan.substring(0,2)+"-"+fechRan.substring(3,5), "final":fechRan.substring(19,23)+"-"+fechRan.substring(13,15)+"-"+fechRan.substring(16,18), "linea":$('#selectLinea').val(),"id_suc":$(this).data("idSucu"),"id_prod":$(this).data("idRojo")}
    getMermaProd(JSON.stringify(datos)).done(function(resp){
        var uno1 = 0;var dos1 = 0;var uno2 = 0;var dos2 = 0;var uno3 = 0;var dos3 = 0;var ex1 = 0;var ex2 = 0;
        if(resp.entra){
            
            $.each(resp.entra,function(index,value){
                uno1 += parseFloat(isnull(value.cantidad));
                dos1 += parseFloat(isnull(value.importe));
                $(".tbodyEntra").append('<tr><td>'+value.folio+'</td> <td>'+value.fecha+'</td> <td>'+value.provee+'</td> <td style="font-weight:bold">'+formatMoney(value.cantidad)+'</td> <td>$ '+formatMoney(value.importe)+'</td> <td>$ '+formatMoney(value.total)+'</td></tr>')
                $(".tfootEntra1").html("CANTIDAD TOTAL : "+formatMoney(uno1))
                $(".tfootEntra2").html("$ "+formatMoney(dos1))
                $(".venEnt1").html(formatMoney(value.existencia1))
                ex1 = value.existencia1;
                ex2 = value.existencia2;
                $(".venSal1").html(formatMoney(value.existencia2))
                $(".venEnt2").html(formatMoney(uno1))
                
            })
        }

        if(resp.ajuen){
            
            $.each(resp.ajuen,function(index,value){
                uno2 += parseFloat(isnull(value.cantidad));
                dos2 += parseFloat(isnull(value.importe));
                $(".tbodyAjue").append('<tr><td>'+value.folio+'</td> <td>'+value.fecha+'</td> <td>'+value.referencia+'</td> <td style="font-weight:bold">'+formatMoney(value.cantidad)+'</td> <td>$ '+formatMoney(value.importe)+'</td> </tr>')
                $(".tfootAjue1").html("CANTIDAD TOTAL : "+formatMoney(uno2))
                $(".tfootAjue2").html("$ "+formatMoney(dos2))
                
            })
        }

        if(resp.ajusa){
            
            $.each(resp.ajusa,function(index,value){
                uno3 += parseFloat(isnull(value.cantidad));
                dos3 += parseFloat(isnull(value.importe));
                $(".tbodyAjus").append('<tr><td>'+value.folio+'</td> <td>'+value.fecha+'</td> <td>'+value.referencia+'</td> <td style="font-weight:bold">'+formatMoney(value.cantidad)+'</td> <td>$ '+formatMoney(value.importe)+'</td> </tr>')
                $(".tfootAjus1").html("CANTIDAD TOTAL : "+formatMoney(uno3))
                $(".tfootAjus2").html("$ "+formatMoney(dos3))
                $(".venSal2").html(formatMoney(uno3))
            })
        }
        setTimeout(function(){
            var totent = isnull(ex1) + isnull(uno1) + isnull(dos2);
            var totsal = isnull(ex2) + isnull(uno3);

            $(".venEnt4").html(formatMoney(totent))
            $(".venSal3").html(formatMoney(totsal))
            $(".ventotis").html(formatMoney( (totent - totsal) ))
        },1000)


    })
})

function isnull(cant){
    if(cant == null || cant == ""  || cant == NaN){
        return 0;
    }else{
        return parseFloat(cant);
    }
}


function getMerma(datos) {
    return $.ajax({
        url: site_url+"Reporte/getMerma",
        type: "POST",
        cache: false,
        data:{
            values:datos
        }
    });
}

function getMermaProd(datos,ide,ides) {
    return $.ajax({
        url: site_url+"Reporte/getMermaProd",
        type: "POST",
        cache: false,
        data:{
            values:datos
        }
    });
}

var KTSelect2 = function() {   
    var demos = function() {
    
        $('#selectLinea').select2({
            placeholder: "SELECCIONE UNA LINEA(FAMILIA)"
        });

    }
    return {
        init: function() {
            demos();
        }
    };
}();


var KTBootstrapDaterangepicker = function () {
    // Private functions
    var demos = function () {

        var start = moment().subtract(7, 'days');
        var end = moment().subtract(1, 'days');

        $('#rangeFecha').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',

            startDate: start,
            endDate: end,
            ranges: {
                'HOY': [moment(), moment()],
                'AYER': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'ULTIMOS 7 DIAS': [moment().subtract(6, 'days'), moment()],
                'ULTIMOS 14 DIAS': [moment().subtract(13, 'days'), moment()],
                'ULTIMOS 21 DIAS': [moment().subtract(20, 'days'), moment()],
                'ULTIMOS 30 DÍAS': [moment().subtract(29, 'days'), moment()],
                'ESTE MES': [moment().startOf('month'), moment().endOf('month')],
                'MES ANTERIOR': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, label) {
            $('#rangeFecha .form-control').val( start.format('DD-MM-YYYY') + ' / ' + end.format('DD-MM-YYYY'));
        });
    }

    return {
        init: function() {
            demos();
        }
    };
}();


$(document).off("change","#rangeFecha").on("change","#rangeFecha",function(event){
    event.preventDefault();
    getReporte();
})

$(document).off("change","#selectLinea").on("change","#selectLinea",function(event){
    event.preventDefault();
    getReporte();
})


