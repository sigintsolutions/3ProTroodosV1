<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	$data = mysqli_query($conn, "SELECT sensor_id FROM sensors JOIN algorithm_sensor ON algorithm_sensor.sensor = sensors.id JOIN dbo_payloader ON dbo_payloader.sensor_id = sensors.sensor_id WHERE dbo_payloader.processedflag = '0'");
	print_r($data);
	//$row = mysqli_fetch_assoc($data);
	// {
	//echo $row['sensor_id'];
	// 	// foreach($row as $key=>$value)
	// 	// {
	// 		$query = mysqli_query($conn, "SELECT * FROM dbo_payloader WHERE sensor_id = '".$row['sensor_id']."' and processedflag = '0' ORDER BY id ASC LIMIT 100");
	// 		while($rows = mysqli_fetch_assoc($query)) 
	// 		{
	// 			echo $rows['sensor_id'].'<br />';					
	// 			$sql = mysqli_query($conn, "INSERT INTO dbo_payloaderalgorithmtemp (id, utc, hub, sensor_id, sensor_type, value, unit, time, processedflag, processedflagall) VALUES ('".$rows["id"]."', '".$rows["utc"]."', '".$rows["hub"]."', '".$rows["sensor_id"]."', '".$rows["sensor_type"]."', '".$rows["value"]."', '".$rows["unit"]."', '".$rows["time"]."', '".$rows["processedflag"]."', '".$rows["processedflagall"]."')");
	// 		}
	// 	//}
	//}
?>