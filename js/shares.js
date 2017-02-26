$(document).ready(function(){
    $(".social_news a").click(function(){
		id = $(this).parents('.image_news').data("id");
        soc = $(this).data("soc");
		$.ajax({
			type: "POST",
			url: "/news/sharestat",
			data: { id : id, soc : soc },
			success: function(server_response)
			{
                
			}
			});
	});
});