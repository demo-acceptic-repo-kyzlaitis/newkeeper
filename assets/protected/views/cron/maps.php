<div id="city_id"><?=$city_id?></div>
<div id="city_coords_1"><?=$city_coords_1?></div>
<div id="city_coords_2"><?=$city_coords_2?></div>
<div id="map<?=$city_id?>" style="width: 600px; height: 400px"></div>

<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.full&lang=ru-RU" type="text/javascript"></script>
<script>
	$(document).ready(function() {
	city_coords_1 = <?php echo $city_coords_1; ?>;
	city_coords_2 = <?php echo $city_coords_2; ?>;
	setTimeout(function(){
        ymaps.ready(init);
        var myMap,
            myPlacemark;
		
        function init(){ 
            myMap = new ymaps.Map ("map", {
                center: [city_coords_1,city_coords_2],
                zoom: 7
            }); 
            var trafficControl = new ymaps.control.TrafficControl({shown: true});
			myMap.controls.add(trafficControl, {top: 10, left: 10});	
       }
	}, 2000)
	});
	
	
setTimeout(function(){
    balls = $("ymaps").last().parent().prev().prev().children().last().children().last().html();
    balls = balls.substring(0,2);
    city_id = <?=$city_id?>;
    $("#map<?=$city_id?>").html(balls);
},4000);


setTimeout(function(){
    console.log("BEFORE");
    data = [];
    data[0] = balls;
    data[1] = city_id;
    $.ajax({
    	type: "POST",
    	url: document.location.protocol+'//'+document.location.host+'/cron/settraffic',
    	data: {"traf_val": data[0],"city": data[1]},
    	success: function(server_response)
    	{
    		console.log("success!");
    		console.log(server_response);
    	}
   	})
},6000);
</script>