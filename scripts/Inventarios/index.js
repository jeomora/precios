'use strict';
var dataJSONArray = "";
var datatable = "";
jQuery(document).ready(function() {
    $("#titlePrincipal").html("ENTRADAS DE INVENTARIO");
    KTDatatableChildDataLocalDemo.init();
});

function getInventario() {
    return $.ajax({
        url: site_url+"Inventarios/getInventario",
        type: "POST",
        cache: false,
    });
}


var KTDatatableChildDataLocalDemo = function() {
    // Private functions

    var subTableInit = function(e) {
        $('<div/>').attr('id', 'child_data_local_' + e.data.RecordID).appendTo(e.detailCell).KTDatatable({
            data: {
                type: 'local',
                source: e.data.Orders,
                pageSize: 20,
            },

            // layout definition
            layout: {
                scroll: false,
                footer: false,

                // enable/disable datatable spinner.
                spinner: {
                    type: 1,
                    theme: 'default',
                },
            },

            sortable: true,

            // columns definition
            columns: [
                {
                    field: 'OrderID',
                    title: '-',
                    textAlign: 'center',
                    width: 50,
                    backgroundImage: '#000000'
                }, {
                    field: 'Codigo',
                    title: 'CÓDIGO',
                    textAlign: 'center',
                    width: 300,
                }, {
                    field: 'Producto',
                    title: 'PRODUCTO',
                    textAlign: 'center',
                    width: 300,
                }, {
                    field: 'Cantidad',
                    title: 'CANTIDAD',
                    textAlign: 'center',
                    width: 100,
                }, {
                    field: 'Costo',
                    title: 'COSTO',
                    textAlign: 'center',
                    width: 100,
                }, {
                    field: 'Totalite',
                    title: 'TOTAL',
                    width: 100,
                    teautoHide: false,
                    textAlign: 'right',
                    template: function(row) {
                        return '<span class="kt-align-right kt-font-brand kt-font-bold">'+row.Totalite+'</span>';
                    },
                }, {
                    field: 'General',
                    title: 'CANT GLOBAL',
                    width: 100,
                    teautoHide: false,
                    textAlign: 'right',
                    template: function(row) {
                        return '<span class="kt-align-right kt-font-brand kt-font-bold">'+row.General+'</span>';
                    },
                }, {
                    field: 'Totalite2',
                    title: 'TOTAL GLOBAL',
                    width: 100,
                    teautoHide: false,
                    textAlign: 'right',
                    template: function(row) {
                        return '<span class="kt-align-right kt-font-brand kt-font-bold">'+row.Totalite2+'</span>';
                    },
                }],
        });
    };

    // demo initializer
    var mainTableInit = function() {
        getInventario().done(function(resp){
            if (resp) {
                console.log(resp)
                var yeison="[";var folio = "";
                $.each(resp.pasillos,function(inx,value){
                    var yeison2 = "";var totales = 0;var totps = 0;
                    if(value.detalles){
                         yeison2 = yeison2 + ',"Orders":[';
                        $.each(value.detalles,function(inxs,values){
                                var totalite = 0;var totalite2 = 0;
                                totalite = parseFloat((values.preciocinco-0.01) * values.cantidad);
                                totalite2 = parseFloat((values.preciocinco-0.01) * resp.totales[values.id_producto].cantidad);
                                values.nombre = values.nombre.replace(/"/g,'');
                                yeison2 = yeison2 + '{"OrderID":"'+values.id_inventario+'","Producto":"'+values.nombre+'","Costo":"$ '+formatMoney((values.preciocinco-0.01))+'","Cantidad":"'+formatMoney(values.cantidad,0)+
                                '","General":"'+resp.totales[values.id_producto].cantidad+'","Codigo":"'+values.codigo+'","Ums":"'+values.ums+'","Totalite2":"$ '+formatMoney(totalite2)+'","Totalite":"$ '+formatMoney(totalite)+'"},'
                                totales += totalite;
                                totps += 1;
                           })
                        yeison2 = yeison2.slice(0,-1) + ']},\n';
                    }else{
                        yeison2 = yeison2 + ',"Orders":[]},\n';
                    }
                    var sobras = "CEDIS";
                    if(value.sobras === 0 || value.sobras === "0"){
                        sobras = "SUCURSAL"
                    }
                    yeison = yeison + '{"RecordID":'+value.id_pasillo+',"Nombre":"'+value.pasillo+'","Totps":"'+totps+'","Total":"$ '+formatMoney(totales)+'"'+yeison2;
                });
                 dataJSONArray =JSON.parse(yeison.slice(0,-1).slice(0,-1)+']');
            }else{
                dataJSONArray =JSON.parse('[]');
            }
            setTimeout(function(){
                datatable = $('.kt-datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'local',
                        source: dataJSONArray,
                        pageSize: 10, // display 20 records per page
                    },

                    // layout definition
                    layout: {
                        scroll: true,
                        //height: 800,
                        footer: false,
                    },

                    sortable: true,


                    pagination: true,

                    detail: {
                        title: 'Cargando Pedidos',
                        content: subTableInit,
                    },

                    search: {
                        input: $('#tableSearch'),
                    },
                    rows:{autoHide:!1},

                    // columns definition
                    columns: [
                        {
                            field: 'RecordID',
                            title: '#',
                            width: 10,
                            textAlign: 'center',
                            type:'number'
                        },{
                            field: 'Nombre',
                            title: 'PASILLO',
                            width: 100,
                            autoHide: false,
                            textAlign: 'right',
                            template: function(row) {
                                return '<span class="text-dark-75 font-weight-bolder font-size-lg text-hover-primary mb-1">'+row.Nombre+'</span>';
                            },
                        }, {
                            field: 'Total',
                            title: 'TOTAL PASILLO',
                            textAlign: 'center',
                            width: 120,
                            template: function(row){
                                return '<span class="font-weight-bold text-dark">'+row.Total+'</span>'
                            }
                        }, {
                            field: 'Totps',
                            title: '# PRODCTOS',
                            textAlign: 'center',
                            width: 120,
                            template: function(row){
                                return '<span class="font-weight-bold text-dark">'+row.Totps+'</span>'
                            }
                        },{
                            field: 'Actions',
                            title: 'CODIGOS',
                            sortable: false,
                            width: 110,
                            overflow: 'visible',
                            autoHide: false,
                            template: function(data, i) {
                                return '<a data-id-user="'+data.RecordID+'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Re imprimir" target="_blank" href="'+site_url+'Inventarios/qrme/'+data.RecordID+'">\
                                            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2020-10-29-133027/theme/html/demo2/dist/../src/media/svg/icons/Devices/Printer.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                                                    <rect x="0" y="0" width="24" height="24"/>\
                                                    <rect fill="#000000" opacity="0.3" x="4" y="4" width="8" height="16"/>\
                                                    <path d="M6,18 L9,18 C9.66666667,18.1143819 10,18.4477153 10,19 C10,19.5522847 9.66666667,19.8856181 9,20 L4,20 L4,15 C4,14.3333333 4.33333333,14 5,14 C5.66666667,14 6,14.3333333 6,15 L6,18 Z M18,18 L18,15 \
                                                    C18.1143819,14.3333333 18.4477153,14 19,14 C19.5522847,14 19.8856181,14.3333333 20,15 L20,20 L15,20 C14.3333333,20 14,19.6666667 14,19 C14,18.3333333 14.3333333,18 15,18 L18,18 Z M18,6 L15,6 C14.3333333,5.88561808 \
                                                    14,5.55228475 14,5 C14,4.44771525 14.3333333,4.11438192 15,4 L20,4 L20,9 C20,9.66666667 19.6666667,10 19,10 C18.3333333,10 18,9.66666667 18,9 L18,6 Z M6,6 L6,9 C5.88561808,9.66666667 5.55228475,10 5,10 C4.44771525,10 \
                                                    4.11438192,9.66666667 4,9 L4,4 L9,4 C9.66666667,4 10,4.33333333 10,5 C10,5.66666667 9.66666667,6 9,6 L6,6 Z" fill="#000000" fill-rule="nonzero"/>\
                                                </g> \
                                            </svg>\
                                        </a>\
                            ';
                            },
                        }],
                });
                $(".cargandodiv").css("display","none");
            },1000)
        });


        $('#kt_form_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $('#kt_form_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_form_status,#kt_form_type').selectpicker();

    };

    return {
        // Public functions
        init: function() {
            // init dmeo
            mainTableInit();
        },
    };
}();