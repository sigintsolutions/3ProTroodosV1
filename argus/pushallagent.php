<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 
	$query = mysqli_query($conn, "SELECT * FROM dbo_payloader WHERE processedflagall = '0' ORDER BY id DESC LIMIT 100");
	while($rows = mysqli_fetch_assoc($query)) 
	{



$queryag= mysqli_query($conn, "SELECT * FROM users");
		while($rowsag = mysqli_fetch_assoc($queryag)) 
	{

$table='dbo_payloaderalgorithmtempandor'.$rowsag['id'];
$agent=$rowsag['id'];
//$agent=249;
$hubsensagdt = mysqli_query($conn, "SELECT sensor_hubs.hub_id,sensors.sensor_id,sensors.agent,sensors.unit FROM sensor_hubs join sensors on sensors.hub_id=sensor_hubs.id where sensors.agent='".$agent."' and sensor_hubs.agent='".$agent."'");
foreach($hubsensagdt as $hsa){
//
	echo "en1----$hsa[hub_id],$hsa[sensor_id],$hsa[unit]--<br>-$rows[hub],$rows[sensor_id],$rows[unit]<br>";
//if (($hsa['sensor_id']==$rows['sensor_id'] ) && ($hsa['hub_id']==$rows['hub']) && ($hsa['unit']==$rows['unit'])){
if (($hsa['sensor_id']==$rows['sensor_id'] ) && ($hsa['hub_id']==$rows['hub']) && ($hsa['unit']==$rows['unit'])){ 
	// )
	echo "en2----";


		$sql = mysqli_query($conn, "INSERT INTO $table (id, utc, hub, sensor_id, sensor_type, value, unit, time, processedflag, processedflagall) VALUES ('".$rows["id"]."', '".$rows["utc"]."', '".$rows["hub"]."', '".$rows["sensor_id"]."', '".$rows["sensor_type"]."', '".$rows["value"]."', '".$rows["unit"]."', '".$rows["time"]."', '".$rows["processedflag"]."', '".$rows["processedflagall"]."')");




}

}
		


}



		//if($sql)
		//{
			echo "suc";
			$data = mysqli_query($conn, "UPDATE dbo_payloader SET processedflagall = '1' WHERE id = '".$rows['id']."'");
		//}
	}
?>