'use strict';
var rojosArray = [];
var almacena = [];
var descChange = 0;
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
                
                $('#outtxt'+index).html("<h3 class='font-weight-bolder mb-1'><a class='text-primary' style='font-size:55px'>"
                    +deco1+"</a></h3><div class='text-primary mb-9' style='font-size:50px'>"+value.code1+"</div><div class='col-md-12' style='text-align:center'><button type='button' data-id-rojo='"+value.id_detail+
                    "' class='"+cliston+"'>"+liston+"</button></div>")
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
    if(value.linea == "SE" || value.linea == "77"){
        imprime = "";
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