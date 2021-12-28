'use strict';
var rojosArray = [];
var almacena = [];
var descChange = 0;
var idLinea = 0;
jQuery(document).ready(function() {
    

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
                var precinco = parseFloat((value.costo / value.cantidad),2);
                precinco += 0.01; 
                var renglon10 = value.costopz / ( 1+(value.iva/100) );
                var codeqr = givePZ(value,index);
                //codeqr += "\x05A\x06b"+value.code1+"\r\nc10\r"+renglon10+"\r\r17\r\n"+iva+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+"\r\n\n\n"+value.pre44+"\r\n\n\n"+value.costopz+"\r\n\r\n";
                //codeqr+="c4\r"
                $('#outtxt'+index).html("<h3 class='font-weight-bolder mb-1'><a class='text-primary' style='font-size:55px'>"
                    +value.desc1+"</a></h3><div class='text-primary mb-9' style='font-size:50px'>"+value.code1+"</div>")
                if (codeqr.indexOf("...") >= 0){
                    $('#outtxt'+index).css("color","red")
                    var code1 = codeqr.substr(0, codeqr.indexOf('...')); 
                    $('#output'+index).qrcode({
                        render: "canvas", 
                        text: code1, 
                        width: 720,
                        height: 720,
                        background: "#FFFFFF",
                        foreground: "#3F47CC",
                    })
                    var code2 = codeqr.substr(codeqr.indexOf('...')+3); 
                    $('#outputs'+index).qrcode({
                        render: "canvas", 
                        text: code2, 
                        width: 720,
                        height: 720,
                        background: "#FFFFFF",
                        foreground: "#3F47CC",
                    })
                }else{
                    $('#outtxt'+index).css("color","blue")
                    $('#output'+index).qrcode({
                        render: "canvas", 
                        text: codeqr, 
                        width: 720,
                        height: 720,
                        background: "#FFFFFF",
                        foreground: "#3F47CC",

                    })
                }

                
            })
                
            
        }
    })
    
    
    
});

