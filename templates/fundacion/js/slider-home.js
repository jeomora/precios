var currentIndex = 0,
  items = $('.parent-footer-sld .sld-cont'),
  itemAmt = items.length;

function cycleItems( previousIndex) {
  var previousItem = $('.parent-footer-sld .sld-cont').eq(previousIndex);
  var item = $('.parent-footer-sld .sld-cont').eq(currentIndex);
  previousItem.fadeOut( 1600, function() {
    //item.fadeIn();
    //item.fadeIn(1600, function() {

    //})
    item.css('display','inline-block');
    // Animation complete.
  });
  //items.hide();
  //item.css('display','inline-block');
}



$('#cursor-slider-home-right').click(function() {
  var previousIndex = currentIndex;
  //clearInterval(autoSlide);
  currentIndex += 1;
  if (currentIndex > itemAmt - 1) {
    currentIndex = 0;
    previousIndex = itemAmt - 1;
  }
  cycleItems(previousIndex);
});

$('#cursor-slider-home-left').click(function() {
  var previousIndex = currentIndex;
  //clearInterval(autoSlide);
  currentIndex -= 1;
  if (currentIndex < 0) {
    currentIndex = itemAmt - 1;
    previousIndex = 0;
  }
  cycleItems(previousIndex);
});