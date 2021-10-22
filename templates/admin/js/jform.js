(function( $ ){
	var JForm = function (el, options, data) {
		this.$el = $(el);
        this.$el_ = this.$el.clone();
        this.timeoutId_ = 0;
        this.$files = [];
        this.$input = [];
        this.$token = false;

        this.init(options);
    };

    JForm.DEFAULTS = {
		before: function(element){ return false; },
        after: function(element){ return false; },
		spin: true,
        btnSpin: true
	};

	JForm.prototype.init = function (options) {
        var $this = this;
        $this.$method =  $this.$el.attr("method");
        $this.$action =  $this.$el.attr("action");
        $this.after = options.after;
        $this.before = options.before;
        $this.token = App.token;

        $.each($this.$el.find("input, select, textarea"), function(index, input){
            if($(input).attr("type") == "file")
                $(input).off("change").on("change", $.proxy($this.onChangeFile, $this, $(input)));
            else if($(input).attr("type") != "submit") $this.$input.push(input);
        });

        $this.$el.off("submit").on("submit", $.proxy($this.onSubmit, $this));
    };

    JForm.prototype.onChangeFile = function(element, evt) {
        evt.preventDefault();
        evt.stopPropagation();
    	evt.preventDefault();
        var name = element.attr("name");
        var previous = element.parent().find(".prevLoad");
        var $this = this;

        files = evt.target.files || evt.dataTransfer.files;

        if(files.length > 1) name += "[]";

        if(previous.length == 0){
            previous = $("<div class='prevLoad' />");
            element.after(previous);
        }

        $.each(files, function(index, file){
            var divPrev = $("<div class='imgPrev'></div>");
            divPrev.append("<canvas id='canva_"+index+"' width='72' height='60'>El navegador no es compartible, para carga asimetrica</canvas>");
            previous.append(divPrev);

            var upload = document.getElementById('canva_'+index);
            var context = upload.getContext('2d');

            var reader = new FileReader();
            reader.onerror = $this.errorHandler;
            reader.onprogress = function(evt){
                if (evt.lengthComputable) {
                    var percentLoaded = Math.round((evt.loaded / evt.total) * 100);

                    if (percentLoaded < 100) {
                        $this.nube(context, percentLoaded);
                    }
                }
            };
            reader.onabort = function(e) {
                alert('File read cancelled');
            };
            reader.onloadstart = function(e) {
                $this.nube(context, 0);
            };
            reader.onload = function(e) {
                var img = $("<img />");
                img.attr('src', e.target.result);
                divPrev.html(img);
            }

            reader.readAsDataURL(file);
            $this.$files.push({n: name, f: file});
        });
    };

    JForm.prototype.errorHandler = function(evt) {
        switch(evt.target.error.code) {
          case evt.target.error.NOT_FOUND_ERR:
            alert('Archivo no valido');
            break;
          case evt.target.error.NOT_READABLE_ERR:
            alert('El archivo no es legible');
            break;
          case evt.target.error.ABORT_ERR:
            break; // noop
          default:
            alert('Ha ocurrido un error al leer el archivo.');
        }
    };

    JForm.prototype.nube = function(ctx, porciento) {
        var gr = ctx.createLinearGradient(0, 6, 0, (100 - porciento) + 7);
        gr.addColorStop(0,"#DBDDDC");
        gr.addColorStop(.5,"#DBDDDC");
        gr.addColorStop(1,"#F0AE71");

        ctx.fillStyle = gr;
        ctx.beginPath();
        ctx.moveTo(58.32,26.7310);
        ctx.bezierCurveTo(59.228894118,25.350776471,59.700282353,23.734588235,59.700282353,22.085364706);
        ctx.bezierCurveTo(59.7002823529,17.3384470588,55.8287957647,13.4669647059,51.0818823529,13.4669647059);
        ctx.bezierCurveTo(49.0281882353,13.4669647059,47.0418352941,14.2072941176,45.4934117647,15.5541176471);
        ctx.bezierCurveTo(42.8336470588,9.09021176471,36.5383058824,4.84856470588,29.5360941176,4.84856470588);
        ctx.bezierCurveTo(20.0088,4.84856470588,12.2997176471,12.5576470588,12.2997176471,22.0849411765);
        ctx.bezierCurveTo(12.2997176471,22.5563294118,12.3336,23.0272941176,12.3670588235,23.5325647059);
        ctx.bezierCurveTo(7.08141176471,25.9903058824,3.68131764706,31.3094117647,3.68131764706,37.1672470588);
        ctx.bezierCurveTo(3.68131764706,45.4824,10.4480470588,52.2491294118,18.7632,52.2491294118);
        ctx.lineTo(55.3908705882,52.2491294118);
        ctx.bezierCurveTo(62.5281924706,52.2491294118,68.3182630588,46.4590588235,68.3182630588,39.3217454118);
        ctx.bezierCurveTo(68.3186823529,33.3296512941,64.1778395294,28.1113454118,58.32,26.7310630588);
        ctx.closePath();
        ctx.fill();

        ctx.beginPath();
        ctx.moveTo(35.1803435294,15.3071152941);
        ctx.bezierCurveTo(34.9140282353,15.0648564706,34.5595341176,14.9438964706,34.1598494118,14.9438964706);
        ctx.bezierCurveTo(33.8045929412,14.9438964706,33.4052470588,15.0648564706,33.1389317647,15.3071152941);
        ctx.lineTo(17.5616047059,29.4752752941);
        ctx.bezierCurveTo(17.2952894118,29.7582818824,17.1178305882,30.0807105882,17.1178305882,30.4442258824);
        ctx.bezierCurveTo(17.1178305882,31.1710023529,17.7386823529,31.7363294118,18.5377129412,31.7363294118);
        ctx.lineTo(28.4789223529,31.7363294118);
        ctx.lineTo(28.4789223529,45.9453176471);
        ctx.bezierCurveTo(28.4789223529,46.6314352941,29.1445835294,47.2366588235,29.8987623529,47.2366588235);
        ctx.lineTo(38.4197505882,47.2366588235);
        ctx.bezierCurveTo(39.1743105882,47.2366588235,39.8403487059,46.6314352941,39.8403487059,45.9453176471);
        ctx.lineTo(39.8403487059,31.7359905882);
        ctx.lineTo(49.7812192941,31.7359905882);
        ctx.bezierCurveTo(50.5804192941,31.7359905882,51.2017369412,31.1305552941, 51.2017369412,30.4438870588);
        ctx.bezierCurveTo(51.2017369412,30.1211576471,51.0687487059,29.7579388235,50.8023487059,29.51568);
        ctx.closePath();
        ctx.fillStyle = "#F5F7F6";
        ctx.fill();
        ctx.restore();
    };

		JForm.prototype.onSubmit = function(evt) {
        var $this = this;
        var $form = new FormData();

        $.each($this.$input, function(index, input){
            if($(input).attr("type") == "checkbox"){

                if($(input).is(":checked"))
                    $form.append($(input).attr("name"), $(input).val());
            }else
                $form.append($(input).attr("name"), $(input).val());
        });

        $.each($this.$files, function(index, file){
            $form.append(file.n, file.f);
        });
        $.ajax({
            url: $this.$action,
            type: $this.$method,
            contentType:false,
            processData: false,
            cache: false,
            data: $form,
            dataType: "json",
            beforeSend : function(xhr) {
                xhr.setRequestHeader("User-Agent", "ApiErpNet");
                xhr.setRequestHeader("Authorization", "Bearer "+$this.token);
            },
            success: function(response){
                if(response.success != undefined){
                    $this.after.call($this, response);
                }else App.Alert(response);
            }
        });

        return false;
    };

    var allowedMethods = [
        'submit', 'submit',
        'validate', 'validate'
    ];

	$.fn.jform = function(option, _relatedTarget){
		var value;

		this.each(function () {
			var $this = $(this),
			data = $this.data('form'),
			options = $.extend({}, JForm.DEFAULTS, $this.data(), typeof option === 'object' && option);

			if (typeof option === 'string') {
				if ($.inArray(option, allowedMethods) < 0) {
					throw "Unknown method: " + option;
				}

				if (!data) {
					return;
				}

				value = data[option](_relatedTarget);

				if (option === 'destroy') {
					$this.removeData('form');
				}
			}

			if (!data) {
				var tmpData = [];

				if(option != undefined && option.data != undefined) tmpData = option.data;

				$this.data('form', (data = new JForm(this, options, tmpData)));
			}
		});

		return typeof value === 'undefined' ? this : value;
	};
})( jQuery );
