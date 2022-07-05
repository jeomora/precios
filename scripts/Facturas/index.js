var factos = []
jQuery(document).ready(function() {
    $("#titlePrincipal").html("BUSCAR FACTURAS");
    printPrenotas();
});

function searchFactos(valos = "") {
    return $.ajax({
        url: "http://aztecadmin.com/AndroidApi/searchFactos/"+valos,
        type: "POST",
        cache: false,
    });
}

$(document).off("click","#buscofactos").on("click","#buscofactos",function(event){
    event.preventDefault();
    var dis = $(this);var busca = $(".fieldFactos").val();
    buscabusca(dis,busca)
    
})

$(document).off("click",".clickFacto").on("click",".clickFacto",function(event){
    event.preventDefault();
    var dis = $(this);
    searchDetails( dis.data("idRojo") ).done(function(resp){
        $(".resolF").html("");
        $(".labelFacto").html("FACTURA FOLIO "+dis.data("idFolio"));
        $(".fieldFactos").val("");
        $(".tbodyFacto").html("")
        $(".detaFacto").css("display","block");
        $(".buscFacto").css("display","none");
        $(".codeCaja").css("display","initial")
        if(resp){
            $.each(resp,function(index,value){
                $(".tbodyFacto").append("<tr class='rowFacto"+(index+1)+"' data-id-rojo='"+index+"'><td>"+value.identificacion+"</td><td>"+value.descripcion+"</td>"+
                    "<td><div class='btn btn-icon btn-sm btn-success font-weight-bolder p-0 choosePF' data-id-rojo='"+(index+1)+"'>"+(index+1)+"</div></td>"+
                   // "<td><div class='input-group'><div class='input-group-prepend'><button class='btn btn-success btnBuscaFacto' type='button' data-toggle='modal' data-target='#modalBuscaf'><i class='text-dark flaticon-search'></i></button></div>"+
                    //"<input type='text' class='form-control codeCaja' placeholder='CODIGO COMPUCAJA'/></div></td><td></td>"+
                    "<td>"+value.cantidad+"</td><td>"+value.unidad+"</td><td>$ "+formatMoney(value.importe)+"</td>")
                factos[index] = {"cantidad":value.cantidad+" "+value.unidad,"codigo":value.identificacion,"nombre":value.descripcion}
            })
        }
    })
})

$(document).off("keyup",".fieldFactos").on("keyup",".fieldFactos",function(event){
    event.preventDefault();
    var dis = $(this);var busca = $(".fieldFactos").val();
    if(event.keyCode == 13){
        buscabusca(dis,busca)
    }
})

function buscabusca(dis,busca){
    if (busca ==  "" || busca ==  " " || busca ==  "  "){
        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        };

        toastr.warning("Es necesario un parámetro de búsqueda", "Ingrese un folio");
    }else{
        $(".resolF").html("<h1 class='text-success'>BUSCANDO....</h1>")
        $("#buscofactos").attr("disabled","disabled");
        searchFactos( busca ).done(function(resp){
            $("#buscofactos").removeAttr("disabled");
            if(resp){
                $(".resolF").html("")
                $.each(resp,function(index,val){
                    $(".resolF").append('<div class="d-flex align-items-center"><span class="bullet bullet-bar bg-success align-self-stretch"></span><label class="checkbox checkbox-lg checkbox-light-success checkbox-inline flex-shrink-0 m-0 mx-4">'+
                                '</label><div class="d-flex flex-column flex-grow-1"><a class="text-dark-75 text-hover-primary font-weight-bold font-size-lg mb-1 clickFacto" data-id-rojo="'+val.id_factura+'" data-id-folio="'+val.folio+'">'+val.folio+
                                '</a><span class="text-muted font-weight-bold">'+val.nombre+'</span><span class="text-muted font-weight-bold">$ '+formatMoney(val.total)+'</span></div></div>');
                })
            }else{
                $(".resolF").html("<h1 class='text-primary'>SIN RESULTADOS</h1>")
            }
        })    
    }
}

