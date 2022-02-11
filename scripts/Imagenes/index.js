'use strict';
var imageName = "";
var dataJSONArray = "";
var urlDrop = "";
var urlDrop2 = "";
var datatable ="";
var imgCualT = 0;
var imgCualT2 = 0;
jQuery(document).ready(function() {
    $("#titlePrincipal").html("IMAGENES DE PRODUCTOS");
    //getMeNews();
    KTDatatableChildDataLocalDemo.init();
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

function goBack() {
  window.history.back();
}
function destroyer(){
    datatable.destroy()
    if($("#cardTable").html() == ""){
        $("#cardTable").html('<div class="kt-datatable datatable datatable-bordered datatable-head-custom" id="prodTable"></div>')
    }
    setTimeout(function(){
        KTDatatableChildDataLocalDemo.init()
    },500)
}



var KTDatatableChildDataLocalDemo = function() {
    // Private functions

    // demo initializer
    var mainTableInit = function() {
        getOfertas().done(function(resp){
            if (resp) {
                var yeison="[";var folio = "";
                $.each(resp,function(inx,value){
                    var yeison2 = "";var totales = 0;
                    value.linea = badString(value.linea);
                    yeison = yeison + '{"RecordID":'+value.id_oferta+',"Fecha":"'+value.fecha_registro+'","Inicio":"'+value.fecha_inicio+'","Termino":"'+value.fecha_termino+'","Idprod":"'+value.id_producto+
                    '","Codigo":"'+value.codigo+'","Nombre":"'+value.nombre+'","Precio":"'+value.precio+'","Normal":"'+value.normal+'","Maximo":"'+value.maximo+'","Registro":"'+value.registro+'","Tipo":"'+value.tipo+
                    '","Conjunto":"'+value.conjunto+'","Ln":"'+value.ln+'","Linea":"'+value.linea+'","Imagen":"'+value.url+'","Umedida":"'+value.umedida+'","Unidad":"'+value.Unidad+'","Estatus":"'+value.estatus+'"},';
                    

                });
                dataJSONArray =JSON.parse(yeison.slice(0,-1)+']');
            }else{
                dataJSONArray =JSON.parse('[]');
            }

            setTimeout(function(){
                datatable = $('.kt-datatable').KTDatatable({
                    // datasource definition
                    data: {
                        type: 'local',
                        source: dataJSONArray,
                        pageSize: 100, // display 20 records per page
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
                        title: 'Cargando Ventas',
                    },

                    search: {
                        input: $('#tableSearch'),
                    },
                    
                    rows:{autoHide:!1},
                    // columns definition
                    columns: [
                        {
                            field: 'RecordID',
                            title: '-',
                            width: 10,
                            textAlign: 'center',
                            type:'number'
                        },{
                            field: 'Codigo',
                            title: 'Codigo',
                            width: 180,
                            autoHide: false,
                            textAlign: 'right',
                            template: function(row) {
                                return '<span class="text-dark-75 font-weight-bolder font-size-lg text-hover-primary mb-1">'+row.Codigo+'</span>';
                            },
                        },{
                            field: 'Nombre',
                            title: 'Nombre',
                            width: 750,
                            autoHide: false,
                            textAlign: 'right',
                            template: function(row) {
                                return '<span class="text-dark-75 font-weight-bolder font-size-lg text-hover-primary mb-1">'+row.Nombre+'</span>';
                            },
                        },{
                            field: 'Umedida',
                            title: 'Unidad',
                            width: 50,
                            autoHide: false,
                            textAlign: 'right',
                            template: function(row) {
                                return '<span class="text-dark-75 font-weight-bolder font-size-lg text-hover-primary mb-1">'+row.Umedida+'</span>';
                            },
                        }, {
                            field: 'Imagen',
                            title: 'Imágen',
                            width: 200,
                            autoHide: false,
                            textAlign: 'center',
                            template: function(row) {      
                                var status = {
                                    1: {'title': 'PENDIENTE', 'class': 'label-light-warning'},
                                    2: {'title': 'PAGADO', 'class': 'label-light-success'},
                                };
                                return '<img src="assets/uploads/productos/'+row.Imagen+'" class="imgOfes imgOfes'+row.Idprod+'"/>';
                                
                            },
                        }, {
                            field: 'Estatus',
                            title: 'Cambiar Imagen',
                            width: 100,
                            teautoHide: false,
                            textAlign: 'right',
                            template: function(row) {
                                return '<span><a class="btn btn-success btn-sm btnChangeImg" data-toggle="modal" data-target="#kt_modal_imagen" data-id-folio="'+row.Idprod+'"><span class="svg-icon">'+
                                    '</span>CAMBIAR IMAGEN</a></span>';
                                
                            },
                        }],
                });
                $(".cargandodiv").css("display","none");
            },500)


            $('#kt_form_status').on('change', function() {
                datatable.search($(this).val().toLowerCase(), 'Status');
            });

            $('#kt_form_type').on('change', function() {
                datatable.search($(this).val().toLowerCase(), 'Type');
            });

            $('#kt_form_status,#kt_form_type').selectpicker();
        });
        

    };

    return {
        // Public functions
        init: function() {
            // init dmeo
            mainTableInit();
        },
    };
}();

function getOfertas() {
    return $.ajax({
        url: site_url+"Uploads/getOfertas",
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
function badString(strs){
    strs = strs.replace(/\n/g, "");
    strs = strs.replace(/\\n/g, "");
    strs = strs.replace(/\r?\n|\r/g, "");
    return strs;
}

$(document).off("click",".btnChangeImg").on("click",".btnChangeImg",function(event){
    event.preventDefault();
    var dis = $(this);
    var col = 1;
    if(dis.data("idFolio") != null || dis.data("idFolio") != ""){
        col = dis.data("idFolio");
    }
    urlDrop = "Imagenes/subirImg/" + col;
    myDropzone.options.url = site_url+""+urlDrop;
    imgCualT = dis.data("idFolio");
    $(".bscimg").val("")
    $(".resImgs").html("")
    getProd(dis.data("idFolio")).done(function(resp){
        if(resp){
            $(".imgPreviews").attr("src","assets/uploads/productos/"+resp.url)
            $(".h1Modaltitle").html(resp.nombre)
            $(".h1Modalcode").html(resp.codigo)
            $(".h1ModalUmd").html(resp.ides)
        }
    })
})

$(document).off("keyup",".bscimg").on("keyup",".bscimg",function(event){
    event.preventDefault();
    var dis = $(this)
    var values = {"busca":dis.val()}
    $(".resImgs").html("")
    console.log(dis.val().length)
    if(dis.val().length > 3){
        getImages(JSON.stringify(values)).done(function(resp){
            if(resp){
                $.each(resp,function(index,value){
                    $(".resImgs").append('<div class="col-xl-4 resolImg" data-id-folio="'+value.id_imagen+'"><div class="col-xl-12 descoImg">'+value.nombre+'</div><img src="assets/uploads/productos/'+value.url+'" class="imgResoImg imgResoImg'+
                        value.id_imagen+'"/><div class="col-xl-12 descoImg">'+value.tags+'</div></div>')
                })
            }
        })
    }
})


$(document).off("click",".resolImg").on("click",".resolImg",function(event){
    event.preventDefault();
    var dis = $(this)
    $(".resolImg").css("background","#FFF")
    dis.css("background","#1BC5BD")
    saveImagen(dis.data("idFolio"),imgCualT).done(function(resp){
        toastr.success("Se actualizo la imagen correctamente","Listo");
        $(".imgPreviews").attr("src",$(".imgResoImg"+dis.data("idFolio")).attr("src") )
        $(".imgOfes"+imgCualT).attr("src",$(".imgResoImg"+dis.data("idFolio")).attr("src") );
    })

})


function goBack() {
  window.history.back();
}

function getProd(valo){
    return $.ajax({
        url: site_url+"/Imagenes/getProd/"+valo,
        type: "POST",
        dataType: "JSON",
        cache: false
    });
}

function saveImagen(val1,val2){
    return $.ajax({
        url: site_url+"/Imagenes/saveImagen/"+val1+"/"+val2,
        type: "POST",
        dataType: "JSON",
        cache: false
    });
}

function getImages(value){
    return $.ajax({
        url: site_url+"/Imagenes/getImagesB",
        type: "POST",
        dataType: "JSON",
        data: {
            values : value
        }
    });
}

Dropzone.autoDiscover = false;
var myDropzone = new Dropzone("div#kt_dropzone_img", {
    paramName: "file_imagen",
    maxFiles: 1,
    maxFilesize: 1000000, // MB
    url: site_url+"Imagenes/subirImg",   
    renameFilename: function (filename) {
        return  filename;
    },
    autoProcessQueue: true,
    queuecomplete:function(resp) {

    },
    success: function(file, response){
        imageName = response;
        myDropzone.removeAllFiles();
        $(".imgPreviews").attr("src","assets/uploads/productos/"+response);
        $(".imgOfes"+imgCualT).attr("src","assets/uploads/productos/"+response);
    }
});

var myDropzone2 = new Dropzone("div#kt_dropzone_img2", {
    paramName: "file_imagen",
    maxFiles: 1,
    maxFilesize: 1000000, // MB
    url: site_url+"Imagenes/subirImg",   
    renameFilename: function (filename) {
        return  filename;
    },
    autoProcessQueue: true,
    queuecomplete:function(resp) {

    },
    success: function(file, response){
        imageName = response;
        myDropzone2.removeAllFiles();
        $(".imgPreviews2").attr("src","assets/uploads/productos/"+response);
        $(".imgOfes"+imgCualT).attr("src","assets/uploads/productos/"+response);
    }
});


$(document).off("keyup",".buscaProd1").on("keyup",".buscaProd1",function(event){
    event.preventDefault();
    var dis = $(this)
    var values = {"busca":dis.val()}
    $("#tbleResosBody").html("")
    $(".bscimg2").val("");
    $(".resImgs2").html("")
    $(".cambioSelec").css("display","none");
    if(dis.val().length > 3){
        buscaProducto(JSON.stringify(values)).done(function(resp){
            if(resp){
                if(resp){
                    $.each(resp,function(index,value){
                        $("#tbleResosBody").append('<tr><td>'+value.id_producto+'</td><td>'+value.codigo+'</td><td>'+value.nombre+'</td><td>'+value.unidad+'</td><td>'+value.ides+'</td><td>'+value.linea+'</td><td>'+value.ima+'</td>'+
                            '<td><button type="button" class="btn btn-success btnCambiaTbl" data-id-user="'+value.url+'" data-id-folio="'+value.id_producto+'" data-id-prod="'+value.nombre+'" data-id-rojo="'+value.codigo+
                            '" data-id-uni="'+value.unidad+'">CAMBIAR</button></td></tr>')
                    })
                }
            }
        })
    }
})

function buscaProducto(value){
    return $.ajax({
        url: site_url+"/Imagenes/buscaProducto",
        type: "POST",
        dataType: "JSON",
        data: {
            values : value
        }
    });
}

$(document).off("click",".btnCambiaTbl").on("click",".btnCambiaTbl",function(event){
    event.preventDefault();
    var dis = $(this)
    var img = dis.data("idUser");
    var pro = dis.data("idFolio");
    imgCualT2 = pro;
    $(".imgPreviews2").attr("src","assets/uploads/productos/"+img )
    $("#tbleResosBody").html("");
    $(".buscaProd1").val("");
    $(".h1Modaltitle2").html(dis.data("idProd"));
    $(".h1Modalcode2").html(dis.data("idRojo"));
    $(".h1ModalUmd2").html(dis.data("idUni"));
    $(".cambioSelec").css("display","contents");

    urlDrop2 = "Imagenes/subirImg/" + pro;
    myDropzone2.options.url = site_url+""+urlDrop2;
})

$(document).off("keyup",".bscimg2").on("keyup",".bscimg2",function(event){
    event.preventDefault();
    var dis = $(this)
    var values = {"busca":dis.val()}
    $(".resImgs2").html("")
    if(dis.val().length > 3){
        getImages(JSON.stringify(values)).done(function(resp){
            if(resp){
                $.each(resp,function(index,value){
                    $(".resImgs2").append('<div class="col-xl-4 resolImg2" data-id-folio="'+value.id_imagen+'"><div class="col-xl-12 descoImg2">'+value.nombre+'</div><img src="assets/uploads/productos/'+value.url+'" class="imgResoImg2 imgResoImg2'+
                        value.id_imagen+'"/><div class="col-xl-12 descoImg2">'+value.tags+'</div></div>')
                })
            }
        })
    }
})

$(document).off("click",".resolImg2").on("click",".resolImg2",function(event){
    event.preventDefault();
    var dis = $(this)
    $(".resolImg2").css("background","#FFF")
    dis.css("background","#1BC5BD")
    saveImagen(dis.data("idFolio"),imgCualT2).done(function(resp){
        toastr.success("Se actualizo la imagen correctamente","Listo");
        $(".imgPreviews2").attr("src",$(".imgResoImg2"+dis.data("idFolio")).attr("src") )
        $(".imgOfes"+imgCualT2).attr("src",$(".imgResoImg2"+dis.data("idFolio")).attr("src") );
    })
})
