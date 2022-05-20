'use strict';
var dataJSONArray = "";
var datatable = "";
jQuery(document).ready(function() {
    $("#titlePrincipal").html("REPORTE SUCURSALES");
    KTSelect2.init();
    KTBootstrapDaterangepicker.init();
    getReporte();
});

function getReporte(){
    console.log($('#selectLinea').val())
    console.log($('#rangeFecha').val())
    getMerma().done(function(resp){
        //console.log(resp)
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


                $(".tbodyMermas").append("<tr><td>"+value.id_producto+"</td><td>"+value.codigo+"</td><td class='font-weight-bolder'>"+value.nombre+"</td><td>"+value.ides+"</td><td>"+value.unidad+"</td><td>"+value.linea+"</td>"+
                    //RENGLONES CEDIS
                    "<td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[7].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[7].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce7)+"</td>"+
                    "<td>"+formatMoney(entra7)+"</td><td></td><td>"+formatMoney(value.sucursales[7].salcan)+"</td><td></td><td></td><td></td>"+
                    //RENGLONES SOLIDARIDAD
                    "<td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[6].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[6].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce6)+"</td>"+
                    "<td>"+formatMoney(entra6)+"</td><td></td><td>"+formatMoney(value.sucursales[6].salcan)+"</td><td></td><td></td><td></td>"+
                    //RENGLONES ULTRAMARINOS    
                    "<td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[5].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[5].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce5)+"</td>"+
                    "<td>"+formatMoney(entra5)+"</td><td></td><td>"+formatMoney(value.sucursales[5].salcan)+"</td><td></td><td></td><td></td>"+
                    //RENGLONES TRINCHERAS    
                    "<td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[4].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[4].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce4)+"</td>"+
                    "<td>"+formatMoney(entra4)+"</td><td></td><td>"+formatMoney(value.sucursales[4].salcan)+"</td><td></td><td></td><td></td>"+
                    //RENGLONES MERCADO    
                    "<td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[3].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[3].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce3)+"</td>"+
                    "<td>"+formatMoney(entra3)+"</td><td></td><td>"+formatMoney(value.sucursales[3].salcan)+"</td><td></td><td></td><td></td>"+
                    //RENGLONES TENENCIA    
                    "<td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[2].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[2].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce2)+"</td>"+
                    "<td>"+formatMoney(entra2)+"</td><td></td><td>"+formatMoney(value.sucursales[2].salcan)+"</td><td></td><td></td><td></td>"+
                    //RENGLONES TIJERAS    
                    "<td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[1].ucosto)+"</td><td class='font-weight-bolder'>$ "+formatMoney(value.sucursales[1].puno)+"</td><td class='font-weight-bolder'>% "+formatMoney(porce1)+"</td>"+
                    "<td>"+formatMoney(entra1)+"</td><td></td><td>"+formatMoney(value.sucursales[1].salcan)+"</td><td></td><td></td><td></td>"+
                    "</tr>")
            })
        }
    })
}


function isnull(cant){
    if(cant == null || cant == ""){
        return 0;
    }else{
        return cant;
    }
}


function getMerma() {
    return $.ajax({
        url: site_url+"Reporte/getMerma",
        type: "POST",
        cache: false,
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


// Class definition

var KTBootstrapDaterangepicker = function () {
    // Private functions
    var demos = function () {

        var start = moment().subtract(6, 'days');
        var end = moment();

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
    