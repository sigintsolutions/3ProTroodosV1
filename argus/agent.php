<?php
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	$data = mysqli_query($conn, "SELECT * FROM sensor_hubs");
	while($row = mysqli_fetch_assoc($data)) 
	{
		$s[] = $row['agent'];
		echo $sval = implode(',', $s);
		// $query = mysqli_query($conn, "SELECT * FROM sensor_hubs WHERE hub_id = '".$row['hub_id']."'");
		// while($fetch = mysqli_fetch_assoc($query))
		// {
		// 	//print_r($fetch);
		// 	$s[] = $fetch['agent'];			
		// }
		// foreach($s as $ss)
		// {
		// 	echo $ss.'<br />';
		// }
		
		// while($rows = mysqli_fetch_assoc($query)) 
		// {					
		// 	$s[] = $rows['agent'].'<br />';
		// }
				
				// if(mysqli_num_rows($datacnt) == '0')
				// {
				// 	$sql = mysqli_query($conn, "INSERT INTO sensordata (hub, sensor_id, sensor_type, unit, value) VALUES ('".$rows["hub"]."', '".$rows["sensor_id"]."', '".$rows["sensor_type"]."', '".$rows["unit"]."', '".$rows["value"]."')");
				// 	//$data = mysqli_query($conn, "UPDATE sensordata SET sensor_id = '".$sval."' WHERE hub = '".$value."'");
				// }
						
	}
	//echo $sval = implode(',', $s);
	
?>