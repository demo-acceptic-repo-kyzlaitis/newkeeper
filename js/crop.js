$(document).ready(function() {
 
$("#faq_search_input").keyup(function()
{

var faq_search_input = $(this).val();
var dataString = 'keyword='+ faq_search_input;
 
var ref_id = $('#ref_id').val(); 
var cust_id = $('#cust_id').val(); 
var current_url = $('.current_url').attr("id"); 
/*This is the minimum size of search string. Search will be only done when at-least 3 characters are provided in input*/
if(faq_search_input.length>3)
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
//$('#content').append(server_response).show();
$(server_response).insertAfter('#mainmenu');

$('#content > #main_section').hide();
$('#content > #main_section.search').show();
$('#searchresultdata').show();
$('#blog_tabscontainer').css('display','none');
$('#yw0').css('display','none');
$('.dop_text').css('display','none');
$('#content > #content').css('display','none');

$('span#faq_category_title').html(faq_search_input);
 
if ($('input#faq_search_input').hasClass("loading")) {
 $("input#faq_search_input").removeClass("loading");
        } 
 
}
});
}else{

$('#content > #main_section').show();
$('#content > #main_section.search').remove();
$('#searchresultdata').css('display','none');
$('#blog_tabscontainer').css('display','');
$('#yw0').css('display','');
$('.dop_text').css('display','');
$('#content > #content').css('display','');


}

return false;
});
});