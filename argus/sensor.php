<?php
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	$data = mysqli_query($conn, "SELECT hub FROM dbo_payloader GROUP BY hub");
	while($row = mysqli_fetch_assoc($data)) 
	{
		foreach($row as $key=>$value)
		{
			if(!empty($value))
			{				
				$query = mysqli_query($conn, "SELECT hub, sensor_id, unit, value, sensor_type FROM dbo_payloader WHERE hub = '".$value."' GROUP BY hub, sensor_id, unit, value, sensor_type");
				while($rows = mysqli_fetch_assoc($query)) 
				{					
					$datacnt = mysqli_query($conn, "SELECT * FROM sensordata where hub = '".$rows["hub"]."' and sensor_id = '".$rows["sensor_id"]."'");
					//echo mysqli_num_rows($datacnt);
					if(mysqli_num_rows($datacnt) == '0')
					{
						$sql = mysqli_query($conn, "INSERT INTO sensordata (hub, sensor_id, sensor_type, unit, value) VALUES ('".$rows["hub"]."', '".$rows["sensor_id"]."', '".$rows["sensor_type"]."', '".$rows["unit"]."', '".$rows["value"]."')");
						//$data = mysqli_query($conn, "UPDATE sensordata SET sensor_id = '".$sval."' WHERE hub = '".$value."'");
					}
				}
			}
		}				
	}
?>