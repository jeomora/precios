'use strict';
// Class definition
var dataJSONArray = "";
var KTDatatableDataLocalDemo = function() {
    // Private functions
    // demo initializer
    
    var demo = function() {
        getUsuarios().done(function(resp){
            var yeison = "[";
            if (resp) {
                $.each(resp,function(index, value){
                    yeison = yeison + '{"RecordID":'+value.id_usuario+',"Nombre":"'+value.nombre+'","Email":"'+value.email+'","Id_grupo":"'+value.id_grupo+
                    '","Grupo":"'+value.grupo+'","Estatus":"'+value.estatus+'","Imagen":"'+value.imagen+'","Actions":null},\n'

                });
            }
           dataJSONArray = JSON.parse(yeison.slice(0,-1).slice(0,-1)+']');
        });


        setTimeout(function(){
            var datatable = $('.kt-datatable').KTDatatable({
            // datasource definition
            data: {
                type: 'local',
                source: dataJSONArray,
                pageSize: 20,
            },

            // layout definition
            layout: {
                scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
                // height: 450, // datatable's body's fixed height
                footer: false, // display/hide footer
            },

            // column sorting
            sortable: true,

            pagination: true,

            search: {
                input: $('#tableSearch'),
            },

            // columns definition
            columns: [
                {
                    field: 'RecordID',
                    title: 'ID',
                    sortable: true,
                    width: 40,
                    type: 'number',
                    textAlign: 'center',
                }, {
                    field: 'Nombre',
                    title: 'Nombre',
                    template: function(row) {
                        return '<div class="d-flex align-items-center"><div class="symbol symbol-40 flex-shrink-0"><div class="symbol-label" style="background-image:url(assets/media/svg/avatars/' + row.Imagen + '.svg)"></div>'+
                        '</div><div class="ml-2"><div class="text-dark-75 font-weight-bold line-height-sm">' + row.Nombre + '</div><a class="font-size-sm text-dark-50 text-hover-primary">' + row.Email + '</a>'+
                        '</div></div>'
                    },
                }, {
                    field: 'Grupo',
                    title: 'Tipo Usuario',
                    width: 250,
                    autoHide: false,
                    // callback function support for column rendering
                    template: function(row) {
                        return '<span class="font-weight-bold text-dark">'+row.Grupo+'</span>';
                    }
                }, {
                    field: 'Estatus',
                    title: 'Estatus',
                    // callback function support for column rendering
                    template: function(row) {
                        var status = {
                            1: {'title': 'Activo', 'class': 'label-light-success'},
                            0: {'title': 'Eliminado', 'class': 'label-light-danger'},
                        };
                        return '<span class="label font-weight-bold label-lg ' + status[row.Estatus].class + ' label-inline">' + status[row.Estatus].title + '</span>';
                    },
                },{
                    field: 'Actions',
                    title: 'Acciones',
                    sortable: false,
                    width: 110,
                    overflow: 'visible',
                    autoHide: false,
                    template: function(data, i) {
                        return '\
                        <a id="edituser" data-id-user="'+data.RecordID+'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Editar" data-toggle="modal" data-target="#kt_modal_4">\
                            <i class="la la-edit"></i>\
                        </a>\
                        <a id="liusered" data-id-user="'+data.RecordID+'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Eliminar"  data-toggle="modal" data-target="#kt_modal_1">\
                            <i class="la la-trash"></i>\
                        </a>\
                    ';
                    },
                }],
        });

        $('#kt_form_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $('#kt_form_type').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_form_status,#kt_form_type').selectpicker();
        },1000)

        

    };

    return {
        // Public functions
        init: function() {
            // init dmeo
            demo();
        },
    };
}();

jQuery(document).ready(function() {
    $("#titlePrincipal").html("Usuarios");
    $(".menu-item").removeClass("menu-item-active")
    $(".menu-users").addClass("menu-item-active")
    KTDatatableDataLocalDemo.init();
    $("#id_sucu").val(8)
});

$(document).off("click", "#liusered").on("click", "#liusered", function(event) {
    event.preventDefault();

    getUser($(this).data("idUser"))
        .done(function (resp) {
            $("#spanuser").html(resp.nombre);
            $("#id_usuario").val(resp.id_usuario);
        });
});

$(document).off("click", "#edituser").on("click", "#edituser", function(event) {
    event.preventDefault();

    getUser($(this).data("idUser"))
        .done(function (resp) {
            $("#id_usuarios").val(resp.id_usuario);
            $("#nombre").val(resp.nombre);
            $("#apellido").val(resp.apellido);
            $("#correo").val(resp.email);
            $("#sucuss").val(resp.id_sucursal);
            $("#id_grupo").val(resp.id_grupo);
        });
});

function getUser(formData) {
    return $.ajax({
        url: site_url+"Usuarios/getUser/"+formData,
        type: "POST",
        dataType: "JSON",
    });
}

function getUsuarios() {
    return $.ajax({
        url: site_url+"Usuarios/getUsuarios",
        type: "POST",
        dataType: "JSON",
    });
}

$(document).off("click", ".delete_usuario").on("click", ".delete_usuario", function(event) {
    event.preventDefault();
    sendForm("Usuarios/delete_user", $("#form_usuario_delete"), "");
});

$(document).off("click", ".update_usuario").on("click", ".update_usuario", function(event) {
    event.preventDefault();
    var flag = 1;
    flag = valis($("#nombre"),$(".userValid"),flag);
    flag = valis($("#correo"),$(".mailValid"),flag);
    flag = isLength($("#password"),$(".passValid"),flag);

    if(flag){
        sendFormas("Usuarios/update_user", $("#form_usuario_edit"), "");
    }
});
$(document).off("click", ".new_usuario").on("click", ".new_usuario", function(event) {
    event.preventDefault();
    var flag = 1;
    flag = valis($("#nombres"),$(".usersValid"),flag);
    flag = valis($("#correos"),$(".mailsValid"),flag);
    flag = isLength($("#passwords"),$(".passsValid"),flag);

    if(flag){
        sendFormas("Usuarios/save_user", $("#form_usuario_new"), "");
    }
});
function goBack() {
  window.history.back();
}


$(document).off("change", "#id_grupos").on("change", "#id_grupos", function(event) {
    event.preventDefault();
    $("#id_sucu").val(8)
    if ($(this).val() === "2"){
        $(".sucus").css("display","block")
    }else{
        $(".sucus").css("display","none")
    }
});

$(document).off("change", "#id_grupo").on("change", "#id_grupo", function(event) {
    event.preventDefault();
    $("#id_sucuss").val(8)
    if ($(this).val() === "2"){
        $(".sucuss").css("display","block")
    }else{
        $(".sucuss").css("display","none")
    }
});