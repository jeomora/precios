'use strict';
var rojosArray = [];
var almacena = [];
var descChange = 0;
var idLinea = 0;
var clave = "";
jQuery(document).ready(function() {
    getMeClave().done(function(resp){

        if(resp){
            clave = diccionario(resp.access)+"\r";
            console.log(clave)
        }
        startQr()
    })    
});

function startQr(){
    qrmeOf().done(function(resp){
        
        if(resp){
            var codeqr2 = "";
            $.each(resp,function(index,value){
                var liston = "MARCAR HECHO";var cliston = "btnlistos btn btn-outline-info";var fore = "#3F47CC"
                if(value.liston != null && value.liston != 0){
                    liston = "HECHO";
                    cliston = "btnlistos2 btn btn-info"
                    fore = "#1BC5BD"
                }
                var codeqr = givePZ(value,index);
                $('#outtxt'+index).html("<h3 class='font-weight-bolder mb-1'><a class='text-dark' style='font-size:55px'>"
                    +value.nombre+"</a></h3><div class='text-dark mb-9' style='font-size:50px'>"+value.codigo+"</div><div class='col-md-12' style='text-align:center'><button type='button' data-id-rojo='"+value.id_oferta+
                    "' class='"+cliston+"'>"+liston+"</button></div>")
                
                $('#output'+index).qrcode({
                    render: "canvas", 
                    text: codeqr, 
                    width: 720,
                    height: 720,
                    background: "#FFFFFF",
                    foreground: ""+fore,

                })
            })
                
            
        }
    })
}

$(document).off("click",".btnlistos").on("click",".btnlistos",function(event){
    event.preventDefault();
    var dis = $(this)
    var idrojo = dis.data("idRojo");
    dis.closest(".card.card-custom").css("background","#1BC5BD")
    if(dis.html() == "MARCAR HECHO"){
        dis.html("HECHO");
        setListo(1,idrojo)
        dis.attr("class","btnlistos2 btn btn-success");
    }
})

function qrmeOf() {
    return $.ajax({
        url: site_url+"Codigos/qrmeOf/"+window.location.pathname.split("/").pop(),
        type: "POST",
        cache: false,
    });
}

function getMeClave() {
    return $.ajax({
        url: site_url+"Codigos/getMeClave",
        type: "POST",
        cache: false,
    });
}

function givePZ(value,index){
    var reso = ["",""];

    var iva = "\r\n";var cajas = true;
    if(value.iva == "0.00" || value.iva == "0"){
        value.iva = "\r\rN";
    }else{
        value.iva = value.iva+"\r";
    }

    if (value.code3 == "0" || value.code3 == null || value.code3 == 0){
        value.desc2 = value.desc1;
        cajas = false;
    }
    var precinco = parseFloat((value.costo / value.cantidad),2);
    precinco += 0.01; 
    var renglon10 = value.costopz / ( 1+(value.iva/100) );
    var codeqr = "\x05A\x06b"+value.codigo+"\r\nc17\r\n"+iva+value.precio+"\r\n\n\n\r\r\n\n\n\r\r\n\r\r\r\r\r\rT";

    if(value.ums == 2 || value.ums == 5 || value.ums == 7 || value.ums == 12 || value.ums == 2 || value.ums == 3 || value.ums == 10){
        codeqr = "\x05B\x06b"+value.code3+"\r\nc"+clave+"1\r\n\x1911\r\n"+iva+value.precio+"\r\n\n\n\r\r\n\n\n\r\r\n\r\r\r\r\r\rT"
    }


    return codeqr;
}

function setListo(val1,val2) {
    return $.ajax({
        url: site_url+"Uploads/setListoOf/"+val1+"/"+val2,
        type: "POST",
        cache: false,
    });
}


function diccionario(vals){
    
    var valo = "";
    for (var i = 0; i <= vals.length-1; i++) {
        switch(vals[i]){
            case "#":
                valo += "#";//"\x0335\x04";
            break;
            case "-":
                valo += "/"
            break;
            case "'":
                valo += "-"
            break;
            case ";":
                valo += "<"
            break;
            case "ñ":
                valo += ";"
            break;
            case ")":
                valo += "("
            break;
            case "=":
                valo += ")"
            break;
            case "(":
                valo += "*"
            break;
            case "&":
                valo += "^"
            break;
            case ":":
                valo += ">"
            break;
            case "?":
                valo += "_"
            break;
            case "_":
                valo += "?"
            break;
            case "+":
                valo += "]"
            break;
            case "/":
                valo += "&"
            break;
            case '^':
                valo += "{"
            break;
            case '*':
                valo += "}"
            break;
            case '`':
                valo += "["
            break;
            case '"':
                valo += "@"
            break;
            default:
                valo += vals[i];
            break;
        }
    }
    return valo;
}
    
