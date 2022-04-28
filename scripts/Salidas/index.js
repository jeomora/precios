/************************* Begin: COMPARATIVO *************************/

$(document).off("change", "#file_cotizaciones").on("change", "#file_cotizaciones", function(event) {
    event.preventDefault();
    blockPage();
    var formdata = new FormData($("#upload_cotizaciones")[0]);
    uploadcotizaciones(formdata)
        .done(function (resp) {
            console.log(resp)
            if (resp.type == 'error'){
                toastr.error(resp.desc, user_name);
            }else{
                unblockPage();
                $("#file_cotizaciones").val("");
                //setTimeout("location.reload()", 1300, toastr.success(resp.desc, user_name), "");
            }
        }); 
});

function uploadcotizaciones(formData) {
    return $.ajax({
        url: site_url+"Salidas/upload_cotizaciones",
        type: "POST",
        cache: false,
        contentType: false,
        processData:false,
        dataType:"JSON",
        data: formData,
    });
}


$(document).off("change", "#file_remisiones").on("change", "#file_remisiones", function(event) {
    event.preventDefault();
    blockPage();
    var formdata = new FormData($("#upload_remisiones")[0]);
    uploadremisiones(formdata)
        .done(function (resp) {
            console.log(resp)
            if (resp.type == 'error'){
                toastr.error(resp.desc, user_name);
            }else{
                unblockPage();
                $("#file_remisiones").val("");
                //setTimeout("location.reload()", 1300, toastr.success(resp.desc, user_name), "");
            }
        }); 
});

function uploadremisiones(formData) {
    return $.ajax({
        url: site_url+"Salidas/upload_remisiones",
        type: "POST",
        cache: false,
        contentType: false,
        processData:false,
        dataType:"JSON",
        data: formData,
    });
}

/************************* End: COMPARATIVO *************************/