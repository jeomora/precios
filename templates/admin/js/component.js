
//recibe la imagen que se recortara, 
//recibe el campo del input en donde se guardara el valor de la imagene recortada para el post
//recibe el id de como se llama la ventana a visualizarse el background en la vista
//recibe el id de la ventana donde se ocultaran los comentarios dentro de la ventana que a su vez estan dentro de un campo para que unicamente la imagen que esta en esa area
var resizeableImage = function(image_target,campo,ver,idarea,idtooltip,ancho,alto) {
  // Some variable and settings

          var ancho = ancho || -1;
            var alto = alto || -1;

            if (ancho != -1 && alto != -1 ) {
              $('.overlay').css("width", ancho);
              $('.overlay').css("height", alto);
            }
     
  var $container,
      nombreimagen=image_target.attr("src"),
      orig_src = new Image(),
      image_target = $(image_target).get(0),
      event_state = {},
      constrain = false,
      min_width = 60, // Change as required
      min_height = 60,
      max_width = 1200, // Change as required
      max_height = 900,
      inputs=[],
      resize_canvas = document.createElement('canvas');

  inicio= function(){

    // When resizing, we will always use this copy of the original as the base
    orig_src.src=image_target.src;
  
    // Wrap the image with the container and add resize handles
    $(image_target).wrap('<div id="cabeza" class="resize-container"></div>')
    .before('<span class="resize-handle resize-handle-nw"></span>')
    .before('<span class="resize-handle resize-handle-ne"></span>')
    .after('<span class="resize-handle resize-handle-se"></span>')
    .after('<span class="resize-handle resize-handle-sw"></span>');

    // Assign the container to a variable
    $container =  $(image_target).parent('.resize-container');

    setTimeout(function(){
      $('.overlay').css('top',240+'px');
      $('.component').css('height',parseInt(alto)+120+'px');
      if (ancho < 250 ){
         $('.overlay').css('left',parseInt(ancho)*2.74+'px');
      }
      else if (ancho < 400 ){
        $('.overlay').css('left',parseInt(ancho)*1.54+'px');
      }
      else if (ancho < 500 ){
        $('.overlay').css('left',parseInt(ancho)+'px');
      }
      else if (ancho < 600){
        $('.overlay').css('left',parseInt(ancho)/1.34+'px');
      }
      else if (ancho < 700 ){
        $('.overlay').css('left',parseInt(ancho)/2+'px');
      }
      else if (ancho < 800 ){
        $('.overlay').css('left',parseInt(ancho)/3+'px');
      }
      else if (ancho < 900 ){
        $('.overlay').css('left',parseInt(ancho)/3.5+'px');
      }
      else{
       $('.overlay').css('left',parseInt(ancho)/5+'px'); 
      }

  },150);
    // Add events
    $container.on('mousedown touchstart', '.resize-handle', startResize);
    $container.on('mousedown touchstart', 'img', startMoving);
    $('.js-crop').on('click', crop);

  };

  startResize = function(e){
    e.preventDefault();
    e.stopPropagation();
    saveEventState(e);
    $(document).on('mousemove touchmove', resizing);
    $(document).on('mouseup touchend', endResize);
  };

  endResize = function(e){
    e.preventDefault();
    $(document).off('mouseup touchend', endResize);
    $(document).off('mousemove touchmove', resizing);
  };

  saveEventState = function(e){
    // Save the initial event details and container state
    event_state.container_width = $container.width();
    event_state.container_height = $container.height();
    event_state.container_left = $container.offset().left; 
    event_state.container_top = $container.offset().top;
    event_state.mouse_x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft(); 
    event_state.mouse_y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();
	
	// This is a fix for mobile safari
	// For some reason it does not allow a direct copy of the touches property
	if(typeof e.originalEvent.touches !== 'undefined'){
		event_state.touches = [];
		$.each(e.originalEvent.touches, function(i, ob){
		  event_state.touches[i] = {};
		  event_state.touches[i].clientX = 0+ob.clientX;
		  event_state.touches[i].clientY = 0+ob.clientY;
		});
	}
    event_state.evnt = e;
  };

  resizing = function(e){
    var mouse={},width,height,left,top,offset=$container.offset();
    mouse.x = (e.clientX || e.pageX || e.originalEvent.touches[0].clientX) + $(window).scrollLeft(); 
    mouse.y = (e.clientY || e.pageY || e.originalEvent.touches[0].clientY) + $(window).scrollTop();
    
    // Position image differently depending on the corner dragged and constraints
    if( $(event_state.evnt.target).hasClass('resize-handle-se') ){
      width = mouse.x - event_state.container_left;
      height = mouse.y  - event_state.container_top;
      left = event_state.container_left;
      top = event_state.container_top;
    } else if($(event_state.evnt.target).hasClass('resize-handle-sw') ){
      width = event_state.container_width - (mouse.x - event_state.container_left);
      height = mouse.y  - event_state.container_top;
      left = mouse.x;
      top = event_state.container_top;
    } else if($(event_state.evnt.target).hasClass('resize-handle-nw') ){
      width = event_state.container_width - (mouse.x - event_state.container_left);
      height = event_state.container_height - (mouse.y - event_state.container_top);
      left = mouse.x;
      top = mouse.y;
      if(constrain || e.shiftKey){
        top = mouse.y - ((width / orig_src.width * orig_src.height) - height);
      }
    } else if($(event_state.evnt.target).hasClass('resize-handle-ne') ){
      width = mouse.x - event_state.container_left;
      height = event_state.container_height - (mouse.y - event_state.container_top);
      left = event_state.container_left;
      top = mouse.y;
      if(constrain || e.shiftKey){
        top = mouse.y - ((width / orig_src.width * orig_src.height) - height);
      }
    }
	
    // Optionally maintain aspect ratio
    if(constrain || e.shiftKey){
      height = width / orig_src.width * orig_src.height;
    }

    if(width > min_width && height > min_height && width < max_width && height < max_height){
      // To improve performance you might limit how often resizeImage() is called
      resizeImage(width, height);  
      // Without this Firefox will not re-calculate the the image dimensions until drag end
      $container.offset({'left': left, 'top': top});
    }
  }

  resizeImage = function(width, height){
    resize_canvas.width = width;
    resize_canvas.height = height;
    resize_canvas.getContext('2d').drawImage(orig_src, 0, 0, width, height);   
    $(image_target).attr('src', resize_canvas.toDataURL("image/png"));  
  };

  startMoving = function(e){

    e.preventDefault();
    e.stopPropagation();
    saveEventState(e);
    $(document).on('mousemove touchmove', moving);
    $(document).on('mouseup touchend', endMoving);
  };

  endMoving = function(e){
    e.preventDefault();
    $(document).off('mouseup touchend', endMoving);
    $(document).off('mousemove touchmove', moving);
  };

  moving = function(e){ 
    var  mouse={}, touches;
    e.preventDefault();
    e.stopPropagation();
    
    touches = e.originalEvent.touches;
    
    mouse.x = (e.clientX || e.pageX || touches[0].clientX) + $(window).scrollLeft(); 
    mouse.y = (e.clientY || e.pageY || touches[0].clientY) + $(window).scrollTop();
    $container.offset({
      'left': mouse.x - ( event_state.mouse_x - event_state.container_left ),
      'top': mouse.y - ( event_state.mouse_y - event_state.container_top ) 
    });
    // Watch for pinch zoom gesture while moving
    if(event_state.touches && event_state.touches.length > 1 && touches.length > 1){
      var width = event_state.container_width, height = event_state.container_height;
      var a = event_state.touches[0].clientX - event_state.touches[1].clientX;
      a = a * a; 
      var b = event_state.touches[0].clientY - event_state.touches[1].clientY;
      b = b * b; 
      var dist1 = Math.sqrt( a + b );
      
      a = e.originalEvent.touches[0].clientX - touches[1].clientX;
      a = a * a; 
      b = e.originalEvent.touches[0].clientY - touches[1].clientY;
      b = b * b; 
      var dist2 = Math.sqrt( a + b );

      var ratio = dist2 /dist1;

      width = width * ratio;
      height = height * ratio;
      // To improve performance you might limit how often resizeImage() is called
      resizeImage(width, height);
    }
  };

  crop = function(){
    //Find the part of the image that is inside the crop box
    //encontrando la ruta a guardar la imagen $dest
    
    var crop_canvas,
        left = $('.overlay').offset().left - $container.offset().left,
        top =  $('.overlay').offset().top - $container.offset().top,
        width = $('.overlay').width(),
        height = $('.overlay').height();
        
    crop_canvas = document.createElement('canvas');
    crop_canvas.width = width;
    crop_canvas.height = height;
    
    crop_canvas.getContext('2d').drawImage(image_target, left, top, width, height, 0, 0, width, height);
    var myImage = crop_canvas.toDataURL("image/png"); 
    
      $('.close').css('display','none');
      var a = inputs.indexOf(campo);
      if(a===-1){
      $(ver).css('background-image','url('+myImage+')');
      $(ver).css("background-size","300px 200px");
      $(idarea).css('display','none');
      $(idtooltip).attr('title','Arrastra o da click en el area para sustituir la imagen');
      $(idtooltip).tooltip();
      $(campo).attr('value',myImage);
      inputs.push(campo);
        BootstrapDialog.show({
      title: "<li class='fa fa-check peligro'></li>",
      message:'imagen ha sido cortada',
      buttons: [{
            label: 'OK',
            cssClass: 'btn btn-primary btn-agregar ',
            action: function(dialogRef) {
                dialogRef.close();
              }
            }]
    });
      } 
  }

  inicio();
};


// Kick everything off with the target image

