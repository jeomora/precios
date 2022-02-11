'use strict';
// Class definition
var dataJSONArray = "";
var KTDatatableDataLocalDemo = function() {
    // Private functions
    // demo initializer
    
    var demo = function() {
        getSucursales().done(function(resp){
            var yeison = "[";
            if (resp) {
                $.each(resp,function(index, value){
                    yeison = yeison + '{"RecordID":'+value.id_sucursal+',"Nombre":"'+value.nombre+'","Vales":"'+value.formato+'","Actions":null},\n'

                });
            }
           dataJSONArray = JSON.parse(yeison.slice(0,-1).slice(0,-1)+']');
            setTimeout(function(){
                    var datatable = $('.kt-datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'local',
                        source: dataJSONArray,
                        pageSize: 20,
                    },

                    // layout definition
                    layout: {
                        scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                        // height: 450, // datatable's body's fixed height
                        footer: false, // display/hide footer
                    },

                    // column sorting
                    sortable: true,

                    pagination: true,

                    search: {
                        input: $('#tableSearch'),
                    },

                    // columns definition
                    columns: [
                        {
                            field: 'RecordID',
                            title: 'ID',
                            sortable: true,
                            width: 40,
                            type: 'number',
                            textAlign: 'center',
                        }, {
                            field: 'Nombre',
                            title: 'Descripción',
                            width: 350,
                            template: function(row) {
                                return '<div class="d-flex align-items-center"><div class="symbol symbol-40 symbol-dark flex-shrink-0"><div class="symbol-label">'+row.Nombre.substring(0,1)+'</div>'+
                                '</div><div class="ml-2"><div class="text-dark-75 font-weight-bold line-height-sm">' + row.Nombre + '</div></div></div>'
                            },
                        }, {
                            field: 'Vales',
                            title: 'Vales',
                        }],
                });

                $('#kt_form_status').on('change', function() {
                    datatable.search($(this).val().toLowerCase(), 'Status');
                });

                $('#kt_form_type').on('change', function() {
                    datatable.search($(this).val().toLowerCase(), 'Type');
                });

                $('#kt_form_status,#kt_form_type').selectpicker();
            },1000)
        });
    };

    return {
        // Public functions
        init: function() {
            // init dmeo
            demo();
        },
    };
}();

jQuery(document).ready(function() {
    $("#titlePrincipal").html("Sucursales");
    $(".menu-item").removeClass("menu-item-active")
    $(".menu-sucus").addClass("menu-item-active")
    KTDatatableDataLocalDemo.init();
});

function getSucursales() {
    return $.ajax({
        url: site_url+"Sucursales/getSucursales",
        type: "POST",
        dataType: "JSON",
    });
}

function goBack() {
  window.history.back();
}

$(document).off("click", ".new_usuario").on("click", ".new_usuario", function(event) {
    event.preventDefault();
    var flag = 1;
    flag = valis($("#codigos"),$(".codesValid"),flag);
    if(flag){
        sendFormas("Sucursales/save_sucursal", $("#form_usuario_new"), "");
    }
});