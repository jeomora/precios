var DialogForm = null;
var App = {};




App.Alert = function(datos,redireccion){

    var redireccion = redireccion || 0;

    var tipo = "", titulo = "", mensaje = "", icono = "", color = "", btn = "default";

    if(datos.success != undefined){
        titulo = "<li class='fa fa-check peligro'></li>";
        tipo = BootstrapDialog.TYPE_SUCCESS;
        mensaje = datos.success;
        color = "5cb85c";
        icono = "";
        btn = "success";
    }else if(datos.error != undefined){
        titulo = "Error";
        tipo = BootstrapDialog.TYPE_DANGER;
        mensaje = datos.error;
        color = "d9534f";
        icono = "times-circle";
        btn = "danger";
    }else if(datos.warning != undefined){
        titulo = "Atención";
        tipo = BootstrapDialog.TYPE_WARNING;
        icono = "warning";
        color = "f0ad4e";
        mensaje = datos.warning;
        btn = "warning";
    }

    BootstrapDialog.show({
        title: titulo,
        type: tipo,
        size: BootstrapDialog.SIZE_MEDIUM,
        closable: false,
        message: mensaje,
        buttons: [{
            label: 'OK',
            cssClass: 'btn btn-primary btn-agregar ',
            action: function(dialogRef) {
                dialogRef.close();
                if (redireccion!==0) {
                location.href=redireccion;
                }

            }
        }]
    });
};

App.connect = function(url, formData, callback){
    $.ajax({
        url: url,
        type: "post",
        contentType:false,
        processData: false,
        cache: false,
        data: formData,
        dataType: "json",
        beforeSend: function(xhr) {
            xhr.setRequestHeader("User-Agent", "ApiErpNet");
            xhr.setRequestHeader("Authorization", "Bearer "+App.token);
        },
        success: callback
    });
};

App.urlBase64Decode = function(str){
    var output = str.replace('-', '+').replace('_', '/');

    switch (output.length % 4) {
        case 0:
            break;
        case 2:
            output += '==';
            break;
        case 3:
            output += '=';
            break;
        default:
            throw 'Illegal base64url string!';
    }

    return window.atob(output);
};

App.Link = function($url, $title, $arguments){
    if($arguments["action"] != undefined){
        return $url;
    }else{
        $elements=[];

        $.each($arguments, function($cve, $valor){
            $elements.push($cve + "='" + $valor + "'");
        });

        return "<a href='" + $url.replace("'", "\"") + "' " + $elements.join(" ") +">" + $title + "</a>";
    }
};

$.expr[':'].Contains = function(x, y, z){
    return jQuery(x).text().toLowerCase().indexOf(z[3].toLowerCase())>=0;
};

BootstrapDialog.confirm = function(message, callback) {
	new BootstrapDialog({
		title: '<i class="glyphicon glyphicon-alert" style="margin:0px 5px;"></i>Atención',
		message: message,
		type: BootstrapDialog.TYPE_DANGER,
		closable: false,
		size: BootstrapDialog.SIZE_NORMAL,
		data: {
			'callback': callback
		},
		buttons: [{
			label: 'Continuar',
			cssClass: 'btn-primary',
			action: function(dialog) {
				typeof dialog.getData('callback') === 'function' && dialog.getData('callback')(true);
				dialog.close();
			}
		},
		{
			label: 'Cancelar',
			action: function(dialog) {
				typeof dialog.getData('callback') === 'function' && dialog.getData('callback')(false);
				dialog.close();
			}
			}]
	}).open();
};

function ucwords(str) {
    return (str + '')
    .replace(/^([a-z\u00E0-\u00FC])|\s+([a-z\u00E0-\u00FC])/g, function($1) {
        return $1.toUpperCase();
    });
}

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');

    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',

    toFixedFix = function(n, prec) {
    var k = Math.pow(10, prec);
    return '' + (Math.round(n * k) / k)
    .toFixed(prec);
    };

    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
    if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
    .join('0');
    }
    return s.join(dec);
}

function base64_decode(data) {
	var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
	var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
	ac = 0,
	dec = '',
	tmp_arr = [];

	if (!data) {
		return data;
	}

	data += '';

	do { // unpack four hexets into three octets using index points in b64
		h1 = b64.indexOf(data.charAt(i++));
		h2 = b64.indexOf(data.charAt(i++));
		h3 = b64.indexOf(data.charAt(i++));
		h4 = b64.indexOf(data.charAt(i++));

		bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;

		o1 = bits >> 16 & 0xff;
		o2 = bits >> 8 & 0xff;
		o3 = bits & 0xff;

		if (h3 == 64) {
		  tmp_arr[ac++] = String.fromCharCode(o1);
		} else if (h4 == 64) {
		  tmp_arr[ac++] = String.fromCharCode(o1, o2);
		} else {
		  tmp_arr[ac++] = String.fromCharCode(o1, o2, o3);
		}
	} while (i < data.length);

	dec = tmp_arr.join('');

	return dec.replace(/\0+$/, '');
}

function utf8_decode(str) {
  var output = "";
  var i = c = c1 = c2 = 0;
  while ( i < str.length ) {
    c = str.charCodeAt(i);
    if (c < 128) {
      output += String.fromCharCode(c);
      i++;
    }
    else if((c > 191) && (c < 224)) {
      c2 = str.charCodeAt(i+1);
      output += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
      i += 2;
    }
    else {
      c2 = str.charCodeAt(i+1);
      c3 = str.charCodeAt(i+2);
      output += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
      i += 3;
    }
  }
  return output;
}

function stristr(haystack, needle, bool) {
    var pos = 0;

    haystack += '';
    pos = haystack.toLowerCase()
    .indexOf((needle + '')
    .toLowerCase());
    if (pos == -1) {
        return false;
    } else {
        if (bool) {
            return haystack.substr(0, pos);
        } else {
            return haystack.slice(pos);
        }
    }
}

function initinymce(){
	tinymce.init({
		selector:'textarea',
		theme: "modern",
		language:'es',
		plugins: [
			"advlist autolink link image lists pagebreak wordcount nonbreaking contextmenu textcolor paste textcolor colorpicker textpattern"
		],
		toolbar: "cut copy paste | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | undo redo | link unlink",
		menubar: false,
		force_p_newlines : false,
		setup : function(ed) {
		  ed.on('blur', function(e) {
			  var id = ed.id;
			  var tmp = ed.getContent();
			  $("textarea#"+id).val(tmp);
		  });
	   }
	});
}