function searchDetails(valos = "") {
    return $.ajax({
        url: "http://aztecadmin.com/AndroidApi/searchDetails/"+valos,
        type: "POST",
        cache: false,
    });
}


$(document).off("click",".seeFacto").on("click",".seeFacto",function(event){
    event.preventDefault();
    $(".tbodyBuscaP").html("")
    var dis = $(this);
    prenotab(dis.data("idRojo")).done(function(resp){
        if(resp){
            $.each(resp,function(index,val){
                
                $(".tbodyBuscaP").append('<tr class="preNTr preNTr'+val.id_prenota+'"><td>'+val.codigo+'</td><td>'+val.cantidad+'</td><td>'+val.pcodigo+'</td><td>'+val.pnombre+'</td><td>'+val.ides+'</td><td>$ '+formatMoney(isnulo(val.preciocinco))+'</td>'+
                    '<td class="tdcode'+val.id_prenota+'"><input type="text" class="form-control codeCaja codeCaja'+val.id_prenota+'" placeholder="IDES FACTURA" data-id-rojo="'+val.id_prenota+'"/><span class="codeCajaSpan'+val.id_prenota+'"></span></td>'+
                    '<td class="tdname'+val.id_prenota+'"></td><td class="tdcant'+val.id_prenota+'"></td><td></td></tr>')
            })
        }
    })

})

$(document).off("keyup",".buscaProd").on("keyup",".buscaProd",function(event){
    event.preventDefault();
    var dis = $(this);
    setTimeout(function(){
        $(".tbodyBuscaP").html("<td colspan='4'>BUSCANDO</td>")
        buscaProdF( dis.val() ).done(function(resp){
            if(resp){
                $(".tbodyBuscaP").html("");
                $.each(resp,function(index,val){
                    $(".tbodyBuscaP").append("<tr><td>"+val.codigo+"</td><td>"+val.nombre+"</td><td>"+val.unidad+"</td><td>$ "+formatMoney(val.precio)+"</td></tr>")
                })
            }else{
                $(".tbodyBuscaP").html("<td colspan='4'>SIN RESULTADOS</td>")
            }
        })
    },500)
})


function buscaProdF(valos = "") {
    return $.ajax({
        url: site_url+"/Facturas/buscaProdF/"+valos,
        type: "POST",
        cache: false,
    });
}


function misPrenotas(valos = "") {
    return $.ajax({
        url: site_url+"/Facturas/misPrenotas",
        type: "POST",
        cache: false,
    });
}

