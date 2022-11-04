<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	//$query = mysqli_query($conn, "SELECT * FROM dbo_payloader where ");
	$sqltime="SELECT * FROM dbo_payloader WHERE hubflag=0 and time BETWEEN now() - INTERVAL 30 DAY AND now() limit 100000";
	$query = mysqli_query($conn,$sqltime); 
	while($rows = mysqli_fetch_array($query)) 
	//while($rows = mysqli_fetch_assoc($query)) 
	{
		echo "INSERT INTO dbo_payloadercharttemphub(id, utc, hub, sensor_id, sensor_type, value, unit, time, processedflag, processedflagall) VALUES ('".$rows["id"]."', '".$rows["utc"]."', '".$rows["hub"]."', '".$rows["sensor_id"]."', '".$rows["sensor_type"]."', '".$rows["value"]."', '".$rows["unit"]."', '".$rows["time"]."', '".$rows["processedflag"]."', '".$rows["processedflagall"]."')";
		$sql = mysqli_query($conn, "INSERT INTO dbo_payloadercharttemphub(id, utc, hub, sensor_id, sensor_type, value, unit, time, processedflag, processedflagall) VALUES ('".$rows["id"]."', '".$rows["utc"]."', '".$rows["hub"]."', '".$rows["sensor_id"]."', '".$rows["sensor_type"]."', '".$rows["value"]."', '".$rows["unit"]."', '".$rows["time"]."', '".$rows["processedflag"]."', '".$rows["processedflagall"]."')");
		if($sql)
		{
			echo "suc";
			//$data = mysqli_query($conn, "UPDATE dbo_payloader SET processedflagall = '1' WHERE id = '".$rows['id']."'");
			$data = mysqli_query($conn, "UPDATE dbo_payloader SET hubflag = '1' WHERE id = '".$rows['id']."'");
		}
	}
?>