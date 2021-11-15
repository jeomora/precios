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
                var codeqr = "b"+value.code1+"\r\nc10\r"+renglon10+"\r\r17\r\n"+iva+value.pre11+"\r\n\n\n"+value.pre22+"\r\n\n\n"+value.pre33+"\r\n\n\n"+value.pre44+"\r\n\n\n"+value.costopz+"\r\n\r\nt";
                $('#outtxt'+index).html("<h3 class='font-weight-bolder mb-1'><a class='text-primary' style='font-size:55px'>"+value.desc2+"</a></h3><div class='text-primary mb-9' style='font-size:50px'>"+value.code1+"</div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Renglon 10</span><span class='text-dark flex-root font-weight-bold'>"+renglon10+"</span></div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Precio 1 :</span><span class='text-dark flex-root font-weight-bold'>"+value.pre11+"</span></div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Precio 2 :</span><span class='text-dark flex-root font-weight-bold'>"+value.pre22+"</span></div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Precio 3 :</span><span class='text-dark flex-root font-weight-bold'>"+value.pre33+"</span></div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Precio 4 :</span><span class='text-dark flex-root font-weight-bold'>"+value.pre44+"</span></div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Precio 5 :</span><span class='text-dark flex-root font-weight-bold'>"+formatMoney(precinco)+"</span></div>")
                $('#output'+index).qrcode({
                    render: "canvas", 
                    text: codeqr, 
                    width: 720,
                    height: 720,
                    background: "#FFFFFF",
                    foreground: "#3F47CC",

                })
                codeqr2 += codeqr;
                if(cajas){
                    $('#outputdos'+index).html("");
                    var cajaqr = "b"+value.code3+"\r\nc1\r\n\x1911\r\n\n\n"+value.pre1+"\r\n\n\n"+value.pre2+"\r\n\n\n"+value.pre3+"\r\n\n\n"+value.pre4+"\r\n\n\n"+value.pre5+"\r\n\r\nt"
                    
                    $('#outtxtdos'+index).html("<h3 class='font-weight-bolder mb-1'><a class='text-success' style='font-size:55px'>"+value.desc1+"</a></h3><div class='text-success mb-9' style='font-size:50px'>"+value.code3+"</div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Precio 1 :</span><span class='text-dark flex-root font-weight-bold'>"+value.pre1+"</span></div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Precio 2 :</span><span class='text-dark flex-root font-weight-bold'>"+value.pre2+"</span></div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Precio 3 :</span><span class='text-dark flex-root font-weight-bold'>"+value.pre3+"</span></div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Precio 4 :</span><span class='text-dark flex-root font-weight-bold'>"+value.pre4+"</span></div>"+
                    "<div class='d-flex mb-3' style='font-size:48px'><span class='text-dark-50 flex-root font-weight-bold'>Precio 5 :</span><span class='text-dark flex-root font-weight-bold'>"+value.pre5+"</span></div>")

                    $('#outputdos'+index).qrcode({
                        render: "canvas", 
                        text: cajaqr, 
                        width: 720,
                        height: 720,
                        background: "#FFFFFF",
                        foreground: "#28A745",

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

