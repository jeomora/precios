jQuery(document).ready(function() {
    $("#titlePrincipal").html("CAMBIOS DE PRECIOS");
    getRojos();
});
var del_row = 0;


function getRojos(){
    var fecha = "";
    $(".tbodyCompa").html("");

    getRojosCompras().done(function(resp){
        console.log(resp)
        if(resp){
            $.each(resp,function(index,value){
                if(fecha != value.fecha ){
                    fecha = value.fecha;
                    $(".tbodyCompa").append('<tr><th class="th1" style="width:100px" rowspan="2">OBSERVACIONES</th><th class="th1" colspan="3">'+formatDate2(value.fecha)+'</th>'+
                                    '<th class="thE" style="width:100px" colspan="2">DATOS EXCEL</th>'+
                                    '<th class="th1" style="width:100px" rowspan="2">CANTIDAD</th><th class="th1" style="width:100px" rowspan="2">COSTO <br>FINAL</th>'+
                                    '<th class="th1" style="width:100px" rowspan="2">IVA</th><th class="th1" style="width:100px" rowspan="2">RENGLON<br>10</th>'+
                                    '<th class="th2" colspan="5">NUEVOS PRECIOS</th>'+
                                    '</tr><tr><th class="th1" style="width:100px" >TIPO</th>'+
                                    '<th class="th1" style="width:100px" >CÓDIGO</th><th class="th1" style="width:350px" >DESCRIPCIÓN</th>'+
                                    '<th class="thE" style="width:100px" >UM</th><th class="thE" style="width:100px" >COSTO</th>'+
                                    '<th class="th2" style="width:100px" >PRECIO 1</th>'+
                                    '<th class="th2" style="width:100px" >PRECIO 2</th><th class="th2" style="width:100px" >PRECIO 3</th><th class="th2" style="width:100px" >PRECIO 4</th>'+
                                    '<th class="th2" style="width:100px" >PRECIO 5</th></tr>');
                }
                value.pre1 = isnulo(value.pre1);value.pre2 = isnulo(value.pre2);value.pre3 = isnulo(value.pre3);value.pre4 = isnulo(value.pre4);value.pre5 = isnulo(value.pre5);
                value.cantidad = isnulo(value.cantidad);value.iva = isnulo(value.iva);value.costo2 = isnulo(value.costo2);value.costo = isnulo(value.costo);
                var boton = '';
                var tipo = "AJUSTE";
                var bckclr = 'style="background:#fff"';

                if(value.estatus == 3){
                    tipo = "CÓDIGO <br>SIN REGISTRO";
                    boton = '<button type="button" class="btn btn-outline-danger rojoBtn" data-id-rojo="'+value.id_rojo+'" data-toggle="modal" data-target="#kt_modal_row">Eliminar</button>';
                    bckclr = 'style="background:#ffb0b0"';
                    if(value.costo == "" || value.costo == 0){
                        tipo = "CAMBIO DE <br>DESCRIPCIÓN NO SE <br>ENCUENTRA CÓDIGO";
                    }
                    value.um_nuevo = "";
                }else if(value.estatus == 2){
                    tipo = "PRECIOS ACTUALIZADOS";
                    bckclr = 'style="background:#b5ffb0"';
                    value.um_nuevo = "";
                }else if(value.estatus == 1){
                    tipo = "PENDIENTE";
                    bckclr = 'style="background:#feffb0"';
                    boton = '<button type="button" class="btn btn-outline-danger rojoBtn" data-id-rojo="'+value.id_rojo+'" data-toggle="modal" data-target="#kt_modal_row">Eliminar</button>';
                    value.um_nuevo = "";
                }else if(value.estatus == 4){
                    tipo = "ALTA<br>PRODUCTO";
                    bckclr = 'style="background:#e4b0ff"';
                    boton = '<button type="button" class="btn btn-outline-danger rojoBtn" data-id-rojo="'+value.id_rojo+'" data-toggle="modal" data-target="#kt_modal_row">Eliminar</button>';
                    if(isnulo(value.desco2) != ""){
                        value.descripcion = value.descripcion+"<br><span class='spandif2'>"+value.desco2+"</span>";
                    }
                }else if(value.estatus == 5){
                    tipo = "CAMBIO <br>DESCRIPCIÓN";
                    bckclr = 'style="background:#FFF"';
                    boton = '<button type="button" class="btn btn-outline-danger rojoBtn" data-id-rojo="'+value.id_rojo+'" data-toggle="modal" data-target="#kt_modal_row">Eliminar</button>';
                    value.descripcion = value.descripcion+"<br><span class='spandif'>"+value.desco+"</span>";
                    value.um_nuevo = "";
                }else if(value.estatus == 6){
                    tipo = "ALTA <br>CÓDIGO YA<br>EXISTE";
                    bckclr = 'style="background:#ffb0b0"';
                    boton = '<button type="button" class="btn btn-outline-danger rojoBtn" data-id-rojo="'+value.id_rojo+'" data-toggle="modal" data-target="#kt_modal_row">Eliminar</button>';
                    value.descripcion = value.descripcion+"<br><span class='spandif2'>"+value.desco+"</span>";
                }
                var renglon10 = ( value.costo2/value.cantidad ) / ( 1+(value.iva/100) );
                renglon10 = value.costo2 == 0 ? "" : formatMoney(renglon10,4);
                $(".tbodyCompa").append('<tr class="trDel'+value.id_rojo+'"><td style="background:#FFF">'+boton+'</td>'+
                    '<td '+bckclr+'>'+tipo+'</td><td '+bckclr+'>'+value.codigo+'</td><td '+bckclr+' class="descos">'+value.descripcion+'</td>'+
                    '<td class="thE2">'+value.um_nuevo+'</td><td class="thE2 preC">'+value.costo+'</td>'+
                    '<td>'+value.cantidad+'</td><td '+difPz(value.costo2,value.costo)+'>'+value.costo2+'</td>'+
                    '<td class="ivaClass">'+value.iva+'</td><td class="renglon10Class" '+difPz(value.costo2,renglon10)+'>'+renglon10+'</td>'+
                    '<td class="preC" '+difPz(value.pre1,value.pre2)+'>'+value.pre1+'<br><span class="spandif">'+difo(value.costo,value.pre1)+'</span></td>'+
                    '<td class="preC" '+difPz(value.pre2,value.pre3)+'>'+value.pre2+'<br><span class="spandif">'+difo(value.costo,value.pre2)+'</span></td>'+
                    '<td class="preC" '+difPz(value.pre3,value.pre4)+'>'+value.pre3+'<br><span class="spandif">'+difo(value.costo,value.pre3)+'</span></td>'+
                    '<td class="preC" '+difPz(value.pre4,value.pre5)+'>'+value.pre4+'<br><span class="spandif">'+difo(value.costo,value.pre4)+'</span></td>'+
                    '<td class="preC">'+value.pre5+'<br><span class="spandif">'+difo(value.costo,value.pre5)+'</span></td>'+
                    '</tr>')
            })
        }
    })
}

