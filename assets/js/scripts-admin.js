function loading(name,overlay)
{ 
	$('body').append('<div id="overlay"></div><div id="preloader">'+name+'..</div>');
		if(overlay==1){
		  	$('#overlay').css('opacity',0.4).fadeIn(400,function(){  $('#preloader').fadeIn(400);	});
		    return  false;
  		}
	$('#preloader').fadeIn();	  
}        
function unloading()
{
    $('#preloader').fadeOut(400, function()
    {
        $('#overlay').remove();

        if ($.fancybox) {
            $.fancybox.close();
        }
    }).remove();
}

$(document).ready(function(){
    $('.calendar').datetimepicker({
    	timeFormat: "HH:mm:ss",
    	dateFormat: "yy-mm-dd"
    });
});