function qrmeup() {
    return $.ajax({
        url: site_url+"Codigos/qrmeup/"+window.location.pathname.split("/").pop(),
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
    var codeqr = "\x05A\x06b"+value.code1+"\r\nc10\r"+value.rdiez+"\r\r17\r\n"+iva+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+"\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r\n\r\n";
    //codeqr = "\x05A\x06b"+value.code1+"\r\n";
    var codeqr2 = ""//"t";
    //codeqr+="c4\r"
    
    if(cajas){
        codeqr2 = "\x05B\x06b"+value.code3+"\r\nc1\r\n\x1911\r\n\n\n"+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+"\r\n\n\n"+value.pre5+"\r\n"
    }


    switch( parseInt(value.estatus) ){
        case 2:
            reso = ["cambioDe",""]; //2 EDITAR PZ 
            codeqr+="c4\r\x09"+value.desc1+"\r18\r"+value.code2+"\r\n\rt"
            codeqr += codeqr2;
            break;
        case 3:
            reso = ["","cambioDe"];//3 EDITAR CAJA 
            codeqr2 += "3\r\x09"+value.desc2+"\r\n\rt"
            codeqr += codeqr2+"t";
            break;
        case 4:
            reso = ["cambioDe","cambioDe"];//4 EDITAR PZ Y CAJA 
            codeqr+="c4\r\x09"+value.desc1+"\r18\r"+value.code2+"\r\n\rt"
            codeqr2 += "3\r\x09"+value.desc2+"\r\n\x01t";
            codeqr+=codeqr2;
            break;
        case 5:
            reso = ["cambioDe","eliminDe"];//5 EDITAR PZ Y ELIM CAJA 
            codeqr+="c4\r\x09"+value.desc1+"\r18\r"+value.code2+"\r\n\rt"
            codeqr2 = "\x05D\x0600\r"+value.linea+"\r"+value.code3+"\r00\r"+value.linea+"\r"+value.code3+"\r"
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
            codeqr+="c4\r\x09"+value.desc1+"\r18\r"+value.code2+"\r\n\rt"
            codeqr2 = "\x05B\x06A1\r"+value.linea+"\r"+value.code3+"\r"+value.desc2+"\r"+value.umcja+"\r"+value.code1+"\r"+value.cantidad+"\r\x19\r\r\n\n\n"+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+
            "\r\n\n\n"+value.pre5+"\r\r\x0Ft"
            codeqr+=codeqr2;
            break;
        case 8:
            reso = ["agregaDe","cambioDe"];//8 EDITAR CAJA Y ADD  PZA 
            codeqr = "\x05A\x06A"+value.linea+"\r"+value.code1+"\r"+value.desc1+"\r"+value.unidad+"\r"+value.proves+"\r\n\r"+value.rdiez+"\r\n\r\n"+value.iva+""+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+
            "\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r"+value.cantidad+"\r"+value.code2+"\r\r\r\x0Ft"
            codeqr2 += "3\r\x09"+value.desc2+"\r\n\rt"
            codeqr+=codeqr2;
            break;
        case 9:
            reso = ["agregaDe",""];//9 ADD PZA 
            codeqr = "\x05A\x06A"+value.linea+"\r"+value.code1+"\r"+value.desc1+"\r"+value.unidad+"\r"+value.proves+"\r\n\r"+
            value.rdiez+"\r\n\r\n"+value.iva+""+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+
            "\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r"+value.cantidad+"\r"+value.code2+"\r\r\r\x0Ft"
            codeqr+=codeqr2;
            break;
        case 10:
            reso = ["","agregaDe"]; //10 ADD CJA 
            codeqr2 = "\x05B\x06A1\r"+value.linea+"\r"+value.code3+"\r"+value.desc2+"\r"+value.umcja+"\r"+value.code1+"\r"+value.cantidad+"\r\x19\r\r\n\n\n"+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+
            "\r\n\n\n"+value.pre5+"\r\r\x0Ft"
            codeqr+=codeqr2;
            break;
        case 11:
            reso = ["agregaDe","agregaDe"]; //11 ADD PZA Y ADD CAJA 
            codeqr = "\x05A\x06A"+value.linea+"\r"+value.code1+"\r"+value.desc1+"\r"+value.unidad+"\r"+value.proves+"\r\n\r"+value.rdiez+"\r\n\r\n"+value.iva+""+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+
            "\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r"+value.cantidad+"\r"+value.code2+"\r\r\r\x0Ft"
            codeqr2 = "\x05B\x06A1\r"+value.linea+"\r"+value.code3+"\r"+value.desc2+"\r"+value.umcja+"\r"+value.code1+"\r"+value.cantidad+"\r\x19\r\r\n\n\n"+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+
            "\r\n\n\n"+value.pre5+"\r\r\x0Ft"
            codeqr+=codeqr2;
            break;
        case 12:
            reso = ["agregaDe","eliminDe"]; //12 ADD PZA Y ELIM CJA 
            codeqr = "\x05A\x06A"+value.linea+"\r"+value.code1+"\r"+value.desc1+"\r"+value.unidad+"\r"+value.proves+"\r\n\r"+value.rdiez+"\r\n\r\n"+value.iva+""+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+
            "\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r"+value.cantidad+"\r"+value.code2+"\r\r\r\x0Ft"
            codeqr2 = "\x05D\x0600\r"+value.linea+"\r"+value.code3+"\r00\r"+value.linea+"\r"+value.code3+"\r"
            codeqr+=codeqr2
            break;
        case 13:
            reso = ["eliminDe","agregaDe"]; //13 ADD CJA Y ELIM PZA 
            codeqr = "\x05D\x0600\r"+value.linea+"\r"+value.code1+"\r00\r"+value.linea+"\r"+value.code1+"\r"
            codeqr2 = "\x05B\x06A1\r"+value.linea+"\r"+value.code3+"\r"+value.desc2+"\r"+value.umcja+"\r"+value.code1+"\r"+value.cantidad+"\r\x19\r\r\n\n\n"+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+
            "\r\n\n\n"+value.pre5+"\r\r\x0Ft"
            codeqr = codeqr2+codeqr;
            break;
        case 14:
            reso = ["eliminDe",""]; //14 ELIM PZA 
            codeqr = "\x05D\x0600\r"+value.linea+"\r"+value.code1+"\r00\r"+value.linea+"\r"+value.code1+"\r"
            codeqr = codeqr2+codeqr;
            break;
        case 15:
            reso = ["","eliminDe"]; //15 ELIM CJA 
            codeqr2 = "\x05D\x0600\r"+value.linea+"\r"+value.code3+"\r00\r"+value.linea+"\r"+value.code3+"\r"
            codeqr += codeqr2;
            break;
        case 16:
            reso = ["eliminDe","eliminDe"]; //16 ELIM PZA Y ELIM CJA 
            codeqr2 = "\x05D\x0600\r"+value.linea+"\r"+value.code3+"\r00\r"+value.linea+"\r"+value.code3+"\r"
            codeqr = "\x05D\x0600\r"+value.linea+"\r"+value.code1+"\r00\r"+value.linea+"\r"+value.code1+"\r"
            codeqr = codeqr+"..."+codeqr2;
            break;
        default:
            codeqr = "\x05A\x06b"+value.code1+"\r\nc10\r"+value.rdiez+"\r\r17\r\n"+iva+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+"\r\n\n\n"+value.pre44+"\r\n\n\n"+value.pre55+"\r\n\r\nT";
            if(cajas){
                codeqr2 = "\x05B\x06b"+value.code3+"\r\nc1\r\n\x1911\r\n\n\n"+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+"\r\n\n\n"+value.pre5+"\r\r\nT"
                codeqr += codeqr2;
            }
            
        break;
    }
    //return codeqr+codeqr2;
    return codeqr;
}
