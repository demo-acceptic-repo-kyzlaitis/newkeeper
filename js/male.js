$(document).ready(function(){
	$(".recommendations_radioblock").children().click(function(){
		dataString = $(this).attr('id');
		$.ajax({
			type: "POST",
			url: "/user/profile/male",
			data: { male : dataString},
			success: function(server_response){
				
			}
		});
	});
});