<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	$query = mysqli_query($conn, "SELECT * FROM dbo_payloader WHERE processedflag = '0' ORDER BY id DESC LIMIT 100");
	while($rows = mysqli_fetch_assoc($query)) 
	{
		//echo $rows["id"].'<br />';
		$sql = mysqli_query($conn, "INSERT INTO dbo_payloaderalgorithmtemp (id, utc, hub, sensor_id, sensor_type, value, unit, time, processedflag, processedflagall) VALUES ('".$rows["id"]."', '".$rows["utc"]."', '".$rows["hub"]."', '".$rows["sensor_id"]."', '".$rows["sensor_type"]."', '".$rows["value"]."', '".$rows["unit"]."', '".$rows["time"]."', '".$rows["processedflag"]."', '".$rows["processedflagall"]."')");
		if($sql)
		{
			echo "suc";
			$data = mysqli_query($conn, "UPDATE dbo_payloader SET processedflag = '1' WHERE id = '".$rows['id']."'");
		}
	}
	//die();
?>