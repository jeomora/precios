'use strict';
var dataJSONArray = "";
var datatable = "";
var datos = "";
jQuery(document).ready(function() {
    $("#titlePrincipal").html("REPORTE MOVIMIENTO PRODUCTOS");
});
 

 $(document).off("keydown","#kardexSearch").on("keydown","#kardexSearch",function(event){
    event.preventDefault();
    var busca = $(this);
    var values = { "busca":busca.val() }
    buscaKardex(JSON.stringify( values ))
})

 function buscaKardex(datos) {
    return $.ajax({
        url: site_url+"Reporte/buscaKardex",
        type: "POST",
        cache: false,
        data:{
            values:datos
        }
    });
}