var theDate = new Date().getTime();
Dropzone.autoDiscover = false;

var myDropzoneExcel = new Dropzone("div#kt_dropzone_uno", {
    paramName: "file_excel",
    maxFiles: 1,
    maxFilesize: 200, 
    timeout: 1800000,
    renameFilename: function (filename) {
        return filename;
    },
    url: site_url+"Compras/upload_excel",
    autoProcessQueue: true,
    queuecomplete: function (resp) {
        toastr.options = {
              "closeButton": true,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-top-right",
              "preventDuplicates": false,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "1000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
        };
    },
    success: function(file, response){
        var dt = new Date();
        var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
        myDropzoneExcel.removeAllFiles();
        getRojos();
        if(response === "Documento incorrecto"){
            toastr.error("Por favor revise el txt que se subió a la plataforma","Archivo incorrecto");
        }else{
            toastr.success("Se cargarón correctamente los datos","Listo");
        }
        
    }
});

function getRojosCompras() {
    return $.ajax({
        url: site_url+"Compras/getRojosCompras",
        type: "POST",
        cache: false,
    });
}

function isnulo(vlo){
    vlo = vlo == null ? "" : vlo;
    return vlo;
}
function difo(vlo1,vlo2){
    if (vlo2 == ""){
        return "";    
    }else{
        return formatMoney(parseFloat(vlo2)-parseFloat(vlo1));
    }  
}

$(document).off("click", ".rojoBtn").on("click", ".rojoBtn", function(event) {
    event.preventDefault();
    del_row = $(this).data("idRojo");
});

$(document).off("click", ".del_row").on("click", ".del_row", function(event) {
    event.preventDefault();
    delRowRojo().done(function(resp){
        $(".trDel"+del_row).html("");
        $('#kt_modal_row').modal('hide');
    })
});

function delRowRojo() {
    return $.ajax({
        url: site_url+"Compras/delRowRojo/"+del_row,
        type: "POST",
        cache: false,
    });
}

function difPz(costo,precio){
    if(parseFloat(costo) < parseFloat(precio)){
        return 'style="background:red"';
    }else{
        return "";
    }
}