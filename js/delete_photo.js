$(document).ready(function(){
$("#delete_photo").click(function(){
		if (confirm($('span',this).text()))
		$.ajax({
			type: "POST",
			url: "/cropper/delete",
			success: function(server_response)
			{
			   document.location.href = ''; 
			}
			});
	});
	
});