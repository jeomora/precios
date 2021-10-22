/* 1/05/2016
 Desarrollado por : Caritina Rivera , Misael Heredia , Josué Aguilar

Funciín arr: Función que sirve para que aparezcan los botones de eliminar , editar y arrastrar
y tambien les da su funcionalidad a lo botones
Recibe (nombre de la tabla ,como se llama el campo id de esta tabla ,nombre del id de la tabla, entero)

el entero si es 1 aparece la opcion de eliminar , culaquier otro hace que no aparezca
*/
(function ($) {

    $.fn.extend({

    	arr:function(tablename,idname,nomelemento,a){
    		var $this = this;
    		var a = a || 0;

    		 function fixWidthHelper(e, ui) {
       		ui.children().each(function() {
          	$(this).width($(this).width());
       		});
       return ui;
   }

   setTimeout(function(){

       $(".table tbody tr").each(function(){
           var $tr = $(this);
           var offset = $tr.position();
           var index = $(".table tbody tr").index($tr);
           var $table = $(".table");
           var data = $(".table").bootstrapTable('getData');
           if(data[index]== null) return
           data = data[index];

           var clasenva = $("<div class='iconos-col' />");
           var btnEditar = $("<a data-toggle='tooltip' data-placement='top' title='Editar registro'/>");
           btnEditar.html("<i class='editar fa fa-pencil'></i>");
           var btnEliminar = $("<a data-toggle='tooltip' data-placement='top' title='Eliminar registro'/>");
           btnEliminar.html("<i class='eliminar fa fa-trash'></i>");
           var btnArrastrar = $("<a data-toggle='tooltip' data-placement='top' title='Arrastrar'/>");
           btnArrastrar.html("<i class='arrastrar fa fa-arrows handle'></i>");

           clasenva.append(btnEditar);
           if (a==0){
			
           	clasenva.append(btnEliminar);
       	   }
       	   else{$(".iconos-col").css("left", -74 + "px");}
           clasenva.append(btnArrastrar);

           clasenva.css("top", offset.top);

           $tr
           .attr("id", data[idname])
           .append(clasenva)
           .off("click")
           .on("click", function(){
               $(".iconos-col").hide();
               clasenva.show();
           });

           //aqui va el boton de editar
           btnEditar.off("click").on("click", function(){
               location.href="admin/"+tablename+"/editar/" + data[idname]+"/"+data[nomelemento];
           });
           //termina boton de editar

           //aqui va el boton de eliminar
           if (a==0) {
           btnEliminar.off("click").on("click", function(){
               BootstrapDialog.confirm('¿Está seguro que quiere eliminar el elemento: "'+data[nomelemento]+'"?<br></b>', function(result){
                   if(result) {
                       App.connect("api/"+tablename+"/eliminar/" + data[idname],false,function(response){
                           App.Alert(response);
                           if($this.bootstrapTable("refresh") !== null){
                            $($this).arr(tablename,idname,nomelemento,a);
                           }

                       });
                   }
               });
           });
       }
           btnArrastrar.off("mousedown").on("mousedown", function(){
               clasenva.hide();
           });
       });

      $(".table tbody").sortable({
          helper: fixWidthHelper,
          handle: ".handle",
          cursor: "move",
          cursorAt: {left: 0, top:10},
          stop: function(event,ui){
             $(".table tbody tr").each(function(){
                 var offset = $(this).position();
                 $(this).find(".iconos-col").css("top", offset.top);
             });

            var $t = $(".table tbody");

              var r = $t.sortable("toArray");
              var form = new FormData();
              for(var i = 0; i<r.length;i++)
              form.append("orden[]",r[i] );
              App.connect("api/"+tablename+"/ordena", form);
          }
      });
   }, 2000);

   $('body').off('click').on('click',function(e){
       $(".table tbody").find("tr").each(function(){
           if(!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0){
               $(this).popover('hide');
           }
       });
   });
  $('[data-toggle="tooltip"]').tooltip();


			}
  });
}(jQuery));