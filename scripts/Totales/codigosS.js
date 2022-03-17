'use strict';
var rojosArray = [];
var almacena = [];
var descChange = 0;
var clave = "";
var printo = 1;var print = 1;
jQuery(document).ready(function() {

    getMeClave().done(function(resp){

        if(resp){
            if(resp.access == ""){
                clave = ""
            }else if(resp.access == null){
                clave = ""
            }else{
                clave = diccionario(resp.access)+"\r";
            }
        }
        doIPrint();
    })
});

function doIPrint(){
    getSucuEtiqueta().done(function(resp){
        if(resp){
            printo = resp.manyp;
            print = resp.printo;
        }else{
            printo = 1;
            print = 1;
        }
        startQr()
    })
}
function startQr(){
    qrmeup().done(function(resp){
        console.log(resp)
        
        if(resp){
            var codeqr2 = "";
            $.each(resp,function(index,value){
                var iva = "\r\n";var cajas = true;
                if(value.iva == "0.00" || value.iva == "0"){
                    iva = "\r\nn\r";
                }
                if (value.desc2 == "" || value.desc2 == null){
                    value.desc2 = value.desc1;
                    cajas = false;
                }
                var deco1  = value.desc1;var deco2 = value.desc2;
                value.desc1 = diccionario(value.desc1);
                value.desc2 = diccionario(value.desc2);
                var precinco = parseFloat((value.costo / value.cantidad),2);
                precinco += 0.01; 
                var renglon10 = value.costopz / ( 1+(value.iva/100) );

                var codeqr = givePZ(value,index);
                //codeqr += "\x05A\x06b"+value.code1+"\r\nc10\r"+renglon10+"\r\r17\r\n"+iva+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+"\r\n\n\n"+value.pre44+"\r\n\n\n"+value.costopz+"\r\n\r\n";
                //codeqr+="c4\r"
                var liston = "MARCAR HECHO";var cliston = "btnlistos btn btn-outline-success";var fore = "#3F47CC"
                if(value.liston != null && value.liston != 0){
                    liston = "HECHO";
                    cliston = "btnlistos2 btn btn-success"
                    fore = "#1BC5BD"
                }
                
                $('#outtxt'+index).html("<h3 class='font-weight-bolder mb-1'><a class='text-black' style='font-size:55px'>"
                    +deco1+"</a></h3><div class='text-black mb-9' style='font-size:50px'>"+value.code1+"</div><div class='text-black mb-9' style='font-size:35px'>Existencia: "+value.existencia+"</div>"+
                    "<div class='col-md-12' style='text-align:center'></div>")
                if(value.pre11 <= 0 ){
                    $('#outtxt'+index).append("<h1>EL <span style='font-weight:bold'>PRECIO 1</span> APARECE EN CEROS, POR FAVOR REVISE EL PRECIO E INTENTELO NUEVAMENTE</h1>")
                    $('#outtxt'+index).css("color","black")
                }else if(value.pre22 <= 0 ){
                    $('#outtxt'+index).append("<h1>EL <span style='font-weight:bold'>PRECIO 2</span> APARECE EN CEROS, POR FAVOR REVISE EL PRECIO E INTENTELO NUEVAMENTE</h1>")
                    $('#outtxt'+index).css("color","black")
                }else if(value.pre33 <= 0 ){
                    $('#outtxt'+index).append("<h1>EL <span style='font-weight:bold'>PRECIO 3</span> APARECE EN CEROS, POR FAVOR REVISE EL PRECIO E INTENTELO NUEVAMENTE</h1>")
                    $('#outtxt'+index).css("color","black")
                }else if(value.pre44 <= 0 ){
                    $('#outtxt'+index).append("<h1>EL <span style='font-weight:bold'>PRECIO 4</span> APARECE EN CEROS, POR FAVOR REVISE EL PRECIO E INTENTELO NUEVAMENTE</h1>")
                    $('#outtxt'+index).css("color","black")
                }else if(value.pre55 <= 0 ){
                    $('#outtxt'+index).append("<h1>EL <span style='font-weight:bold'>PRECIO 5</span> APARECE EN CEROS, POR FAVOR REVISE EL PRECIO E INTENTELO NUEVAMENTE</h1>")
                    $('#outtxt'+index).css("color","black")
                }else if(value.rdiez <= 0 ){
                    $('#outtxt'+index).append("<h1>EL <span style='font-weight:bold'>PRECIO DEL RENGLON 10</span> APARECE EN CEROS, POR FAVOR REVISE EL PRECIO E INTENTELO NUEVAMENTE</h1>")
                    $('#outtxt'+index).css("color","black")
                }else{
                    $('#outtxt'+index).append("<button type='button' data-id-rojo='"+value.id_detail+"' class='"+cliston+"'>"+liston+"</button>")
                    if (codeqr.indexOf("...") >= 0){
                        $('#outtxt'+index).css("color","red")
                        var code1 = codeqr.substr(0, codeqr.indexOf('...')); 
                        $('#output'+index).qrcode({
                            encoding:"UTF-8",
                            render: "canvas", 
                            text: code1, 
                            width: 720,
                            height: 720,
                            background: "#FFFFFF",
                            foreground: ""+fore,
                        })
                        var code2 = codeqr.substr(codeqr.indexOf('...')+3); 
                        $('#outputs'+index).qrcode({
                            render: "canvas", 
                            text: code2, 
                            width: 720,
                            height: 720,
                            background: "#FFFFFF",
                            foreground: ""+fore,
                        })
                    }else{
                        $('#outtxt'+index).css("color","blue")
                        $('#output'+index).qrcode({
                            encoding:"UTF-8",
                            render: "canvas", 
                            text: codeqr, 
                            width: 720,
                            height: 720,
                            background: "#FFFFFF",
                            foreground: ""+fore,

                        })
                    }
                }
                    

                
            })
                
            
        }
    })
}
function qrmeup() {
    return $.ajax({
        url: site_url+"Codigos/qrmeup/"+window.location.pathname.split("/").pop(),
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
    var imprime = "i1\r"
    if(value.existencia == null || value.existencia == 0 || value.existencia == ""){
        imprime = "";
    }else{
        if(print == 0){
            imprime = "";
        }else{
            imprime = "i"+printo+"\r"
        }
        if(value.linea == "SE" || value.linea == "77"){
            imprime = "";
        }
    }
    
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
    //value.desc1 = value.desc1.replace(/\//g,"&")
    //value.desc2 = value.desc2.replace(/\//g,"&")

    var precinco = parseFloat((value.costo / value.cantidad),2);
    precinco += 0.01; 
    var renglon10 = value.costopz / ( 1+(value.iva/100) );
    var codeqr = "\x05A\x06b"+value.code1+"\r\nc10\r"+value.rdiez+"\r\r17\r\n"+iva+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+"\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r\n\r\n";
    //codeqr = "\x05A\x06b"+value.code1+"\r\n";
    var codeqr2 = ""//"t";
    //codeqr+="c4\r"

    if(cajas){
        codeqr2 = "\x05B\x06b"+value.code3+"\r\nc"+clave+"1\r\n\x1911\r\n\n\n"+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+"\r\n\n\n"+value.pre5+"\r\n"
    }
    if(typeof(almacena[value.blues]) == "undefined" && almacena[value.blues] == null){
        almacena[value.blues] = "";
    }
    if(value.blues != 0){
        almacena[value.blues] += ""+value.code1+"\r"+value.cantidad+"\r";
    }
    var cajaAlta = "";

    value.estatus = yaAgregados(value,index)

    switch( parseInt(value.estatus) ){
        case 2:
            reso = ["cambioDe",""]; //2 EDITAR PZ 
            codeqr+="c4\r\x09"+value.desc1+"\r18\r"+value.code2+"\r\n\r"+imprime+"t"
            codeqr += codeqr2;
            break;
        case 3:
            reso = ["","cambioDe"];//3 EDITAR CAJA 
            codeqr2 += "3\r\x09"+value.desc2+"\r\n\rt"
            codeqr += codeqr2+""+imprime+"t";
            break;
        case 4:
            reso = ["cambioDe","cambioDe"];//4 EDITAR PZ Y CAJA 
            codeqr+="c4\r\x09"+value.desc1+"\r18\r"+value.code2+"\r\n\r"+imprime+"t"
            codeqr2 += "3\r\x09"+value.desc2+"\r\n\x01t";
            codeqr+=codeqr2;
            break;
        case 5:
            reso = ["cambioDe","eliminDe"];//5 EDITAR PZ Y ELIM CAJA 
            codeqr+="c4\r\x09"+value.desc1+"\r18\r"+value.code2+"\r\n\r"+imprime+"t"
            codeqr2 = "\x05B\x06b"+value.code3+"\r\neS\rtt"//"\x05D\x0600\r"+value.linea+"\r"+value.code3+"\r00\r"+value.linea+"\r"+value.code3+"\r"
            codeqr+=codeqr2;
            break;
        case 6:
            reso = ["eliminDe","cambioDe"];//6 EDITAR CAJA Y ELIM PZA 
            codeqr = "\x05D\x0600\r"+value.linea+"\r"+value.code1+"\r00\r"+value.linea+"\r"+value.code1+"\r"
            codeqr2 += "3\r\x09"+value.desc2+"\r\n\rt"
            codeqr = codeqr2 + codeqr;
            break;
        case 7:
            reso = ["cambioDe","agregaDe"];//7 EDITAR PZ Y ADD CAJA 
            codeqr+="c4\r\x09"+value.desc1+"\r18\r"+value.code2+"\r\n\r"+imprime+"t"
            cajaAlta = value.code1+"\r"+value.cantidad+"\r"
            if(value.blues != 0){
                cajaAlta = almacena[value.blues];
            }
            codeqr2 = "\x05B\x06A"+clave+"1\r"+value.linea+"\r"+value.code3+"\r"+value.desc2+"\r"+value.umcaja+"\r"+cajaAlta+"\x19\r\r\n\n"+value.iva+""+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+
            "\r\n\n\n"+value.pre5+"\r\r"+clave+"1\x0Ftt"
            codeqr+=codeqr2;
            break;
        case 8:
            reso = ["agregaDe","cambioDe"];//8 EDITAR CAJA Y ADD  PZA 
            codeqr = "\x05A\x06A"+value.linea+"\r"+value.code1+"\r"+value.desc1+"\r"+value.unidad+"\r"+value.proves+"\r\n\r"+value.rdiez+"\r\n\r\n"+value.iva+""+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+
            "\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r"+value.cantidad+"\r"+value.code2+"\r\r\r\x0F"+imprime+"t"
            codeqr2 += "3\r\x09"+value.desc2+"\r\n\rt"
            codeqr+=codeqr2;
            break;
        case 9:
            reso = ["agregaDe",""];//9 ADD PZA 
            codeqr = "\x05A\x06A"+value.linea+"\r"+value.code1+"\r"+value.desc1+"\r"+value.unidad+"\r"+value.proves+"\r\n\r"+
            value.rdiez+"\r\n\r\n"+value.iva+""+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+
            "\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r"+value.cantidad+"\r"+value.code2+"\r\r\r\x0F"+imprime+"t"
            codeqr+=codeqr2;
            break;
        case 10:
            reso = ["","agregaDe"]; //10 ADD CAJA 
            cajaAlta = value.code1+"\r"+value.cantidad+"\r"
            if(value.blues != 0){
                cajaAlta = almacena[value.blues];
            }
            codeqr2 = "\x05B\x06A"+clave+"1\r"+value.linea+"\r"+value.code3+"\r"+value.desc2+"\r"+value.umcaja+"\r"+cajaAlta+"\x19\r\r\n\n"+value.iva+""+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+
            "\r\n\n\n"+value.pre5+"\r\r"+clave+"1\x0Ftt"
            codeqr+=codeqr2;
            break;
        case 11:
            reso = ["agregaDe","agregaDe"]; //11 ADD PZA Y ADD CAJA 
            codeqr = "\x05A\x06A"+value.linea+"\r"+value.code1+"\r"+value.desc1+"\r"+value.unidad+"\r"+value.proves+"\r\n\r"+value.rdiez+"\r\n\r\n"+value.iva+""+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+
            "\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r"+value.cantidad+"\r"+value.code2+"\r\r\r\x0F"+imprime+"t"
            cajaAlta = value.code1+"\r"+value.cantidad+"\r"
            if(value.blues != 0){
                cajaAlta = almacena[value.blues];
            }
            codeqr2 = "\x05B\x06A"+clave+"1\r"+value.linea+"\r"+value.code3+"\r"+value.desc2+"\r"+value.umcaja+"\r"+cajaAlta+"\x19\r\r\n\n"+value.iva+""+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+
            "\r\n\n\n"+value.pre5+"\r\r"+clave+"1\x0Ftt"
            codeqr+=codeqr2;
            break;
        case 12:
            reso = ["agregaDe","eliminDe"]; //12 ADD PZA Y ELIM CAJA 
            codeqr = "\x05A\x06A"+value.linea+"\r"+value.code1+"\r"+value.desc1+"\r"+value.unidad+"\r"+value.proves+"\r\n\r"+value.rdiez+"\r\n\r\n"+value.iva+""+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+
            "\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r"+value.cantidad+"\r"+value.code2+"\r\r\r\x0F"+imprime+"t"
            codeqr2 = "\x05B\x06b"+value.code3+"\r\neS\rtt"//"\x05D\x0600\r"+value.linea+"\r"+value.code3+"\r00\r"+value.linea+"\r"+value.code3+"\r"
            codeqr+=codeqr2
            break;
        case 13:
            reso = ["eliminDe","agregaDe"]; //13 ADD CAJA Y ELIM PZA 
            codeqr = "\x05D\x0600\r"+value.linea+"\r"+value.code1+"\r00\r"+value.linea+"\r"+value.code1+"\r"
            cajaAlta = value.code1+"\r"+value.cantidad+"\r"
            if(value.blues != 0){
                cajaAlta = almacena[value.blues];
            }
            codeqr2 = "\x05B\x06A"+clave+"1\r"+value.linea+"\r"+value.code3+"\r"+value.desc2+"\r"+value.umcaja+"\r"+cajaAlta+"\x19\r\r\n\n"+value.iva+""+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+
            "\r\n\n\n"+value.pre5+"\r\r"+clave+"1\x0Ftt"
            codeqr = codeqr2+codeqr;
            break;
        case 14:
            reso = ["eliminDe",""]; //14 ELIM PZA 
            codeqr = "\x05D\x0600\r"+value.linea+"\r"+value.code1+"\r00\r"+value.linea+"\r"+value.code1+"\r"
            codeqr = codeqr2+codeqr;
            break;
        case 15:
            reso = ["","eliminDe"]; //15 ELIM CAJA 
            codeqr2 = "\x05B\x06b"+value.code3+"\r\neS\rtt"//"\x05D\x0600\r"+value.linea+"\r"+value.code3+"\r00\r"+value.linea+"\r"+value.code3+"\r"
            codeqr += codeqr2;
            break;
        case 16:
            reso = ["eliminDe","eliminDe"]; //16 ELIM PZA Y ELIM CAJA 
            codeqr2 = "\x05B\x06b"+value.code3+"\r\neS\rt"//"\x05D\x0600\r"+value.linea+"\r"+value.code3+"\r00\r"+value.linea+"\r"+value.code3+"\r"
            codeqr = "\x05D\x0600\r"+value.linea+"\r"+value.code1+"\r00\r"+value.linea+"\r"+value.code1+"\r"
            codeqr = codeqr2+"..."+codeqr;
            break;
        default:
            codeqr = "\x05A\x06b"+value.code1+"\r\nc10\r"+value.rdiez+"\r\r17\r\n"+iva+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+"\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r\n\r\n"+imprime+"T";
            if(cajas){
                codeqr2 = "\x05B\x06b"+value.code3+"\r\nc"+clave+"1\r\n\x1911\r\n\n\n"+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+"\r\n\n\n"+value.pre5+"\r\r\nT"
                codeqr += codeqr2;
            }
            
        break;
    }
    //return codeqr+codeqr2;
    return codeqr;
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
function setListo(val1,val2) {
    return $.ajax({
        url: site_url+"Uploads/setListo/"+val1+"/"+val2,
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
            case "Ñ":
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

function getSucuEtiqueta(cuantos){
    return $.ajax({
        url: site_url+"Uploads/getSucuEtiqueta",
        type: "POST",
        cache: false,
    });
}

function yaAgregados(value,index){
    var nuevoStats = parseInt(value.estatus);
    var flag = 0;
    var cambio = "";var cambio2 = "";var cambio3 ="";

    //ADD PIEZA
    if(value.estatus == 9 && value.codigo == value.code1){
        nuevoStats = 2;
        flag = 1;
        cambio = "CAMBIO "+value.id_nuevo+"  => EL CAMBIO COMO ALTA DE LA PIEZA "+value.desc1+" // "+value.code1+" // SE CAMBIO A EDICIÓN POR QUE YA SE ENCONTRABA EN MATRICIAL EL PRODUCTO CON LA DESCRIPCIÓN : "+value.nombre;
    }
    if(value.estatus == 12 && value.codigo == value.code1){
        nuevoStats = 5;
        flag = 1;
        cambio = "CAMBIO "+value.id_nuevo+"  => EL CAMBIO COMO ALTA DE LA PIEZA "+value.desc1+" // "+value.code1+" // SE CAMBIO A EDICIÓN POR QUE YA SE ENCONTRABA EN MATRICIAL EL PRODUCTO CON LA DESCRIPCIÓN : "+value.nombre;
    }
    if(value.estatus == 8 && value.codigo == value.code1){
        nuevoStats = 4;
        flag = 1;
        cambio = "CAMBIO "+value.id_nuevo+"  => EL CAMBIO COMO ALTA DE LA PIEZA "+value.desc1+" // "+value.code1+" // SE CAMBIO A EDICIÓN POR QUE YA SE ENCONTRABA EN MATRICIAL EL PRODUCTO CON LA DESCRIPCIÓN : "+value.nombre;
    }


    //ADD CAJA
    if(value.estatus == 7 && value.codigosss == value.code3){
        nuevoStats = 4;
        flag = 1;
        cambio2 = "CAMBIO "+value.id_nuevo+"  => EL CAMBIO COMO ALTA DE LA CAJA "+value.desc2+" // "+value.code3+" // SE CAMBIO A EDICIÓN POR QUE YA SE ENCONTRABA LA CAJA CON LA DESCRIPCIÓN : "+value.nombresss;
    }
    if(value.estatus == 10 && value.codigosss == value.code3){
        nuevoStats = 3;
        flag = 1;
        cambio2 = "CAMBIO "+value.id_nuevo+"  => EL CAMBIO COMO ALTA DE LA CAJA "+value.desc2+" // "+value.code3+" // SE CAMBIO A EDICIÓN POR QUE YA SE ENCONTRABA LA CAJA CON LA DESCRIPCIÓN : "+value.nombresss;
    }
    
    if(value.estatus == 13 && value.codigosss == value.code3){
        nuevoStats = 6;
        flag = 1;
        cambio2 = "CAMBIO "+value.id_nuevo+"  => EL CAMBIO COMO ALTA DE LA CAJA "+value.desc2+" // "+value.code3+" // SE CAMBIO A EDICIÓN POR QUE YA SE ENCONTRABA LA CAJA CON LA DESCRIPCIÓN : "+value.nombresss;
    }


    //BOTH
    if(value.estatus == 11 && value.codigo == value.code1 && value.codigosss == value.code3){
        nuevoStats = 4;
        flag = 1;
        cambio = "CAMBIO "+value.id_nuevo+"  => EL CAMBIO COMO ALTA DE LA PIEZA "+value.desc1+" // "+value.code1+" // SE CAMBIO A EDICIÓN POR QUE YA SE ENCONTRABA EN MATRICIAL EL PRODUCTO CON LA DESCRIPCIÓN : "+value.nombre;
        cambio2 = "CAMBIO "+value.id_nuevo+"  => EL CAMBIO COMO ALTA DE LA CAJA "+value.desc2+" // "+value.code3+" // SE CAMBIO A EDICIÓN POR QUE YA SE ENCONTRABA LA CAJA CON LA DESCRIPCIÓN : "+value.nombresss;
    }
    if(value.estatus == 11 && value.codigo == value.code1 && value.codigosss != value.code3){
        nuevoStats = 7;
        flag = 1;
        cambio = "CAMBIO "+value.id_nuevo+"  => EL CAMBIO COMO ALTA DE LA PIEZA "+value.desc1+" // "+value.code1+" // SE CAMBIO A EDICIÓN POR QUE YA SE ENCONTRABA EN MATRICIAL EL PRODUCTO CON LA DESCRIPCIÓN : "+value.nombre;
        cambio2 = "";
    }
    if(value.estatus == 11 && value.codigo != value.code1 && value.codigosss == value.code3){
        nuevoStats = 8;
        flag = 1;
        cambio = "";
        cambio2 = "CAMBIO "+value.id_nuevo+"  => EL CAMBIO COMO ALTA DE LA CAJA "+value.desc2+" // "+value.code3+" // SE CAMBIO A EDICIÓN POR QUE YA SE ENCONTRABA LA CAJA CON LA DESCRIPCIÓN : "+value.nombresss;
    }

    if(value.estatus == 4 || value.estatus == 8 || value.estatus == 6){
        if(value.code3 != value.codigosss){
            cambio3 = "ES POSIBLE QUE NO TENGAS DADO DE ALTA LA CAJA CÓDIGO "+value.code3+"<br><br>"
        }
    }

    if(value.estatus == 4 || value.estatus == 5 || value.estatus == 7){
        if(value.code1 != value.codigo){
            cambio3 += "ES POSIBLE QUE NO TENGAS DADO DE ALTA EL PRODUCTO CON EL CÓDIGO "+value.code1
        }
    }
    

    if(flag){
        var values = {"antes":cambio,"despues":cambio2,"accion":"YA EXISTE"};
        cambioYaExiste(JSON.stringify(values)).done(function(resp){
            $("#outtxtya"+index).html("<h1>"+cambio+"<br><br>"+cambio2+"</h1>");
            $("#outtxtyaN"+index).html("<h1>"+cambio3+"</h1>");
        })
        return nuevoStats;
    }
}


function cambioYaExiste(value){
    return $.ajax({
        url: site_url+"/Codigos/cambioYaExiste",
        type: "POST",
        dataType: "JSON",
        data: {
            values : value
        }
    });
}