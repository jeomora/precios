var obj = $("#dropbox");

obj
.on('dragenter', function (e){
    e.stopPropagation();
    e.preventDefault();
})
.on('dragover', function (e){
     e.stopPropagation();
     e.preventDefault();
     $(this).css('border', '2px dotted #0B85A1');
})
.on('drop', function (e){
     e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;
     handleFileUpload(files,obj);
});


$("#fileselect").change(function(e){
	e.preventDefault();
    e.stopPropagation();
	e.preventDefault();
	
	files = e.target.files || e.dataTransfer.files;
    handleFileUpload(files,obj);
});

function handleFileUpload(files,obj){
   for (var i = 0; i < files.length; i++){
        var fd = new FormData();
        fd.append('doc', $('ul.recursos').data("doc"));
        fd.append('file', files[i]);
        
        var status = new createStatusbar(obj); //Using this we can set progress.
        status.setFileNameSize(files[i].name,files[i].size);
        sendFileToServer(fd,status);
   }
}

function sendFileToServer(formData,status){
    var uploadURL ="recursos/addfile";
    var extraData = {};

    var jqXHR = $.ajax({
		xhr: function() {
			var xhrobj = $.ajaxSettings.xhr();
			if (xhrobj.upload) {
				xhrobj.upload.addEventListener('progress', function(event) {
					var percent = 0;
					var position = event.loaded || event.position;
					var total = event.total;
					if (event.lengthComputable) {
						percent = Math.ceil(position / total * 100);
					}
					//Set progress
					status.setProgress(percent);
				}, false);
			}

			return xhrobj;
		},
		url: uploadURL,
		type: "POST",
		contentType:false,
		processData: false,
		cache: false,
		data: formData,
		dataType: "json",
		success: function(data){
			status.setProgress(100);

			var img = "plantillas/boot/images/";
			var attr = "data-id='"+data.id+"' ";
			var url = "recursos/down/"+data.ruta.replace("/",":::");
			
			if(data.tipo == "pdf"){
				url = "filerecursos/"+data.ruta;
				img += "pdf.png";
				attr += "class = 'modalPDF btnOpenFile' rel = 'pdfs' data-fancybox-type = 'iframe'";
			}else if(data.tipo == "word"){
				url = "recursos/word/"+data.ruta.replace("/",":::");
				img += "word.png";
				attr += "target = 'ifDownload' class='btnOpenFile'";
			}else if(data.tipo == "excel"){
				url = "recursos/excel/"+data.ruta.replace("/",":::");
				img += "excel.png";
				attr += "target = 'ifDownload' class='btnOpenFile'";
			}else if(data.tipo == "power point"){
				url = "recursos/power/"+data.ruta.replace("/",":::");
				img += "powerpoint.png";
				attr += "target = 'ifDownload' class='btnOpenFile'";
			}else if(data.tipo == "video"){
				url = "recursos/video/"+data.ruta.replace("/",":::");
				img += "video.png";
				attr += "class = 'modalIFRAME btnOpenFile' rel = 'videos'";
			}else if(data.tipo == "audio"){
				url = "filerecursos/"+data.ruta;
				img += "audio.png";
				attr += "class = 'modalAudio btnOpenFile' rel = 'audios'";
			}else if(data.tipo == "imagen"){
				url = "filerecursos/"+data.ruta;
				img = "filerecursos/"+data.ruta;
				attr += "class = 'modal btnOpenFile' rel = 'galeria'";
			}else{
				img += "desconocido.png";
				attr += "target = 'ifDownload' class='btnOpenFile'";
			}
			
			var Li = "<li data-tipo='file' title='"+data.nombre+"'>";
			Li += "<div class='span6 filename-col'>";	
			Li += "<img src='"+img+"' style = 'width:32px; height:32px; float:left; margin-right:15px;' />";
			Li += "<a href='"+url+"' "+attr+">"+data.nombre+"</a>";
			Li += "</div>";
			Li += "<div class='span3 filename-col'>"+data.tipo+"</div>";
			Li += "<div class='span3 filename-col'>"+data.fecha+"</div>";
			Li += "</li>";
			
			$("#dropbox ul.recursos").append(Li);
			status.statusbar.remove();
		}
	});
 
	status.setAbort(jqXHR);
}

var rowCount=0;
function createStatusbar(obj){
     rowCount++;
     var row="odd";
     if(rowCount %2 ==0) row ="even";
     this.statusbar = $("<div class='statusbar "+row+"'></div>");
     this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
     this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
     this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
     this.abort = $("<div class='abort'>Cancelar</div>").appendTo(this.statusbar);
     obj.after(this.statusbar);

    this.setFileNameSize = function(name,size){
        var sizeStr="";
        var sizeKB = size/1024;
        if(parseInt(sizeKB) > 1024){
            var sizeMB = sizeKB/1024;
            sizeStr = sizeMB.toFixed(2)+" MB";
        }else{
            sizeStr = sizeKB.toFixed(2)+" KB";
        }
 
        this.filename.html(name);
        this.size.html(sizeStr);
    }
    
    this.setProgress = function(progress){
        var progressBarWidth =progress*this.progressBar.width()/ 100; 
        this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
        if(parseInt(progress) >= 100){
            this.abort.hide();
        }
    }
    
    this.setAbort = function(jqxhr){
        var sb = this.statusbar;
        this.abort.click(function(){
            jqxhr.abort();
            sb.hide();
        });
    }
}
