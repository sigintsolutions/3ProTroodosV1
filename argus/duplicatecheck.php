<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	//die("hai");
	$conn=mysqli_connect("localhost", "payloader", "wY#UcYxpo659$6jzsHg","mqttdata") or die(mysqli_error()); 

//$sensorslist=DB::table('algorithm_sensor')->join('sensors', 'algorithm_sensor.sensor', '=', 'sensors.id')->get();
//$result = mysqli_query($conn, "SELECT count(id) as cou FROM dbo_payloader as gp group by hub,sensor_id,time,utc having cou >1 ");
//$result = mysqli_query($conn, "SELECT count(*) as cou FROM dbo_payloader as gp group by hub,sensor_id,time having time>='2020-08-22 00:00:00'");

$result = mysqli_query($conn, "SELECT *FROM dbo_payloader where time>='2020-08-22 00:00:00'");

//echo "SELECT * FROM dbo_payloader as gp where time>='2020-08-22 00:00:00'";	
//die;
$slarr=array();
while( $row =mysqli_fetch_array($result))
{

echo $row["sensor_id"].' '.$row["hub"].' '.$row["time"];
$hub=$row['hub'];
$sensid=$row['sensor_id'];
$time=$row['time'];
$qry="select count(*) as cou from dbo_payloader as dp where hub=$hub and sensor_id=$sensid and time=$time";



/*$result1 = mysqli_query($conn,$qry);
while($nd = mysqli_fetch_array($result1))
	{
echo $nd['cou'];
echo "<br>";
}*/
echo "<br>";

}

?>