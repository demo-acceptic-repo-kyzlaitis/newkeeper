$(document).ready(function() {
//$("#faq_search_input").val("\u00A0");
//$("#faq_search_input").on('click', function(){ $(this).val(""); });
//$("#faq_search_input").focusout(function(){ $(this).val("\u00A0"); });
var chk_rules = false;
/*$("#chk_rules").on('click', function(){ 
	if(!chk_rules){
		chk_rules = true;
		$(this).addClass("active");									
	}else{
		chk_rules = false;
		$(this).removeClass("active");
	}
});*/

$('#faq_search_input').bind('keypress', function(e) {
    var code = e.keyCode || e.which;
    if(code == 13) { //Enter keycode
        return false;
    }
});

$("#faq_search_input").keyup(function()
{

var faq_search_input = $(this).val();
var dataString = 'keyword='+ faq_search_input;
 
var ref_id = $('#ref_id').val(); 
var cust_id = $('#cust_id').val(); 
var current_url = $('.current_url').attr("id"); 
var was_search = false;
/*This is the minimum size of search string. Search will be only done when at-least 3 characters are provided in input*/
if(faq_search_input.length > 1)
{
	$.ajax({
	type: "POST",
	url: current_url+"/SearchEngine",
	data: dataString,
	/*Uncomment this if you want to send the additional data*/
	//data: dataString+"&refid="+ref_id+"&custid="+cust_id,
	beforeSend:  function() {
	$('input#faq_search_input').addClass('loading');
	},
	success: function(server_response)
	{
		
		if ((server_response.substring(0,2) == "{" + '"')){
			was_search = true;
			json = JSON.parse(server_response);
			if (json[0] !== undefined){
				server_response = json[0];
				$("#searchresultdata").attr("style","margin-left: 35%; margin-top: 20%; width: 52%");
			}
				
			if (json[1] !== undefined){
				server_response = json[1];
				$("#searchresultdata").attr("style","margin-left: 35%; margin-top: 20%; width: 52%");
			}
				
			if (json[2] !== undefined){
				server_response = json[2];			
				$("#searchresultdata").attr("style","margin-left: 35%; margin-top: 20%; width: 52%");
			}
		}else
			$("#searchresultdata").attr("style","margin-left: none; margin-top: none; width: none");
				
			
		

		//$('#content > #main_section').hide();
		//$('#content > #main_section.search').show();
        $('#main_section').addClass('while_search');
		$('#searchresultdata').show();
		$('#blog_tabscontainer').css('display','none');
		$('#yw0').css('display','none');
		$('.dop_text').css('display','none');

		$('span#faq_category_title').html(faq_search_input);
		 
		if ($('input#faq_search_input').hasClass("loading")) {
			$("input#faq_search_input").removeClass("loading");
		} 
		$('#searchresultdata').html(server_response);
        initAfterNewsLoad();
	}
	});
}else{
    $('#main_section').removeClass('while_search');
	$('#searchresultdata').html('');
	$('#content > #main_section').show();
	$('#content > #main_section > .items').show();
	$('#blog_tabscontainer').css('display','');
	$('#yw0').css('display','');
	$('.dop_text').css('display','');
}

return false;
});
});