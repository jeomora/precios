/*
* Author: LFJAIMESB
*/
(function( $ ){
	$.fn.protabla = function() {
		var _Elemento = $(this);
		var _min = 0;
		var _filtro = false;
		var _next = "disabled";
		var _prev = "disabled";
		var _Th = _Elemento.find("thead tr th:not('.td-actions')");
		
		_Elemento.find("tbody tr").addClass("show");

		_Elemento.before("<div class='dataTables_length'>Mostrar <select style='margin:0px 5px;'><option value='15' selected='selected'>15</option><option value='30'>30</option><option value='50'>50</option><option value='100'>100</option></select>entradas</div><div class='dataTables_filter'>Buscar: <input type='text' class='txtSearch' placeholder='Buscar datos' /></div>");

		var _Select = _Elemento.prev().prev().find("select");
		var _TxtSearch = _Elemento.prev().find("input");

		_Elemento.after("<div class='dataTables_info'>Mostrando <span></span> al <span></span> de <span></span> entradas <em>(filtro de "+ _Elemento.find("tbody tr").length +" total de entradas)</em></div><div class='dataTables_paginate paging_two_button'><a class='paginate_disabled_previous'>Anterior</a><a class='paginate_disabled_next'>Siguiente</a></div>");

		var _BtnAnt = _Elemento.next().next().find("a:first");
		var _BtnSig = _Elemento.next().next().find("a:last");
		var _TxtMin = _Elemento.next().find("span:first");
		var _TxtMax = _Elemento.next().find("span:first").next();
		var _TxtTotal = _Elemento.next().find("span:last");
		var _TxtFiltro = _Elemento.next().find("em");

		/********** Funciones *******/
		__Mostrar = function(){
			var _visibles = parseInt(_Select.val());
			var _max = _min + _visibles;
			
			_Elemento.find("tbody tr").hide();

			_Elemento.find("tbody tr").each(function(index){
				if($(this).hasClass("show")){
					if(index >= _min && index < _max){
						$(this).show();
					}
				}
			});

			var _registro = _Elemento.find("tbody tr.show").length;
			var _vistos = ((_min) + _visibles)>=_registro?_registro:((_min) + _visibles);
			_next = (_registro <= ((_min) + _visibles))?"disabled":"enabled";
			_prev = _min < 2?"disabled":"enabled";

			_TxtMin.html(_min + 1);
			_TxtMax.html(_vistos);
			_TxtTotal.html(_registro);

			if(_filtro) _TxtFiltro.show();
			else _TxtFiltro.hide();

			_BtnAnt.attr("class","paginate_"+_prev+"_previous");
			_BtnSig.attr("class","paginate_"+_next+"_next");
		}

		_Dinamico = function (_property) {
			var _sortOrder = 1;

			if(_property[0] === "-") {
				_sortOrder = -1;
				_property = _property.substr(1);
			}
			
			return function (_a,_b) {
				var _result = (_a[_property] < _b[_property]) ? -1 : (_a[_property] > _b[_property]) ? 1 : 0;
				return _result * _sortOrder;
			}
		}

		/***** Eventos *******/
		_TxtSearch.keyup(function(){
			var search = _TxtSearch.val();
			_min = 0;

	        _Elemento.find("tbody tr").addClass("show");
	        
	        if(search.length>0){
	        	_filtro = true;
				_Elemento.find("tbody tr").not(":Contains('"+search+"')").removeClass("show");
	        }

	        __Mostrar();

		});

		_Select.change(__Mostrar);
		
		_BtnSig.click(function(){
			if(_next == "enabled"){
				_min += parseInt(_Select.val());
				__Mostrar();
			}
		});

		_BtnAnt.click(function(){
			if(_prev == "enabled"){
				_min -= parseInt(_Select.val());
				__Mostrar();
			}
		});

		_Th.click(function(){
			var _th = $(this);
			var _class = _th.attr("class")!=undefined?_th.attr("class"):"asc";
			var _trs = _Elemento.find("tbody tr");
			var _tag_i;
			var _columna;
			var _datos = [];

			$(this).parent().find("th").removeAttr("class");
			$(this).parent().find("th i").remove("");
			
			if(_th.find("i").length == 0)
				_th.append("<i style='margin-left:10px;'></i>");

			_tag_i = _th.find("i");
			
			$(this).parent().find("th").each(function(index){
				if($(this).html() == _th.html()){
					_columna = index;
					return false;
				}
			});

			_trs.each(function(index){
				_datos.push( {"nombre": $(this).find("td:eq("+_columna+")").html().toLowerCase(), "id":index} );
			});

			_datos.sort(_Dinamico("nombre"));
			_th.attr("class", "desc");
			_tag_i.attr("class", "icon-arrow-circle-1-up");
				
			if(_class == "desc"){
				_datos.reverse();
				_th.attr("class", "asc");
				_tag_i.attr("class", "icon-arrow-circle-1-down");
			}

			_Elemento.find("tbody").html("");
			
			for(var i in _datos){
				var index = _datos[i].id;
				_trs
				_Elemento.find("tbody").append(_trs[index]);
			}

			_min = 0;
			__Mostrar();
			
		});

		/****** Lanzadores *****/
		_Select.change();

	};
})( jQuery );
