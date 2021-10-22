App.token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJpc3MiOiJodHRwOlwvXC9lbm93bG9jYWwuY29tXC8iLCJhdWQiOiJodHRwOlwvXC9lbm93bG9jYWwuY29tXC8iLCJpYXQiOjE0NjQyNjk4NDQsImV4cCI6MTc3NTMwOTg0NCwic3ViIjoidXN1YXJpbyIsImFkbWluIjpmYWxzZX0.Ynx4eXqAWwHGFO1cKLLwScI3VM5Fs2e_OODtzkvGjN_LUzYgTaR-sUSFopGWAMzmOJ0jLn_NtnxU80Q6qwnFRA";



App.connect("api/blog/getdata2",false,function(response4){
  console.log(response4);
    $.each(response4,function(index,value4){
        var divA = $('<div class="col-md-4 no-padding ultnot"> <div class="col-md-12 publicaciimg"> <a href="blog/articulo/'+value4.url+'"><img src="fileimages/publicaciones/'+value4.img+'" class=" hm-ntc-img" alt="fileimages/publicaciones/'+value4.img+'">  </a>  </div>  <a href="blog/articulo/'+value4.url+'"><div class="col-md-12  font-2">'+value4.titulo+'</div></a>  <div class="col-md-12 font-1">'+value4.promocional+'</div></div>');

        $('#bloghome').append(divA);

    })
});

var currentIndex = 0,
  items = $('.parent-footer-sld .sld-cont'),
  itemAmt = items.length;



 $('.indicator-crs').click(function(){
    var previousIndex = currentIndex;
    currentIndex =$('.indicator-crs').index(this);
    cycleItems( previousIndex);
});



