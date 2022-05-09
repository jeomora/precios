'use strict';
var dataJSONArray = "";
var datatable = "";
jQuery(document).ready(function() {
    $("#titlePrincipal").html("REPORTE SUCURSALES");
    KTSelect2.init();
    KTBootstrapDaterangepicker.init();
});



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
