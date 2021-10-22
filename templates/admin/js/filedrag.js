var select = document.querySelector('#fileselect');
var contenedor;
function addEvent(el, event, funcion){
	if (el != undefined && el.addEventListener) {
	  el.addEventListener(event, funcion, false);
	} else if (el != undefined && el.attachEvent)  {
	  el.attachEvent(event, funcion);
	}
}

function subirArchivo(f, tmbs, doc){
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'handler.php?up=true', true);
	xhr.setRequestHeader('UP-FILENAME', f.name);
	xhr.setRequestHeader('UP-SOCIO', id_socio);
	xhr.setRequestHeader('UP-DOC', doc);
	xhr.setRequestHeader('UP-SIZE', f.size);
	xhr.setRequestHeader('UP-TYPE', f.type);
	xhr.send(f); 
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200){
			tmbs.html('<img class="thumb" src="imgdocumentos/'+xhr.responseText+'"/>');
			tmbs.append('<span class="btnBorrarPrevio" style="position:absolute; right:0px; bottom:0px; width:24px; height:24px; cursor:pointer;"><i class="icon-remove" style="color:#F00; font-size:18px;"></i></span>');
		}
	};
}

function handlerDrop(evt){
	var Errores="";
	evt.stopPropagation();
	evt.preventDefault();
	
	var files = evt.target.files || evt.dataTransfer.files;
    for (var i = 0, f; f = files[i]; i++) {
		var tmp = f.name.toLowerCase().split(".");
		var tmn=f.size / 1048576;
		
		if("jpg, jpeg, png, gif".indexOf(tmp[1]) != -1){
			if(tmn <= 1.5){
				contenedor.append('<div class="thumbs span4"><img class="thumb" src="plantillas/boot/images/ajax-loader.gif" style="width:64px; height:64px; margin-top:12px;"/></div>');
				var tmbs = contenedor.find(".thumbs:last");
				subirArchivo(f, tmbs, contenedor.data("doc"));
				
			}else Errores +="<li>" + f.name + ": Tamaño máximo permitido es de 1.5 MB</li>";
		}else Errores +="<li>" + f.name + ": Solo se acepta jpg, jpeg, png, gif - "+tmn+"</li>";
	}
	
	if(Errores){
		$("#dialogo")
		.html("<ul>"+Errores+"</ul>")
		.dialog({
			title:"Error",
			modal:true,
			resizable:false,
			position:"center",
			buttons:{
				"OK":function(){ 
					$(this).dialog("close"); 
				}
			}
		})
		.dialog("open");
	}
		
		
	this.className = '';
	return false;
}



addEvent(select, "change",handlerDrop);
