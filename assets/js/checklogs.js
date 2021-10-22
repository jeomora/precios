jQuery(document).ready(function() {
    setInterval(function(){
    	amILogin().done(function (resp){
    		if(resp === "NotSessioned"){
    			location.href = site_url;
    		}
    	})
    },10000);
});


function amILogin(){
    return $.ajax({
        url: site_url+"Inicio/amILogin",
        type: "POST",
        dataType: "JSON",
    });
}