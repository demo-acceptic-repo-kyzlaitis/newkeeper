// GLOBAL

function loading(name,overlay)
{ 
	if(!name)
	{
		name = $('#dictionary').data('loading');
	}
	
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


// POPUP

function tw_ok()
{
	sendRequest('/user/login/twittercomplete', {'email' : $('#email').val()});
}

function tw_cancel()
{
	sendRequest('/user/login/twittercancel');
    $.magnificPopup.close();
}

function sendRequest(url, params)
{
	$.post('/'+window.lang+url, params, function(data){
		parseResp(data);
	},'json');
}

function parseResp(resp)
{
	if(resp.error == 1) {
        $('.error_msg').text(resp['msg']).show();
    }else{
        //window.location.reload();
        $.magnificPopup.close();
    }
}

function preventCloseWhileDragSelected()
{
    $('.jcrop-tracker').mousedown('click', function(){
    	$('.mfp-wrap, .mfp-content, .mfp-container').addClass('mfp-prevent-close');
    });
    $( "body *" ).mouseup(function() {
	    setTimeout(function(){
	    	$('.mfp-wrap, .mfp-content, .mfp-container').removeClass('mfp-prevent-close');
	    },100);
	});
}