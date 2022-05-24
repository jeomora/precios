'use strict';
var dataJSONArray = "";
var datatable = "";
jQuery(document).ready(function() {
    $("#titlePrincipal").html("REPORTE SUCURSALES");
    KTSelect2.init();
    KTBootstrapDaterangepicker.init();
    //getReporte();
});

function getReporte(){
    var fechRan = $('#rangeFecha').val();
    var datos = {"inicio": fechRan.substring(6,10)+"-"+fechRan.substring(0,2)+"-"+fechRan.substring(3,5), "final":fechRan.substring(19,23)+"-"+fechRan.substring(13,15)+"-"+fechRan.substring(16,18), "linea":$('#selectLinea').val()}
    $(".tbodyMermas").html("")
    getMerma(JSON.stringify(datos)).done(function(resp){
        //console.log(resp)
        if(resp){
            $.each(resp,function(index,value){
                //console.log(value)
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

                


                $(".tbodyMermas").append("<tr><td>"+value.id_producto+"</td><td>"+value.codigo+"</td><td class='font-weight-bolder'>"+value.nombre+"</td><td>"+value.ides+"</td><td>"+value.unidad+"</td><td>"+value.linea+"</td>"+
                    //RENGLONES CEDIS
                    "<td class='font-weight-bolder td7left'>$ "+formatMoney(value.sucursales[7].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[7].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce7)+"</td>"+
                    "<td>"+formatMoney(entra7)+"</td><td>"+formatMoney(value.sucursales[7].sumorems)+"</td><td>"+formatMoney(value.sucursales[7].salcan)+"</td><td>$ "+formatMoney( totcom7 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[7].salcan * value.sucursales[7].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;'  class='td7right'>$ "+formatMoney( (totcom7/isnull(value.sucursales[7].sumorems)) )+"</td>"+
                    //RENGLONES SOLIDARIDAD
                    "<td class='font-weight-bolder td6left'>$ "+formatMoney(value.sucursales[6].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[6].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce6)+"</td>"+
                    "<td>"+formatMoney(entra6)+"</td><td>"+formatMoney(inve6)+"</td><td>"+formatMoney(value.sucursales[6].salcan)+"</td><td>$ "+formatMoney( totcom6 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[6].salcan * value.sucursales[6].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;'  class='td6right'>$ "+formatMoney( (totcom6/inve6) )+"</td>"+
                    //RENGLONES ULTRAMARINOS    
                    "<td class='font-weight-bolder td5left'>$ "+formatMoney(value.sucursales[5].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[5].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce5)+"</td>"+
                    "<td>"+formatMoney(entra5)+"</td><td>"+formatMoney(inve5)+"</td><td>"+formatMoney(value.sucursales[5].salcan)+"</td><td>$ "+formatMoney( totcom5 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[5].salcan * value.sucursales[5].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;'  class='td5right'>$ "+formatMoney( (totcom5/inve5) )+"</td>"+
                    //RENGLONES TRINCHERAS    
                    "<td class='font-weight-bolder td4left'>$ "+formatMoney(value.sucursales[4].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[4].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce4)+"</td>"+
                    "<td>"+formatMoney(entra4)+"</td><td>"+formatMoney(inve4)+"</td><td>"+formatMoney(value.sucursales[4].salcan)+"</td><td>$ "+formatMoney( totcom4 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[4].salcan * value.sucursales[4].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;'  class='td4right'>$ "+formatMoney( (totcom4/inve4) )+"</td>"+
                    //RENGLONES MERCADO    
                    "<td class='font-weight-bolder td3left'>$ "+formatMoney(value.sucursales[3].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[3].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce3)+"</td>"+
                    "<td>"+formatMoney(entra3)+"</td><td>"+formatMoney(inve3)+"</td><td>"+formatMoney(value.sucursales[3].salcan)+"</td><td>$ "+formatMoney( totcom3 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[3].salcan * value.sucursales[3].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;'  class='td3right'>$ "+formatMoney( (totcom3/inve3) )+"</td>"+
                    //RENGLONES TENENCIA    
                    "<td class='font-weight-bolder td2left'>$ "+formatMoney(value.sucursales[2].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[2].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce2)+"</td>"+
                    "<td>"+formatMoney(entra2)+"</td><td>"+formatMoney(inve2)+"</td><td>"+formatMoney(value.sucursales[2].salcan)+"</td><td>$ "+formatMoney( totcom2 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[2].salcan * value.sucursales[2].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;'  class='td2right'>$ "+formatMoney( (totcom2/inve2) )+"</td>"+
                    //RENGLONES TIJERAS    
                    "<td class='font-weight-bolder td1left'>$ "+formatMoney(value.sucursales[1].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[1].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce1)+"</td>"+
                    "<td>"+formatMoney(entra1)+"</td><td>"+formatMoney(inve1)+"</td><td>"+formatMoney(value.sucursales[1].salcan)+"</td><td>$ "+formatMoney( totcom1 )+"</td><td>$ "+
                    formatMoney( (value.sucursales[1].salcan * value.sucursales[1].ucosto) )+"</td><td style='font-weight:bold;font-size:16px;'  class='td1right'>$ "+formatMoney( (totcom1/inve1) )+"</td>"+
                    "</tr>")
            })
        }
    })
}


function isnull(cant){
    if(cant == null || cant == ""){
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