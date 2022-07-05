var obj = {};
obj.detalle = [];
obj.prove = [];
obj.folio = [];
var saving = true;
jQuery(document).ready(function() {
    $("#titlePrincipal").html("PRODUCTOS RECIBIDOS");
    $(".folioFacto").focus();
    KTInputmask.init();
});


$(document).off("keyup",".folioFacto").on("keyup",".folioFacto",function(event){
    event.preventDefault();
    var dis = $(this)
    if(event.keyCode == 13){
        if( dis.val() == "" || dis.val() == " " ){
            toastr.error("AGREGA UN FOLIO");
            $("#txt1").attr("style","color:#F64E60 !important")
        }else{
            $(".proveeFacto").focus();
            $("#txt1").attr("style","color:#B5B5C3 !important")
        }
    }
})

$(document).off("keyup",".proveeFacto").on("keyup",".proveeFacto",function(event){
    event.preventDefault();
    var dis = $(this)
    if(event.keyCode == 13){
        if( dis.val() == "" || dis.val() == " " ){
            toastr.error("AGREGA UN PROVEEDOR");
            $("#txt2").attr("style","color:#F64E60 !important")
        }else{
            $(".codeProd").focus();
            $("#txt2").attr("style","color:#B5B5C3 !important")
        }
    }
})

$(document).off("keyup",".codeProd").on("keyup",".codeProd",function(event){
    event.preventDefault();
    var dis = $(this)
    if(event.keyCode == 13){
        if( dis.val() == "" || dis.val() == " " ){
            toastr.error("AGREGA UN PRODUCTO");
            $("#txt3").attr("style","color:#F64E60 !important")
        }else{
            $(".cantProd").focus();
            $("#txt3").attr("style","color:#B5B5C3 !important")
        }
    }


})

$(document).off("keyup",".cantProd").on("keyup",".cantProd",function(event){
    event.preventDefault();
    var codeprod = $(".codeProd");
    var cantprod = $(this);
    
    if(event.keyCode == 13){
        if( $(".codeProd").val() == "" || $(".codeProd").val() == " "){
            toastr.error("AGREGA UN PRODUCTO");
            $("#txt3").attr("style","color:#F64E60 !important");
            codeprod.focus();
        }else{
            $("#txt3").attr("style","color:#B5B5C3 !important")
            if(cantprod.val() == "" || cantprod.val() == " "){
                toastr.error("AGREGA UNA CANTIDAD");
                $("#txt4").attr("style","color:#F64E60 !important");
            }else{
                $("#txt4").attr("style","color:#B5B5C3 !important")
                buscaleProd( codeprod.val() ).done(function(resp){
                    console.log(resp)
                    var desco = "";var ides = 222;var nomo = "SIN RELACIÓN";
                    if(resp){
                        desco = resp[0].nombre;
                        ides = resp[0].id_producto;
                        nomo = resp[0].nombre;
                    }
                    obj.detalle.push({"codigo": codeprod.val(),"cantidad":cantprod.val().split(',').join(""),"identifico":ides,"nombre":nomo})
                    $(".tbodyPreFacto").append("<tr><td>"+codeprod.val()+"</td><td>"+desco+"</td><td>"+formatMoney(cantprod.val())+"</td><td><button type='button' class='btn btn-primary font-weight-bold btn-square deletenote'>ELIMINAR RENGLÓN</button></td></tr>")
                    $(".codeProd").val("");cantprod.val("");
                    codeprod.focus();
                    var noprod = parseInt($(".noprods").html()); 
                    $(".noprods").html(noprod + 1)
                })
                
            }

        }
    }
})

function buscaleProd(valos = "") {
    return $.ajax({
        url: site_url+"/Facturas/buscaleProd/"+valos,
        type: "POST",
        cache: false,
    });
}


// Class definition

var KTInputmask = function () {
    var demos = function () {
        $(".cantProd").inputmask('decimal', {
            rightAlignNumerics: false
        });
    }

    return {
        init: function() {
            demos();
        }
    };
}();

$(document).off("click", ".deletenote").on("click", ".deletenote", function(event){
    event.preventDefault();
    var i = $('.tbodyPreFacto tr').index($(this).closest('tr'));
    obj.detalle.splice(i, 1);
    var row =$(this).closest("tr").remove();

    var noprod = parseInt($(".noprods").html()); 
    $(".noprods").html(noprod - 1)
    console.log(obj.detalle)
});


$(document).keydown(function (e) {
    if(e.ctrlKey && e.keyCode == 77){
        saveTheMDF();
    }
});


function saveTheMDF(){
    if(obj.detalle.length !== 0){
        if ($(".folioFacto").val() !== "" && $(".folioFacto").val() !== " ") {
            obj.prove = {'proveedor': $(".proveeFacto").val()};
            obj.folio = {'folio': $(".folioFacto").val()};
            if(saving){
                saving = false;
                saveNota(JSON.stringify(obj)).done(function(resp){
                    if(resp){
                        toastr.success("SE GUARDO CORRECTAMENTE")
                        location.reload()
                    }else{
                        toastr.error("HUBO UN ERROR INTENTALO NUEVAMENTE")
                    }
                })
            }else{
                toastr.warning("SE ESTA GUARDANDO LA ANTERIOR, ESPERE UN MOMENTO POR FAVOR")
            }
        }else{
            toastr.error("AGREGA UN FOLIO PARA QUE RECUERDES LA NOTA");
        }
    }else{
        toastr.error("AGREGA AL MENOS UN PRODUCTO");
    }
}


$(document).off("click", ".saveNote").on("click", ".saveNote", function(event){
    event.preventDefault();
    saveTheMDF();
});

function saveNota(values){
    return $.ajax({
        url: site_url+"/Facturas/saveNota",
        type: "POST",
        dataType: "JSON",
        data: {
            values : values
        },
    });
}