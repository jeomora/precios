 //recibe la ubicacion de la carpeta y el numero de archivos que permite subir.
 (function($){   
    $.fn.extend({
        subida_arch:function(ubicacion,num_Arch,idinput,selec,visual,idarea,idtooltip,ancho,alto){
            var ancho = ancho || -1;
            var alto = alto || -1;

            $(selec).filer({
                        limit: num_Arch,
                        maxSize: null,
                        extensions: null,
                        changeInput: '<a style="text-decoration:none;" id="'+idtooltip+'" data-toggle="tooltip" data-placement="top" title=""><div class="jFiler-input-dragDrop" id="'+visual+'"><div id="'+idarea+'"><div class="jFiler-input-inner"><div class="jFiler-input-icon"><i class="icon-jfi-cloud-up-o"></i></div><div class="jFiler-input-text"><h3>Arrastra y suelta imagen aquí</h3> <span style="display:inline-block; margin: 15px 0">o click aquí</span></div></div></div></div></a>',
                        showThumbs: true,
                        theme: "dragdropbox",
                        templates: {
                            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
                            item: '<li class="jFiler-item">\
                                        <div class="jFiler-item-container" >\
                                            <div class="jFiler-item-inner">\
                                                <div class="jFiler-item-thumb">\
                                                    <div class="jFiler-item-status"></div>\
                                                    <div class="jFiler-item-info" >\
                                                        <span class="jFiler-item-title"><b id="nombreIm" title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                                        <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                    </div>\
                                                    {{fi-image}}\
                                                </div>\
                                                <div class="jFiler-item-assets jFiler-row">\
                                                    <ul class="list-inline pull-left">\
                                                        <li>{{fi-progressBar}}</li>\
                                                    </ul>\
                                                    <ul class="list-inline pull-right">\
                                                        <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                                    </ul>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </li>',
                            itemAppend: '<li class="jFiler-item">\
                                            <div class="jFiler-item-container">\
                                                <div class="jFiler-item-inner">\
                                                    <div class="jFiler-item-thumb">\
                                                        <div class="jFiler-item-status"></div>\
                                                        <div class="jFiler-item-info">\
                                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                                            <span class="jFiler-item-others">{{fi-size2}}</span>\
                                                        </div>\
                                                        {{fi-image}}\
                                                    </div>\
                                                    <div class="jFiler-item-assets jFiler-row">\
                                                        <ul class="list-inline pull-left">\
                                                            <li><span class="jFiler-item-others">{{fi-icon}}</span></li>\
                                                        </ul>\
                                                        <ul class="list-inline pull-right">\
                                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                                        </ul>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                        </li>',
                            progressBar: '<div class="bar"></div>',
                            itemAppendToEnd: false,
                            removeConfirmation: true,
                            _selectors: {
                                list: '.jFiler-items-list',
                                item: '.jFiler-item',
                                progressBar: '.bar',
                                remove: '.jFiler-item-trash-action'
                            }
                        },
                        success:null,
                        dragDrop: {
                            dragEnter: null,
                            dragLeave: null,
                            drop: function(){
                                    $('#cabeza').remove();
                                    $('#cabeza').append("<img id='corte' class='resize-image' alt='' src='../../../fileimages>'");
                                    $(idinput).attr('value','');
                            },
                        
                        },
                        files: null,
                        addMore: false,
                        clipBoardPaste: true,
                        excludeName: null,
                        beforeRender: null,
                        afterRender: null,
                        beforeShow: null,
                        beforeSelect: null,
                        onSelect:function(file){
                                var reader = new FileReader();
                                reader.onload=function(e){
                                    var ver="#"+visual;
                                    var ver2="#"+idarea;
                                    var ver3="#"+idtooltip;
                                    $('#identif').appendTo(ver);
                                    $('.component').append("<img id='corte' class='resize-image' alt='' src='"+e.target.result+"' />");
                                    $('#ModalCrop').modal('show');
                                    if(ancho != -1 && alto != -1) resizeableImage($('.resize-image'),idinput,ver,ver2,ver3,ancho,alto);
                                    else resizeableImage($('.resize-image'),idinput,ver,ver2,ver3);
                                }
                                reader.readAsDataURL(file);
                            },
                        afterShow: null,
                        onRemove: function(itemEl, file, id, listEl, boxEl, newInputEl, inputEl){
                            var file = file.name;
                            $.post(rutilla2, {file: file});
                        },
                        onEmpty: null,
                        options: null,
                        captions: {
                            button: "Choose Files",
                            feedback: "Choose files To Upload",
                            feedback2: "files were chosen",
                            drop: "Drop file here to Upload",
                            removeConfirmation: "Are you sure you want to remove this file?",
                            errors: {
                                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                                filesType: "Only Images are allowed to be uploaded.",
                                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
                            }
                        }
                    });
                    
                

}
});
}(jQuery));