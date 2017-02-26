
<?php
header('Content-Type: text/html; charset=utf-8');
header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
header('Content-transfer-encoding: binary');
header('Content-Disposition: attachment; filename=list.html');
header('Content-Type: application/x-unknown');
// echo "<table border='1' cellpadding='5' style='text-align: center; border: 1px; cellpadding: 5px'>";
echo "<table>";
foreach ($model1 as $model){
	foreach ($model as $field => $value){
		if (($field != "password") && ($field != "activkey") && ($field != "token") && (($field != "superuser")))
			print "<td>".$field."</td>";
	}
	break;
}
foreach ($model2 as $model){
		foreach ($model as $field => $value){
			if ($field != "user_id")
				print "<td>".$field."</td>";
		}
	break;
}
	print "</tr><tr>";
print "<tr>";
foreach ($model1 as $model){
	$row = $model->attributes;
	foreach ($row as $field => $value){
		switch ($field){
			case "id": 	$id = $value;
						print "<td>".$id."</td>";
			case "password": break;
			case "activkey": break;
			case "token": break;
			case "superuser": break;
			case "sex": if ($value == 1) 
							print "<td>Male</td>";
						else
							print "<td>Female</td>";
						break;
			case "status": if ($value == 0)
							print "<td>NOT ACTIVE</td>";
						elseif ($value == -1)
							print "<td>BANNED</td>";
						else
							print "<td>ACTIVE</td>";
						break;
			default : print "<td>".$value."</td>";	
		}
		
		
	}
	foreach ($model2 as $model){
		$row = $model->attributes;
		if ($row["user_id"] == $id)
		foreach ($row as $field => $value){
			if (($field != "user_id") && ($field != "sex"))
				print "<td>".$value."</td>";
			elseif ($field == "sex"){
				if ($value == 1)
					print "<td>Male</td>";
				else 
					print "<td>Female</td>";
			}
		}
	}
	echo "</tr>";
}
echo "</table>";

die();
?>
