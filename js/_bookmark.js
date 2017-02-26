$(document).ready(function(){
$(".bookmark").click(function(){
	dataString = $(this).attr("id");
	$.ajax({
		type: "POST",
		url: "/news/bookmarkstat",
		data: { str : dataString},
		
		success: function(server_response)
		{
			//alert(server_response);
		}
		});
	
});
});    