function cycleItems( previousIndex) {
  //if (direction ==1)
  var previousItem = $('.parent-footer-sld .sld-cont').eq(previousIndex);
  var item = $('.parent-footer-sld .sld-cont').eq(currentIndex);
  if( previousItem.is(':animated') ) {
    previousItem.finish();
  }
  if(item.is(':animated') ) {
    item.finish();
  }


  previousItem.fadeOut( 250, function() {
    item.fadeIn(250, function () {
      //item.css('display','inline-block');
    });
    //previousItem.hide();
    //item.fadeIn(1600, function() {

    //})

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





$('.indicator-crs').click(function() {
  $( ".indicator-crs" ).removeClass( "active" );
  $(this).addClass( "active" );
  //$(this).wrap( "<div class='verticalLine'></div>" );

});



/*$(function() {

    $(".home-circle")                             // get all <h2>s
    .filter(":onScreen")              // get only <h2>s on screen
    .animate({
        left : "50px"
    }, 500, function() {
      alert("completed");
    });
})*/

/*
var bar = new ProgressBar.Circle(circle1, {
  color: '#616161',
  svgStyle: {
        display: 'block',

        // Important: make sure that your container has same
        // aspect ratio as the SVG canvas. See SVG canvas sizes above.
        background: '#c6c6c6',
        width: "90%",
       // "padding-top": "3%",
        "border-radius": "50%"
  },
  // This has to be the same size as the maximum width to
  // prevent clipping
  strokeWidth: 15,
  trailWidth: 15,
  easing: 'easeInOut',
  duration: 1400,
  text: {
    autoStyleContainer: false
  },
  from: { color: '#ffc000', width: 15 },
  to: { color: '#ffc000', width: 15 },
  // Set default step function for all animate calls
  step: function(state, circle) {
    circle.path.setAttribute('stroke', state.color);
    circle.path.setAttribute('stroke-width', state.width);

    var value = Math.round(circle.value() * 100);
    if (value === 0) {
      circle.setText('');
    } else {
      circle.setText(value+"%");
    }

  }
});
bar.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
bar.text.style.fontSize = '2.4rem';
bar.text.style.left = "51%";
bar.text.style.top = "39%";

var bar2 = new ProgressBar.Circle(circle2, {
  color: '#616161',
  svgStyle: {
        display: 'block',
        width: "90%",

        // Important: make sure that your container has same
        // aspect ratio as the SVG canvas. See SVG canvas sizes above.
        background: '#c6c6c6',
        "border-radius": "50%"
  },
  // This has to be the same size as the maximum width to
  // prevent clipping
  strokeWidth: 15,
  trailWidth: 15,
  easing: 'easeInOut',
  duration: 1400,
  text: {
    autoStyleContainer: false
  },
  from: { color: '#f46819', width: 15 },
  to: { color: '#f46819', width: 15 },
  // Set default step function for all animate calls
  step: function(state, circle) {
    circle.path.setAttribute('stroke', state.color);
    circle.path.setAttribute('stroke-width', state.width);

    var value = Math.round(circle.value() * 100);
    if (value === 0) {
      circle.setText('');
    } else {
      circle.setText(value+"%");
    }

  }
});
bar2.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
bar2.text.style.fontSize = '2.4rem';
bar2.text.style.left = "51%";
bar2.text.style.top = "39%";

var bar3 = new ProgressBar.Circle(circle3, {
  color: '#616161',
  svgStyle: {
        display: 'block',
        width: "90%",
        // Important: make sure that your container has same
        // aspect ratio as the SVG canvas. See SVG canvas sizes above.
        background: '#c6c6c6',
        "border-radius": "50%"
  },
  // This has to be the same size as the maximum width to
  // prevent clipping
  strokeWidth: 15,
  trailWidth: 15,
  easing: 'easeInOut',
  duration: 1400,
  text: {
    autoStyleContainer: false
  },
  from: { color: '#6232ff', width: 15 },
  to: { color: '#6232ff', width: 15 },
  // Set default step function for all animate calls
  step: function(state, circle) {
    circle.path.setAttribute('stroke', state.color);
    circle.path.setAttribute('stroke-width', state.width);

    var value = Math.round(circle.value() * 100);
    if (value === 0) {
      circle.setText('');
    } else {
      circle.setText(value+"%");
    }

  }
});
bar3.text.style.fontFamily = '"Raleway", Helvetica, sans-serif';
bar3.text.style.fontSize = '2.4rem';
bar3.text.style.left = "51%";
bar3.text.style.top = "39%";
//bar.animate(1.0);
  // Number from 0.0 to 1.0


var waypoint = new Waypoint({
  element: document.getElementById("home-resultadosContainer"),
  handler: function(direction) {
//    $('.home-circle').css({'border-color': 'red', 'transition-property': 'border-color',
 // 'transition-duration': '10s'});
  bar.animate(0.7);
  bar2.animate(0.5);
  bar3.animate(0.9);
  //console.log(waypoint);
  }, offset: '70%'
});

var waypointOffset4 = new Waypoint({
  element: document.getElementById("home-resultadosContainer"),
  handler: function(direction) {
//    $('.home-circle').css({'border-color': 'red', 'transition-property': 'border-color',
 // 'transition-duration': '10s'});
  bar.animate(0.7);
  bar2.animate(0.5);
  bar3.animate(0.9);
  console.log("cero");
  }, offset: '20%'
});

/*

var waypointOffset1 = new Waypoint({
  element: document.getElementById("home-resultadosContainer"),
  handler: function(direction) {
//    $('.home-circle').css({'border-color': 'red', 'transition-property': 'border-color',
 // 'transition-duration': '10s'});
  bar.set(0.0);
  bar2.set(0.0);
  bar3.set(0.0);
  console.log("unoo");
  }, offset: '100%'
});

var waypointOffset2 = new Waypoint({
  element: document.getElementById("home-resultadosContainer"),
  handler: function(direction) {
//    $('.home-circle').css({'border-color': 'red', 'transition-property': 'border-color',
 // 'transition-duration': '10s'});
  bar.set(0.0);
  bar2.set(0.0);
  bar3.set(0.0);
  console.log("doss");
  }, offset: '-2%'
});*/

App.connect("api/home/getdata",false,function(response){
  console.log(response);
var num1 = response[0].numvolunt_home;
var num2 = response[0].horasmen_home;
var num3 = response[0].numcomisi_home;
var num4 = response[0].niniosbenefi_home;
var bandera=1;
var bandera2=1;
var bandera3=1;
var bandera4=1;
var bandera5=1;
var bandera6=1;
var bandera7=1;
var bandera8=1;
$(document).on("scroll", function(){

  var desplazamientoActual = $(document).scrollTop();

  if(desplazamientoActual > 2300 && (bandera==1) ) {

bandera=2;
  var num=10000;

    bandera=0;
      var count=0;
        var count2=0;

       var counter=setInterval(timer, 3);

        function timer(){

          count=count+1;

          if (count > num){

           clearInterval(counter);
           return;
          }
          if (count <= num1) {
          document.getElementById("g1").innerHTML=count+""; // watch for spellin+g
          }

          if (count <= num3) {
          document.getElementById("g3").innerHTML=count+""; // watch for spellin+g
          }


        }

        var counter2=setInterval(timer2, 7);

         function timer2(){

           count2=count2+10;

           if (count2 > num){

            clearInterval(counter);
            return;
           }

           if (count2 <= num2) {
           document.getElementById("g2").innerHTML=count2+""; // watch for spellin+g
           }

           if (count2 <= num4) {
           document.getElementById("g4").innerHTML=count2+""; // watch for spellin+g
           }

         }

  }


});

});

$(document).ready(function() {
  $(".frame").css("height", $(".tablet").height()-37);
});
