'use strict';
jQuery(document).ready(function() {
    

    qrmeup().done(function(resp){
        if(resp){
            var flag = 0;var flag2 = 1;var textCode = "";var colores = "#FF8484";var est = true;
            $.each(resp,function(index,value){
                //var codeqr = givePZ(value,index);
                $('#outtxt'+flag).append("<h3 class='mb-1'><a class='text-black' style='font-size:30px'>"+flag2+".- "+value.codigo+" "+value.nombre+"</a></h3><div class='font-weight-bolder text-black mb-9' style='font-size:30px'>Cant: "+
                    value.cantidad+"</div><div class='col-md-12' style='text-align:center'></div>") 
                if(flag2 == 10){
                    flag2 = 1;
                    textCode += value.codigo+"\r"+value.cantidad+"\r";
                    if(est){
                        colores = "#FF8484";
                        est = false
                    }else{
                        colores = "#84BBFF";
                        est = true
                    }
                    $('#output'+flag).qrcode({
                        render: "canvas", 
                        text: textCode, 
                        width: 720,
                        height: 720,
                        background: "#FFFFFF",
                        foreground: colores,

                    })
                    textCode = "";
                    flag++;
                }else if(flag2 == 1){
                    textCode += "\x05Z\x06a\n\r\r\rINVENTARIO\r5\r"+value.codigo+"\r"+value.cantidad+"\r";
                    flag2++;
                }else{
                    flag2++;
                    textCode += value.codigo+"\r"+value.cantidad+"\r";
                }
            
            })
            if(flag2 > 1){
                if(est){
                    colores = "#FF8484";
                    est = false
                }else{
                    colores = "#84BBFF";
                    est = true
                }
                textCode += "";
                $('#output'+flag).qrcode({
                    render: "canvas", 
                    text: textCode, 
                    width: 720,
                    height: 720,
                    background: "#FFFFFF",
                    foreground: colores,

                })
            }
        }
    })
    
    
    
});


function qrmeup() {
    return $.ajax({
        url: site_url+"Inventarios/qrmeupCedis/"+window.location.pathname.split("/").pop(),
        type: "POST",
        cache: false,
    });
}

