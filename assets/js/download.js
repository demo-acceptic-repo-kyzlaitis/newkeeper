$(document).ready(function(){
	$(".download").click(function(){
		var id = $(this).parents('.image_news').data("id");
		$.ajax({
			type: "POST",
			url: "news/downloadstat",
			data: { id : id},
			success: function(server_response)
			{
                $('#news'+id+' .bookmark').siblings(".news_stat").find(".dl_stat").html(server_response);
			}
			});
        /*$.post('/news/imgpath',{ 'id' : dataString },function(data){
		    var str = data;
        });*/
		//window.open('/news/sendfile?id='+dataString)
	});
});