(function($){
 $.fn.extend({
 
 	customSelect : function(options) {
	  if(!$.browser.msie || ($.browser.msie&&$.browser.version>6)){
	  return this.each(function() {
	  
			var currentSelected = $(this).find(':selected');
			var html = currentSelected.html();
			if(!html){ html='&nbsp;'; }
			$(this).after('<span class="customStyleSelectBox"><span class="customStyleSelectBoxInner">'+html+'</span></span>').css({position:'absolute', opacity:0,fontSize:$(this).next().css('font-size')});
			
			var selectBoxWidth = parseInt($(this).parent().width()) - 10;
			var selectBoxSpan = $(this).next();
			var selectBoxSpanInner = selectBoxSpan.find(':first-child');
			
			selectBoxSpan.css({width:selectBoxWidth, display:'inline-block', padding:"2px 5px"});
			selectBoxSpanInner.css({width:selectBoxWidth, display:'inline-block'});
			var selectBoxHeight = parseInt(selectBoxSpan.height()) + parseInt(selectBoxSpan.css('padding-top')) + parseInt(selectBoxSpan.css('padding-bottom'));
			
			
			$(this).width(selectBoxWidth+10);
			$(this).height(selectBoxHeight).change(function(){
				selectBoxSpanInner.text($(this).find(':selected').text()).parent().addClass('changed');
			});
			
	  });
	  }
	}
 });
})(jQuery);