function printPrenotas(){
    misPrenotas().done(function(resp){
        if(resp){
            
            var folio = "";var printo = "";var iden =0;var flag = 0;var fecha = "";var nomos = "";
            $.each(resp,function(index,val){
                val.nombre = val.nombre == null ? "SIN RELACIÓN" : val.nombre;
                if(folio !== val.folio){
                    if(flag !== 0){
                        printo += nomos+'</p><div class="mb-7"><div class="d-flex justify-content-between align-items-center"><span class="text-dark-75 font-weight-bolder mr-2">'+formatDate(fecha)+'</span>'+
                                '</div><div class="d-flex justify-content-between align-items-cente my-1"><span class="text-dark-75 font-weight-bolder mr-2">NUMERO DE PRODUCTOS:</span><a class="text-muted text-hover-primary">'+flag+'</a></div></div>'+
                                '<a class="btn btn-block btn-sm btn-light-success font-weight-bolder text-uppercase py-4 seeFacto" data-id-rojo="'+iden+'" data-toggle="modal" data-target="#modalDetailsF">VER MÁS</a></div></div></div>';
                    }
                    iden = val.identificador;
                    printo += '<div class="col-xl-2"><div class="card card-custom gutter-b card-stretch" style="box-shadow:0px 0px 30px 0px rgb(82 63 105 / 42%);"><div class="card-body pt-4"><div class="d-flex justify-content-end">'+
                            '</div><div class="d-flex align-items-end mb-7"><div class="d-flex align-items-center"><div class="flex-shrink-0 mr-4 mt-lg-0 mt-3"><div class="symbol symbol-lg-75 symbol-circle symbol-primary btn-light-success">'+
                            '<span class="font-size-h3 font-weight-boldest text-success">'+val.identificador+'</span></div></div><div class="d-flex flex-column"><a class="text-dark font-weight-bold text-hover-primary font-size-h4 mb-0">'+val.folio+'</a>'+
                            '<span class="text-muted font-weight-bold">'+val.proveedor+'</span></div></div></div><p class="mb-7">- '+(val.nombre)+'<br>';
                            fecha = val.fecha_registro;
                    flag = 1;folio = val.folio;nomos = "";
                }else{
                    flag++;
                    if(flag <= 4){
                        nomos += '- '+val.nombre+'<br>';
                    }
                }
            })
            printo += nomos+'</p><div class="mb-7"><div class="d-flex justify-content-between align-items-center"><span class="text-dark-75 font-weight-bolder mr-2">FECHA : </span><a class="text-muted text-hover-primary">'+formatDate(fecha)+'</a>'+
                                '</div><div class="d-flex justify-content-between align-items-cente my-1"><span class="text-dark-75 font-weight-bolder mr-2">NUMERO DE PRODUCTOS:</span><a class="text-muted text-hover-primary">'+flag+'</a></div></div>'+
                                '<a class="btn btn-block btn-sm btn-light-success font-weight-bolder text-uppercase py-4 seeFacto" data-id-rojo="'+iden+'" data-toggle="modal" data-target="#modalDetailsF">VER MÁS</a></div></div></div>';
            $(".prenots").html(printo)
        }else{
            $(".prenots").html("<h1>NO SE HAN REGISTRADO FACTURAS EN ÁREA DE MAYOREO</h1>")
        }
    })
}

function prenotab(valos = "") {
    return $.ajax({
        url: site_url+"/Facturas/prenotab/"+valos,
        type: "POST",
        cache: false,
    });
}

function isnulo(vlo){
    vlo = vlo == null ? 0 : vlo;
    return vlo;
}
//CUANDO ASIGNAS UN PRODUCTO DE LA FACTURA AL DE LA PRENOTA
$(document).off("keyup",".codeCaja").on("keyup",".codeCaja",function(event){
    event.preventDefault();
    var dis = $(this);
    if(event.keyCode == 13){
        var linea2 = dis.val();        
        var linea1 = dis.data("idRojo");

        if( $(".rowFacto"+linea2).css("display") == "none" ){
            toastr.warning("YA ASIGNO ESTE IDE")
        }else{
            $(".codeCajaSpan"+linea1).html( '<div>'+factos[linea2].codigo+'</div><div><div class="btn btn-icon btn-light btn-hover-primary btn-sm btnSpan btnSpan'+linea1+'" data-id-rojo="'+linea1+'" data-id-folio="'+linea2+
            '"><span class="svg-icon svg-icon-md svg-icon-primary"><i class="flaticon2-cancel-music"></i></div></div>' )
            $(".codeCaja"+linea1).css("display","none")
            $(".tdname"+linea1).html( factos[linea2].nombre )
            $(".tdcant"+linea1).html( factos[linea2].cantidad )
            $(".rowFacto"+linea2).css("display","none");
        }

    }
})
//CAMBIAR PRODUCTO DE FACTURA ASOCIADO AL DE LA PRENOTA
$(document).off("click",".btnSpan").on("click",".btnSpan",function(event){
    var dis = $(this);
    var linea1 = dis.data("idRojo");
    var linea2 = dis.data("idFolio");
    $(".codeCajaSpan"+linea1).html("")
    $(".codeCaja"+linea1).css("display","initial")
    $(".codeCaja"+linea1).val("")
    $(".tdname"+linea1).html( "" )
    $(".tdcant"+linea1).html( "" )
    $(".rowFacto"+linea2).removeAttr("style");
})